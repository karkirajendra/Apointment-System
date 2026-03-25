@extends('layouts.master')

@section('content')
<div class="block request">
	<h1 class="dash__header">Appointment Notifications</h1>
	<h4 class="dash__description">Status updates for your appointments.</h4>

	@include('shared.session_message')

	@if ($notifications->count())
		<hr>
		@foreach ($notifications as $n)
			<div class="alert {{ $n->read_at ? 'alert-default' : 'alert-info' }}" style="margin-top:10px;">
				<div>
					<strong>{{ ucfirst($n->type) }}:</strong> {{ $n->message }}
				</div>
				<div style="margin-top:6px;">
					<small>
						Appointment #{{ $n->booking?->id }} -
						{{ $n->booking?->activity?->name }}
						({{ $n->booking?->date ? toDate($n->booking->date, true) : '' }})
						{{ $n->booking?->start_time ? 'at ' . toTime($n->booking->start_time, true) : '' }}
					</small>
				</div>

				@if (is_null($n->read_at))
					<form method="POST" action="/my-notifications/{{ $n->id }}/read" style="margin-top:8px;">
						{{ csrf_field() }}
						<button type="submit" class="btn btn-sm btn-primary">Mark read</button>
					</form>
				@endif
			</div>
		@endforeach
	@else
		@include('shared.error_message_thumbs_down', [
			'message' => 'No notifications yet.',
			'subMessage' => 'When admins approve/cancel your appointments, updates will appear here.'
		])
	@endif
</div>
@endsection

