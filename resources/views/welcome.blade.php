{{-- Lokasi file: resources/views/beranda.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Beranda - Kelurahan Sukorame')

@section('content')

    <section class="text-center py-12 md:py-20 px-4">
        <div class="container mx-auto">
            <h1 class="text-4xl md:text-6xl font-extrabold text-sukorame-purple mb-8">
                KOTA KEDIRI MAPAN
            </h1>
            <div class="w-full max-w-5xl mx-auto h-64 md:h-96 bg-gray-300 rounded-lg shadow-lg flex items-center justify-center">
                <img src="{{ asset('img/hewani.jpg') }}" alt="">
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20">
        <div class="bg-sukorame-green py-4 mb-12">
            <h2 class="text-3xl font-bold text-sukorame-purple text-center">
                KELURAHAN SUKORAME
            </h2>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center max-w-3xl mx-auto mb-12">
                Kelurahan sukorame adalah lorem ipsum dolor sit amet kelurahan sukorame adalah lorem ipsum dolor sit amet kelurahan sukorame adalah lorem ipsum dolor sit amet kelurahan sukorame.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-sukorame-purple-light p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-sukorame-purple mb-4">Pelayanan Online</h3>
                    <p class="text-sukorame-purple">Kelurahan Sukorame sudah menyediakan fasilitas online yang berbasis web yang bertujuan untuk memudahkan masyarakat Kelurahan Sukorame khususnya dalam mengurus surat.</p>
                </div>
                <div class="bg-sukorame-green p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-sukorame-purple mb-4">Berita Warga</h3>
                    <p class="text-gray-700">Update berita terkini di Lingkungan Kelurahan Sukorame dan sekitarnya untuk memantau perkembangan di lingkungan sekitar.</p>
                </div>
                <div class="bg-sukorame-purple text-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4">Galeri Kelurahan</h3>
                    <p>Galeri kegiatan Pemerintahan dan Warga Sukorame.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20">
        <div class="bg-sukorame-green py-4 mb-12">
            <h2 class="text-3xl font-bold text-sukorame-purple text-center">
                PEMANGKU JABATAN
            </h2>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-around">
                <button class="text-sukorame-purple p-2 rounded-full hover:bg-gray-200">
                    <!-- <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> -->
                </button>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 md:gap-16 text-center">
                    <div class="flex flex-col items-center">
                        <img src="https://i.pravatar.cc/150?img=1" alt="Kepala Desa" class="w-32 h-32 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Kepala Desa</h4>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="https://i.pravatar.cc/150?img=2" alt="Sekretaris" class="w-32 h-32 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Sekretaris</h4>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="https://i.pravatar.cc/150?img=3" alt="Kasi Pelayanan" class="w-32 h-32 rounded-full object-cover border-4 border-sukorame-purple-light shadow-lg">
                        <h4 class="mt-4 font-bold text-lg text-sukorame-purple">Kasi Pelayanan</h4>
                    </div>
                </div>

                <button class="text-sukorame-purple p-2 rounded-full hover:bg-gray-200">
                    <!-- <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> -->
                </button>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-20 text-center">
         <div class="bg-sukorame-green py-4 mb-12">
            <h2 class="text-3xl font-bold text-sukorame-purple text-center">
                APLIKASI LAYANAN PUBLIK
            </h2>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center items-start gap-12 md:gap-20 mb-12">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo E-Suket" class="w-28 h-28 object-contain">
                    <span class="mt-2 font-semibold">E-Suket</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo SAKTI" class="w-28 h-28 object-contain">
                    <span class="mt-2 font-semibold">SAKTI</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo Cek Bansos" class="w-28 h-28 object-contain">
                    <span class="mt-2 font-semibold">Cek Bansos</span>
                </div>
            </div>

            <a href="{{ url('/buku-tamu') }}" class="inline-block bg-sukorame-purple-light text-sukorame-purple font-bold py-4 px-10 rounded-lg shadow-md hover:bg-opacity-80 transition-colors">
                Klik untuk mengisi buku tamu
            </a>
        </div>
    </section>

@endsection