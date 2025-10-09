{{-- Lokasi file: resources/views/bukutamu.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Buku Tamu - Kelurahan Sukorame')

@section('content')

    {{-- Catatan: Untuk mengaktifkan menu 'Profil' di header, Anda perlu menambahkan logika di file `layouts/master.blade.php`.
    Contoh: <a href="/profil" class="{{ Request::is('profil*') ? 'text-sukorame-purple font-bold' : 'font-semibold text-sukorame-purple' }}">Profil</a>
    --}}

    <div class="bg-white py-12 md:py-20 px-4">
        <div class="container mx-auto">

            <section class="text-center">
                <h1 class="text-3xl font-poppins font-bold text-black">Formulir Buku Tamu</h1>
                <p class="text-xl font-poppins italic text-black mt-2">Silahkan Diisi Sesuai Keperluan</p>

                <form action="#" method="POST" class="max-w-lg mx-auto mt-8 space-y-6">
                    @csrf
                    <div>
                        <input
                            type="text"
                            name="nama_lengkap"
                            id="nama_lengkap"
                            placeholder="isi nama lengkap"
                            class="w-full px-5 py-3 border border-[#cccccc] rounded-full focus:outline-none focus:ring-2 focus:ring-sukorame-purple"
                        >
                    </div>

                    <div>
                        <textarea
                            name="alamat_lengkap"
                            id="alamat_lengkap"
                            rows="4"
                            placeholder="isi alamat lengkap"
                            class="w-full px-5 py-3 border border-[#cccccc] rounded-2xl focus:outline-none focus:ring-2 focus:ring-sukorame-purple"
                        ></textarea>
                    </div>

                    <div>
                         <input
                            type="text"
                            name="keperluan"
                            id="keperluan"
                            placeholder="pilih keperluan"
                            class="w-full px-5 py-3 border border-[#cccccc] rounded-full focus:outline-none focus:ring-2 focus:ring-sukorame-purple"
                        >
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full bg-[#d7f27b] text-black font-bold uppercase py-3 rounded-full hover:bg-[#b5d85e] transition-colors duration-300"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </section>

            <section class="text-center mt-16 md:mt-24">
                <h2 class="text-2xl font-poppins font-bold text-black">Aduan Melalui Aplikasi</h2>
                <p class="text-lg font-poppins italic text-black mt-2">Lapor Mbak Wali 112</p>
            </section>

        </div>
    </div>

@endsection