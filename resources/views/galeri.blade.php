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
    </div>
</section>

{{-- GRID GALERI --}}
<section class="py-12 md:py-20 bg-[#f9fdf5]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($albums as $album)
                <a href="{{ route('publik.galeri_detail', $album->id_galeri) }}" class="group bg-[#cbb2ff] rounded-2xl p-4 shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="bg-white p-2 rounded-xl overflow-hidden relative">
                        <img src="{{ asset('storage/' . $album->cover_path) }}"
                             alt="{{ $album->nama_album }}"
                             class="w-full h-48 object-cover rounded-lg transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 rounded-xl bg-black bg-opacity-0 group-hover:bg-opacity-25 transition-all"></div>
                    </div>
                    <div class="mt-3 text-center">
                        <p class="font-semibold text-lg text-gray-800">
                            {{ $album->nama_album }}
                            <span class="text-gray-600 text-sm">/ {{ $album->tanggal->format('d-m-Y') }}</span>
                        </p>
                        <p class="text-sm text-gray-500">{{ $album->fotos_count }} Foto</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- SLIDER BERITA --}}
<section class="py-12 md:py-20 px-4 bg-[#f9fdf5]">
    <div class="container mx-auto max-w-4xl relative">
        <div id="sliderContainer" class="bg-[#d4f78f] p-4 rounded-2xl shadow-xl overflow-hidden relative">
            <div id="sliderTrack" class="flex transition-transform duration-700 ease-in-out">
                @foreach ($sliderImages as $gambar)
                    <div class="min-w-full">
                        <img src="{{ asset('storage/' . $gambar) }}" alt="Galeri Utama" class="w-full h-[400px] object-cover rounded-xl shadow-lg">
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

    setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }, 5000);
</script>

@endsection
