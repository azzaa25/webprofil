{{-- Lokasi file: resources/views/pelayanan.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Pelayanan - Kelurahan Sukorame')

@section('content')

    {{-- Catatan: Untuk mengaktifkan menu 'Pelayanan' di header, Anda perlu menambahkan logika di file `layouts/master.blade.php`.
    Contoh: <a href="/pelayanan" class="{{ Request::is('pelayanan') ? 'text-sukorame-purple font-bold' : 'font-semibold text-sukorame-purple' }}">Pelayanan</a>
    --}}

    <div class="bg-white py-12 md:py-20 px-4">
        <div class="container mx-auto max-w-4xl">

            <header class="text-center mb-12">
                <h1 class="font-poppins text-3xl font-extrabold text-black">
                    Pelayanan Kantor Kelurahan Sukorame
                </h1>
            </header>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-[#D4F36B] p-5 rounded-xl shadow-md">
                    <h2 class="font-poppins text-lg font-bold uppercase mb-3">JANJI PELAYANAN</h2>
                    <p class="font-poppins text-sm text-gray-800">
                        lorem ipsum dolor sitamet lorem impsumdolor sit ametlorem ipsum dolor sit ameticlorem ipsum dolor sit amet lorem impsumdolor sit amet loremipsum dolor sit amet lorem ipsum dolor sit amet lorem impsumdolor sit amet lorem impsum olor sit amet lorem
                    </p>
                </div>

                <div class="bg-[#D4F36B] p-5 rounded-xl shadow-md">
                    <h2 class="font-poppins text-lg font-bold uppercase mb-3">JENIS PELAYANAN</h2>
                    <p class="font-poppins text-sm text-gray-800">
                        lorem ipsum dolor sitamet lorem impsumdolor sit ametlorem ipsum dolor sit ameticlorem ipsum dolor sit amet lorem impsumdolor sit amet loremipsum dolor sit amet lorem ipsum dolor sit amet lorem impsumdolor sit amet lorem impsum olor sit amet lorem
                    </p>
                </div>
            </section>

            <section class="text-center mb-12">
                <h2 class="font-poppins text-xl font-bold uppercase mb-4">SOP PELAYANAN</h2>
                <div class="bg-[#B9A6E3] p-5 rounded-xl shadow-md min-h-[200px] flex items-center justify-center">
                    <p class="text-gray-700 font-semibold"><img src="{{ asset('img/pelayanan.png') }}" alt="SOP Pelayanan"></p>
                </div>
            </section>

            <section>
                <div class="bg-[#5D4BA2] text-white p-5 rounded-xl shadow-md">
                    <h2 class="font-poppins text-lg font-bold uppercase mb-3">MAKLUMAT PELAYANAN</h2>
                    <p class="font-poppins text-sm">
                        lorem ipsum dolor sitamet lorem impsumdolor sit ametlorem ipsum dolor sit ameticlorem ipsum dolor sit amet lorem impsumdolor sit amet loremipsum dolor sit amet lorem ipsum dolor sit amet lorem impsumdolor sit amet lorem impsum olor sit amet lorem
                    </p>
                </div>
            </section>

        </div>
    </div>

@endsection