@extends('layouts.app') 

@section('title', 'Kelola Galeri')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-images me-2"></i> Kelola Galeri Album Foto
            </h4>
        </div>
        
        {{-- Tombol Aksi dan Search Bar --}}
        <div class="d-flex justify-content-between flex-column flex-md-row align-items-stretch align-items-md-center mb-5">
            
            {{-- Search Bar --}}
            <form action="{{ route('admin.galeri.index') }}" method="GET" class="d-flex me-md-3 mb-3 mb-md-0 w-100 w-md-50">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama album/Kegiatan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary" title="Cari"><i class="bi bi-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-danger" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
            
            <a href="{{ route('admin.galeri.create') }}" class="btn btn-success shadow-sm flex-shrink-0">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Album Baru
            </a>
        </div>

        {{-- Daftar Album (Card Grid View) --}}
        <div class="row g-4">
            @forelse($albums as $album)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-lg border-0 transform-on-hover">
                    
                    {{-- Cover Album --}}
                    @if($album->cover_path)
                        <img src="{{ asset('storage/' . $album->cover_path) }}" 
                             class="card-img-top album-cover" 
                             alt="Cover {{ $album->nama_album }}" 
                             style="height: 180px; object-fit: cover;">
                    @else
                        <div class="card-img-top d-flex flex-column align-items-center justify-content-center bg-light text-muted" style="height: 180px;">
                            <i class="bi bi-image display-4"></i>
                            <p class="small mb-0">No Cover</p>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title fw-bold text-dark mb-2 line-clamp-2" title="{{ $album->nama_album }}">
                            {{ $album->nama_album }}
                        </h6>
                        
                        {{-- Metadata --}}
                        <div class="d-flex justify-content-between small text-muted mb-3">
                            <span><i class="bi bi-calendar me-1"></i> {{ $album->tanggal->format('d/m/Y') }}</span>
                            <span class="fw-bold text-primary">
                                <i class="bi bi-camera-fill me-1"></i> {{ $album->fotos_count }} Foto
                            </span>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-auto d-flex justify-content-end gap-1 pt-2 border-top">
                            {{-- Tombol LIHAT DETAIL --}}
                            <button type="button" class="btn btn-info btn-sm text-white shadow-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detailAlbumModal{{ $album->id_galeri }}"
                                title="Lihat Album">
                                <i class="bi bi-eye"></i>
                            </button>
                            
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.galeri.edit', $album->id_galeri) }}" class="btn btn-warning btn-sm shadow-sm" title="Edit Rincian">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.galeri.destroy', $album->id_galeri) }}" 
                                method="POST" 
                                class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="album_name" value="{{ $album->nama_album }}">
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Album">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- MODAL DETAIL ALBUM (Ditempatkan di dalam loop) --}}
            <div class="modal fade" id="detailAlbumModal{{ $album->id_galeri }}" tabindex="-1" aria-labelledby="detailAlbumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title fw-bold" id="detailAlbumModalLabel">
                                <i class="bi bi-images me-2"></i> Detail Album: {{ $album->nama_album }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            
                            {{-- Metadata Detail --}}
                            <div class="alert alert-light p-3 small d-flex justify-content-between">
                                <span><i class="bi bi-calendar-event me-1"></i> Tanggal Kegiatan: <strong>{{ $album->tanggal->isoFormat('dddd, D MMMM YYYY') }}</strong></span>
                                <span><i class="bi bi-camera me-1"></i> Total Foto: <strong class="text-primary">{{ $album->fotos_count }}</strong></span>
                            </div>
                            
                            <h6>Pratinjau Foto Album:</h6>
                            <div class="row g-2 mt-3">
                                @forelse($album->fotos as $foto)
                                    <div class="col-6 col-md-3 col-lg-2">
                                        <a href="{{ asset('storage/' . $foto->foto_path) }}" target="_blank" title="Lihat Gambar Asli">
                                            <img src="{{ asset('storage/' . $foto->foto_path) }}" 
                                                 alt="Foto {{ $foto->id }}" 
                                                 class="img-fluid rounded shadow-sm border photo-thumbnail"
                                                 style="width: 100%; height: 120px; object-fit: cover;">
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-warning text-center">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Album ini belum memiliki foto detail.
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <a href="{{ route('admin.galeri.edit', $album->id_galeri) }}" class="btn btn-warning shadow-sm">
                                <i class="bi bi-pencil me-2"></i> Edit Album & Foto Detail
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            
            @empty
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm p-4 text-center">
                    <h5 class="mb-2"><i class="bi bi-info-circle-fill me-2"></i> Tidak Ada Album Galeri Ditemukan</h5>
                    <p class="mb-0">Belum ada Album Galeri yang terdaftar atau sesuai dengan pencarian Anda.</p>
                    <a href="{{ route('admin.galeri.create') }}" class="btn btn-info mt-3 text-white shadow-sm">
                        <i class="bi bi-plus-circle-fill me-1"></i> Tambah Album Pertama Anda
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $albums->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('scripts')
{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.form-delete');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 

                // Ambil nama album dari hidden input
                const albumName = form.querySelector('input[name="album_name"]').value;

                Swal.fire({
                    title: 'Konfirmasi Hapus Album',
                    text: `Anda akan menghapus album "${albumName}" beserta semua fotonya. Data yang dihapus tidak bisa dikembalikan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus Album!',
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
@endsection