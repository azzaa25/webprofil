<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

    <style>
        :root {
            --sidebar-width-full: 280px;
            --sidebar-width-mini: 80px;
        }

        body { 
            background-color: #f0f3ff; 
            padding-top: 60px; 
            margin: 0;
        }

        /* ------------------------- NAVBAR FIX --------------------------- */
        .navbar-custom {
            background: #1e2a3a !important; 
            color: white !important;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 2000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .navbar-custom .fs-5,
        .navbar-custom .dropdown-toggle {
            color: white !important;
        }

        .dropdown-menu {
            background: #ffffff !important;
        }
        
        /* --- NAMA ADMIN DI NAVBAR --- */
        .admin-name-text {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #fff;
            border: 2px solid #007bff;
        }

        /* ------------------------- SIDEBAR PERBAIKAN POSISI KRITIS --------------------------- */
        .sidebar {
            /* Perbaikan Posisi & Tinggi agar tidak menutupi Navbar */
            height: calc(100vh - 60px); 
            top: 60px; /* Jarak dari atas, setelah navbar */
            
            background: #1e2a3a;
            color: #fff;
            position: fixed;
            left: 0; /* Pastikan selalu di kiri */
            z-index: 1050;
            width: var(--sidebar-width-mini);
            overflow-y: auto;
            transition: width 0.3s ease, transform 0.3s ease;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar.expanded {
            width: var(--sidebar-width-full);
        }

        .sidebar .menu-link { 
            color: #fff;
            text-decoration: none;
            display: flex; 
            align-items: center;
            padding: 12px 20px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar .menu-link i {
            margin-right: 12px; 
            font-size: 1.1rem;
        }

        /* --- PERBAIKAN LOGO DI SIDEBAR (AGAR TIDAK TERPOTONG) START --- */
        .sidebar .logo-container {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .sidebar .logo-wrapper {
            display: flex;
            align-items: center;
            /* Padding 12px untuk menyisakan ruang di mode mini 80px */
            padding: 10px 12px; 
            justify-content: center; /* Tetap center di mode mini */
            transition: justify-content 0.3s ease, padding 0.3s ease;
        }
        
        .sidebar.expanded .logo-wrapper {
            justify-content: flex-start;
            padding: 10px 20px; /* Kembalikan padding normal saat expanded */
        }

        .sidebar .logo-img {
            width: 55px;
            min-width: 55px;
            height: 55px;
            object-fit: contain;
            margin-right: 0;
            transition: margin-right 0.3s ease;
        }
        
        .sidebar.expanded .logo-img {
            margin-right: 12px;
        }

        .sidebar .logo-text {
            font-size: 1.1rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            /* Perbaikan: Menggunakan max-width untuk mengontrol tampilan/transisi teks */
            max-width: 0;
            opacity: 0;
            transition: max-width 0.3s ease, opacity 0.3s ease;
        }
        
        .sidebar.expanded .logo-text {
            max-width: 200px;
            opacity: 1;
        }

        /* Perbaikan untuk menu-text secara umum (menggunakan max-width untuk transisi) */
        .sidebar .menu-text {
            max-width: 0; 
            opacity: 0;
            overflow: hidden;
            transition: max-width 0.3s ease, opacity 0.3s ease;
        }

        .sidebar.expanded .menu-text {
            max-width: 200px; 
            opacity: 1;
        }
        /* --- PERBAIKAN LOGO DI SIDEBAR END --- */


        .sidebar .menu-link.active {
            background: #007bff; 
            color: #fff;
            border-radius: 5px;
        }

        .sidebar .menu-link:hover:not(.active) {
            background: #283a4d; 
        }

        .content {
            margin-left: var(--sidebar-width-mini); 
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .content.expanded {
            margin-left: var(--sidebar-width-full);
        }

        .navbar-content-shift {
            margin-left: var(--sidebar-width-mini); 
            transition: margin-left 0.3s ease;
        }

        .navbar-content-shift.expanded {
            margin-left: var(--sidebar-width-full);
        }

        /* ------------------------- MOBILE RESPONSIVE --------------------------- */
        @media (max-width: 768px) {
            /* Posisi Sidebar di Mobile harusnya di luar layar */
            .sidebar {
                top: 0; /* Di mobile, sidebar dimulai dari atas karena menutupi konten */
                height: 100vh;
                transform: translateX(-100%);
            }
            .sidebar.expanded {
                transform: translateX(0);
                width: 260px;
            }

            .content,
            .navbar-content-shift {
                margin-left: 0 !important;
            }

            /* Sembunyikan nama Admin lewat mobile agar tidak panjang */
            .navbar-custom .dropdown-toggle .admin-name-text {
                display: none !important;
            }

            /* Judul kecil biar rapi */
            .navbar-custom .fs-5 {
                font-size: 1.1rem;
            }
        }
    </style>


    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-custom p-3 d-flex align-items-center">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            
            <div class="d-flex align-items-center navbar-content-shift" id="navbarContentShift">
                <span class="toggle-btn text-white me-3" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </span>
                <span class="fs-5 fw-bold text-white">@yield('title', 'Dashboard Admin')</span>
            </div>
            
            <div class="d-flex align-items-center gap-3">

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('img/default-avatar.png') }}" alt="Admin Avatar" class="admin-avatar me-2">
                        <span class="admin-name-text">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.user.index') }}"><i class="bi bi-person-gear me-2"></i> Kelola Admin</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button type="button" class="dropdown-item text-danger" id="logout-button">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>
    </nav>

    <div class="sidebar d-flex flex-column p-3" id="sidebar">
        <div class="text-center logo-container">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-decoration-none text-white">
                
                <div class="text-white logo-wrapper">
                    <img src="{{ asset('img/logo_kediri.png') }}" class="logo-img">
                    <span class="logo-text menu-text">Kelurahan Sukorame</span>
                </div>

            </a>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i> <span class="menu-text">Dashboard</span>
        </a>
        <a href="{{ route('admin.profil.index') }}" class="menu-link {{ request()->is('admin/profil*') ? 'active' : '' }}">
            <i class="bi bi-person-vcard-fill"></i> <span class="menu-text">Profil</span>
        </a>
        <a href="{{ route('admin.berita.index') }}" class="menu-link {{ request()->is('admin/berita*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> <span class="menu-text">Berita & Pengumuman</span>
        </a>
        <a href="{{ route('admin.pelayanan.index') }}" class="menu-link {{ request()->is('admin/pelayanan*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text-fill"></i> <span class="menu-text">Pelayanan</span>
        </a>
        <a href="{{ route('admin.galeri.index') }}" class="menu-link {{ request()->is('admin/galeri*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> <span class="menu-text">Galeri</span>
        </a>
        <a href="{{ route('admin.buku-tamu.index') }}" class="menu-link {{ request()->is('admin/buku-tamu*') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i> <span class="menu-text">Buku Tamu</span>
        </a>
        <a href="{{ route('admin.faq.index') }}" class="menu-link {{ request()->is('admin/faq*') ? 'active' : '' }}">
            <i class="bi bi-question-circle-fill"></i> <span class="menu-text">FAQ</span>
        </a>
    </div>

    <div class="content" id="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Logika Toggle Sidebar & Penyesuaian lebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const navbarShift = document.getElementById('navbarContentShift');

            sidebar.classList.toggle('expanded');
            content.classList.toggle('expanded');
            navbarShift.classList.toggle('expanded');
        });

        // Tampilkan sidebar secara penuh di layar lebar secara default
        window.addEventListener('load', function() {
            if (window.innerWidth >= 768) {
                // Di layar besar, default-nya adalah mode expanded
                document.getElementById('sidebar').classList.add('expanded');
                document.getElementById('content').classList.add('expanded');
                document.getElementById('navbarContentShift').classList.add('expanded');
            } else {
                // Di layar kecil, default-nya adalah mode mini/hidden
                document.getElementById('sidebar').classList.remove('expanded');
                document.getElementById('content').classList.remove('expanded');
                document.getElementById('navbarContentShift').classList.remove('expanded');
            }
        });

        // SWEETALERT LOGOUT & NOTIFIKASI
        document.addEventListener('DOMContentLoaded', function () {
            const logoutButton = document.getElementById('logout-button');
            const logoutForm = document.getElementById('logout-form');

            if (logoutButton && logoutForm) {
                logoutButton.addEventListener('click', function(e) {
                    Swal.fire({
                        title: 'Yakin Ingin Keluar?',
                        text: "Anda akan diarahkan ke halaman beranda.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>