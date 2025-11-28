@extends('layouts.app') 

@section('title', 'Edit Berita: ' . Str::limit($berita->judul, 30))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i> Edit Berita & Pengumuman
            </h4>
        </div>
        
        <p class="text-secondary small mb-4">Anda sedang mengedit entri: <span class="fw-bold text-dark">{{ $berita->judul }}</span></p>

        {{-- PEMBERITAHUAN ERROR UMUM (Ditingkatkan dengan Ikon) --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-x-octagon-fill me-2"></i> <strong>Gagal Memperbarui!</strong> Mohon periksa kembali kolom yang ditandai merah:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg p-4 mb-4">
            <form action="{{ route('admin.berita.update', $berita->id_berita) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- Kolom Kiri: Input Form Teks --}}
                    <div class="col-lg-8">
                        
                        <h5 class="text-info mb-3"><i class="bi bi-card-heading me-2"></i> Informasi Utama</h5>

                        {{-- Judul Berita --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul Berita/Pengumuman</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                    id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Slug (Input Group) --}}
                        <div class="mb-3">
                            <label for="slug" class="form-label fw-bold">Slug (URL Friendly Name)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                        id="slug" name="slug" value="{{ old('slug', $berita->slug) }}" required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Contoh: judul-berita-anda. Ubah hanya jika perlu.</div>
                        </div>

                        <div class="row">
                            {{-- Tanggal Publikasi --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_publikasi" class="form-label fw-bold">Tanggal Publikasi</label>
                                <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                                        id="tanggal_publikasi" name="tanggal_publikasi" 
                                        value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi->format('Y-m-d')) }}" required>
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
                                        <option value="{{ $kategori }}" {{ old('kategori', $berita->kategori) == $kategori ? 'selected' : '' }}>
                                            {{ $kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <h5 class="text-info mt-4 mb-3"><i class="bi bi-body-text me-2"></i> Isi Konten</h5>

                        {{-- Konten --}}
                        <div class="mb-4">
                            <label for="konten" class="form-label fw-bold">Isi Konten Berita/Pengumuman</label>
                            <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="15" required>{{ old('konten', $berita->konten) }}</textarea>
                            @error('konten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Gunakan format baris baru atau HTML sederhana jika diperlukan.</div>
                        </div>

                    </div>
                    
                    {{-- Kolom Kanan: Pratinjau Gambar --}}
                    <div class="col-lg-4">
                        
                        <h5 class="text-info mb-3"><i class="bi bi-image me-2"></i> Pratinjau Gambar</h5>
                        
                        {{-- Gambar saat ini (Pratinjau) --}}
                        <div class="mb-4 p-3 border rounded bg-light text-center shadow-sm">
                            <label class="form-label fw-bold d-block mb-2">Gambar Utama Saat Ini</label>
                            @if($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" id="currentImagePreview" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: cover; width: 100%;" alt="Gambar {{ $berita->judul }}">
                                <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-danger mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');"><i class="bi bi-trash-fill"></i> Hapus Gambar</a> 
                                {{-- Catatan: Rute penghapusan gambar spesifik harus disesuaikan dengan logika backend Anda. Saya asumsikan tombol ini hanya mengarah kembali untuk kesederhanaan. --}}
                            @else
                                <div class="alert alert-warning border-0 mb-0">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Tidak ada gambar utama yang terunggah.
                                </div>
                            @endif
                        </div>

                        {{-- Upload Gambar Baru --}}
                        <div class="mb-4 p-3 border border-dashed rounded" style="border-style: dashed !important;">
                            <label for="gambar" class="form-label fw-bold text-primary">Ganti Gambar Utama (Opsional)</label>
                            <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Maksimal: 2MB. Format: JPG, PNG.</div>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="newImagePreview" class="img-fluid rounded mt-2 d-none" style="max-height: 150px; object-fit: cover; width: 100%;" alt="Pratinjau Gambar Baru">
                        </div>
                        
                    </div>
                </div>

                <div class="col-12 border-top pt-4">
                    <button type="submit" class="btn btn-primary me-2 shadow-sm">
                        <i class="bi bi-arrow-repeat me-1"></i> Simpan Perubahan
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
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    });
</script>
@endpush