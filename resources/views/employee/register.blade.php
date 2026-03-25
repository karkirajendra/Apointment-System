@extends('layouts.master')

@section('content')
	@include('shared.error_message')

	<div class="block request">
		<h1 class="dash__header">Doctor / Staff Registration</h1>
		<h4 class="dash__description">Create an account for hospital staff</h4>

		<form class="request__form" method="POST" action="/register/doctor-staff">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="inputRole">Role</label>
				<select name="role" id="inputRole" class="form-control request__input">
					<option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
					<option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
				</select>
			</div>

			<div class="form-group">
				<label for="inputFirstName">First Name</label>
				<input name="firstname" type="text" id="inputFirstName" class="form-control request__input" placeholder="First Name" value="{{ old('firstname') }}" autofocus>
			</div>

			<div class="form-group">
				<label for="inputLastName">Last Name</label>
				<input name="lastname" type="text" id="inputLastName" class="form-control request__input" placeholder="Last Name" value="{{ old('lastname') }}">
			</div>

			<div class="form-group">
				<label for="inputJobTitle">Job Title / Specialty</label>
				<input name="title" type="text" id="inputJobTitle" class="form-control request__input" placeholder="e.g. Cardiologist, Nurse" value="{{ old('title') }}">
			</div>

			<div class="form-group">
				<label for="inputPhone">Phone</label>
				<input name="phone" type="text" id="inputPhone" class="form-control request__input" placeholder="Phone" value="{{ old('phone') }}">
			</div>

			<hr>

			<div class="form-group">
				<label for="inputUsername">Username</label>
				<input name="username" type="text" id="inputUsername" class="form-control request__input" placeholder="Username" value="{{ old('username') }}">
			</div>

			<div class="form-group">
				<label for="inputPassword">Password</label>
				<input name="password" type="password" id="inputPassword" class="form-control request__input" placeholder="Password">
			</div>

			<div class="form-group">
				<label for="inputPasswordConfirmation">Password Confirmation</label>
				<input name="password_confirmation" type="password" id="inputPasswordConfirmation" class="form-control request__input" placeholder="Password Confirmation">
			</div>

			<button class="btn btn-lg btn-primary btn-block btn--margin-top" type="submit">Create Account</button>
		</form>
	</div>
@endsection

