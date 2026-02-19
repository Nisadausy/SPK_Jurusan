<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\SpkController;

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
    Route::get('/dashboard', fn () => view('bk.dashboard'))->name('dashboard');
});

/**
 * SPK Tes Siswa
 */
Route::prefix('siswa')->name('siswa.')->middleware('auth')->group(function () {
    Route::get('/tes', [SpkController::class, 'index'])->name('tes.index');
    Route::post('/tes/simpan', [SpkController::class, 'store'])->name('tes.simpan');
    Route::get('/tes/hasil', [SpkController::class, 'hasil'])->name('tes.hasil');
    Route::get('/tes/cetak', [SpkController::class, 'cetakPdf'])->name('tes.cetak'); // ✅ tambahan
    Route::get('/history', [SpkController::class, 'history'])->name('history');
    Route::get('/tes/{tes}/hasil', [SpkController::class, 'hasilByTes'])->name('tes.hasil.show');
    Route::get('/tes/{tes}/pdf',  [SpkController::class, 'cetakPdfByTes'])->name('tes.pdf.download');
});

