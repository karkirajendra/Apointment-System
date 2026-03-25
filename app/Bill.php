<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'patient_id',
        'booking_id',
        'total_amount',
        'insurance_provider',
        'insurance_number',
        'status',
        'issued_at',
        'due_at',
    ];

    public function patient()
    {
        return $this->belongsTo(Customer::class, 'patient_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function payments()
    {
        return $this->hasMany(BillPayment::class, 'bill_id');
    }
}

