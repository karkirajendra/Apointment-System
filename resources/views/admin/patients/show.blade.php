@extends('layouts.dashboard')

@section('content')
<div class="dash__block">
	<div class="flex items-center justify-between mb-6">
		<div>
			<h1 class="dash__header">Patient Details</h1>
			<h4 class="dash__description">{{ $patient->firstname }} {{ $patient->lastname }}</h4>
		</div>
		<div>
			<a class="btn btn-sm btn-primary" href="/admin/patients/{{ $patient->id }}/edit">Edit</a>
			<a class="btn btn-sm btn-default" href="/admin/patients" style="margin-left:6px;">Back</a>
		</div>
	</div>

	@include('shared.session_message')

	<table class="table no-margin">
		<tr>
			<th class="table__name table__left-solid">Username</th>
			<td class="table__name">{{ $patient->username }}</td>
		</tr>
		<tr>
			<th class="table__name table__left-solid">Phone</th>
			<td class="table__name">{{ $patient->phone }}</td>
		</tr>
		<tr>
			<th class="table__name table__left-solid">Address</th>
			<td class="table__name">{{ $patient->address }}</td>
		</tr>
	</table>

	<hr>

	<h3 class="dash__header dash__header--margin-top">Medical History</h3>

	@if ($medicalRecords->count())
		<table class="table no-margin">
			<tr>
				<th class="table__id table__right-solid">#</th>
				<th class="table__name table__left-solid">Title</th>
				<th class="table__name">Doctor</th>
				<th class="table__date">Created</th>
				<th class="table__date">File</th>
			</tr>

			@foreach ($medicalRecords as $record)
				<tr>
					<td class="table__id">{{ $loop->iteration }}</td>
					<td class="table__name table__left-solid">{{ $record->title }}</td>
					<td class="table__name">
						{{ $record->doctor->firstname ?? '' }} {{ $record->doctor->lastname ?? '' }}
					</td>
					<td class="table__date table__left-dotted">{{ \Carbon\Carbon::parse($record->created_at)->format('d/m/y') }}</td>
					<td class="table__date table__left-dotted">
						@if ($record->file_path)
							<a class="btn btn-sm btn-success" href="{{ asset('storage/' . $record->file_path) }}" target="_blank">
								View File
							</a>
						@else
							<span class="text-muted">-</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	@else
		@include('shared.error_message_thumbs_down', [
			'message' => 'No medical records found.',
			'subMessage' => 'A doctor can create records for this patient.',
		])
	@endif
</div>
@endsection

