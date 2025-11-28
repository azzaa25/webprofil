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
use Carbon\Carbon;
use Exception;
use App\Models\Pejabat;
use App\Models\Lembaga;


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
            ->take(3)
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
        $profileData = Profile::firstOrCreate(['id_profil' => 1]);

        return view('detail_pelayanan', compact('pelayanan', 'lainnya', 'profileData'));
    }


    // Halaman profil
    public function profil()
    {
        $profil = Profile::first(); // ambil 1 data (misal hanya ada 1 baris profil)
        $lembaga = Lembaga::orderBy('nama', 'asc')->get();
        $pejabatList = Pejabat::all();
        return view('profil', compact('profil', 'lembaga', 'pejabatList'));
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

            // Ambil data dari Realtime Database
            $rawData = $this->rtdb->getAll('penduduks');
            $dataWarga = is_array($rawData) ? array_values($rawData) : [];

            //------------------------------------------------------
            // 1. Hitung jumlah berdasarkan jenis kelamin
            //------------------------------------------------------
            $jumlahLaki = 0;
            $jumlahPerempuan = 0;
            $jumlahAnomali = 0;

            foreach ($dataWarga as $warga) {

                $jk = strtolower($warga['jenisKelamin'] ?? $warga['jeniskelamin'] ?? '');

                if (in_array($jk, ['laki-laki', 'l', 'male'])) {
                    $jumlahLaki++;
                } elseif (in_array($jk, ['perempuan', 'p', 'female'])) {
                    $jumlahPerempuan++;
                } else {
                    $jumlahAnomali++;
                }
            }

            $totalPenduduk = $jumlahLaki + $jumlahPerempuan + $jumlahAnomali;

            //------------------------------------------------------
            // 2. Hitung kelompok usia berdasarkan tanggal lahir
            //------------------------------------------------------
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

            foreach ($dataWarga as &$w) {

                $tgl = $w['tanggalLahir'] ?? null;

                if ($tgl) {
                    try {
                        $usia = Carbon::parse($tgl)->age;
                    } catch (Exception $e) {
                        $usia = 0;
                    }
                } else {
                    $usia = 0;
                }

                // Simpan usia agar bisa ditampilkan di blade jika perlu
                $w['usia'] = $usia;

                // Kelompokkan usia
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

            //------------------------------------------------------
            // 3. Distribusi Pendidikan
            //------------------------------------------------------
            $pendidikan = [];
            foreach ($dataWarga as $w) {
                $p = ucfirst(strtolower($w['pendidikan'] ?? 'Tidak diketahui'));
                $pendidikan[$p] = ($pendidikan[$p] ?? 0) + 1;
            }

            //------------------------------------------------------
            // 4. Distribusi Pekerjaan
            //------------------------------------------------------
            $pekerjaan = [];
            foreach ($dataWarga as $w) {
                $p = ucfirst(strtolower($w['pekerjaan'] ?? 'Tidak diketahui'));
                $pekerjaan[$p] = ($pekerjaan[$p] ?? 0) + 1;
            }

            //------------------------------------------------------
            // 4. Distribusi Agamo
            //------------------------------------------------------
            $agama = [];
            foreach ($dataWarga as $w) {
                $a = ucfirst(strtolower($w['agama'] ?? 'Tidak diketahui'));
                $agama[$a] = ($agama[$a] ?? 0) + 1;
            }

            //------------------------------------------------------
            // RETURN KE VIEW
            //------------------------------------------------------
            return view('kependudukan', [
                'jumlahLaki' => $jumlahLaki,
                'jumlahPerempuan' => $jumlahPerempuan,
                'jumlahAnomali' => $jumlahAnomali,
                'totalPenduduk' => $totalPenduduk,
                'kelompokUsia' => $kelompokUsia,
                'pendidikan' => $pendidikan,
                'pekerjaan' => $pekerjaan,
                'agama' => $agama,
                'dataWarga' => $dataWarga
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
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