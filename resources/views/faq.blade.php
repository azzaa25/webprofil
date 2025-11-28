{{-- Lokasi file: resources/views/faq.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', 'FAQ')

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

        {{-- Daftar Pertanyaan dari Database --}}
        <div class="space-y-6">
            @foreach ($faqList as $index => $faq)
                <div class="bg-[#D4F36B] rounded-2xl p-5 shadow-sm">
                    <button type="button"
                        class="w-full flex justify-between items-center font-semibold text-left text-black text-lg focus:outline-none transition-all duration-300 ease-in-out">
                        {{ $loop->iteration }}. {{ $faq->pertanyaan }}
                        <i class="faq-icon text-xl font-bold">+</i>
                    </button>
                    <div class="hidden mt-3 text-sm text-black leading-relaxed">
                        {{ $faq->jawaban }}
                    </div>
                </div>
            @endforeach

            @if ($faqList->isEmpty())
                <p class="text-center text-gray-600 italic">Belum ada data FAQ.</p>
            @endif
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