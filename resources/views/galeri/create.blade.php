@extends('layouts.app') 

@section('title', 'Tambah Galeri')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-folder-plus me-2"></i> Tambah Album Baru
            </h4>
        </div>
        
        {{-- Pesan Error Validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-x-octagon-fill me-2"></i> <strong>🚨 Gagal Menyimpan!</strong> Mohon periksa kembali kolom yang ditandai.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg p-4 mb-4">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    {{-- Kolom Kiri: Detail Album (Nama & Tanggal) --}}
                    <div class="col-lg-7">
                        <h5 class="text-info mb-3"><i class="bi bi-card-heading me-2"></i> Detail Album</h5>
                        
                        {{-- Nama Album --}}
                        <div class="mb-3">
                            <label for="nama_album" class="form-label fw-bold">Nama Album / Kegiatan</label>
                            <input type="text" 
                                class="form-control @error('nama_album') is-invalid @enderror" 
                                id="nama_album" 
                                name="nama_album" 
                                value="{{ old('nama_album') }}"
                                placeholder="Contoh: Kegiatan Kerja Bakti Bulan Januari"
                                required>
                            @error('nama_album') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tanggal Kegiatan --}}
                        <div class="mb-4">
                            <label for="tanggal" class="form-label fw-bold">Tanggal Kegiatan</label>
                            <input type="date" 
                                class="form-control @error('tanggal') is-invalid @enderror" 
                                id="tanggal" 
                                name="tanggal" 
                                value="{{ old('tanggal', date('Y-m-d')) }}" 
                                required>
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="d-lg-none my-4">

                        {{-- Unggah Banyak Foto Detail --}}
                        <h5 class="text-info mb-3"><i class="bi bi-upload me-2"></i> Foto Detail Album</h5>
                        <div class="mb-4 p-4 border rounded bg-light">
                            <label for="foto_album" class="form-label fw-bold">Unggah Banyak Foto Kegiatan</label>
                            <input class="form-control @error('foto_album.*') is-invalid @enderror" type="file" id="foto_album" name="foto_album[]" multiple accept="image/*">
                            <div class="form-text mt-1">Anda dapat memilih banyak foto sekaligus untuk album ini. Maksimal 2MB per foto.</div>
                            @error('foto_album.*') <div class="text-danger small">{{ $message }}</div> @enderror
                            @error('foto_album') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    {{-- Kolom Kanan: Cover & Pratinjau (Opsional) --}}
                    <div class="col-lg-5">
                        <h5 class="text-warning mb-3"><i class="bi bi-image-fill me-2"></i> Foto Cover (Thumbnail)</h5>
                        
                        <div class="mb-4 p-4 border border-dashed rounded bg-light" style="border-style: dashed !important;">
                            <label for="cover_file" class="form-label fw-bold">Pilih Foto Cover Album</label>
                            
                            {{-- Input File --}}
                            <input class="form-control @error('cover_file') is-invalid @enderror" 
                                type="file" 
                                id="cover_file" 
                                name="cover_file" 
                                accept="image/*" 
                                required>
                            <div class="form-text">Gambar ini akan menjadi thumbnail album di halaman galeri.</div>
                            @error('cover_file') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            {{-- Pratinjau Cover --}}
                            <div class="mt-3 text-center">
                                <label class="form-label small fw-bold">Pratinjau Cover:</label>
                                <img id="coverPreview" class="img-fluid rounded shadow-sm d-none" style="width: 150px; height: 150px; object-fit: cover;" alt="Pratinjau Cover">
                                <div id="noCoverText" class="alert alert-light p-2 mt-2 mb-0 text-center">
                                    <i class="bi bi-image-alt me-1"></i> Belum ada cover dipilih.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-12 mt-4 pt-3 border-top text-end">
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary me-2 shadow-sm">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Album
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fungsionalitas Pratinjau Gambar Cover Baru
    document.getElementById('cover_file').addEventListener('change', function(event) {
        const preview = document.getElementById('coverPreview');
        const noCoverText = document.getElementById('noCoverText');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                noCoverText.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
            noCoverText.classList.remove('d-none');
        }
    });

    // Handle error display on load for consistency
    @if ($errors->has('cover_file'))
        document.getElementById('coverPreview').classList.add('d-none');
        document.getElementById('noCoverText').classList.remove('d-none');
    @endif
});
</script>
@endpush