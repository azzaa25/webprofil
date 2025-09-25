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
    body { background-color: #f0f3ff; }
    .sidebar {
      height: 100vh;
      background: #1e2a3a;
      color: #fff;
      position: fixed;
      width: 220px;
      overflow-y: auto;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
    }
    .sidebar a.active, .sidebar a:hover {
      background: #007bff;
      border-radius: 5px;
    }
    .content {
      margin-left: 220px;
      padding: 20px;
    }
    .card-custom {
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .navbar-custom {
      background: #2c3e50;
      color: #fff;
      margin-left: 220px;
    }
  </style>
  @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-custom p-3">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <span class="fs-4 fw-bold">@yield('title', 'Dashboard Admin')</span>
    <div>
      <span class="me-3"><i class="bi bi-person-circle"></i> Admin</span>
      <!-- Logout pakai form POST -->
      <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
      </form>
    </div>
  </div>
</nav>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
  <!-- Logo / Judul -->
  <div class="text-center mb-4 border-bottom pb-3">
    <a href="{{ route('dashboard') }}" class="d-block text-decoration-none text-white">
      <i class="bi bi-building fs-3"></i>
      <div class="fw-bold mt-1">Kelurahan Sukorame</div>
    </a>
  </div>

  <!-- Menu -->
  <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
  <a href="{{ route('profil.index') }}" class="{{ request()->is('profil*') ? 'active' : '' }}">👤 Profil</a>
  <a href="{{ route('berita.index') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">📰 Berita & Pengumuman</a>
  <a href="{{ route('galeri.index') }}" class="{{ request()->is('galeri*') ? 'active' : '' }}">🖼️ Galeri</a>
  <a href="{{ route('buku-tamu.index') }}" class="{{ request()->is('buku-tamu*') ? 'active' : '' }}">📖 Buku Tamu</a>
  <a href="{{ route('faq.index') }}" class="{{ request()->is('faq*') ? 'active' : '' }}">❓ FAQ</a>
</div>


<!-- Content -->
<div class="content">
  @yield('content')
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>
