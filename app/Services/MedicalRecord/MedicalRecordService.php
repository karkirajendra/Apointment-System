<?php

namespace App\Services\MedicalRecord;

use App\MedicalRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class MedicalRecordService
{
    /**
     * Store a new medical record, handling optional file upload.
     *
     * @param array $data   Validated form data
     * @param int   $employeeId  ID of the doctor creating the record
     * @return MedicalRecord
     */
    public function store(array $data, int $employeeId): MedicalRecord
    {
        $filePath = null;

        if (isset($data['file']) && $data['file']) {
            $filePath = $data['file']->store('medical-records', 'public');
        }

        return MedicalRecord::create([
            'patient_id'              => $data['patient_id'],
            'uploaded_by_employee_id' => $employeeId,
            'title'                   => $data['title'],
            'description'             => $data['description'] ?? null,
            'file_path'               => $filePath,
        ]);
    }

    /**
     * Get all medical records (for doctor view), latest first.
     *
     * @return Collection
     */
    public function getForDoctor(): Collection
    {
        return MedicalRecord::with(['patient', 'doctor'])
            ->latest()
            ->get();
    }

    /**
     * Get medical records belonging to a specific patient.
     *
     * @param int $customerId
     * @return Collection
     */
    public function getForPatient(int $customerId): Collection
    {
        return MedicalRecord::with(['doctor'])
            ->where('patient_id', $customerId)
            ->latest()
            ->get();
    }

    /**
     * Find a single record by ID.
     *
     * @param int $id
     * @return MedicalRecord
     */
    public function findOrFail(int $id): MedicalRecord
    {
        return MedicalRecord::with(['patient', 'doctor'])->findOrFail($id);
    }
}
