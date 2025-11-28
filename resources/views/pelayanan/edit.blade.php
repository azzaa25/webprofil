@extends('layouts.app')

@section('title', 'Edit Pelayanan: ' . Str::limit($pelayanan->nama_pelayanan, 30))

@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i> Edit Rincian Pelayanan
            </h4>
        </div>
        
        <p class="text-secondary small mb-4">Anda sedang mengedit layanan: <span class="fw-bold text-dark">{{ $pelayanan->nama_pelayanan }}</span></p>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-x-octagon-fill me-2"></i> <strong>🚨 Mohon Perhatian!</strong> Ada beberapa kesalahan pengisian data. Silakan periksa kembali kolom yang ditandai.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-lg p-4 mb-4">
            <form action="{{ route('admin.pelayanan.update', $pelayanan->id_pelayanan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Group 1: Informasi Utama & Deskripsi --}}
                <h5 class="text-info mb-3"><i class="bi bi-info-circle-fill me-2"></i> Informasi Utama</h5>
                
                <div class="row g-3">
                    {{-- Nama Pelayanan --}}
                    <div class="col-md-8 mb-3">
                        <label for="nama_pelayanan" class="form-label fw-bold">Nama Jenis Pelayanan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                            <input type="text" class="form-control @error('nama_pelayanan') is-invalid @enderror" id="nama_pelayanan" name="nama_pelayanan" value="{{ old('nama_pelayanan', $pelayanan->nama_pelayanan) }}" required>
                        </div>
                        @error('nama_pelayanan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Waktu Layanan --}}
                    <div class="col-md-4 mb-3">
                        <label for="waktu_layanan" class="form-label fw-bold">Waktu Layanan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
                            <input type="text" class="form-control @error('waktu_layanan') is-invalid @enderror" id="waktu_layanan" name="waktu_layanan" value="{{ old('waktu_layanan', $pelayanan->waktu_layanan) }}" placeholder="Contoh: 1 hari kerja" required>
                        </div>
                        @error('waktu_layanan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi Singkat --}}
                <div class="mb-4">
                    <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat (Penjelasan umum layanan)</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $pelayanan->deskripsi) }}</textarea>
                    <div class="form-text">Maksimal 500 karakter.</div>
                    @error('deskripsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Group 2: Persyaratan & Proses --}}
                <h5 class="text-info mb-3"><i class="bi bi-list-ol me-2"></i> Detail Prosedur</h5>
                
                <div class="row g-4">
                    {{-- Persyaratan --}}
                    <div class="col-md-6">
                        <label for="persyaratan" class="form-label fw-bold text-success"><i class="bi bi-file-earmark-check-fill me-1"></i> Persyaratan</label>
                        <textarea class="form-control @error('persyaratan') is-invalid @enderror" id="persyaratan" name="persyaratan" rows="8" placeholder="Tulis setiap poin persyaratan di baris baru" required>{{ old('persyaratan', $pelayanan->persyaratan) }}</textarea>
                        <div class="form-text">Pisahkan setiap persyaratan dengan menekan tombol ENTER.</div>
                        @error('persyaratan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Proses Pengurusan --}}
                    <div class="col-md-6">
                        <label for="proses" class="form-label fw-bold text-success"><i class="bi bi-arrow-right-circle-fill me-1"></i> Proses Pengurusan</label>
                        <textarea class="form-control @error('proses') is-invalid @enderror" id="proses" name="proses" rows="8" placeholder="Tulis setiap langkah proses di baris baru" required>{{ old('proses', $pelayanan->proses) }}</textarea>
                        <div class="form-text">Pisahkan setiap langkah proses dengan menekan tombol ENTER.</div>
                        @error('proses')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                {{-- Group 3: Keterangan Tambahan --}}
                <h5 class="text-info mb-3"><i class="bi bi-chat-left-text-fill me-2"></i> Keterangan Tambahan</h5>
                
                {{-- Keterangan Tambahan --}}
                <div class="mb-4">
                    <label for="keterangan" class="form-label fw-bold">Keterangan (Opsional, info penting lain)</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="5">{{ old('keterangan', $pelayanan->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-4 pt-3 border-top text-end">
                    <a href="{{ route('admin.pelayanan.index') }}" class="btn btn-outline-secondary me-2 shadow-sm">
                        <i class="bi bi-x-circle-fill me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-arrow-repeat me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection