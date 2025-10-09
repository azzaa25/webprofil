{{-- Lokasi file: resources/views/berita.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Berita - Kelurahan Sukorame')

@section('content')

    {{-- Catatan: Untuk mengaktifkan menu 'Berita' di header, Anda perlu menambahkan logika di file `layouts/master.blade.php`. 
    Contoh: <a href="/berita" class="{{ Request::is('berita') ? 'text-sukorame-purple font-bold' : 'font-semibold text-sukorame-purple' }}">Berita</a> 
    --}}

    <section class="text-center py-12 md:py-16 px-4 bg-white">
        <div class="container mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold text-black">
                Selamat Datang,<br>Di Halaman Berita
            </h1>
        </div>
    </section>

    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <div class="space-y-8">

                @php
                    $beritaList = [
                        [
                            'judul' => 'Judul Berita Pertama',
                            'isi' => 'Lorem ipsum dolor sit amet lorem impsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem impsum dolor sit amet lorem ipsum.',
                            'tanggal' => '12/09/2025',
                            'bg_color' => 'bg-[#d4f78f]',
                            'text_color' => 'text-gray-800',
                            'image_seed' => 'news1'
                        ],
                        [
                            'judul' => 'Judul Berita Kedua',
                            'isi' => 'Lorem ipsum dolor sit amet lorem impsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem impsum dolor sit amet lorem ipsum.',
                            'tanggal' => '12/09/2025',
                            'bg_color' => 'bg-[#cbb2ff]',
                            'text_color' => 'text-sukorame-purple',
                            'image_seed' => 'news2'
                        ],
                        [
                            'judul' => 'Judul Berita Ketiga',
                            'isi' => 'Lorem ipsum dolor sit amet lorem impsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem impsum dolor sit amet lorem ipsum.',
                            'tanggal' => '12/09/2025',
                            'bg_color' => 'bg-sukorame-purple',
                            'text_color' => 'text-white',
                            'image_seed' => 'news3'
                        ]
                    ];
                @endphp

                @foreach ($beritaList as $berita)
                <div class="{{ $berita['bg_color'] }} {{ $berita['text_color'] }} rounded-2xl p-6 md:p-8 shadow-lg flex flex-col md:flex-row items-center gap-6 md:gap-8">
                    <div class="w-full md:w-1/3 flex-shrink-0">
                        <img src="https://picsum.photos/seed/{{ $berita['image_seed'] }}/400/400" alt="{{ $berita['judul'] }}" class="w-full h-auto object-cover rounded-xl aspect-square">
                    </div>

                    <div class="w-full md:w-2/3 flex flex-col h-full">
                        <h3 class="text-2xl font-bold mb-2">{{ $berita['judul'] }}</h3>
                        <p class="flex-grow mb-4 text-base">
                            {{ $berita['isi'] }}
                        </p>
                        <p class="text-right font-semibold">{{ $berita['tanggal'] }}</p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection