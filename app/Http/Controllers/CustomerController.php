<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\WorkingTime;
use App\Http\Requests\CustomerRegisterRequest;
use App\Services\Auth\CustomerRegistrationService;

use Carbon\Carbon as Time;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerRegistrationService $registrationService
    ) {
        // Check if guest then stay, else redirect
        $this->middleware('guest:web_admin');
        $this->middleware('guest:web_user');
    }

	// Opens the customer registration page
	public function register()
	{
		return view('customer.register');
	}

	// Registers a new customer account
	public function create(CustomerRegisterRequest $request)
	{
        Log::info("An attempt was made to register a customer account", $request->all());

        $customer = $this->registrationService->register($request->validated());

        Log::notice("A customer account with user_id and username: " . $customer->id . ', '. $customer->username . " was created", $customer->toArray());

        // Session flash
        session()->flash('message', 'Thank you for registering! You can now Login!');

       	return redirect('/login');
	}
}
