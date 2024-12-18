@extends('base.base')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl p-6" style="background-color: #133E87; color: white; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="{{ isset($location) ? route('locations.updateLocation', $location->id) : route('locations.insertLocation') }}">
            @csrf
            @if(isset($location))
                @method('PUT')
                <h2 class="mb-6 text-2xl font-bold text-center">EDIT LOCATION</h2>
            @else
                @method('POST')
                <h2 class="mb-6 text-2xl font-bold text-center">ADD NEW LOCATION</h2>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium">Location Name</label>
                    <input type="text" name="name" id="name" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="e.g., Library, Cafeteria" value="{{ old('name', $location->name ?? '') }}" required>
                    @error('name')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Building -->
                <div class="md:col-span-2">
                    <label for="building" class="block mb-2 text-sm font-medium">Building</label>
                    <input type="text" name="building" id="building" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="e.g., Building A, Main Hall" value="{{ old('building', $location->building ?? '') }}" required>
                    @error('building')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-center gap-4">
                <a href="{{ route('locations.showLocationList') }}" 
                    class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-red-300">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-green-300">
                    @if(isset($location)) Update Location @else Add Location @endif
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
