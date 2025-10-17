<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuTamu;
use App\Models\GaleriAlbum;
use App\Models\Berita;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total pengunjung (buku tamu) bulan ini
        $totalPengunjung = BukuTamu::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        // Hitung total berita aktif (pastikan tabel berita punya kolom 'status' = 'aktif')
        $beritaAktif = 0;
        if (class_exists(Berita::class)) {
            $beritaAktif = Berita::count(); // hitung semua berita
        }

        // Hitung total galeri dari galeri_album
        $totalGaleri = GaleriAlbum::count();

        // Statistik pengunjung per bulan
        $statistik = BukuTamu::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Buat data bulanan lengkap dari Januari–Desember
        $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataStatistik = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataStatistik[] = $statistik[$i] ?? 0;
        }

        return view('admin.dashboard', [
            'totalPengunjung' => $totalPengunjung,
            'beritaAktif' => $beritaAktif,
            'totalGaleri' => $totalGaleri,
            'bulanNama' => $bulanNama,
            'dataStatistik' => $dataStatistik,
        ]);
    }
}
