{{-- Lokasi file: resources/views/faq.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'FAQ - Kelurahan Sukorame')

@section('content')
<div class="bg-[#f9fdf5] py-14 px-6 md:px-10 overflow-hidden font-[Poppins]">
    <div class="container mx-auto max-w-5xl faq">

        {{-- Judul Halaman --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-black">
                Frequently Asked Question
            </h1>
            <p class="text-lg italic text-gray-700 mt-2">
                Apa saja yang harus aku tau ya?
            </p>
        </div>

        {{-- Daftar Pertanyaan --}}
        <div class="space-y-6">

            {{-- Item 1 --}}
            <div class="bg-[#D4F36B] rounded-2xl p-5 shadow-sm">
                <button type="button"
                    class="w-full flex justify-between items-center font-semibold text-left text-black text-lg focus:outline-none transition-all duration-300 ease-in-out">
                    1. Bagaimana cara mengurus surat keterangan domisili?
                    <i class="faq-icon text-xl font-bold">+</i>
                </button>
                <div class="hidden mt-3 text-sm text-black leading-relaxed">
                    Untuk mengurus surat keterangan domisili, warga dapat datang ke kantor kelurahan dengan membawa fotokopi KTP dan KK.
                    Proses verifikasi dilakukan oleh petugas, dan surat dapat diambil pada hari yang sama.
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="bg-[#D4F36B] rounded-2xl p-5 shadow-sm">
                <button type="button"
                    class="w-full flex justify-between items-center font-semibold text-left text-black text-lg focus:outline-none transition-all duration-300 ease-in-out">
                    2. Apa saja syarat untuk membuat surat keterangan usaha?
                    <i class="faq-icon text-xl font-bold">+</i>
                </button>
                <div class="hidden mt-3 text-sm text-black leading-relaxed">
                    Warga harus membawa fotokopi KTP, KK, dan surat pengantar RT/RW setempat.
                    Selain itu, nama usaha dan alamat lengkap tempat usaha perlu dicantumkan pada formulir permohonan.
                </div>
            </div>

            {{-- Item 3 --}}
            <div class="bg-[#D4F36B] rounded-2xl p-5 shadow-sm">
                <button type="button"
                    class="w-full flex justify-between items-center font-semibold text-left text-black text-lg focus:outline-none transition-all duration-300 ease-in-out">
                    3. Bagaimana prosedur pengajuan surat keterangan tidak mampu?
                    <i class="faq-icon text-xl font-bold">+</i>
                </button>
                <div class="hidden mt-3 text-sm text-black leading-relaxed">
                    Surat keterangan tidak mampu diajukan dengan membawa fotokopi KTP, KK, dan surat pengantar dari RT/RW.
                    Petugas kelurahan akan melakukan verifikasi sebelum surat diterbitkan.
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="bg-[#D4F36B] rounded-2xl p-5 shadow-sm">
                <button type="button"
                    class="w-full flex justify-between items-center font-semibold text-left text-black text-lg focus:outline-none transition-all duration-300 ease-in-out">
                    4. Apakah pelayanan di kelurahan bisa dilakukan secara online?
                    <i class="faq-icon text-xl font-bold">+</i>
                </button>
                <div class="hidden mt-3 text-sm text-black leading-relaxed">
                    Beberapa pelayanan dapat dilakukan secara online melalui situs resmi Kelurahan Sukorame.
                    Namun, untuk dokumen yang membutuhkan tanda tangan langsung, pemohon tetap perlu datang ke kantor.
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Script Dropdown Toggle --}}
<script>
document.querySelectorAll('.faq button').forEach(button => {
    button.addEventListener('click', () => {
        const content = button.nextElementSibling;
        const icon = button.querySelector('.faq-icon');

        // Toggle konten
        content.classList.toggle('hidden');

        // Ubah ikon + ↔ −
        icon.textContent = content.classList.contains('hidden') ? '+' : '−';
    });
});
</script>
@endsection
