<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    /**
     * Menampilkan daftar semua FAQ. (INDEX)
     */
    public function index(Request $request)
    {
        $query = Faq::orderBy('urutan', 'asc')->orderBy('created_at', 'desc');
        
        // Fitur Cari/Search
        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%')
                  ->orWhere('jawaban', 'like', '%' . $request->search . '%');
        }

        $faqList = $query->paginate(10);

        return view('faq.index', compact('faqList'));
    }

    /**
     * Menampilkan form tambah FAQ baru. (CREATE)
     */
    public function create()
    {
        // Mendapatkan ID tertinggi + 1 untuk dijadikan saran urutan default
        $nextUrutan = Faq::max('urutan') + 1;
        return view('faq.create', compact('nextUrutan'));
    }

    /**
     * Menyimpan FAQ baru. (STORE)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jawaban' => 'required|string',
            'urutan' => 'required|integer|min:0',
        ]);
        
        Faq::create($validated);

        return redirect()->route('admin.faq.index')->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit. (EDIT)
     * Menggunakan ID eksplisit dari rute.
     */
    public function edit($id_faq)
    {
        $faq = Faq::findOrFail($id_faq);
        return view('faq.edit', compact('faq'));
    }

    /**
     * Menyimpan perubahan FAQ. (UPDATE)
     * Menggunakan ID eksplisit dari rute.
     */
    public function update(Request $request, $id_faq)
    {
        $faq = Faq::findOrFail($id_faq);

        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jawaban' => 'required|string',
            'urutan' => 'required|integer|min:0',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.faq.index')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    /**
     * Menghapus FAQ. (DESTROY)
     * Menggunakan ID eksplisit dari rute.
     */
    public function destroy($id_faq)
    {
        $faq = Faq::findOrFail($id_faq);
        $faq->delete();
        
        return redirect()->route('admin.faq.index')->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
