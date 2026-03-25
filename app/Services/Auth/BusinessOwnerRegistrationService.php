<?php

namespace App\Services\Auth;

use App\BusinessOwner;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BusinessOwnerRegistrationService
{
    public function register(array $data): BusinessOwner
    {
        // Create business owner.
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        $businessOwner = BusinessOwner::create([
            'business_name' => $data['business_name'],
            'firstname' => ucfirst($data['firstname']),
            'lastname' => ucfirst($data['lastname']),
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'role_id' => $adminRole->id,
        ]);

        // Mark selected temp password as used.
        DB::update('update temp_password set used = 1 where password= ?', [$data['temp_password']]);

        return $businessOwner;
    }
}

