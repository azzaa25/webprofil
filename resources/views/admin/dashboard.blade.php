@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
  <h3 class="mb-4">Dashboard Admin</h3>

  <div class="row g-3 mb-3">
    <div class="col-sm-6 col-lg-4">
      <div class="card card-custom p-3 h-100 shadow-sm">
        <h6>Total Pengunjung</h6>
        <h3>{{ $totalPengunjung ?? 100 }}</h3>
        <small>Bulan Ini</small>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4">
      <div class="card card-custom p-3 h-100 shadow-sm">
        <h6>Berita Aktif</h6>
        <h3>{{ $beritaAktif ?? 73 }}</h3>
        <small>Kategori Terkini</small>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4">
      <div class="card card-custom p-3 h-100 shadow-sm">
        <h6>Galeri Foto</h6>
        <h3>{{ $totalGaleri ?? '...' }}</h3>
        <small>Jumlah Unggahan</small>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-lg-6">
      <div class="card card-custom p-3 h-100 shadow-sm">
        <h6>Statistik Kunjungan</h6>
        <div class="position-relative" style="height:300px;">
          <canvas id="statistikChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-custom p-3 h-100 shadow-sm">
        <h6>Aktivitas Terkini</h6>
        <ul class="small mb-3 overflow-auto" style="max-height:120px;">
          <li>Menambah Berita Baru "Kerja Bakti Rutin"</li>
          <li>Mengedit Profil Lurah</li>
          <li>Mengunggah 10 foto ke galeri</li>
        </ul>

        <h6>Pesan Masuk</h6>
        <div class="table-responsive">
          <table class="table table-sm align-middle">
            <tbody>
              <tr>
                <td>
                  Budi Santoso<br>
                  <small class="text-muted">budisantoso@gmail.com</small>
                </td>
                <td class="text-end">
                  <a href="#" class="btn btn-primary btn-sm">Lihat Pesan</a>
                </td>
              </tr>
              <tr>
                <td>
                  Siti Aminah<br>
                  <small class="text-muted">sitiaminah@gmail.com</small>
                </td>
                <td class="text-end">
                  <a href="#" class="btn btn-primary btn-sm">Lihat Pesan</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  const ctx = document.getElementById('statistikChart');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Januari', 'Februari', 'Maret', 'Mei', 'Juni'],
      datasets: [
        { label: 'Pengunjung', data: [20, 30, 40, 55, 90], borderColor: 'blue', fill: false, tension: 0.3 },
        { label: 'Pesan', data: [10, 20, 25, 40, 60], borderColor: 'orange', fill: false, tension: 0.3 }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } }
    }
  });
</script>
@endpush
