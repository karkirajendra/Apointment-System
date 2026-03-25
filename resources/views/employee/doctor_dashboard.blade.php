@extends('layouts.master')

@section('content')
	<div class="block request">
		<h1 class="dash__header">Doctor Dashboard</h1>
		<h4 class="dash__description">Welcome, {{ $employee->firstname }} {{ $employee->lastname }}</h4>

		<hr>

		<h4>Hospital Modules</h4>
		<ul>
			<li><a href="/medical-records">Medical Records</a> — Create &amp; view patient records</li>
			<li><a href="/prescriptions/create">Prescriptions</a> — Create &amp; patient can view</li>
			<li>Laboratory Requests &amp; Results <span style="color:#aaa;font-size:0.85em;">(coming soon)</span></li>
		</ul>
	</div>
@endsection
