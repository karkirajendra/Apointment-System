@include('head.html')

<head>
	<title>
		@if ($business = BusinessOwner::first())
			{{ $business->business_name }}: Booking System
		@else
			Business Placeholder
		@endif
	</title>
	@include('head.meta')
	@include('head.css')
	@include('head.js')
	@include('head.other')
</head>

<body>
	<div class="container">
		@php
			$customer = Auth::guard('web_user')->user();
			$admin = Auth::guard('web_admin')->user();
			$employee = Auth::guard('web_employee')->user();
			$isLoggedIn = $customer || $admin || $employee;
			$loggedInUsername = $customer?->username ?? $admin?->username ?? $employee?->username;
		@endphp

		@if ($isLoggedIn)
			<ul class="nav nav-pills pull-left">
				@if ($customer)
					<li role="presentation" class="{{ Request::is('bookings') ? 'active' : null }}"><a href="/bookings">Bookings</a></li>
					<li role="presentation" class="{{ Request::is('bookings/*') ? 'active' : null }}"><a href="/bookings/{{ toMonthYear(getNow()) }}/new">Create Booking</a></li>
					<li role="presentation" class="{{ Request::is('my-notifications') ? 'active' : null }}"><a href="/my-notifications">Notifications</a></li>
				@endif
				@if ($admin)
					<li role="presentation" class="{{ Request::is('admin') ? 'active' : null }}"><a href="/admin">Admin</a></li>
				@endif
				@if ($employee)
					<li role="presentation" class="{{ Request::is('doctor*') || Request::is('staff*') ? 'active' : null }}"><a href="{{ $employee?->role?->name === 'doctor' ? '/doctor' : '/staff' }}">Dashboard</a></li>
				@endif
			</ul>
			<div class="pull-right user">
				Logged in as {{ $loggedInUsername }}
				<a href="/logout">Logout</a>
			</div>
		@endif
		<div class="clearfix"></div>
		<div class="header">
			<a class="header__title" href="/">
				@if ($business = BusinessOwner::first())
					@if ($business->logo)
						<img class="logo logo--large padding-bottom-three padding-top-three" alt="" src="{{ asset('storage/' . $business->logo) }}">
					@else
						<h1>{{ BusinessOwner::first()->business_name }}</h1>
					@endif
				@else
					<h1>Business Placeholder</h1>
				@endif
			</a>
			@php
				// Dynamic page titles
				$title = ": ";

				// Check url for title
				if (Request::is('bookings')) {
					$title .= "Customer Bookings";
				}
				elseif (Request::is('login')) {
					$title .= "Login";
				}
				elseif (Request::is('register')) {
					$title .= "Customer Registration";
				}
				elseif (Request::is('admin')) {
					$title .= "Admin";
				}
				elseif (Request::is('create_booking')) {
					$title .= "Create a Booking";
				}
				else {
					// Else default
					$title = "";
				}
			@endphp
			<h3 class="header__subtitle">Booking System{{ $title }}</h3>
		</div>
	</div>
	<div class="container">
		@include('shared.session_message')
		@yield('content')
	</div>
	<footer>
		LCJJ Development Team
	</footer>
</body>

</html>
