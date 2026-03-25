<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessOwnerRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_name' => "required|min:2|max:32|regex:/^[A-z0-9\\-\\.\\'\\s]+$/",
            'firstname' => "required|min:2|max:32|regex:/^[A-z\\'\\-']+$/",
            'lastname' => "required|min:2|max:32|regex:/^[A-z\\'\\-']+$/",
            'username' => 'required|min:6|max:24|alpha_num|unique:customers,username',
            'password' => 'required|min:6|max:32|confirmed',
            'phone' => 'required|min:10|max:24|regex:/^[0-9\\-\\+\\.\\s\\(\\)x]+$/',
            'address' => 'required|min:6|max:32',
            'temp_password' => 'required|exists:temp_password,password',
        ];
    }

    public function messages(): array
    {
        return [
            'business_name.regex' => 'The :attribute is invalid, do not use special characters except "." and "-".',
            'firstname.regex' => 'The :attribute is invalid, field cannot contain special characters or numbers.',
            'lastname.regex' => 'The :attribute is invalid, field cannot contain special characters or numbers.',
            'phone.regex' => 'The :attribute is invalid, field cannot contain special characters or numbers.',
        ];
    }
}

