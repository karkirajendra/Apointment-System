@extends('layouts.dashboard')

@section('content')
<div class="dash__block">
	<div class="flex items-center justify-between mb-6">
		<div>
			<h1 class="dash__header">Patients</h1>
			<h4 class="main_description">Add and manage hospital patients</h4>
		</div>
		<a class="btn btn-lg btn-primary" href="/admin/patients/new">+ New Patient</a>
	</div>

	@include('shared.session_message')
	@include('shared.error_message')

	@if ($patients->count())
		<table class="table no-margin">
			<tr>
				<th class="table__id table__right-solid">ID</th>
				<th class="table__name table__left-solid">First Name</th>
				<th class="table__name">Last Name</th>
				<th class="table__name">Username</th>
				<th class="table__name">Phone</th>
				<th class="table__date">Created</th>
				<th class="table__date">Actions</th>
			</tr>

			@foreach ($patients as $patient)
				<tr>
					<td class="table__id">{{ $patient->id }}</td>
					<td class="table__name table__left-solid">{{ $patient->firstname }}</td>
					<td class="table__name">{{ $patient->lastname }}</td>
					<td class="table__name">{{ $patient->username }}</td>
					<td class="table__name">{{ $patient->phone }}</td>
					<td class="table__date table__left-dotted">
						{{ \Carbon\Carbon::parse($patient->created_at)->format('d/m/y') }}
					</td>
					<td class="table__date table__left-dotted">
						<a class="btn btn-sm btn-info" href="/admin/patients/{{ $patient->id }}">View</a>
						<a class="btn btn-sm btn-primary" href="/admin/patients/{{ $patient->id }}/edit" style="margin-left:6px;">Edit</a>
						<form method="POST" action="/admin/patients/{{ $patient->id }}" style="display:inline-block;margin-left:6px;">
							{{ csrf_field() }}
							@method('DELETE')
							<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this patient?')">Delete</button>
						</form>
					</td>
				</tr>
			@endforeach
		</table>

		<div class="mt-4">
			{{ $patients->links() }}
		</div>
	@else
		@include('shared.error_message_thumbs_down', [
			'message' => 'No patients found.',
			'subMessage' => 'Add a new patient using the button above.',
		])
	@endif
</div>
@endsection

