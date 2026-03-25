<?php

namespace App\Http\Requests\Lab;

use App\LabTest;
use Illuminate\Foundation\Http\FormRequest;

class StoreLabResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var LabTest|null $test */
        $test = $this->route('test');

        if (! $test) {
            return false;
        }

        $user = auth()->guard('web_employee')->user();

        return auth()->guard('web_employee')->check()
            && strtolower(optional($user?->role)->name) === 'doctor'
            && (int) $test->doctor_id === (int) $user?->id;
    }

    public function rules(): array
    {
        return [
            'result_value' => 'nullable|string|max:5000',
            'normal_range' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'attachment.max' => 'File size must not exceed 5 MB.',
        ];
    }
}

