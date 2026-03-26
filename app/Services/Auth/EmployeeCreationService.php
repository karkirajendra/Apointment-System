<?php

namespace App\Services\Auth;

use App\Employee;
use App\Role;
use Illuminate\Support\Facades\Hash;

class EmployeeCreationService
{
    public function createStaff(array $data): Employee
    {
        $staffRole = Role::where('name', 'staff')->firstOrFail();

        $role = Role::where('name', $data['role'] ?? 'staff')->firstOrFail();

        return Employee::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'title' => $data['title'],
            'specialty' => $data['specialty'] ?? null,
            'phone' => $data['phone'],
            'role_id' => $role->id,
            'username' => $data['username'] ?? null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    }
}

