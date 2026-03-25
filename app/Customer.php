<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Support\Facades\Validator;

use App\Booking;
use App\MedicalRecord;

class Customer extends Model implements Authenticatable
{
	use AuthenticableTrait;

	protected $guarded = [];

	/**
	 * Role assigned to the patient (role-based authorization).
	 */
	public function role()
	{
		return $this->belongsTo(Role::class, 'role_id');
	}

	/**
	 *
	 * Get bookings for customer
	 *
	 */
	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}

	/**
	 * Medical records belonging to this patient.
	 */
	public function medicalRecords()
	{
		return $this->hasMany(MedicalRecord::class, 'patient_id');
	}
}
