{{-- Lokasi file: resources/views/beranda.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Beranda - Kelurahan Sukorame')

@section('content')

    {{-- Hero Section --}}
    <section
        class="relative bg-gradient-to-br from-sukorame-purple via-sukorame-purple-light to-sukorame-green text-white text-center py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-50">
            <img src="{{ asset('img/kantor.jpg') }}" alt="Foto Kelurahan Sukorame" class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 container mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 drop-shadow-lg tracking-wide">
                KOTA KEDIRI MAPAN
            </h1>
            <div x-data="{ active: 0, total: {{ count($berita) }} }"
                x-init="setInterval(() => active = (active + 1) % total, 4000)"
                class="relative w-full max-w-5xl mx-auto h-64 md:h-96 rounded-xl overflow-hidden shadow-2xl ring-4 ring-white/20 transform hover:scale-[1.02] transition duration-500 ease-out">

                {{-- Slider Gambar --}}
                @foreach($berita as $i => $item)
                    <div x-show="active === {{ $i }}" x-transition.opacity.duration.700ms class="absolute inset-0">
                        @if(!empty($item->gambar) && Storage::disk('public')->exists($item->gambar))
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('img/default.jpg') }}" alt="Gambar tidak tersedia"
                                class="w-full h-full object-cover">
                        @endif

                        {{-- Teks judul opsional di bawah gambar --}}
                        <!-- <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-3">
                            <h3 class="text-white text-lg font-semibold">{{ $item->judul }}</h3>
                        </div> -->
                    </div>
                @endforeach

                {{-- Tombol panah kiri-kanan --}}
                <button @click="active = active > 0 ? active - 1 : total - 1"
                    class="absolute top-1/2 left-3 -translate-y-1/2 bg-white/60 hover:bg-white text-gray-700 rounded-full p-2 shadow-md">
                    ‹
                </button>
                <button @click="active = (active + 1) % total"
                    class="absolute top-1/2 right-3 -translate-y-1/2 bg-white/60 hover:bg-white text-gray-700 rounded-full p-2 shadow-md">
                    ›
                </button>

                {{-- Indikator lingkaran kecil --}}
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2">
                    @foreach($berita as $i => $item)
                        <button @click="active = {{ $i }}" :class="active === {{ $i }} ? 'bg-white' : 'bg-gray-400/70'"
                            class="w-3 h-3 rounded-full transition"></button>
                    @endforeach
                </div>
            </div>


        </div>
    </section>

    {{-- Tentang Kelurahan --}}
    <section class="py-20 bg-gradient-to-b from-white via-gray-50 to-sukorame-green/10">
        <div class="bg-sukorame-green py-4 mb-12 rounded-lg shadow-lg shadow-sukorame-green/30">
            <h2 class="text-3xl font-extrabold text-sukorame-purple text-center tracking-wide uppercase">
                KELURAHAN SUKORAME
            </h2>
        </div>
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-700 max-w-4xl mx-auto mb-16 text-lg leading-relaxed">
                Kelurahan Sukorame berkomitmen memberikan pelayanan publik yang modern, profesional, dan transparan berbasis
                teknologi informasi untuk mewujudkan masyarakat yang MAPAN (Mandiri, Aman, Produktif, dan Nyaman).
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div
                    class="bg-gradient-to-br from-white to-sukorame-purple-light/20 border border-sukorame-purple-light p-8 rounded-2xl shadow-md hover:shadow-2xl hover:scale-[1.03] transition duration-500 transform hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-sukorame-purple mb-4">Pelayanan Online</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Layanan berbasis web yang memudahkan masyarakat dalam pengurusan surat tanpa harus datang langsung
                        ke kantor kelurahan.
                    </p>
                </div>
                <div
                    class="bg-gradient-to-br from-white to-sukorame-green/20 border border-sukorame-green p-8 rounded-2xl shadow-md hover:shadow-2xl hover:scale-[1.03] transition duration-500 transform hover:-translate-y-1">
                    <h3 class="text-xl font-bold text-sukorame-purple mb-4">Berita Warga</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Informasi dan berita terkini dari masyarakat dan kegiatan kelurahan untuk memperkuat transparansi
                        dan partisipasi warga.
                    </p>
                </div>
                <div
                    class="bg-gradient-to-br from-sukorame-purple to-sukorame-purple-light text-white p-8 rounded-2xl shadow-md hover:shadow-xl hover:scale-[1.03] transition duration-500 transform hover:-translate-y-1">
                    <h3 class="text-xl font-bold mb-4">Galeri Kelurahan</h3>
                    <p class="leading-relaxed opacity-90">
                        Dokumentasi kegiatan pemerintahan dan masyarakat sebagai bentuk akuntabilitas publik dan kebersamaan
                        warga Sukorame.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Pemangku Jabatan --}}
    <section class="py-20 bg-gradient-to-t from-sukorame-green/10 via-white to-sukorame-purple-light/10">
        <div class="bg-sukorame-green py-4 mb-12 rounded-lg shadow-lg shadow-sukorame-green/40">
            <h2 class="text-3xl font-extrabold text-sukorame-purple text-center uppercase tracking-wide">
                PEMANGKU JABATAN
            </h2>
        </div>
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-16">
                <!-- Kepala Desa -->
                <div class="text-center transform hover:scale-[1.05] transition duration-500 hover:-translate-y-2">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/30 p-4 rounded-2xl shadow-md hover:shadow-2xl">
                        <img src="https://i.pravatar.cc/150?img=1" alt="Kepala Desa"
                            class="w-36 h-36 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Kepala Desa</h4>
                        <p class="text-gray-500 text-sm">Pimpinan Kelurahan Sukorame</p>
                    </div>
                </div>

                <!-- Sekretaris -->
                <div class="text-center transform hover:scale-[1.05] transition duration-500 hover:-translate-y-2">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-green/30 p-4 rounded-2xl shadow-md hover:shadow-2xl">
                        <img src="https://i.pravatar.cc/150?img=2" alt="Sekretaris"
                            class="w-36 h-36 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Sekretaris</h4>
                        <p class="text-gray-500 text-sm">Koordinasi Administratif</p>
                    </div>
                </div>

                <!-- Kasi Pelayanan -->
                <div class="text-center transform hover:scale-[1.05] transition duration-500 hover:-translate-y-2">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/30 p-4 rounded-2xl shadow-md hover:shadow-2xl">
                        <img src="https://i.pravatar.cc/150?img=3" alt="Kasi Pelayanan"
                            class="w-36 h-36 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Kasi Pelayanan</h4>
                        <p class="text-gray-500 text-sm">Pelayanan Masyarakat</p>
                    </div>
                </div>

                <!-- Kasi Keuangan -->
                <div class="text-center transform hover:scale-[1.05] transition duration-500 hover:-translate-y-2">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-green/30 p-4 rounded-2xl shadow-md hover:shadow-2xl">
                        <img src="https://i.pravatar.cc/150?img=4" alt="Kasi Keuangan"
                            class="w-36 h-36 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Kasi Keuangan</h4>
                        <p class="text-gray-500 text-sm">Pengelolaan Keuangan Desa</p>
                    </div>
                </div>

                <!-- Kasi Pembangunan -->
                <div class="text-center transform hover:scale-[1.05] transition duration-500 hover:-translate-y-2">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/30 p-4 rounded-2xl shadow-md hover:shadow-2xl">
                        <img src="https://i.pravatar.cc/150?img=5" alt="Kasi Pembangunan"
                            class="w-36 h-36 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Kasi Pembangunan</h4>
                        <p class="text-gray-500 text-sm">Perencanaan dan Infrastruktur</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Aplikasi Layanan Publik --}}
    <section class="py-20 bg-gradient-to-b from-white via-gray-50 to-sukorame-green/10 text-center">
        <div class="bg-sukorame-green py-4 mb-12 rounded-lg shadow-lg shadow-sukorame-green/40">
            <h2 class="text-3xl font-extrabold text-sukorame-purple uppercase tracking-wide">
                APLIKASI LAYANAN PUBLIK
            </h2>
        </div>
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-12 md:gap-20 mb-16">
                <div class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo E-Suket" class="w-28 h-28 object-contain">
                    </div>
                    <span class="mt-3 font-semibold text-sukorame-purple">E-Suket</span>
                </div>
                <div class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500">
                    <div class="bg-gradient-to-br from-white to-sukorame-green/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo SAKTI" class="w-28 h-28 object-contain">
                    </div>
                    <span class="mt-3 font-semibold text-sukorame-purple">SAKTI</span>
                </div>
                <div class="flex flex-col items-center transform hover:scale-[1.1] transition duration-500">
                    <div
                        class="bg-gradient-to-br from-white to-sukorame-purple-light/20 p-6 rounded-xl shadow-md hover:shadow-xl">
                        <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo Cek Bansos"
                            class="w-28 h-28 object-contain">
                    </div>
                    <span class="mt-3 font-semibold text-sukorame-purple">Cek Bansos</span>
                </div>
            </div>

            <a href="{{ url('/buku-tamu') }}"
                class="inline-block bg-sukorame-purple-light text-sukorame-purple font-bold py-4 px-10 rounded-full shadow-md hover:shadow-xl hover:bg-opacity-90 hover:scale-[1.05] transition duration-500 ease-out">
                Klik untuk mengisi buku tamu
            </a>
        </div>
    </section>

@endsection