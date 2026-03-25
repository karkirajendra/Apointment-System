<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    protected $fillable = [
        'lab_test_id',
        'result_value',
        'normal_range',
        'attachment_path',
        'result_at',
    ];

    protected $casts = [
        'result_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function test()
    {
        return $this->belongsTo(LabTest::class, 'lab_test_id');
    }
}

