<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PelayananController;
use Illuminate\Support\Facades\Auth;

// Halaman utama (welcome tetap ada)
Route::get('/', function () {return view('welcome');});
Route::get('/galeri', function () {return view('galeri');});
Route::get('/berita', function () {return view('berita');});
Route::get('/buku-tamu', function () {return view('buku_tamu');});
Route::get('/pelayanan', function () {return view('pelayanan');});
Route::get('/profil', function () {return view('profil');});

// Dashboard admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Resource route untuk kelola konten

Route::resource('admin-profil', ProfilController::class);
Route::resource('admin-berita', BeritaController::class);
Route::resource('admin-galeri', GaleriController::class);
Route::resource('admin-buku-tamu', BukuTamuController::class);
Route::resource('admin-faq', FaqController::class);

// 1. KELOLA PROFIL (Menyesuaikan dengan ProfilController sebelumnya)
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    
    // Rute PUT/UPDATE untuk Visi/Misi/Sejarah (menggunakan parameter {type})
    Route::put('/profil/update/{type}', [ProfilController::class, 'update'])->name('profil.update'); 
    
    // Rute untuk Struktur Organisasi
    Route::post('/profil/struktur/upload', [ProfilController::class, 'uploadStruktur'])->name('profil.upload_struktur');
    Route::delete('/profil/struktur/delete', [ProfilController::class, 'deleteStruktur'])->name('profil.delete_struktur');
    
    // Rute CRUD Lembaga (Hanya 3 fungsi yang digunakan di controller)
    Route::post('/lembaga', [ProfilController::class, 'storeLembaga'])->name('lembaga.store');
    Route::put('/lembaga/{lembaga}', [ProfilController::class, 'updateLembaga'])->name('lembaga.update');
    Route::delete('/lembaga/{lembaga}', [ProfilController::class, 'destroyLembaga'])->name('lembaga.destroy');
//2. KELOLA BERITA
Route::resource('berita', BeritaController::class)->parameters([
    'berita' => 'id_berita'
]);
// 3. KELOLA GALERI
    
Route::delete('/galeri/foto/{foto}', [GaleriController::class, 'destroyFoto'])
    ->name('galeri.destroy_foto'); 

// RESOURCE GALERI (Menggunakan binding id_galeri)
Route::resource('galeri', GaleriController::class)->parameters([
    'galeri' => 'id_galeri'
]); 
// 4. KELOLA BUKU TAMU
Route::resource('buku-tamu', BukuTamuController::class);
// 5. KELOLA FAQ
Route::resource('faq', FaqController::class);
// 6. KELOLA PELAYANAN
Route::resource('pelayanan', PelayananController::class);


// route logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/'); // kembali ke halaman welcome
})->name('logout');

