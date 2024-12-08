<head>
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>

@extends('base.base')

@section('home')

<!-- Carousel -->
<div class="container mx-auto">
    <h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-4 h-12 text-center pt-2">ANNOUNCEMENTS</h1>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @if($verifiedReports->isEmpty())
                <p class="text-gray-500 text-center">No verified reports found.</p>
            @else
                @foreach($verifiedReports->chunk(4) as $chunk)
                <div class="swiper-slide">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($chunk as $report)
                        <div class="bg-white shadow-lg rounded-lg p-4">
                            <img src="{{ asset($report->image ?? 'images/default-image.jpg') }}" 
                                 alt="Lost Item" 
                                 class="rounded-lg cursor-pointer mx-auto max-w-[120px] max-h-[120px] w-auto h-40"
                                 onclick="showModal('{{ asset($report->image) }}')">
                            <p class="text-gray-700 font-bold mt-2">Contact erson: {{ $report->user?->name ?? 'N/A' }}</p>
                            <p class="text-gray-500">Lost Item: {{ $report->description }}</p>
                            <p class="text-gray-500">Lost Location: {{ $report->location?->name ?? 'N/A' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <!-- Carousel Controls -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <!-- Lost Goods Section -->
    <h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-4 h-12 pt-2 pl-4">LOST GOODS</h1>

    <!-- Filter Dropdown -->
    <div class="mb-4">
        <form method="GET" action="{{ url()->current() }}" class="flex justify-end gap-4">
            <div class="relative">
                <select name="category" class="bg-[#133E87] text-white rounded-lg py-3 px-6 pr-10 text-lg shadow-md focus:outline-none mt-2" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if($lostGoodsItems->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($lostGoodsItems as $item)
                <div class="lost-item-card bg-white shadow-lg rounded-lg p-4">
                    <img src="{{ asset($item->image ?? 'images/default-image.jpg') }}"
                         alt="Lost Item"
                         class="rounded-lg cursor-pointer max-w-[120px] max-h-[120px] mx-auto w-auto h-40"
                         onclick="showModal('{{ asset($item->image) }}')">
                    <strong>{{ $item->name }}</strong><br>
                    Description: {{ $item->description }}<br>
                    Location Found: {{ $item->location_found }}<br>
                    Time Found: {{ \Carbon\Carbon::parse($item->time_found)->format('d M Y, H:i') }}<br>  
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-center">No lost goods found.</p>
    @endif

</div>

<!-- Modal -->
<div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="relative bg-white rounded-lg p-4 w-11/12 max-w-4xl">
        <button type="button" class="absolute top-2 right-2 text-white bg-red-700 hover:bg-red-800 rounded-lg px-4 py-2"
                onclick="closeModal()">✕</button>
        <img id="modalImage" src="" alt="Image Preview" class="w-full max-h-[70vh] rounded-lg object-contain">
    </div>
</div>

<!-- Footer -->
<div class="bg-[#133E87] text-white text-center py-6 mt-12">
    <p class="text-sm">Lost something? Found an item? Let's reconnect people and their belongings. Contact us to report or search for lost items.</p>
    <p class="text-sm mt-2">Address: Lorem Street | Phone Number: 123-456-789</p>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        touchEventsTarget: 'container', // Target touch events on the container
        threshold: 10, // Minimum distance to trigger swipe
        followFinger: true, // Follow the user's touch during swiping
        simulateTouch: true, // Allow touch gestures for devices like touchpads
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
