@extends('layouts.app') 

@section('title', 'Edit Pertanyaan FAQ')

@section('content')
<div class="row">
    <div class="col-12 col-md-8 offset-md-2">
        <h2 class="mb-4 text-primary">Edit Pertanyaan Umum (FAQ)</h2>
        
        <div class="card shadow-sm p-4 mb-4">
            <form action="{{ route('admin.faq.update', $faq->id_faq) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ID --}}
                <div class="mb-3">
                    <label for="id_view" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id_view" value="{{ $faq->id_faq }}" disabled>
                </div>
                
                {{-- Pertanyaan --}}
                <div class="mb-3">
                    <label for="pertanyaan" class="form-label">Pertanyaan</label>
                    <textarea class="form-control @error('pertanyaan') is-invalid @enderror" id="pertanyaan" name="pertanyaan" rows="3" required>{{ old('pertanyaan', $faq->pertanyaan) }}</textarea>
                    @error('pertanyaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Jawaban --}}
                <div class="mb-3">
                    <label for="jawaban" class="form-label">Jawaban</label>
                    <textarea class="form-control @error('jawaban') is-invalid @enderror" id="jawaban" name="jawaban" rows="6" required>{{ old('jawaban', $faq->jawaban) }}</textarea>
                    @error('jawaban')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Urutan Tampil --}}
                <div class="mb-4">
                    <label for="urutan" class="form-label">Urutan Tampil (Angka)</label>
                    <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', $faq->urutan) }}" required>
                    <div class="form-text">Angka yang lebih kecil akan tampil lebih dulu.</div>
                    @error('urutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('admin.faq.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-arrow-repeat me-1"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
