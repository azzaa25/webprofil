@extends('layouts.app') 
{{-- Menggunakan layout yang sama dengan dashboard admin --}}

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-file-earmark-plus-fill me-2"></i> Tambah Berita & Pengumuman Baru
            </h4>
        </div>
        
        {{-- PEMBERITAHUAN ERROR UMUM (Ditingkatkan dengan Ikon) --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-x-octagon-fill me-2"></i> <strong>🚨 Gagal Publikasi!</strong> Mohon periksa kembali kolom yang ditandai merah:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="card shadow-lg p-4 mb-4">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    {{-- Kolom Kiri: Input Form Teks (8/12) --}}
                    <div class="col-lg-8">
                        
                        <h5 class="text-info mb-3"><i class="bi bi-card-heading me-2"></i> Informasi Utama</h5>

                        {{-- Judul Berita --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul Berita/Pengumuman</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                    id="judul" name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Tanggal Publikasi --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_publikasi" class="form-label fw-bold">Tanggal Publikasi</label>
                                <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                                        id="tanggal_publikasi" name="tanggal_publikasi" 
                                        value="{{ old('tanggal_publikasi', date('Y-m-d')) }}" required>
                                @error('tanggal_publikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label fw-bold">Kategori</label>
                                <select class="form-select @error('kategori') is-invalid @enderror" 
                                        id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoriList as $kategori)
                                        <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <h5 class="text-info mt-4 mb-3"><i class="bi bi-body-text me-2"></i> Isi Konten</h5>

                        {{-- Konten Berita --}}
                        <div class="mb-4">
                            <label for="konten" class="form-label fw-bold">Isi Konten Berita/Pengumuman</label>
                            <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="15" required>{{ old('konten') }}</textarea>
                            @error('konten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Gunakan format baris baru atau HTML sederhana jika diperlukan.</div>
                        </div>

                    </div>
                    
                    {{-- Kolom Kanan: Upload & Pratinjau Gambar (4/12) --}}
                    <div class="col-lg-4">
                        <h5 class="text-info mb-3"><i class="bi bi-image-fill me-2"></i> Gambar Utama</h5>

                        {{-- Upload Gambar Baru --}}
                        <div class="mb-4 p-3 border border-dashed rounded" style="border-style: dashed !important;">
                            <label for="gambar" class="form-label fw-bold text-primary">Upload Gambar Utama</label>
                            <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Maksimal: 2MB. Format: JPG, PNG.</div>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            {{-- Pratinjau Gambar Baru --}}
                            <div class="mt-3">
                                <label class="form-label small fw-bold">Pratinjau:</label>
                                <img id="newImagePreview" class="img-fluid rounded shadow-sm d-none" style="max-height: 250px; object-fit: cover; width: 100%;" alt="Pratinjau Gambar Baru">
                                <div id="noImageText" class="alert alert-light p-2 mt-2 mb-0 text-center">
                                    <i class="bi bi-image-alt me-1"></i> Belum ada file dipilih.
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="col-12 border-top pt-4">
                    <button type="submit" class="btn btn-success me-2 shadow-sm">
                        <i class="bi bi-send-fill me-1"></i> Publikasikan
                    </button>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsionalitas Pratinjau Gambar Baru
    document.getElementById('gambar').addEventListener('change', function(event) {
        const preview = document.getElementById('newImagePreview');
        const noImageText = document.getElementById('noImageText');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                noImageText.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
            noImageText.classList.remove('d-none');
        }
    });
</script>
@endpush