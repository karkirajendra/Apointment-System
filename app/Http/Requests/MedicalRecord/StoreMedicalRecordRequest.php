<?php

namespace App\Http\Requests\MedicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only authenticated doctors can create records
        return auth()->guard('web_employee')->check();
    }

    public function rules(): array
    {
        return [
            'patient_id'  => 'required|exists:customers,id',
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists'   => 'The selected patient does not exist.',
            'title.required'      => 'A record title is required.',
            'file.mimes'          => 'Only PDF, JPG, and PNG files are allowed.',
            'file.max'            => 'File size must not exceed 5 MB.',
        ];
    }
}
