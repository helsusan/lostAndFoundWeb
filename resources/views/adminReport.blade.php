@extends('base.base')

@section('content')

<style>
    tr:nth-child(odd) td {
        background-color: #a9c6ff;
        color: #003366;
    }

    tr:hover td {
        background-color: #5A9BCF;
    }

    tr:nth-child(even) td {
        background-color: #133E87;
        color: #ffffff;
    }

    tr:nth-child(even):hover td {
        background-color: #5A9BCF;
    }

    .rounded-lg {
        overflow: hidden; 
    }

    .bg-gray-500.cursor-not-allowed:disabled {
    background-color: #6B7280; 
    cursor: not-allowed;
    }

    select {
        appearance: none;
        padding: 8px 12px;
        margin: 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill-rule='evenodd' d='M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z' clip-rule='evenodd'/%3E%3C/svg%3E") no-repeat right 12px center;
        background-size: 12px;
        width: 180px;
    }

    input[type="number"] {
        -moz-appearance: textfield;
        appearance: none;
        padding: 10px;
        width: 180px;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

</style>

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">REPORT REQUEST</h1>

<div class="overflow-hidden mx-4 md:mx-20 my-10"> 
    <div class="overflow-x-auto"> 
        <table id="Table" class="min-w-full table-auto border-collapse rounded-lg">
            <thead>
                <tr class="bg-[#133E87] text-center text-white"> 
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">ID</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Image</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Contact Person</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Description</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Location</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Location Detail</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Time Lost</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Status</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Item Status</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Verified</th>
                    <th class="py-4 px-6 border-b text-sm font-bold uppercase text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td class="py-4 px-6 border-b text-left font-medium">{{ $report->id }}</td>
                        <td class="py-4 px-6 border-b">
                            @if ($report->image)
                                <img src="{{ asset($report->image) }}" alt="Image" class="rounded-lg cursor-pointer max-w-[120px] max-h-[120px] mx-auto"
                                     onclick="showModal('{{ asset($report->image) }}')">
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-4 px-6 border-b text-left font-medium">{{ $report->user->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b font-medium">{{ $report->description ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-left font-medium">{{ $report->location->name ?? 'N/A' }} - {{ $report->location->building ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-left font-medium">{{ $report->location_lost ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-center font-medium">{{ $report->time_lost ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-left font-medium">{{ $report->reportStatus->name ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b text-left">
                        <div class="flex flex-col items-center gap-2">
                            @if (is_null($report->item_id))
                                <a href="{{ route('admin.showAssignPage', $report->id) }}" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-bold">
                                    Assign
                                </a>
                            @else
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('admin.detailItem', $report->item_id) }}" 
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-bold">
                                        Detail
                                    </a>
                                    
                                    <form action="{{ route('admin.cancelAssignItem', $report->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-bold w-full 
                                                @if($report->item && $report->item->item_status_id == 1) bg-gray-500 cursor-not-allowed @endif"
                                                @if($report->item && $report->item->item_status_id == 1) disabled="disabled" @endif>
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 border-b text-left font-medium">{{ $report->is_verified ? 'Yes' : 'No' }}</td>
                        <td class="py-4 px-6 border-b text-center">
                            <div class="flex flex-col items-center gap-2">
                                @if (!$report->is_verified)
                                    <form action="{{ route('admin.isVerified', $report->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="flex items-center justify-start bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Verify
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="flex items-center justify-start bg-gray-500 text-white px-4 py-2 rounded-lg w-full font-bold" disabled="disabled">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Verified
                                    </button>
                                @endif

                                <a href="{{ route('admin.editReport', $report->id) }}" class="flex items-center justify-start bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg w-full font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931ZM18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Edit
                                </a>

                                <form action="{{ route('admin.deleteReport', $report->id) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deleteRow(this)" class="buttondelete flex items-center justify-start bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg w-full font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
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
    $('#Table').DataTable({
        columnDefs: [
            { orderable: false, targets: [1] },
        ],
        language: {
            emptyTable: "You have no reports yet."
        }
    });

    function showModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }
</script>

@endsection
