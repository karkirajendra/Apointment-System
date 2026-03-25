<?php

namespace App\Services\Auth;

use App\Employee;
use App\Role;

class EmployeeCreationService
{
    public function createStaff(array $data): Employee
    {
        $staffRole = Role::where('name', 'staff')->firstOrFail();

        return Employee::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'title' => $data['title'],
            'phone' => $data['phone'],
            'role_id' => $staffRole->id,
            // Admin-created employees aren't given login credentials in this project yet.
            // Public registration creates doctor/staff logins.
        ]);
    }
}

