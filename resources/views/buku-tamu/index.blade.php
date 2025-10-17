@extends('layouts.app')

@section('title', 'Kelola Buku Tamu')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-book"></i> Kelola Buku Tamu
        </h4>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter dan tombol --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('admin.buku-tamu.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="tanggal_dari" class="form-label fw-semibold mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control"
                        value="{{ request('tanggal_dari') }}">
                </div>

                <div class="col-md-3">
                    <label for="tanggal_sampai" class="form-label fw-semibold mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control"
                        value="{{ request('tanggal_sampai') }}">
                </div>

                <div class="col-md-3">
                    <label for="keperluan" class="form-label fw-semibold mb-1">Keperluan</label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control"
                        placeholder="Masukkan keperluan..." value="{{ request('keperluan') }}">
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.buku-tamu.index', ['sort' => 'desc']) }}" class="btn btn-info text-white">
                        <i class="bi bi-sort-down-alt"></i> Terbaru
                    </a>
                    <a href="{{ route('admin.buku-tamu.index') }}" class="btn btn-success text-white">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel data --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center table-bordered">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>Keperluan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bukutamu as $index => $tamu)
                            <tr>
                                <td>{{ $bukutamu->firstItem() + $index }}</td>
                                <td>{{ $tamu->nama_lengkap }}</td>
                                <td>{{ $tamu->alamat_lengkap }}</td>
                                <td>{{ $tamu->keperluan }}</td>
                                <td>{{ \Carbon\Carbon::parse($tamu->tanggal)->format('d/m/Y') }}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Detail --}}
                                    <button type="button" 
                                            class="btn btn-sm btn-primary btn-anim" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal{{ $tamu->id_bukutamu }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" 
                                            class="btn btn-sm btn-danger btn-anim btn-delete" 
                                            data-id="{{ $tamu->id_bukutamu }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    {{-- Form hapus tersembunyi --}}
                                    <form id="delete-form-{{ $tamu->id_bukutamu }}" 
                                          action="{{ route('admin.buku-tamu.destroy', $tamu->id_bukutamu) }}" 
                                          method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal detail --}}
                            <div class="modal fade" id="detailModal{{ $tamu->id_bukutamu }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-gradient bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-person-lines-fill me-2"></i> Detail Buku Tamu
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start p-4">
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <p><strong>Nama:</strong> {{ $tamu->nama_lengkap }}</p>
                                                    <p><strong>Alamat:</strong> {{ $tamu->alamat_lengkap }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Keperluan:</strong> {{ $tamu->keperluan }}</p>
                                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tamu->tanggal)->translatedFormat('d F Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i> Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-3">Belum ada data buku tamu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
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
                cancelButtonColor: '#3085d6',
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
