@extends('layouts.app') 

@section('title', 'Kelola Berita & Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-newspaper me-2"></i> Kelola Berita & Pengumuman
            </h4>
        </div>
        
        {{-- Kontainer Aksi, Filter (Diganti Nav Pills) --}}
        <div class="card p-3 shadow-lg mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                
                {{-- Tombol Aksi --}}
                <a href="{{ route('admin.berita.create') }}" class="btn btn-success me-3 shadow-sm mb-2 mb-md-0">
                    <i class="bi bi-plus-circle-fill me-1"></i> Tambah Berita Baru
                </a>
                
                {{-- Filter Kategori (MENGGUNAKAN NAV PILLS) --}}
                @php
                    $activeKategori = request('kategori') ?? 'Semua Kategori';
                @endphp

                <div class="d-flex align-items-center flex-wrap">
                    <span class="text-muted small me-3 fw-bold d-none d-lg-inline">Filter:</span>
                    
                    <ul class="nav nav-pills nav-pills-custom" role="tablist">
                        {{-- Opsi Semua Kategori --}}
                        <li class="nav-item me-1" role="presentation">
                            <a class="nav-link nav-link-custom py-1 px-3 @if($activeKategori == 'Semua Kategori') active @endif" 
                                href="{{ route('admin.berita.index') }}" 
                                role="tab">
                                <i class="bi bi-list-stars me-1"></i> Semua ({{ count($kategoriList) }})
                            </a>
                        </li>
                        
                        {{-- Opsi Kategori Dinamis --}}
                        @foreach($kategoriList as $kategori)
                            <li class="nav-item me-1" role="presentation">
                                <a class="nav-link nav-link-custom py-1 px-3 @if($activeKategori == $kategori) active @endif" 
                                    href="{{ route('admin.berita.index', ['kategori' => $kategori]) }}" 
                                    role="tab">
                                    {{ $kategori }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Daftar Berita (Loop Kartu) --}}
        @forelse($beritaList as $berita)
        <div class="card mb-4 shadow-lg border-0">
            <div class="row g-0 align-items-stretch">
                
                {{-- Kolom Gambar (30%) --}}
                <div class="col-md-3"> 
                    @if($berita->gambar)
                        <img 
                            src="{{ asset('storage/' . $berita->gambar) }}" 
                            class="img-fluid rounded-start" 
                            alt="{{ $berita->judul }}" 
                            style="width: 100%; height: 220px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded-start" 
                             style="width: 100%; height: 220px; border: 1px solid #eee;">
                             <i class="bi bi-image-fill display-6"></i>
                        </div>
                    @endif
                </div>

                {{-- Kolom Konten dan Aksi (70%) --}}
                <div class="col-md-9">
                    <div class="card-body py-3 d-flex flex-column h-100">
                        
                        <h5 class="card-title text-dark fw-bold mb-2">{{ $berita->judul }}</h5>
                        
                        {{-- Metadata --}}
                        <div class="mb-3">
                            <span class="badge bg-primary me-2"><i class="bi bi-tag-fill me-1"></i> {{ $berita->kategori }}</span>
                            <span class="text-muted small me-3"><i class="bi bi-calendar me-1"></i> {{ $berita->tanggal_publikasi->isoFormat('D MMMM YYYY') }}</span>
                            <span class="text-muted small"><i class="bi bi-person me-1"></i> {{ $berita->penulis }}</span>
                        </div>
                        
                        {{-- Ringkasan Konten --}}
                        <p class="card-text text-secondary flex-grow-1">{{ Str::limit(strip_tags($berita->konten), 200, '...') }}</p>

                        {{-- Tombol Aksi (Diletakkan di bawah dan sejajar kanan) --}}
                        <div class="mt-auto text-end pt-2 border-top">
                            {{-- TOMBOL LIHAT DETAIL --}}
                            <button type="button" class="btn btn-info btn-sm me-2 text-white shadow-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailModal{{ $berita->id_berita }}" 
                                title="Lihat Detail">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                            
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.berita.edit', $berita->id_berita) }}" class="btn btn-warning btn-sm me-2 shadow-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.berita.destroy', $berita->id_berita) }}" 
                                    method="POST" 
                                    class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL BERITA --}}
        <div class="modal fade" id="detailModal{{ $berita->id_berita }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $berita->id_berita }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="detailModalLabel{{ $berita->id_berita }}"><i class="bi bi-info-circle-fill me-2"></i> {{ $berita->judul }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-light p-2 small">
                            <strong><i class="bi bi-person me-1"></i> Penulis:</strong> {{ $berita->penulis }} |
                            <strong><i class="bi bi-calendar me-1"></i> Tanggal:</strong> {{ $berita->tanggal_publikasi->isoFormat('dddd, D MMMM YYYY') }} |
                            <strong><i class="bi bi-tag-fill me-1"></i> Kategori:</strong> <span class="badge bg-primary">{{ $berita->kategori }}</span>
                        </div>
                        
                        @if($berita->gambar)
                            <div class="text-center mb-4 p-3 border rounded bg-light">
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: contain;">
                            </div>
                        @endif

                        <h6 class="fw-bold text-secondary mt-3 mb-3">Isi Konten:</h6>
                        <div class="content-detail border p-3 rounded bg-light">
                            {{-- Hati-hati dengan output konten mentah, pastikan sudah di-sanitize jika mengandung HTML --}}
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
        <div class="alert alert-info border-0 shadow-sm p-4">
            <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i> Informasi</h5>
            <p class="mb-0">Belum ada Berita atau Pengumuman yang dipublikasikan untuk kategori ini.</p>
        </div>
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