<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\FaqController;
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

// route logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/'); // kembali ke halaman welcome
})->name('logout');

