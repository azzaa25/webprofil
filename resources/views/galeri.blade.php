{{-- Lokasi file: resources/views/galeri.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Galeri - Kelurahan Sukorame')

@section('content')

    {{-- HEADER --}}
    <section class="text-center py-12 md:py-16 px-4 bg-[#f9fdf5]">
        <div class="container mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">
                Selamat Datang,<br>Di Galeri Kelurahan Sukorame
            </h1>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto">
                Temukan berbagai dokumentasi kegiatan dan acara penting yang telah dilaksanakan di lingkungan Kelurahan Sukorame.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 max-w-2xl mx-auto">
                <input 
                    type="text" 
                    placeholder="Masukkan Kegiatan......." 
                    class="w-full sm:w-2/3 px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-sukorame-purple"
                >
                <button class="w-full sm:w-auto bg-[#a3e635] hover:bg-[#86efac] text-sukorame-purple font-bold px-8 py-3 rounded-full transition-colors duration-300">
                    Cari Kegiatan
                </button>
            </div>
        </div>
    </section>

    {{-- GRID GALERI UTAMA --}}
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @php
                    $galleries = [
                        ['title' => 'Kegiatan PKK', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-sukorame-purple'],
                        ['title' => 'Musyawarah', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-gray-800'],
                        ['title' => 'Kirab Budaya', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-white'],
                        ['title' => 'Kerja Bakti', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-sukorame-purple'],
                        ['title' => 'Sosialisasi', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-gray-800'],
                        ['title' => 'Lomba Desa', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-white'],
                    ];
                @endphp

                @foreach ($galleries as $index => $gallery)
                <div class="group {{ $gallery['bg_color'] }} rounded-2xl p-4 shadow-md hover:shadow-2xl transition-all duration-500 cursor-pointer hover:-translate-y-2">
                    <div class="bg-white p-2 rounded-xl overflow-hidden relative">
                        <img src="https://picsum.photos/seed/{{ $index+1 }}/400/300" 
                             alt="{{ $gallery['title'] }}" 
                             class="w-full h-48 object-cover rounded-lg transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 rounded-xl bg-black bg-opacity-0 group-hover:bg-opacity-25 transition-all"></div>
                    </div>
                    <div class="mt-3 text-center">
                        <p class="font-semibold text-lg {{ $gallery['text_color'] }}">
                            {{ $gallery['title'] }} <span class="text-gray-600 text-sm">/ 22-08-2025</span>
                        </p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- SLIDER --}}
    <section class="py-12 md:py-20 px-4 bg-white">
        <div class="container mx-auto max-w-4xl relative">
            <div id="sliderContainer" class="bg-[#d4f78f] p-4 rounded-2xl shadow-xl overflow-hidden relative">
                <div id="sliderTrack" class="flex transition-transform duration-700 ease-in-out">
                    @php
                        $sliderImages = [
                            'https://picsum.photos/seed/carousel1/900/500',
                            'https://picsum.photos/seed/carousel2/900/500',
                            'https://picsum.photos/seed/carousel3/900/500',
                        ];
                    @endphp

                    @foreach ($sliderImages as $img)
                        <div class="min-w-full">
                            <img src="{{ $img }}" alt="Galeri Utama" class="w-full h-[400px] object-cover rounded-xl shadow-lg">
                        </div>
                    @endforeach
                </div>

                {{-- Tombol Navigasi --}}
                <button id="prevBtn" class="absolute top-1/2 left-0 sm:-left-6 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md z-10 hover:bg-gray-200 transition">
                    <svg class="w-6 h-6 text-sukorame-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button id="nextBtn" class="absolute top-1/2 right-0 sm:-right-6 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md z-10 hover:bg-gray-200 transition">
                    <svg class="w-6 h-6 text-sukorame-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>

    {{-- GALERI TAMBAHAN --}}
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-sukorame-purple mb-10">Galeri Kegiatan Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 justify-center">
                @php
                    $extra_galleries = [
                        ['bg_color' => 'bg-[#cbb2ff]'],
                        ['bg_color' => 'bg-sukorame-purple'],
                        ['bg_color' => 'bg-[#d4f78f]'],
                    ];
                @endphp

                @foreach ($extra_galleries as $index => $gallery)
                <div class="group {{ $gallery['bg_color'] }} p-3 rounded-2xl shadow-lg aspect-square max-w-sm mx-auto hover:scale-105 transition-transform duration-500">
                    <img src="https://picsum.photos/seed/{{ $index+10 }}/400/400" alt="Galeri Tambahan {{ $index+1 }}" class="w-full h-full object-cover rounded-xl shadow-md">
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SCRIPT SLIDER --}}
    <script>
        const sliderTrack = document.getElementById('sliderTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentSlide = 0;
        const totalSlides = sliderTrack.children.length;

        function updateSlider() {
            sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        });

        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlider();
        });

        // Auto Slide
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        }, 5000);
    </script>

@endsection
