@extends('layouts.master')

@section('content')
	@if (!BusinessOwner::first())
		
	@endif
	@if (session('error'))
		<div class="alert alert-danger">
			{{ session('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>
	@endif
	
	<div class="block request" style="max-width: 450px; margin: 2rem auto;">
		<div class="text-center" style="margin-bottom: 2rem;">
			<h1 class="dash__header">Welcome Back</h1>
			<h4 class="dash__description">Sign in to your account</h4>
		</div>

		<form class="request__form" method="POST" action="/login">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label for="inputUsername">Username</label>
				<input type="text" name="username" id="inputUsername" class="form-control request__input" placeholder="Username" autofocus>
			</div>
			<div class="form-group" style="margin-bottom: 2rem;">
				<label for="inputPassword">Password</label>
				<input type="password" name="password" id="inputPassword" class="form-control request__input" placeholder="Password">
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign In</button>
		</form>
		
		<hr style="margin: 2rem 0;">
		
		<div style="display: flex; flex-direction: column; gap: 0.75rem;">
			<a class="btn btn-lg btn-secondary btn-block" href="/register">Create Patient Account</a>
			<a class="btn btn-lg btn-secondary btn-block" href="/register/doctor-staff" style="background: #f1f5f9;">Doctor / Staff Registration</a>
		</div>
	</div>
@endsection