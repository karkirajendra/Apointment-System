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
            'firstname' => 'required|min:2|max:32|regex:/^[A-Za-z\\-\\.\\\'\\s]+$/',
            'lastname' => 'required|min:2|max:32|regex:/^[A-Za-z\\-\\.\\\'\\s]+$/',
            'title' => 'required|min:2|max:32|regex:/^[A-Za-z\\-\\.\\\'\\s]+$/',
            'phone' => 'required|min:10|max:24|regex:/^[0-9\\-\\+\\.\\s\\(\\)x]+$/',
        ];
    }
}

