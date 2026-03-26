<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // protected by auth:web_admin middleware already
    }

    public function rules(): array
    {
        return [
            'role' => 'required|in:doctor,staff',
            'specialty' => 'nullable|string|max:100|regex:/^[A-Za-z\-\.\'\s]+$/',
            'firstname' => 'required|min:2|max:32|regex:/^[A-Za-z\-\.\'\s]+$/',
            'lastname' => 'required|min:2|max:32|regex:/^[A-Za-z\-\.\'\s]+$/',
            'title' => 'required|min:2|max:32|regex:/^[A-Za-z\-\.\'\s]+$/',
            'username' => 'required|min:4|max:24|alpha_num|unique:employees,username',
            'password' => 'required|min:6|max:72|confirmed',
            'phone' => 'required|min:10|max:24|regex:/^[0-9\\-\\+\\.\\s\\(\\)x]+$/',
        ];
    }
}

