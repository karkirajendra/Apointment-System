@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-8">
            <a href="/medical-records"
               class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-indigo-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Medical Records
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create Medical Record</h1>
            <p class="mt-1 text-sm text-gray-500">Fill in the patient details and upload any relevant files.</p>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            <form action="/medical-records" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Patient Select --}}
                <div>
                    <label for="patient_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Patient <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="patient_id" name="patient_id"
                                class="w-full appearance-none bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-10 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition @error('patient_id') border-red-400 bg-red-50 @enderror">
                            <option value="">— Select a patient —</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->firstname }} {{ $patient->lastname }} ({{ $patient->username }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('patient_id')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Record Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title') }}"
                           placeholder="e.g. Blood Test Results, X-Ray Report"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition @error('title') border-red-400 bg-red-50 @enderror">
                    @error('title')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                        <span class="ml-1 text-xs text-gray-400 font-normal">(optional)</span>
                    </label>
                    <textarea id="description" name="description" rows="5"
                              placeholder="Add clinical notes, diagnosis, or treatment details…"
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition resize-none @error('description') border-red-400 bg-red-50 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- File Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Attach File
                        <span class="ml-1 text-xs text-gray-400 font-normal">(PDF, JPG, PNG — max 5 MB)</span>
                    </label>
                    <label for="file"
                           class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200 group @error('file') border-red-400 @enderror">
                        <svg class="w-8 h-8 text-gray-300 group-hover:text-indigo-400 transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-sm text-gray-400 group-hover:text-indigo-500 transition">
                            Click to upload or drag &amp; drop
                        </span>
                        <input id="file" name="file" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                    </label>
                    @error('file')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 pt-2">
                    <button type="submit"
                            class="flex-1 sm:flex-none bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-sm transition-all duration-200">
                        Save Record
                    </button>
                    <a href="/medical-records"
                       class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Show selected filename
    document.getElementById('file').addEventListener('change', function () {
        const label = this.closest('label').querySelector('span');
        label.textContent = this.files[0] ? this.files[0].name : 'Click to upload or drag & drop';
    });
</script>
@endsection
