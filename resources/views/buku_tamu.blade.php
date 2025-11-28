{{-- Lokasi file: resources/views/bukutamu.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'Buku Tamu')

@section('content')
    <section class="bg-[#f9fdf5] py-16 md:py-24 px-6">
        <div class="container mx-auto">
            {{-- Judul Halaman --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 font-poppins tracking-tight">
                    Buku Tamu Kelurahan Sukorame
                </h1>
                <p class="text-lg md:text-xl italic text-gray-700 mt-2">
                    Silakan isi formulir berikut sesuai keperluan Anda
                </p>
            </div>

            {{-- FORM BUKU TAMU --}}
            <form action="{{ route('bukutamu.store') }}" method="POST"
                class="max-w-xl mx-auto bg-gray-50 border border-gray-200 shadow-xl rounded-3xl px-8 py-10 space-y-6 hover:shadow-2xl transition-all duration-300 ease-in-out">
                @csrf
                
                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap" class="block text-left text-gray-800 font-semibold mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        name="nama_lengkap"
                        id="nama_lengkap"
                        placeholder="Masukkan nama lengkap Anda"
                        value="{{ old('nama_lengkap') }}"
                        class="w-full px-5 py-3 border @error('nama_lengkap') border-red-500 ring-red-200 @else border-gray-300 @enderror rounded-full focus:outline-none focus:ring-4 focus:ring-[#cbb2ff] focus:border-[#cbb2ff] transition-all duration-300"
                        {{-- Hapus atribut 'required' --}}
                        >
                    @error('nama_lengkap')
                        <div class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Lengkap --}}
                <div>
                    <label for="alamat_lengkap" class="block text-left text-gray-800 font-semibold mb-2">
                        Alamat Lengkap
                    </label>
                    <textarea
                        name="alamat_lengkap"
                        id="alamat_lengkap"
                        rows="4"
                        placeholder="Masukkan alamat lengkap Anda"
                        class="w-full px-5 py-3 border @error('alamat_lengkap') border-red-500 ring-red-200 @else border-gray-300 @enderror rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#cbb2ff] focus:border-[#cbb2ff] transition-all duration-300"
                        {{-- Hapus atribut 'required' --}}
                    >{{ old('alamat_lengkap') }}</textarea>
                    @error('alamat_lengkap')
                        <div class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keperluan --}}
                <div>
                    <label for="keperluan" class="block text-left text-gray-800 font-semibold mb-2">
                        Keperluan
                    </label>
                    <input
                        type="text"
                        name="keperluan"
                        id="keperluan"
                        placeholder="Tuliskan keperluan Anda di sini"
                        value="{{ old('keperluan') }}"
                        class="w-full px-5 py-3 border @error('keperluan') border-red-500 ring-red-200 @else border-gray-300 @enderror rounded-full focus:outline-none focus:ring-4 focus:ring-[#cbb2ff] focus:border-[#cbb2ff] transition-all duration-300"
                        {{-- Hapus atribut 'required' --}}
                        >
                    @error('keperluan')
                        <div class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full bg-[#d7f27b] text-sukorame-purple font-bold uppercase py-3 rounded-full shadow-md hover:shadow-xl  transition-all duration-300 ease-in-out">
                        Kirim Buku Tamu
                    </button>
                </div>
            </form>

            {{-- Bagian Aduan --}}
            <div class="text-center mt-20">
                <h2 class="text-3xl font-extrabold text-sukorame-purple font-poppins">
                    Aduan Melalui Aplikasi
                </h2>
                <p class="text-lg italic text-gray-700 mt-2">Lapor Mbak Wali <span class="font-semibold text-black">112</span></p>

                {{-- Tombol Lapor --}}
                <a href="https://lapormbakwali.kedirikota.go.id/"
                    target="_blank"
                    class="inline-block mt-6 bg-sukorame-purple text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-[#b392f5] hover:shadow-xl transition-all duration-300">
                    Lapor Sekarang
                </a>
            </div>
        </div>
    </section>
    
    {{-- SWEETALERT SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menangkap pesan sukses dari Controller (setelah submit berhasil)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}", // Menampilkan pesan: "Terima kasih! ✅ Data buku tamu Anda telah berhasil dicatat."
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });
    </script>
@endsection
