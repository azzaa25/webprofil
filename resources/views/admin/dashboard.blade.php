@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary">
        <i class="bi bi-speedometer2"></i> Dashboard Admin
    </h4>
</div>

{{-- Kartu Statistik (Ditingkatkan dengan Ikon dan Warna) --}}
<div class="row g-4 mb-4">
    {{-- Total Buku Tamu --}}
    <div class="col-sm-6 col-lg-4">
        <div class="card p-3 shadow-lg border-0 h-100 bg-primary text-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 mb-0">Total Buku Tamu</h6>
                    <h3 class="fw-bold">{{ $totalPengunjung }}</h3>
                    <small>Bulan Ini</small>
                </div>
                <i class="bi bi-book-half display-4 opacity-50"></i>
            </div>
        </div>
    </div>
    
    {{-- Total Berita --}}
    <div class="col-sm-6 col-lg-4">
        <div class="card p-3 shadow-lg border-0 h-100" style="background-color: #28a745; color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 mb-0">Total Berita</h6>
                    <h3 class="fw-bold">{{ $beritaAktif }}</h3>
                    <small>Semua Kategori</small>
                </div>
                <i class="bi bi-newspaper display-4 opacity-50"></i>
            </div>
        </div>
    </div>
    
    {{-- Galeri Foto --}}
    <div class="col-sm-6 col-lg-4">
        <div class="card p-3 shadow-lg border-0 h-100 bg-info text-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 mb-0">Galeri Foto</h6>
                    <h3 class="fw-bold">{{ $totalGaleri }}</h3>
                    <small>Jumlah Album</small>
                </div>
                <i class="bi bi-images display-4 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

{{-- Statistik & Aktivitas --}}
<div class="row g-4">
    {{-- Grafik Statistik Kunjungan --}}
    <div class="col-lg-7">
        <div class="card p-4 shadow-lg border-0 h-100">
            <h5 class="card-title fw-bold text-secondary mb-3">📈 Statistik Kunjungan Bulanan</h5>
            <div class="position-relative" style="height:350px;">
                <canvas id="statistikChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Aktivitas Terkini --}}
    <div class="col-lg-5">
        <div class="card p-4 shadow-lg border-0 h-100">
            <h5 class="card-title fw-bold text-secondary mb-3">🕓 Aktivitas Terbaru</h5>
            
            <ul class="list-group list-group-flush small mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Berita Aktif
                    <span class="badge bg-success rounded-pill">{{ $beritaAktif }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total Album Galeri
                    <span class="badge bg-info rounded-pill">{{ $totalGaleri }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center text-muted">
                    Terakhir Diperbarui
                    <small>{{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</small>
                </li>
            </ul>

            <h6 class="mt-3 fw-bold text-primary">🧾 Buku Tamu Terbaru</h6>
            <div class="list-group">
                @forelse (\App\Models\BukuTamu::latest('tanggal')->take(3)->get() as $tamu)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-bold">{{ $tamu->nama_lengkap }}</div>
                        <small class="text-success">{{ $tamu->keperluan }}</small><br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($tamu->tanggal)->translatedFormat('d M Y') }}</small>
                    </div>
                    <a href="{{ url('admin/buku-tamu') }}" class="btn btn-outline-primary btn-sm ms-2">Lihat</a>
                </div>
                @empty
                <div class="alert alert-light text-center mb-0" role="alert">
                    Belum ada data buku tamu terbaru.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SweetAlert2 untuk Notifikasi yang Bagus --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. NOTIFIKASI SUKSES LOGIN (Jika ada session 'success')
        // Memastikan notifikasi hanya muncul sekali setelah login
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Masuk',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    });

    // Kode Chart.js Anda (tetap dipertahankan dengan sedikit penyesuaian)
    const ctx = document.getElementById('statistikChart').getContext('2d');

    // Buat gradasi warna untuk area di bawah garis
    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
    gradient.addColorStop(0, 'rgba(0, 123, 255, 0.6)'); // Biru Cerah
    gradient.addColorStop(1, 'rgba(0, 123, 255, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($bulanNama),
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: @json($dataStatistik),
                borderColor: '#007bff', // Biru primary
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4, 
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#007bff', 
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
                        stepSize: 1, 
                        precision: 0, 
                        color: '#555',
                    },
                    grid: {
                        color: 'rgba(200, 200, 200, 0.4)',
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
                    backgroundColor: 'rgba(0, 123, 255, 0.9)',
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