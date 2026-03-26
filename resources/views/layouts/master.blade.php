@include('head.html')

<head>
	<title>
		@if ($business = BusinessOwner::first())
			{{ $business->business_name }} : Booking System
		@else
			S & S Hospital
		@endif
	</title>
	@include('head.meta')
	@include('head.css')
	@include('head.js')
	@include('head.other')
</head>

<body>
	@php
		$customer = Auth::guard('web_user')->user();
		$admin = Auth::guard('web_admin')->user();
		$employee = Auth::guard('web_employee')->user();
		$isLoggedIn = $customer || $admin || $employee;
		$loggedInUsername = $customer?->username ?? $admin?->username ?? $employee?->username;
	@endphp

	<nav class="public-nav">
		<a class="public-nav__brand" href="/">
			@if ($business = BusinessOwner::first())
				{{ $business->business_name }}
			@else
				Booking System
			@endif
		</a>
		
		@if ($isLoggedIn)
			<ul class="public-nav__links">
				@if ($customer)
					<li class="{{ Request::is('bookings') ? 'active' : null }}"><a href="/bookings">Bookings</a></li>
					<li class="{{ Request::is('bookings/*') ? 'active' : null }}"><a href="/bookings/{{ toMonthYear(getNow()) }}/new">Create Booking</a></li>
					<li class="{{ Request::is('my-notifications') ? 'active' : null }}"><a href="/my-notifications">Notifications</a></li>
				@endif
				@if ($admin)
					<li class="{{ Request::is('admin') ? 'active' : null }}"><a href="/admin">Admin Dashboard</a></li>
				@endif
				@if ($employee)
					<li class="{{ Request::is('doctor*') || Request::is('staff*') ? 'active' : null }}"><a href="{{ $employee?->role?->name === 'doctor' ? '/doctor' : '/staff' }}">Dashboard</a></li>
				@endif
			</ul>
			<div class="public-nav__user">
				Logged in as {{ $loggedInUsername }}
				<a href="/logout">Logout</a>
			</div>
		@endif
	</nav>

	<div class="container">
		<div class="header">
			<a class="header__title" href="/">
				@if ($business = BusinessOwner::first() && $business->logo)
					<img class="logo logo--large padding-bottom-three" alt="" src="{{ asset('storage/' . $business->logo) }}">
				@else
					<h1>{{ $business ? $business->business_name : 'S & S Hospital' }}</h1>
				@endif
			</a>
			@php
				// Dynamic page titles
				$title = "";

				// Check url for title
				if (Request::is('bookings')) {
					$title = "Customer Bookings";
				}
				elseif (Request::is('login')) {
					$title = "Access Your Account";
				}
				elseif (Request::is('register')) {
					$title = "Create an Account";
				}
				elseif (Request::is('admin')) {
					$title = "Admin Dashboard";
				}
				elseif (Request::is('create_booking')) {
					$title = "Create a Booking";
				}
			@endphp
			@if($title)
				<h3 class="header__subtitle">{{ $title }}</h3>
			@endif
		</div>
	</div>
	
	<div class="container">
		@include('shared.session_message')
		@yield('content')
	</div>
	

</body>

</html>
