<?php

namespace App\Services\Notification;

use App\AppointmentNotification;
use App\Booking;
use Carbon\Carbon as Time;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    /**
     * @return Collection<AppointmentNotification>
     */
    public function getForCustomer(int $customerId)
    {
        return AppointmentNotification::with([
                'booking',
                'booking.customer',
                'booking.employee',
                'booking.activity',
            ])
            ->whereHas('booking', function ($q) use ($customerId) {
                $q->where('customer_id', $customerId);
            })
            ->orderByRaw('CASE WHEN read_at IS NULL THEN 0 ELSE 1 END')
            ->latest()
            ->get();
    }

    public function markRead(AppointmentNotification $notification): AppointmentNotification
    {
        $notification->read_at = Time::now('Australia/Melbourne');
        $notification->save();

        return $notification;
    }

    public function getForAdmin()
    {
        return AppointmentNotification::with([
                'booking',
                'booking.customer',
                'booking.employee',
                'booking.activity',
            ])
            ->orderByRaw('CASE WHEN read_at IS NULL THEN 0 ELSE 1 END')
            ->latest()
            ->get();
    }
}

