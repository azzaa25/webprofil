{{-- Lokasi file: resources/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kelurahan Sukorame')</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Alpine.js for interactivity (mobile menu) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Konfigurasi custom warna untuk Tailwind CSS
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sukorame-green': '#d7f27b',
                        'sukorame-purple': '#4c3588',
                        'sukorame-purple-light': '#a89cc8',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="font-poppins text-gray-800">

    <header class="bg-sukorame-green sticky top-0 z-50 shadow-md" x-data="{ open: false }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <div class="flex items-center">
                    <img class="h-24" src="{{ asset('img/logo_kediri.png') }}" alt="Logo Kota Kediri">
                    <img class="h-12" src="{{ asset('img/logo_sukorame.png') }}" alt="Logo Kelurahan Sukorame">
                </div>

                {{-- Navigation Desktop --}}
                <nav class="hidden md:flex items-center space-x-8">

                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open"
                            class="font-semibold transition-colors duration-300 flex items-center {{ Request::is('/', 'profil/struktur-organisasi', 'profil/demografi') ? 'text-black font-bold' : 'text-sukorame-purple hover:text-black' }}">
                            <span>Beranda</span>
                            <svg class="w-5 h-5 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition
                            class="absolute z-10 mt-2 w-48 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-1">
                                <a href="{{ url('/') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Beranda</a>
                                <a href="{{ url('/profil') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Struktur Organisasi</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Demografi</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kependudukan</a>
                                <a href="{{ url('/buku-tamu') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Buku Tamu</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/profil') }}"
                        class="font-semibold transition-colors duration-300 {{ Request::is('profil') ? 'text-black font-bold' : 'text-sukorame-purple hover:text-black' }}">Profil</a>
                    <a href="{{ url('/pelayanan') }}"
                        class="font-semibold transition-colors duration-300 {{ Request::is('pelayanan') ? 'text-black font-bold' : 'text-sukorame-purple hover:text-black' }}">Pelayanan</a>
                    <a href="{{ url('/berita') }}"
                        class="font-semibold transition-colors duration-300 {{ Request::is('berita') ? 'text-black font-bold' : 'text-sukorame-purple hover:text-black' }}">Berita</a>
                    <a href="{{ url('/galeri') }}"
                        class="font-semibold transition-colors duration-300 {{ Request::is('galeri') ? 'text-black font-bold' : 'text-sukorame-purple hover:text-black' }}">Galeri</a>
                    <a href="#faq"
                        class="font-semibold transition-colors duration-300 text-sukorame-purple hover:text-black">FAQ ?</a>

                    {{-- Tombol Login --}}
                    <a href="{{ url('/login') }}"
                        class="ml-4 px-4 py-2 rounded-lg bg-sukorame-purple text-white font-semibold hover:bg-sukorame-purple-light transition-colors duration-300">
                        Login
                    </a>

                </nav>

                {{-- Tombol Menu Mobile --}}
                <div class="md:hidden flex items-center space-x-3">
                    {{-- Tombol Login versi Mobile --}}
                    <a href="{{ url('/login') }}"
                        class="px-3 py-1 rounded-md bg-sukorame-purple text-white text-sm font-semibold hover:bg-sukorame-purple-light transition-colors">
                        Login
                    </a>

                    <button @click="open = !open" class="text-sukorame-purple focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Menu Mobile Dropdown --}}
        <div x-show="open" @click.away="open = false" class="md:hidden bg-sukorame-green border-t border-gray-200">
            <div x-data="{ subMenuOpen: false }">
                <button @click="subMenuOpen = !subMenuOpen"
                    class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold text-left text-sukorame-purple hover:bg-sukorame-purple hover:text-white">
                    <span>Beranda</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': subMenuOpen }"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="subMenuOpen" x-transition class="bg-gray-100">
                    <a href="{{ url('/') }}"
                        class="block pl-8 pr-4 py-2 text-sm font-semibold {{ Request::is('/') ? 'bg-sukorame-purple text-white' : 'text-sukorame-purple hover:bg-gray-200' }}">Beranda</a>
                    <a href="{{ url('/profil') }}"
                        class="block pl-8 pr-4 py-2 text-sm font-semibold {{ Request::is('profil') ? 'bg-sukorame-purple text-white' : 'text-sukorame-purple hover:bg-gray-200' }}">Struktur
                        Organisasi</a>
                    <a href="#"
                        class="block pl-8 pr-4 py-2 text-sm font-semibold text-sukorame-purple hover:bg-gray-200">Demografi</a>
                    <a href="#"
                        class="block pl-8 pr-4 py-2 text-sm font-semibold text-sukorame-purple hover:bg-gray-200">Kependudukan</a>
                    <a href="{{ url('/buku-tamu') }}"
                        class="block pl-8 pr-4 py-2 text-sm font-semibold {{ Request::is('buku-tamu') ? 'bg-sukorame-purple text-white' : 'text-sukorame-purple hover:bg-gray-200' }}">Buku
                        Tamu</a>
                </div>
            </div>

            <a href="{{ url('/profil') }}"
                class="block px-4 py-3 text-sm font-semibold {{ Request::is('profil') ? 'bg-sukorame-purple text-white' : 'text-sukorame-purple hover:bg-sukorame-purple hover:text-white' }}">Profil</a>
            <a href="{{ url('/pelayanan') }}"
                class="block px-4 py-3 text-sm font-semibold {{ Request::is('pelayanan') ? 'bg-sukorame-purple text-white' : 'text-sukorame-purple hover:bg-sukorame-purple hover:text-white' }}">Pelayanan</a>
            <a href="{{ url('/berita') }}"
                class="block px-4 py-3 text-sm font-semibold {{ Request::is('berita') ? 'bg-sukorame-purple text-white' : 'text-sukorame-purple hover:bg-sukorame-purple hover:text-white' }}">Berita</a>
            <a href="{{ url('/galeri') }}"
                class="block px-4 py-3 text-sm font-semibold {{ Request::is('galeri') ? 'bg-sukorame-purple text-white' : 'text-sukorame-purple hover:bg-sukorame-purple hover:text-white' }}">Galeri</a>
            <a href="#faq"
                class="block px-4 py-3 text-sm font-semibold">FAQ ?</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-sukorame-purple text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span>(0354) 8022152</span>
                    </div>
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Kelurahan.Sukorame@gmail.com</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Senin s/d Jum'at : 08.00–15.30</span>
                    </div>
                </div>

                <div>
                    <iframe class="w-full h-48 rounded-lg shadow-lg"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15810.15783329976!2d112.015497!3d-7.838503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7857053365a633%3A0x134b2a3f5898516e!2sSukorame%2C%20Kec.%20Mojoroto%2C%20Kota%20Kediri%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1664500000000!5m2!1sid!2sid"
                        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="bg-black bg-opacity-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3 text-center text-sm">
                © 2025 Kelurahan Sukorame. Designed By 3E
            </div>
        </div>
    </footer>

</body>

</html>