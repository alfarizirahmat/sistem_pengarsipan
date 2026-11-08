<?php

use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeamananController;
use App\Http\Controllers\KependudukanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PortalWargaController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratPengantarController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. PORTAL PUBLIK PELAYANAN & SURAT WARGA
// ==========================================
Route::get('/', [PortalWargaController::class, 'index'])->name('portal.warga');
Route::post('/ajukan-surat', [PortalWargaController::class, 'ajukanSurat'])->name('portal.ajukan');
Route::get('/surat-digital/{token}', [PortalWargaController::class, 'digitalSurat'])->name('portal.digital');

// ==========================================
// 2. AUTENTIKASI PENGURUS RT
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. MEJA KERJA ADMINISTRASI PENGURUS RT
// ==========================================
Route::middleware('auth')->group(function () {
    // Pusat Pelayanan & Register Pengurus RT
    Route::get('/pengurus', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Modul Kependudukan: Register Warga & KK (Sesuai LRS & ERD)
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

        Route::get('/laporan-desa', [KependudukanController::class, 'laporanDesa'])->name('kependudukan.laporan-desa');
    });

    // Modul Pelayanan & Pengarsipan Surat Pengantar Keluar
    Route::get('/arsip-surat', [ArsipSuratController::class, 'index'])->name('arsip.semua');
    Route::resource('surat-pengantar', SuratPengantarController::class)->except(['edit', 'update']);
    Route::post('surat-pengantar/{suratPengantar}/validasi', [SuratPengantarController::class, 'validasi'])->name('surat-pengantar.validasi');
    Route::get('surat-pengantar/{suratPengantar}/print', [SuratPengantarController::class, 'print'])->name('surat-pengantar.print');

    // Modul Buku Agenda Surat Masuk
    Route::resource('surat-masuk', SuratMasukController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::get('surat-masuk/{suratMasuk}/print', [SuratMasukController::class, 'print'])->name('surat-masuk.print');

    // Modul Keuangan: Iuran Warga & Buku Kas RT (Sesuai LRS & ERD)
    Route::prefix('keuangan')->group(function () {
        Route::get('/iuran', [KeuanganController::class, 'iuranIndex'])->name('keuangan.iuran.index');
        Route::post('/iuran/generate', [KeuanganController::class, 'generateIuran'])->name('keuangan.iuran.generate');
        Route::post('/iuran/{iuran}/bayar', [KeuanganController::class, 'bayarIuran'])->name('keuangan.iuran.bayar');

        Route::get('/kas', [KeuanganController::class, 'kasIndex'])->name('keuangan.kas.index');
        Route::post('/kas', [KeuanganController::class, 'kasStore'])->name('keuangan.kas.store');
        Route::delete('/kas/{kas}', [KeuanganController::class, 'kasDestroy'])->name('keuangan.kas.destroy');
    });

    // Modul Ronda & Keamanan Lingkungan (Sesuai LRS & ERD)
    Route::prefix('keamanan')->group(function () {
        Route::get('/', [KeamananController::class, 'index'])->name('keamanan.index');
        Route::post('/', [KeamananController::class, 'store'])->name('keamanan.store');
        Route::put('/{laporanKeamanan}/status', [KeamananController::class, 'updateStatus'])->name('keamanan.status');
        Route::delete('/{laporanKeamanan}', [KeamananController::class, 'destroy'])->name('keamanan.destroy');
    });
});
