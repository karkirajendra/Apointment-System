<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'booking_id',
        'test_name',
        'status',
        'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Customer::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function results()
    {
        return $this->hasMany(LabResult::class, 'lab_test_id');
    }
}

