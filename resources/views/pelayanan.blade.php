@extends('layouts.nav_webprof')

@section('title', 'Pelayanan')

@section('content')
    <div class="bg-[#f9fdf5] py-14 px-6 md:px-10 overflow-hidden">
        <div class="container mx-auto max-w-6xl">

            {{-- Header --}}
            <header class="text-center mb-14">
                <h1 class="font-poppins text-4xl font-extrabold text-gray-900 leading-tight">
                    Pelayanan Kantor Kelurahan Sukorame
                </h1>
                <p class="text-gray-700 mt-2 text-base md:text-lg font-medium">
                    Komitmen kami memberikan pelayanan publik terbaik bagi masyarakat.
                </p>
            </header>

            {{-- Janji & Jenis Pelayanan --}}
            <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <div class="bg-[#D4F36B] p-8 rounded-2xl shadow-md border border-[#C5E25E]
                                transition-all duration-300 ease-in-out 
                                hover:shadow-xl hover:-translate-y-1 hover:scale-[1.01]">
                    <h2 class="font-poppins text-lg font-bold uppercase mb-4 text-gray-900 border-b-2 border-gray-900 pb-2">
                        Janji Pelayanan
                    </h2>
                    <p class="font-poppins text-gray-800 text-base leading-relaxed">
                        Kami berkomitmen memberikan pelayanan publik yang cepat, mudah, ramah, transparan, dan akuntabel.
                    </p>
                </div>

                <div class="bg-[#D4F36B] p-8 rounded-2xl shadow-md border border-[#C5E25E]
                                transition-all duration-300 ease-in-out 
                                hover:shadow-xl hover:-translate-y-1 hover:scale-[1.01]">
                    <h2 class="font-poppins text-lg font-bold uppercase mb-4 text-gray-900 border-b-2 border-gray-900 pb-2">
                        Jenis Pelayanan
                    </h2>
                    <p class="font-poppins text-gray-800 text-base leading-relaxed">
                        Pelayanan administrasi kependudukan, surat keterangan, perizinan, dan layanan sosial masyarakat.
                    </p>
                </div>
            </section>

            {{-- Pelayanan --}}
            <section class="mb-16">
                <h2 class="font-poppins text-2xl font-bold uppercase mb-10 text-center text-gray-900">
                    Pelayanan Masyarakat
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($data as $item)
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 hover:shadow-xl transition-all
                            flex flex-col">

                            <h3 class="font-poppins text-xl font-bold text-gray-900 mb-2">
                                {{ $item->nama_pelayanan }}
                            </h3>

                            {{-- Wrapper untuk menjaga tinggi deskripsi konsisten --}}
                            <div class="flex-grow mb-4">
                                <p class="text-gray-700 text-sm leading-relaxed line-clamp-3">
                                    {{ Str::limit($item->deskripsi, 120) }}
                                </p>
                            </div>

                            <div class="flex items-center text-gray-600 text-sm mb-4">
                                <i class="fas fa-clock mr-2 text-gsukorame-purple"></i>
                                {{ $item->waktu_layanan ?? 'Tidak ditentukan' }}
                            </div>

                            {{-- Tombol disetarakan di bawah --}}
                            <div class="mt-auto">
                                <a href="{{ route('publik.detail_pelayanan', $item->id_pelayanan) }}" class="bg-[#4c3588] hover:bg-[#3b2970] text-white px-4 py-2 rounded-lg text-sm font-semibold
                                  flex items-center justify-center w-full">
                                    <i class="fas fa-info-circle mr-2"></i> Detail Layanan
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </section>

            {{-- Maklumat Pelayanan --}}
            <section>
                <div class="bg-[#5D4BA2] text-white p-8 rounded-2xl shadow-md 
                                transition-all duration-300 ease-in-out 
                                hover:shadow-xl hover:-translate-y-1 hover:scale-[1.01]">
                    <h2 class="font-poppins text-xl font-bold uppercase mb-4 border-b border-white/40 pb-2">
                        Maklumat Pelayanan
                    </h2>
                    <p class="font-poppins text-base leading-relaxed">
                        Kami menyatakan kesanggupan untuk menyelenggarakan pelayanan sesuai standar yang telah ditetapkan.
                        Apabila tidak menepati janji tersebut, kami siap menerima sanksi sesuai peraturan yang berlaku.
                    </p>
                </div>
            </section>

        </div>
    </div>

    {{-- Font Awesome untuk ikon --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection