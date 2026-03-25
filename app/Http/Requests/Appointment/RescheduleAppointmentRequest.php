<?php

namespace App\Http\Requests\Appointment;

use App\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RescheduleAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Booking $booking */
        $booking = $this->route('booking');

        if (! $booking) {
            return false;
        }

        if (! auth()->guard('web_user')->check()) {
            return false;
        }

        // Only allow rescheduling for the owning customer.
        return (int) $booking->customer_id === (int) auth()->guard('web_user')->id();
    }

    protected function prepareForValidation(): void
    {
        /** @var Booking|null $booking */
        $booking = $this->route('booking');

        if (! $booking) {
            return;
        }

        // Ensure conflict validators have the required ids.
        $this->merge([
            'customer_id' => $booking->customer_id,
            'employee_id' => $booking->employee_id,
            'activity_id' => $booking->activity_id,
        ]);
    }

    public function rules(): array
    {
        return [
            'activity_id' => 'required|exists:activities,id|is_end_time_valid',
            'customer_id' => 'required|exists:customers,id|is_on_booking',
            'employee_id' => 'required|exists:employees,id|is_employee_working|is_on_booking',
            'start_time' => 'required|date_format:H:i',
            'date' => 'required|date|after:' . getDateNow(),
        ];
    }
}

