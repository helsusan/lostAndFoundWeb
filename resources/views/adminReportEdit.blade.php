@extends('base.base')

@section('content')
<h1 class="text-center font-bold text-4xl my-10">Edit Report</h1>

<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <form action="{{ route('admin.updateReport', $report->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea id="description" name="description" class="w-full border rounded px-3 py-2" required>{{ old('description', $report->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="location_lost" class="block text-gray-700 font-bold mb-2">Detail Location</label>
            <input type="text" id="location_lost" name="location_lost" class="w-full border rounded px-3 py-2" value="{{ old('location_lost', $report->location_lost) }}">
        </div>

        <div class="mb-4">
            <label for="time_lost" class="block text-gray-700 font-bold mb-2">Lost Time</label>
            <input type="datetime-local" id="time_lost" name="time_lost" class="w-full border rounded px-3 py-2"
            value="{{ old('time_lost', $report->time_lost ? \Illuminate\Support\Carbon::parse($report->time_lost)->format('Y-m-d\TH:i') : '') }}">
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.showAdminReport') }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-center font-bold">
                Cancel
            </a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 font-bold">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
