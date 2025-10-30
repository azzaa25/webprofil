@extends('layouts.nav_webprof')

@section('title', 'Berita - Kelurahan Sukorame')

@section('content')

    <section class="text-center py-12 md:py-16 px-4 bg-[#f9fdf5]">
        <div class="container mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">
                Selamat Datang,<br>Di Halaman Berita
            </h1>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-[#f9fdf5]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="space-y-10">

                {{-- Loop berita dari database --}}
                @foreach ($beritaList as $berita)
                    <div
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-400 flex flex-col md:flex-row items-center overflow-hidden border border-gray-200 hover:-translate-y-1">

                        {{-- Gambar --}}
                        <div class="w-full md:w-1/3 flex-shrink-0 overflow-hidden">
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        {{-- Konten --}}
                        <div class="w-full md:w-2/3 p-6 md:p-8">
                            <h3
                                class="text-2xl md:text-3xl font-bold text-gray-900 hover:text-[#4c3588] transition-colors duration-300 mb-2">
                                {{ $berita->judul }}
                            </h3>
                            <div class="text-sm text-gray-600 mb-4">
                                Oleh: <span class="font-semibold text-gray-900">{{ $berita->penulis }}</span> |
                                {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }} |
                                <span class="bg-gray-200 text-gray-800 px-2 py-0.5 rounded text-xs font-semibold">
                                    {{ $berita->kategori }}
                                </span>
                            </div>
                            <p class="text-gray-700 leading-relaxed mb-2">
                                {{ Str::limit(strip_tags($berita->konten), 150, '...') }}
                            </p>
                            <a href="{{ route('publik.berita_detail', $berita->slug) }}"
                                class="inline-block mt-3 text-gray-900 font-semibold hover:underline">
                                Baca Selengkapnya →
                            </a>

                        </div>

                    </div>
                @endforeach

                {{-- Jika kosong --}}
                @if (empty($beritaList))
                    <p class="text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
                @endif

            </div>
        </div>
    </section>

@endsection