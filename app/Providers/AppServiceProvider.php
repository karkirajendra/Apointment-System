<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

use App\Activity;
use App\Booking;
use App\BusinessOwner;
use App\WorkingTime;
use App\BusinessTime;

use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		// Additional code to fix php artisan migrate error for (unique key too long on certain systems)
        Schema::defaultStringLength(191);

        // Share $business with all views using View Composer
        // Using a View Composer (lazy) so it only runs during actual web requests,
        // not during artisan commands or before DB is ready.
        // Cache the business owner in a request-scoped variable to avoid repeated DB queries
        $businessOwner = null;
        $getBusinessOwner = function () use (&$businessOwner) {
            if ($businessOwner === null) {
                $businessOwner = \App\BusinessOwner::first();
            }
            return $businessOwner;
        };
        
        View::composer(['layouts.dashboard', 'layouts.master'], function ($view) use ($getBusinessOwner) {
            if (! $view->offsetExists('business')) {
                $view->with('business', $getBusinessOwner());
            }
        });

        // Required because `app/Http/Kernel.php` uses `ThrottleRequests::class.':api'` for the `api` middleware group.
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Validator that checks if value is a day of the week
        Validator::extend('is_day_of_week', function ($attribute, $value, $parameters, $validator) {
            foreach (getDaysOfWeek() as $day) {
                if (strcasecmp($value, $day) == 0) {
                    return true;
                }
            }

            return false;
        });

        // Create a validator to check if an employee is free when adding a booking
        Validator::extend('is_on_booking', function ($attribute, $value, $parameters, $validator) {
            // Get request data
            $request = $validator->getData();

            // If request data is not provided then return false
            if (!isset($request['date']) or !isset($request['start_time']) or !isset($request['activity_id'])) {
                return false;
            }

            // Find activity or return false
            try {
                $activity = Activity::findOrFail($request['activity_id']);
            }
            catch (ModelNotFoundException $e) {
                return false;
            }

            // Set time
            $reqStartTime = toTime($request['start_time']);
            $reqEndTime = Booking::calcEndTime($activity->duration, $reqStartTime);

            // If end time could not be calculated, reject the booking
            if ($reqEndTime === null) {
                return false;
            }

            // Get bookings of the date
            $bookings = Booking::where($attribute, $value)
                ->where('date', $request['date'])
                ->get();

            // Loop through booking results
            foreach ($bookings as $booking) {
                // Booking start and end time
                $bookStartTime = $booking->start_time;
                $bookEndTime = $booking->end_time;

                // Two time ranges overlap if: reqStart < bookEnd && reqEnd > bookStart
                // This single condition catches all overlap cases (start overlap, end overlap, complete overlap, contained)
                if ($reqStartTime < $bookEndTime && $reqEndTime > $bookStartTime) {
                    return false;
                }
            }

            return true;
        });

        // Check if date is in open times of the business
        Validator::extend('is_business_open', function ($attribute, $value, $parameters, $validator) {
            // Get request data
            $request = $validator->getData();

            // If request data is not provided then return false
            if (!isset($request['start_time']) or !isset($request['end_time'])) {
                return false;
            }

            // Parameter variables
            $pStartTime = toTime($request['start_time']);
            $pEndTime = toTime($request['end_time']);

            // Get the day value from attribute
            // Convert to enum day
            // e.g. MONDAY, TUESDAY
            $day = strtoupper(parseDateTime($value)->format('l'));

            // Get business time of the date
            $btTime = BusinessTime::where('day', $day)->first();

            // If not found, then return false
            if ($btTime == null) {
                return false;
            }

            // Time alias
            $btStartTime = $btTime->start_time;
            $btEndTime = $btTime->end_time;

            // Check if booking is in between employee working time
            if ($pStartTime >= $btStartTime and $pEndTime <= $btEndTime) {
                return true;
            }

            // If anything unexpected happens, return false
            return false;
        });

        // Create a validator to check if an employee is free when adding a booking
        Validator::extend('is_employee_working', function ($attribute, $value, $parameters, $validator) {
            // Get request data
            $request = $validator->getData();

            // If request data is not provided then return false
            if (!isset($request['date']) or !isset($request['start_time']) or !isset($request['activity_id'])) {
                return false;
            }

            // Find activity or return false
            try {
                $activity = Activity::findOrFail($request['activity_id']);
            }
            catch (ModelNotFoundException $e) {
                return false;
            }

            // Set time
            $pStartTime = toTime($request['start_time']);
            $pEndTime = Booking::calcEndTime($activity->duration, $pStartTime);

            // If end time could not be calculated, reject the booking
            if ($pEndTime === null) {
                return false;
            }

            // Get working time for the employee on the given date
            $workingTime = WorkingTime::where($attribute, $value)
                ->where('date', $request['date'])
                ->first();

            // If there doesn't exist a working time, then return false
            if ($workingTime == null) {
                return false;
            }

            // Working time alias
            $wStartTime = $workingTime->start_time;
            $wEndTime = $workingTime->end_time;

            // Check if booking is in between employee working time
            if ($pStartTime >= $wStartTime and $pEndTime <= $wEndTime) {
                return true;
            }

            // If anything unexpected happens, return false
            return false;
        });

        // Check if the calculated end time of a booking is valid
        Validator::extend('is_end_time_valid', function ($attribute, $value, $parameters, $validator) {
            // Get request data
            $request = $validator->getData();

            // If request data is not provided then return false
            if (!isset($request['start_time'])) {
                return false;
            }

            // Alias
            $startTime = $request['start_time'];

            // Find activity or return false
            try {
                $activity = Activity::findOrFail($value);
            }
            catch (ModelNotFoundException $e) {
                return false;
            }

            // Calculate end time
            $endTime = Booking::calcEndTime($activity->duration, $startTime);
            
            // If end time could not be calculated, reject
            if ($endTime === null) {
                return false;
            }

            // If end time is after start time, return true (valid)
            // Otherwise return false
            return $endTime > $startTime;
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
