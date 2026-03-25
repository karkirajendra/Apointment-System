<?php

namespace App\Services\Patient;

use App\Customer;
use App\MedicalRecord;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class PatientService
{
    public function paginatePatients(int $perPage = 10)
    {
        // Keep simple: only show patients (role_id = patient)
        $patientRole = Role::where('name', 'patient')->first();

        $query = Customer::query();
        if ($patientRole) {
            $query->where('role_id', $patientRole->id);
        }

        return $query->orderBy('firstname')->paginate($perPage);
    }

    public function createPatient(array $data): Customer
    {
        $patientRole = Role::where('name', 'patient')->firstOrFail();

        return Customer::create([
            'firstname' => ucfirst($data['firstname']),
            'lastname' => ucfirst($data['lastname']),
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'role_id' => $patientRole->id,
        ]);
    }

    public function updatePatient(Customer $patient, array $data): Customer
    {
        $patientRole = Role::where('name', 'patient')->firstOrFail();

        $patient->firstname = ucfirst($data['firstname']);
        $patient->lastname = ucfirst($data['lastname']);
        $patient->username = $data['username'];
        $patient->address = $data['address'];
        $patient->phone = $data['phone'];
        $patient->role_id = $patientRole->id;

        if (!empty($data['password'])) {
            $patient->password = Hash::make($data['password']);
        }

        $patient->save();

        return $patient;
    }

    public function deletePatient(Customer $patient): void
    {
        // For a student-friendly version: delete the customer record.
        // Medical records will remain unless you add cascading foreign keys.
        $patient->delete();
    }

    public function getMedicalRecordsForPatient(int $patientId): Collection
    {
        return MedicalRecord::with('doctor')
            ->where('patient_id', $patientId)
            ->latest()
            ->get();
    }
}

