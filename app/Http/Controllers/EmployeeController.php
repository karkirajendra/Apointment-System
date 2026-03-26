<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Activity;
use App\Booking;
use App\BusinessOwner;
use App\Customer;
use App\Employee;
use App\Role;
use App\WorkingTime;
use App\Http\Requests\EmployeeCreateRequest;
use App\Services\Auth\EmployeeCreationService;

use Carbon\Carbon as Time;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly EmployeeCreationService $employeeCreationService
    ) {
        // Check auth, if not auth then redirect to login
        $this->middleware('auth:web_admin', [
            'only' => [
                'store',
                'index',
                'assign',
            ]
        ]);
    }

    // Create a new employee
    public function store(EmployeeCreateRequest $request)
    {
        Log::info("An attempt was made to create a new employee", $request->all());

        // Create employee (default role is `staff` for compatibility)
        $employee = $this->employeeCreationService->createStaff($request->validated());

        Log::notice("Employee was created with name: " . $request->firstname . " " . $request->lastname, $employee->toArray());

        // Session flash
        session()->flash('message', 'New Employee Added');

        //Redirect to the business owner employee page
        return redirect('/admin/employees');
    }

    public function index()
    {
        $employees = Employee::orderBy('firstname')->orderBy('lastname')->get();
        $pendingEmployees = $employees->where('is_approved', false);

        return view('admin.employees', [
            'business' => BusinessOwner::first(),
            'employees' => $employees,
            'pendingEmployees' => $pendingEmployees,
        ]);
    }

    public function approve(Employee $employee)
    {
        $employee->is_approved = true;
        $employee->approved_at = now();
        $employee->save();

        session()->flash('message', "{$employee->firstname} {$employee->lastname} has been approved.");
        return redirect('/admin/employees');
    }

    public function revoke(Employee $employee)
    {
        $employee->is_approved = false;
        $employee->approved_at = null;
        $employee->save();

        session()->flash('message', "{$employee->firstname} {$employee->lastname} has been revoked.");
        return redirect('/admin/employees');
    }
}

