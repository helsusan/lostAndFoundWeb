@extends('base.base')

@section('content')

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">ITEM DETAILS</h1>

<div class="max-w-4xl mx-auto bg-[#f0f8ff] p-8 rounded-lg shadow-lg border border-[#133E87]">
    <div class="p-6">
        <img src="{{ asset($item->image) }}" alt="Item Image" class="w-1/2 mx-auto rounded-lg">

        <h2 class="text-2xl font-bold mt-4 text-[#133E87]">{{ $item->name }}</h2>
        <p class="text-[#133E87] mt-2 font-bold">Category:  <span class="font-normal">{{ $item->itemCategory->name ?? 'N/A' }}</span></p>
        <p class="text-[#133E87] mt-2 font-bold">Description: <span class="font-normal">{{ $item->description }}</span></p>
        <p class="text-[#133E87] mt-2 font-bold">Location Found: <span class="font-normal">{{ $item->location_found ?? 'N/A' }}</span></p>
        <p class="text-[#133E87] mt-2 font-bold">Time Found: <span class="font-normal">{{ $item->time_found ?? 'N/A' }}</span></p>

        <div class="mt-6 flex justify-end gap-4">
            <a href="{{ route('admin.showAdminReport') }}" class="bg-[#f25c5c] text-white px-6 py-3 rounded-lg hover:bg-[#d94a4a] font-semibold transition-all">
                Back
            </a>
        </div>
    </div>
</div>

@endsection
