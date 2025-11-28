@extends('layouts.app') 

@section('title', 'Tambah Pertanyaan FAQ')

@section('content')
<div class="row">
    {{-- Menggunakan kolom tengah untuk fokus --}}
    <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2"> 
        
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-patch-question-fill me-2"></i> Tambah Pertanyaan Umum (FAQ)
            </h4>
        </div>
        
        <div class="card shadow-lg p-4 mb-4">
            <form action="{{ route('admin.faq.store') }}" method="POST">
                @csrf

                {{-- Group 1: ID & Urutan --}}
                <div class="row g-3 mb-4 border-bottom pb-4">
                    {{-- ID (Disabled) --}}
                    <div class="col-md-6">
                        <label for="id_view" class="form-label fw-bold text-muted">ID Pertanyaan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-hash"></i></span>
                            <input type="text" class="form-control" id="id_view" value="Otomatis Dibuat" disabled>
                        </div>
                    </div>
                    
                    {{-- Urutan Tampil --}}
                    <div class="col-md-6">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampil (Angka)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-sort-numeric-down-alt"></i></span>
                            <input type="number" class="form-control @error('urutan') is-invalid @enderror" 
                                id="urutan" name="urutan" 
                                value="{{ old('urutan', $nextUrutan ?? 1) }}" 
                                placeholder="{{ $nextUrutan ?? 1 }}">
                        </div>
                        <div class="form-text">Angka yang lebih kecil akan tampil lebih dulu.</div>
                        @error('urutan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Group 2: Pertanyaan & Jawaban --}}
                <h5 class="text-info mb-3"><i class="bi bi-lightbulb-fill me-2"></i> Isi Konten</h5>
                
                {{-- Pertanyaan --}}
                <div class="mb-3">
                    <label for="pertanyaan" class="form-label fw-bold">Pertanyaan</label>
                    <textarea class="form-control @error('pertanyaan') is-invalid @enderror" id="pertanyaan" name="pertanyaan" rows="3" required>{{ old('pertanyaan') }}</textarea>
                    <div class="form-text">Usahakan pertanyaan ringkas dan langsung.</div>
                    @error('pertanyaan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Jawaban --}}
                <div class="mb-4">
                    <label for="jawaban" class="form-label fw-bold">Jawaban</label>
                    <textarea class="form-control @error('jawaban') is-invalid @enderror" id="jawaban" name="jawaban" rows="8" required>{{ old('jawaban') }}</textarea>
                    <div class="form-text">Berikan jawaban yang jelas dan lengkap.</div>
                    @error('jawaban')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="mt-4 pt-3 border-top text-end">
                    <a href="{{ route('admin.faq.index') }}" class="btn btn-outline-secondary me-2 shadow-sm">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection