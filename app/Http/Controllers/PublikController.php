<?php
// sendy
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublikController extends Controller
{
    // Halaman utama
    public function index()
    {
        return view('welcome');
    }

    // Halaman galeri
    public function galeri()
    {
        return view('galeri');
    }

    // Halaman berita
    public function berita()
    {
        return view('berita');
    }

    // Halaman buku tamu
    public function bukuTamu()
    {
        return view('buku_tamu');
    }

    // Halaman pelayanan
    public function pelayanan()
    {
        return view('pelayanan');
    }

    // Halaman profil
    public function profil()
    {
        return view('profil');
    }
}
