@extends('base.base')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl p-6 bg-[#133E87] text-white rounded-lg shadow-lg">
        <form action="{{ route('admin.assignItem', $item->id) }}" method="POST">
            @csrf

            <h2 class="mb-6 text-2xl font-bold text-center">ASSIGN ITEM</h2>

            <!-- nama owner -->
            <div class="mb-6">
                <label for="owner_name" class="block mb-2 text-sm font-medium">Owner Name</label>
                <select id="owner_name" name="owner_name" 
                    class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="" disabled selected>Select Owner</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('owner_name') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('owner_name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- status -->
            <div class="mb-6">
                <label for="status" class="block mb-2 text-sm font-medium">Status</label>
                <select name="status" id="status" class="bg-white text-gray-900 text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="pending" @if($item->status == 'pending') selected @endif>Pending</option>
                    <option value="returned" @if($item->status == 'returned') selected @endif>Returned</option>
                    <option value="disposed" @if($item->status == 'disposed') selected @endif>Disposed</option>
                </select>
            </div>

            <div class="flex justify-center gap-4">
                <!-- cancel -->
                <a href="{{ route('admin.showAdminItem') }}" 
                    class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-red-300">
                    Cancel
                </a>
                <!-- save -->
                <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-green-300">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
