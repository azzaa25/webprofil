@extends('layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div class="container mt-4">
    {{-- Tampilkan notifikasi success/error dari controller --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any() && (old('_admin_id') || (!old('_admin_id') && Request::routeIs('admin.user.store'))))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Gagal menyimpan data. Silakan cek kembali input Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark">👥 Kelola Admin</h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Admin
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Dibuat</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                        data-bs-target="#infoAdminModal{{ $admin->id }}">
                                    <i class="bi bi-info-circle"></i>
                                </button>

                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal"
                                        data-bs-target="#editAdminModal{{ $admin->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="infoAdminModal{{ $admin->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="bi bi-person-circle me-2"></i>Info Admin</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Nama:</strong> {{ $admin->name }}</li>
                                            <li class="list-group-item"><strong>Email:</strong> {{ $admin->email }}</li>
                                            <li class="list-group-item"><strong>Dibuat:</strong> {{ $admin->created_at->format('d M Y') }}</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Admin</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.user.update', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                {{-- Hapus atribut required di sini --}}
                                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" 
                                                    class="form-control @if($errors->has('name') && old('_admin_id') == $admin->id) is-invalid @endif">
                                                @if($errors->has('name') && old('_admin_id') == $admin->id)
                                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                {{-- Hapus atribut required di sini --}}
                                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" 
                                                    class="form-control @if($errors->has('email') && old('_admin_id') == $admin->id) is-invalid @endif">
                                                @if($errors->has('email') && old('_admin_id') == $admin->id)
                                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password Baru (opsional)</label>
                                                <input type="password" name="password" 
                                                    class="form-control @if($errors->has('password') && old('_admin_id') == $admin->id) is-invalid @endif" 
                                                    placeholder="Kosongkan jika tidak ingin mengganti">
                                                @if($errors->has('password') && old('_admin_id') == $admin->id)
                                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                                @endif
                                            </div>
                                            {{-- Field tersembunyi ini wajib ada di update --}}
                                            <input type="hidden" name="_admin_id" value="{{ $admin->id }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-white">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada admin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahAdminModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-person-plus-fill me-2"></i>Tambah Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        {{-- Hapus atribut required di sini --}}
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        {{-- Hapus atribut required di sini --}}
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        {{-- Hapus atribut required di sini --}}
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Logika tombol hapus (tidak diubah)
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;

            Swal.fire({
                title: 'Hapus Admin?',
                text: `Yakin ingin menghapus admin "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/user/${id}`; // Pastikan ini sesuai dengan route DELETE Anda
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

    // --------------------------------------------------------
    // Logika JavaScript untuk membuka kembali modal saat error
    // --------------------------------------------------------
    
    // Cek apakah ada error validasi
    const hasError = {{ $errors->any() ? 'true' : 'false' }};
    const oldAdminId = '{{ old('_admin_id') }}';
    
    if (hasError) {
        // PENTING: Untuk memastikan modal Bootstrap telah dimuat
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