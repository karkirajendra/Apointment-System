@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create Prescription</h1>
                <p class="mt-1 text-sm text-gray-500">Doctors can write an electronic prescription for a patient.</p>
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

            <form action="/prescriptions" method="POST">
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
                            placeholder="e.g. 5"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Diagnosis (optional)</label>
                        <input
                            name="diagnosis"
                            type="text"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800"
                            value="{{ old('diagnosis') }}"
                            placeholder="e.g. Common cold"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Medications <span class="text-red-500">*</span></label>
                        <textarea
                            name="medications"
                            rows="6"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800"
                            placeholder="List medications, dosage, frequency..."
                            required
                        >{{ old('medications') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (optional)</label>
                        <textarea
                            name="notes"
                            rows="4"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800"
                            placeholder="Additional instructions..."
                        >{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-sm">
                            Save Prescription
                        </button>
                        <a href="/doctor" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

