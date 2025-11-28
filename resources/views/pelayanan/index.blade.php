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
        
        {{-- START: BAGIAN KELOLA GAMBAR SOP (Global) --}}
        {{-- Pastikan variabel $profileData dikirim dari Controller yang melayani view ini. --}}
        @isset($profileData)
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-primary">Gambar Standar Operasional Prosedur (SOP) Pelayanan Global</h6>
            </div>
            <div class="card-body">
                
                <!-- Tampilan Gambar SOP Saat Ini -->
                @if ($profileData->gambar_sop)
                    <div class="mb-3 text-center p-3 border rounded bg-light">
                        <p class="mb-2 fw-bold">Gambar SOP saat ini:</p>
                        <img 
                            src="{{ Storage::url($profileData->gambar_sop) }}" 
                            alt="Gambar SOP Pelayanan" 
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 250px; border: 1px solid #ccc;"
                        >
                    </div>

                    <!-- Tombol Hapus (Jika Gambar Sudah Ada) -->
                    <form action="{{ route('profil.delete_sop') }}" method="POST" class="d-inline form-delete-sop">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill me-1"></i> Hapus Gambar SOP
                        </button>
                    </form>
                    <hr class="my-4">
                @else
                    <p class="text-danger mb-3"><i class="bi bi-exclamation-triangle-fill me-1"></i> Belum ada Gambar SOP yang diunggah.</p>
                @endif

                <!-- Form Tambah/Ganti Gambar SOP -->
                <form action="{{ route('profil.upload_sop') }}" method="POST" enctype="multipart/form-data" class="pt-2">
                    @csrf
                    
                    <div class="form-group">
                        <label for="gambar_sop_image" class="form-label fw-bold">
                            @if($profileData->gambar_sop) Ganti Gambar SOP: @else Unggah Gambar SOP: @endif
                            <small class="text-muted">(Max 2MB, format JPEG/PNG)</small>
                        </label>
                        <input type="file" name="gambar_sop_image" id="gambar_sop_image" class="form-control @error('gambar_sop_image') is-invalid @enderror" required>
                        @error('gambar_sop_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-upload me-1"></i> 
                        @if($profileData->gambar_sop) Perbarui SOP @else Upload SOP @endif
                    </button>
                </form>

            </div>
        </div>
        @endisset
        {{-- END: BAGIAN KELOLA GAMBAR SOP (Global) --}}
        
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
    // --------------------------------------------------------------------------
    // 1. Logika SweetAlert untuk Hapus Pelayanan (Tabel Utama)
    // --------------------------------------------------------------------------
    const formsDeletePelayanan = document.querySelectorAll('.form-delete');
    
    formsDeletePelayanan.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); 

            // Mengambil nama pelayanan jika memungkinkan, atau menggunakan nama generik
            const namaPelayanan = "Layanan ini"; 

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
                    form.submit(); 
                }
            });
        });
    });

    // --------------------------------------------------------------------------
    // 2. Logika SweetAlert untuk Hapus Gambar SOP (Konfigurasi Global)
    // --------------------------------------------------------------------------
    const formDeleteSOP = document.querySelector('.form-delete-sop');
    
    if (formDeleteSOP) {
        formDeleteSOP.addEventListener('submit', function (e) {
            e.preventDefault(); 

            Swal.fire({
                title: 'Konfirmasi Hapus SOP',
                text: "Anda akan menghapus Gambar SOP Global. Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Gambar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    formDeleteSOP.submit(); 
                }
            });
        });
    }
});
</script>
@endpush
@endsection