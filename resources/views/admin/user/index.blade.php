@extends('layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div class="container mt-4">
    {{-- Notifikasi Error/Success ditangani di JS menggunakan SweetAlert --}}
    
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-person-gear-fill me-2"></i> Kelola Administrator
        </h4>
        <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Admin Baru
        </button>
    </div>

    {{-- Notifikasi Error Validasi yang Muncul Saat Modal Tertutup --}}
    @if ($errors->any() && (old('_admin_id') || (!old('_admin_id') && Request::routeIs('admin.user.store'))))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal menyimpan data. Silakan cek kembali input Anda di modal yang terbuka.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary text-white">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 30%;">Nama</th>
                            <th style="width: 35%;">Email</th>
                            <th style="width: 15%;">Dibuat</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td class="small text-muted">{{ $admin->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-info btn-sm text-white shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#infoAdminModal{{ $admin->id }}" title="Lihat Info">
                                        <i class="bi bi-info-circle"></i>
                                    </button>

                                    <button class="btn btn-warning btn-sm text-white shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#editAdminModal{{ $admin->id }}" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button class="btn btn-danger btn-sm delete-btn shadow-sm" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Info --}}
                        <div class="modal fade" id="infoAdminModal{{ $admin->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-person-circle me-2"></i>Info Administrator</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <ul class="list-group list-group-flush small">
                                            <li class="list-group-item d-flex justify-content-between"><strong>Nama:</strong> <span>{{ $admin->name }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><strong>Email:</strong> <span>{{ $admin->email }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between"><strong>Dibuat Sejak:</strong> <span>{{ $admin->created_at->translatedFormat('d F Y') }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Administrator</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.user.update', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nama</label>
                                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" 
                                                    class="form-control @if($errors->has('name') && old('_admin_id') == $admin->id) is-invalid @endif">
                                                @if($errors->has('name') && old('_admin_id') == $admin->id)
                                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Email</label>
                                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" 
                                                    class="form-control @if($errors->has('email') && old('_admin_id') == $admin->id) is-invalid @endif">
                                                @if($errors->has('email') && old('_admin_id') == $admin->id)
                                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Password Baru (opsional)</label>
                                                <input type="password" name="password" 
                                                    class="form-control @if($errors->has('password') && old('_admin_id') == $admin->id) is-invalid @endif" 
                                                    placeholder="Kosongkan jika tidak ingin mengganti">
                                                @if($errors->has('password') && old('_admin_id') == $admin->id)
                                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                                @endif
                                            </div>
                                            {{-- Field tersembunyi ini wajib ada di update untuk logika JS --}}
                                            <input type="hidden" name="_admin_id" value="{{ $admin->id }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-white shadow-sm"><i class="bi bi-save me-1"></i> Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i> Belum ada administrator terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="tambahAdminModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Tambah Administrator Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success shadow-sm"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const routeDestroy = '/admin/user/';

    // --- Logika Tombol Hapus (SweetAlert) ---
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;

            Swal.fire({
                title: 'Hapus Administrator?',
                text: `Yakin ingin menghapus administrator "${name}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    // Membuat form DELETE dinamis
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = routeDestroy + id; 
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // --- Logika JavaScript untuk membuka kembali modal saat error ---
    const hasError = {{ $errors->any() ? 'true' : 'false' }};
    const oldAdminId = '{{ old('_admin_id') }}';
    
    if (hasError) {
        // PENTING: Memastikan modal Bootstrap telah dimuat
        const bootstrap = window.bootstrap;

        if (oldAdminId) {
            // Error dari operasi UPDATE
            const modalEditElement = document.getElementById('editAdminModal' + oldAdminId);
            if (modalEditElement) {
                const modalEdit = new bootstrap.Modal(modalEditElement);
                modalEdit.show();
            }
        } else {
            // Error dari operasi STORE
            const modalTambahElement = document.getElementById('tambahAdminModal');
            if (modalTambahElement) {
                const modalTambah = new bootstrap.Modal(modalTambahElement);
                modalTambah.show();
            }
        }
    }
});
</script>
@endpush