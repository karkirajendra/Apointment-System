<?php

namespace App\Http\Controllers\Prescription;

use App\Customer;
use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prescription\StorePrescriptionRequest;
use App\Services\Prescription\PrescriptionService;
use Illuminate\Http\RedirectResponse;

class PrescriptionController extends Controller
{
    public function __construct(private readonly PrescriptionService $service)
    {
    }

    public function create()
    {
        $patients = Customer::orderBy('firstname')->get();

        return view('prescriptions.create', compact('patients'));
    }

    public function store(StorePrescriptionRequest $request): RedirectResponse
    {
        $doctorId = auth()->guard('web_employee')->id();

        $this->service->create($request->validated(), $doctorId);

        session()->flash('message', 'Prescription created successfully.');

        return redirect('/doctor');
    }

    public function indexMyPrescriptions()
    {
        $patientId = auth()->guard('web_user')->id();

        $prescriptions = $this->service->getForPatient($patientId);

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function showMyPrescription(int $id)
    {
        $patientId = auth()->guard('web_user')->id();

        $prescription = $this->service->findForPatientOrFail($id, $patientId);

        return view('prescriptions.show', compact('prescription'));
    }
}

