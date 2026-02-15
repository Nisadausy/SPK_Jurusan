<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\SpkController;

Route::get('/', fn () => redirect()->route('login'));

// Routes bawaan Breeze (login, register, logout, dll)
require __DIR__.'/auth.php';

/**
 * Siswa (Home)
 * Breeze login = guard web, jadi pakai middleware auth (bukan auth:siswa)
 */
Route::get('/landingpage', fn () => redirect()->route('siswa.tes.index'))
    ->middleware('auth')
    ->name('landingpage');

Route::get('/home', fn () => view('landingpage.home'))
    ->middleware('auth')
    ->name('home');

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
 * Flow Tes Siswa (SPK)
 */
Route::prefix('siswa')->name('siswa.')->middleware('auth')->group(function () {
    Route::get('/tes', [SpkController::class, 'index'])->name('tes.index');
    Route::post('/tes/simpan', [SpkController::class, 'store'])->name('tes.simpan');
    Route::get('/tes/hasil', [SpkController::class, 'hasil'])->name('tes.hasil');
});
