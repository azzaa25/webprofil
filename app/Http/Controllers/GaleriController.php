<?php

namespace App\Http\Controllers;

use App\Models\GaleriAlbum;
use App\Models\GaleriFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Diimpor jika dibutuhkan

class GaleriController extends Controller
{
    /**
     * Menampilkan daftar semua album. (INDEX)
     */
    public function index()
    {
        // Ambil semua album dengan jumlah foto di dalamnya
        $albums = GaleriAlbum::withCount('fotos')->latest('tanggal')->paginate(10);
        return view('galeri.index', compact('albums'));
    }

    /**
     * Menampilkan form tambah album baru. (CREATE)
     */
    public function create()
    {
        return view('galeri.create');
    }

    /**
     * Menyimpan album baru dan foto-fotonya. (STORE)
     */
    public function store(Request $request)
    {
        // 1. Definisikan Pesan Validasi Kustom
        $messages = [
            'required' => '⚠️ Kolom **:attribute** wajib diisi. Mohon periksa kembali.',
            'string' => 'Kolom **:attribute** harus berupa teks.',
            'date' => 'Kolom **:attribute** harus berupa tanggal yang valid.',
            'image' => 'File **:attribute** harus berupa gambar.',
            'mimes' => 'Format file **:attribute** tidak valid. Hanya: JPEG, PNG, JPG.',
            
            // Pesan Spesifik
            'nama_album.required' => 'Nama Album wajib diisi.',
            'cover_file.required' => 'Gambar Cover Album wajib diunggah.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'cover_file.max' => 'Ukuran file Cover tidak boleh melebihi 2MB.',
            'foto_album.*.image' => 'Setiap file di bagian **Foto Detail** harus berupa gambar.',
            'foto_album.*.mimes' => 'Hanya format JPEG, PNG, atau JPG yang diizinkan untuk foto detail.',
            'foto_album.*.max' => 'Ukuran setiap foto detail tidak boleh melebihi 2MB.',
        ];

        // 2. Lakukan Validasi dengan Pesan Kustom
        $request->validate([
            'nama_album' => 'required|string|max:255',
            'cover_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_album' => 'nullable|array',
            'foto_album.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
        ], $messages);

        // 1. Upload Cover Album
        $coverPath = $request->file('cover_file')->store('galeri/covers', 'public');

        // 2. Buat Album
        $album = GaleriAlbum::create([
            'nama_album' => $request->nama_album,
            'cover_path' => $coverPath,
            'tanggal' => $request->tanggal,
        ]);

        // 3. Upload Foto Detail Album
        if ($request->hasFile('foto_album')) {
            foreach ($request->file('foto_album') as $file) {
                $fotoPath = $file->store('galeri/album_photos', 'public');
                GaleriFoto::create([
                    'album_id' => $album->id_galeri,
                    'foto_path' => $fotoPath,
                ]);
            }
        }

        return redirect()->route('admin.galeri.index')->with('success', '✅ Album baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit album. (EDIT)
     * Menggunakan ID eksplisit dari rute untuk menghindari Route Model Binding yang bermasalah.
     */
    public function edit($id_galeri)
    {
        // Temukan album berdasarkan ID yang dilewatkan
        $galeri = GaleriAlbum::findOrFail($id_galeri);
        
        // Ambil foto detail yang sudah ada
        $fotos = $galeri->fotos;
        
        return view('galeri.edit', compact('galeri', 'fotos'));
    }

    /**
     * Menyimpan perubahan album. (UPDATE)
     * Menggunakan ID eksplisit dari rute untuk menghindari Route Model Binding yang bermasalah.
     */
    public function update(Request $request, $id_galeri)
    {
        // Temukan album berdasarkan ID yang dilewatkan
        $galeri = GaleriAlbum::findOrFail($id_galeri);

        // 1. Definisikan Pesan Validasi Kustom
        $messages = [
            'required' => '⚠️ Kolom **:attribute** wajib diisi. Mohon periksa kembali.',
            'string' => 'Kolom **:attribute** harus berupa teks.',
            'date' => 'Kolom **:attribute** harus berupa tanggal yang valid.',
            'image' => 'File **:attribute** harus berupa gambar.',
            'mimes' => 'Format file **:attribute** tidak valid. Hanya: JPEG, PNG, JPG.',
            
            // Pesan Spesifik
            'nama_album.required' => 'Nama Album wajib diisi.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'cover_file.max' => 'Ukuran file Cover tidak boleh melebihi 2MB.',
            'new_foto_album.*.image' => 'Setiap file baru di bagian **Foto Detail** harus berupa gambar.',
            'new_foto_album.*.mimes' => 'Hanya format JPEG, PNG, atau JPG yang diizinkan untuk foto detail baru.',
            'new_foto_album.*.max' => 'Ukuran setiap foto detail baru tidak boleh melebihi 2MB.',
        ];

        // 2. Lakukan Validasi dengan Pesan Kustom
        $request->validate([
            'nama_album' => 'required|string|max:255',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            // Untuk tambah foto baru saat edit
            'new_foto_album' => 'nullable|array',
            'new_foto_album.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], $messages);

        // 1. Update Cover (jika ada file baru)
        if ($request->hasFile('cover_file')) {
            // Hapus cover lama
            if ($galeri->cover_path && Storage::disk('public')->exists($galeri->cover_path)) {
                Storage::disk('public')->delete($galeri->cover_path);
            }
            $coverPath = $request->file('cover_file')->store('galeri/covers', 'public');
        } else {
            $coverPath = $galeri->cover_path;
        }

        // 2. Update data Album
        $galeri->update([
            'nama_album' => $request->nama_album,
            'cover_path' => $coverPath,
            'tanggal' => $request->tanggal,
        ]);

        // 3. Tambah Foto Detail Album Baru
        if ($request->hasFile('new_foto_album')) {
            foreach ($request->file('new_foto_album') as $file) {
                $fotoPath = $file->store('galeri/album_photos', 'public');
                GaleriFoto::create([
                    'album_id' => $galeri->id_galeri,
                    'foto_path' => $fotoPath,
                ]);
            }
        }
        
        return redirect()->route('admin.galeri.index')->with('success', '✅ Album berhasil diperbarui!');
    }
    
    /**
     * Menghapus foto detail dari album (Aksi terpisah saat di form edit).
     */
    public function destroyFoto(GaleriFoto $foto)
    {
        // Hapus file fisik
        if ($foto->foto_path && Storage::disk('public')->exists($foto->foto_path)) {
            Storage::disk('public')->delete($foto->foto_path);
        }
        // Hapus record dari database
        $foto->delete();

        return back()->with('success', 'Foto detail berhasil dihapus.');
    }


    /**
     * Menghapus seluruh album. (DESTROY)
     * Menggunakan ID eksplisit dari rute untuk menghindari Route Model Binding yang bermasalah.
     */
    public function destroy($id_galeri)
    {
        // Temukan album berdasarkan ID yang dilewatkan
        $galeri = GaleriAlbum::findOrFail($id_galeri);

        // Hapus Cover
        if ($galeri->cover_path && Storage::disk('public')->exists($galeri->cover_path)) {
            Storage::disk('public')->delete($galeri->cover_path);
        }

        // Hapus semua foto detail yang terkait
        foreach ($galeri->fotos as $foto) {
            if ($foto->foto_path && Storage::disk('public')->exists($foto->foto_path)) {
                Storage::disk('public')->delete($foto->foto_path);
            }
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', '✅ Album berhasil dihapus!');
    }
}
