@extends('base.base')

@section('content')

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-6" style="background-color: #133E87; color: white; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <h2 class="mb-6 text-2xl font-bold text-center">LOST ITEM FORM</h2>
            <div class="grid gap-4 mb-6">
                <!-- Lost Item -->
                <div>
                    <label for="item" class="block mb-2 text-sm font-medium">Lost Item</label>
                    <input type="text" name="item" id="item" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="Enter item name" required>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block mb-2 text-sm font-medium">Category</label>
                    <select name="category" id="category" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" selected disabled>Select category</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="accessories">Accessories</option>
                        <option value="documents">Documents</option>
                        <option value="others">Others</option>
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium">Description</label>
                    <textarea name="description" id="description" rows="4" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="Write a description..." required></textarea>
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block mb-2 text-sm font-medium">Upload Photo</label>
                    <input type="file" name="photo" id="photo" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        accept="image/*" required>
                </div>

                <!-- Location Found -->
                <div>
                    <label for="location" class="block mb-2 text-sm font-medium">Location Found</label>
                    <select name="location" id="location" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" selected disabled>Select location</option>
                        <option value="library">Library</option>
                        <option value="cafeteria">Cafeteria</option>
                        <option value="parking-lot">Parking Lot</option>
                        <option value="classroom">Classroom</option>
                        <option value="others">Others</option>
                    </select>
                </div>

                <!-- Detail Location Found -->
                <div>
                    <label for="detail_location" class="block mb-2 text-sm font-medium">Detail Location Found</label>
                    <input type="text" name="detail_location" id="detail_location" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        placeholder="e.g., Table 5, near entrance" required>
                </div>

                <!-- Time Found -->
                <div>
                    <label for="time_found" class="block mb-2 text-sm font-medium">Time Found</label>
                    <input type="datetime-local" name="time_found" id="time_found" 
                        class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-center gap-4">
                <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-green-300">
                    Submit
                </button>
                <button type="button" 
                    class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-red-300">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@endsection