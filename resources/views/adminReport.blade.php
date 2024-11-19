@extends('base.base')

@section('content')

<h1 class="text-center font-bold text-4xl my-10">Report Request</h1>

<div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-20 my-10">
    <table class="min-w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">ID</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Item</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">User</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Location</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Status</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Description</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Image</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Verified</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Lost Location</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Lost Time</th>
                <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Created At</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($reports as $report)
            <tr class="hover:bg-gray-50">
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->id }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->item->name ?? 'N/A' }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->user->name ?? 'N/A' }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->location->name ?? 'N/A' }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->reportStatus->name ?? 'N/A' }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->description }}</td>
                <td class="py-4 px-6 border-b border-gray-200">
                    @if ($report->image)
                        <img src="{{ asset($report->image) }}" alt="Image" width="50" class="rounded-lg">
                    @else
                        N/A
                    @endif
                </td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->is_verified ? 'Yes' : 'No' }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->location_lost }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->time_lost }}</td>
                <td class="py-4 px-6 border-b border-gray-200">{{ $report->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
