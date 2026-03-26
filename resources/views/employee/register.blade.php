@extends('layouts.master')

@section('content')
	@include('shared.error_message')

	<div class="block request" style="max-width: 600px; margin: 2rem auto;">
		<div class="text-center" style="margin-bottom: 2rem;">
			<h1 class="dash__header">⚕️ Staff Registration</h1>
			<h4 class="dash__description">Create a secure account for hospital access</h4>
		</div>

		<form class="request__form" method="POST" action="/register/doctor-staff">
			<p class="text-info">After registration, an admin will review your account and approve login access.</p>
			{{ csrf_field() }}

			<div class="form-group">
				<label for="inputRole">Account Type</label>
				<select name="role" id="inputRole" class="form-control request__input">
					<option value="doctor" {{ old('role', 'doctor') === 'doctor' ? 'selected' : '' }}>🧑‍⚕️ Doctor / Medical Professional</option>
					<option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>🧑‍💼 Hospital Staff / Admin</option>
				</select>
			</div>

			{{-- Specialty dropdown — only for Doctors --}}
			<div class="form-group" id="specialtyGroup" style="display: {{ old('role', 'doctor') !== 'staff' ? 'block' : 'none' }};">
				<label for="inputSpecialty">Specialty <span class="request__validate">(Select your medical specialty)</span></label>
				<select name="specialty" id="inputSpecialty" class="form-control request__input">
					<option value="">-- Select Specialty --</option>
					@foreach ([
						'General Practice', 'Cardiology', 'Dermatology', 'Neurology',
						'Orthopedics', 'Pediatrics', 'Psychiatry', 'Ophthalmology',
						'Ear, Nose & Throat', 'Gynecology', 'Urology', 'Endocrinology',
						'Gastroenterology', 'Pulmonology', 'Rheumatology'
					] as $sp)
						<option value="{{ $sp }}" {{ old('specialty') === $sp ? 'selected' : '' }}>{{ $sp }}</option>
					@endforeach
				</select>
			</div>

			<div class="request__flex-container">
				<div class="request__flex request__flex--left form-group">
					<label for="inputFirstName">First Name</label>
					<input name="firstname" type="text" id="inputFirstName" class="form-control request__input" placeholder="First Name" value="{{ old('firstname') }}" autofocus>
				</div>

				<div class="request__flex request__flex--right form-group">
					<label for="inputLastName">Last Name</label>
					<input name="lastname" type="text" id="inputLastName" class="form-control request__input" placeholder="Last Name" value="{{ old('lastname') }}">
				</div>
			</div>

			<div class="request__flex-container">
				<div class="request__flex request__flex--left form-group">
					<label for="inputJobTitle">Job Title</label>
					<input name="title" type="text" id="inputJobTitle" class="form-control request__input" placeholder="e.g. Senior Cardiologist" value="{{ old('title') }}">
				</div>

				<div class="request__flex request__flex--right form-group">
					<label for="inputPhone">Phone Contact</label>
					<input name="phone" type="text" id="inputPhone" class="form-control request__input" placeholder="Phone Number" value="{{ old('phone') }}">
				</div>
			</div>

			<hr>

			<div class="form-group">
				<label for="inputUsername">Username <span class="request__validate">(used for system login)</span></label>
				<input name="username" type="text" id="inputUsername" class="form-control request__input" placeholder="Choose a username" value="{{ old('username') }}">
			</div>

			<div class="request__flex-container">
				<div class="request__flex request__flex--left form-group">
					<label for="inputPassword">Password</label>
					<input name="password" type="password" id="inputPassword" class="form-control request__input" placeholder="Create password">
				</div>

				<div class="request__flex request__flex--right form-group">
					<label for="inputPasswordConfirmation">Confirm Password</label>
					<input name="password_confirmation" type="password" id="inputPasswordConfirmation" class="form-control request__input" placeholder="Repeat password">
				</div>
			</div>

			<button class="btn btn-lg btn-success btn-block btn--margin-top" type="submit">Create Staff Account</button>
		</form>
	</div>
@endsection

<script>
	document.addEventListener('DOMContentLoaded', function () {
		var roleSelect = document.getElementById('inputRole');
		var specialtyGroup = document.getElementById('specialtyGroup');

		function toggleSpecialty() {
			specialtyGroup.style.display = (roleSelect.value === 'doctor') ? 'block' : 'none';
		}

		roleSelect.addEventListener('change', toggleSpecialty);
		toggleSpecialty(); // Run on load
	});
</script>
