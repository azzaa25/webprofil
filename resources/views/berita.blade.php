@extends('layouts.nav_webprof')

@section('title', 'Berita Sukorame')

@section('content')

    {{-- HERO SECTION --}}
    <section class="text-center py-12 md:py-16 px-4 bg-white">
        <div class="container mx-auto">
            <h1 class="font-poppins text-4xl font-extrabold text-gray-900 leading-tight">
                Selamat Datang, Di Halaman Berita
            </h1>
            <p class="text-gray-700 mb-8 max-w-xl mx-auto">
                Temukan berbagai informasi kabar kegiatan dan acara penting yang telah dilaksanakan di lingkungan Kelurahan Sukorame.
            </p>
        </div>
    </section>

    {{-- GRID BERITA --}}
    <section class="py-12 md:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">

            {{-- Jika kosong --}}
            @if ($beritaList->isEmpty())
                <p class="text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                @foreach ($beritaList as $berita)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-200 overflow-hidden 
                                transition-all duration-300 hover:-translate-y-1 group">

                        {{-- Gambar --}}
                        <div class="w-full h-56 overflow-hidden">
                            <img src="{{ asset('storage/' . $berita->gambar) }}"
                                 alt="{{ $berita->judul }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>

                        {{-- Konten --}}
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 
                                       group-hover:text-[#4c3588] transition-colors duration-300">
                                {{ $berita->judul }}
                            </h3>

                            <div class="text-sm text-gray-600 mb-4">
                                Oleh: 
                                <span class="font-semibold text-gray-900">{{ $berita->penulis }}</span> |
                                {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }} |
                                <span class="bg-gray-200 text-gray-800 px-2 py-0.5 rounded text-xs font-semibold">
                                    {{ $berita->kategori }}
                                </span>
                            </div>

                            <p class="text-gray-700 leading-relaxed mb-3">
                                {{ Str::limit(strip_tags($berita->konten), 130, '...') }}
                            </p>

                            <a href="{{ route('publik.berita_detail', $berita->slug) }}"
                               class="text-sukorame-purple font-semibold hover:underline">
                                Baca Selengkapnya →
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </section>

@endsection
