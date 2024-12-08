@extends('base.base')

@section('content')

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">List Items</h1>

<div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-20 my-10 bg-[#f0f8ff]"> <!-- Background lembut -->
    <div class="overflow-x-auto"> <!-- Pembungkus untuk responsivitas -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-[#133E87] text-left text-white"> <!-- Header warna biru tua -->
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">ID</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Image</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Owner</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Item Name</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Item Category</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Description</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Location Found</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Time Found</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase">Status</th>
                    <th class="w-1/12 py-4 px-6 border-b text-sm font-bold uppercase text-center">Action</th> <!-- Heading Action ditambahkan text-center -->
                </tr>
            </thead>
            <tbody>
                @if($items->isEmpty()) <!-- Check if items are empty -->
                    <tr>
                        <td colspan="11" class="py-4 px-6 text-center text-[#003366] font-medium">
                            Table is empty. No items found.
                        </td>
                    </tr>
                @else
                    @foreach($items as $item)
                    <tr class="@if($loop->even) bg-[#5A9BCF] @else bg-[#a9c6ff] @endif hover:bg-[#5A9BCF]">
                        <td class="py-4 px-6 border-b text-center text-[#003366] font-medium">{{ $item->id }}</td>
                        <td class="py-4 px-6 border-b text-center">
                            @if ($item->image)
                                <img src="{{ asset($item->image) }}" alt="Image" class="rounded-lg cursor-pointer max-w-[120px] max-h-[120px] mx-auto"
                                     onclick="showModal('{{ asset($item->image) }}')">
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-4 px-6 border-b text-[#003366] font-medium">{{ $item->user->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-[#003366] font-medium">{{ $item->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-[#003366] font-medium">{{ $item->itemCategory->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-[#003366] font-medium">{{ $item->description ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-[#003366] font-medium">{{ $item->location_found ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-[#003366] font-medium">{{ $item->time_found ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-[#003366] font-medium">
                        <select class="item-status-dropdown bg-[#f0f8ff] text-[#003366] py-2 px-4 rounded w-full min-w-[120px] text-sm" data-item-id="{{ $item->id }}">
                            <option value="2" @if($item->item_status_id == 2) selected @endif>Pending</option>
                            <option value="1" @if($item->item_status_id == 1) selected @endif>Returned</option>
                            <option value="3" @if($item->item_status_id == 3) selected @endif>Disposed</option>
                        </select>
                        </td>
                        <td class="py-4 px-6 border-b text-center flex flex-col space-y-2">
                            <a href="{{ route('admin.editItem', $item->id) }}" class="flex items-center justify-center bg-[#f3cf56] hover:bg-[#e6be40] text-[#003366] font-bold px-4 py-2 rounded">
                                Edit
                            </a>

                            <form action="{{ route('admin.deleteItem', $item->id) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-center bg-[#f25c5c] hover:bg-[#d94a4a] text-[#003366] font-bold px-4 py-2 rounded">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="relative bg-white rounded-lg p-4 w-11/12 max-w-4xl">
        <button type="button" class="absolute top-2 right-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
            onclick="closeModal()">
            <strong>✕</strong>
        </button>
        <img id="modalImage" src="" alt="Image Preview" class="w-full max-h-[70vh] rounded-lg object-contain">
    </div>
</div>

<script>
    // Show modal for image preview
    function showModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
    }

    // Close modal
    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }

    // Handle dropdown change for itemStatus
    document.querySelectorAll('.item-status-dropdown').forEach(function (select) {
        select.addEventListener('change', function () {
            const itemId = this.getAttribute('data-item-id');
            const itemStatus = this.value;

            fetch(`/items/update-item-status/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ item_status: itemStatus }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert('Item status updated successfully!');
                    } else {
                        alert(data.message || 'Failed to update item status.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the item status.');
                });
        });
    });
</script>

@endsection
