@include('head.html')

<head>
	<title>{{ $business->business_name }} : Dashboard</title>
	@include('head.meta')
	@include('head.css')
	@include('head.js')
	@include('head.other')
</head>

<body class="dashboard">
	{{-- Modern Tailwind Navbar --}}
	<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-sm" style="height:60px;">
		<div class="flex items-center justify-between h-full px-6">
			{{-- Left: Brand / Logo --}}
			<div class="flex items-center gap-3">
				@if ($business->logo)
					<a href="/admin" title="Back to Business Info" class="flex items-center gap-2">
						<img class="h-8 w-auto rounded" alt="{{ $business->business_name }}" src="{{ asset('storage/' . $business->logo) }}">
					</a>
				@else
					<a href="/admin" title="Back to Business Info" class="text-lg font-bold text-indigo-600 tracking-tight hover:text-indigo-700 transition-colors">
						{{ $business->business_name }}
					</a>
				@endif

				@php
					$pageTitle = null;
					if (Request::is('admin/summary'))          $pageTitle = 'Summary';
					elseif (Request::is('admin/times'))        $pageTitle = 'Business Times';
					elseif (Request::is('admin/history'))      $pageTitle = 'History';
					elseif (Request::is('admin/reports*'))     $pageTitle = 'Reports';
					elseif (Request::is('admin/notifications*')) $pageTitle = 'Notifications';
					elseif (Request::is('admin/employees'))    $pageTitle = 'Employees';
					elseif (Request::is('admin/activity'))     $pageTitle = 'Activities';
					elseif (Request::is('admin/bookings*'))    $pageTitle = 'Bookings';
					elseif (Request::is('admin/roster*'))      $pageTitle = 'Roster';
					elseif (Request::is('admin/patients*'))    $pageTitle = 'Patients';
					elseif (Request::is('admin'))              $pageTitle = 'Dashboard';
				@endphp

				@if ($pageTitle)
					<span class="hidden md:inline text-gray-300 text-lg font-light">/</span>
					<span class="hidden md:inline text-gray-600 font-medium text-sm">{{ $pageTitle }}</span>
				@endif
			</div>

			{{-- Right: User info + logout --}}
			<div class="flex items-center gap-4">
				<span class="hidden sm:flex items-center gap-2 text-sm text-gray-500">
					<span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 font-semibold text-xs">
						{{ strtoupper(substr($business->username, 0, 1)) }}
					</span>
					<span class="font-medium text-gray-700">{{ $business->username }}</span>
				</span>
				<a href="/logout" title="Logout Administrator"
				   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 border border-transparent hover:border-red-100 transition-colors">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
					</svg>
					<span class="hidden sm:inline">Logout</span>
				</a>
			</div>
		</div>
	</nav>
	
	<div class="sidebar">
		<div class="sidebar-label">Management</div>
		<ul class="nav nav-sidebar">
			<li class="{{ Request::is('admin') ? 'active' : null }}"><a title="Show Business Information" href="/admin"><span class="nav-icon">🏢</span> Information</a></li>
			<li class="{{ Request::is('admin/times') ? 'active' : null }}"><a title="Show open hours for the business" href="/admin/times"><span class="nav-icon">⏰</span> Business Times</a></li>
			<li class="{{ Request::is('admin/employees') ? 'active' : null }}"><a title="Show all employees" href="/admin/employees"><span class="nav-icon">👥</span> Employees</a></li>
			<li class="{{ Request::is('admin/roster/*') ? 'active' : null }}"><a title="Show a roster" href="/admin/roster/{{ Time::now('Asia/Kathmandu')->format('m-Y') }}"><span class="nav-icon">📋</span> Roster</a></li>
			<li class="{{ Request::is('admin/activity') ? 'active' : null }}"><a title="Show activitites" href="/admin/activity"><span class="nav-icon">🎾</span> Activities</a></li>
			<li class="{{ Request::is('admin/patients*') ? 'active' : null }}"><a title="Manage patients" href="/admin/patients"><span class="nav-icon">🤒</span> Patients</a></li>
		</ul>
		
		<div class="sidebar-label">Scheduling</div>
		<ul class="nav nav-sidebar">
			<li class="{{ Request::is('admin/bookings/*') ? 'active' : null }}"><a title="Show a bookings" href="/admin/bookings/{{ Time::now('Asia/Kathmandu')->format('m-Y') }}"><span class="nav-icon">📅</span> Bookings</a></li>
			<li class="{{ Request::is('admin/summary') ? 'active' : null }}"><a title="Show a summary of bookings" href="/admin/summary"><span class="nav-icon">📊</span> Summary</a></li>
			<li class="{{ Request::is('admin/history') ? 'active' : null }}"><a title="Show a history of bookings" href="/admin/history"><span class="nav-icon">🕰️</span> History</a></li>
		</ul>

		<div class="sidebar-label">System</div>
		<ul class="nav nav-sidebar">
			<li class="{{ Request::is('admin/reports*') ? 'active' : null }}"><a title="Reporting & Analytics" href="/admin/reports"><span class="nav-icon">📈</span> Reports</a></li>
			<li class="{{ Request::is('admin/notifications*') ? 'active' : null }}"><a title="Appointment notifications" href="/admin/notifications"><span class="nav-icon">🔔</span> Notifications</a></li>
		</ul>
	
	</div>
	
	<div class="dash">
		@yield('content')
	</div>
	
</body>

</html>
