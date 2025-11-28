@extends('layouts.nav_webprof')

@section('title', 'Profil Sukorame')

@section('content')
    <div class="py-12 md:py-16 px-4">
        <div class="container mx-auto max-w-5xl">

            {{-- HEADER --}}
            <header class="text-center mb-12">
                <h1 class="font-poppins text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">
                    Selamat Datang di Halaman Profil
                </h1>
                <p class="text-gray-700 font-poppins text-sm md:text-base">
                    Mengenal lebih dekat Kelurahan Sukorame, Kecamatan Mojoroto, Kota Kediri
                </p>
            </header>

            {{-- TENTANG DESA (statis) --}}
            <section
                class="bg-sukorame-green p-6 md:p-8 rounded-2xl mb-8 shadow-md hover:shadow-xl  transition-all duration-300">
                <h2
                    class="font-poppins text-xl font-bold uppercase text-gray-900 mb-6 border-b-2 border-gray-900 inline-block pb-1">
                    Tentang Desa
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                    <div class="md:col-span-1 text-center">
                        <img src="{{ asset('img/logo_sukorame.png') }}" alt="Logo Sukorame" class="h-24 mb-3 mx-auto">
                        <h3 class="font-poppins font-semibold text-lg text-gray-900">Desa Sukorame</h3>
                        <p class="text-sm text-gray-700 font-poppins">Kecamatan Mojoroto, Kota Kediri</p>
                    </div>
                    <div class="md:col-span-2 font-poppins text-sm text-gray-800 leading-relaxed">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
                            <div><strong>Nama Desa:</strong> Sukorame</div>
                            <div><strong>Kecamatan:</strong> Mojoroto</div>
                            <div><strong>Kabupaten/Kota:</strong> Kota Kediri</div>
                            <div><strong>Provinsi:</strong> Jawa Timur</div>
                            <div><strong>Kode Pos:</strong> 64114</div>
                            <div><strong>Telepon:</strong> (0354) 6022152</div>
                            <div class="sm:col-span-2"><strong>Email:</strong> kelurahan.sukorame@gmail.com </div>
                            <div class="sm:col-span-2"><strong>Website:</strong> https://sukorame.kedirikota.go.id</div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- SEJARAH (dari database) --}}
            <section class="bg-white p-6 md:p-8 rounded-2xl mb-10 shadow-md hover:shadow-xl  transition-all duration-300">

                <h2
                    class="font-poppins text-xl md:text-2xl font-bold uppercase text-gray-900 mb-5 border-b-2 border-gray-900 inline-block pb-1">
                    Sejarah
                </h2>

                <p class="font-poppins text-sm md:text-base text-gray-800 leading-relaxed">
                    {{ $profil->sejarah ?? 'Belum ada data sejarah yang diinput.' }}
                </p>

            </section>


            {{-- DATA LEMBAGA --}}
            <section class="bg-white p-6 md:p-8 rounded-2xl mb-10 shadow-md hover:shadow-xl  transition-all duration-300">

                <h2
                    class="font-poppins text-xl md:text-2xl font-bold uppercase text-gray-900 mb-6 border-b-2 border-gray-900 inline-block pb-1">
                    Data Lembaga Kelurahan Sukorame
                </h2>

                @if($lembaga->isEmpty())
                    <div class="p-4 bg-yellow-100 border border-yellow-500 rounded font-poppins text-sm">
                        Belum ada data lembaga yang tersedia.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($lembaga as $item)
                            <div
                                class="bg-white p-6 rounded-xl shadow-md border border-gray-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                                <h3 class="font-poppins text-lg font-bold text-sukorame-purple mb-3">
                                    {{ $item->nama }}
                                </h3>

                                <p class="font-poppins text-sm text-gray-700 leading-relaxed">
                                    {{ Str::limit($item->deskripsi, 180) }}
                                </p>

                            </div>
                        @endforeach
                    </div>
                @endif

            </section>


            {{-- STRUKTUR PEMERINTAHAN --}}
            <section id="struktur"
                class="bg-white p-6 md:p-8 rounded-2xl mb-10 shadow-md hover:shadow-xl  transition-all duration-300">

                <h2
                    class="font-poppins text-xl md:text-2xl font-bold uppercase text-gray-900 mb-6 border-b-2 border-gray-900 inline-block pb-1">
                    Struktur Pemerintahan
                </h2>

                <div
                    class="bg-white hover:shadow-xl hover:-translate-y-1 p-5 rounded-xl shadow-inner border border-gray-200 transition-all duration-300">
                    @if (!empty($profil->struktur_path) && Storage::disk('public')->exists($profil->struktur_path))
                        <img src="{{ asset('storage/' . $profil->struktur_path) }}" alt="Struktur Organisasi"
                            class="w-full h-auto rounded-md shadow-md">
                    @else
                        <img src="{{ asset('img/struktur.png') }}" alt="Struktur Organisasi Kelurahan Sukorame"
                            class="w-full h-auto rounded-md shadow-md">
                    @endif
                </div>
            </section>

            <section>
                <h2
                    class="font-poppins text-xl md:text-2xl font-bold uppercase text-gray-900 mb-6 border-b-2 border-gray-900 inline-block pb-1">
                    Struktur Pemerintahan
                </h2>

                <div class="container mx-auto px-6">
                    <div class="flex flex-wrap justify-center gap-6 md:gap-8 mb-16">

                        @forelse($pejabatList as $pejabat)
                            {{-- Card Pejabat Dinamis --}}
                            <div
                                class="text-center transform hover:scale-[1.05] transition duration-500 hover:-translate-y-2 max-w-[220px]">
                                <div {{-- Tinggi Card Dibuat Tetap (h-[400px]) --}}
                                    class="bg-gradient-to-br border border-sukorame-purple-light border-2 from-white to-sukorame-purple-light/30 p-4 rounded-2xl shadow-md hover:shadow-2xl h-[400px] flex flex-col items-center">

                                    {{-- Foto --}}
                                    <div class="mb-4">
                                        @if(!empty($pejabat->foto_path) && Storage::disk('public')->exists($pejabat->foto_path))
                                            <img src="{{ asset('storage/' . $pejabat->foto_path) }}" alt="{{ $pejabat->jabatan }}"
                                                class="w-27 h-32 rounded-xl object-contain object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                                        @else
                                            <img src="{{ asset('img/default_avatar.jpg') }}" alt="Foto tidak tersedia"
                                                class="w-27 h-32 rounded-xl object-contain object-cover border-4 border-sukorame-purple-light shadow-lg mx-auto">
                                        @endif
                                    </div>

                                    {{-- Jabatan --}}
                                    <h4 class="font-extrabold text-lg text-sukorame-purple mb-2 break-words leading-tight px-1">
                                        {{ $pejabat->jabatan }}
                                    </h4>

                                    {{-- Deskripsi Konten (MENGHILANGKAN GRADIENT) --}}
                                    <div class="relative w-full text-center overflow-hidden">
                                        {{-- line-clamp-4 tetap digunakan untuk membatasi tinggi dan menjaga keseragaman card
                                        --}}
                                        <p class="text-gray-700 text-sm mt-1 line-clamp-4 px-1">
                                            {{ $pejabat->deskripsi }}
                                        </p>
                                        {{-- EFEK GRADASI DIHAPUS --}}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600">Data pemangku jabatan belum tersedia.</p>
                        @endforelse
                    </div>

        
                </div>
            </section>



            {{-- VISI & MISI (dari database) --}}
            <section class="bg-white p-6 md:p-8 rounded-2xl shadow-md hover:shadow-xl  transition-all duration-300">
                <h2
                    class="font-poppins text-xl font-bold uppercase text-gray-900 mb-6 border-b-2 border-gray-900 inline-block pb-1">
                    Visi dan Misi
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-poppins font-semibold text-lg text-gray-900 mb-2">Visi</h3>
                        <div class="bg-white p-4 rounded-lg shadow-inner">
                            <p class="font-poppins text-sm md:text-base text-gray-800 italic">
                                “{{ $profil->visi ?? 'Belum ada data visi yang diinput.' }}”
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-poppins font-semibold text-lg text-gray-900 mb-2">Misi</h3>
                        <div class="bg-white p-4 rounded-lg shadow-inner">
                            @if(!empty($profil->misi))
                                <ul class="list-disc list-inside space-y-2 font-poppins text-sm md:text-base text-gray-800">
                                    @foreach(explode("\n", $profil->misi) as $misi)
                                        <li>{{ $misi }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-700 italic">Belum ada data misi yang diinput.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection