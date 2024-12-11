@extends('base.base')

@section('content')

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">LIST ITEMS</h1>

<div class="text-right my-5 mr-20">
    <a href="{{ route('admin.createItem') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-green-300 inline-flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 mr-2">
            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
        </svg>
        Add New Item
    </a>
</div>


<div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-20 my-10 bg-[#f0f8ff]">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-[#133E87] text-left text-white">
                <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">ID</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Image</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Owner</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Item Name</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Item Category</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Description</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Location Found</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Location Detail</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Time Found</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Status</th>
                    <th class="w-1/12 py-4 px-6 text-sm font-bold uppercase text-center border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($items->isEmpty())
                    <tr>
                        <td colspan="10" class="py-4 px-6 text-center text-white font-medium">
                            Table is empty. No items found.
                        </td>
                    </tr>
                @else
                    @foreach($items as $item)
                    <tr class="@if($loop->even) bg-[#133E87] @else bg-[#a9c6ff] @endif hover:bg-[#5A9BCF] border-b @if($loop->last) border-0 @endif" style="height: 170px;">
                        <td class="py-4 px-6 text-center @if($loop->odd) text-[#003366] @else text-white @endif font-medium">{{ $item->id }}</td>
                        <td class="py-4 px-6 text-center align-middle" style="width: 150px; height: 150px;">
                            @if ($item->image)
                                <img src="{{ asset($item->image) }}" alt="Image" class="rounded-lg cursor-pointer max-w-[120px] max-h-[120px] mx-auto object-contain"
                                    onclick="showModal('{{ asset($item->image) }}')">
                            @else
                                N/A
                            @endif
                        </td>

                        <td class="py-4 px-6 text-center @if($loop->odd) text-[#003366] @else text-white @endif font-medium">{{ $item->user->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 text-center @if($loop->odd) text-[#003366] @else text-white @endif font-medium">{{ $item->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 text-center @if($loop->odd) text-[#003366] @else text-white @endif font-medium">{{ $item->itemCategory->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 text-center @if($loop->odd) text-[#003366] @else text-white @endif font-medium">{{ $item->description ?? 'N/A' }}</td>
                        <td class="py-4 px-6 @if($loop->odd) text-[#003366] @else text-white @endif font-medium text-center">{{ $item->location->name ?? 'N/A' }} - {{ $item->location->building ?? 'N/A' }}</td>
                        <td class="py-4 px-6 text-center @if($loop->odd) text-[#003366] @else text-white @endif font-medium">{{ $item->location_found ?? 'N/A' }}</td>
                        <td class="py-4 px-6 text-center @if($loop->odd) text-[#003366] @else text-white @endif font-medium">{{ $item->time_found ?? 'N/A' }}</td>
                        <td class="py-4 px-6 text-center">
                            <select class="item-status-dropdown bg-[#f0f8ff] text-[#003366] py-2 px-4 rounded w-full min-w-[120px] text-sm" data-item-id="{{ $item->id }}">
                                <option value="2" @if($item->item_status_id == 2) selected @endif>Pending</option>
                                <option value="1" @if($item->item_status_id == 1) selected @endif>Returned</option>
                                <option value="3" @if($item->item_status_id == 3) selected @endif>Disposed</option>
                            </select>
                        </td>
                        <td class="py-4 px-6 text-center flex flex-col space-y-2">
                            <a href="{{ route('admin.editItem', $item->id) }}" class="flex items-center justify-start bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded font-bold mt-6 focus:ring-4 focus:ring-yellow-300 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931ZM18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit
                            </a>

                            <form action="{{ route('admin.deleteItem', $item->id) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="button-delete flex items-center justify-start bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold focus:ring-4 focus:ring-red-300 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Item status updated successfully!',
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to update item status.',
                        });
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the item status.',
                    });
                });
        });
    });


    // Tambahkan event listener ke tombol delete
    document.querySelectorAll('.button-delete').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Cegah pengiriman form otomatis
            const form = this.closest('form'); // Cari elemen form terdekat

            Swal.fire({
                title: 'Are you sure?',
                text: "Deleted data cannot be reverted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika pengguna mengonfirmasi
                }
            });
        });
    });
</script>

@endsection
