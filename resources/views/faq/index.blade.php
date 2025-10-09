@extends('layouts.app') 

@section('title', 'Kelola FAQ')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4 text-primary">Kelola FAQ (Pertanyaan Umum)</h2>
        
        {{-- Pesan Status --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        {{-- Form Pencarian dan Tambah --}}
        <div class="d-flex justify-content-between mb-4">
            <form action="{{ route('faq.index') }}" method="GET" class="d-flex me-3 w-50">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Pertanyaan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Cari</button>
            </form>
            <a href="{{ route('faq.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Pertanyaan
            </a>
        </div>

        {{-- Tabel Daftar FAQ --}}
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 40%;">Pertanyaan</th>
                            <th style="width: 40%;">Jawaban</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqList as $faq)
                        <tr>
                            <td>{{ $faq->id_faq }}</td>
                            <td>{{ Str::limit($faq->pertanyaan, 100) }}</td>
                            <td>{{ Str::limit($faq->jawaban, 100) }}</td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('faq.edit', $faq->id_faq) }}" class="btn btn-primary btn-sm me-2" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                {{-- Tombol Hapus (Menggunakan Modal Konfirmasi) --}}
                                <button type="button" class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $faq->id_faq }}"
                                    data-name="{{ $faq->pertanyaan }}"
                                    title="Hapus Pertanyaan">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data FAQ yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $faqList->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pertanyaan: <span id="deleteFaqName" class="fw-bold"></span> Aksi ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteFormFaq" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('confirmDeleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; 
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            
            const deleteForm = document.getElementById('deleteFormFaq');
            const deleteFaqName = document.getElementById('deleteFaqName');

            deleteFaqName.textContent = name;

            // Menggunakan rute 'faq.destroy'
            const routeBase = "{{ route('faq.destroy', ':id') }}";
            const routeUrl = routeBase.replace(':id', id);

            deleteForm.action = routeUrl;
        });
    }
});
</script>
@endpush
@endsection
