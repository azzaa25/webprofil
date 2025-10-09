{{-- Lokasi file: resources/views/profil.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Profil - Kelurahan Sukorame')

@section('content')

    {{-- Catatan: Logika untuk menu aktif ('Profil') idealnya diatur di file layout master,
    misalnya dengan memeriksa route saat ini. Contoh di master layout:
    <a href="/profil" class="{{ Request::is('profil') ? 'text-[#7D5AB5]' : 'text-black' }}">Profil</a>
    --}}

    <div class="bg-white py-12 md:py-16 px-4">
        <div class="container mx-auto max-w-5xl">

            <header class="text-center mb-12">
                <h1 class="font-poppins text-3xl font-extrabold text-black">
                    Selamat Datang, di Halaman Profil
                </h1>
            </header>

            <section class="bg-[#D4F36B] p-6 md:p-8 rounded-2xl mb-8 shadow-md">
                <h2 class="font-poppins text-xl font-bold uppercase text-black mb-6">TENTANG DESA</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                    <div class="md:col-span-1 flex flex-col items-center text-center">
                        <img src="{{ asset('img/logo_sukorame.png') }}" alt="Logo Sukorame Berdaya" class="h-24 mb-4">
                        <p class="font-poppins font-semibold text-black">Desa Sukorame</p>
                        <p class="font-poppins text-sm text-gray-700">Kecamatan Mojoroto, Kota Kediri</p>
                    </div>
                    <div class="md:col-span-2 font-poppins text-sm text-black">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
                            <div><strong class="font-semibold">Nama Desa:</strong> Sukorame</div>
                            <div><strong class="font-semibold">Kecamatan:</strong> Mojoroto</div>
                            <div><strong class="font-semibold">Kabupaten/Kota:</strong> Kota Kediri</div>
                            <div><strong class="font-semibold">Provinsi:</strong> Jawa Timur</div>
                            <div><strong class="font-semibold">Kode Pos:</strong> 64114</div>
                            <div><strong class="font-semibold">Telepon:</strong> (0354) 6022152</div>
                            <div class="sm:col-span-2"><strong class="font-semibold">Email:</strong> Kelurahan.Sukorame@gmail.com</div>
                            <div class="sm:col-span-2"><strong class="font-semibold">Website:</strong> https://sukorame.kedirikota.go.id</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-[#D4F36B] p-6 md:p-8 rounded-xl mb-8 shadow-md">
                <h2 class="font-poppins text-xl font-bold uppercase text-black mb-4">SEJARAH</h2>
                <p class="font-poppins text-sm text-black leading-relaxed">
                    Lorem ipsum dolor sitamet lorem impsumdolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem impsumdolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem impsum olor sit amet lorem. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
            </section>

            <section class="bg-[#D4F36B] p-6 md:p-8 rounded-xl mb-8 shadow-md">
                <h2 class="font-poppins text-xl font-bold uppercase text-black mb-4">STRUKTUR PEMERINTAHAN</h2>
                <div class="bg-white p-4 rounded-lg">
                    <img src="{{ asset('img/struktur.png') }}" alt="Bagan Struktur Organisasi Kelurahan Sukorame" class="w-full h-auto rounded-md">
                </div>
            </section>

            <section class="bg-[#D4F36B] p-6 md:p-8 rounded-xl shadow-md">
                <h2 class="font-poppins text-xl font-bold uppercase text-black mb-4">VISI DAN MISI</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-poppins font-bold text-black mb-2">Visi</h3>
                        <div class="bg-[#EAEAEA] p-4 rounded-lg">
                            <p class="font-poppins text-sm text-black">
                                "Pelayanan Prima untuk meningkatkan pemberdayaan masyarakat demi terciptanya kesejahteraan"
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-poppins font-bold text-black mb-2">Misi</h3>
                        <div class="bg-white p-4 rounded-lg">
                            <ol class="list-decimal list-inside space-y-2 font-poppins text-sm text-black">
                                <li>Meningkatkan kedisiplinan peran dan fungsi kelurahan dalam pelaksanaan administrasi, pemerintahan dan pelayanan publik.</li>
                                <li>Meningkatkan penyebarluasan informasi kepada masyarakat tentang penyelenggaraan pemerintahan dan hasil pembangunan.</li>
                                <li>Meningkatkan partisipasi masyarakat dalam proses perencanaan pembangunan di tingkat kelurahan.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection