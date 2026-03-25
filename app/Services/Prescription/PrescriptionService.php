<?php

namespace App\Services\Prescription;

use App\Booking;
use App\Prescription;
use App\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrescriptionService
{
    public function create(array $data, int $doctorId): Prescription
    {
        return Prescription::create([
            'patient_id' => $data['patient_id'],
            'doctor_id' => $doctorId,
            'booking_id' => $data['booking_id'] ?? null,
            'diagnosis' => $data['diagnosis'] ?? null,
            'medications' => $data['medications'],
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function getForPatient(int $patientId): Collection
    {
        return Prescription::with(['doctor'])
            ->where('patient_id', $patientId)
            ->latest()
            ->get();
    }

    public function findForPatientOrFail(int $id, int $patientId): Prescription
    {
        $prescription = Prescription::with(['doctor', 'booking'])
            ->findOrFail($id);

        if ((int) $prescription->patient_id !== (int) $patientId) {
            abort(403);
        }

        return $prescription;
    }
}

