@extends('layouts.app') 

@section('title', 'Kelola Galeri')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-images me-2"></i> Kelola Galeri
            </h4>
        </div>
        
        {{-- Pesan Status (Dihapus, karena SweetAlert global di layouts/app.blade.php sudah menanganinya, dan SweetAlert lokal di bawah juga menanganinya.) --}}
        
        <div class="d-flex justify-content-between mb-4">
            {{-- Search Bar --}}
            {{-- Tambahkan form GET untuk fungsi search --}}
            <form action="{{ route('admin.galeri.index') }}" method="GET" class="d-flex me-3">
                <input type="text" name="search" class="form-control me-2" style="width: 300px;" placeholder="Nama album/Kegiatan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Cari</button>
            </form>
            
            <a href="{{ route('admin.galeri.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Album Baru
            </a>
        </div>

        {{-- Tabel Daftar Album --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 10%;">Cover</th>
                            <th style="width: 40%;">Nama Album</th>
                            <th style="width: 15%;">Jumlah Foto</th>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($albums as $album)
                        <tr>
                            <td>
                                @if($album->cover_path)
                                    <img src="{{ asset('storage/' . $album->cover_path) }}" 
                                        alt="{{ $album->nama_album }}" 
                                        class="img-fluid rounded shadow-sm" 
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                                @endif
                            </td>
                            <td>{{ $album->nama_album }}</td>
                            <td>{{ $album->fotos_count }}</td>
                            <td>{{ $album->tanggal->format('d/m/Y') }}</td>
                            <td>
                                {{-- Tombol LIHAT DETAIL --}}
                                <button type="button" class="btn btn-info btn-sm me-2 text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailAlbumModal{{ $album->id_galeri }}"
                                    title="Lihat Detail Album">
                                    <i class="bi bi-eye"></i>
                                </button>
                                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.galeri.edit', $album->id_galeri) }}" class="btn btn-primary btn-sm me-2" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                {{-- Tombol Hapus (Memicu SweetAlert) --}}
                                <form action="{{ route('admin.galeri.destroy', $album->id_galeri) }}" 
                                    method="POST" 
                                    class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    {{-- Hidden input untuk menyimpan nama, agar bisa ditampilkan di alert --}}
                                    <input type="hidden" name="album_name" value="{{ $album->nama_album }}"> 
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        
                        {{-- MODAL DETAIL ALBUM (Ditempatkan di dalam loop) --}}
                        <div class="modal fade" id="detailAlbumModal{{ $album->id_galeri }}" tabindex="-1" aria-labelledby="detailAlbumModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="detailAlbumModalLabel">Detail Album: {{ $album->nama_album }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Cover Album:</h6>
                                        <div class="text-center mb-4 p-3 border rounded">
                                            @if($album->cover_path)
                                                <img src="{{ asset('storage/' . $album->cover_path) }}" 
                                                    alt="Cover {{ $album->nama_album }}" 
                                                    class="img-fluid rounded shadow-sm" 
                                                    style="max-height: 250px;">
                                            @else
                                                <i class="bi bi-image-alt fs-1 text-muted"></i>
                                                <p class="text-muted">Tidak ada foto cover.</p>
                                            @endif
                                        </div>

                                        <h6>Detail Kegiatan:</h6>
                                        <p><strong>Nama:</strong> {{ $album->nama_album }}</p>
                                        <p><strong>Tanggal:</strong> {{ $album->tanggal->isoFormat('dddd, D MMMM YYYY') }}</p>
                                        <p><strong>Total Foto:</strong> {{ $album->fotos_count }}</p>

                                        <hr>
                                        
                                        <h6>Pratinjau Foto Album:</h6>
                                        <div class="row g-2">
                                            @forelse($album->fotos as $foto)
                                                <div class="col-4 col-md-3">
                                                    <img src="{{ asset('storage/' . $foto->foto_path) }}" 
                                                        alt="Foto {{ $foto->id }}" 
                                                        class="img-fluid rounded"
                                                        style="width: 100%; height: 100px; object-fit: cover;">
                                                </div>
                                            @empty
                                                <div class="col-12 text-muted small">Tidak ada foto detail di album ini.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route('admin.galeri.edit', $album->id_galeri) }}" class="btn btn-warning me-auto">
                                            <i class="bi bi-pencil"></i> Edit Album
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada Album Galeri yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $albums->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS (DIHAPUS karena diganti SweetAlert) --}}


@push('scripts')
{{-- SweetAlert2 CDN (Ditambahkan untuk memastikan SweetAlert tersedia) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.form-delete');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 

                // Ambil nama album dari hidden input yang baru ditambahkan
                const albumName = form.querySelector('input[name="album_name"]').value;

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Anda akan menghapus album "${albumName}" beserta semua fotonya. Data yang dihapus tidak bisa dikembalikan!`,
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

        // Logika session('success') untuk menampilkan notifikasi sukses
        // (Dipertahankan, meskipun idealnya ada di layout global, untuk memastikan notifikasi muncul)
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
