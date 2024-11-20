@extends('base.base')

@section('content')

<h1 class="text-center font-bold text-4xl my-10">Report Request</h1>

<div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-20 my-10">
    <div class="overflow-x-auto"> <!-- Pembungkus untuk responsivitas -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">ID</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Image</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Contact person</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Description</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Location</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Detail Location</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Lost Time</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Status</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Item Status</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Verified</th>
                    <th class="w-1/6 py-4 px-6 border-b text-gray-600 font-bold uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($reports as $report)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->id }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">
                        @if ($report->image)
                            <img src="{{ asset($report->image) }}" alt="Image" width="50" class="rounded-lg cursor-pointer"
                                 onclick="showModal('{{ asset($report->image) }}')">
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->user->name ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->description ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->location->name ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->location_lost ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->time_lost ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->repostStatus->name ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->item->name ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">{{ $report->is_verified ? 'Yes' : 'No' }}</td>
                    <td class="py-4 px-6 border-b border-gray-200">
                        @if (!$report->is_verified)
                            <form action="{{ route('admin.isVerified', $report->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                    Verify
                                </button>
                            </form>
                        @else
                        <button type="submit" class="bg-gray-500 text-white hover:bg-gray-400 px-4 py-2 rounded" disabled='disabled'>Verified</button>
                        @endif
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
