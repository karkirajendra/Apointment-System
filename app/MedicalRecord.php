<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'uploaded_by_employee_id',
        'title',
        'description',
        'file_path',
    ];

    /**
     * The patient (customer) this record belongs to.
     */
    public function patient()
    {
        return $this->belongsTo(Customer::class, 'patient_id');
    }

    /**
     * The doctor/employee who uploaded the record.
     */
    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'uploaded_by_employee_id');
    }
}
