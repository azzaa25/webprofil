@extends('layouts.nav_webprof')

@section('title', $pelayanan->nama_pelayanan . ' - Detail Layanan')

@section('content')
<div class="bg-[#f9fdf5] py-12 md:py-16 px-4">
    <div class="container mx-auto max-w-5xl">

        {{-- HEADER --}}
        <header class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $pelayanan->nama_pelayanan }}</h1>
            <p class="text-gray-600 text-sm">{{ $pelayanan->tanggal_publikasi->format('d F Y') }}</p>
        </header>

        {{-- DESKRIPSI --}}
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Layanan:</h2>
            <p class="text-gray-700 leading-relaxed">{{ $pelayanan->deskripsi }}</p>
        </section>

        {{-- SYARAT & PROSES --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            {{-- Persyaratan --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Persyaratan:</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-1">
                    @foreach ($pelayanan->persyaratan ?? [] as $syarat)
                        <li>{{ $syarat }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Proses --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Proses Pengurusan:</h3>
                <ol class="list-decimal list-inside text-gray-700 space-y-1">
                    @foreach ($pelayanan->proses ?? [] as $proses)
                        <li>{{ $proses }}</li>
                    @endforeach
                </ol>
            </div>
        </div>

        {{-- WAKTU & KETERANGAN --}}
        <div class="bg-white rounded-xl shadow p-6 mb-12">
            <p class="mb-2"><strong>Waktu Pelayanan:</strong> {{ $pelayanan->waktu_layanan ?? '-' }}</p>
            <p><strong>Keterangan:</strong> {{ $pelayanan->keterangan ?? '-' }}</p>
        </div>

        {{-- PELAYANAN LAINNYA --}}
        @if ($lainnya->count() > 0)
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Pelayanan Lainnya</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($lainnya as $item)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-xl transition-all">
                        <h3 class="font-poppins text-xl font-bold text-gray-900 mb-2">{{ $item->nama_pelayanan }}</h3>
                        <p class="text-gray-700 text-sm leading-relaxed mb-4 line-clamp-3">
                            {{ Str::limit($item->deskripsi, 100) }}
                        </p>

                        <div class="flex items-center text-gray-600 text-sm mb-2">
                            <i class="fas fa-clock mr-2 text-green-700"></i> {{ $item->waktu_layanan ?? 'Tidak ditentukan' }}
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('publik.detail_pelayanan', $item->id_pelayanan) }}" 
                               class="bg-[#4c3588] hover:bg-[#3b2970] text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Detail Layanan
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection
