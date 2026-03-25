<?php

namespace App\Http\Requests\Prescription;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only doctors can create prescriptions.
        $user = auth()->guard('web_employee')->user();
        return auth()->guard('web_employee')->check() && strtolower(optional($user?->role)->name) === 'doctor';
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:customers,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'diagnosis' => 'nullable|string|max:150',
            'medications' => 'required|string|max:5000',
            'notes' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'medications.required' => 'Medications are required.',
        ];
    }
}

