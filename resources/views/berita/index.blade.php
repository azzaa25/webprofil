@extends('layouts.app') 

@section('title', 'Kelola Berita & Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4 text-primary">Kelola Berita & Pengumuman</h2>
        
        {{-- Tombol Aksi dan Filter --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.berita.create') }}" class="btn btn-success me-3">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Berita Baru
            </a>
            
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter Kategori
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.berita.index') }}">Semua Kategori</a></li>
                    @foreach($kategoriList as $kategori)
                        <li><a class="dropdown-item" href="{{ route('admin.berita.index', ['kategori' => $kategori]) }}">{{ $kategori }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Daftar Berita (Loop Kartu) --}}
        @forelse($beritaList as $berita)
        <div class="card mb-4 shadow-sm">
            <div class="row g-0 align-items-center">
                
                {{-- Kolom Gambar --}}
                <div class="col-md-3 p-3"> 
                    @if($berita->gambar)
                        <img 
                            src="{{ asset('storage/' . $berita->gambar) }}" 
                            class="img-fluid rounded shadow-sm" 
                            alt="{{ $berita->judul }}" 
                            style="width: 100%; height: 180px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded" 
                             style="width: 100%; height: 180px; border: 1px solid #ccc;">
                            Tidak Ada Gambar
                        </div>
                    @endif
                </div>

                {{-- Kolom Konten dan Aksi --}}
                <div class="col-md-9">
                    <div class="card-body py-3">
                        <h5 class="card-title text-primary">{{ $berita->judul }}</h5>
                        
                        <p class="card-text text-muted small mb-2">
                            Oleh: <strong class="text-dark">{{ $berita->penulis }}</strong> | 
                            {{ $berita->tanggal_publikasi->isoFormat('D MMMM YYYY') }} | 
                            Kategori: <span class="badge bg-secondary">{{ $berita->kategori }}</span>
                        </p>
                        
                        {{-- Batasi Teks Konten --}}
                        <p class="card-text">{{ Str::limit(strip_tags($berita->konten), 120, '...') }}</p>

                        {{-- Tombol Aksi --}}
                        <div class="mt-3 text-end">
                            {{-- TOMBOL LIHAT DETAIL --}}
                            <button type="button" class="btn btn-info btn-sm me-2 text-white" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailModal{{ $berita->id_berita }}" 
                                title="Lihat Detail">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </button>
                            
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.berita.edit', $berita->id_berita) }}" class="btn btn-primary btn-sm me-2" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.berita.destroy', $berita->id_berita) }}" 
                                  method="POST" 
                                  class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL BERITA --}}
        <div class="modal fade" id="detailModal{{ $berita->id_berita }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $berita->id_berita }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="detailModalLabel{{ $berita->id_berita }}">{{ $berita->judul }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Oleh: <strong>{{ $berita->penulis }}</strong> | 
                            Tanggal: {{ $berita->tanggal_publikasi->isoFormat('dddd, D MMMM YYYY') }} | 
                            Kategori: <span class="badge bg-primary">{{ $berita->kategori }}</span>
                        </p>
                        
                        @if($berita->gambar)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="img-fluid rounded shadow-sm" style="max-height: 350px;">
                            </div>
                        @endif

                        <hr>
                        <h6>Isi Konten:</h6>
                        <div class="content-detail">
                            <p>{!! nl2br(e($berita->konten)) !!}</p> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @empty
        <div class="alert alert-info">Belum ada Berita atau Pengumuman yang dipublikasikan.</div>
        @endforelse

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            @if($beritaList instanceof \Illuminate\Pagination\AbstractPaginator)
                {{ $beritaList->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.form-delete');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data berita yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            });
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush
