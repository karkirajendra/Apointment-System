<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Employee;
use App\LabTest;
use App\MedicalRecord;
use App\Prescription;
use Carbon\Carbon as Time;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        /** @var Employee $employee */
        $employee = auth()->guard('web_employee')->user();

        $today = Time::now('Australia/Melbourne')->toDateString();
        $nextWeek = Time::now('Australia/Melbourne')->addDays(7)->toDateString();

        $upcomingBookings = Booking::where('employee_id', $employee->id)
            ->where('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(6)
            ->get();

        $weeklyAppointments = Booking::where('employee_id', $employee->id)
            ->whereBetween('date', [$today, $nextWeek])
            ->count();

        $medicalRecords = MedicalRecord::where('uploaded_by_employee_id', $employee->id)->count();
        $prescriptions = Prescription::where('doctor_id', $employee->id)->count();
        $pendingLabTests = LabTest::where('doctor_id', $employee->id)
            ->where('status', 'pending')
            ->count();

        return view('employee.doctor_dashboard', compact(
            'employee',
            'upcomingBookings',
            'weeklyAppointments',
            'medicalRecords',
            'prescriptions',
            'pendingLabTests'
        ));
    }
}

