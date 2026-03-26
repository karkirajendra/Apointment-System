<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorStaffRegisterRequest;
use App\Services\Auth\DoctorStaffRegistrationService;
use Illuminate\Http\RedirectResponse;

class DoctorStaffRegistrationController extends Controller
{
    public function __construct(
        private readonly DoctorStaffRegistrationService $registrationService,
    ) {
        // Public route, no auth middleware.
    }

    public function create()
    {
        // Simple blade view with doctor/staff selection.
        return view('employee.register');
    }

    public function store(DoctorStaffRegisterRequest $request)
    {
        $this->registrationService->register($request->validated());

        session()->flash('message', 'Account created successfully. Your account is pending approval by admin.');
        return redirect('/login');
    }
}

