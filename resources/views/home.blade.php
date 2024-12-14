<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <title>Lost and Found</title>
    <style>
        // mengatur tampilan tombol navigasi swiper
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
            margin-bottom: 0 !important; // mengatur margin swiper agar tidak ada ruang kosong di bawah carousel
        }
    </style>
</head>
<body>
    @extends('base.base')


    @section('content')


    <!-- Container -->
    <div class="container mx-auto px-16">
        <!-- Carousel -->
        <h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-4 h-20 text-center pt-6 rounded-t-lg">ANNOUNCEMENTS</h1>
        <div class="swiper mySwiper flex bg-[#a9c6ff] -mt-4 rounded-b-lg">
            @if($verifiedReports->isEmpty())
                <div class="swiper-wrapper flex mt-10 mb-12 justify-center item-center">
                    <p class="text-gray-500 text-center">No verified reports found.</p>
                @else
                <div class="swiper-wrapper flex mt-10 mb-12">
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
            <!-- carousel controls -->
            <div class="swiper-pagination"></div>
            <!-- navigasi pagination untuk swiper -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>


        <!-- Lost Goods Section -->
        <h1 class="bg-[#133E87] text-2xl font-bold text-white mb-4 mt-7 h-20 pt-6 pl-4 rounded-lg">LOST GOODS</h1>
        <!-- filter dropdown -->
        <div class="mb-4">
            <form method="GET" action="{{ url()->current() }}" class="flex justify-end gap-4">
                <div class="relative -mt-20">
                    <select name="category" class="bg-[#a9c6ff] text-black rounded-lg py-2 px-6 pr-10 text-lg shadow-md focus:outline-none mr-3" onchange="this.form.submit()">
                        <option value="">Filter</option>
                        <!-- menambahkan opsi filter untuk kategori barang -->
                        @foreach($categories as $category)
                            <!-- menampilkan kategori dlm dropdown & menandai kategori yg dipilih -->
                            <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="lostGoodsContainer pb-12">
            <!-- jika ada barang hilang yang ditemukan -->
            @if($lostGoodsItems->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- loop untuk menampilkan tiap barang hilang -->
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


    <!-- modal untuk menampilkan gambar-->
    <div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="relative bg-white rounded-lg p-4 w-11/12 max-w-4xl">
            <button type="button" class="absolute top-2 right-2 text-white bg-red-700 hover:bg-red-800 rounded-lg px-4 py-2"
                    onclick="closeModal()">✕</button>
            <img id="modalImage" src="" alt="Image Preview" class="w-full max-h-[70vh] rounded-lg object-contain">
        </div>
    </div>


    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // inisialisasi swiper untuk carousel laporan yg diverif
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


        // fungsi untuk menampilkan gambar di model
        function showModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
        }


        // fungsi untuk menutup model
        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }


        document.addEventListener('DOMContentLoaded', function () {
            // fungsi untuk memuat data laporan verified
            function loadVerifiedReports() {
                fetch('/fetch-verified-reports') // memanggil API untuk mendapatkan data laporan yang telah diverifikasi
                    .then(response => response.json()) // mengubah respon menjadi format JSON
                    .then(data => {
                        const swiperWrapper = document.querySelector('.swiper-wrapper'); // cari elemen dgn class swiper-wrapper
                        swiperWrapper.innerHTML = ''; // kosongkan isi elemen untuk mencegah duplikasi

                        if (data.length === 0) {
                            swiperWrapper.innerHTML = `<p class="text-gray-500 text-center">No verified reports found.</p>`;
                        } else {
                            const chunkedReports = []; // array untuk bagi laporan jd grup grup kecil
                            for (let i = 0; i < data.length; i += 3) {
                                chunkedReports.push(data.slice(i, i + 3)); // memecah jadi grup berisi 3 laporan
                            }

                            chunkedReports.forEach(chunk => {
                                const slide = document.createElement('div'); // buat elemen baru untuk slide
                                slide.className = 'swiper-slide';

                                const grid = document.createElement('div'); // buat elemen grid untuk laporan
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
                                    grid.innerHTML += reportCard; // menambahkan elemen kartu laporan ke grid
                                });


                                slide.appendChild(grid); // menambahkan grid ke dalam slide
                                swiperWrapper.appendChild(slide); // menambahkan slide ke swiper-wrapper
                            });


                            swiper.update();
                        }
                    })
                    .catch(error => console.error('Error fetching verified reports:', error));
            }


            // fungsi untuk memuat data Lost Goods
            function loadLostGoods() {
                fetch('/fetch-lost-goods') 
                    .then(response => response.json())
                    .then(data => {
                        const lostGoodsContainer = document.querySelector('.lostGoodsContainer'); 
                        lostGoodsContainer.innerHTML = ''; 

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
                                        Time Found: ${new Date(item.time_found).toLocaleString()}<br>
                                    </div>`;
                                grid.innerHTML += itemCard; 
                            });

                            lostGoodsContainer.appendChild(grid);
                        }
                    })
                    .catch(error => console.error('Error fetching lost goods:', error));
            }

            function loadReports() {
                fetch('/fetch-reports')
                    .then(response => response.json())
                    .then(data => {
                        const reportsContainer = document.querySelector('.reportsContainer'); 
                        reportsContainer.innerHTML = ''; 

                        if (data.length === 0) {
                            reportsContainer.innerHTML = `<p class="text-gray-500 text-center">No reports found.</p>`;
                        } else {
                            const grid = document.createElement('div'); 
                            grid.className = 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4';

                            data.forEach(report => {
                                const reportCard = `
                                    <div class="report-card bg-white shadow-lg rounded-lg p-4">
                                        <strong>${report.item.name}</strong><br>
                                        Description: ${report.item.description}<br>
                                        Location: ${report.location.name}<br>
                                        Status: ${report.reportStatus.name}<br>
                                        Reported By: ${report.user.name}<br>
                                        Time Reported: ${new Date(report.created_at).toLocaleString()}<br>
                                    </div>`;
                                grid.innerHTML += reportCard; 
                            });

                            reportsContainer.innerHTML = ''; // Clear the container before appending new data
                            reportsContainer.appendChild(grid);
                        }
                    })
                    .catch(error => console.error('Error fetching reports:', error));
            }




            // jalankan polling setiap 5 detik untuk update verified reports dan lost goods
            // setInterval(() => {
            //     loadVerifiedReports();
            //     loadLostGoods();
            //     loadReports();
            // }, 5000);
        });
    </script>
</body>
</html>

@endsection
