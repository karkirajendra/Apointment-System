@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Add Lab Result</h1>
                <p class="mt-1 text-sm text-gray-500">Test: <span class="font-medium">{{ $test->test_name }}</span></p>
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

            <form action="/lab-tests/{{ $test->id }}/results" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Result Value</label>
                        <textarea
                            name="result_value"
                            rows="4"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800"
                            placeholder="Enter the measured value..."
                        >{{ old('result_value') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Normal Range</label>
                        <input
                            name="normal_range"
                            type="text"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800"
                            value="{{ old('normal_range') }}"
                            placeholder="e.g. 3.5 - 5.5"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Attachment (optional)</label>
                        <input type="file" name="attachment" class="w-full">
                        <p class="text-xs text-gray-500 mt-1">PDF/JPG/PNG, max 5MB.</p>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-sm">
                            Save Result
                        </button>
                        <a href="/doctor" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

