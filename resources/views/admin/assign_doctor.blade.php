@extends('layouts.dashboard')

@section('content')
<div class="dash__block">
    <h1 class="dash__header">Assign Doctor to Booking #{{ $booking->id }}</h1>
    <h4 class="dash__description">
        Select an approved doctor
        @if($booking->requested_specialty)
            specializing in <strong>{{ $booking->requested_specialty }}</strong>
        @endif
        for this appointment.
    </h4>

    @include('shared.session_message')
    @include('shared.error_message')

    <div style="background:#f8f9fa; border-radius:8px; padding:1.2rem; margin-bottom:1.5rem;">
        <table class="table no-margin" style="margin:0;">
            <tr><th style="width:160px;">Booking ID</th><td>#{{ $booking->id }}</td></tr>
            <tr><th>Customer</th><td>{{ optional($booking->customer)->firstname }} {{ optional($booking->customer)->lastname }}</td></tr>
            <tr><th>Activity</th><td>{{ optional($booking->activity)->name }}</td></tr>
            <tr><th>Date</th><td>{{ $booking->date }}</td></tr>
            <tr><th>Time</th><td>{{ toTime($booking->start_time, false) }} – {{ toTime($booking->end_time, false) }}</td></tr>
            <tr><th>Requested Specialty</th><td>{{ $booking->requested_specialty ?? '(Any)' }}</td></tr>
            <tr><th>Status</th><td>{{ $booking->status }}</td></tr>
        </table>
    </div>

    <form method="POST" action="/admin/bookings/{{ $booking->id }}/assign-doctor">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="assign_employee_id">Select Doctor <span class="request__validate">(Specialty – Name)</span></label>
            <select name="employee_id" id="assign_employee_id" class="form-control request__input">
                <option value="">-- Choose a Doctor --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">
                        {{ $doctor->specialty ? '[' . $doctor->specialty . '] ' : '' }}{{ $doctor->title }} {{ $doctor->firstname }} {{ $doctor->lastname }}
                    </option>
                @endforeach
            </select>
            @if($doctors->isEmpty())
                <p class="text-warning" style="margin-top:.5rem;">
                    ⚠ No approved doctors found
                    @if($booking->requested_specialty) for specialty "{{ $booking->requested_specialty }}" @endif.
                    Try clearing the specialty filter below.
                </p>
                @if($booking->requested_specialty)
                    <a href="/admin/bookings/{{ $booking->id }}/assign-doctor?ignore_specialty=1" class="btn btn-sm btn-default" style="margin-top:.5rem;">Show All Doctors</a>
                @endif
            @endif
        </div>
        <button type="submit" class="btn btn-lg btn-success btn-block btn--margin-top">✔ Assign Doctor &amp; Approve Booking</button>
    </form>

    <a href="{{ url()->previous() }}" class="btn btn-default" style="margin-top:1rem;">← Back</a>
</div>
@endsection
