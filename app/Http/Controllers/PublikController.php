<?php
// sendy
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Profile;
use App\Models\Pelayanan;
use App\Models\GaleriAlbum;
use App\Models\GaleriFoto;
use App\Models\Faq;


class PublikController extends Controller
{
    // Halaman utama
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('welcome', compact('berita'));
    }

    // Halaman Galeri
    public function galeri()
    {
        // Ambil semua album galeri
        $albums = GaleriAlbum::withCount('fotos')->orderBy('tanggal', 'desc')->get();

        // Ambil gambar slider dari berita
        $sliderImages = Berita::whereNotNull('gambar')
            ->latest('tanggal_publikasi')
            ->take(5)
            ->pluck('gambar');

        return view('galeri', compact('albums', 'sliderImages'));
    }

    // Halaman Detail Album
    public function galeriDetail(GaleriAlbum $album)
    {
        // Ambil semua foto berdasarkan album yang dipilih
        $fotos = $album->fotos()->get();

        // Ambil beberapa album lain untuk rekomendasi
        $albumLain = GaleriAlbum::where('id_galeri', '!=', $album->id_galeri)
            ->latest('tanggal')
            ->take(3)
            ->get();

        return view('detail_galeri', compact('album', 'fotos', 'albumLain'));
    }

    // Halaman daftar berita
    public function berita()
    {
        $beritaList = Berita::orderBy('tanggal_publikasi', 'desc')->get();
        return view('berita', compact('beritaList'));
    }

    // Halaman detail berita
    public function beritaDetail($slug)
    {
        // Ambil berita berdasarkan slug
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Ambil berita lain untuk rekomendasi
        $beritaLain = Berita::where('slug', '!=', $slug)
            ->latest('tanggal_publikasi')
            ->take(3)
            ->get();

        return view('detail_berita', compact('berita', 'beritaLain'));
    }

    // Halaman buku tamu
    public function bukuTamu()
    {
        return view('buku_tamu');
    }

    // Halaman daftar pelayanan
    public function pelayanan()
    {
        $data = Pelayanan::orderBy('tanggal_publikasi', 'desc')->get();
        return view('pelayanan', compact('data'));
    }

    // Halaman detail pelayanan
    public function detailPelayanan($id)
    {
        $pelayanan = Pelayanan::findOrFail($id);
        $lainnya = Pelayanan::where('id_pelayanan', '!=', $id)
            ->orderBy('tanggal_publikasi', 'desc')
            ->take(3)
            ->get();

        return view('detail_pelayanan', compact('pelayanan', 'lainnya'));
    }


    // Halaman profil
    public function profil()
    {
        $profil = Profile::first(); // ambil 1 data (misal hanya ada 1 baris profil)
        return view('profil', compact('profil'));
    }
    public function faq()
    {
        // Ambil semua data FAQ, diurutkan berdasarkan kolom 'urutan'
        $faqList = Faq::orderBy('urutan', 'asc')->get();

        // Kirim ke view
        return view('faq', compact('faqList'));
    }
}
