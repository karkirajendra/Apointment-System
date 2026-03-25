@extends('layouts.master')

@section('content')
	<div class="block request">
		<h1 class="dash__header">Staff Dashboard</h1>
		<h4 class="dash__description">Welcome, {{ $employee->firstname }} {{ $employee->lastname }}</h4>

		<hr>

		<h4>Next Features (Hospital Modules)</h4>
		<ul>
			<li>Inventory Management</li>
			<li>Billing & Payments</li>
			<li>Appointment Notifications</li>
		</ul>

		<p class="text-muted">For now, this is a placeholder UI. We will wire real data module-by-module.</p>
	</div>
@endsection

