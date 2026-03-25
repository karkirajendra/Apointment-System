<?php

namespace App\Services\Auth;

use App\Customer;
use App\Role;
use Illuminate\Support\Facades\Hash;

class CustomerRegistrationService
{
    public function register(array $data): Customer
    {
        $patientRole = Role::where('name', 'patient')->firstOrFail();

        return Customer::create([
            'firstname' => ucfirst($data['firstname']),
            'lastname' => ucfirst($data['lastname']),
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'role_id' => $patientRole->id,
        ]);
    }
}

