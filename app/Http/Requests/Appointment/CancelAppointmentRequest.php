<?php

namespace App\Http\Requests\Appointment;

use App\Booking;
use Illuminate\Foundation\Http\FormRequest;

class CancelAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Booking $booking */
        $booking = $this->route('booking');

        if (! $booking) {
            return false;
        }

        if (auth()->guard('web_user')->check()) {
            return (int) $booking->customer_id === (int) auth()->guard('web_user')->id();
        }

        if (auth()->guard('web_admin')->check()) {
            return true;
        }

        return false;
    }

    public function rules(): array
    {
        return [
            'reason' => 'nullable|string|max:500',
        ];
    }
}

