<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeamanan;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KeamananController extends Controller
{
    /**
     * Buku Mutasi Ronda & Laporan Keamanan Lingkungan
     * Menjawab No 2: seksi keamanan contohnya ronda, menjaga kondusifitas lingkungan
     */
    public function index(): View
    {
        $laporans = LaporanKeamanan::latest('tanggal')->paginate(15);
        $wargas = Warga::aktif()->where('jenis_kelamin', 'L')->orderBy('nama_lengkap')->get();

        return view('keamanan.index', compact('laporans', 'wargas'));
    }

    /**
     * Catat Laporan Keamanan / Ronda Baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'kategori' => ['required', 'string'],
            'judul' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'petugas_ronda' => ['nullable', 'string'],
            'keterangan' => ['required', 'string'],
            'status' => ['required', 'in:kondusif,proses,selesai,perlu_tindakan'],
            'tindakan' => ['nullable', 'string'],
        ]);

        $validated['pelapor'] = Auth::check() ? Auth::user()->name : 'Seksi Keamanan';

        LaporanKeamanan::create($validated);

        return back()->with('success', 'Catatan kegiatan keamanan / siskamling berhasil disimpan.');
    }

    /**
     * Update status laporan keamanan
     */
    public function updateStatus(Request $request, LaporanKeamanan $laporanKeamanan): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:kondusif,proses,selesai,perlu_tindakan'],
            'tindakan' => ['nullable', 'string'],
        ]);

        $laporanKeamanan->update($validated);

        return back()->with('success', 'Status laporan keamanan telah diperbarui.');
    }

    /**
     * Hapus laporan
     */
    public function destroy(LaporanKeamanan $laporanKeamanan): RedirectResponse
    {
        $laporanKeamanan->delete();

        return back()->with('success', 'Laporan keamanan telah dihapus.');
    }
}
