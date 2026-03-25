@extends('layouts.dashboard')

@section('content')
<div class="dash__block">
	<h1 class="dash__header">Reporting & Analytics</h1>
	<h4 class="dash__description">Basic stats for patients, appointments, and revenue.</h4>
	@include('shared.session_message')

	<div class="row" style="margin-top:20px;">
		<div class="col-sm-4">
			<div class="block">
				<h2 style="margin-top:0;">{{ $stats['totalPatients'] }}</h2>
				<p class="main_description">Total Patients</p>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="block">
				<h2 style="margin-top:0;">{{ $stats['totalAppointments'] }}</h2>
				<p class="main_description">Total Appointments</p>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="block">
				<h2 style="margin-top:0;">${{ number_format($stats['totalRevenue'], 2) }}</h2>
				<p class="main_description">Revenue (Payments)</p>
			</div>
		</div>
	</div>

	<hr>

	<div class="block">
		<h3 class="dash__header" style="margin-top:0;">Revenue by Month</h3>
		<canvas id="revenueChart" height="110"></canvas>
		<p class="text-muted" style="margin-top:8px;">
			Showing payments from {{ $stats['start']->format('d M Y') }} to {{ $stats['end']->format('d M Y') }}.
		</p>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		const ctx = document.getElementById('revenueChart').getContext('2d');
		const labels = @json($stats['revenueByMonth']['labels']);
		const values = @json($stats['revenueByMonth']['values']);

		new Chart(ctx, {
			type: 'line',
			data: {
				labels: labels,
				datasets: [{
					label: 'Revenue',
					data: values,
					borderColor: '#4f46e5',
					backgroundColor: 'rgba(79, 70, 229, 0.1)',
					tension: 0.25,
					fill: true,
				}]
			},
			options: {
				responsive: true,
				plugins: {
					legend: { display: true },
				},
				scales: {
					y: { beginAtZero: true }
				}
			}
		});
	</script>
</div>
@endsection

