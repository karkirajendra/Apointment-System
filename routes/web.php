<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\BusinessOwnerController;
use App\Http\Controllers\BusinessTimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\WorkingTimeController;
use App\Http\Controllers\Auth\DoctorStaffRegistrationController;
use App\Http\Controllers\MedicalRecord\MedicalRecordController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Prescription\PrescriptionController;
use App\Http\Controllers\Lab\LabController;
use App\Http\Controllers\Reporting\ReportingController;
use App\Http\Controllers\Notification\AppointmentNotificationController;

Route::get('/', function () {
	return redirect('/login');
});

/**
 * Session handling
 */

Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::post('/login', [SessionController::class, 'login']);
Route::get('/logout', [SessionController::class, 'logout']);
Route::get('/register', [CustomerController::class, 'register']);
Route::post('/register', [CustomerController::class, 'create']);

// Public doctor/staff registration
Route::get('/register/doctor-staff', [DoctorStaffRegistrationController::class, 'create']);
Route::post('/register/doctor-staff', [DoctorStaffRegistrationController::class, 'store']);

/**
 * Role-based dashboards
 */
Route::get('/dashboard', function () {
    if (auth()->guard('web_admin')->check()) {
        return redirect('/admin');
    }
    if (auth()->guard('web_user')->check()) {
        return redirect('/bookings');
    }
    if (auth()->guard('web_employee')->check()) {
        $role = auth()->guard('web_employee')->user()->role?->name;
        if ($role === 'doctor') {
            return redirect('/doctor');
        }

        return redirect('/staff');
    }

    return redirect('/login');
});

Route::middleware(['auth:web_employee', 'ensure.role:doctor'])
    ->group(function () {
        Route::get('/doctor', [DoctorDashboardController::class, 'index']);
    });

Route::middleware(['auth:web_employee', 'ensure.role:staff'])
    ->group(function () {
        Route::get('/staff', [StaffDashboardController::class, 'index']);
    });


/**
 * Admin handling
 */
Route::middleware(['auth:web_admin', 'ensure.role:admin'])
    ->group(function () {
        Route::post('/admin/employees/{employee}/approve', [EmployeeController::class, 'approve']);
        Route::post('/admin/employees/{employee}/revoke', [EmployeeController::class, 'revoke']);
    });


// Admin views
Route::get('/admin', [BusinessOwnerController::class, 'index']);
Route::get('/admin/register', [BusinessOwnerController::class, 'register']);

// Business Info
Route::get('/admin/edit', [BusinessOwnerController::class, 'edit']);
Route::put('/admin/{bo}', [BusinessOwnerController::class, 'update']);

// Business Times
Route::resource('admin/times', BusinessTimeController::class)->except(['create']);

// Employees
Route::get('/admin/employees', [EmployeeController::class, 'index']);
Route::get('/admin/employees/assign', [EmployeeController::class, 'assign']);
Route::get('/admin/employees/assign/{employee_id}', [EmployeeController::class, 'assign']);
Route::post('/admin/employees/assign', [BookingController::class, 'assignEmployee']);

// Roster
Route::get('/admin/roster', function () { return redirect('/admin/roster/' . toMonthYear(getNow())); });
Route::get('/admin/roster/{month_year}', [WorkingTimeController::class, 'index']);
Route::get('/admin/roster/{month_year}/{employee_id}', [WorkingTimeController::class, 'show']);
Route::get('/admin/roster/{month_year}/{employee_id}/{working_time_id}/edit', [WorkingTimeController::class, 'edit']);
Route::put('/admin/roster/{wTime}', [WorkingTimeController::class, 'update']);
Route::post('/admin/roster', [WorkingTimeController::class, 'store']);
Route::post('/admin/roster/{month_year}', [WorkingTimeController::class, 'store']);
Route::delete('/admin/roster/{wTime}', [WorkingTimeController::class, 'destroy']);

// Booking
Route::get('/admin/summary', [BookingController::class, 'summary']);
Route::get('/admin/history', [BookingController::class, 'history']);
Route::get('/admin/bookings', function () { return redirect('/admin/bookings/' . toMonthYear(getNow())); });
Route::get('/admin/bookings/{month_year}', [BookingController::class, 'indexAdmin']);
Route::get('/admin/bookings/{month_year}/{employee_id}', [BookingController::class, 'showAdmin']);
Route::post('/admin/bookings/{month_year}', [BookingController::class, 'store']);
Route::post('/admin/bookings', [BookingController::class, 'store']);

// Employee
Route::post('/admin/employees', [EmployeeController::class, 'store']);

// Business registration for
Route::post('/admin/register', [BusinessOwnerController::class, 'store']);

// Activity management
// Custom modified resourceful controller using CRUD routes
Route::resource('admin/activity', ActivityController::class)->except(['create']);

Route::resource('admin/booking', BookingController::class)->only(['edit', 'update', 'destroy']);

