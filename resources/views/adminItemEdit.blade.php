@extends('base.base')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl p-6" style="background-color: #133E87; color: white; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <form action="{{ route('admin.updateItem', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 class="mb-6 text-2xl font-bold text-center">EDIT ITEM</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Description Field -->
                <div class="md:col-span-2">
                    <label for="description" class="block mb-2 text-sm font-medium">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        required>{{ old('description', $item->description) }}</textarea>
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label for="item_category_id" class="block mb-2 text-sm font-medium">Category</label>
                    <select name="item_category_id" id="item_category_id" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" disabled>Select category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $item->item_category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Location Found Dropdown -->
                <div>
                    <label for="location_found" class="block mb-2 text-sm font-medium">Location Found</label>
                    <select name="location_found" id="location_found" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" disabled>Select location</option>
                        @foreach ($locations as $location)
                        <option value="{{ $location->name }}" 
                            {{ $item->location_found == $location->name ? 'selected' : '' }}>
                            {{ $location->name }} - {{ $location->building }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Image Upload Field -->
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium">Upload Image</label>
                    <input type="file" id="image" name="image" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @if ($item->image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-300">Current Image:</p>
                            <img src="{{ asset($item->image) }}" alt="Current Image" class="w-32 h-32 object-cover rounded-lg mt-2">
                        </div>
                    @endif
                </div>

                <!-- Found Time Field -->
                <div>
                    <label for="time_found" class="block mb-2 text-sm font-medium">Found Time</label>
                    <input type="datetime-local" id="time_found" name="time_found" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        value="{{ old('time_found', $item->time_found ? \Illuminate\Support\Carbon::parse($item->time_found)->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-4">
                <a href="{{ route('admin.showAdminItem') }}" 
                    class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-red-300">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-green-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
