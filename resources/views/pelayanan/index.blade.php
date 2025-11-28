@extends('layouts.app') 

@section('title', 'Kelola Pelayanan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-clipboard-check-fill me-2"></i> Daftar Layanan Kelurahan
            </h4>
        </div>
        
        {{-- BAGIAN KELOLA GAMBAR SOP (Dipertahankan dari versi sebelumnya, bisa disesuaikan posisinya jika ingin) --}}
        @isset($profileData)
        <div class="card shadow-lg mb-5 border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold text-info mb-4"><i class="bi bi-file-earmark-image me-2"></i> Gambar Standar Operasional Prosedur (SOP)</h5>
                
                <div class="row g-4 align-items-center">
                    
                    {{-- Pratinjau Gambar --}}
                    <div class="col-md-5">
                        <div class="p-3 border rounded bg-light text-center" style="min-height: 200px;">
                            <label class="d-block fw-bold text-secondary mb-2">Pratinjau SOP Saat Ini:</label>
                            @if ($profileData->gambar_sop)
                                <img 
                                    src="{{ Storage::url($profileData->gambar_sop) }}" 
                                    alt="Gambar SOP Pelayanan" 
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 250px; object-fit: contain;"
                                >
                                <form action="{{ route('profil.delete_sop') }}" method="POST" class="d-inline mt-3 form-delete-sop">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                        <i class="bi bi-trash-fill me-1"></i> Hapus SOP
                                    </button>
                                </form>
                            @else
                                <div class="p-4 text-center text-danger">
                                    <i class="bi bi-exclamation-triangle-fill display-5"></i>
                                    <p class="mb-0 mt-2">Belum ada Gambar SOP yang diunggah.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Form Upload/Ganti Gambar --}}
                    <div class="col-md-7">
                        <form action="{{ route('profil.upload_sop') }}" method="POST" enctype="multipart/form-data" class="pt-2">
                            @csrf
                            
                            <h6 class="fw-bold text-primary">Upload/Ganti Gambar Baru:</h6>
                            <div class="mb-3">
                                <label for="gambar_sop_image" class="form-label fw-bold small">
                                    Pilih File Gambar <small class="text-muted">(Max 2MB, JPEG/PNG)</small>
                                </label>
                                <input type="file" name="gambar_sop_image" id="gambar_sop_image" class="form-control @error('gambar_sop_image') is-invalid @enderror" required>
                                @error('gambar_sop_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary mt-2 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-1"></i> 
                                @if($profileData->gambar_sop) Perbarui Gambar SOP @else Upload Gambar SOP @endif
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @endisset
        {{-- END: BAGIAN KELOLA GAMBAR SOP --}}
        
        <hr class="mt-5">
        
        <h5 class="fw-bold text-primary mb-4 mt-4"><i class="bi bi-card-list me-2"></i> Daftar Semua Layanan</h5>

        {{-- Form Pencarian dan Tombol Tambah --}}
        <div class="d-flex justify-content-between flex-column flex-md-row align-items-stretch align-items-md-center mb-4">
            <form action="{{ route('admin.pelayanan.index') }}" method="GET" class="d-flex me-md-3 mb-3 mb-md-0 w-100 w-md-50">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama layanan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.pelayanan.index') }}" class="btn btn-outline-danger" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
            <a href="{{ route('admin.pelayanan.create') }}" class="btn btn-success shadow-sm flex-shrink-0">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Pelayanan Baru
            </a>
        </div>

        {{-- Daftar Pelayanan (Menggunakan Card List) --}}
        <div class="row g-4">
            @forelse($pelayananList as $pelayanan)
            <div class="col-md-6 col-lg-4"> {{-- Menggunakan 3 kolom di layar besar, 2 di medium --}}
                <div class="card h-100 shadow-sm border-0 transform-on-hover"> {{-- Efek hover --}}
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary text-white me-3">
                                <i class="bi bi-gear-fill"></i> {{-- Contoh ikon, bisa disesuaikan --}}
                            </div>
                            <h5 class="card-title fw-bold text-primary mb-0">{{ $pelayanan->nama_pelayanan }}</h5>
                        </div>
                        <p class="card-text text-secondary mb-4 flex-grow-1 line-clamp-3">{{ Str::limit($pelayanan->deskripsi, 120) }}</p> {{-- Batasi baris --}}
                        
                        <div class="mt-auto d-flex justify-content-end gap-2 border-top pt-3">
                            {{-- Tombol Lihat Detail --}}
                            <button type="button" class="btn btn-info btn-sm text-white shadow-sm d-flex align-items-center" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailModal{{ $pelayanan->id_pelayanan }}" 
                                title="Lihat Detail">
                                <i class="bi bi-eye me-1"></i> Detail
                            </button>
                            
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.pelayanan.edit', $pelayanan->id_pelayanan) }}" class="btn btn-warning btn-sm shadow-sm d-flex align-items-center" title="Edit">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                            
                            {{-- Tombol Hapus (Memicu SweetAlert) --}}
                            <form action="{{ route('admin.pelayanan.destroy', $pelayanan->id_pelayanan) }}" 
                                method="POST" 
                                class="d-inline form-delete" 
                                data-nama-pelayanan="{{ $pelayanan->nama_pelayanan }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm d-flex align-items-center" title="Hapus">
                                    <i class="bi bi-trash-fill me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MODAL DETAIL PELAYANAN (Tetap di dalam loop) --}}
            <div class="modal fade" id="detailModal{{ $pelayanan->id_pelayanan }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $pelayanan->id_pelayanan }}" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title fw-bold" id="detailModalLabel{{ $pelayanan->id_pelayanan }}">
                                <i class="bi bi-file-text-fill me-2"></i> Detail Layanan: {{ $pelayanan->nama_pelayanan }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            
                            <h6 class="mb-3 text-primary"><i class="bi bi-info-circle-fill me-2"></i> Deskripsi Layanan:</h6>
                            <div class="alert alert-light p-3 border rounded shadow-sm">{{ $pelayanan->deskripsi }}</div>

                            <div class="row g-4 mt-3">
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-list-check me-2"></i> Persyaratan:</h6>
                                    <div class="bg-light p-3 rounded border shadow-sm" style="min-height: 150px;">
                                        @if(is_array($pelayanan->persyaratan) && count($pelayanan->persyaratan) > 0)
                                            <ul class="list-group list-group-flush small">
                                                @foreach($pelayanan->persyaratan as $syarat)
                                                    <li class="list-group-item bg-light border-0 px-0"><i class="bi bi-check-circle-fill text-success me-2"></i> {{ $syarat }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="text-muted text-center py-4">
                                                <i class="bi bi-folder-x display-6 mb-2"></i>
                                                <p class="mb-0">Tidak ada persyaratan spesifik yang dicantumkan.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-arrow-right-circle-fill me-2"></i> Langkah Proses Pengurusan:</h6>
                                    <div class="bg-light p-3 rounded border shadow-sm" style="min-height: 150px;">
                                        @if(is_array($pelayanan->proses) && count($pelayanan->proses) > 0)
                                            <ol class="list-group list-group-numbered small">
                                                @foreach($pelayanan->proses as $langkah)
                                                    <li class="list-group-item border-0 px-0">{{ $langkah }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <div class="text-muted text-center py-4">
                                                <i class="bi bi-journal-x display-6 mb-2"></i>
                                                <p class="mb-0">Tidak ada rincian proses pengurusan.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h6 class="mb-3 text-warning"><i class="bi bi-clock-fill me-2"></i> Waktu Pelayanan:</h6>
                                    <div class="alert alert-warning fw-bold shadow-sm p-3 mb-0">{{ $pelayanan->waktu_layanan ?? 'Informasi tidak tersedia.' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3 text-secondary"><i class="bi bi-chat-dots-fill me-2"></i> Keterangan:</h6>
                                    <div class="alert alert-secondary p-3 shadow-sm mb-0">{{ $pelayanan->keterangan ?? 'Tidak ada keterangan tambahan.' }}</div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info shadow-sm p-4 text-center">
                    <h5 class="mb-2"><i class="bi bi-info-circle-fill me-2"></i> Tidak Ada Layanan Ditemukan</h5>
                    <p class="mb-0">Belum ada data pelayanan yang terdaftar atau sesuai dengan pencarian Anda.</p>
                    <a href="{{ route('admin.pelayanan.create') }}" class="btn btn-info mt-3 text-white shadow-sm">
                        <i class="bi bi-plus-circle-fill me-1"></i> Tambah Layanan Pertama Anda
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $pelayananList->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card.transform-on-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card.transform-on-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --------------------------------------------------------------------------
    // 1. Logika SweetAlert untuk Hapus Pelayanan (Card List)
    // --------------------------------------------------------------------------
    const formsDeletePelayanan = document.querySelectorAll('.form-delete');
    
    formsDeletePelayanan.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); 

            // Mengambil nama pelayanan dari data attribute
            const namaPelayanan = form.getAttribute('data-nama-pelayanan') || "layanan ini"; 

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus layanan "${namaPelayanan}"? Data yang dihapus tidak bisa dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });

    // --------------------------------------------------------------------------
    // 2. Logika SweetAlert untuk Hapus Gambar SOP (Konfigurasi Global)
    // --------------------------------------------------------------------------
    const formDeleteSOP = document.querySelector('.form-delete-sop');
    
    if (formDeleteSOP) {
        formDeleteSOP.addEventListener('submit', function (e) {
            e.preventDefault(); 

            Swal.fire({
                title: 'Konfirmasi Hapus SOP',
                text: "Anda akan menghapus Gambar SOP Global. Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Gambar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    formDeleteSOP.submit(); 
                }
            });
        });
    }
});
</script>
@endpush
@endsection