@extends('layouts.app') 

@section('title', 'Kelola FAQ')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-question-circle-fill me-2"></i> Kelola FAQ (Pertanyaan Umum)
            </h4>
        </div>
        
        {{-- Form Pencarian dan Tambah --}}
        <div class="d-flex justify-content-between flex-column flex-md-row align-items-stretch align-items-md-center mb-5">
            <form action="{{ route('admin.faq.index') }}" method="GET" class="d-flex me-md-3 mb-3 mb-md-0 w-100 w-md-50">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari Pertanyaan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.faq.index') }}" class="btn btn-outline-danger" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
            <a href="{{ route('admin.faq.create') }}" class="btn btn-success shadow-sm flex-shrink-0">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Pertanyaan Baru
            </a>
        </div>

        {{-- Daftar FAQ (Menggunakan Accordion) --}}
        <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-card-list me-2"></i> Daftar Pertanyaan dan Jawaban</h5>
        
        <div class="accordion shadow-lg" id="faqAccordion">
            @forelse($faqList as $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $faq->id_faq }}">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id_faq }}" aria-expanded="false" aria-controls="collapse{{ $faq->id_faq }}">
                        {{ $faq->id_faq }}. {{ Str::limit($faq->pertanyaan, 150) }}
                    </button>
                </h2>
                <div id="collapse{{ $faq->id_faq }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id_faq }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body d-flex justify-content-between align-items-start bg-light">
                        
                        {{-- Konten Jawaban --}}
                        <div class="flex-grow-1 me-4">
                            <p class="mb-1 fw-bold text-primary">Jawaban:</p>
                            <p>{{ $faq->jawaban }}</p>
                        </div>
                        
                        {{-- Tombol Aksi --}}
                        <div class="flex-shrink-0 d-flex gap-2">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.faq.edit', $faq->id_faq) }}" class="btn btn-warning btn-sm shadow-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            
                            {{-- Tombol Hapus (Memicu SweetAlert) --}}
                            <form action="{{ route('admin.faq.destroy', $faq->id_faq) }}" method="POST" class="d-inline form-delete-faq">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-faq-button shadow-sm" 
                                    data-name="{{ Str::limit($faq->pertanyaan, 50, '...') }}" 
                                    title="Hapus Pertanyaan">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info border-0 shadow-sm p-4 mb-0">
                <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i> Informasi</h5>
                <p class="mb-0">Tidak ada data FAQ yang ditemukan.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $faqList->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

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