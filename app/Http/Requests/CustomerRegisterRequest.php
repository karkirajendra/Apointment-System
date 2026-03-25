<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => "required|min:2|max:32|regex:/^[A-z\\s\\-\\']+$/",
            'lastname' => "required|min:2|max:32|regex:/^[A-z\\s\\-\\']+$/",
            'username' => 'required|min:4|max:24|alpha_num|unique:customers,username|unique:business_owners,username',
            'password' => 'required|min:6|max:72|confirmed',
            'phone' => 'required|min:10|max:24|regex:/^[0-9\\-\\+\\.\\s\\(\\)x]+$/',
            'address' => 'required|min:6|max:32',
        ];
    }
}

