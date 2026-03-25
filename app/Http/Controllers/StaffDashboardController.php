<?php

namespace App\Http\Controllers;

use App\Employee;

class StaffDashboardController extends Controller
{
    public function index()
    {
        /** @var Employee $employee */
        $employee = auth()->guard('web_employee')->user();

        return view('employee.staff_dashboard', compact('employee'));
    }
}

