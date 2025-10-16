<?php

namespace App\Http\Controllers;

use App\Models\Pelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelayananController extends Controller
{
    /**
     * Menampilkan daftar semua pelayanan. (INDEX)
     */
    public function index(Request $request)
    {
        $query = Pelayanan::query();
        
        // Fitur Cari/Search
        if ($request->filled('search')) {
            $query->where('nama_pelayanan', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        $pelayananList = $query->latest()->paginate(10);

        return view('pelayanan.index', compact('pelayananList'));
    }

    /**
     * Menampilkan form tambah pelayanan baru. (CREATE)
     */
    public function create()
    {
        return view('pelayanan.create');
    }

    /**
     * Menyimpan pelayanan baru. (STORE)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelayanan' => 'required|string|max:255|unique:pelayanan,nama_pelayanan',
            'deskripsi' => 'required|string|max:500',
            // Persyaratan dan Proses dikirim sebagai string baru per baris
            'persyaratan' => 'nullable|string', 
            'proses' => 'nullable|string',
            'waktu_layanan' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);
        
        // Konversi string multi-baris menjadi array untuk disimpan sebagai JSON
        $persyaratanArray = $validated['persyaratan'] ? explode("\n", trim($validated['persyaratan'])) : null;
        $prosesArray = $validated['proses'] ? explode("\n", trim($validated['proses'])) : null;

        Pelayanan::create([
            'nama_pelayanan' => $validated['nama_pelayanan'],
            'deskripsi' => $validated['deskripsi'],
            'persyaratan' => $persyaratanArray,
            'proses' => $prosesArray,
            'waktu_layanan' => $validated['waktu_layanan'],
            'keterangan' => $validated['keterangan'],
            'dibuat_oleh' => Auth::check() ? Auth::user()->name : 'Admin',
            'tanggal_publikasi' => now(),
        ]);

        return redirect()->route('admin.pelayanan.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail pelayanan (via modal di index, atau halaman terpisah). (SHOW)
     */
    public function show(Pelayanan $pelayanan)
    {
        // Dalam konteks CMS, metode ini mungkin digunakan untuk API atau view detail terpisah.
        // Untuk admin, kita akan menggunakan modal di index view.
        return response()->json($pelayanan); 
    }

    /**
     * Menampilkan form edit. (EDIT)
     */
    public function edit(Pelayanan $pelayanan)
    {
        // Konversi array kembali ke string multi-baris untuk display di textarea
        $pelayanan->persyaratan = $pelayanan->persyaratan ? implode("\n", $pelayanan->persyaratan) : '';
        $pelayanan->proses = $pelayanan->proses ? implode("\n", $pelayanan->proses) : '';
        
        return view('pelayanan.edit', compact('pelayanan'));
    }

    /**
     * Menyimpan perubahan pelayanan. (UPDATE)
     */
    public function update(Request $request, Pelayanan $pelayanan)
    {
        $validated = $request->validate([
            'nama_pelayanan' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama unik kecuali untuk dirinya sendiri
                Rule::unique('pelayanan', 'nama_pelayanan')->ignore($pelayanan->id_pelayanan, 'id_pelayanan')
            ],
            'deskripsi' => 'required|string|max:500',
            'persyaratan' => 'nullable|string', 
            'proses' => 'nullable|string',
            'waktu_layanan' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        // Konversi string multi-baris menjadi array untuk disimpan sebagai JSON
        $persyaratanArray = $validated['persyaratan'] ? explode("\n", trim($validated['persyaratan'])) : null;
        $prosesArray = $validated['proses'] ? explode("\n", trim($validated['proses'])) : null;

        $pelayanan->update([
            'nama_pelayanan' => $validated['nama_pelayanan'],
            'deskripsi' => $validated['deskripsi'],
            'persyaratan' => $persyaratanArray,
            'proses' => $prosesArray,
            'waktu_layanan' => $validated['waktu_layanan'],
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('admin.pelayanan.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Menghapus pelayanan. (DESTROY)
     */
    public function destroy(Pelayanan $pelayanan)
    {
        $pelayanan->delete();
        return redirect()->route('admin.pelayanan.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
