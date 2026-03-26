@extends('layouts.master')

@section('content')
	@include('shared.error_message')

	<div class="block request" style="max-width: 600px; margin: 2rem auto;">
		<div class="text-center" style="margin-bottom: 2rem;">
			<h1 class="dash__header">Patient Registration</h1>
			<h4 class="dash__description">Create your patient profile</h4>
		</div>

		<form method="POST" action="/register">
			{{ csrf_field() }}
			
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
					<label for="inputPhone">Phone <span class="request__validate">(at least 10 char)</span></label>
					<input name="phone" type="text" id="inputPhone" class="form-control request__input" placeholder="Phone" value="{{ old('phone') }}">
				</div>
				<div class="request__flex request__flex--right form-group">
					<label for="inputAddress">Address <span class="request__validate">(at least 6 char)</span></label>
					<input name="address" type="text" id="inputAddress" class="form-control request__input" placeholder="Address" value="{{ old('address') }}">
				</div>
			</div>

			<hr>

			<div class="form-group">
				<label for="inputUsername">Username <span class="request__validate">(alpha-numeric only)</span></label>
				<input name="username" type="text" id="inputUsername" class="form-control request__input" placeholder="Choose a username" value="{{ old('username') }}">
			</div>
			
			<div class="request__flex-container">
				<div class="request__flex request__flex--left form-group">
					<label for="inputPassword">Password <span class="request__validate">(min 6 char)</span></label>
					<input name="password" type="password" id="inputPassword" class="form-control request__input" placeholder="Password">
				</div>
				<div class="request__flex request__flex--right form-group">
					<label for="inputPasswordConfirmation">Confirm Password</label>
					<input name="password_confirmation" type="password" id="inputPasswordConfirmation" class="form-control request__input" placeholder="Repeat Password">
				</div>
			</div>

			<button class="btn btn-lg btn-primary btn-block btn--margin-top" type="submit">Create Patient Account</button>
		</form>
	</div>
@endsection