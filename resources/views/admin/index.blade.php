
@extends('layouts.dashboard')

@section('content')
	<div class="dash__block">
		<a class="btn btn-lg btn-primary pull-right" href="/admin/edit/"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
		<h1 class="dash__header">Admin Panel</h1>
		<h4 class="main_description">Full management dashboard for staff, doctor approvals, and system settings.</h4>
		@include('shared.session_message')

		<div class="admin-box-summary">
			<h3>Business Info</h3>
			<p><strong>Name:</strong> {{ ucfirst($business->business_name) }}</p>
			<p><strong>Owner:</strong> {{ ucfirst($business->firstname) . ' ' . ucfirst($business->lastname) }}</p>
			<p><strong>Phone:</strong> {{ $business->phone }}</p>
			<p><strong>Address:</strong> {{ ucfirst($business->address) }}</p>
		</div>

		<div class="admin-box-links" style="margin-top: 16px;">
			<a class="btn btn-default" href="/admin/employees">Manage Employees</a>
			<a class="btn btn-default" href="/admin/roster">Roster</a>
			<a class="btn btn-default" href="/admin/bookings">Bookings</a>
			<a class="btn btn-default" href="/admin/reports">Reports</a>
		</div>
	</div>
@endsection