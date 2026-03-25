@extends('layouts.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Prescriptions</h1>
                <p class="mt-1 text-sm text-gray-500">View your doctor-issued prescriptions.</p>
            </div>
        </div>

        @if($prescriptions->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <h3 class="text-lg font-semibold text-gray-700">No prescriptions found.</h3>
                <p class="text-sm text-gray-400 mt-2">When your doctor creates prescriptions, they will appear here.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Doctor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($prescriptions as $p)
                            <tr class="hover:bg-indigo-50/40 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-800">{{ $p->diagnosis ?: 'Prescription' }}</div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit($p->medications, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $p->doctor->firstname ?? '' }} {{ $p->doctor->lastname ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/my-prescriptions/{{ $p->id }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
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

