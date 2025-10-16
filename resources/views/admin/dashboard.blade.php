@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
  <h3 class="mb-4">Dashboard Admin</h3>

  {{-- Kartu Statistik --}}
  <div class="row g-3 mb-3">
    <div class="col-sm-6 col-lg-4">
      <div class="card card-custom p-3 h-100 shadow-sm text-center">
        <h6>Total Pengunjung</h6>
        <h3>{{ $totalPengunjung }}</h3>
        <small>Bulan Ini</small>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4">
      <div class="card card-custom p-3 h-100 shadow-sm text-center">
        <h6>Total Berita</h6>
        <h3>{{ $beritaAktif }}</h3>
        <small>Semua Kategori</small>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4">
      <div class="card card-custom p-3 h-100 shadow-sm text-center">
        <h6>Galeri Foto</h6>
        <h3>{{ $totalGaleri }}</h3>
        <small>Jumlah Album</small>
      </div>
    </div>
  </div>

  {{-- Statistik & Aktivitas --}}
  <div class="row g-3 mb-3">
    {{-- Grafik Statistik Kunjungan --}}
    <div class="col-lg-6">
      <div class="card card-custom p-3 h-100 shadow-sm">
        <h6>📈 Statistik Kunjungan</h6>
        <div class="position-relative" style="height:320px;">
          <canvas id="statistikChart"></canvas>
        </div>
      </div>
    </div>

    {{-- Aktivitas Terkini --}}
    <div class="col-lg-6">
      <div class="card card-custom p-3 h-100 shadow-sm">
        <h6>🕓 Aktivitas Terkini</h6>
        <ul class="small mb-3 overflow-auto" style="max-height:150px;">
          <li>📘 Total pengunjung bulan ini: <strong>{{ $totalPengunjung }}</strong></li>
          <li>📰 Total berita di sistem: <strong>{{ $beritaAktif }}</strong></li>
          <li>🖼️ Total galeri foto: <strong>{{ $totalGaleri }}</strong></li>
          <li>📅 Terakhir diperbarui: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</li>
        </ul>

        <h6>🧾 Buku Tamu Terbaru</h6>
        <div class="table-responsive">
          <table class="table table-sm align-middle">
            <tbody>
              @forelse (\App\Models\BukuTamu::latest('tanggal')->take(3)->get() as $tamu)
                <tr>
                  <td>
                    {{ $tamu->nama_lengkap }}<br>
                    <small class="text-muted">{{ $tamu->keperluan }}</small><br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($tamu->tanggal)->translatedFormat('d M Y') }}</small>
                  </td>
                  <td class="text-end">
                    <a href="{{ url('admin/buku-tamu') }}" class="btn btn-primary btn-sm">Lihat</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="2" class="text-center text-muted">Belum ada data buku tamu.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  const ctx = document.getElementById('statistikChart').getContext('2d');

  // Buat gradasi warna untuk garis
  const gradient = ctx.createLinearGradient(0, 0, 0, 300);
  gradient.addColorStop(0, 'rgba(54, 162, 235, 0.4)');
  gradient.addColorStop(1, 'rgba(54, 162, 235, 0)');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: @json($bulanNama),
      datasets: [{
        label: 'Jumlah Pengunjung',
        data: @json($dataStatistik),
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: gradient,
        borderWidth: 3,
        tension: 0.4, // membuat garis lebih lembut
        fill: true,
        pointRadius: 5,
        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
        pointBorderColor: '#fff',
        pointHoverRadius: 7,
        pointHoverBorderWidth: 2,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1, // biar 1, 2, 3, bukan 0,2,4
            precision: 0, // biar gak ada koma
            color: '#555',
          },
          grid: {
            color: 'rgba(200, 200, 200, 0.2)',
          }
        },
        x: {
          grid: {
            display: false
          },
          ticks: {
            color: '#555',
          }
        }
      },
      plugins: {
        legend: {
          position: 'top',
          labels: {
            color: '#333',
            font: { weight: 'bold' }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(54, 162, 235, 0.9)',
          titleColor: '#fff',
          bodyColor: '#fff',
          callbacks: {
            label: function(context) {
              return ` ${context.parsed.y} Pengunjung`;
            }
          }
        }
      }
    }
  });
</script>
@endpush