/**
 * Hospital — Patient Management (admin CRUD)
 */
Route::middleware(['auth:web_admin', 'ensure.role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/patients', [PatientController::class, 'index']);
        Route::get('/patients/new', [PatientController::class, 'create']);
        Route::post('/patients', [PatientController::class, 'store']);

        Route::get('/patients/{patient}', [PatientController::class, 'show']);
        Route::get('/patients/{patient}/edit', [PatientController::class, 'edit']);
        Route::put('/patients/{patient}', [PatientController::class, 'update']);
        Route::delete('/patients/{patient}', [PatientController::class, 'destroy']);
    });

/**
 * Customer handling
 */

// Booking
Route::get('/bookings', [BookingController::class, 'indexCustomer']);
Route::get('/bookings/new', function () { return redirect('/bookings/' . toMonthYear(getNow()) . '/new'); });
Route::get('/bookings/{month_year}/new', [BookingController::class, 'createCustomer']);
Route::get('/bookings/{month_year}/new/{employee}', [BookingController::class, 'createCustomer']);
Route::post('/bookings', [BookingController::class, 'store']);

/**
 * Appointment actions — Customer
 */
Route::middleware(['auth:web_user'])->group(function () {
    Route::get('/bookings/{booking}/reschedule', [AppointmentController::class, 'rescheduleForm']);
    Route::post('/bookings/{booking}/reschedule', [AppointmentController::class, 'rescheduleCustomer']);
    Route::post('/bookings/{booking}/cancel', [AppointmentController::class, 'cancelCustomer']);
});

/**
 * Medical Records — Doctor (create & view all)
 */
Route::middleware(['auth:web_employee', 'ensure.role:doctor'])->group(function () {
    Route::get('/medical-records', [MedicalRecordController::class, 'index']);
    Route::get('/medical-records/create', [MedicalRecordController::class, 'create']);
    Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show']);
});

/**
 * Medical Records — Patient (view own records only)
 */
Route::middleware(['auth:web_user'])->group(function () {
    Route::get('/my-records', [MedicalRecordController::class, 'index']);
    Route::get('/my-records/{id}', [MedicalRecordController::class, 'show']);

    // Prescriptions (patient view)
    Route::get('/my-prescriptions', [PrescriptionController::class, 'indexMyPrescriptions']);
    Route::get('/my-prescriptions/{id}', [PrescriptionController::class, 'showMyPrescription']);
});

/**
 * Prescriptions (doctor create)
 */
Route::middleware(['auth:web_employee', 'ensure.role:doctor'])->group(function () {
    Route::get('/prescriptions/create', [PrescriptionController::class, 'create']);
    Route::post('/prescriptions', [PrescriptionController::class, 'store']);
});

/**
 * Laboratory (Lab Tests)
 */
Route::middleware(['auth:web_employee', 'ensure.role:doctor'])->group(function () {
    Route::get('/lab-tests/create', [LabController::class, 'create']);
    Route::post('/lab-tests', [LabController::class, 'store']);

    Route::get('/lab-tests/{test}/results', [LabController::class, 'resultsForm']);
    Route::post('/lab-tests/{test}/results', [LabController::class, 'storeResult']);
});

Route::middleware(['auth:web_user'])->group(function () {
    Route::get('/my-lab-tests', [LabController::class, 'indexMyTests']);
    Route::get('/my-lab-tests/{id}', [LabController::class, 'showMyTest']);
});

/**
 * Appointment actions — Admin
 */
Route::middleware(['auth:web_admin', 'ensure.role:admin'])->group(function () {
    Route::post('/admin/bookings/{booking}/approve', [AppointmentController::class, 'approveAdmin']);
    Route::post('/admin/bookings/{booking}/complete', [AppointmentController::class, 'completeAdmin']);
    Route::post('/admin/bookings/{booking}/cancel', [AppointmentController::class, 'cancelAdmin']);
    Route::get('/admin/bookings/{booking}/assign-doctor', [AppointmentController::class, 'assignDoctorForm']);
    Route::post('/admin/bookings/{booking}/assign-doctor', [AppointmentController::class, 'assignDoctor']);
});

/**
 * Reporting & Analytics
 */
Route::middleware(['auth:web_admin', 'ensure.role:admin'])->group(function () {
    Route::get('/admin/reports', [ReportingController::class, 'index']);
});

/**
 * Appointment Notifications
 */
Route::middleware(['auth:web_user'])->group(function () {
    Route::get('/my-notifications', [AppointmentNotificationController::class, 'indexCustomer']);
    Route::post('/my-notifications/{notification}/read', [AppointmentNotificationController::class, 'markRead']);
});

Route::middleware(['auth:web_admin', 'ensure.role:admin'])->group(function () {
    Route::get('/admin/notifications', [AppointmentNotificationController::class, 'indexAdmin']);
});