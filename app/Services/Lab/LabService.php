<?php

namespace App\Services\Lab;

use App\LabResult;
use App\LabTest;
use Carbon\Carbon as Time;
use Illuminate\Support\Collection;

class LabService
{
    public function createTest(array $data, int $doctorId): LabTest
    {
        $test = LabTest::create([
            'patient_id' => $data['patient_id'],
            'doctor_id' => $doctorId,
            'booking_id' => $data['booking_id'] ?? null,
            'test_name' => $data['test_name'],
            'status' => 'Ordered',
            'ordered_at' => Time::now('Australia/Melbourne'),
        ]);

        return $test;
    }

    public function addResult(LabTest $test, array $data): LabResult
    {
        $attachmentPath = null;
        if (isset($data['attachment']) && $data['attachment']) {
            $attachmentPath = $data['attachment']->store('lab-results', 'public');
        }

        $result = LabResult::create([
            'lab_test_id' => $test->id,
            'result_value' => $data['result_value'] ?? null,
            'normal_range' => $data['normal_range'] ?? null,
            'attachment_path' => $attachmentPath,
            'result_at' => Time::now('Australia/Melbourne'),
        ]);

        // Mark the whole test as completed once a result is added.
        $test->status = 'Completed';
        $test->save();

        return $result;
    }

    public function getForPatient(int $patientId): Collection
    {
        return LabTest::with(['doctor', 'results'])
            ->where('patient_id', $patientId)
            ->latest()
            ->get();
    }

    public function findForPatientOrFail(int $id, int $patientId): LabTest
    {
        $test = LabTest::with(['doctor', 'results'])->findOrFail($id);

        if ((int) $test->patient_id !== (int) $patientId) {
            abort(403);
        }

        return $test;
    }
}

