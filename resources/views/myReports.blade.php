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
</style>


<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">My Reports</h1>

<div class="overflow-hidden mx-4 md:mx-10 my-10">
    <div class="overflow-x-auto">
        <table id="Table" class="min-w-full table-auto border-collapse rounded-lg">
            <thead>
                <tr class="bg-[#133E87] text-left text-white">
                    <th class="border-b text-sm font-bold uppercase text-center">NO</th> 
                    <th class="border-b text-sm font-bold uppercase text-center">Image</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Description</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Location Lost</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Location Detail</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Time Lost</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Status</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($reports->isEmpty())
                    <tr>
                        <td colspan="6" class="py-4 px-6 text-center text-white font-medium">
                            You have no reports yet.
                        </td>
                    </tr>
                @else
                    @foreach($reports as $report)
                    <tr class="">
                        <td class="py-4 px-6 border-b text-left font-medium">{{ $loop->iteration }}</td> 
                        <td class="py-4 px-6 border-b text-left">
                            @if ($report->image)
                                <img src="{{ asset($report->image) }}" alt="Image" class="rounded-lg cursor-pointer max-w-[120px] max-h-[120px] mx-auto"
                                     onclick="showModal('{{ asset($report->image) }}')">
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-4 px-6 border-b font-medium">{{ $report->description ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b font-medium text-left">
                            {{ $report->location->name ?? 'N/A' }} - {{ $report->location->building ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-6 border-b font-medium text-left">{{ $report->location_lost ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b font-medium text-center">{{ $report->time_lost ?? 'N/A' }}</td>
                        <td class="py-4 px-6 border-b font-medium text-center">
                            @if($report->reportStatus->id == 1)
                                <div class="found">Found</div>
                            @else
                                <div class="notfound">Not Found</div>
                            @endif
                        </td>
                        <td class="py-4 px-6 border-b text-center">
                            <div class="flex flex-col items-center gap-2">
                                
                                @if($report->reportStatus->id == 2)
                                <form id="findform" action="{{ route('myreport.foundReport', $report->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button onclick="findReport(this)" data-id="{{$report->id }}" type="submit" id="findbutton" class="flex items-center justify-start bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 min-w-[120px] font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:8px;" height="14" width="14" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                                        Found!
                                    </button>
                                </form>
                                @endif
                                
                                @if($report->is_verified === 0 && $report->reportStatus->id == 2)
                            
                                <form action="{{ route('myreport.editReport', $report->id) }}" method="GET">
                                    <button type="submit" class="flex items-center justify-start bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded min-w-[120px] font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931ZM18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        Edit
                                    </button>
                                </form>

                                <form action="{{ route('myreport.deleteReport', $report->id) }}" method="POST" class="w-auto" id="formdelete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deleteRow(this)" class="buttondelete flex items-center justify-start bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded min-w-[120px] font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

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

    function findReport(button){
        var id = button.data('id');
        console.log(id);
    }

    document.getElementsByClassName("buttondelete").onclick = deleteRow;
    function deleteRow(button) {
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
                button.parentElement.submit();
            }
        });
    } 
</script>

@endsection
