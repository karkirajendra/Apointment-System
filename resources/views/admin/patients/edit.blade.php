@extends('layouts.dashboard')

@section('content')
<div class="dash__block">
	<h1 class="dash__header">Edit Patient</h1>
	<h4 class="dash__description">Update patient profile</h4>

	@include('shared.session_message')
	@include('shared.error_message')

	<form class="request" method="POST" action="/admin/patients/{{ $patient->id }}">
		{{ csrf_field() }}
		@method('PUT')

		<div class="form-group">
			<label>First Name</label>
			<input name="firstname" type="text" class="form-control request__input" value="{{ old('firstname', $patient->firstname) }}" autofocus>
		</div>

		<div class="form-group">
			<label>Last Name</label>
			<input name="lastname" type="text" class="form-control request__input" value="{{ old('lastname', $patient->lastname) }}">
		</div>

		<div class="form-group">
			<label>Username</label>
			<input name="username" type="text" class="form-control request__input" value="{{ old('username', $patient->username) }}">
		</div>

		<div class="form-group">
			<label>New Password <span class="text-muted">(leave blank to keep current)</span></label>
			<input name="password" type="password" class="form-control request__input" value="">
		</div>

		<div class="form-group">
			<label>Password Confirmation</label>
			<input name="password_confirmation" type="password" class="form-control request__input" value="">
		</div>

		<div class="form-group">
			<label>Phone</label>
			<input name="phone" type="text" class="form-control request__input" value="{{ old('phone', $patient->phone) }}">
		</div>

		<div class="form-group">
			<label>Address</label>
			<input name="address" type="text" class="form-control request__input" value="{{ old('address', $patient->address) }}">
		</div>

		<button class="btn btn-lg btn-primary btn-block btn--margin-top">Save Changes</button>
	</form>
</div>
@endsection

