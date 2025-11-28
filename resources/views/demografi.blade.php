@extends('layouts.nav_webprof')

@section('title', 'Demografi')

@section('content')
    <div class="bg-[#f9fdf5] py-12 px-4">
        <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-2xl p-8">
            <div class="flex items-center mb-6 border-b pb-3">
                <i class="fas fa-city text-sukorame-green text-2xl mr-3"></i>
                <h2 class="text-2xl font-bold text-gray-800">Demografi Tempat</h2>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-left text-gray-700">
                    <thead class="bg-sukorame-green text-gray-900 uppercase text-sm">
                        <tr>
                            <th class="py-3 px-4">Nama Tempat</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Deskripsi</th>
                            <th class="py-3 px-4">RT</th>
                            <th class="py-3 px-4">RW</th>
                            <th class="py-3 px-4">Latitude</th>
                            <th class="py-3 px-4">Longitude</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bangunans as $item)
                            <tr class="border-t hover:bg-green-50 transition">
                                <td class="py-3 px-4 font-semibold text-gray-900">
                                    {{ data_get($item, 'nama_bangunan') }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ data_get($item, 'kategori') }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ data_get($item, 'deskripsi') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    {{ data_get($item, 'rt_id') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    {{ data_get($item, 'rw_id') }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ data_get($item, 'latitude') }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ data_get($item, 'longitude') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                    Tidak ada data bangunan yang tersedia.
                                </td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>

            {{-- Jumlah total data --}}
            @if(count($bangunans) > 0)
                <div class="mt-4 text-sm text-gray-600">
                    <i class="fas fa-database mr-1 text-sukorame-green"></i>
                    Total Tempat: <span class="font-semibold text-gray-800">{{ count($bangunans) }}</span>
                </div>
            @endif
        </div>
    </div>
@endsection