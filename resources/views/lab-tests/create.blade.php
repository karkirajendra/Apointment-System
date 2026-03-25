@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order Lab Test</h1>
                <p class="mt-1 text-sm text-gray-500">Doctors can order tests and doctors/staff can later add results.</p>
            </div>
            <a href="/doctor" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                ← Back
            </a>
        </div>

        @include('shared.error_message')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @if(session('message'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-xl text-sm font-medium">
                    {{ session('message') }}
                </div>
            @endif

            <form action="/lab-tests" method="POST">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Patient <span class="text-red-500">*</span></label>
                        <select name="patient_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800" required>
                            <option value="">— Select Patient —</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->firstname }} {{ $patient->lastname }} ({{ $patient->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Booking ID (optional)</label>
                        <input
                            name="booking_id"
                            type="number"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800"
                            value="{{ old('booking_id') }}"
                            placeholder="e.g. 7"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Test Name <span class="text-red-500">*</span></label>
                        <input
                            name="test_name"
                            type="text"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800"
                            value="{{ old('test_name') }}"
                            placeholder="e.g. CBC, Blood Sugar, Urinalysis"
                            required
                        >
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-sm">
                            Order Test
                        </button>
                        <a href="/doctor" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

