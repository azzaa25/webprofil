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
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Storage;
use App\Services\FirestoreService;
use Kreait\Firebase\Factory;
use App\Services\RealtimeDatabaseService;


use Exception;
use App\Models\Pejabat; // <-- TAMBAHKAN INI


class PublikController extends Controller
{
    // Halaman utama
    public function index()
    {
        $berita = Berita::latest()->get();
        // TAMBAHKAN: Ambil daftar pejabat untuk ditampilkan di Beranda
        $pejabatList = Pejabat::all(); 
        
        return view('welcome', compact('berita', 'pejabatList')); // <-- KIRIMKAN DATA PEJABAT
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

    // Halaman kependudukan
    protected $firestore;
    protected $rtdb;
    protected $collection = 'users';

    public function __construct(FirestoreService $firestore, RealtimeDatabaseService $rtdb)
    {
        $this->firestore = $firestore;
        $this->rtdb = $rtdb;
    }

    public function kependudukan()
    {
        try {
            // Ambil semua dokumen dari Firestore (tanpa variabel collection)
            $rawData = $this->firestore->getAll('users'); // langsung nama koleksi

            $documents = $rawData['documents'] ?? [];

            $dataWarga = [];

            // 🔹 Konversi struktur Firestore ke array biasa
            foreach ($documents as $doc) {
                $fields = $doc['fields'] ?? [];
                $item = [];

                foreach ($fields as $key => $value) {
                    $item[$key] = $value['stringValue']
                        ?? $value['integerValue']
                        ?? $value['doubleValue']
                        ?? $value['booleanValue']
                        ?? null;
                }

                $dataWarga[] = $item;
            }

            // 🔹 Hitung jumlah berdasarkan jenis kelamin
            $jumlahLaki = 0;
            $jumlahPerempuan = 0;
            $jumlahAnomali = 0;

            foreach ($dataWarga as $warga) {
                $jk = strtolower($warga['jenisKelamin'] ?? '');

                if (in_array($jk, ['laki-laki', 'l', 'male'])) {
                    $jumlahLaki++;
                } elseif (in_array($jk, ['perempuan', 'p', 'female'])) {
                    $jumlahPerempuan++;
                } elseif (in_array($jk, ['', 'anomali'])) {
                    $jumlahAnomali++;
                }
            }

            $totalPenduduk = $jumlahLaki + $jumlahPerempuan + $jumlahAnomali;

            // 🔹 Hitung distribusi usia (kelompok umur)
            $kelompokUsia = [
                '0-12 bulan' => 0,
                '1-5 tahun' => 0,
                '6-12 tahun' => 0,
                '13-17 tahun' => 0,
                '18-30 tahun' => 0,
                '31-45 tahun' => 0,
                '46-60 tahun' => 0,
                '60+ tahun' => 0,
            ];

            foreach ($dataWarga as $w) {
                $usia = (int) ($w['usia'] ?? 0);

                if ($usia <= 1)
                    $kelompokUsia['0-12 bulan']++;
                elseif ($usia <= 5)
                    $kelompokUsia['1-5 tahun']++;
                elseif ($usia <= 12)
                    $kelompokUsia['6-12 tahun']++;
                elseif ($usia <= 17)
                    $kelompokUsia['13-17 tahun']++;
                elseif ($usia <= 30)
                    $kelompokUsia['18-30 tahun']++;
                elseif ($usia <= 45)
                    $kelompokUsia['31-45 tahun']++;
                elseif ($usia <= 60)
                    $kelompokUsia['46-60 tahun']++;
                else
                    $kelompokUsia['60+ tahun']++;
            }

            // 🔹 Hitung distribusi pendidikan
            $pendidikan = [];
            foreach ($dataWarga as $w) {
                $p = ucfirst(strtolower($w['pendidikan'] ?? 'Tidak diketahui'));
                $pendidikan[$p] = ($pendidikan[$p] ?? 0) + 1;
            }

            // 🔹 Hitung distribusi pekerjaan
            $pekerjaan = [];
            foreach ($dataWarga as $w) {
                $p = ucfirst(strtolower($w['pekerjaan'] ?? 'Tidak diketahui'));
                $pekerjaan[$p] = ($pekerjaan[$p] ?? 0) + 1;
            }

            // 🔹 Kirim semua data ke view
            return view('kependudukan', [
                'jumlahLaki' => $jumlahLaki,
                'jumlahPerempuan' => $jumlahPerempuan,
                'jumlahAnomali' => $jumlahAnomali,
                'totalPenduduk' => $totalPenduduk,
                'kelompokUsia' => $kelompokUsia,
                'pendidikan' => $pendidikan,
                'pekerjaan' => $pekerjaan,
                'dataWarga' => $dataWarga
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // HALAMAN DEMOGRAFI
    public function demografi()
    {
        $raw = $this->rtdb->getAll('bangunans'); // bisa mengembalikan [] atau array keyed/object

        // Jika getAll sudah mengembalikan array_values(...), tetap aman — namun pastikan tiap item adalah array
        $bangunans = array_values(array_filter($raw, function ($item) {
            return is_array($item) && count($item) > 0;
        }));

        // Optional: jika kamu ingin hanya mengambil field-field tertentu dan memastikan key ada
        $bangunans = array_map(function ($item) {
            return [
                'nama_bangunan' => $item['nama_bangunan'] ?? null,
                'kategori' => $item['kategori'] ?? null,
                'deskripsi' => $item['deskripsi'] ?? null,
                'rt_id' => $item['rt_id'] ?? null,
                'rw_id' => $item['rw_id'] ?? null,
                'latitude' => $item['latitude'] ?? null,
                'longitude' => $item['longitude'] ?? null,
            ];
        }, $bangunans);

        return view('demografi', compact('bangunans'));
    }


}