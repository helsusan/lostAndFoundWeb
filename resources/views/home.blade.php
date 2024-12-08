<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <title>Lost and Found</title>
    <style>
        .swiper-button-next, .swiper-button-prev {
            color: #133E87; 
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }
        .swiper-button-next {
            right: 10px;
        }
        .swiper-button-prev {
            left: 10px;
        }
        .swiper {
            margin-bottom: 0 !important; /* Remove additional spacing below the carousel */
        }
    </style>
</head>
<body>
    @extends('base.base')

    @section('home')

    <!-- Container -->
    <div class="container mx-auto">
        <!-- Carousel -->
        <h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-4 h-20 text-center pt-6 rounded-lg">ANNOUNCEMENTS</h1>
        <div class="swiper mySwiper flex bg-[#a9c6ff] -mt-4">
            <div class="swiper-wrapper mt-10 mb-12">
                @if($verifiedReports->isEmpty())
                    <p class="text-gray-500 text-center">No verified reports found.</p>
                @else
                    @foreach($verifiedReports->chunk(3) as $chunk)
                    <div class="swiper-slide">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
                            @foreach($chunk as $report)
                            <div class="bg-white shadow-lg rounded-lg p-4 ml-14 mr-14">
                                <img src="{{ asset($report->image ?? 'images/default-image.jpg') }}" 
                                    alt="Lost Item" 
                                    class="rounded-lg cursor-pointer mx-auto max-w-[120px] max-h-[120px] w-auto h-40"
                                    onclick="showModal('{{ asset($report->image) }}')">
                                <p class="text-gray-700 font-bold mt-2">Contact Person: {{ $report->user?->name ?? 'N/A' }}</p>
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
        <h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-4 h-20 pt-6 pl-4 rounded-lg">LOST GOODS</h1>
        <!-- Filter Dropdown -->
        <div class="mb-4">
            <form method="GET" action="{{ url()->current() }}" class="flex justify-end gap-4">
                <div class="relative -mt-20">
                    <select name="category" class="bg-[#a9c6ff] text-black rounded-lg py-2 px-6 pr-10 text-lg shadow-md focus:outline-none mr-3" onchange="this.form.submit()">
                        <option value="">Filter</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div id="lostGoodsContainer">
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

        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk memuat data laporan verified
            function loadVerifiedReports() {
                fetch('/fetch-verified-reports')
                    .then(response => response.json())
                    .then(data => {
                        const swiperWrapper = document.querySelector('.swiper-wrapper');
                        swiperWrapper.innerHTML = ''; // Kosongkan kontainer sebelum menambahkan data baru

                        if (data.length === 0) {
                            swiperWrapper.innerHTML = `<p class="text-gray-500 text-center">No verified reports found.</p>`;
                        } else {
                            const chunkedReports = [];
                            for (let i = 0; i < data.length; i += 3) {
                                chunkedReports.push(data.slice(i, i + 3));
                            }

                            chunkedReports.forEach(chunk => {
                                const slide = document.createElement('div');
                                slide.className = 'swiper-slide';

                                const grid = document.createElement('div');
                                grid.className = 'grid grid-cols-2 md:grid-cols-3 gap-1';

                                chunk.forEach(report => {
                                    const reportCard = `
                                        <div class="bg-white shadow-lg rounded-lg p-4 ml-14 mr-14">
                                            <img src="${report.image ? report.image : '/images/default-image.jpg'}" 
                                                alt="Lost Item" 
                                                class="rounded-lg cursor-pointer mx-auto max-w-[120px] max-h-[120px] w-auto h-40"
                                                onclick="showModal('${report.image ? report.image : '/images/default-image.jpg'}')">
                                            <p class="text-gray-700 font-bold mt-2">Contact Person: ${report.user?.name ?? 'N/A'}</p>
                                            <p class="text-gray-500">Lost Item: ${report.description}</p>
                                            <p class="text-gray-500">Lost Location: ${report.location?.name ?? 'N/A'}</p>
                                        </div>`;
                                    grid.innerHTML += reportCard;
                                });

                                slide.appendChild(grid);
                                swiperWrapper.appendChild(slide);
                            });

                            swiper.update();
                        }
                    })
                    .catch(error => console.error('Error fetching verified reports:', error));
            }

            // Fungsi untuk memuat data Lost Goods
            function loadLostGoods() {
                fetch('/fetch-lost-goods')
                    .then(response => response.json())
                    .then(data => {
                        const lostGoodsContainer = document.getElementById('lostGoodsContainer');
                        lostGoodsContainer.innerHTML = ''; // Kosongkan kontainer sebelum menambahkan data baru

                        if (data.length === 0) {
                            lostGoodsContainer.innerHTML = `<p class="text-gray-500 text-center">No lost goods found.</p>`;
                        } else {
                            const grid = document.createElement('div');
                            grid.className = 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4';

                            data.forEach(item => {
                                const itemCard = `
                                    <div class="lost-item-card bg-white shadow-lg rounded-lg p-4">
                                        <img src="${item.image ? item.image : '/images/default-image.jpg'}"
                                            alt="Lost Item"
                                            class="rounded-lg cursor-pointer max-w-[120px] max-h-[120px] mx-auto w-auto h-40"
                                            onclick="showModal('${item.image}')">
                                        <strong>${item.name}</strong><br>
                                        Description: ${item.description}<br>
                                        Location Found: ${item.location_found}<br>
                                        Time Found: ${item.time_found}<br>
                                    </div>`;
                                grid.innerHTML += itemCard;
                            });

                            lostGoodsContainer.appendChild(grid);
                        }
                    })
                    .catch(error => console.error('Error fetching lost goods:', error));
            }

            // Jalankan polling setiap 10 detik untuk update verified reports dan lost goods
            setInterval(() => {
                loadVerifiedReports();
                loadLostGoods();
            }, 10000);
        });
    </script>
</body>
</html>
