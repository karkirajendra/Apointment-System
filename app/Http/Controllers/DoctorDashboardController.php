<?php

namespace App\Http\Controllers;

use App\Employee;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        /** @var Employee $employee */
        $employee = auth()->guard('web_employee')->user();

        return view('employee.doctor_dashboard', compact('employee'));
    }
}

