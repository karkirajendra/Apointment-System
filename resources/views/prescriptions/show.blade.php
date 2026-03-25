@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="/my-prescriptions" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                ← Back to Prescriptions
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Prescription Details</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 px-8 py-6">
                <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider">Diagnosis</p>
                <h2 class="text-2xl font-bold text-white mt-2">{{ $prescription->diagnosis ?: 'Prescription' }}</h2>
            </div>

            <div class="p-8 space-y-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Doctor</h3>
                    <p class="text-gray-800 text-sm">
                        Dr. {{ $prescription->doctor->firstname ?? '' }} {{ $prescription->doctor->lastname ?? '' }}
                    </p>
                </div>

                @if($prescription->booking)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Linked Appointment</h3>
                        <p class="text-gray-800 text-sm">
                            {{ toDate($prescription->booking->date, true) }} at {{ toTime($prescription->booking->start_time, false) }}
                        </p>
                    </div>
                @endif

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Medications</h3>
                    <pre class="text-sm text-gray-800 whitespace-pre-wrap bg-gray-50 border border-gray-100 rounded-xl p-4">{{ $prescription->medications }}</pre>
                </div>

                @if($prescription->notes)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Notes</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $prescription->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

