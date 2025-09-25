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
Route::get('/', function () {
    return view('welcome'); // tetap tampil welcome.blade.php
});

// Dashboard admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Resource route untuk kelola konten
Route::resource('profil', ProfilController::class);
Route::resource('berita', BeritaController::class);
Route::resource('galeri', GaleriController::class);
Route::resource('buku-tamu', BukuTamuController::class);
Route::resource('faq', FaqController::class);

// route logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/'); // kembali ke halaman welcome
})->name('logout');

