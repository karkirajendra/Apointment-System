
@extends('layouts.dashboard')

@section('content')
	<div class="dash__block">
		<div class="flex items-center justify-between mb-6">
			<div>
				<h1 class="dash__header">Admin Panel</h1>
				<h4 class="main_description">Full management dashboard for staff, doctor approvals, and system settings.</h4>
			</div>
			<a class="btn btn-lg w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white !text-white rounded-lg transition-colors font-medium text-center shadow-sm" href="/admin/edit/">
				<span class="glyphicon glyphicon-edit mr-2" aria-hidden="true"></span> Edit Settings
			</a>
		</div>
		
		@include('shared.session_message')

		<div class="bg-gray-50 rounded-xl p-6 shadow-sm border border-gray-200 flex flex-col md:flex-row gap-8 justify-between items-start mt-6">
			<div class="admin-box-summary flex-1">
				<h3 class="text-xl font-semibold mb-4 text-gray-800">Business Information</h3>
				<div class="space-y-3 text-gray-600">
					<p><strong class="text-gray-900 font-medium">Name:</strong> {{ ucfirst($business->business_name) }}</p>
					<p><strong class="text-gray-900 font-medium">Owner:</strong> {{ ucfirst($business->firstname) . ' ' . ucfirst($business->lastname) }}</p>
					<p><strong class="text-gray-900 font-medium">Phone:</strong> {{ $business->phone }}</p>
					<p><strong class="text-gray-900 font-medium">Address:</strong> {{ ucfirst($business->address) }}</p>
				</div>
			</div>

			<div class="admin-box-links bg-white p-5 rounded-lg shadow-sm border border-gray-100 md:w-72">
				<h3 class="text-lg font-semibold mb-4 text-gray-800">Quick Navigation</h3>
				<nav class="flex flex-col gap-2">
					<a class="px-4 py-2 bg-gray-50 hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 rounded-md transition-colors font-medium border border-gray-100 block" href="/admin/employees">👥 Manage Employees</a>
					<a class="px-4 py-2 bg-gray-50 hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 rounded-md transition-colors font-medium border border-gray-100 block" href="/admin/roster">📋 Roster</a>
					<a class="px-4 py-2 bg-gray-50 hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 rounded-md transition-colors font-medium border border-gray-100 block" href="/admin/bookings">📅 Bookings</a>
					<a class="px-4 py-2 bg-gray-50 hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 rounded-md transition-colors font-medium border border-gray-100 block" href="/admin/reports">📈 Reports</a>
				</nav>
			</div>
		</div>
	</div>
@endsection