<?php

namespace App\Http\Controllers;

use App\Models\IuranWarga;
use App\Models\KasRt;
use App\Models\Keluarga;
use App\Models\LaporanKeamanan;
use App\Models\SuratMasuk;
use App\Models\SuratPengantar;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Metrik Kependudukan
        $totalKk = Keluarga::count();
        $totalKkKontrak = Keluarga::kontrak()->count();
        $totalWargaAktif = Warga::aktif()->count();
        $totalWargaLaki = Warga::aktif()->where('jenis_kelamin', 'L')->count();
        $totalWargaPerempuan = Warga::aktif()->where('jenis_kelamin', 'P')->count();
        $totalWargaKontrak = Warga::aktif()->kontrak()->count();

        // Mutasi Penduduk (Menjawab Pertanyaan RT No 5 & 10)
        $wargaPindahBulanIni = Warga::pindah()
            ->whereMonth('tgl_mutasi', $currentMonth)
            ->whereYear('tgl_mutasi', $currentYear)
            ->count();

        $wargaMeninggalBulanIni = Warga::meninggal()
            ->whereMonth('tgl_mutasi', $currentMonth)
            ->whereYear('tgl_mutasi', $currentYear)
            ->count();

        $wargaLahirBulanIni = Warga::aktif()
            ->whereMonth('tanggal_lahir', $currentMonth)
            ->whereYear('tanggal_lahir', $currentYear)
            ->count();

        $wargaDatangBulanIni = Warga::aktif()
            ->whereNotNull('tgl_mutasi')
            ->whereMonth('tgl_mutasi', $currentMonth)
            ->whereYear('tgl_mutasi', $currentYear)
            ->where('status_hubungan_keluarga', '!=', 'Anak')
            ->count();

        // Metrik Surat & Arsip
        $totalSuratPengantar = SuratPengantar::count();
        $suratPengantarBulanIni = SuratPengantar::whereMonth('tanggal_surat', $currentMonth)
            ->whereYear('tanggal_surat', $currentYear)
            ->count();
        $totalSuratMasuk = SuratMasuk::count();

        // Metrik Keuangan Kas RT
        $totalKasMasuk = KasRt::pemasukan()->sum('nominal');
        $totalKasKeluar = KasRt::pengeluaran()->sum('nominal');
        $saldoKas = $totalKasMasuk - $totalKasKeluar;

        // Metrik Iuran Bulanan Humas
        $iuranLunasBulanIni = IuranWarga::where('bulan', $currentMonth)
            ->where('tahun', $currentYear)
            ->where('status', 'lunas')
            ->sum('total_iuran');

        $iuranBelumLunasCount = IuranWarga::where('bulan', $currentMonth)
            ->where('tahun', $currentYear)
            ->where('status', 'belum_lunas')
            ->count();

        // Surat Pengantar Terbaru
        $recentSurats = SuratPengantar::with('warga')->latest()->take(5)->get();

        // Catatan Keamanan Terbaru
        $recentKeamanan = LaporanKeamanan::latest()->take(4)->get();

        return view('dashboard.index', compact(
            'totalKk',
            'totalKkKontrak',
            'totalWargaAktif',
            'totalWargaLaki',
            'totalWargaPerempuan',
            'totalWargaKontrak',
            'wargaPindahBulanIni',
            'wargaMeninggalBulanIni',
            'wargaLahirBulanIni',
            'wargaDatangBulanIni',
            'totalSuratPengantar',
            'suratPengantarBulanIni',
            'totalSuratMasuk',
            'totalKasMasuk',
            'totalKasKeluar',
            'saldoKas',
            'iuranLunasBulanIni',
            'iuranBelumLunasCount',
            'recentSurats',
            'recentKeamanan'
        ));
    }
}
