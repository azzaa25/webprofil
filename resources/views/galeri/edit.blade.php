@extends('layouts.app') 

@section('title', 'Edit Galeri: ' . Str::limit($galeri->nama_album, 30))

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4 text-primary">Edit Galeri</h2>
        <p class="text-muted">Anda sedang mengedit: **{{ $galeri->nama_album }}**</p>
        
        {{-- Pesan Sukses untuk Hapus Foto Detail (Ditangani oleh SweetAlert global) --}}

        <div class="card shadow-sm p-4 mb-4">
            {{-- Form Update Album Utama --}}
            <form action="{{ route('admin.galeri.update', $galeri->id_galeri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama Album --}}
                <div class="mb-4">
                    <label for="nama_album" class="form-label">Nama Album</label>
                    <input type="text" 
                        class="form-control @error('nama_album') is-invalid @enderror" 
                        id="nama_album" 
                        name="nama_album" 
                        value="{{ old('nama_album', $galeri->nama_album) }}" 
                        {{-- required Dihapus --}}
                    >
                    @error('nama_album') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    {{-- Cover Album --}}
                    <div class="col-md-6 mb-4">
                        <label for="cover_file" class="form-label">Ganti Foto Cover</label>
                        <div class="input-group">
                            <input class="form-control @error('cover_file') is-invalid @enderror" type="file" id="cover_file" name="cover_file" accept="image/*">
                        </div>
                        <div class="form-text">Biarkan kosong untuk mempertahankan cover lama.</div>
                        @if($galeri->cover_path)
                            <img src="{{ asset('storage/' . $galeri->cover_path) }}" alt="Cover Album" class="mt-2 rounded shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                        @error('cover_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Tanggal Kegiatan --}}
                    <div class="col-md-6 mb-4">
                        <label for="tanggal" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" 
                            class="form-control @error('tanggal') is-invalid @enderror" 
                            id="tanggal" 
                            name="tanggal" 
                            value="{{ old('tanggal', $galeri->tanggal->format('Y-m-d')) }}" 
                            {{-- required Dihapus --}}
                        >
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <h5 class="mt-4">Simpan Perubahan Album</h5>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-arrow-repeat me-1"></i> Simpan Album
                </button>
            </form>
            
            <hr class="my-5">

            {{-- Bagian Kelola Foto Detail --}}
            <h4 class="mb-4 text-secondary">Kelola Foto Detail Album</h4>
            
            {{-- Tombol Lihat Detail Modal --}}
            @if($fotos->count() > 0)
            <div class="mb-4">
                <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#photoDetailModal">
                    <i class="bi bi-images me-1"></i> Lihat {{ $fotos->count() }} Foto Album Saat Ini
                </button>
            </div>
            @endif

            {{-- Form Tambah Foto Baru --}}
            <form action="{{ route('admin.galeri.update', $galeri->id_galeri) }}" method="POST" enctype="multipart/form-data" class="mb-5 p-3 border rounded bg-light">
                @csrf
                @method('PUT')
                <input type="hidden" name="action_type" value="add_photo">
                
                <label for="new_foto_album" class="form-label">Unggah Foto Album Tambahan</label>
                <div class="d-flex">
                    <input class="form-control @error('new_foto_album.*') is-invalid @enderror me-2" type="file" id="new_foto_album" name="new_foto_album[]" multiple accept="image/*">
                    <button type="submit" class="btn btn-success text-nowrap">
                        <i class="bi bi-upload me-1"></i> Unggah Gambar
                    </button>
                </div>
                <div class="form-text">Pilih banyak foto untuk ditambahkan ke album ini.</div>
                @error('new_foto_album.*') <div class="text-danger small">{{ $message }}</div> @enderror
            </form>

            {{-- Daftar Foto Saat Ini (untuk aksi hapus) --}}
            <h6>Hapus Foto (Satu per Satu):</h6>
            <div class="row g-3">
                @forelse($fotos as $foto)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card p-2 shadow-sm">
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" 
                                alt="Foto Album {{ $foto->id }}" 
                                class="img-fluid rounded" 
                                style="width: 100%; height: 150px; object-fit: cover;">
                            
                            {{-- Form Hapus Foto Detail (DIUBAH UNTUK SWEETALERT) --}}
                            <form action="{{ route('admin.galeri.destroy_foto', $foto->id) }}" 
                                method="POST" 
                                class="mt-2 form-delete-foto"> 
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="foto_id" value="{{ $foto->id }}">
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada foto yang diunggah untuk album ini.</div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- MODAL DETAIL GALERI FOTO --}}
<div class="modal fade" id="photoDetailModal" tabindex="-1" aria-labelledby="photoDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="photoDetailModalLabel">Foto Detail Album: {{ $galeri->nama_album }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    @forelse($fotos as $foto)
                    <div class="col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm">
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" 
                                alt="Foto Album {{ $foto->id }}" 
                                class="img-fluid rounded" 
                                style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                <p class="card-text small text-muted">ID Foto: {{ $foto->id }}</p>
                            </div>
                        </div>
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
            const fotoId = form.querySelector('input[name="foto_id"]').value;

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
    // Dipertahankan di sini jika layout global tidak memuat SweetAlert, namun idealnya ini di layouts/app.blade.php
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
