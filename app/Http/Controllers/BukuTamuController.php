<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu; // Pastikan model ini diimpor
use Illuminate\Validation\Rule; // Diperlukan jika ada aturan unik/complex lainnya

class BukuTamuController extends Controller
{
    /**
     * 🔹 Halaman Form Buku Tamu (Frontend)
     * Menampilkan form bagi pengunjung untuk mengisi buku tamu.
     */
    public function index()
    {
        // View ini kemungkinan adalah form frontend (misalnya: resources/views/buku-tamu/index.blade.php)
        return view('buku-tamu.index');
    }

    /**
     * 🔹 Simpan Data Buku Tamu (STORE)
     * Menerima input dari form dan menyimpan ke database.
     */
    public function store(Request $request)
    {
        // 1. Definisikan Pesan Validasi Kustom
        $messages = [
            'required'       => '⚠️ Kolom **:attribute** wajib diisi. Tidak boleh kosong.',
            'string'         => 'Kolom **:attribute** harus berupa teks.',
            'max'            => 'Kolom **:attribute** terlalu panjang. Maksimal :max karakter.',
            // Pesan spesifik
            'nama_lengkap.required' => 'Nama lengkap Anda wajib diisi. Mohon periksa kembali.',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi untuk pencatatan.',
            'keperluan.required' => 'Keperluan kunjungan wajib diisi.',
        ];

        // 2. Lakukan Validasi dengan Pesan Kustom
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'keperluan' => 'required|string|max:255',
        ], $messages);

        BukuTamu::create([
            'nama_lengkap'   => $validated['nama_lengkap'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'keperluan'      => $validated['keperluan'],
            'tanggal'        => now()->format('Y-m-d'),
        ]);

        // 3. Pesan Sukses untuk Pop-up
        return redirect()
            ->back()
            ->with('success', 'Terima kasih! ✅ Data buku tamu Anda telah berhasil dicatat.');
    }

    /**
     * 🔹 Halaman Kelola Buku Tamu (ADMIN INDEX)
     * Menampilkan semua data buku tamu di dashboard admin.
     * Menggunakan nama indexAdmin agar kompatibel dengan rute admin.buku-tamu.index
     */
    public function indexAdmin(Request $request)
    {
        $query = BukuTamu::query();

        // 🔸 Filter berdasarkan keperluan
        if ($request->filled('keperluan')) {
            $query->where('keperluan', 'like', '%' . $request->keperluan . '%');
        }

        // 🔸 Filter berdasarkan rentang tanggal
        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        // 🔸 Urutkan data berdasarkan tanggal
        if ($request->sort == 'desc') {
            $query->orderBy('tanggal', 'desc');
        } else {
            $query->orderBy('tanggal', 'asc');
        }

        // 🔸 Pencarian opsional
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                ->orWhere('alamat_lengkap', 'like', '%' . $request->search . '%')
                ->orWhere('keperluan', 'like', '%' . $request->search . '%');
            });
        }

        // 🔸 Pagination + tetap bawa query filter
        $bukutamu = $query->paginate(10)->appends($request->query());

        // 🔸 Arahkan ke view admin
        // Catatan: Pastikan Anda memiliki view di 'buku-tamu.admin-index' atau 'buku-tamu.index' yang benar
        return view('buku-tamu.index', compact('bukutamu')); 
    }


    /**
     * 🔹 Hapus Data Buku Tamu (DESTROY)
     * Menghapus data buku tamu berdasarkan ID.
     */
    public function destroy($id_bukutamu)
    {
        $bukuTamu = BukuTamu::findOrFail($id_bukutamu);
        $bukuTamu->delete();

        return redirect()
            ->route('admin.buku-tamu.index')
            ->with('success', 'Data buku tamu berhasil dihapus.');
    }
}
