<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\SpkController;
use App\Http\Controllers\Siswa\ProfileController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


Route::get('/reset-admin', function () {
    DB::table('users')
        ->where('email', 'admin@spksaw.local')
        ->update([
            'password_hash' => Hash::make('admin123')
        ]);

    return 'Password admin berhasil direset';
});

// ── Tambahan import untuk Guru BK ──
use App\Http\Controllers\Bk\DashboardController;
use App\Http\Controllers\Bk\SiswaController     as BkSiswaController;
use App\Http\Controllers\Bk\StatistikController;
use App\Http\Controllers\Bk\ArtikelController   as BkArtikelController;
use App\Http\Controllers\Bk\InfoJurusanController;
use App\Http\Controllers\Bk\ProfilController    as BkProfilController;
use App\Http\Controllers\Bk\PasswordController  as BkPasswordController;

// Landing (public)
Route::get('/', fn () => view('landingpage.home'))->name('landing.home');

// Breeze routes (login/register/logout/forgot/etc)
require __DIR__ . '/auth.php';

/**
 * Optional: kalau ada yang akses /landingpage, langsung ke landing utama
 */
Route::get('/landingpage', fn () => redirect()->route('landing.home'))->name('landingpage');

/**
 * Admin
 */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    
    Route::get('/guru-bk', fn () => 'index guru bk')->name('gurubk.index');
    Route::get('/siswa', fn () => 'index siswa')->name('siswa.index');
    Route::get('/status', fn () => 'status index')->name('status.index');
    Route::get('/jurusan', fn () => 'jurusan index')->name('jurusan.index');
    Route::get('/artikel', fn () => 'artikel index')->name('artikel.index');
    Route::get('/informasi-jurusan', fn () => 'info jurusan index')->name('infojurusan.index');
    Route::get('/monitoring', fn () => 'monitoring index')->name('monitoring.index');
});

/**
 * Guru BK
 */
Route::prefix('bk')->name('bk.')->middleware('auth')->group(function () {

    // FR-BK-02: Ubah password — tidak kena force redirect
    Route::get ('/password',        [BkPasswordController::class, 'index']) ->name('password.index');
    Route::put ('/password/update', [BkPasswordController::class, 'update'])->name('password.update');

    // Semua route lain kena middleware ForcePasswordChange
    Route::middleware('force.password.change')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // FR-BK-05: Data siswa (read-only)
        Route::get('/siswa',      [BkSiswaController::class, 'index'])->name('siswa.index');
        Route::get('/siswa/{id}', [BkSiswaController::class, 'show']) ->name('siswa.show');

        // FR-BK-06: Statistik
        Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

        // FR-BK-07: Artikel CRUD
        Route::get   ('/artikel',           [BkArtikelController::class, 'index'])  ->name('artikel.index');
        Route::get   ('/artikel/create',    [BkArtikelController::class, 'create']) ->name('artikel.create');
        Route::post  ('/artikel',           [BkArtikelController::class, 'store'])  ->name('artikel.store');
        Route::get   ('/artikel/{id}/edit', [BkArtikelController::class, 'edit'])   ->name('artikel.edit');
        Route::put   ('/artikel/{id}',      [BkArtikelController::class, 'update']) ->name('artikel.update');
        Route::delete('/artikel/{id}',      [BkArtikelController::class, 'destroy'])->name('artikel.destroy');

        // FR-BK-08/09: Info Jurusan
        Route::get('/infojurusan',           [InfoJurusanController::class, 'index']) ->name('infojurusan.index');
        Route::get('/infojurusan/{id}/edit', [InfoJurusanController::class, 'edit'])  ->name('infojurusan.edit');
        Route::put('/infojurusan/{id}',      [InfoJurusanController::class, 'update'])->name('infojurusan.update');

        // FR-BK-04: Profil
        Route::get('/profil', [BkProfilController::class, 'index'])->name('profil');
    });
});

/**
 * SPK Tes Siswa
 */
Route::prefix('siswa')->name('siswa.')->middleware('auth')->group(function () {
    Route::get('/tes', [SpkController::class, 'index'])->name('tes.index');
    Route::post('/tes/simpan', [SpkController::class, 'store'])->name('tes.simpan');
    Route::get('/tes/hasil', [SpkController::class, 'hasil'])->name('tes.hasil');
    Route::get('/tes/cetak', [SpkController::class, 'cetakPdf'])->name('tes.cetak');
    Route::get('/history', [SpkController::class, 'history'])->name('history');
    Route::get('/tes/{tes}/hasil', [SpkController::class, 'hasilByTes'])->name('tes.hasil.show');
    Route::get('/tes/{tes}/pdf',  [SpkController::class, 'cetakPdfByTes'])->name('tes.pdf.download');

    // =========================
    // PROFILE SISWA
    // =========================
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::put('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');
});