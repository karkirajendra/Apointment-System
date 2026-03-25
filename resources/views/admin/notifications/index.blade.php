@extends('layouts.dashboard')

@section('content')
<div class="dash__block">
	<h1 class="dash__header">Appointment Notifications</h1>
	<h4 class="dash__description">Recent appointment status updates.</h4>

	@include('shared.session_message')

	@if ($notifications->count())
		<hr>
		@foreach ($notifications as $n)
			<div class="block" style="margin-top:12px;">
				<p style="margin:0 0 6px 0;">
					<strong>{{ ucfirst($n->type) }}:</strong> {{ $n->message }}
				</p>
				<p style="margin:0;">
					<small>
						Appointment #{{ $n->booking?->id }} -
						Patient: {{ $n->booking?->customer?->firstname }} {{ $n->booking?->customer?->lastname }} -
						Date: {{ $n->booking?->date ? toDate($n->booking->date, true) : '' }}
					</small>
				</p>
				<p style="margin:8px 0 0 0;">
					<small>
						Created: {{ $n->created_at ? $n->created_at->format('d/m/y') : '' }} -
						@if (is_null($n->read_at))
							<span class="text-muted">(Unread)</span>
						@endif
					</small>
				</p>
			</div>
		@endforeach
	@else
		@include('shared.error_message_thumbs_down', [
			'message' => 'No notifications found.',
			'subMessage' => 'As appointments are approved/cancelled, notifications will show up here.'
		])
	@endif
</div>
@endsection

