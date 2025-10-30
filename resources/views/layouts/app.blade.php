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
        /* ... (Gaya CSS tidak diubah) ... */
        body { 
            background-color: #f0f3ff; 
            padding-top: 60px; 
            margin: 0;
        } 

        .sidebar {
            height: 100vh;
            background: #1e2a3a;
            color: #fff;
            position: fixed;
            top: 0; 
            z-index: 1050; 
            width: 220px;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        .sidebar a.active, 
        .sidebar a:hover {
            background: #007bff;
            border-radius: 5px;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .content.full {
            margin-left: 0;
        }

        .navbar-custom {
            background: #2c3e50;
            color: #fff;
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            z-index: 1040;
            transition: none; 
        }

        .navbar-content-shift {
            margin-left: 220px;
            transition: margin-left 0.3s ease;
        }

        .navbar-content-shift.full {
            margin-left: 0;
        }

        .toggle-btn {
            cursor: pointer;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .dropdown-menu a {
            color: #000 !important;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #fff;
            border: 2px solid #007bff;
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
                <span class="fs-4 fw-bold">@yield('title', 'Dashboard Admin')</span>
            </div>
            
            <div class="d-flex align-items-center gap-3">

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('img/default-avatar.png') }}" alt="Admin Avatar" class="admin-avatar me-2">
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.user.index') }}"><i class="bi bi-people-fill me-2"></i> Kelola Admin</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            {{-- Tombol Logout di Dropdown --}}
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
        <div class="text-center mb-4 border-bottom pb-3">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-decoration-none text-white">
                <img src="{{ asset('img/logo_sukorame.png') }}" 
                    alt="Logo Kelurahan Sukorame" 
                    class="img-fluid mb-2"
                    style="width: 70px; height: 70px; object-fit: contain; border-radius: 50%; background-color: #fff; padding: 5px;">
                <div class="fw-bold mt-2">Kelurahan Sukorame</div>
            </a>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('admin.profil.index') }}" class="{{ request()->is('admin/profil*') ? 'active' : '' }}">👤 Profil</a>
        <a href="{{ route('admin.berita.index') }}" class="{{ request()->is('admin/berita*') ? 'active' : '' }}">📰 Berita & Pengumuman</a>
        <a href="{{ route('admin.pelayanan.index') }}" class="{{ request()->is('admin/pelayanan*') ? 'active' : '' }}">📋 Pelayanan</a>
        <a href="{{ route('admin.galeri.index') }}" class="{{ request()->is('admin/galeri*') ? 'active' : '' }}">🖼️ Galeri</a>
        <a href="{{ route('admin.buku-tamu.index') }}" class="{{ request()->is('admin/buku-tamu*') ? 'active' : '' }}">📖 Buku Tamu</a>
        <a href="{{ route('admin.faq.index') }}" class="{{ request()->is('admin/faq*') ? 'active' : '' }}">❓ FAQ</a>
    </div>

    <div class="content" id="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Logika Toggle Sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('hidden');
            document.getElementById('content').classList.toggle('full');
            document.getElementById('navbarContentShift').classList.toggle('full');
        });

        // SWEETALERT LOGOUT & NOTIFIKASI (Logika sudah benar, hanya penjorokan dirapikan)
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