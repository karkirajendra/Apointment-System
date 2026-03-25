@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Lab Tests</h1>
                <p class="mt-1 text-sm text-gray-500">Track your lab test orders and view results.</p>
            </div>
        </div>

        @if($tests->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <h3 class="text-lg font-semibold text-gray-700">No lab tests found.</h3>
                <p class="text-sm text-gray-400 mt-2">When your doctor orders tests, they will appear here.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Test</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Doctor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tests as $t)
                            <tr class="hover:bg-indigo-50/40 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-800">{{ $t->test_name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Ordered: {{ optional($t->ordered_at)->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $t->doctor->firstname ?? '' }} {{ $t->doctor->lastname ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-gray-700 text-xs font-semibold">
                                        {{ $t->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/my-lab-tests/{{ $t->id }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

