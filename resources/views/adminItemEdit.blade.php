@extends('base.base')

@section('content')

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">Edit Item</h1>

<div class="max-w-4xl mx-auto bg-[#f0f8ff] p-8 rounded-lg shadow-lg border border-[#133E87]">
    <form action="{{ route('admin.updateItem', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Description Field -->
        <div class="mb-6">
            <label for="description" class="block text-lg font-semibold text-[#133E87] mb-2">Description</label>
            <textarea id="description" name="description" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all" required>{{ old('description', $item->description) }}</textarea>
        </div>

        <!-- Detail Location Field -->
        <div class="mb-6">
            <label for="location_found" class="block text-lg font-semibold text-[#133E87] mb-2">Location Found</label>
            <input type="text" id="location_found" name="location_found" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all" value="{{ old('location_found', $item->location_found) }}">
        </div>

        <!-- Found Time Field -->
        <div class="mb-6">
            <label for="time_found" class="block text-lg font-semibold text-[#133E87] mb-2">Found Time</label>
            <input type="datetime-local" id="time_found" name="time_found" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all"
            value="{{ old('time_found', $item->time_found ? \Illuminate\Support\Carbon::parse($item->time_found)->format('Y-m-d\TH:i') : '') }}">
        </div>

        <!-- Image Field -->
        <div class="mb-6">
            <label for="image" class="block text-lg font-semibold text-[#133E87] mb-2">Image</label>
            <input type="file" id="image" name="image" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all">
            @if ($item->image)
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Current Image:</p>
                    <img src="{{ asset($item->image) }}" alt="Current Image" class="w-32 h-32 object-cover rounded-lg mt-2">
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('admin.showAdminItem') }}" class="bg-[#f25c5c] text-white px-6 py-3 rounded-lg hover:bg-[#d94a4a] font-semibold transition-all">
                Cancel
            </a>
            <button type="submit" class="bg-[#133E87] text-white px-6 py-3 rounded-lg hover:bg-[#5A9BCF] font-semibold transition-all">
                Save Changes
            </button>
        </div>
    </form>
</div>

@endsection
