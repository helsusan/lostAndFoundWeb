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

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">ASSIGN ITEM TO REPORT</h1>

<div class="shadow-lg rounded-lg overflow-hidden mx-6 md:mx-24 my-10 bg-[#f0f8ff]"> 
    <!-- Report Details -->
    <div class="mb-8 px-6 mt-4">
        <h2 class="text-2xl font-bold mb-2 text-[#133E87]">REPORT DETAILS</h2>
        
        <!-- Display Report Image -->
        @if ($report->image)
            <img src="{{ asset($report->image) }}" alt="Report Image" class="w-32 h-32 rounded-lg mb-4">
        @else
            <p class="text-gray-500 italic mb-4">No image available for this report.</p>
        @endif
        
        <p class="text-[#133E87] mt-2"><strong>Description:</strong> {{ $report->description }} </span></p>
        <p class="text-[#133E87] mt-2"><strong>Detail Location:</strong> {{ $report->location_lost }}</p>
        <p class="text-[#133E87] mt-2"><strong>Time Lost:</strong> {{ \Carbon\Carbon::parse($report->time_lost)->format('d-m-Y H:i:s') }}</p>
    </div>

    <!-- Item Table -->
    <div class="overflow-x-auto px-6 md:px-12 mb-5"> 
        <table id="Table" class="min-w-full table-auto border-collapse rounded-lg">
            <thead>
                <tr class="bg-[#133E87] text-left text-white"> 
                    <th class="w-1/6 py-4 px-6 border-b text-sm font-bold uppercase text-center rounded-tl-lg">Image</th>
                    <th class="w-1/6 py-4 px-6 border-b text-sm font-bold uppercase text-center">Item Name</th>
                    <th class="w-1/6 py-4 px-6 border-b text-sm font-bold uppercase text-center">Category</th>
                    <th class="w-1/6 py-4 px-6 border-b text-sm font-bold uppercase text-center">Description</th>
                    <th class="w-1/6 py-4 px-6 border-b text-sm font-bold uppercase text-center">Location Found</th>
                    <th class="w-1/6 py-4 px-6 border-b text-sm font-bold uppercase text-center">Time Found</th>
                    <th class="w-1/6 py-4 px-6 border-b text-sm font-bold uppercase text-center rounded-tr-lg">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="">
                    <td class="py-4 px-6 border-b text-center">
                        <img src="{{ asset($item->image) }}" alt="Item Image" class="w-16 h-16 rounded-lg mx-auto">
                    </td>
                    <td class="py-4 px-6 border-b text-left font-medium">{{ $item->name }}</td>
                    <td class="py-4 px-6 border-b text-left font-medium">{{ $item->itemCategory->name ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b text-left font-medium">{{ $item->description }}</td>
                    <td class="py-4 px-6 border-b text-left font-medium">{{ $item->location_found ?? 'N/A' }}</td>
                    <td class="py-4 px-6 border-b text-left font-medium">
                        {{ \Carbon\Carbon::parse($item->time_found)->format('d-m-Y H:i:s') ?? 'N/A' }}
                    </td>
                    <td class="py-4 px-6 border-b text-center">
                        <form action="{{ route('admin.assignItemToReport', $report->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 font-bold">
                                Assign
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Back Button -->
    <div class="text-center my-6">
        <a href="{{ route('admin.showAdminReport') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all">
            Back
        </a>
    </div>
</div>

<script>
    $('#Table').DataTable({
        columnDefs: [
            { orderable: false, targets: [0] }, 
        ],
    });
</script>


@endsection