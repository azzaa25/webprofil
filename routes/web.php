<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\PublikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\FirestoreController;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseAccessToken;

Route::get('/test-token', function () {
    return FirebaseAccessToken::get();
});


/*
|--------------------------------------------------------------------------
| ROUTE HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [PublikController::class, 'index'])->name('publik.home');
Route::get('/galeri', [PublikController::class, 'galeri'])->name('publik.galeri');
Route::get('/galeri/{album}', [PublikController::class, 'galeriDetail'])->name('publik.galeri_detail');
Route::get('/berita', [PublikController::class, 'berita'])->name('publik.berita');
Route::get('/berita/{slug}', [PublikController::class, 'beritaDetail'])->name('publik.berita_detail');
Route::get('/buku-tamu', [PublikController::class, 'bukuTamu'])->name('publik.buku_tamu');
Route::post('/buku-tamu', [BukuTamuController::class, 'store'])->name('bukutamu.store');
Route::get('/pelayanan', [PublikController::class, 'pelayanan'])->name('publik.pelayanan');
Route::get('/pelayanan/{id}', [PublikController::class, 'detailPelayanan'])->name('publik.detail_pelayanan');
Route::get('/profil', [PublikController::class, 'profil'])->name('publik.profil');
Route::get('/faq', [PublikController::class, 'faq'])->name('publik.faq');
Route::get('/kependudukan', [PublikController::class, 'kependudukan'])->name('publik.kependudukan');
Route::get('/demografi', [PublikController::class, 'demografi'])->name('publik.demografi');
// Route::get('/penduduks', [PublikController::class, 'kependudukan']);

/*
|--------------------------------------------------------------------------
| ROUTE LOGIN ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Halaman Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

});

/*
|--------------------------------------------------------------------------
| ROUTE HALAMAN ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/user', [AdminUserController::class, 'index'])->name('admin.user.index');
    Route::post('/user', [AdminUserController::class, 'store'])->name('admin.user.store');
    Route::put('/user/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
    Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // PROFIL
    Route::get('/profil', [ProfilController::class, 'index'])->name('admin.profil.index');
    Route::put('/profil/update/{type}', [ProfilController::class, 'update'])->name('admin.profil.update');
    Route::post('/profil/struktur/upload', [ProfilController::class, 'uploadStruktur'])->name('admin.profil.upload_struktur');
    Route::delete('/profil/struktur/delete', [ProfilController::class, 'deleteStruktur'])->name('admin.profil.delete_struktur');
    Route::post('/lembaga', [ProfilController::class, 'storeLembaga'])->name('admin.lembaga.store');
    Route::put('/lembaga/{lembaga}', [ProfilController::class, 'updateLembaga'])->name('admin.lembaga.update');
    Route::delete('/lembaga/{lembaga}', [ProfilController::class, 'destroyLembaga'])->name('admin.lembaga.destroy');

    // BERITA
    Route::resource('/berita', BeritaController::class)->parameters([
        'berita' => 'id_berita'
    ])->names('admin.berita');

    // GALERI
    Route::delete('/galeri/foto/{foto}', [GaleriController::class, 'destroyFoto'])->name('admin.galeri.destroy_foto');
    Route::resource('/galeri', GaleriController::class)->parameters([
        'galeri' => 'id_galeri'
    ])->names('admin.galeri');

    // BUKU TAMU
    Route::get('/buku-tamu', [BukuTamuController::class, 'indexAdmin'])->name('admin.buku-tamu.index');
    Route::delete('/buku-tamu/{id_bukutamu}', [BukuTamuController::class, 'destroy'])->name('admin.buku-tamu.destroy');

    // FAQ
    Route::resource('/faq', FaqController::class)->names('admin.faq');

    // PELAYANAN
    Route::resource('/pelayanan', PelayananController::class)->names('admin.pelayanan');
});

/*
|--------------------------------------------------------------------------
| ROUTE LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // kembali ke halaman publik
})->name('logout');
