@extends('layouts.nav_webprof')

@section('title', $pelayanan->nama_pelayanan . ' - Detail Layanan')

@section('content')

    <div class="bg-[#f9fdf5] py-12 md:py-16 px-4">

        {{-- BREADCRUMB --}}
        <div class="mb-6 flex items-center text-sm text-gray-600">

            <a href="{{ route('publik.pelayanan') }}"
                class="text-[#4c3588] font-semibold hover:underline flex items-center gap-2">
                <i class="fas fa-arrow-left text-[#4c3588] text-xs"></i>
                <span>Kembali ke Pelayanan</span>
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900 font-semibold">
                Detail Layanan
            </span>
        </div>

        <div class="container mx-auto max-w-5xl">

            {{-- HEADER --}}
            <header class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    {{ $pelayanan->nama_pelayanan }}
                </h1>
                <p class="text-gray-600 text-sm">
                    {{ $pelayanan->tanggal_publikasi->translatedFormat('d F Y') }}
                </p>
            </header>

            {{-- CARD DESKRIPSI --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8 mb-10">
                <h2 class="text-xl font-bold text-gray-800 mb-3">Deskripsi Layanan</h2>
                <p class="text-gray-700 leading-relaxed">
                    {{ $pelayanan->deskripsi }}
                </p>
            </div>

            {{-- GRID PERSYARATAN & PROSES --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

                {{-- CARD PERSYARATAN --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Persyaratan</h3>
                    <ul class="space-y-2 text-gray-700">
                        @foreach ($pelayanan->persyaratan ?? [] as $syarat)
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-600 mt-1"></i>
                                <span>{{ $syarat }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- CARD PROSES --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Proses Pengurusan</h3>
                    <ol class="space-y-2 text-gray-700 list-decimal list-inside">
                        @foreach ($pelayanan->proses ?? [] as $proses)
                            <li>{{ $proses }}</li>
                        @endforeach
                    </ol>
                </div>

            </div>

            {{-- CARD WAKTU & KETERANGAN --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8 mb-12">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Tambahan</h3>

                <p class="mb-3">
                    <strong>Waktu Pelayanan:</strong>
                    <span class="text-gray-700">{{ $pelayanan->waktu_layanan ?? '-' }}</span>
                </p>

                <p>
                    <strong>Keterangan:</strong>
                    <span class="text-gray-700">{{ $pelayanan->keterangan ?? '-' }}</span>
                </p>
            </div>

            {{-- SOP --}}
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">SOP Pelayanan</h2>

            {{-- Ambil gambar SOP dari Profile Data --}}
            @if(isset($profileData) && $profileData->gambar_sop)
                <div class="text-center">
                    <img src="{{ Storage::url($profileData->gambar_sop) }}" class="rounded-xl shadow img-fluid"
                        alt="SOP Pelayanan Global" style="max-width: 100%; height: auto;">
                </div>
            @else
                {{-- Tampilkan placeholder jika gambar SOP belum diunggah --}}
                <div class="text-center p-5 border rounded bg-light">
                    <p class="text-muted">Gambar SOP Pelayanan (Global) belum tersedia.</p>
                </div>
            @endif

            {{-- PELAYANAN LAINNYA --}}
            @if ($lainnya->count() > 0)
                <section class="mt-14">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Pelayanan Lainnya</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                        @foreach ($lainnya as $item)
                            <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-xl transition-all">

                                <h3 class="font-poppins text-xl font-bold text-gray-900 mb-2">
                                    {{ $item->nama_pelayanan }}
                                </h3>

                                <p class="text-gray-700 text-sm leading-relaxed line-clamp-3 mb-4">
                                    {{ Str::limit($item->deskripsi, 100) }}
                                </p>

                                <div class="flex items-center text-gray-600 text-sm mb-4">
                                    <i class="fas fa-clock mr-2 text-sukorame-purple"></i>
                                    {{ $item->waktu_layanan ?? 'Tidak ditentukan' }}
                                </div>

                                <a href="{{ route('publik.detail_pelayanan', $item->id_pelayanan) }}" class="bg-[#4c3588] hover:bg-[#3b2970] text-white px-4 py-2 rounded-lg text-sm font-semibold
                                                  flex items-center justify-center w-full">
                                    <i class="fas fa-info-circle mr-2"></i> Detail Layanan
                                </a>

                            </div>
                        @endforeach

                    </div>
                </section>
            @endif

        </div>
    </div>

@endsection