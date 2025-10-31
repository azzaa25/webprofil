@extends('layouts.app') 

@section('title', 'Kelola FAQ')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-question-circle me-2"></i> Kelola FAQ (Pertanyaan Umum)
            </h4>
        </div>
        
        {{-- Pesan Status (Dihapus, karena sudah ditangani oleh SweetAlert global di layouts/app.blade.php) --}}
        
        {{-- Form Pencarian dan Tambah --}}
        <div class="d-flex justify-content-between mb-4">
            <form action="{{ route('admin.faq.index') }}" method="GET" class="d-flex me-3 w-50">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Pertanyaan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Cari</button>
            </form>
            <a href="{{ route('admin.faq.create') }}" class="btn btn-success">
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
                                <a href="{{ route('admin.faq.edit', $faq->id_faq) }}" class="btn btn-primary btn-sm me-2" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                {{-- Tombol Hapus (Memicu SweetAlert) --}}
                                <form action="{{ route('admin.faq.destroy', $faq->id_faq) }}" method="POST" class="d-inline form-delete-faq">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-faq-button" 
                                        data-name="{{ Str::limit($faq->pertanyaan, 50, '...') }}" 
                                        title="Hapus Pertanyaan">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
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

{{-- MODAL KONFIRMASI HAPUS (DIHAPUS KARENA DIGANTI SWEETALERT) --}}

@push('scripts')
{{-- SweetAlert2 harus sudah dimuat di layouts/app.blade.php --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-faq-button');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); 
            const form = this.closest('.form-delete-faq'); 
            const faqName = this.getAttribute('data-name'); 

            Swal.fire({
                title: 'Hapus Pertanyaan?',
                text: `Anda yakin ingin menghapus pertanyaan: "${faqName}"? Aksi ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
});
</script>
@endpush
@endsection
