@extends('layouts.master')

@section('content')
<div class="max-w-6xl mx-auto p-4">
    <div class="bg-white shadow rounded-lg p-5 mb-5">
        <h1 class="text-3xl font-bold">Staff Dashboard</h1>
        <p class="text-gray-600 mt-1">Welcome back, {{ $employee->firstname }} {{ $employee->lastname }} ({{ optional($employee->role)->name ?? 'Staff' }}).</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm uppercase tracking-wide text-blue-700">Next 7 days</h3>
            <p class="text-3xl font-semibold text-blue-900">{{ $weeklyCount ?? 0 }}</p>
            <p class="text-sm text-blue-600 mt-1">Appointments</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <h3 class="text-sm uppercase tracking-wide text-green-700">Upcoming Appointments</h3>
            <p class="text-3xl font-semibold text-green-900">{{ $totalFuture ?? 0 }}</p>
            <p class="text-sm text-green-600 mt-1">Future bookings</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="text-sm uppercase tracking-wide text-yellow-700">Quick actions</h3>
            <ul class="mt-2 space-y-1 text-sm text-yellow-900">
                <li><a class="underline" href="/bookings">View all bookings</a></li>
                <li><a class="underline" href="/bookings/{{ toMonthYear(now()) }}/new">Create booking</a></li>
                <li><a class="underline" href="/dashboard">Go to dashboard redirect</a></li>
            </ul>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="border-b px-4 py-3 bg-gray-50">
            <h2 class="text-lg font-semibold">Upcoming Appointments</h2>
            <p class="text-sm text-gray-600">Showing next 6 appointments for your account</p>
        </div>
        <div class="p-4">
            @if(isset($upcomingBookings) && $upcomingBookings->count())
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr class="text-left text-gray-700 uppercase text-xs tracking-wide">
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Time</th>
                        <th class="px-3 py-2">Customer</th>
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
                <p>No upcoming appointments yet. Check back soon or create one.</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
            <h3 class="font-semibold">Staff Resources</h3>
            <p class="text-sm text-indigo-700 mt-1">Your daily tasks and workflows are just one click away.</p>
            <a class="inline-block mt-3 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700" href="/bookings">Manage Bookings</a>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold">Help</h3>
            <p class="text-sm text-gray-700 mt-1">Contact admin if you need schedule or permissions updates.</p>
            <p class="text-sm text-gray-500 mt-2">Email: support@example.com</p>
        </div>
    </div>
</div>
@endsection

