@extends('layouts.app') 

@section('title', 'Kelola Pelayanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-clipboard-check me-2"></i> Kelola Pelayanan
            </h4>
        </div>
        
        {{-- Pesan Status (Dihapus, karena sudah ditangani oleh SweetAlert global di layouts/app.blade.php) --}}
        
        {{-- Form Pencarian dan Tambah --}}
        <div class="d-flex justify-content-between mb-4">
            <form action="{{ route('admin.pelayanan.index') }}" method="GET" class="d-flex me-3 w-50">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Pelayanan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Cari</button>
            </form>
            <a href="{{ route('admin.pelayanan.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Pelayanan
            </a>
        </div>

        {{-- Tabel Daftar Pelayanan --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 25%;">Pelayanan</th>
                            <th style="width: 50%;">Deskripsi</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelayananList as $pelayanan)
                        <tr>
                            <td>{{ $pelayanan->id_pelayanan }}</td>
                            <td>{{ $pelayanan->nama_pelayanan }}</td>
                            <td>{{ Str::limit($pelayanan->deskripsi, 80) }}</td>
                            <td>
                                {{-- Tombol Lihat Detail --}}
                                <button type="button" class="btn btn-info btn-sm text-white" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailModal{{ $pelayanan->id_pelayanan }}" 
                                    title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.pelayanan.edit', $pelayanan->id_pelayanan) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                {{-- Tombol Hapus (Memicu SweetAlert) --}}
                                <form action="{{ route('admin.pelayanan.destroy', $pelayanan->id_pelayanan) }}" 
                                    method="POST" 
                                    class="d-inline form-delete"> {{-- Tambahkan class form-delete --}}
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL DETAIL PELAYANAN (Tetap di dalam loop) --}}
                        <div class="modal fade" id="detailModal{{ $pelayanan->id_pelayanan }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $pelayanan->id_pelayanan }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="detailModalLabel{{ $pelayanan->id_pelayanan }}">
                                            Detail Layanan: {{ $pelayanan->nama_pelayanan }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- Ilustrasi (Placeholder, sesuai gambar 3) --}}
                                        <div class="text-center mb-4">
                                            <img src="https://placehold.co/900x200/4e73df/ffffff?text=INFORMASI+LAYANAN" class="img-fluid rounded" alt="Ilustrasi Layanan">
                                        </div>

                                        <h6>Deskripsi Layanan:</h6>
                                        <p>{{ $pelayanan->deskripsi }}</p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Persyaratan:</h6>
                                                @if($pelayanan->persyaratan)
                                                    <ul class="list-group list-group-flush mb-3">
                                                        @foreach($pelayanan->persyaratan as $syarat)
                                                            <li class="list-group-item">{{ $syarat }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted">Tidak ada persyaratan spesifik yang dicantumkan.</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Proses Pengurusan:</h6>
                                                @if($pelayanan->proses)
                                                    <ol class="list-group list-group-numbered mb-3">
                                                        @foreach($pelayanan->proses as $langkah)
                                                            <li class="list-group-item">{{ $langkah }}</li>
                                                        @endforeach
                                                    </ol>
                                                @else
                                                    <p class="text-muted">Tidak ada rincian proses pengurusan.</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <hr>

                                        <h6>Waktu Pelayanan:</h6>
                                        <p><strong>{{ $pelayanan->waktu_layanan ?? 'Informasi tidak tersedia.' }}</strong></p>

                                        <h6>Keterangan:</h6>
                                        <p>{{ $pelayanan->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data Pelayanan yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $pelayananList->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS ASLI TELAH DIHAPUS --}}

@push('scripts')
{{-- Karena SweetAlert sudah dipindahkan secara global di layouts/app.blade.php, 
     kita hanya perlu menambahkan logika spesifik untuk form delete di sini. --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Cari semua form dengan class 'form-delete'
    const forms = document.querySelectorAll('.form-delete');
    
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah submit form bawaan

            // Ambil nama item dari atribut data (jika ada, atau buat manual)
            // Di sini kita tidak punya data-name di tombol, jadi kita bisa ambil dari form action URL,
            // tapi yang termudah adalah menggunakan nama default yang generik.
            // Atau, jika mau spesifik, kita bisa passing ID ke SweetAlert dan meminta detail via AJAX.
            // Untuk kesederhanaan, kita akan menggunakan nama generik.

            const namaPelayanan = "Layanan ini"; // Ganti dengan nama yang lebih spesifik jika data-name bisa diakses

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus ${namaPelayanan}? Data yang dihapus tidak bisa dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika user mengkonfirmasi
                }
            });
        });
    });
});
</script>
@endpush
@endsection
