<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
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
  </style>

  @stack('styles')
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-custom p-3 d-flex align-items-center">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      
      <!-- Kiri -->
      <div class="d-flex align-items-center navbar-content-shift" id="navbarContentShift">
        <span class="toggle-btn text-white me-3" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </span>
        <span class="fs-4 fw-bold">@yield('title', 'Dashboard Admin')</span>
      </div>
      
      <!-- Kanan -->
      <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>

    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column p-3" id="sidebar">
    <div class="text-center mb-4 border-bottom pb-3">
      <a href="{{ route('admin.dashboard') }}" class="d-block text-decoration-none text-white">
        <i class="bi bi-building fs-3"></i>
        <div class="fw-bold mt-1">Kelurahan Sukorame</div>
      </a>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">🏠 Dashboard</a>
    <a href="{{ route('admin.profil.index') }}" class="{{ request()->is('admin/profil*') ? 'active' : '' }}">👤 Profil</a>
    <a href="{{ route('admin.berita.index') }}" class="{{ request()->is('admin/berita*') ? 'active' : '' }}">📰 Berita & Pengumuman</a>
    <a href="{{ route('admin.pelayanan.index') }}" class="{{ request()->is('admin/pelayanan*') ? 'active' : '' }}">📋 Pelayanan</a>
    <a href="{{ route('admin.galeri.index') }}" class="{{ request()->is('admin/galeri*') ? 'active' : '' }}">🖼️ Galeri</a>
    <a href="{{ route('admin.buku_tamu.index') }}" class="{{ request()->is('admin/buku-tamu*') ? 'active' : '' }}">📖 Buku Tamu</a>
    <a href="{{ route('admin.faq.index') }}" class="{{ request()->is('admin/faq*') ? 'active' : '' }}">❓ FAQ</a>
  </div>

  <!-- Konten -->
  <div class="content" id="content">
    @yield('content')
  </div>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('hidden');
      document.getElementById('content').classList.toggle('full');
      document.getElementById('navbarContentShift').classList.toggle('full');
    });
  </script>
  @stack('scripts')
</body>
</html>
