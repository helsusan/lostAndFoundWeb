<head>
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>

@extends('base.base') 

@section('home') 

<!-- Carousel -->
<div class="container m-auto">
<h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-4 h-12 text-center pt-2">ANNOUNCEMENTS</h1>
<div class="swiper mySwiper w-full mt-4">
    @if($verifiedReports->isEmpty())
        <p class="text-gray-500 text-center">No verified reports found.</p>
    @else
    <div id="carousel" class="carousel flex overflow-x-scroll snap-x snap-mandatory scroll-smooth">
      @foreach($verifiedReports->chunk(4) as $chunk) <!-- Membagi laporan menjadi beberapa kelompok, 4 laporan per slide -->
              <div class="swiper-slide">
                  <div class="flex gap-4 justify-between"> <!-- Flex dengan jarak antar gambar -->
                      @foreach($chunk as $report)
                      <div class="p-4 bg-white shadow-lg rounded-lg w-full flex-shrink-0"> <!-- Ukuran lebar lebih besar untuk setiap gambar -->
                          <img src="{{ asset($report->image ?? 'images/default-image.jpg') }} "
                              alt="Lost Item"
                              class="rounded-lg cursor-pointer max-w-[120px] max-h-[120px] mx-auto"
                              onclick="showModal('{{ asset($report->image) }}')">
                          <p class="text-gray-700 font-bold">Contact person: {{ $report->user?->name ?? 'N/A' }}</p>
                          <div class="flex-grow">
                              <p class="text-gray-500">Lost Item: {{ $report->description }}</p>
                              <p class="text-gray-500">Lost Location: {{ $report->location?->name ?? 'N/A' }}</p>
                          </div> <!-- Memungkinkan teks memanjang -->
                      </div>
                      @endforeach
                  </div>
              </div>
              @endforeach
        </div>
        <!-- Carousel Controls -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    @endif
</div>

<script>
    const carousel = document.getElementById('carousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    prevBtn.addEventListener('click', () => {
      carousel.scrollBy({
        left: -carousel.clientWidth,
        behavior: 'smooth'
      });
    });

    nextBtn.addEventListener('click', () => {
      carousel.scrollBy({
        left: carousel.clientWidth,
        behavior: 'smooth'
      });
    });

</script>

{{-- Lost Goods Section --}}
<h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-4 h-12 pt-2 pl-4">LOST GOODS</h1>

{{-- Filter Dropdown --}}
<div class="mb-4">
    <form method="GET" action="{{ url()->current() }}" class="flex justify-end gap-4">
        <div class="relative">
            <select name="category" class="bg-[#133E87] text-white rounded-lg py-2 px-4 shadow-md focus:outline-none">
                <option value="">All</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-[#1E56A0] text-white rounded-lg py-2 px-4 shadow-md hover:bg-[#133E87] transition">
            Go
        </button>
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


<div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="relative bg-white rounded-lg p-4 w-11/12 max-w-4xl">
        <button type="button" class="absolute top-2 right-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
            onclick="closeModal()">
            <strong>✕</strong>
        </button>
        <img id="modalImage" src="" alt="Image Preview" class="w-full max-h-[70vh] rounded-lg object-contain">
    </div>
</div>


<!-- Footer -->
<div class="bg-[#133E87] text-white text-center py-6 mt-12 w-full">
    <p class="text-sm">Lost something? Found an item? Let's reconnect people and their belongings. Contact us to report or search for lost items.</p>
    <p class="text-sm mt-2">Address: Lorem Street | Phone Number: 123-456-789</p>
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


<style>
    /* Atur posisi tombol next dan prev agar lebih mudah terlihat */
    .swiper-button-prev, .swiper-button-next {
        color: #133E87; /* Warna tombol */
        z-index: 10; /* Pastikan tombol tetap di atas gambar */
    }

    /* Atur posisi pagination */
    .swiper-pagination {
        bottom: 10px; /* Jarak dari bawah */
        z-index: 10;
    }
</style>
@endsection <!-- Akhir section -->



