<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArsipSuratController extends Controller
{
    /**
     * Buku Arsip Semua Surat (Gabungan Surat Pengantar Keluar & Surat Masuk)
     * Memungkinkan pengurus melihat isi dari semua surat secara langsung di satu tempat
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $tahun = $request->query('tahun');
        $kategori = $request->query('kategori', 'semua'); // 'semua', 'pengantar', 'masuk'

        // 1. Query Surat Pengantar
        $queryPengantar = SuratPengantar::with('warga.keluarga');
        if ($search) {
            $queryPengantar->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('warga', function ($w) use ($search) {
                        $w->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }
        if ($tahun) {
            $queryPengantar->where('tahun_arsip', $tahun);
        }
        $suratPengantars = $queryPengantar->latest('tanggal_surat')->get();

        // 2. Query Surat Masuk
        $queryMasuk = SuratMasuk::query();
        if ($search) {
            $queryMasuk->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('nomor_surat_pengirim', 'like', "%{$search}%")
                    ->orWhere('pengirim', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%");
            });
        }
        if ($tahun) {
            $queryMasuk->where('tahun_arsip', $tahun);
        }
        $suratMasuks = $queryMasuk->latest('tanggal_terima')->get();

        // Format data menjadi satu koleksi gabungan yang seragam
        $allLetters = collect();

        if (in_array($kategori, ['semua', 'pengantar'])) {
            foreach ($suratPengantars as $sp) {
                $allLetters->push([
                    'id' => $sp->id,
                    'kategori' => 'pengantar',
                    'label_kategori' => 'Surat Pengantar (Keluar)',
                    'badge_color' => 'emerald',
                    'nomor' => $sp->nomor_surat,
                    'tanggal' => $sp->tanggal_surat,
                    'tanggal_formatted' => $sp->tanggal_surat->format('d/m/Y'),
                    'tahun_arsip' => $sp->tahun_arsip,
                    'pihak' => $sp->warga->nama_lengkap ?? 'Warga',
                    'sub_pihak' => 'NIK: '.($sp->warga->nik ?? '-'),
                    'perihal' => $sp->label_jenis_surat,
                    'ringkasan' => $sp->keperluan,
                    'dokumen_hilang' => $sp->dokumen_hilang,
                    'lokasi_arsip_fisik' => $sp->lokasi_arsip_fisik ?? 'Map Arsip RT',
                    'tanda_tangan_jenis' => $sp->tanda_tangan_jenis,
                    'tanda_tangan_url' => $sp->tanda_tangan_url,
                    'qr_token' => $sp->qr_token,
                    'penandatangan_nama' => $sp->penandatangan_nama,
                    'penandatangan_jabatan' => $sp->penandatangan_jabatan,
                    'warga' => $sp->warga,
                    'file_lampiran' => null,
                    'print_url' => route('surat-pengantar.print', $sp),
                    'detail_url' => route('surat-pengantar.show', $sp),
                ]);
            }
        }

        if (in_array($kategori, ['semua', 'masuk'])) {
            foreach ($suratMasuks as $sm) {
                $allLetters->push([
                    'id' => $sm->id,
                    'kategori' => 'masuk',
                    'label_kategori' => 'Surat Masuk (Desa/RW)',
                    'badge_color' => 'blue',
                    'nomor' => $sm->nomor_agenda,
                    'nomor_asli' => $sm->nomor_surat_pengirim,
                    'tanggal' => $sm->tanggal_terima,
                    'tanggal_formatted' => $sm->tanggal_terima->format('d/m/Y'),
                    'tahun_arsip' => $sm->tahun_arsip,
                    'pihak' => $sm->pengirim,
                    'sub_pihak' => 'No: '.$sm->nomor_surat_pengirim,
                    'perihal' => $sm->perihal,
                    'ringkasan' => $sm->ringkasan_isi ?: $sm->perihal,
                    'disposisi' => $sm->disposisi,
                    'lokasi_arsip_fisik' => $sm->lokasi_arsip_fisik ?? 'Ordner Surat Masuk',
                    'file_lampiran' => $sm->file_lampiran,
                    'print_url' => route('surat-masuk.print', $sm),
                    'detail_url' => route('surat-masuk.show', $sm),
                ]);
            }
        }

        // Urutkan berdasarkan tanggal terbaru
        $sortedLetters = $allLetters->sortByDesc('tanggal')->values();

        // Daftar tahun arsip gabungan (10 tahun ke belakang)
        $tahunPengantar = SuratPengantar::distinct()->pluck('tahun_arsip');
        $tahunMasuk = SuratMasuk::distinct()->pluck('tahun_arsip');
        $daftarTahun = $tahunPengantar->concat($tahunMasuk)->unique()->sortDesc()->values();

        // Statistik Cepat
        $stats = [
            'total_semua' => SuratPengantar::count() + SuratMasuk::count(),
            'total_pengantar' => SuratPengantar::count(),
            'total_masuk' => SuratMasuk::count(),
            'total_scan' => SuratMasuk::whereNotNull('file_lampiran')->count(),
        ];

        return view('arsip.semua', compact('sortedLetters', 'daftarTahun', 'search', 'tahun', 'kategori', 'stats'));
    }
}
