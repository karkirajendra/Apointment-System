<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Employee;
use Carbon\Carbon as Time;

class StaffDashboardController extends Controller
{
    public function index()
    {
        /** @var Employee $employee */
        $employee = auth()->guard('web_employee')->user();

        $today = Time::now('Australia/Melbourne')->toDateString();
        $nextWeek = Time::now('Australia/Melbourne')->addDays(7)->toDateString();

        $upcomingBookings = Booking::where('employee_id', $employee->id)
            ->where('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(6)
            ->get();

        $weeklyCount = Booking::where('employee_id', $employee->id)
            ->whereBetween('date', [$today, $nextWeek])
            ->count();

        $totalFuture = Booking::where('employee_id', $employee->id)
            ->where('date', '>=', $today)
            ->count();

        return view('employee.staff_dashboard', compact('employee', 'upcomingBookings', 'weeklyCount', 'totalFuture'));
    }
}

