@extends('layouts.app')

@section('title', 'Kelola Buku Tamu')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-book-fill me-2"></i> Kelola Buku Tamu
        </h4>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter dan tombol (Ditingkatkan) --}}
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-body p-4">
            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-funnel-fill me-2"></i> Filter Data Kunjungan</h6>
            <form action="{{ route('admin.buku-tamu.index') }}" method="GET" class="row g-3 align-items-end">
                
                <div class="col-md-3">
                    <label for="tanggal_dari" class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control form-control-sm"
                        value="{{ request('tanggal_dari') }}">
                </div>

                <div class="col-md-3">
                    <label for="tanggal_sampai" class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control form-control-sm"
                        value="{{ request('tanggal_sampai') }}">
                </div>

                <div class="col-md-4">
                    <label for="keperluan" class="form-label small fw-bold">Cari Keperluan/Nama</label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control form-control-sm"
                        placeholder="Cth: Mengurus KTP / Nama Tamu..." value="{{ request('keperluan') }}">
                </div>

                <div class="col-md-2 d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-primary btn-sm shadow-sm">
                        <i class="bi bi-search me-1"></i> Cari & Filter
                    </button>
                    <a href="{{ route('admin.buku-tamu.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </a>
                </div>
            </form>
            
            <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                <a href="{{ route('admin.buku-tamu.index', ['sort' => 'desc']) }}" class="btn btn-info text-white btn-sm me-2 shadow-sm">
                    <i class="bi bi-sort-down-alt me-1"></i> Urut Terbaru
                </a>
                {{-- OPSI EXPORT EXCEL DIHAPUS --}}
            </div>
        </div>
    </div>

    {{-- Tabel data --}}
    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-table me-2"></i> Hasil Data Kunjungan</h6>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle table-sm">
                    <thead class="table-primary text-white">
                        <tr class="align-middle">
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 20%;">Nama Tamu</th>
                            <th style="width: 30%;">Alamat</th>
                            <th style="width: 25%;">Keperluan</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bukutamu as $index => $tamu)
                            <tr>
                                <td class="text-center">{{ $bukutamu->firstItem() + $index }}</td>
                                <td class="fw-bold">{{ $tamu->nama_lengkap }}</td>
                                <td class="small text-muted">{{ Str::limit($tamu->alamat_lengkap, 50) }}</td>
                                <td>{{ $tamu->keperluan }}</td>
                                <td>{{ \Carbon\Carbon::parse($tamu->tanggal)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Detail --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-primary btn-anim" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal{{ $tamu->id_bukutamu }}"
                                                title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger btn-anim btn-delete" 
                                                data-id="{{ $tamu->id_bukutamu }}"
                                                title="Hapus Data">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        {{-- Form hapus tersembunyi --}}
                                        <form id="delete-form-{{ $tamu->id_bukutamu }}" 
                                                action="{{ route('admin.buku-tamu.destroy', $tamu->id_bukutamu) }}" 
                                                method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal detail (Ditingkatkan) --}}
                            <div class="modal fade" id="detailModal{{ $tamu->id_bukutamu }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-person-vcard-fill me-2"></i> Detail Tamu: {{ $tamu->nama_lengkap }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start p-4">
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <p class="mb-2"><span class="fw-bold text-secondary"><i class="bi bi-person-fill me-2"></i> Nama Lengkap:</span> {{ $tamu->nama_lengkap }}</p>
                                                    <p class="mb-2"><span class="fw-bold text-secondary"><i class="bi bi-calendar-event me-2"></i> Tanggal Kunjungan:</span> {{ \Carbon\Carbon::parse($tamu->tanggal)->translatedFormat('d F Y') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-2"><span class="fw-bold text-secondary"><i class="bi bi-geo-alt-fill me-2"></i> Alamat:</span></p>
                                                    <div class="alert alert-light border p-2 small">{{ $tamu->alamat_lengkap }}</div>
                                                </div>
                                            </div>
                                            
                                            <hr>

                                            <div class="mb-2">
                                                <p class="fw-bold text-secondary"><i class="bi bi-briefcase-fill me-2"></i> Keperluan Kunjungan:</p>
                                                <div class="alert alert-info p-3 fw-bold">{{ $tamu->keperluan }}</div>
                                            </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i> Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4 text-center">
                                    <i class="bi bi-info-circle fs-5 me-2"></i> Belum ada data buku tamu yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <span class="small text-muted">Menampilkan {{ $bukutamu->firstItem() }} sampai {{ $bukutamu->lastItem() }} dari total {{ $bukutamu->total() }} data.</span>
                {{ $bukutamu->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Animasi tombol */
.btn-anim {
    transition: all 0.2s ease;
}
.btn-anim:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
}
.btn-anim:active {
    transform: scale(0.95);
}
/* Memperjelas modal header gradient */
.modal-header.bg-primary {
    background-color: #007bff !important;
    background-image: linear-gradient(180deg, #007bff, #0056b3) !important;
}
</style>
@endpush

@push('scripts')
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d', // Ubah warna batal menjadi abu-abu
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endpush