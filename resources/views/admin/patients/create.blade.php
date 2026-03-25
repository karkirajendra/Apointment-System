@extends('layouts.dashboard')

@section('content')
<div class="dash__block">
	<h1 class="dash__header">Create Patient</h1>
	<h4 class="dash__description">Add a new patient account</h4>

	@include('shared.session_message')
	@include('shared.error_message')

	<form class="request" method="POST" action="/admin/patients">
		{{ csrf_field() }}

		<div class="form-group">
			<label>First Name</label>
			<input name="firstname" type="text" class="form-control request__input" value="{{ old('firstname') }}" autofocus>
		</div>

		<div class="form-group">
			<label>Last Name</label>
			<input name="lastname" type="text" class="form-control request__input" value="{{ old('lastname') }}">
		</div>

		<div class="form-group">
			<label>Username</label>
			<input name="username" type="text" class="form-control request__input" value="{{ old('username') }}">
		</div>

		<div class="form-group">
			<label>Password</label>
			<input name="password" type="password" class="form-control request__input">
		</div>

		<div class="form-group">
			<label>Password Confirmation</label>
			<input name="password_confirmation" type="password" class="form-control request__input">
		</div>

		<div class="form-group">
			<label>Phone</label>
			<input name="phone" type="text" class="form-control request__input" value="{{ old('phone') }}">
		</div>

		<div class="form-group">
			<label>Address</label>
			<input name="address" type="text" class="form-control request__input" value="{{ old('address') }}">
		</div>

		<button class="btn btn-lg btn-primary btn-block btn--margin-top">Create Patient</button>
	</form>
</div>
@endsection

