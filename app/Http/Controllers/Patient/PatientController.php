<?php

namespace App\Http\Controllers\Patient;

use App\Customer;
use App\BusinessOwner;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Services\Patient\PatientService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PatientController extends Controller
{
    public function __construct(private readonly PatientService $service)
    {
        // Routes apply auth + ensure.role middleware; controller stays simple.
    }

    public function index()
    {
        $patients = $this->service->paginatePatients(10);

        return view('admin.patients.index', [
            'business' => BusinessOwner::first(),
            'patients' => $patients,
        ]);
    }

    public function create()
    {
        return view('admin.patients.create', [
            'business' => BusinessOwner::first(),
        ]);
    }

    public function store(StorePatientRequest $request): RedirectResponse
    {
        $this->service->createPatient($request->validated());

        session()->flash('message', 'Patient created successfully.');

        return redirect('/admin/patients');
    }

    public function show(Customer $patient)
    {
        $medicalRecords = $this->service->getMedicalRecordsForPatient($patient->id);

        return view('admin.patients.show', [
            'business' => BusinessOwner::first(),
            'patient' => $patient,
            'medicalRecords' => $medicalRecords,
        ]);
    }

    public function edit(Customer $patient)
    {
        return view('admin.patients.edit', [
            'business' => BusinessOwner::first(),
            'patient' => $patient,
        ]);
    }

    public function update(UpdatePatientRequest $request, Customer $patient): RedirectResponse
    {
        $this->service->updatePatient($patient, $request->validated());

        session()->flash('message', 'Patient updated successfully.');

        return redirect('/admin/patients/' . $patient->id);
    }

    public function destroy(Customer $patient): RedirectResponse
    {
        $this->service->deletePatient($patient);

        session()->flash('message', 'Patient deleted successfully.');

        return redirect('/admin/patients');
    }
}

