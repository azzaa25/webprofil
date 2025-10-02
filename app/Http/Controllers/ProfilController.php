<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile; // Asumsi ada model untuk data profil
use App\Models\Lembaga; // Asumsi ada model untuk data lembaga
use Illuminate\Validation\ValidationException;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman kelola profil dengan tab navigasi.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // PERBAIKAN: Selalu cari/buat record dengan ID 1
        $profileData = Profile::firstOrCreate(['id_profil' => 1]);

        // Ambil daftar lembaga
        $lembagaList = Lembaga::all();
        
        return view('profil.index', compact('profileData', 'lembagaList'));
    }

    // ----------------------------------------------------------------------
    // Bagian 1: Update Visi & Misi dan Sejarah Kelurahan
    // ----------------------------------------------------------------------

    /**
     * Mengupdate data profil (visi_misi atau sejarah).
     * @param  \Illuminate\Http\Request  $request
     * @param  string $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $type)
    {
        // PERBAIKAN: Selalu cari/buat record dengan ID 1
        $profile = Profile::firstOrCreate(['id_profil' => 1]);

        try {
            if ($type === 'visi_misi') {
                $request->validate([
                    'visi' => 'required|string|max:500',
                    'misi' => 'required|string|max:2000',
                ]);
                
                $profile->visi = $request->visi;
                $profile->misi = $request->misi;
                $message = 'Visi & Misi berhasil diperbarui!';
                
            } elseif ($type === 'sejarah') {
                $request->validate([
                    'sejarah' => 'required|string',
                ]);

                $profile->sejarah = $request->sejarah;
                $message = 'Sejarah Kelurahan berhasil diperbarui!';

            } else {
                return back()->with('error', 'Tipe profil tidak valid.');
            }

            $profile->save();
            return back()->with('success', $message);

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    // ----------------------------------------------------------------------
    // Bagian 2: Struktur Organisasi (Upload Gambar)
    // ----------------------------------------------------------------------

    /**
     * Mengupload atau mengganti gambar Struktur Organisasi.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadStruktur(Request $request)
    {
        $request->validate([
            'struktur_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // 2MB Max
        ]);

        // PERBAIKAN: Selalu cari/buat record dengan ID 1
        $profile = Profile::firstOrCreate(['id_profil' => 1]);

        // Hapus gambar lama jika ada
        if ($profile->struktur_path && Storage::disk('public')->exists($profile->struktur_path)) {
            Storage::disk('public')->delete($profile->struktur_path);
        }

        // Simpan gambar baru
        $path = $request->file('struktur_image')->store('profil/struktur', 'public');
        $profile->struktur_path = $path;
        $profile->save();

        return back()->with('success', 'Gambar Struktur Organisasi berhasil diupload!');
    }

    /**
     * Menghapus gambar Struktur Organisasi.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteStruktur()
    {
        // PERBAIKAN: Selalu cari/buat record dengan ID 1
        $profile = Profile::firstOrCreate(['id_profil' => 1]);

        if ($profile->struktur_path && Storage::disk('public')->exists($profile->struktur_path)) {
            Storage::disk('public')->delete($profile->struktur_path);
            $profile->struktur_path = null;
            $profile->save();
            return back()->with('success', 'Gambar Struktur Organisasi berhasil dihapus.');
        }

        return back()->with('error', 'Tidak ada gambar Struktur Organisasi untuk dihapus.');
    }

    // ----------------------------------------------------------------------
    // Bagian 3: Lembaga (CRUD)
    // ----------------------------------------------------------------------

    /**
     * Menyimpan data Lembaga baru.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLembaga(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:500', // Diubah menjadi required agar sesuai form input di Blade
        ]);

        Lembaga::create($request->all());

        return back()->with('success', 'Lembaga berhasil ditambahkan!');
    }

    /**
     * Mengupdate data Lembaga.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lembaga  $lembaga
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLembaga(Request $request, Lembaga $lembaga)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:500', // Diubah menjadi required
        ]);

        $lembaga->update($request->all());

        return back()->with('success', 'Data Lembaga berhasil diperbarui!');
    }

    /**
     * Menghapus Lembaga.
     * @param  \App\Models\Lembaga  $lembaga
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyLembaga(Lembaga $lembaga)
    {
        $lembaga->delete();

        return back()->with('success', 'Lembaga berhasil dihapus.');
    }
}