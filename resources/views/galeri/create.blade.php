@extends('layouts.app') 

@section('title', 'Tambah Galeri')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4 text-primary">Tambah Album Baru</h2>
        
        <div class="card shadow-sm p-4 mb-4">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Album --}}
                <div class="mb-4">
                    <label for="nama_album" class="form-label">Nama Album / Kegiatan</label>
                    <input type="text" 
                        class="form-control @error('nama_album') is-invalid @enderror" 
                        id="nama_album" 
                        name="nama_album" 
                        value="{{ old('nama_album') }}"
                        {{-- required Dihapus --}}
                    >
                    @error('nama_album') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    {{-- Cover Album --}}
                    <div class="col-md-6 mb-4">
                        <label for="cover_file" class="form-label">Pilih Foto Cover Album</label>
                        <input class="form-control @error('cover_file') is-invalid @enderror" 
                            type="file" 
                            id="cover_file" 
                            name="cover_file" 
                            accept="image/*" 
                            {{-- required Dihapus --}}
                        >
                        <div class="form-text">Maksimal: 2MB. Gambar ini akan menjadi thumbnail album.</div>
                        @error('cover_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Tanggal Kegiatan --}}
                    <div class="col-md-6 mb-4">
                        <label for="tanggal" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" 
                            class="form-control @error('tanggal') is-invalid @enderror" 
                            id="tanggal" 
                            name="tanggal" 
                            value="{{ old('tanggal', date('Y-m-d')) }}" 
                            {{-- required Dihapus --}}
                        >
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Foto Album (Multiple Upload) --}}
                <div class="mb-4">
                    <label for="foto_album" class="form-label">Unggah Banyak Foto Album</label>
                    {{-- Atribut required tidak diperlukan di sini karena upload multiple foto bersifat nullable di controller --}}
                    <input class="form-control @error('foto_album.*') is-invalid @enderror" type="file" id="foto_album" name="foto_album[]" multiple accept="image/*">
                    <div class="form-text">Anda dapat memilih banyak foto sekaligus. Maksimal 2MB per foto.</div>
                    @error('foto_album.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @error('foto_album') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
