@extends('layouts.nav_webprof')

@section('title', $berita->judul . ' - Detail Berita')

@section('content')

{{-- HEADER --}}
<section class="text-center py-12 md:py-16 px-4 bg-[#f9fdf5] border-b border-gray-200">
    
    {{-- BREADCRUMB --}}
    <div class="mb-6 flex items-center text-sm text-gray-600">

        <a href="{{ route('publik.berita') }}"
            class="text-[#4c3588] font-semibold hover:underline flex items-center gap-2">
            <i class="fa-solid fa-arrow-left text-[#4c3588] text-xs"></i>
            <span>Kembali ke Berita</span>
        </a>

        <span class="mx-2 text-gray-400">/</span>

        <span class="text-gray-900 font-semibold">
            Detail Berita
        </span>
    </div>

    <div class="container mx-auto max-w-3xl">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
            {{ $berita->judul }}
        </h1>

        <p class="text-gray-600 text-sm">
            Oleh <span class="font-semibold text-gray-900">{{ $berita->penulis }}</span> •
            {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y') }} •
            <span class="bg-gray-200 text-gray-800 px-2 py-0.5 rounded text-xs font-semibold">
                {{ $berita->kategori }}
            </span>
        </p>
    </div>
</section>

{{-- ISI BERITA --}}
<section class="py-12 md:py-20 bg-[#f9fdf5]">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200">

            @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" 
                     alt="{{ $berita->judul }}" 
                     class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-500">
                    Tidak Ada Gambar
                </div>
            @endif

            <div class="p-8 md:p-10">
                <article class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                    {!! nl2br(e($berita->konten)) !!}
                </article>
            </div>
        </div>
    </div>
</section>

{{-- BERITA LAINNYA --}}
@if($beritaLain->isNotEmpty())
<section class="py-12 bg-[#eef7ec] border-t border-gray-200">
    <div class="container mx-auto px-4 max-w-5xl">

        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
            Berita Lainnya
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($beritaLain as $lain)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg overflow-hidden transition-transform hover:-translate-y-1">

                    <img src="{{ asset('storage/' . $lain->gambar) }}" 
                         alt="{{ $lain->judul }}" 
                         class="w-full h-48 object-cover">

                    <div class="p-5">

                        <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-[#4c3588] transition-colors">
                            <a href="{{ route('publik.berita_detail', $lain->slug) }}">
                                {{ $lain->judul }}
                            </a>
                        </h3>

                        <p class="text-sm text-gray-600 mb-2">
                            {{ \Carbon\Carbon::parse($lain->tanggal_publikasi)->translatedFormat('d F Y') }}
                        </p>

                        <p class="text-gray-700 text-sm">
                            {{ Str::limit(strip_tags($lain->konten), 100, '...') }}
                        </p>

                        <a href="{{ route('publik.berita_detail', $lain->slug) }}" 
                           class="text-[#4c3588] font-semibold text-sm hover:underline mt-2 inline-block">
                           Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

@endsection
