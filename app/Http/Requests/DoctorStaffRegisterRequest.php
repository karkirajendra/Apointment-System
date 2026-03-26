<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStaffRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Public registration, no special auth required.
        return true;
    }

    public function rules(): array
    {
        return [
            'role'      => 'required|in:doctor,staff',
            'specialty' => 'nullable|string|max:100',
            'firstname' => "required|min:2|max:32|regex:/^[A-z\\s\\-\\']+$/",
            'lastname'  => "required|min:2|max:32|regex:/^[A-z\\s\\-\\']+$/",
            'title'     => 'required|min:2|max:64',
            'username'  => 'required|min:4|max:24|alpha_num|unique:employees,username',
            'password'  => 'required|min:6|max:72|confirmed',
            'phone'     => 'required|min:10|max:24|regex:/^[0-9\\-\\+\\.\\s\\(\\)x]+$/',
        ];
    }
}

