<?php

namespace App\Http\Controllers\Lab;

use App\Customer;
use App\LabTest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\StoreLabResultRequest;
use App\Http\Requests\Lab\StoreLabTestRequest;
use App\Services\Lab\LabService;
use Illuminate\Http\RedirectResponse;

class LabController extends Controller
{
    public function __construct(private readonly LabService $service)
    {
    }

    public function create()
    {
        $patients = Customer::orderBy('firstname')->get();

        return view('lab-tests.create', compact('patients'));
    }

    public function store(StoreLabTestRequest $request): RedirectResponse
    {
        $doctorId = auth()->guard('web_employee')->id();

        $this->service->createTest($request->validated(), $doctorId);

        session()->flash('message', 'Lab test ordered successfully.');

        return redirect('/doctor');
    }

    public function resultsForm(LabTest $test)
    {
        $doctorId = auth()->guard('web_employee')->id();

        if ((int) $test->doctor_id !== (int) $doctorId) {
            abort(403);
        }

        return view('lab-tests.results', compact('test'));
    }

    public function storeResult(StoreLabResultRequest $request, LabTest $test): RedirectResponse
    {
        $this->service->addResult($test, $request->validated());

        session()->flash('message', 'Lab result saved successfully.');

        return redirect()->back();
    }

    public function indexMyTests()
    {
        $patientId = auth()->guard('web_user')->id();

        $tests = $this->service->getForPatient($patientId);

        return view('lab-tests.index', compact('tests'));
    }

    public function showMyTest(int $id)
    {
        $patientId = auth()->guard('web_user')->id();

        $test = $this->service->findForPatientOrFail($id, $patientId);

        return view('lab-tests.show', compact('test'));
    }
}

