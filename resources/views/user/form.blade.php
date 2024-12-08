@extends('base.base')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl p-6" style="background-color: #133E87; color: white; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="{{ route('user.insertReport')}}" enctype="multipart/form-data">
            @csrf
            @method('post')
            <h2 class="mb-6 text-2xl font-bold text-center">REPORT FORM</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block mb-2 text-sm font-medium">Description</label>
                    <textarea name="description" id="description" rows="4" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="Write a description..." required></textarea>
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium">Upload Image</label>
                    <input type="file" name="image" id="image" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        accept="image/*" required>
                </div>

                <!-- Location Found -->
                <div>
                    <label for="location" class="block mb-2 text-sm font-medium">Location Lost</label>
                    <select name="location" id="location" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" selected disabled>Select location</option>
                        @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }} - {{ $location->building }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Detail Location Found -->
                <div>
                    <label for="location_lost" class="block mb-2 text-sm font-medium">Detail Location Lost</label>
                    <input type="text" name="location_lost" id="location_lost" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="e.g., Table 5, near entrance" required>
                </div>

                <!-- Time Found -->
                <div>
                    <label for="time_lost" class="block mb-2 text-sm font-medium">Time Lost</label>
                    <input type="datetime-local" name="time_lost" id="time_lost" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-center gap-4">
                <button type="button" 
                    class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-red-300">
                    Cancel
                </button>
                <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-green-300">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection