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

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">LIST LOCATIONS</h1>

<div class="text-right my-5 mr-20">
    <a href="{{ route('locations.createLocation') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 focus:ring-4 focus:outline-none focus:ring-green-300 inline-flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 mr-2">
            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
        </svg>
        Add New Location
    </a>
</div>

<div class="overflow-hidden mx-4 md:mx-20 my-10">
    <div class="overflow-x-auto">
        <table id="Table" class="min-w-full table-auto border-collapse rounded-lg">
            <thead>
                <tr class="bg-[#133E87] text-center text-white">
                    <th class="border-b text-sm font-bold uppercase text-center">ID</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Name</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Building</th>
                    <th class="border-b text-sm font-bold uppercase text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                    <tr>
                        <td class="border-b text-left font-medium">{{ $location->id }}</td>
                        <td class="border-b text-left font-medium">{{ $location->name }}</td>
                        <td class="border-b text-left font-medium">{{ $location->building }}</td>
                        <td class="border-b text-center">
                            <a href="{{ route('locations.editLocation', $location->id) }}" 
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 font-bold mr-2">
                               Edit
                            </a>
                            <form action="{{ route('locations.deleteLocation', $location->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteRow(this)"
                                        class="buttondelete bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-bold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#Table').DataTable({
        language: {
            emptyTable: "No locations found."
        }
    });
</script>

@endsection
