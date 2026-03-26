@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto p-4">
    <div class="bg-white shadow rounded-lg p-5 mb-5">
        <h1 class="text-3xl font-bold">Doctor Dashboard</h1>
        <p class="text-gray-600 mt-1">Welcome back, Dr. {{ $employee->firstname }} {{ $employee->lastname }}.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-5">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-xs uppercase tracking-wide text-blue-700">Appointments (7d)</h3>
            <p class="text-3xl font-semibold text-blue-900">{{ $weeklyAppointments ?? 0 }}</p>
            <p class="text-xs text-blue-600 mt-1">Scheduled</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h3 class="text-xs uppercase tracking-wide text-green-700">Medical Records</h3>
            <p class="text-3xl font-semibold text-green-900">{{ $medicalRecords ?? 0 }}</p>
            <p class="text-xs text-green-600 mt-1">Created</p>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <h3 class="text-xs uppercase tracking-wide text-purple-700">Prescriptions</h3>
            <p class="text-3xl font-semibold text-purple-900">{{ $prescriptions ?? 0 }}</p>
            <p class="text-xs text-purple-600 mt-1">Issued</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="text-xs uppercase tracking-wide text-yellow-700">Pending Lab Tests</h3>
            <p class="text-3xl font-semibold text-yellow-900">{{ $pendingLabTests ?? 0 }}</p>
            <p class="text-xs text-yellow-600 mt-1">Awaiting results</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden mb-5">
        <div class="border-b px-4 py-3 bg-gray-50">
            <h2 class="text-lg font-semibold">Upcoming Appointments</h2>
            <p class="text-sm text-gray-600">Next 6 appointments</p>
        </div>
        <div class="p-4">
            @if(isset($upcomingBookings) && $upcomingBookings->count())
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr class="text-left text-gray-700 uppercase text-xs tracking-wide">
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Time</th>
                        <th class="px-3 py-2">Patient</th>
                        <th class="px-3 py-2">Activity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($upcomingBookings as $booking)
                    <tr>
                        <td class="px-3 py-2">{{ $booking->date }}</td>
                        <td class="px-3 py-2">{{ $booking->start_time }} &ndash; {{ $booking->end_time }}</td>
                        <td class="px-3 py-2">{{ optional($booking->customer)->firstname ?? 'Unknown' }} {{ optional($booking->customer)->lastname ?? '' }}</td>
                        <td class="px-3 py-2">{{ optional($booking->activity)->name ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center text-gray-600 py-12">
                <p>No upcoming appointments available. Check your schedule or add a booking.</p>
            </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h3 class="text-lg font-semibold">Medical Actions</h3>
            <ul class="mt-3 space-y-2 text-gray-700 text-sm">
                <li><a class="font-medium text-blue-600 hover:text-blue-700" href="/medical-records">View Medical Records</a></li>
                <li><a class="font-medium text-blue-600 hover:text-blue-700" href="/medical-records/create">Create Medical Record</a></li>
                <li><a class="font-medium text-blue-600 hover:text-blue-700" href="/prescriptions/create">Issue Prescription</a></li>
                <li><a class="font-medium text-blue-600 hover:text-blue-700" href="/lab-tests/create">Order Lab Test</a></li>
            </ul>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h3 class="text-lg font-semibold">Quick Insights</h3>
            <p class="text-sm text-gray-600 mt-2">Track your daily performance at a glance and ensure patients are attended on time.</p>
            <div class="mt-4 grid grid-cols-2 gap-2 text-center">
                <div class="bg-green-100 text-green-800 rounded py-2">{{ $medicalRecords ?? 0 }} records</div>
                <div class="bg-purple-100 text-purple-800 rounded py-2">{{ $prescriptions ?? 0 }} prescriptions</div>
                <div class="bg-blue-100 text-blue-800 rounded py-2">{{ $weeklyAppointments ?? 0 }} this week</div>
                <div class="bg-yellow-100 text-yellow-800 rounded py-2">{{ $pendingLabTests ?? 0 }} pending labs</div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h3 class="text-lg font-semibold">Support</h3>
            <p class="text-sm text-gray-700 mt-2">Need assistance with system updates, workflows, or patients? Reach out to administration for priority support.</p>
            <p class="text-xs text-gray-500 mt-3">support@example.com | +1 555 123 456</p>
        </div>
    </div>
</div>
@endsection
