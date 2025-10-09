{{-- Lokasi file: resources/views/galeri.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Galeri - Kelurahan Sukorame')

@section('content')

    {{-- Catatan: Untuk mengaktifkan menu 'Galeri' di header, Anda perlu menambahkan logika di file `layouts/master.blade.php`. 
    Contoh: <a href="/galeri" class="{{ Request::is('galeri') ? 'text-sukorame-purple font-bold' : 'font-semibold text-sukorame-purple' }}">Galeri</a> 
    --}}

    <section class="text-center py-12 md:py-16 px-4 bg-white">
        <div class="container mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-black mb-8">
                Selamat Datang,<br>Di Galeri Kelurahan
            </h1>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 max-w-2xl mx-auto">
                <input 
                    type="text" 
                    placeholder="Masukkan Kategori Kegiatan" 
                    class="w-full sm:w-2/3 px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-sukorame-purple"
                >
                <button class="w-full sm:w-auto bg-[#d7f27b] text-sukorame-purple font-bold px-8 py-3 rounded-full hover:bg-opacity-90 transition-colors">
                    Cari Kategori
                </button>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @php
                    $galleries = [
                        ['title' => 'Kegiatan PKK', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-sukorame-purple'],
                        ['title' => 'Musyawarah', 'bg_color' => 'bg-[#d4f78f]', 'text_color' => 'text-gray-800'],
                        ['title' => 'Kirab Budaya', 'bg_color' => 'bg-sukorame-purple', 'text_color' => 'text-white'],
                        ['title' => 'Kegiatan PKK', 'bg_color' => 'bg-[#cbb2ff]', 'text_color' => 'text-sukorame-purple'],
                        ['title' => 'Musyawarah', 'bg_color' => 'bg-[#d4f78f]', 'text_color' => 'text-gray-800'],
                        ['title' => 'Kirab Budaya', 'bg_color' => 'bg-sukorame-purple', 'text_color' => 'text-white'],
                    ];
                @endphp

                @foreach ($galleries as $index => $gallery)
                <div class="{{ $gallery['bg_color'] }} rounded-2xl p-4 shadow-lg">
                    <div class="bg-white p-2 rounded-xl">
                        <img src="https://picsum.photos/seed/{{ $index+1 }}/400/300" alt="{{ $gallery['title'] }}" class="w-full h-48 object-cover rounded-lg">
                        <div class="mt-3 text-center">
                            <p class="font-semibold {{ $gallery['text_color'] }}">{{ $gallery['title'] }} / 22-08-2025</p>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    
    <section class="py-12 md:py-20 px-4 bg-white">
        <div class="container mx-auto max-w-4xl">
            <div class="relative bg-[#d4f78f] p-4 rounded-2xl shadow-xl">
                 <button class="absolute top-1/2 left-0 sm:-left-6 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md z-10 hover:bg-gray-200">
                    <svg class="w-6 h-6 text-sukorame-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <div class="overflow-hidden rounded-xl">
                    <img src="https://picsum.photos/seed/carousel/800/500" alt="Galeri Utama" class="w-full h-auto object-cover">
                </div>

                <button class="absolute top-1/2 right-0 sm:-right-6 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md z-10 hover:bg-gray-200">
                    <svg class="w-6 h-6 text-sukorame-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 justify-center">
                 @php
                    $extra_galleries = [
                        ['bg_color' => 'bg-[#cbb2ff]'],
                        ['bg_color' => 'bg-sukorame-purple'],
                        ['bg_color' => 'bg-[#d4f78f]'],
                    ];
                @endphp

                @foreach ($extra_galleries as $index => $gallery)
                <div class="{{ $gallery['bg_color'] }} p-3 rounded-2xl shadow-lg aspect-square max-w-sm mx-auto">
                    <img src="https://picsum.photos/seed/{{ $index+10 }}/400/400" alt="Galeri Tambahan {{ $index+1 }}" class="w-full h-full object-cover rounded-xl">
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection