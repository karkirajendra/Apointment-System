@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="/my-lab-tests" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                ← Back to Lab Tests
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ $test->test_name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Status: <span class="font-semibold">{{ $test->status }}</span></p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-indigo-500">
                <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider">Doctor</p>
                <p class="text-white font-semibold mt-1">
                    Dr. {{ $test->doctor->firstname ?? '' }} {{ $test->doctor->lastname ?? '' }}
                </p>
                <p class="text-indigo-100 text-sm mt-1">
                    Ordered: {{ optional($test->ordered_at)->format('d M Y, h:i A') }}
                </p>
            </div>

            <div class="p-8 space-y-6">
                @if($test->results->isEmpty())
                    <div class="border border-dashed border-gray-200 rounded-xl p-6 text-center">
                        <p class="text-gray-700 font-semibold">No results yet.</p>
                        <p class="text-sm text-gray-500 mt-1">You will see results when your lab finishes processing.</p>
                    </div>
                @else
                    @foreach($test->results as $r)
                        <div class="border border-gray-100 rounded-xl p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Result</p>
                                    @if($r->result_value)
                                        <pre class="mt-2 text-sm text-gray-700 whitespace-pre-wrap">{{ $r->result_value }}</pre>
                                    @else
                                        <p class="text-sm text-gray-400 mt-2">No value provided.</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Date</p>
                                    <p class="text-sm text-gray-700">{{ optional($r->result_at)->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>

                            @if($r->normal_range)
                                <div class="mt-4">
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Normal Range</p>
                                    <p class="text-sm text-gray-700">{{ $r->normal_range }}</p>
                                </div>
                            @endif

                            @if($r->attachment_path)
                                <div class="mt-4">
                                    <a href="{{ asset('storage/' . $r->attachment_path) }}" target="_blank"
                                       class="inline-flex items-center gap-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold px-4 py-2 rounded-xl border border-indigo-100">
                                        View Attachment
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

