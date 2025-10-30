{{-- Lokasi file: resources/views/galeri_detail.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', $album->nama_album . ' - Galeri Kelurahan Sukorame')

@section('content')

{{-- HEADER --}}
<section class="py-12 md:py-16 px-4 bg-[#f9fdf5]">
    <div class="container mx-auto max-w-5xl text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">{{ $album->nama_album }}</h1>
        <p class="text-gray-600 mb-8">
            Album dibuat pada {{ $album->tanggal->format('d F Y') }}<br>
            Total {{ $fotos->count() }} foto kegiatan.
        </p>
    </div>
</section>

{{-- GALERI FOTO --}}
<section class="py-12 bg-[#f9fdf5]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($fotos as $index => $foto)
                <div class="bg-white rounded-2xl shadow outline outline-2 outline-[#d4f78f] overflow-hidden">
                    <img 
                        src="{{ asset('storage/' . $foto->foto_path) }}" 
                        alt="Foto {{ $loop->iteration }}" 
                        class="w-full h-64 object-cover cursor-pointer"
                        onclick="openLightbox({{ $index }})">
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ALBUM LAINNYA --}}
@if($albumLain->isNotEmpty())
<section class="py-12 bg-[#eef7ec] border-t border-gray-200">
    <div class="container mx-auto px-4 max-w-5xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Album Lainnya</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($albumLain as $lain)
                <a href="{{ route('publik.galeri_detail', $lain->id_galeri) }}" 
                   class="bg-white rounded-2xl shadow outline outline-2 outline-[#d4f78f] overflow-hidden block">
                    <img src="{{ asset('storage/' . $lain->cover_path) }}" 
                         alt="{{ $lain->nama_album }}" 
                         class="w-full h-48 object-cover">
                    <div class="p-5 text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-[#4c3588] transition-colors">
                            {{ $lain->nama_album }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-2">
                            {{ $lain->tanggal->format('d F Y') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LIGHTBOX (pratinjau foto penuh) --}}
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 hidden items-center justify-center z-50">
    <button id="closeBtn" 
            class="absolute top-5 right-5 text-white text-3xl font-bold focus:outline-none"
            onclick="closeLightbox()">&times;</button>

    <button id="prevBtn" 
            class="absolute left-5 text-white text-4xl font-bold px-3 focus:outline-none"
            onclick="prevImage()">&#10094;</button>

    <img id="lightboxImg" 
         src="" 
         alt="Preview Foto"
         class="max-h-[90vh] max-w-[90vw] rounded-xl outline outline-4 outline-[#d4f78f] object-contain">

    <button id="nextBtn" 
            class="absolute right-5 text-white text-4xl font-bold px-3 focus:outline-none"
            onclick="nextImage()">&#10095;</button>
</div>

{{-- SCRIPT LIGHTBOX --}}
<script>
    const photos = @json($fotos->pluck('foto_path'));
    let currentIndex = 0;

    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');

    function openLightbox(index) {
        currentIndex = index;
        lightboxImg.src = "{{ asset('storage') }}/" + photos[index];
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
    }

    function closeLightbox() {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % photos.length;
        lightboxImg.src = "{{ asset('storage') }}/" + photos[currentIndex];
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + photos.length) % photos.length;
        lightboxImg.src = "{{ asset('storage') }}/" + photos[currentIndex];
    }

    // Tutup jika klik di luar gambar
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    // Navigasi dengan keyboard
    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        if (e.key === 'ArrowRight') nextImage();
        else if (e.key === 'ArrowLeft') prevImage();
        else if (e.key === 'Escape') closeLightbox();
    });
</script>

@endsection
