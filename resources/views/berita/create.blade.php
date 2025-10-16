@extends('layouts.app') 
{{-- Menggunakan layout yang sama dengan dashboard admin --}}

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4 text-primary">Tambah Berita & Pengumuman Baru</h2>
        
        <div class="card shadow-sm p-4 mb-4">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul Berita --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita/Pengumuman</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Tanggal Publikasi --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi', date('Y-m-d')) }}" required>
                        @error('tanggal_publikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
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
                
                {{-- Gambar Utama --}}
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Utama (Opsional)</label>
                    <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar" accept="image/*">
                    <div class="form-text">Maksimal: 2MB. Format: JPG, PNG.</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konten Berita --}}
                <div class="mb-4">
                    <label for="konten" class="form-label">Isi Konten Berita/Pengumuman</label>
                    {{-- Anda bisa mengganti ini dengan CKEditor atau TinyMCE jika Anda menggunakannya --}}
                    <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="10" required>{{ old('konten') }}</textarea>
                    @error('konten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save me-1"></i> Publikasikan
                </button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection