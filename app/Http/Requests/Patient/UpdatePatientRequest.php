<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('web_admin')->check();
    }

    public function rules(): array
    {
        $patientId = $this->route('patient')?->id;

        return [
            'firstname' => "required|min:2|max:32|regex:/^[A-z\\s\\-\\']+$/",
            'lastname' => "required|min:2|max:32|regex:/^[A-z\\s\\-\\']+$/",
            'username' => [
                'required',
                'min:4',
                'max:24',
                'alpha_num',
                Rule::unique('customers', 'username')->ignore($patientId),
            ],
            'password' => 'nullable|min:6|max:72|confirmed',
            'phone' => "required|min:10|max:24|regex:/^[0-9\\-\\+\\.\\s\\(\\)x]+$/",
            'address' => 'required|min:6|max:32',
        ];
    }
}

