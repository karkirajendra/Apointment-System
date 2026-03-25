<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentNotification extends Model
{
    protected $fillable = [
        'booking_id',
        'type',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}

