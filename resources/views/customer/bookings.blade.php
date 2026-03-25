@extends('layouts.master')

@section('content')
	@if ($bookings->count())
		<table class="table no-margin">
			<tr>
				<th class="table__id table__right-solid">ID</th>
				<th class="table__name">Employee</th>
				<th class="table__name">Activity</th>
				<th class="table__time">Start</th>
				<th class="table__time">End</th>
				<th class="table__time">Duration</th>
				<th class="table__date">Date</th>
				<th class="table__date">Status</th>
				<th class="table__date">Actions</th>
			</tr>
			@foreach ($bookings as $booking)
				<tr>
					<td class="table__id table__right-solid">{{ $booking->id }}</td>
					<td class="table__name table__right-dotted">{{ $booking->employee->firstname . ' ' . $booking->employee->lastname }}</td>
					<td class="table__name table__right-dotted">{{ $booking->activity->name }}</td>
					<td class="table__time table__right-dotted">{{ toTime($booking->start_time, true) }}</td>
					<td class="table__time table__right-dotted">{{ toTime($booking->end_time, true) }}</td>
					<td class="table__time table__right-dotted">{{ $booking->activity->duration }}</td>
					<td class="table__date">{{ toDate($booking->date, true) }}</td>
					<td class="table__date">{{ $booking->status }}</td>
					<td class="table__date">
						@if ($booking->status === 'Pending')
							<a class="btn btn-sm btn-primary" href="/bookings/{{ $booking->id }}/reschedule">Reschedule</a>
							<form method="POST" action="/bookings/{{ $booking->id }}/cancel" style="display:inline-block;margin-left:6px;">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Cancel this appointment?')">Cancel</button>
							</form>
						@else
							<span class="text-muted">No actions</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	@else
		<div class="block">
			@include('shared.error_message_thumbs_down', [
				'message' => 'No Bookings Found.',
				'subMessage' => 'Create a new booking <a href="/bookings/new">here</a>'
			])
		</div>
	@endif
@endsection