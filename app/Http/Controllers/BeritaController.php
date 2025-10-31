<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BeritaController extends Controller
{
    /**
     * Daftar kategori default.
     */
    private $kategoriList = ['Kegiatan Warga', 'Rapat', 'Pengumuman', 'Lain-lain'];

    /**
     * Menampilkan daftar semua berita & pengumuman dengan pagination (INDEX).
     * Bisa difilter berdasarkan kategori.
     */
    public function index(Request $request)
    {
        $query = Berita::latest('tanggal_publikasi');

        // Filter kategori jika dipilih
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $beritaList = $query->paginate(10);

        return view('berita.index', [
            'beritaList'   => $beritaList,
            'kategoriList' => $this->kategoriList,
        ]);
    }

    /**
     * Menampilkan form untuk membuat berita baru (CREATE).
     */
    public function create()
    {
        return view('berita.create', [
            'kategoriList' => $this->kategoriList,
        ]);
    }

    /**
     * Menyimpan berita baru ke database (STORE).
     */
    public function store(Request $request)
    {
        // 1. Definisikan Pesan Kustom (Menggantikan pesan default)
        $messages = [
            'required'            => '⚠️ Kolom **:attribute** wajib diisi. Mohon periksa kembali.',
            'string'              => 'Kolom **:attribute** harus berupa teks.',
            'max'                 => 'Kolom **:attribute** tidak boleh lebih dari :max karakter.',
            'in'                  => 'Pilihan **:attribute** tidak valid.',
            'image'               => 'File **Gambar** harus berupa gambar (jpeg, png, jpg).',
            'mimes'               => 'Format **Gambar** yang diperbolehkan hanyalah JPEG, PNG, atau JPG.',
            'max'                 => 'Ukuran file **Gambar** tidak boleh melebihi 2MB.',
            'date'                => 'Kolom **Tanggal Publikasi** harus berupa tanggal yang valid.',
            'after_or_equal'      => 'Tanggal publikasi tidak boleh di masa lalu. Harus hari ini atau setelahnya.',
            
            // Pesan spesifik untuk attribute tertentu
            'judul.required'      => 'Judul berita wajib diisi.',
            'konten.required'     => 'Konten berita wajib diisi. Tidak boleh kosong.',
            'kategori.required'   => 'Kategori berita wajib dipilih.',
        ];

        // 2. Lakukan Validasi dengan Pesan Kustom
        $validated = $request->validate([
            'judul'               => 'required|string|max:255',
            'konten'              => 'required|string',
            'kategori'            => 'required|string|max:50|in:' . implode(',', $this->kategoriList),
            'gambar'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_publikasi'   => 'required|date|after_or_equal:today',
        ], $messages); // <-- PESAN KUSTOM DITERAPKAN DI SINI

        // Upload gambar jika ada
        $gambarPath = $request->hasFile('gambar')
            ? $request->file('gambar')->store('berita/gambar', 'public')
            : null;

        // Slug unik
        $slug = $this->generateUniqueSlug($validated['judul']);

        // Simpan data
        Berita::create([
            'judul'               => $validated['judul'],
            'slug'                => $slug,
            'konten'              => $validated['konten'],
            'gambar'              => $gambarPath,
            'penulis'             => Auth::check() ? Auth::user()->name : 'Admin',
            'kategori'            => $validated['kategori'],
            'tanggal_publikasi'   => $validated['tanggal_publikasi'],
        ]);

        return redirect()->route('admin.berita.index')->with('success', '✅ Berita berhasil dipublikasikan!');
    }

    /**
     * Menampilkan detail berita (SHOW).
     */
    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    /**
     * Menampilkan form edit berita (EDIT).
     */
    public function edit($id_berita)
    {
        $berita = Berita::findOrFail($id_berita);

        return view('berita.edit', [
            'berita'       => $berita,
            'kategoriList' => $this->kategoriList,
        ]);
    }

    /**
     * Menyimpan perubahan berita yang diedit (UPDATE).
     */
    public function update(Request $request, $id_berita)
    {
        $berita = Berita::findOrFail($id_berita);

        // 1. Definisikan Pesan Kustom
        $messages = [
            'required'            => '⚠️ Kolom **:attribute** wajib diisi. Mohon periksa kembali.',
            'string'              => 'Kolom **:attribute** harus berupa teks.',
            'max'                 => 'Kolom **:attribute** tidak boleh lebih dari :max karakter.',
            'in'                  => 'Pilihan **:attribute** tidak valid.',
            'image'               => 'File **Gambar** harus berupa gambar (jpeg, png, jpg).',
            'mimes'               => 'Format **Gambar** yang diperbolehkan hanyalah JPEG, PNG, atau JPG.',
            'max'                 => 'Ukuran file **Gambar** tidak boleh melebihi 2MB.',
            'date'                => 'Kolom **Tanggal Publikasi** harus berupa tanggal yang valid.',
            'after_or_equal'      => 'Tanggal publikasi tidak boleh di masa lalu. Harus hari ini atau setelahnya.',
            
            // Pesan spesifik untuk attribute tertentu
            'judul.required'      => 'Judul berita wajib diisi.',
            'konten.required'     => 'Konten berita wajib diisi. Tidak boleh kosong.',
            'kategori.required'   => 'Kategori berita wajib dipilih.',
            'slug.unique'         => 'Slug sudah digunakan oleh berita lain. Coba ganti Judul atau Slug.',
        ];

        // 2. Lakukan Validasi dengan Pesan Kustom
        $validated = $request->validate([
            'judul'               => 'required|string|max:255',
            'konten'              => 'required|string',
            'kategori'            => 'required|string|max:50|in:' . implode(',', $this->kategoriList),
            'gambar'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_publikasi'   => 'required|date|after_or_equal:today',
            'slug'                => [
                'required',
                'string',
                'max:255',
                Rule::unique('berita', 'slug')->ignore($id_berita, 'id_berita')
            ],
        ], $messages); // <-- PESAN KUSTOM DITERAPKAN DI SINI

        // Upload gambar baru jika ada
        $gambarPath = $berita->gambar;
        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $gambarPath = $request->file('gambar')->store('berita/gambar', 'public');
        }

        // Slug unik
        $slug = $this->generateUniqueSlug($validated['judul'], $id_berita, $validated['slug']);

        // Update data
        $berita->update([
            'judul'               => $validated['judul'],
            'slug'                => $slug,
            'konten'              => $validated['konten'],
            'gambar'              => $gambarPath,
            'kategori'            => $validated['kategori'],
            'tanggal_publikasi'   => $validated['tanggal_publikasi'],
        ]);

        return redirect()->route('admin.berita.index')->with('success', '✅ Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita dari database (DESTROY).
     */
    public function destroy($id_berita)
    {
        $berita = Berita::findOrFail($id_berita);

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Generate slug unik berdasarkan judul.
     */
    private function generateUniqueSlug(string $judul, $ignoreId = null, $slugInput = null): string
    {
        $slug = $slugInput ?: Str::slug($judul);
        $originalSlug = $slug;
        $count = 1;

        $query = Berita::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id_berita', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count++;
            $query = Berita::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id_berita', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}
