<?php

namespace App\Http\Requests\Appointment;

use App\Booking;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Booking|null $booking */
        $booking = $this->route('booking');

        return (bool) ($booking && auth()->guard('web_admin')->check());
    }

    public function rules(): array
    {
        return [
            'note' => 'nullable|string|max:500',
        ];
    }
}

