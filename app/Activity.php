<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon as Time;

class Activity extends Model
{
	protected $guarded = [];

	// Declare public accessors
	public $hour, $minute;

	public function __construct(array $attributes = array()) {
		// Run parent Eloquent model construct method before setup
		parent::__construct($attributes);

		// Set public accessors — cast to int to satisfy Carbon's strict type requirement
		$this->hour   = (int) Time::parse($this->duration)->hour;
		$this->minute = (int) Time::parse($this->duration)->minute;
	}

    /**
	 * Get bookings from activity
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}
}
