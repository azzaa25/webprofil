{{-- resources/views/kependudukan.blade.php --}}
@extends('layouts.nav_webprof')

@section('title', ' Kependudukan ')

@section('content')
    <div class="bg-[#f9fdf5] py-12 md:py-16 px-4">
        <div class="container mx-auto max-w-6xl">

            {{-- Judul Halaman --}}
            <h1 class="text-4xl font-semibold text-center mb-10 text-gray-800">
                Struktur Kependudukan Kelurahan Sukorame
            </h1>

            {{-- Bagian A --}}
            <section class="mb-12">
                <h2 class="text-xl font-semibold mb-4">A. Jumlah Penduduk dan Kepadatan Penduduk</h2>
                <p class="mb-2">Jumlah penduduk Kelurahan Sukorame Kecamatan Mojoroto Kota Kediri adalah :</p>
                <ul class="space-y-1">
                    <li>Jumlah laki-laki: <strong>{{ $jumlahLaki }} orang</strong></li>
                    <li>Jumlah perempuan: <strong>{{ $jumlahPerempuan }} orang</strong></li>
                    <li>Jumlah anomali: <strong>{{ $jumlahAnomali }} orang</strong></li>
                    <li>Jumlah total: <strong>{{ $totalPenduduk }} orang</strong></li>

                </ul>
            </section>


            {{-- Bagian B --}}
            {{-- Bagian B --}}
            <section class="mb-12">
                <h2 class="text-xl font-semibold mb-4">B. Usia</h2>
                <div class="overflow-x-auto">
                    <table class="border border-gray-300">
                        <thead class="bg-sukorame-green">
                            <tr>
                                <th class="border px-4 py-2">Kelompok Usia</th>
                                <th class="border px-4 py-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelompokUsia as $kelompok => $jumlah)
                                <tr>
                                    <td class="border px-4 py-2">{{ $kelompok }}</td>
                                    <td class="border px-4 py-2" colspan="2">{{ $jumlah }} orang</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-2">Tidak ada data usia</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </section>


            {{-- Bagian C --}}
            <!-- <section class="mb-12">
                    <h2 class="text-xl font-semibold mb-4">C. Pendidikan</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300">
                            <thead class="bg-green-100">
                                <tr>
                                    <th class="border px-4 py-2">Tingkat Pendidikan</th>
                                    <th class="border px-4 py-2">Laki-laki</th>
                                    <th class="border px-4 py-2">Perempuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendidikan as $tingkat => $jumlah)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $tingkat }}</td>
                                        <td class="border px-4 py-2" colspan="2">{{ $jumlah }} orang</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-2">Tidak ada data pendidikan</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </section> -->


            {{-- Bagian D --}}
            <section>
                <h2 class="text-xl font-semibold mb-4">C. Pekerjaan</h2>
                <div class="overflow-x-auto">
                    <table class="border border-gray-300">
                        <thead class="bg-sukorame-green">
                            <tr>
                                <th class="border px-4 py-2">Jenis Pekerjaan</th>
                                <th class="border px-4 py-2">Jumlah</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pekerjaan as $jenis => $jumlah)
                                <tr>
                                    <td class="border px-4 py-2">{{ $jenis }}</td>
                                    <td class="border px-4 py-2" colspan="2">{{ $jumlah }} orang</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-2">Tidak ada data pekerjaan</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Bagian E --}}
            <section class="mt-12">
                <h2 class="text-xl font-semibold mb-4">D. Agama</h2>
                <div class="overflow-x-auto">
                    <table class="border border-gray-300">
                        <thead class="bg-sukorame-green">
                            <tr>
                                <th class="border px-4 py-2">Agama</th>
                                <th class="border px-4 py-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agama as $namaAgama => $jumlah)
                                <tr>
                                    <td class="border px-4 py-2">{{ $namaAgama }}</td>
                                    <td class="border px-4 py-2">{{ $jumlah }} orang</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-2">Tidak ada data agama</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>


        </div>
    </div>
@endsection