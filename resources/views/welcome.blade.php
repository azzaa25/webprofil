{{-- Lokasi file: resources/views/beranda.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Beranda Sukorame')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- 1. HERO SECTION (Setelah Navbar dari layout) --}}
    <section
        class="relative bg-gradient-to-br from-sukorame-purple via-sukorame-purple-light to-sukorame-green text-sukorame-purple text-center py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-90">
            <img src="{{ asset('img/ggklotok.jpg') }}" alt="Foto Kelurahan Sukorame" class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 container mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 drop-shadow-lg tracking-wide">
                KOTA KEDIRI MAPAN
            </h1>
            @php
                $beritaTerbaru = $berita->take(3);
            @endphp
            <div x-data="{ active: 0, total: {{ count($beritaTerbaru) }} }"
                x-init="setInterval(() => active = (active + 1) % total, 4000)"
                class="relative w-full max-w-5xl mx-auto h-64 md:h-96 rounded-xl overflow-hidden shadow-2xl ring-4 ring-white/20 transform hover:scale-[1.02] transition duration-500 ease-out">

                {{-- Slider Gambar --}}
                @foreach($beritaTerbaru as $i => $item)
                    <div x-show="active === {{ $i }}" x-transition.opacity.duration.700ms class="absolute inset-0">
                        @if(!empty($item->gambar) && Storage::disk('public')->exists($item->gambar))
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('img/default.jpg') }}" alt="Gambar tidak tersedia"
                                class="w-full h-full object-cover">
                        @endif
                    </div>
                @endforeach

                {{-- Tombol panah kiri --}}
                <button @click="active = active > 0 ? active - 1 : total - 1"
                    class="absolute top-1/2 left-3 -translate-y-1/2 bg-white/60 hover:bg-white text-gray-700 rounded-full p-2 shadow-md">
                    < </button>

                        {{-- Tombol panah kanan --}}
                        <button @click="active = (active + 1) % total"
                            class="absolute top-1/2 right-3 -translate-y-1/2 bg-white/60 hover:bg-white text-gray-700 rounded-full p-2 shadow-md">
                            >
                        </button>

                        {{-- Indikator --}}
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2">
                            @foreach($beritaTerbaru as $i => $item)
                                <button @click="active = {{ $i }}" :class="active === {{ $i }} ? 'bg-white' : 'bg-gray-400/70'"
                                    class="w-3 h-3 rounded-full transition"></button>
                            @endforeach
                        </div>
            </div>


        </div>
    </section>

    {{-- 2. Tentang Kelurahan --}}
    <section class="py-20 bg-gradient-to-b from-white via-gray-50 to-sukorame-green/10">
        <div class="bg-sukorame-green py-4 mb-12 rounded-lg shadow-lg shadow-sukorame-green/30">
            <h2 class="text-3xl font-extrabold text-sukorame-purple text-center tracking-wide uppercase">
                KELURAHAN SUKORAME
            </h2>
        </div>
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-900 max-w-4xl mx-auto mb-16 text-xl leading-relaxed">
                Kelurahan Sukorame berkomitmen memberikan pelayanan publik yang modern, profesional, dan transparan berbasis
                teknologi informasi untuk mewujudkan masyarakat yang MAPAN (Mandiri, Aman, Produktif, dan Nyaman).
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <div class="group p-8 rounded-2xl shadow-md hover:shadow-2xl hover:scale-[1.03] transition duration-500 transform hover:-translate-y-1 

                                       /* Default State (Warna Solid Terang) */
                                       bg-sukorame-purple text-white  
                                       flex flex-col justify-center items-center text-center h-64 relative overflow-hidden

                                       /* Hover State (Warna Solid Gelap - Disesuaikan) */
                                       hover:bg-sukorame-purple hover:text-white hover:border-sukorame-purple">

                    <div class="flex flex-col items-center justify-center transition-all duration-500">
                        <i class="fas fa-file-alt text-4xl mb-3 group-hover:text-white transition-colors duration-500"></i>
                        <h3 class="text-xl font-bold group-hover:text-white transition-colors duration-500">Pelayanan
                        </h3>
                    </div>

                    <p class="text-sm leading-relaxed mt-4 max-w-xs transition-opacity duration-500 ease-in-out 

                                          /* Awalnya tersembunyi */
                                          opacity-0 h-0 overflow-hidden 

                                          /* Muncul saat hover */
                                          group-hover:opacity-100 group-hover:h-auto group-hover:text-white">
                        Pelayanan administrasi publik untuk menerbitkan berbagai jenis surat pengantar
                        atau keterangan yang diperlukan oleh warga untuk urusan resmi.
                    </p>
                </div>

                <div class="group p-8 rounded-2xl shadow-md hover:shadow-2xl hover:scale-[1.03] transition duration-500 transform hover:-translate-y-1 

                                       /* Default State (Warna Solid Terang) */
                                       bg-sukorame-green text-sukorame-purple 
                                       flex flex-col justify-center items-center text-center h-64 relative overflow-hidden

                                       /* Hover State (Warna Solid Gelap - Disesuaikan) */
                                       hover:bg-sukorame-green hover:text-sukorame-purple hover:border-sukorame-green">

                    <div class="flex flex-col items-center justify-center transition-all duration-500">
                        <i
                            class="fas fa-newspaper text-4xl mb-3 group-hover:text-sukorame-purple transition-colors duration-500"></i>
                        <h3 class="text-xl font-bold group-hover:text-sukorame-purple transition-colors duration-500">Berita
                            Warga
                        </h3>
                    </div>

                    <p class="text-sm leading-relaxed mt-4 max-w-xs transition-opacity duration-500 ease-in-out 
                                          opacity-0 h-0 overflow-hidden 
                                          group-hover:opacity-100 group-hover:h-auto group-hover:text-sukorame-purple">
                        Informasi dan berita terkini dari masyarakat dan kegiatan kelurahan untuk memperkuat transparansi
                        dan partisipasi warga.
                    </p>
                </div>

                <div class="group p-8 rounded-2xl shadow-md hover:shadow-xl hover:scale-[1.03] transition duration-500 transform hover:-translate-y-1 

                                       /* Default State (Warna Solid Gelap) */
                                       bg-sukorame-purple text-white 
                                       flex flex-col justify-center items-center text-center h-64 relative overflow-hidden

                                       /* Hover State (Warna Solid Lebih Gelap - Disesuaikan) */
                                       hover:bg-[#3d2073] hover:text-white">

                    <div class="flex flex-col items-center justify-center transition-all duration-500">
                        <i class="fas fa-images text-4xl mb-3"></i>
                        <h3 class="text-xl font-bold">Galeri Kelurahan</h3>
                    </div>

                    <p class="text-sm leading-relaxed mt-4 max-w-xs transition-opacity duration-500 ease-in-out 
                                          opacity-0 h-0 overflow-hidden 
                                          group-hover:opacity-100 group-hover:h-auto">
                        Dokumentasi kegiatan pemerintahan dan masyarakat sebagai bentuk akuntabilitas publik dan kebersamaan
                        warga Sukorame.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. Pemangku Jabatan --}}
    <section class="py-20 bg-gradient-to-t from-sukorame-green/10 via-white to-sukorame-purple-light/10">
        <div class="bg-sukorame-green py-4 mb-12 rounded-lg shadow-lg shadow-sukorame-green/40">
            <h2 class="text-3xl font-extrabold text-sukorame-purple text-center uppercase tracking-wide">
                PEMANGKU JABATAN
            </h2>
        </div>
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-6 md:gap-8 mb-16">

                @forelse($pejabatList as $pejabat)
                    {{-- Card Pejabat Dinamis --}}
                    <div
                        class="text-center transform hover:scale-[1.05] transition duration-500 hover:-translate-y-2 max-w-[220px]">
                        <div {{-- Tinggi Card Dibuat Tetap (h-[400px]) --}}
                            class="bg-gradient-to-br border border-sukorame-purple-light border-2 from-white to-sukorame-purple-light/30 p-4 rounded-2xl shadow-md hover:shadow-2xl h-[400px] flex flex-col items-center">

                            {{-- Foto --}}
                            <div class="mb-4">
                                @if(!empty($pejabat->foto_path) && Storage::disk('public')->exists($pejabat->foto_path))
                                    <img src="{{ asset('storage/' . $pejabat->foto_path) }}" alt="{{ $pejabat->jabatan }}"
                                        class="w-27 h-32 rounded-xl object-contain object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                                @else
                                    <img src="{{ asset('img/default_avatar.jpg') }}" alt="Foto tidak tersedia"
                                        class="w-27 h-32 rounded-xl object-contain object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                                @endif
                            </div>

                            {{-- Jabatan --}}
                            <h4 class="font-extrabold text-lg text-sukorame-purple mb-2 break-words leading-tight px-1">
                                {{ $pejabat->jabatan }}
                            </h4>

                            {{-- Deskripsi Konten (MENGHILANGKAN GRADIENT) --}}
                            <div class="relative w-full text-center overflow-hidden">
                                {{-- line-clamp-4 tetap digunakan untuk membatasi tinggi dan menjaga keseragaman card --}}
                                <p class="text-gray-700 text-sm mt-1 line-clamp-4 px-1">
                                    {{ $pejabat->deskripsi }}
                                </p>
                                {{-- EFEK GRADASI DIHAPUS --}}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">Data pemangku jabatan belum tersedia.</p>
                @endforelse
            </div>

            {{-- KODE BARU: Footer Pemangku Jabatan (DIBAWAH CARD) --}}
            <div class="mt-8 pt-8 border-t-4 border-sukorame-purple-light text-center">
                <h3
                    class="text-3xl md:text-4xl font-extrabold text-sukorame-purple tracking-widest uppercase mb-2 drop-shadow-md">
                    KANTOR KELURAHAN SUKORAME
                </h3>
                <p class="text-xl md:text-2xl font-bold text-sukorame-green-dark tracking-wide italic">
                    Sepenuh Hati Mengabdi dan Melayani
                </p>
            </div>
        </div>
    </section>

    {{-- 4. Aplikasi Layanan Publik (KEMBALI KE POSISI TERBAWAH DENGAN TAMPILAN GRID 6 KOLOM) --}}
    <section class="py-20 bg-gradient-to-b from-white via-gray-50 to-sukorame-green/10 text-center">
        <div class="bg-sukorame-green py-4 mb-12 rounded-lg shadow-lg shadow-sukorame-green/40">
            <h2 class="text-3xl font-extrabold text-sukorame-purple uppercase tracking-wide">
                APLIKASI LAYANAN PUBLIK
            </h2>
        </div>
        <div class="container mx-auto px-6">
            {{-- Tampilan Grid/Flex yang Disesuaikan --}}
            <div
                class="flex flex-wrap justify-center gap-x-8 gap-y-12 mb-16 max-w-7xl mx-auto 
                                                                                lg:grid lg:grid-cols-6 lg:gap-x-4 lg:gap-y-0">

                {{-- E-Suket --}}
                <a href="https://esuket.kedirikota.go.id/" target="_blank"
                    class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500 w-[120px] lg:w-auto">

                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo E-Suket"
                            class="w-20 h-20 md:w-28 md:h-28 object-contain">
                    </div>

                    <span class="mt-3 font-semibold text-sukorame-purple text-sm md:text-base">E-Suket</span>

                </a>


                {{-- SAKTI --}}
                <a href="https://disdukcapil.kedirikota.go.id/" target="_blank"
                    class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500 w-[120px] lg:w-auto">

                    <div class="bg-gradient-to-br from-white to-sukorame-green/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo SAKTI"
                            class="w-20 h-20 md:w-28 md:h-28 object-contain">
                    </div>

                    <span class="mt-3 font-semibold text-sukorame-purple text-sm md:text-base">SAKTI</span>

                </a>


                {{-- Cek Bansos --}}
                <div
                    class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500 w-[120px] lg:w-auto">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo Cek Bansos"
                            class="w-20 h-20 md:w-28 md:h-28 object-contain">
                    </div>
                    <span class="mt-3 font-semibold text-sukorame-purple text-sm md:text-base">Cek Bansos</span>
                </div>

                {{-- Aplikasi Surat Pengantar --}}
                <div
                    class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500 w-[120px] lg:w-auto">
                    <div class="bg-gradient-to-br from-white to-sukorame-green/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo Surat Pengantar"
                            class="w-20 h-20 md:w-28 md:h-28 object-contain">
                    </div>
                    <span class="mt-3 font-semibold text-sukorame-purple text-sm md:text-base">Surat Pengantar</span>
                </div>

                {{-- UMKM Desa --}}
                <div
                    class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500 w-[120px] lg:w-auto">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo UMKM Desa"
                            class="w-20 h-20 md:w-28 md:h-28 object-contain">
                    </div>
                    <span class="mt-3 font-semibold text-sukorame-purple text-sm md:text-base">UMKM Desa</span>
                </div>

                {{-- Pemetaan Kos --}}
                <div
                    class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500 w-[120px] lg:w-auto">
                    <div class="bg-gradient-to-br from-white to-sukorame-green/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo Pemetaan Kos"
                            class="w-20 h-20 md:w-28 md:h-28 object-contain">
                    </div>
                    <span class="mt-3 font-semibold text-sukorame-purple text-sm md:text-base">Pemetaan Kos</span>
                </div>

            </div>

            <a href="{{ url('/buku-tamu') }}"
                class="inline-block bg-sukorame-purple-light text-sukorame-purple font-bold py-4 px-10 rounded-full shadow-md hover:shadow-xl hover:bg-opacity-90 hover:scale-[1.05] transition duration-500 ease-out">
                Klik untuk mengisi buku tamu
            </a>
        </div>
    </section>

@endsection