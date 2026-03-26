@extends('layouts.master')

@section('content')
    <div class="block request">
        @include('shared.error_message')
        @if (!Activity::first())
            @include('shared.error_message_custom', [
                'title'   => 'Activities do not exist',
                'message' => 'Please contact a site administrator.',
                'type'    => 'danger'
            ])
        @endif
        <form class="request" method="POST" action="/bookings">
            @include('shared.loading_message')
            {{ csrf_field() }}

            {{-- Specialty filter --}}
            <div class="form-group">
                <label for="input_specialty">Specialty <span class="request__validate">(Filter Doctors by Specialty — optional)</span></label>
                <select id="input_specialty" name="requested_specialty" class="form-control request__input" onchange="filterDoctorsBySpecialty(this.value)">
                    <option value="">-- All Specialties --</option>
                    @foreach (Employee::whereNotNull('specialty')->where('specialty', '!=', '')->pluck('specialty')->unique()->sort() as $specialty)
                        <option value="{{ $specialty }}" {{ old('requested_specialty') === $specialty ? 'selected' : '' }}>{{ $specialty }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Selecting a specialty helps us assign the right doctor to your booking.</small>
            </div>

            {{-- Doctor / Employee selection (optional) --}}
            <div class="form-group">
                <label for="input_employee">Doctor (Optional) <span class="request__validate">(Leave blank and we will assign one for you)</span></label>
                <select name="employee_id" id="input_employee" class="form-control request__input" onchange="showRedirect('.loading', '/bookings/{{ $dateString }}/new/' + this.value)">
                    <option value="" {{ old('employee_id') || $employeeID ? null : 'selected' }}>-- Let Admin Assign a Doctor --</option>
                    @foreach (Employee::where('is_approved', true)->whereNotNull('role_id')->get()->filter(function($e) { return optional($e->role)->name === 'doctor'; })->sortBy('lastname') as $e)
                        <option value="{{ $e->id }}" data-specialty="{{ $e->specialty }}" {{ old('employee_id') == $e->id || $employeeID == $e->id ? 'selected' : null }}>
                            {{ $e->title . ' - ' . $e->firstname . ' ' . $e->lastname }}
                            @if($e->specialty) ({{ $e->specialty }}) @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="booking_date">Date <span class="request__validate"></span></label>
                <input type="date" name="date" id="booking_date" class="form-control request__input" required value="{{ old('date', request('day') ? $date->format('Y-m-') . str_pad(request('day'), 2, '0', STR_PAD_LEFT) : $date->format('Y-m-d')) }}" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label for="booking_activity">Activity <span class="request__validate">(Name - Duration)</span></label>
                <select name="activity_id" id="booking_activity" class="form-control request__input">
                    @foreach (Activity::all()->sortBy('duration')->sortBy('name') as $activity)
                        <option value="{{ $activity->id }}" {{ old('activity_id') == $activity->id ? 'selected' : null }}>{{ $activity->name . ' - ' . $activity->duration }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="booking_start_time">Start Time <span class="request__validate">(24 hour format)</span></label>
                <input name="start_time" type="text" id="booking_start_time" class="form-control request__input" placeholder="hh:mm" value="{{ old('start_time') ? old('start_time') : '09:00' }}" masked-time>
            </div>

            <button class="btn btn-lg btn-primary btn-block btn--margin-top">Add Booking</button>
        </form>
    </div>
    <hr>
    <h1 class="text-center margin-bottom-three">{{ $date->format('F Y') }}</h1>
    @include('shared.calendar', [
        'pDate' => $date,
        'items' => $roster,
        'type'  => 'customer'
    ])
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.originalDoctorOptions = Array.from(document.getElementById('input_employee').options);
    });

    function filterDoctorsBySpecialty(specialty) {
        var employeeSelect = document.getElementById('input_employee');
        employeeSelect.innerHTML = '';

        var hasValidOption = false;

        window.originalDoctorOptions.forEach(function(option) {
            var optSpecialty = option.getAttribute('data-specialty');
            if (option.value === '' || !specialty || optSpecialty === specialty) {
                employeeSelect.appendChild(option);
                if (option.selected) hasValidOption = true;
            }
        });

        if (!hasValidOption && employeeSelect.options.length > 0) {
            employeeSelect.value = employeeSelect.options[0].value;
        }
    }
</script>