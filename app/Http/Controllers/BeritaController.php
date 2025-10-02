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
     * Menampilkan daftar semua berita dan pengumuman dengan pagination. (INDEX)
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data berita dengan pagination, urutkan dari yang terbaru
        $beritaList = Berita::latest('tanggal_publikasi')->paginate(10);

        // Daftar kategori (bisa diambil dari tabel kategori jika ada)
        $kategoriList = ['Kegiatan Warga', 'Rapat', 'Pengumuman', 'Lain-lain']; 

        return view('berita.index', compact('beritaList', 'kategoriList'));
    }

    /**
     * Menampilkan form untuk membuat berita baru. (CREATE)
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $kategoriList = ['Kegiatan Warga', 'Rapat', 'Pengumuman', 'Lain-lain']; 
        return view('berita.create', compact('kategoriList'));
    }

    /**
     * Menyimpan berita baru ke database. (STORE)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:50|in:Kegiatan Warga,Rapat,Pengumuman,Lain-lain', // Tambah in: untuk validasi kategori
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional, Max 2MB
            'tanggal_publikasi' => 'required|date|after_or_equal:today', // Cegah tanggal masa lalu
        ]);

        // 1. Upload Gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita/gambar', 'public');
        }

        // 2. Buat Slug unik
        $slug = Str::slug($request->judul);
        $originalSlug = $slug;
        $count = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // 3. Simpan data
        Berita::create([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'konten' => $validated['konten'],
            'gambar' => $gambarPath,
            'penulis' => Auth::check() ? Auth::user()->name : 'Admin', // Menggunakan nama admin yang login
            'kategori' => $validated['kategori'],
            'tanggal_publikasi' => $validated['tanggal_publikasi'],
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    /**
     * Menampilkan detail berita (biasanya untuk tampilan frontend). (SHOW)
     * Laravel secara otomatis menemukan Berita berdasarkan ID.
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\View\View
     */
    public function show(Berita $berita)
    {
        // Di admin, ini mungkin jarang dipakai, tapi disertakan untuk Route::resource
        return view('berita.show', compact('berita'));
    }

    /**
     * Menampilkan form edit berita yang sudah ada. (EDIT)
     * Laravel secara otomatis menemukan Berita berdasarkan ID.
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\View\View
     */
    public function edit(Berita $berita)
    {
        $kategoriList = ['Kegiatan Warga', 'Rapat', 'Pengumuman', 'Lain-lain']; 
        return view('berita.edit', compact('berita', 'kategoriList'));
    }

    /**
     * Menyimpan perubahan berita yang diedit. (UPDATE)
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string|max:50|in:Kegiatan Warga,Rapat,Pengumuman,Lain-lain',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_publikasi' => 'required|date|after_or_equal:today',
            // Pastikan slug yang baru tidak sama dengan slug lain (kecuali slug sendiri)
            'slug' => ['required', 'string', 'max:255', Rule::unique('berita', 'slug')->ignore($berita->id_berita, 'id_berita')],
        ]);

        $gambarPath = $berita->gambar;

        // 1. Handle Upload Gambar Baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('berita/gambar', 'public');
        }

        // 2. Buat Slug unik jika slug kosong atau sama dengan judul (fallback seperti store)
        $slug = $validated['slug'];
        if (empty($slug) || $slug === Str::slug($validated['judul'])) {
            $originalSlug = Str::slug($validated['judul']);
            $count = 1;
            $slug = $originalSlug;
            while (Berita::where('slug', $slug)->where('id_berita', '!=', $berita->id_berita)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        // 3. Update data (gunakan fill() + save() untuk efisiensi)
        $berita->fill([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'konten' => $validated['konten'],
            'gambar' => $gambarPath,
            'kategori' => $validated['kategori'],
            'tanggal_publikasi' => $validated['tanggal_publikasi'],
            // 'penulis' => Auth::check() ? Auth::user()->name : 'Admin', // Komentar: Jangan update penulis di edit, biarkan asli
        ]);
        $berita->save();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita dari database. (DESTROY)
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Berita $berita)
    {
        // Hapus gambar terkait dari storage
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
