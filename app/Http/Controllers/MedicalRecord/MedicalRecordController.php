<?php

namespace App\Http\Controllers\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecord\StoreMedicalRecordRequest;
use App\Services\MedicalRecord\MedicalRecordService;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MedicalRecordController extends Controller
{
    public function __construct(private MedicalRecordService $service) {}

    /**
     * List records — doctors see all, patients see their own.
     */
    public function index()
    {
        if (auth()->guard('web_employee')->check()) {
            $records = $this->service->getForDoctor();
            return view('medical-records.index', compact('records'));
        }

        // Patient guard (web_user)
        $customerId = auth()->guard('web_user')->id();
        $records    = $this->service->getForPatient($customerId);
        return view('medical-records.index', compact('records'));
    }

    /**
     * Show the create form (doctor only).
     */
    public function create()
    {
        $patients = Customer::orderBy('firstname')->get();
        return view('medical-records.create', compact('patients'));
    }

    /**
     * Store a new medical record (doctor only).
     */
    public function store(StoreMedicalRecordRequest $request): RedirectResponse
    {
        $employeeId = auth()->guard('web_employee')->id();
        $this->service->store($request->validated(), $employeeId);

        session()->flash('message', 'Medical record created successfully.');
        return redirect('/medical-records');
    }

    /**
     * Show a single medical record.
     * Doctors can view any; patients can only view their own.
     */
    public function show(int $id)
    {
        $record = $this->service->findOrFail($id);

        // Patient guard: ensure they only see their own records
        if (auth()->guard('web_user')->check()) {
            $customerId = auth()->guard('web_user')->id();
            if ($record->patient_id !== $customerId) {
                abort(403, 'Unauthorized.');
            }
        }

        return view('medical-records.show', compact('record'));
    }
}
