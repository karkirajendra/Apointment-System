<?php

namespace App\Services\Auth;

use App\Employee;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorStaffRegistrationService
{
    /**
     * Create a doctor or staff member and mark as pending approval.
     */
    public function register(array $data): Employee
    {
        $role = Role::where('name', $data['role'])->firstOrFail();

        $employee = Employee::create([
            'firstname' => ucfirst($data['firstname']),
            'lastname' => ucfirst($data['lastname']),
            'title' => $data['title'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role_id' => $role->id,
            'is_approved' => false,
        ]);

        return $employee;
    }
}

