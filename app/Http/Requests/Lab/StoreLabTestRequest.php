<?php

namespace App\Http\Requests\Lab;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->guard('web_employee')->user();

        return auth()->guard('web_employee')->check() && strtolower(optional($user?->role)->name) === 'doctor';
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:customers,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'test_name' => 'required|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'test_name.required' => 'Test name is required.',
        ];
    }
}

