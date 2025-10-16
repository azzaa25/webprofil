{{-- Lokasi file: resources/views/profil.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Profil - Kelurahan Sukorame')

@section('content')
<div class="bg-[#f9fdf5] py-12 md:py-16 px-4">
    <div class="container mx-auto max-w-5xl">

        {{-- HEADER --}}
        <header class="text-center mb-12">
            <h1 class="font-poppins text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">
                Selamat Datang di Halaman Profil
            </h1>
            <p class="text-gray-600 font-poppins text-sm md:text-base">
                Mengenal lebih dekat Kelurahan Sukorame, Kecamatan Mojoroto, Kota Kediri 🌿
            </p>
        </header>

        {{-- TENTANG DESA --}}
        <section class="bg-[#D4F36B] p-6 md:p-8 rounded-2xl mb-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <h2 class="font-poppins text-xl font-bold uppercase text-gray-900 mb-6 border-b-2 border-[#7D5AB5] inline-block pb-1">
                Tentang Desa
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <div class="md:col-span-1 text-center">
                    <img src="{{ asset('img/logo_sukorame.png') }}" alt="Logo Sukorame" class="h-24 mb-3 mx-auto">
                    <h3 class="font-poppins font-semibold text-lg text-gray-900">Desa Sukorame</h3>
                    <p class="text-sm text-gray-700 font-poppins">Kecamatan Mojoroto, Kota Kediri</p>
                </div>
                <div class="md:col-span-2 font-poppins text-sm text-gray-800 leading-relaxed">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
                        <div><strong>Nama Desa:</strong> Sukorame</div>
                        <div><strong>Kecamatan:</strong> Mojoroto</div>
                        <div><strong>Kabupaten/Kota:</strong> Kota Kediri</div>
                        <div><strong>Provinsi:</strong> Jawa Timur</div>
                        <div><strong>Kode Pos:</strong> 64114</div>
                        <div><strong>Telepon:</strong> (0354) 6022152</div>
                        <div class="sm:col-span-2"><strong>Email:</strong> Kelurahan.Sukorame@gmail.com</div>
                        <div class="sm:col-span-2"><strong>Website:</strong> https://sukorame.kedirikota.go.id</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SEJARAH --}}
        <section class="bg-[#D4F36B] p-6 md:p-8 rounded-2xl mb-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <h2 class="font-poppins text-xl font-bold uppercase text-gray-900 mb-4 border-b-2 border-[#7D5AB5] inline-block pb-1">
                Sejarah
            </h2>
            <p class="font-poppins text-sm md:text-base text-gray-800 leading-relaxed">
                Kelurahan Sukorame berdiri sejak masa pemerintahan kolonial dan terus berkembang menjadi salah satu wilayah yang aktif dan produktif di Kota Kediri. Dengan semangat gotong royong, masyarakat Sukorame membangun daerahnya menuju kelurahan yang sejahtera, aman, dan berdaya saing.
            </p>
        </section>

        {{-- STRUKTUR PEMERINTAHAN --}}
        <section class="bg-[#D4F36B] p-6 md:p-8 rounded-2xl mb-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <h2 class="font-poppins text-xl font-bold uppercase text-gray-900 mb-4 border-b-2 border-[#7D5AB5] inline-block pb-1">
                Struktur Pemerintahan
            </h2>
            <div class="bg-white p-4 rounded-lg shadow-inner">
                <img src="{{ asset('img/struktur.png') }}" alt="Struktur Organisasi Kelurahan Sukorame" class="w-full h-auto rounded-md">
            </div>
        </section>

        {{-- VISI & MISI --}}
        <section class="bg-[#D4F36B] p-6 md:p-8 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <h2 class="font-poppins text-xl font-bold uppercase text-gray-900 mb-6 border-b-2 border-[#7D5AB5] inline-block pb-1">
                Visi dan Misi
            </h2>
            <div class="space-y-6">
                <div>
                    <h3 class="font-poppins font-semibold text-lg text-gray-900 mb-2">Visi</h3>
                    <div class="bg-white p-4 rounded-lg shadow-inner">
                        <p class="font-poppins text-sm md:text-base text-gray-800 italic">
                            “Pelayanan Prima untuk meningkatkan pemberdayaan masyarakat demi terciptanya kesejahteraan.”
                        </p>
                    </div>
                </div>
                <div>
                    <h3 class="font-poppins font-semibold text-lg text-gray-900 mb-2">Misi</h3>
                    <div class="bg-white p-4 rounded-lg shadow-inner">
                        <ol class="list-decimal list-inside space-y-2 font-poppins text-sm md:text-base text-gray-800">
                            <li>Meningkatkan kedisiplinan dan fungsi kelurahan dalam pelayanan publik.</li>
                            <li>Menyebarluaskan informasi tentang penyelenggaraan pemerintahan.</li>
                            <li>Mendorong partisipasi masyarakat dalam perencanaan pembangunan.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
