<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratMasukController extends Controller
{
    /**
     * Buku Agenda Arsip Surat Masuk
     * Menjawab No 6: Pencatatan surat masuk di sekretaris RT
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $tahun = $request->query('tahun');

        $query = SuratMasuk::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('nomor_surat_pengirim', 'like', "%{$search}%")
                    ->orWhere('pengirim', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($tahun) {
            $query->where('tahun_arsip', $tahun);
        }

        $suratMasuks = $query->latest('tanggal_terima')->paginate(15)->withQueryString();

        $daftarTahun = SuratMasuk::select('tahun_arsip')
            ->distinct()
            ->orderByDesc('tahun_arsip')
            ->pluck('tahun_arsip');

        return view('surat_masuk.index', compact('suratMasuks', 'daftarTahun', 'search', 'tahun'));
    }

    /**
     * Form Catat Surat Masuk
     */
    public function create(): View
    {
        $currentYear = Carbon::now()->year;
        $count = SuratMasuk::whereYear('tanggal_terima', $currentYear)->count() + 1;
        $autoNomorAgenda = sprintf('SM-%d-%03d', $currentYear, $count);

        return view('surat_masuk.create', compact('autoNomorAgenda'));
    }

    /**
     * Simpan Surat Masuk
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_agenda' => ['required', 'string', 'unique:surat_masuks,nomor_agenda'],
            'nomor_surat_pengirim' => ['required', 'string'],
            'pengirim' => ['required', 'string'],
            'perihal' => ['required', 'string'],
            'ringkasan_isi' => ['nullable', 'string'],
            'tanggal_surat' => ['required', 'date'],
            'tanggal_terima' => ['required', 'date'],
            'lokasi_arsip_fisik' => ['nullable', 'string'],
            'disposisi' => ['nullable', 'string'],
            'file_lampiran' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('file_lampiran')) {
            $path = $request->file('file_lampiran')->store('surat_masuk', 'public');
            $validated['file_lampiran'] = $path;
        }

        $tglTerima = Carbon::parse($validated['tanggal_terima']);
        $validated['tahun_arsip'] = $tglTerima->year;

        SuratMasuk::create($validated);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dicatat dalam buku agenda arsip.');
    }

    /**
     * Tampilan Detail & Berkas Surat Masuk
     */
    public function show(SuratMasuk $suratMasuk): View
    {
        return view('surat_masuk.show', compact('suratMasuk'));
    }

    /**
     * Cetak Lembar Disposisi Surat Masuk
     */
    public function print(SuratMasuk $suratMasuk): View
    {
        return view('surat_masuk.print', compact('suratMasuk'));
    }

    /**
     * Hapus arsip surat masuk
     */
    public function destroy(SuratMasuk $suratMasuk): RedirectResponse
    {
        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')->with('success', 'Arsip surat masuk berhasil dihapus.');
    }
}
