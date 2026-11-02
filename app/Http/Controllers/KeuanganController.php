<?php

namespace App\Http\Controllers;

use App\Models\IuranWarga;
use App\Models\KasRt;
use App\Models\Keluarga;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KeuanganController extends Controller
{
    /**
     * Halaman Pengelolaan Iuran Warga (Seksi Humas)
     * Menjawab No 2: penarikan iuran bulanan (posyandu, rw, kematian)
     */
    public function iuranIndex(Request $request): View
    {
        $bulan = (int) $request->query('bulan', Carbon::now()->month);
        $tahun = (int) $request->query('tahun', Carbon::now()->year);
        $status = $request->query('status');

        $query = IuranWarga::with('keluarga')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun);

        if ($status && in_array($status, ['lunas', 'belum_lunas'])) {
            $query->where('status', $status);
        }

        $iurans = $query->paginate(20)->withQueryString();

        $totalLunas = IuranWarga::where('bulan', $bulan)->where('tahun', $tahun)->where('status', 'lunas')->sum('total_iuran');
        $totalBelumLunas = IuranWarga::where('bulan', $bulan)->where('tahun', $tahun)->where('status', 'belum_lunas')->sum('total_iuran');
        $countLunas = IuranWarga::where('bulan', $bulan)->where('tahun', $tahun)->where('status', 'lunas')->count();
        $countBelumLunas = IuranWarga::where('bulan', $bulan)->where('tahun', $tahun)->where('status', 'belum_lunas')->count();

        $daftarKeluarga = Keluarga::orderBy('kepala_keluarga')->get();

        return view('keuangan.iuran.index', compact(
            'iurans',
            'bulan',
            'tahun',
            'status',
            'totalLunas',
            'totalBelumLunas',
            'countLunas',
            'countBelumLunas',
            'daftarKeluarga'
        ));
    }

    /**
     * Generate Tagihan Iuran Bulanan untuk seluruh KK
     */
    public function generateIuran(Request $request): RedirectResponse
    {
        $bulan = (int) $request->input('bulan', Carbon::now()->month);
        $tahun = (int) $request->input('tahun', Carbon::now()->year);

        $keluargas = Keluarga::all();
        $generatedCount = 0;

        foreach ($keluargas as $kk) {
            $exists = IuranWarga::where('keluarga_id', $kk->id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();

            if (! $exists) {
                IuranWarga::create([
                    'keluarga_id' => $kk->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nominal_posyandu' => 5000,
                    'nominal_rw' => 10000,
                    'nominal_kematian' => 10000,
                    'nominal_sampah' => 15000,
                    'total_iuran' => 40000,
                    'status' => 'belum_lunas',
                ]);
                $generatedCount++;
            }
        }

        return back()->with('success', "Berhasil men-generate {$generatedCount} tagihan iuran KK untuk periode bulan {$bulan}/{$tahun}.");
    }

    /**
     * Tandai Iuran Lunas / Bayar
     */
    public function bayarIuran(Request $request, IuranWarga $iuran): RedirectResponse
    {
        $validated = $request->validate([
            'metode_pembayaran' => ['required', 'in:tunai,transfer'],
            'catatan' => ['nullable', 'string'],
        ]);

        $petugas = Auth::check() ? Auth::user()->name : 'Seksi Humas RT';

        $iuran->update([
            'status' => 'lunas',
            'tanggal_bayar' => Carbon::now(),
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'petugas_penarik' => $petugas,
            'catatan' => $validated['catatan'] ?? 'Lunas diserahkan ke Humas',
        ]);

        return back()->with('success', 'Pembayaran iuran KK '.$iuran->keluarga->kepala_keluarga.' berhasil diverifikasi lunas.');
    }

    /**
     * Buku Kas Umum RT (Seksi Bendahara)
     * Menjawab No 2: bendahara keuangan rt, kas rt dll
     */
    public function kasIndex(Request $request): View
    {
        $bulan = $request->query('bulan');
        $tahun = (int) $request->query('tahun', Carbon::now()->year);
        $jenis = $request->query('jenis');

        $query = KasRt::query();

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        if ($jenis && in_array($jenis, ['pemasukan', 'pengeluaran'])) {
            $query->where('jenis', $jenis);
        }

        $transaksis = $query->latest('tanggal')->paginate(20)->withQueryString();

        $totalMasuk = KasRt::whereYear('tanggal', $tahun)
            ->when($bulan, fn ($q) => $q->whereMonth('tanggal', $bulan))
            ->pemasukan()
            ->sum('nominal');

        $totalKeluar = KasRt::whereYear('tanggal', $tahun)
            ->when($bulan, fn ($q) => $q->whereMonth('tanggal', $bulan))
            ->pengeluaran()
            ->sum('nominal');

        $saldoKas = $totalMasuk - $totalKeluar;

        // Saldo Kas Keseluruhan
        $saldoTotalAllTime = KasRt::pemasukan()->sum('nominal') - KasRt::pengeluaran()->sum('nominal');

        return view('keuangan.kas.index', compact(
            'transaksis',
            'bulan',
            'tahun',
            'jenis',
            'totalMasuk',
            'totalKeluar',
            'saldoKas',
            'saldoTotalAllTime'
        ));
    }

    /**
     * Catat Transaksi Kas RT Baru
     */
    public function kasStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis' => ['required', 'in:pemasukan,pengeluaran'],
            'kategori' => ['required', 'string'],
            'nominal' => ['required', 'numeric', 'min:1000'],
            'keterangan' => ['required', 'string'],
            'nomor_bukti' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['dicatat_oleh'] = Auth::check() ? Auth::user()->name : 'Bendahara RT';

        KasRt::create($validated);

        return back()->with('success', 'Transaksi kas RT berhasil dicatat.');
    }

    /**
     * Hapus Transaksi Kas
     */
    public function kasDestroy(KasRt $kas): RedirectResponse
    {
        $kas->delete();

        return back()->with('success', 'Transaksi kas telah dihapus.');
    }
}
