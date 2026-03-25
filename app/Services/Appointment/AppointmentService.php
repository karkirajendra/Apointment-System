<?php

namespace App\Services\Appointment;

use App\Activity;
use App\AppointmentNotification;
use App\Booking;
use Carbon\Carbon as Time;

class AppointmentService
{
    public function cancelBooking(Booking $booking, ?string $reason = null): Booking
    {
        $booking->status = 'Cancelled';
        $booking->cancelled_at = Time::now('Australia/Melbourne');
        $booking->approved_at = null;
        $booking->completed_at = null;
        $booking->save();

        $message = $reason ? "Appointment cancelled: {$reason}" : 'Appointment cancelled.';
        $this->notify($booking, 'cancelled', $message);

        return $booking;
    }

    public function rescheduleBooking(Booking $booking, string $date, string $startTime): Booking
    {
        // Reset status after changing time.
        $booking->status = 'Pending';
        $booking->cancelled_at = null;
        $booking->approved_at = null;
        $booking->completed_at = null;

        $activity = $booking->activity()->first();
        $duration = $activity?->duration;

        if (! $duration) {
            abort(422, 'Unable to calculate appointment end time (missing activity duration).');
        }

        // Store times in the same format used by existing booking creation logic.
        $booking->date = $date;
        $booking->start_time = toTime($startTime);
        $booking->end_time = Booking::calcEndTime($duration, $booking->start_time);
        $booking->save();

        $message = "Appointment rescheduled to {$booking->date} at {$booking->start_time}.";
        $this->notify($booking, 'rescheduled', $message);

        return $booking;
    }

    public function approveBooking(Booking $booking): Booking
    {
        $booking->status = 'Approved';
        $booking->approved_at = Time::now('Australia/Melbourne');
        $booking->save();

        $this->notify($booking, 'status_changed', 'Appointment approved.');

        return $booking;
    }

    public function completeBooking(Booking $booking): Booking
    {
        $booking->status = 'Completed';
        $booking->completed_at = Time::now('Australia/Melbourne');
        $booking->save();

        $this->notify($booking, 'status_changed', 'Appointment completed.');

        return $booking;
    }

    private function notify(Booking $booking, string $type, string $message): void
    {
        AppointmentNotification::create([
            'booking_id' => $booking->id,
            'type' => $type,
            'message' => $message,
        ]);
    }
}

