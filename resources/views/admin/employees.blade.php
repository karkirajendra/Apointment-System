@extends('layouts.dashboard')

@section('content')

<div class="dash__block">
	<h1 class="dash__header">Create Employee</h1>
	<h4 class="dash__description">Add a new employee to the system</h4>
	@include('shared.session_message')
	@include('shared.error_message')
	<form class="request" method="POST" action="/admin/employees">
		{{ csrf_field() }}
		<div class="form-group">
			<label for="inputRole">Role</label>
			<select name="role" id="inputRole" class="form-control request__input">
				<option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
				<option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
			</select>
		</div>
		<div class="form-group">
			<label for="inputJobTitle">Job Title <span class="request__validate">(e.g. Crew Member, Manager)</span></label>
			<input name="title" type="text" id="inputJobTitle" class="form-control request__input" placeholder="Title" value="{{ old('title') }}" autofocus>
		</div>
		<div class="form-group">
			<label for="inputFirstName">First Name</label>
			<input name="firstname" type="text" id="inputFirstName" class="form-control request__input" placeholder="First Name" value="{{ old('firstname') }}">
		</div>
		<div class="form-group">
			<label for="inputLastName">Last Name</label>
			<input name="lastname" type="text" id="inputLastName" class="form-control request__input" placeholder="Last Name" value="{{ old('lastname') }}">
		</div>
		<div class="form-group">
			<label for="inputUsername">Username</label>
			<input name="username" type="text" id="inputUsername" class="form-control request__input" placeholder="Login username" value="{{ old('username') }}">
		</div>
		<div class="form-group">
			<label for="inputPassword">Password</label>
			<input name="password" type="password" id="inputPassword" class="form-control request__input" placeholder="Password">
		</div>
		<div class="form-group">
			<label for="inputPasswordConfirmation">Password Confirm</label>
			<input name="password_confirmation" type="password" id="inputPasswordConfirmation" class="form-control request__input" placeholder="Confirm password">
		</div>
		<div class="form-group">
			<label for="inputPhone">Phone <span class="request__validate">(at least 10 characters)</span></label>
			<input name="phone" type="text" id="inputPhone" class="form-control request__input" placeholder="Phone" value="{{ old('phone') }}">
		</div>
		<button class="btn btn-lg btn-primary btn-block btn--margin-top">Create Employee</button>
	</form>
</div>
<hr>
<div class="dash__block">
	<h1 class="dash__header dash__header--margin-top">Employees</h1>
	@if ($employees->count())
		<h4 class="main_description">A table of all employees within the business.</h4>
	    <table class="table no-margin">
	        <tr>
				<th class="table__id">ID</th>
				<th class="table__name table__left-solid">First Name</th>
				<th class="table__name">Last Name</th>
				<th class="table__name">Title</th>
				<th class="table__name">Role</th>
				<th class="table__name">Username</th>
				<th class="table__date">Approved</th>
				<th class="table__date">Actions</th>
			</tr>
			@foreach ($employees as $employee)
				<tr>
					<td class="table__id">{{ $employee->id }}</td>
					<td class="table__name table__left-solid">{{ $employee->firstname }}</td>
					<td class="table__name table__left-dotted">{{ $employee->lastname }}</td>
					<td class="table__name table__left-dotted">{{ $employee->title }}</td>
					<td class="table__name table__left-dotted">{{ optional($employee->role)->name ?? '–' }}</td>
					<td class="table__name table__left-dotted">{{ $employee->username ?? '–' }}</td>
					<td class="table__date table__left-dotted">{{ $employee->is_approved ? 'Yes' : 'Pending' }}</td>
					<td class="table__date table__left-dotted">
						@if ($employee->is_approved)
							<form method="POST" action="/admin/employees/{{ $employee->id }}/revoke" style="display:inline;">
								{{ csrf_field() }}
								<button class="btn btn-small btn-warning" type="submit">Revoke</button>
							</form>
						@else
							<form method="POST" action="/admin/employees/{{ $employee->id }}/approve" style="display:inline;">
								{{ csrf_field() }}
								<button class="btn btn-small btn-success" type="submit">Approve</button>
							</form>
						@endif
					</td>
				</tr>
			@endforeach
	    </table>
	@else
		@include('shared.error_message_thumbs_down', [
			'message' => 'No employees found.',
			'subMessage' => 'Try add an employee using the form above.'
		])
	@endif
</div>
@endsection