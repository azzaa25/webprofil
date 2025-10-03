@extends('layouts.app') 

@section('title', 'Edit Berita: ' . Str::limit($berita->judul, 30))

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4 text-primary">Edit Berita & Pengumuman</h2>
        <p class="text-muted">Anda sedang mengedit: <b>{{ $berita->judul }}</b></p>
        
        <div class="card shadow-sm p-4 mb-4">
            {{-- ✅ cukup kirim $berita->id_berita --}}
            <form action="{{ route('berita.update', $berita->id_berita) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul Berita --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita/Pengumuman</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Slug --}}
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug (URL Friendly Name)</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                           id="slug" name="slug" value="{{ old('slug', $berita->slug) }}" required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Contoh: judul-berita-anda. Ubah hanya jika perlu.</div>
                </div>

                <div class="row">
                    {{-- Tanggal Publikasi --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                               id="tanggal_publikasi" name="tanggal_publikasi" 
                               value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi->format('Y-m-d')) }}" required>
                        @error('tanggal_publikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
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
                
                {{-- Upload Gambar --}}
                <div class="mb-3">
                    <label for="gambar" class="form-label">Ganti Gambar Utama (opsional)</label>
                    <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar" accept="image/*">
                    <div class="form-text">Maksimal: 2MB. Format: JPG, PNG.</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Gambar saat ini --}}
                @if($berita->gambar)
                    <div class="mb-4">
                        <h6>Gambar Saat Ini:</h6>
                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Gambar {{ $berita->judul }}">
                    </div>
                @else
                    <div class="mb-4 alert alert-warning">
                        Tidak ada gambar utama yang terunggah.
                    </div>
                @endif

                {{-- Konten --}}
                <div class="mb-4">
                    <label for="konten" class="form-label">Isi Konten Berita/Pengumuman</label>
                    <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="10" required>{{ old('konten', $berita->konten) }}</textarea>
                    @error('konten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-arrow-repeat me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
