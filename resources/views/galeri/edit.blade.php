@extends('layouts.app') 

@section('title', 'Edit Galeri: ' . Str::limit($galeri->nama_album, 30))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i> Edit Album Galeri
            </h4>
        </div>
        <p class="text-secondary small mb-4">Anda sedang mengedit Album: <span class="fw-bold text-dark">{{ $galeri->nama_album }}</span></p>

        {{-- Pesan Error Validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-x-octagon-fill me-2"></i> <strong>🚨 Gagal Update!</strong> Mohon periksa kembali kolom yang ditandai.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- BAGIAN 1: EDIT DETAIL ALBUM UTAMA --}}
        <div class="card shadow-lg p-4 mb-5 border-0">
            <h5 class="text-info mb-4"><i class="bi bi-card-heading me-2"></i> Detail Album Utama</h5>
            
            <form action="{{ route('admin.galeri.update', $galeri->id_galeri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- Kolom Kiri: Nama & Tanggal --}}
                    <div class="col-md-7">
                        {{-- Nama Album --}}
                        <div class="mb-3">
                            <label for="nama_album" class="form-label fw-bold">Nama Album / Kegiatan</label>
                            <input type="text" 
                                class="form-control @error('nama_album') is-invalid @enderror" 
                                id="nama_album" 
                                name="nama_album" 
                                value="{{ old('nama_album', $galeri->nama_album) }}"
                                required>
                            @error('nama_album') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tanggal Kegiatan --}}
                        <div class="mb-3">
                            <label for="tanggal" class="form-label fw-bold">Tanggal Kegiatan</label>
                            <input type="date" 
                                class="form-control @error('tanggal') is-invalid @enderror" 
                                id="tanggal" 
                                name="tanggal" 
                                value="{{ old('tanggal', $galeri->tanggal->format('Y-m-d')) }}"
                                required>
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    {{-- Kolom Kanan: Cover & Pratinjau --}}
                    <div class="col-md-5">
                        <label for="cover_file" class="form-label fw-bold">Ganti Foto Cover</label>
                        <div class="p-3 border rounded bg-light text-center">
                            @if($galeri->cover_path)
                                <img src="{{ asset('storage/' . $galeri->cover_path) }}" 
                                    id="currentCoverPreview"
                                    alt="Cover Album" 
                                    class="mb-2 rounded shadow-sm border border-primary" 
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="alert alert-warning mb-2 p-2">Tidak ada Cover.</div>
                            @endif
                            
                            {{-- Input File --}}
                            <input class="form-control @error('cover_file') is-invalid @enderror" 
                                type="file" id="cover_file" name="cover_file" accept="image/*">
                            <div class="form-text">Biarkan kosong untuk mempertahankan cover lama. Max 2MB.</div>
                            @error('cover_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Tombol Simpan Album Utama --}}
                <div class="mt-4 pt-3 border-top text-end">
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary me-2 shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-arrow-repeat me-1"></i> Simpan Detail Album
                    </button>
                </div>
            </form>
        </div>

        {{-- BAGIAN 2: KELOLA FOTO DETAIL (TAMBAH & HAPUS) --}}
        <h4 class="mb-4 text-secondary"><i class="bi bi-folder-fill me-2"></i> Kelola Foto Detail ({{ $fotos->count() }} Foto)</h4>
        
        {{-- Tombol Lihat Detail Modal --}}
        @if($fotos->count() > 0)
        <div class="mb-4">
            <button type="button" class="btn btn-info text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#photoDetailModal">
                <i class="bi bi-images me-1"></i> Lihat Semua Foto (Pratinjau)
            </button>
        </div>
        @endif

        {{-- Form Tambah Foto Baru --}}
        <div class="card shadow-sm mb-5 p-4 border border-success">
            <h6 class="text-success mb-3"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Foto Baru ke Album</h6>
            <form action="{{ route('admin.galeri.update', $galeri->id_galeri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="action_type" value="add_photo">
                
                <div class="d-flex flex-column flex-md-row gap-2 align-items-stretch">
                    <input class="form-control @error('new_foto_album.*') is-invalid @enderror" 
                        type="file" 
                        id="new_foto_album" 
                        name="new_foto_album[]" 
                        multiple 
                        accept="image/*"
                        required>
                    <button type="submit" class="btn btn-success text-nowrap shadow-sm flex-shrink-0">
                        <i class="bi bi-upload me-1"></i> Unggah Foto
                    </button>
                </div>
                <div class="form-text mt-1">Pilih satu atau lebih foto (Max 2MB/foto) untuk ditambahkan ke album ini.</div>
                @error('new_foto_album.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </form>
        </div>

        {{-- Daftar Foto Saat Ini (untuk aksi hapus) --}}
        <h6 class="mb-3 text-secondary"><i class="bi bi-trash3-fill me-2"></i> Hapus Foto (Satu per Satu):</h6>
        <div class="row g-3">
            @forelse($fotos as $foto)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="{{ asset('storage/' . $foto->foto_path) }}" 
                            alt="Foto Album {{ $foto->id }}" 
                            class="card-img-top rounded" 
                            style="width: 100%; height: 120px; object-fit: cover;">
                        
                        {{-- Form Hapus Foto Detail --}}
                        <div class="card-footer p-2 bg-light text-center">
                            <form action="{{ route('admin.galeri.destroy_foto', $foto->id) }}" 
                                method="POST" 
                                class="form-delete-foto"> 
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="foto_id" value="{{ $foto->id }}">
                                <button type="submit" class="btn btn-danger btn-sm w-100 shadow-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0 shadow-sm">
                        <i class="bi bi-info-circle-fill me-2"></i> Album ini belum memiliki foto detail. Silakan unggah di atas.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL DETAIL GALERI FOTO (Pratinjau Besar) --}}
<div class="modal fade" id="photoDetailModal" tabindex="-1" aria-labelledby="photoDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title fw-bold" id="photoDetailModalLabel"><i class="bi bi-grid-3x3-gap-fill me-2"></i> Pratinjau Foto Album: {{ $galeri->nama_album }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    @forelse($fotos as $foto)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ asset('storage/' . $foto->foto_path) }}" target="_blank" title="Lihat Foto Asli">
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" 
                                alt="Foto Album {{ $foto->id }}" 
                                class="img-fluid rounded shadow-sm border photo-thumbnail"
                                style="width: 100%; height: 150px; object-fit: cover;">
                        </a>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">
                        <i class="bi bi-info-circle fs-4"></i>
                        <p>Tidak ada foto yang diunggah untuk album ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- CDN SweetAlert (Dipertahankan di sini untuk memastikan modal hapus foto bekerja, walau idealnya di layout) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Logika Hapus Foto Detail menggunakan SweetAlert
    const deleteFotoForms = document.querySelectorAll('.form-delete-foto');
    deleteFotoForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); 

            Swal.fire({
                title: 'Hapus Foto?',
                text: "Foto detail ini akan dihapus permanen dari album. Apakah Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });

    // 2. Logika Notifikasi Sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
});
</script>
@endpush