@extends('base.base')

@section('content')

<h1 class="text-center font-bold text-4xl my-10 text-[#133E87]">Edit Report</h1>

<div class="max-w-4xl mx-auto bg-[#f0f8ff] p-8 rounded-lg shadow-lg border border-[#133E87] mb-8">
    <form action="{{ route('myreport.updateReport', $report->id) }}" method="POST" enctype="multipart/form-data" id="formedit">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="description" class="block text-lg font-semibold text-[#133E87] mb-2">Description</label>
            <textarea id="description" name="description" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all" required>{{ old('description', $report->description) }}</textarea>
        </div>

        <!-- location lost itu location->id (DROPDOWN) -->
        <div class="mb-6">
            <label for="location_lost" class="block text-lg font-semibold text-[#133E87] mb-2">Location Lost</label>
            <select id="location_lost" name="location_lost" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all" required>
                <option value="">Select Location Lost</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" @if($report->location_id == $location->id) selected @endif>
                        {{ $location->name }} - {{ $location->building }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- location detail itu report->location_lost (INPUTAN USER) -->
        <div class="mb-6">
            <label for="location_detail" class="block text-lg font-semibold text-[#133E87] mb-2">Location Detail</label>
            <input type="text" id="location_detail" name="location_detail" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all" value="{{ old('location_detail', $report->location_lost) }}">
        </div>

        <input type="hidden" name="time_lost" value="{{ $report->time_lost }}">

        <div class="mb-6">
            <label for="image" class="block text-lg font-semibold text-[#133E87] mb-2">Image</label>
            <input type="file" id="image" name="image" class="w-full border border-[#5A9BCF] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#133E87] transition-all">
            @if ($report->image)
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Current Image:</p>
                    <img src="{{ asset($report->image) }}" alt="Current Image" class="w-32 h-32 object-cover rounded-lg mt-2">
                </div>
            @endif
        </div>

        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('myreport.showReports') }}" class="bg-[#f25c5c] text-white px-6 py-3 rounded-lg hover:bg-[#d94a4a] font-semibold transition-all">
                Cancel
            </a>
            <button type="submit" class="bg-[#133E87] text-white px-6 py-3 rounded-lg hover:bg-[#5A9BCF] font-semibold transition-all">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    // $('#formedit').on('submit', function(e) {
    //     e.preventDefault();
    //     $dataa = new FormData(this);
    //     console.log($dataa);
    //     $.ajax({
    //         url: '{{ route('myreport.updateReport', $report->id)}}',
    //         method: "PUT",
    //         data: $dataa,
    //         contentType: false,
    //         processData: false,
    //         dataType: "json",
    //         success: function(response) {
    //             alert()
    //             // console.log(response);
    //             // window.location.href="{{route('myreport.showReports')}}"
    //         },
    //         error: function(xhr, status, error) {
    //             console.log(xhr);
    //             console.log(status);
    //             console.log(error);
    //         }
    //     });
    // });
</script>

@endsection
