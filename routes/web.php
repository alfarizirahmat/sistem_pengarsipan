<?php

use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeamananController;
use App\Http\Controllers\KependudukanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratPengantarController;
use Illuminate\Support\Facades\Route;

// Autentikasi Pengurus RT
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Pengurus RT (Terproteksi)
Route::middleware('auth')->group(function () {
    // Dashboard Utama RT
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Modul Kependudukan & Laporan Desa (Menjawab No 5, 7, 10)
    Route::prefix('kependudukan')->group(function () {
        Route::get('/warga', [KependudukanController::class, 'index'])->name('warga.index');
        Route::get('/warga/kontrak', [KependudukanController::class, 'wargaKontrak'])->name('warga.kontrak');
        Route::get('/warga/create', [KependudukanController::class, 'create'])->name('warga.create');
        Route::post('/warga', [KependudukanController::class, 'store'])->name('warga.store');
        Route::get('/warga/{warga}/edit', [KependudukanController::class, 'edit'])->name('warga.edit');
        Route::put('/warga/{warga}', [KependudukanController::class, 'update'])->name('warga.update');
        Route::put('/warga/{warga}/mutasi', [KependudukanController::class, 'updateMutasi'])->name('warga.mutasi');
        Route::delete('/warga/{warga}', [KependudukanController::class, 'destroy'])->name('warga.destroy');

        Route::get('/keluarga', [KependudukanController::class, 'keluargaIndex'])->name('keluarga.index');
        Route::post('/keluarga', [KependudukanController::class, 'keluargaStore'])->name('keluarga.store');

        // Rekap Bulanan Perkembangan Penduduk ke Kantor Desa (Menjawab No 5 & 10)
        Route::get('/laporan-desa', [KependudukanController::class, 'laporanDesa'])->name('kependudukan.laporan-desa');
    });

    // Modul Pelayanan & Pengarsipan Surat Pengantar Keluar (Menjawab No 1, 6, 8, 9, 10, 11)
    Route::get('/arsip-surat', [ArsipSuratController::class, 'index'])->name('arsip.semua');
    Route::resource('surat-pengantar', SuratPengantarController::class)->except(['edit', 'update']);
    Route::get('surat-pengantar/{suratPengantar}/print', [SuratPengantarController::class, 'print'])->name('surat-pengantar.print');

    // Modul Buku Agenda Surat Masuk (Menjawab No 6 & 8)
    Route::resource('surat-masuk', SuratMasukController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::get('surat-masuk/{suratMasuk}/print', [SuratMasukController::class, 'print'])->name('surat-masuk.print');

    // Modul Keuangan: Iuran Warga (Humas) & Kas RT (Bendahara) (Menjawab No 2)
    Route::prefix('keuangan')->group(function () {
        // Iuran Warga (Posyandu, RW, Kematian, Sampah)
        Route::get('/iuran', [KeuanganController::class, 'iuranIndex'])->name('keuangan.iuran.index');
        Route::post('/iuran/generate', [KeuanganController::class, 'generateIuran'])->name('keuangan.iuran.generate');
        Route::post('/iuran/{iuran}/bayar', [KeuanganController::class, 'bayarIuran'])->name('keuangan.iuran.bayar');

        // Kas RT (Pemasukan, Pengeluaran, Saldo)
        Route::get('/kas', [KeuanganController::class, 'kasIndex'])->name('keuangan.kas.index');
        Route::post('/kas', [KeuanganController::class, 'kasStore'])->name('keuangan.kas.store');
        Route::delete('/kas/{kas}', [KeuanganController::class, 'kasDestroy'])->name('keuangan.kas.destroy');
    });

    // Modul Ronda & Keamanan Lingkungan (Seksi Keamanan) (Menjawab No 2 & 9)
    Route::prefix('keamanan')->group(function () {
        Route::get('/', [KeamananController::class, 'index'])->name('keamanan.index');
        Route::post('/', [KeamananController::class, 'store'])->name('keamanan.store');
        Route::put('/{laporanKeamanan}/status', [KeamananController::class, 'updateStatus'])->name('keamanan.status');
        Route::delete('/{laporanKeamanan}', [KeamananController::class, 'destroy'])->name('keamanan.destroy');
    });
});
