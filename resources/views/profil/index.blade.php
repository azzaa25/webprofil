@extends('layouts.app') 

@section('title', 'Kelola Profil')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-person-badge me-2"></i> Kelola Profil Kelurahan
            </h4>
        </div>
        <p class="text-muted">Kelola informasi dasar, struktur organisasi, dan daftar lembaga kelurahan.</p>

        {{-- Pesan Status (Success/Error Alerts) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        {{-- Pesan Error Validasi untuk Tab Pemangku Jabatan --}}
        @if ($errors->has('nama_pejabat') || $errors->has('jabatan') || $errors->has('foto_pejabat'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Terdapat kesalahan input pada tab **Pejabat**. Silakan periksa kembali formulir.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif


        {{-- Navigasi Tab --}}
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-visi-misi-tab" data-bs-toggle="pill" data-bs-target="#pills-visi-misi" type="button" role="tab" aria-controls="pills-visi-misi" aria-selected="true">📝 Visi & Misi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-struktur-tab" data-bs-toggle="pill" data-bs-target="#pills-struktur" type="button" role="tab" aria-controls="pills-struktur" aria-selected="false">🏛️ Struktur Organisasi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-lembaga-tab" data-bs-toggle="pill" data-bs-target="#pills-lembaga" type="button" role="tab" aria-controls="pills-lembaga" aria-selected="false">👥 Lembaga</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-pejabat-tab" data-bs-toggle="pill" data-bs-target="#pills-pejabat" type="button" role="tab" aria-controls="pills-pejabat" aria-selected="false">👨‍💼 Pejabat</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-sejarah-tab" data-bs-toggle="pill" data-bs-target="#pills-sejarah" type="button" role="tab" aria-controls="pills-sejarah" aria-selected="false">📜 Sejarah Kelurahan</button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">

            {{-- 1. Tab Visi & Misi (Edit) - KODE ASLI --}}
            <div class="tab-pane fade show active" id="pills-visi-misi" role="tabpanel" aria-labelledby="pills-visi-misi-tab" tabindex="0">
                <div class="card shadow-sm p-4 mb-4">
                    <form action="{{ route('admin.profil.update', ['type' => 'visi_misi']) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3 text-info">Visi</h5>
                        <div class="form-floating mb-4">
                            <textarea class="form-control @error('visi') is-invalid @enderror" name="visi" id="visiInput" style="height: 100px" required>{{ old('visi', $profileData->visi ?? '') }}</textarea>
                            <label for="visiInput">Isi Visi</label>
                            @error('visi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <h5 class="mb-3 text-info">Misi</h5>
                        <div class="form-floating mb-4">
                            <textarea class="form-control @error('misi') is-invalid @enderror" name="misi" id="misiInput" style="height: 180px" required>{{ old('misi', $profileData->misi ?? '') }}</textarea>
                            <label for="misiInput">Isi Misi (Gunakan enter untuk baris baru)</label>
                            @error('misi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            {{-- 2. Tab Struktur Organisasi (Upload/Edit) - KODE ASLI --}}
            <div class="tab-pane fade" id="pills-struktur" role="tabpanel" aria-labelledby="pills-struktur-tab" tabindex="0">
                <div class="card shadow-sm p-4 mb-4">
                    <h5 class="mb-3 text-primary">Upload Gambar Struktur Organisasi</h5>
                    
                    {{-- Form Upload --}}
                    <form action="{{ route('admin.profil.upload_struktur') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Pilih Gambar Baru (.jpg, .png)</label>
                            <input class="form-control @error('struktur_image') is-invalid @enderror" type="file" id="formFile" name="struktur_image" accept="image/*" required>
                            <div class="form-text">Maksimal: 2MB. Mengganti gambar lama.</div>
                            @error('struktur_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-success me-2">Upload/Ganti Gambar</button>
                    </form>

                    <hr class="my-4">

                    {{-- Tampilan Gambar Saat Ini --}}
                    @if($profileData->struktur_path ?? false)
                    <h6 class="mb-3">Gambar Saat Ini:</h6>
                    <div class="mb-3 p-3 border rounded text-center bg-light">
                        <img src="{{ asset('storage/' . $profileData->struktur_path) }}" alt="Struktur Organisasi" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                    </div>
                    {{-- Form Hapus --}}
                    <form action="{{ route('admin.profil.delete_struktur') }}" method="POST" onsubmit="return confirm('ANDA YAKIN INGIN MENGHAPUS GAMBAR INI ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus Gambar</button>
                    </form>
                    @else
                    <div class="alert alert-warning">Belum ada gambar Struktur Organisasi yang diunggah.</div>
                    @endif
                </div>
            </div>

            {{-- 3. Tab Lembaga (CRUD INLINE - Responsif) - KODE ASLI --}}
            <div class="tab-pane fade" id="pills-lembaga" role="tabpanel" aria-labelledby="pills-lembaga-tab" tabindex="0">
                <div class="card shadow-sm p-4 mb-4">
                    
                    <h5 class="mb-3 text-primary">Tambah Lembaga Baru</h5>
                    {{-- Form Tambah Lembaga Baru (INLINE ADD) --}}
                    <form action="{{ route('admin.lembaga.store') }}" method="POST" class="mb-5 p-3 border rounded bg-light">
                        @csrf
                        {{-- Menggunakan form-control-sm agar lebih ringkas --}}
                        <div class="row g-3">
                            <div class="col-12 col-md-5">
                                <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror" name="nama" placeholder="Nama Lembaga (cth: LPMK)" value="{{ old('nama') }}" required>
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-5">
                                <input type="text" class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Deskripsi Singkat" value="{{ old('deskripsi') }}" required>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-2">
                                <button type="submit" class="btn btn-success btn-sm w-100">Tambah</button>
                            </div>
                        </div>
                    </form>

                    <h5 class="mb-3 text-primary">Daftar Lembaga Kemasyarakatan</h5>
                    
                    {{-- Tabel Data Lembaga (INLINE EDIT) --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 25%;">Nama Lembaga</th>
                                    <th style="width: 45%;">Deskripsi Singkat</th>
                                    <th style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lembagaList as $lembaga)
                                <tr class="py-2">
                                    {{-- FORM EDIT INLINE: setiap baris adalah satu form --}}
                                    <form action="{{ route('admin.lembaga.update', $lembaga->id_lembaga) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="nama" value="{{ old('nama', $lembaga->nama) }}" required>
                                        </td>
                                        <td>
                                            <textarea class="form-control form-control-sm" name="deskripsi" rows="2" required>{{ old('deskripsi', $lembaga->deskripsi) }}</textarea>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm me-1">Simpan</button>
                                            
                                            {{-- Tombol Hapus memicu form DELETE tersembunyi --}}
                                            <button type="button" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus {{ $lembaga->nama }}?')) document.getElementById('delete-form-lembaga-{{ $lembaga->id_lembaga }}').submit();">Hapus</button>
                                        </td>
                                    </form>
                                </tr>

                                {{-- Form Hapus tersembunyi --}}
                                <form id="delete-form-lembaga-{{ $lembaga->id_lembaga }}" action="{{ route('admin.lembaga.destroy', $lembaga->id_lembaga) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data lembaga.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 4. Tab Pemangku Jabatan (CRUD) - KODE BARU --}}
            <div class="tab-pane fade" id="pills-pejabat" role="tabpanel" aria-labelledby="pills-pejabat-tab" tabindex="0">
                <div class="card shadow-sm p-4 mb-4">

                    <h5 class="mb-3 text-primary">Tambah Pejabat Baru</h5>
                    {{-- Form Tambah Pejabat Baru (dengan file upload) --}}
                    <form action="{{ route('admin.pejabat.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 border rounded bg-light">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label for="inputJabatan" class="form-label">Jabatan</label>
                                <input type="text" 
                                    class="form-control @error('jabatan') is-invalid @enderror" 
                                    id="inputJabatan" 
                                    name="jabatan" 
                                    placeholder="Cth: Lurah, Sekretaris Lurah" 
                                    value="{{ old('jabatan') }}" 
                                    required>
                                @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="inputDeskripsi" class="form-label">Deskripsi Tambahan</label>
                                <input type="text" 
                                    class="form-control @error('deskripsi') is-invalid @enderror" 
                                    id="inputDeskripsi" 
                                    name="deskripsi" 
                                    placeholder="Cth: Penanggung jawab program A" 
                                    value="{{ old('deskripsi') }}" 
                                    required>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="fotoPejabat" class="form-label">Foto Pejabat</label>
                                <input class="form-control @error('foto_pejabat') is-invalid @enderror" type="file" id="fotoPejabat" name="foto_pejabat" accept="image/*" required>
                                <div class="form-text">Maksimal: 1MB (.jpg, .png).</div>
                                @error('foto_pejabat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success">Tambah Pejabat</button>
                            </div>
                        </div>
                    </form>

                    <h5 class="mb-3 text-primary">Daftar Pemangku Jabatan</h5>
                    
                    {{-- Tabel Data Pejabat --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%;">Foto</th>
                                    <th style="width: 30%;">Jabatan</th>
                                    <th style="width: 30%;">Deskripsi</th>
                                    <th style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pejabatList as $pejabat)
                                <tr class="py-2">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($pejabat->foto_path)
                                        <img src="{{ asset('storage/' . $pejabat->foto_path) }}" alt="{{ $pejabat->jabatan }}" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                        <i class="bi bi-person-circle text-muted" style="font-size: 2rem;"></i>
                                        @endif
                                    </td>
                                    <td>{{ $pejabat->jabatan }}</td>
                                    <td>{{ $pejabat->deskripsi }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editPejabatModal{{ $pejabat->id_pejabat }}">Edit</button>
                                        
                                        {{-- Tombol Hapus memicu form DELETE tersembunyi --}}
                                        <button type="button" class="btn btn-danger btn-sm" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus {{ $pejabat->nama_pejabat }}?')) document.getElementById('delete-form-pejabat-{{ $pejabat->id_pejabat }}').submit();">Hapus</button>
                                    </td>
                                </tr>

                                {{-- Form Hapus tersembunyi --}}
                                <form id="delete-form-pejabat-{{ $pejabat->id_pejabat }}" action="{{ route('admin.pejabat.destroy', $pejabat->id_pejabat) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data pemangku jabatan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- MODAL EDIT PEJABAT (di luar tab-content untuk akses global) --}}
            @foreach($pejabatList as $pejabat)
            <div class="modal fade" id="editPejabatModal{{ $pejabat->id_pejabat }}" tabindex="-1" aria-labelledby="editPejabatModalLabel{{ $pejabat->id_pejabat }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="editPejabatModalLabel{{ $pejabat->id_pejabat }}">Edit Pejabat: {{ $pejabat->nama_pejabat }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.pejabat.update', $pejabat->id_pejabat) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editJabatan{{ $pejabat->id_pejabat }}" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="editJabatan{{ $pejabat->id_pejabat }}" name="jabatan" value="{{ old('jabatan', $pejabat->jabatan) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editDeskripsi{{ $pejabat->id_pejabat }}" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="editDeskripsi{{ $pejabat->id_pejabat }}" name="deskripsi" value="{{ old('deskripsi', $pejabat->deskripsi) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editFotoPejabat{{ $pejabat->id_pejabat }}" class="form-label">Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
                                    <input class="form-control" type="file" id="editFotoPejabat{{ $pejabat->id_pejabat }}" name="foto_pejabat" accept="image/*">
                                    <div class="form-text">Foto saat ini: <a href="{{ asset('storage/' . $pejabat->foto_path) }}" target="_blank">Lihat</a></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach


            {{-- 5. Tab Sejarah Kelurahan (Edit) - KODE ASLI (DIURUTKAN ULANG) --}}
            <div class="tab-pane fade" id="pills-sejarah" role="tabpanel" aria-labelledby="pills-sejarah-tab" tabindex="0">
                <div class="card shadow-sm p-4 mb-4">
                    <form action="{{ route('admin.profil.update', ['type' => 'sejarah']) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3 text-info">Teks Sejarah Kelurahan</h5>
                        <div class="form-floating mb-4">
                            <textarea class="form-control @error('sejarah') is-invalid @enderror" name="sejarah" id="sejarahInput" style="height: 300px" required>{{ old('sejarah', $profileData->sejarah ?? '') }}</textarea>
                            <label for="sejarahInput">Isi Sejarah Lengkap</label>
                            @error('sejarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection