@extends('layouts.master')

@section('content')
<div class="block request">
	<a class="btn btn-sm btn-default" href="/bookings">← Back to Bookings</a>

	<h1 class="dash__header" style="margin-top:15px;">Reschedule Appointment</h1>
	<h4 class="dash__description">
		Booking #{{ $booking->id }} — {{ $booking->activity->name }}
	</h4>

	@include('shared.error_message')

	<form class="request" method="POST" action="/bookings/{{ $booking->id }}/reschedule">
		{{ csrf_field() }}

		<div class="form-group">
			<label>Current Date</label>
			<p class="form-control" style="background:#f7f7f7;">{{ toDate($booking->date, true) }}</p>
		</div>

		<div class="form-group">
			<label>Current Start Time</label>
			<p class="form-control" style="background:#f7f7f7;">{{ toTime($booking->start_time, true) }}</p>
		</div>

		<hr>

		<div class="form-group">
			<label>New Date</label>
			<input
				name="date"
				type="date"
				class="form-control request__input"
				value="{{ old('date', $booking->date) }}"
				autofocus
			>
		</div>

		<div class="form-group">
			<label>New Start Time</label>
			<input
				name="start_time"
				type="time"
				class="form-control request__input"
				value="{{ old('start_time', substr($booking->start_time, 0, 5)) }}"
			>
		</div>

		<button class="btn btn-lg btn-primary btn-block btn--margin-top" type="submit">Save Reschedule</button>
	</form>
</div>
@endsection

