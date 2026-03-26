@include('head.html')

<head>
	<title>{{ $business->business_name }} : Dashboard</title>
	@include('head.meta')
	@include('head.css')
	@include('head.js')
	@include('head.other')
</head>

<body class="dashboard">
	<nav class="navbar navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				@php
					// Dynamic page titles
					$title = ": ";

					// Check url for title
					if (Request::is('admin')) {
						$title .= "Business Information";
					}
					elseif (Request::is('admin/summary')) {
						$title .= "Summary of Bookings";
					}
					elseif (Request::is('admin/times')) {
						$title .= "Business Times";
					}
					elseif (Request::is('admin/history')) {
						$title .= "History";
					}
					elseif (Request::is('admin/reports*')) {
						$title .= "Reports";
					}
					elseif (Request::is('admin/notifications*')) {
						$title .= "Notifications";
					}
					elseif (Request::is('admin/employees')) {
						$title .= "Employees";
					}
					elseif (Request::is('admin/activity')) {
						$title .= "Activities";
					}
					elseif (Request::is('admin/booking')) {
						$title .= "Bookings";
					}
					elseif (Request::is('admin/roster/*')) {
						$title .= "Roster";
					}
					elseif( Request::is('admin/employees/assign')) {
						$title .= "Assign Employees";
					}
					else {
						// Else default
						$title = "";
					}
				@endphp
				@if ($business->logo)
					<a title="Redirect back to business information" class="navbar-brand navbar-brand--logo" href="/admin">
						<img class="logo logo--small" alt="" src="{{ asset('storage/' . $business->logo) }}">
					</a>
				@else
					<a title="Redirect back to business information" class="navbar-brand" href="/admin">{{ $business->business_name . $title }}</a>
				@endif
			</div>
			<div id="navbar" class="collapse navbar-collapse navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="/admin">Logged in as {{ $business->username }}</a></li>
					<li><a title="Logout Administrator" href="/logout">Logout</a></li>
				</ul>
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
		<footer class="dashboard">LCJJ Development Team</footer>
	</div>
	
	<div class="dash">
		@yield('content')
	</div>
	
</body>

</html>
