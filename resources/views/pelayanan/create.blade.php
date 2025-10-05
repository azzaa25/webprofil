@extends('layouts.app') 

@section('title', 'Tambah Pelayanan Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4 text-primary">Tambah Pelayanan Baru</h2>
        
        <div class="card shadow-sm p-4 mb-4">
            <form action="{{ route('pelayanan.store') }}" method="POST">
                @csrf

                {{-- Nama Pelayanan --}}
                <div class="mb-3">
                    <label for="nama_pelayanan" class="form-label">Nama Jenis Pelayanan</label>
                    <input type="text" class="form-control @error('nama_pelayanan') is-invalid @enderror" id="nama_pelayanan" name="nama_pelayanan" value="{{ old('nama_pelayanan') }}" required>
                    @error('nama_pelayanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Deskripsi Singkat --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat (Maks. 500 Karakter)</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Persyaratan --}}
                    <div class="col-md-6 mb-3">
                        <label for="persyaratan" class="form-label">Persyaratan (Tulis setiap poin di baris baru)</label>
                        <textarea class="form-control @error('persyaratan') is-invalid @enderror" id="persyaratan" name="persyaratan" rows="5">{{ old('persyaratan') }}</textarea>
                        <div class="form-text">Contoh: Fotokopi KTP, Fotokopi KK. Pisahkan dengan ENTER.</div>
                        @error('persyaratan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Proses Pengurusan --}}
                    <div class="col-md-6 mb-3">
                        <label for="proses" class="form-label">Proses Pengurusan (Tulis setiap langkah di baris baru)</label>
                        <textarea class="form-control @error('proses') is-invalid @enderror" id="proses" name="proses" rows="5">{{ old('proses') }}</textarea>
                        <div class="form-text">Contoh: Ambil nomor antrian, Verifikasi data oleh petugas. Pisahkan dengan ENTER.</div>
                        @error('proses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Waktu Layanan --}}
                <div class="mb-3">
                    <label for="waktu_layanan" class="form-label">Waktu Layanan (Contoh: 1 hari kerja)</label>
                    <input type="text" class="form-control @error('waktu_layanan') is-invalid @enderror" id="waktu_layanan" name="waktu_layanan" value="{{ old('waktu_layanan') }}" placeholder="Contoh: 1 hari kerja">
                    @error('waktu_layanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Keterangan Tambahan --}}
                <div class="mb-4">
                    <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="5">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save me-1"></i> Simpan Layanan
                </button>
                <a href="{{ route('pelayanan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
