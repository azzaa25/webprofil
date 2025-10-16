<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu;

class BukuTamuController extends Controller
{
    /**
     * 🔹 Halaman Form Buku Tamu (Frontend)
     * Menampilkan form bagi pengunjung untuk mengisi buku tamu.
     */
    public function index()
    {
        return view('buku-tamu.index');
    }

    /**
     * 🔹 Simpan Data Buku Tamu (STORE)
     * Menerima input dari form dan menyimpan ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'keperluan' => 'required|string|max:255',
        ]);

        BukuTamu::create([
            'nama_lengkap'   => $validated['nama_lengkap'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'keperluan'      => $validated['keperluan'],
            'tanggal'        => now()->format('Y-m-d'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Terima kasih! Data buku tamu Anda telah dikirim.');
    }

    /**
     * 🔹 Halaman Kelola Buku Tamu (ADMIN INDEX)
     * Menampilkan semua data buku tamu di dashboard admin.
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
