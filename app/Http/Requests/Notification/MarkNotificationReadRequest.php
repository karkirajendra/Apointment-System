<?php

namespace App\Http\Requests\Notification;

use App\AppointmentNotification;
use Illuminate\Foundation\Http\FormRequest;

class MarkNotificationReadRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var AppointmentNotification|null $notification */
        $notification = $this->route('notification');

        if (! $notification) {
            return false;
        }

        if (auth()->guard('web_admin')->check()) {
            return true;
        }

        if (auth()->guard('web_user')->check()) {
            return (int) $notification->booking->customer_id === (int) auth()->guard('web_user')->id();
        }

        return false;
    }

    public function rules(): array
    {
        return [];
    }
}

