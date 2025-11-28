@extends('layouts.app') 

@section('title', 'Kelola Profil')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-person-badge-fill me-2"></i> Kelola Profil Kelurahan
            </h4>
        </div>
        <p class="text-muted border-bottom pb-3">Kelola informasi dasar, struktur organisasi, pejabat, dan daftar lembaga kelurahan.</p>

        {{-- Pesan Status (Success/Error Alerts) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                **Berhasil!** {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-x-octagon-fill me-2"></i>
                **Gagal!** {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        {{-- Pesan Error Validasi untuk Tab Pemangku Jabatan --}}
        @if ($errors->has('nama_pejabat') || $errors->has('jabatan') || $errors->has('foto_pejabat') || $errors->has('deskripsi_pejabat'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Terdapat **kesalahan validasi** pada tab **👨‍💼 Pejabat**. Silakan periksa kembali formulir input.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif


        {{-- Navigasi Tab --}}
        <ul class="nav nav-pills nav-fill mb-4 p-2 bg-white rounded shadow-sm" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-visi-misi-tab" data-bs-toggle="pill" data-bs-target="#pills-visi-misi" type="button" role="tab" aria-controls="pills-visi-misi" aria-selected="true"><i class="bi bi-journals me-1"></i> Visi & Misi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-struktur-tab" data-bs-toggle="pill" data-bs-target="#pills-struktur" type="button" role="tab" aria-controls="pills-struktur" aria-selected="false"><i class="bi bi-diagram-3-fill me-1"></i> Struktur Organisasi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-lembaga-tab" data-bs-toggle="pill" data-bs-target="#pills-lembaga" type="button" role="tab" aria-controls="pills-lembaga" aria-selected="false"><i class="bi bi-people-fill me-1"></i> Lembaga</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-pejabat-tab" data-bs-toggle="pill" data-bs-target="#pills-pejabat" type="button" role="tab" aria-controls="pills-pejabat" aria-selected="false"><i class="bi bi-person-workspace me-1"></i> Pejabat</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-sejarah-tab" data-bs-toggle="pill" data-bs-target="#pills-sejarah" type="button" role="tab" aria-controls="pills-sejarah" aria-selected="false"><i class="bi bi-clock-history me-1"></i> Sejarah Kelurahan</button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">

            {{-- 1. Tab Visi & Misi (Edit) --}}
            <div class="tab-pane fade show active" id="pills-visi-misi" role="tabpanel" aria-labelledby="pills-visi-misi-tab" tabindex="0">
                <div class="card shadow-lg p-4 mb-4">
                    <form action="{{ route('admin.profil.update', ['type' => 'visi_misi']) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3 text-primary"><i class="bi bi-eye-fill me-2"></i> Visi Kelurahan</h5>
                        <div class="form-floating mb-4">
                            <textarea class="form-control @error('visi') is-invalid @enderror" name="visi" id="visiInput" style="height: 100px" required>{{ old('visi', $profileData->visi ?? '') }}</textarea>
                            <label for="visiInput">Isi Visi</label>
                            @error('visi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <h5 class="mb-3 text-primary"><i class="bi bi-bullseye me-2"></i> Misi Kelurahan</h5>
                        <div class="form-floating mb-4">
                            <textarea class="form-control @error('misi') is-invalid @enderror" name="misi" id="misiInput" style="height: 180px" required>{{ old('misi', $profileData->misi ?? '') }}</textarea>
                            <label for="misiInput">Isi Misi (Gunakan enter untuk baris baru)</label>
                            @error('misi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-2 shadow-sm"><i class="bi bi-save me-2"></i> Simpan Visi & Misi</button>
                    </form>
                </div>
            </div>

            {{-- 2. Tab Struktur Organisasi (Upload/Edit) --}}
            <div class="tab-pane fade" id="pills-struktur" role="tabpanel" aria-labelledby="pills-struktur-tab" tabindex="0">
                <div class="card shadow-lg p-4 mb-4">
                    <h5 class="mb-3 text-primary"><i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload Gambar Struktur Organisasi</h5>
                    
                    {{-- Form Upload --}}
                    <form action="{{ route('admin.profil.upload_struktur') }}" method="POST" enctype="multipart/form-data" class="p-3 border rounded bg-light mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Pilih Gambar Baru (.jpg, .png)</label>
                            <input class="form-control @error('struktur_image') is-invalid @enderror" type="file" id="formFile" name="struktur_image" accept="image/*" required>
                            <div class="form-text">Maksimal: 2MB. Gambar ini akan mengganti gambar lama.</div>
                            @error('struktur_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-success me-2 shadow-sm"><i class="bi bi-upload me-2"></i> Upload Gambar</button>
                    </form>

                    <hr class="my-4">

                    {{-- Tampilan Gambar Saat Ini --}}
                    <h5 class="mb-3 text-primary"><i class="bi bi-image-fill me-2"></i> Gambar Saat Ini</h5>
                    @if($profileData->struktur_path ?? false)
                    <div class="mb-3 p-3 border rounded text-center bg-white shadow-sm">
                        <img src="{{ asset('storage/' . $profileData->struktur_path) }}" alt="Struktur Organisasi" class="img-fluid rounded" style="max-height: 450px; object-fit: contain; width: 100%;">
                    </div>
                    {{-- Form Hapus --}}
                    <form action="{{ route('admin.profil.delete_struktur') }}" method="POST" onsubmit="return confirm('ANDA YAKIN INGIN MENGHAPUS GAMBAR STRUKTUR INI SECARA PERMANEN?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mt-2 shadow-sm"><i class="bi bi-trash-fill me-2"></i> Hapus Gambar Saat Ini</button>
                    </form>
                    @else
                    <div class="alert alert-warning border-0">
                        <i class="bi bi-info-circle-fill me-2"></i> Belum ada gambar Struktur Organisasi yang diunggah.
                    </div>
                    @endif
                </div>
            </div>

            {{-- 3. Tab Lembaga (CRUD INLINE - Responsif) --}}
            <div class="tab-pane fade" id="pills-lembaga" role="tabpanel" aria-labelledby="pills-lembaga-tab" tabindex="0">
                <div class="card shadow-lg p-4 mb-4">
                    
                    <h5 class="mb-3 text-primary"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Lembaga Baru</h5>
                    {{-- Form Tambah Lembaga Baru (INLINE ADD) --}}
                    <form action="{{ route('admin.lembaga.store') }}" method="POST" class="mb-5 p-4 border border-success rounded bg-light">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-4">
                                <label for="namaLembaga" class="form-label small fw-bold">Nama Lembaga</label>
                                <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror" id="namaLembaga" name="nama" placeholder="Cth: LPMK" value="{{ old('nama') }}" required>
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-5">
                                <label for="deskripsiLembaga" class="form-label small fw-bold">Deskripsi Singkat</label>
                                <input type="text" class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" id="deskripsiLembaga" name="deskripsi" placeholder="Cth: Lembaga Pemberdayaan Masyarakat" value="{{ old('deskripsi') }}" required>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm"><i class="bi bi-plus me-2"></i> Tambah</button>
                            </div>
                        </div>
                    </form>

                    <h5 class="mb-3 text-primary"><i class="bi bi-list-stars me-2"></i> Daftar Lembaga Kemasyarakatan</h5>
                    
                    {{-- Tabel Data Lembaga (INLINE EDIT) --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle table-sm border">
                            <thead class="bg-primary text-white">
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
                                            <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $lembaga->nama) }}" required>
                                        </td>
                                        <td>
                                            <textarea class="form-control form-control-sm @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="2" required>{{ old('deskripsi', $lembaga->deskripsi) }}</textarea>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm me-1 shadow-sm"><i class="bi bi-arrow-repeat"></i> Simpan</button>
                                            
                                            {{-- Tombol Hapus memicu form DELETE tersembunyi --}}
                                            <button type="button" class="btn btn-danger btn-sm shadow-sm" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus {{ $lembaga->nama }}?')) document.getElementById('delete-form-lembaga-{{ $lembaga->id_lembaga }}').submit();"><i class="bi bi-trash"></i> Hapus</button>
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
                                    <td colspan="4" class="text-center text-muted p-3">Tidak ada data lembaga yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 4. Tab Pemangku Jabatan (CRUD) --}}
            <div class="tab-pane fade" id="pills-pejabat" role="tabpanel" aria-labelledby="pills-pejabat-tab" tabindex="0">
                <div class="card shadow-lg p-4 mb-4">

                    <h5 class="mb-3 text-primary"><i class="bi bi-person-plus-fill me-2"></i> Tambah Pejabat Baru</h5>
                    {{-- Form Tambah Pejabat Baru (dengan file upload) --}}
                    <form action="{{ route('admin.pejabat.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 border border-success rounded bg-light">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label for="inputJabatan" class="form-label small fw-bold">Jabatan</label>
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
                                <label for="inputDeskripsi" class="form-label small fw-bold">Deskripsi Tambahan</label>
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
                                <label for="fotoPejabat" class="form-label small fw-bold">Foto Pejabat</label>
                                <input class="form-control @error('foto_pejabat') is-invalid @enderror" type="file" id="fotoPejabat" name="foto_pejabat" accept="image/*" required>
                                <div class="form-text">Maksimal: 1MB (.jpg, .png).</div>
                                @error('foto_pejabat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success shadow-sm"><i class="bi bi-person-add me-2"></i> Tambah Pejabat</button>
                            </div>
                        </div>
                    </form>

                    <h5 class="mb-3 text-primary"><i class="bi bi-card-list me-2"></i> Daftar Pemangku Jabatan</h5>
                    
                    {{-- Tabel Data Pejabat --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle border">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%;">Foto</th>
                                    <th style="width: 25%;">Jabatan</th>
                                    <th style="width: 35%;">Deskripsi</th>
                                    <th style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pejabatList as $pejabat)
                                <tr class="py-2">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($pejabat->foto_path)
                                        <img src="{{ asset('storage/' . $pejabat->foto_path) }}" alt="{{ $pejabat->jabatan }}" class="img-fluid rounded-circle border shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                        <i class="bi bi-person-circle text-muted" style="font-size: 2rem;"></i>
                                        @endif
                                    </td>
                                    <td>**{{ $pejabat->jabatan }}**</td>
                                    <td class="small text-wrap">{{ $pejabat->deskripsi }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm me-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#editPejabatModal{{ $pejabat->id_pejabat }}"><i class="bi bi-pencil-square"></i> Edit</button>
                                        
                                        {{-- Tombol Hapus memicu form DELETE tersembunyi --}}
                                        <button type="button" class="btn btn-danger btn-sm shadow-sm" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus pejabat {{ $pejabat->jabatan }}?')) document.getElementById('delete-form-pejabat-{{ $pejabat->id_pejabat }}').submit();"><i class="bi bi-trash"></i> Hapus</button>
                                    </td>
                                </tr>

                                {{-- Form Hapus tersembunyi --}}
                                <form id="delete-form-pejabat-{{ $pejabat->id_pejabat }}" action="{{ route('admin.pejabat.destroy', $pejabat->id_pejabat) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted p-3">Belum ada data pemangku jabatan yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- MODAL EDIT PEJABAT (Tidak diubah, hanya dipercantik sedikit) --}}
            @foreach($pejabatList as $pejabat)
            <div class="modal fade" id="editPejabatModal{{ $pejabat->id_pejabat }}" tabindex="-1" aria-labelledby="editPejabatModalLabel{{ $pejabat->id_pejabat }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title fw-bold" id="editPejabatModalLabel{{ $pejabat->id_pejabat }}">Edit Pejabat: {{ $pejabat->jabatan }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.pejabat.update', $pejabat->id_pejabat) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editJabatan{{ $pejabat->id_pejabat }}" class="form-label fw-bold">Jabatan</label>
                                    <input type="text" class="form-control" id="editJabatan{{ $pejabat->id_pejabat }}" name="jabatan" value="{{ old('jabatan', $pejabat->jabatan) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editDeskripsi{{ $pejabat->id_pejabat }}" class="form-label fw-bold">Deskripsi</label>
                                    <input type="text" class="form-control" id="editDeskripsi{{ $pejabat->id_pejabat }}" name="deskripsi" value="{{ old('deskripsi', $pejabat->deskripsi) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editFotoPejabat{{ $pejabat->id_pejabat }}" class="form-label fw-bold">Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
                                    <input class="form-control" type="file" id="editFotoPejabat{{ $pejabat->id_pejabat }}" name="foto_pejabat" accept="image/*">
                                    <div class="form-text">Foto saat ini: <a href="{{ asset('storage/' . $pejabat->foto_path) }}" target="_blank">Lihat</a></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning shadow-sm"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach


            {{-- 5. Tab Sejarah Kelurahan (Edit) --}}
            <div class="tab-pane fade" id="pills-sejarah" role="tabpanel" aria-labelledby="pills-sejarah-tab" tabindex="0">
                <div class="card shadow-lg p-4 mb-4">
                    <form action="{{ route('admin.profil.update', ['type' => 'sejarah']) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3 text-primary"><i class="bi bi-journal-text me-2"></i> Teks Sejarah Kelurahan</h5>
                        <div class="form-floating mb-4">
                            <textarea class="form-control @error('sejarah') is-invalid @enderror" name="sejarah" id="sejarahInput" style="height: 350px" required>{{ old('sejarah', $profileData->sejarah ?? '') }}</textarea>
                            <label for="sejarahInput">Isi Sejarah Lengkap</label>
                            @error('sejarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary shadow-sm"><i class="bi bi-save me-2"></i> Simpan Sejarah</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection