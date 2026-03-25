@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

        {{-- Back Link --}}
        <div class="mb-6">
            @if(auth()->guard('web_employee')->check())
            <a href="/medical-records"
               class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-indigo-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                All Medical Records
            </a>
            @else
            <a href="/my-records"
               class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-indigo-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                My Records
            </a>
            @endif
        </div>

        {{-- Record Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 px-8 py-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider mb-1">Medical Record</p>
                        <h1 class="text-2xl font-bold text-white">{{ $record->title }}</h1>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Meta Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 border-b border-gray-100">

                {{-- Patient --}}
                <div class="px-6 py-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Patient</p>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm">
                            {{ strtoupper(substr($record->patient->firstname ?? 'P', 0, 1)) }}
                        </div>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $record->patient->firstname ?? '–' }} {{ $record->patient->lastname ?? '' }}
                        </p>
                    </div>
                </div>

                {{-- Doctor --}}
                <div class="px-6 py-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Attending Doctor</p>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm">
                            {{ strtoupper(substr($record->doctor->firstname ?? 'D', 0, 1)) }}
                        </div>
                        <p class="text-sm font-semibold text-gray-800">
                            Dr. {{ $record->doctor->firstname ?? '–' }} {{ $record->doctor->lastname ?? '' }}
                        </p>
                    </div>
                </div>

                {{-- Date --}}
                <div class="px-6 py-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Date Created</p>
                    <div class="flex items-center gap-2 mt-2">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm font-semibold text-gray-800">{{ $record->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="px-8 py-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Clinical Notes / Description</h2>
                @if($record->description)
                    <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $record->description }}</p>
                @else
                    <p class="text-gray-400 text-sm italic">No description provided.</p>
                @endif
            </div>

            {{-- File --}}
            @if($record->file_path)
            <div class="px-8 py-6 border-t border-gray-100">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Attached File</h2>
                <a href="{{ asset('storage/' . $record->file_path) }}"
                   target="_blank"
                   class="inline-flex items-center gap-3 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 rounded-xl px-5 py-3 transition-all duration-200 group">
                    <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-indigo-700 group-hover:text-indigo-900 transition">Download / View File</p>
                        <p class="text-xs text-indigo-400">{{ basename($record->file_path) }}</p>
                    </div>
                    <svg class="w-4 h-4 text-indigo-400 ml-auto group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
            @endif

            {{-- Footer Actions --}}
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center gap-4">
                @if(auth()->guard('web_employee')->check())
                <a href="/medical-records"
                   class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                    ← All Records
                </a>
                <a href="/medical-records/create"
                   class="ml-auto inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-all duration-200">
                    + New Record
                </a>
                @else
                <a href="/my-records"
                   class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                    ← My Records
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
