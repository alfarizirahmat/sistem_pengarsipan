<?php

namespace App\Http\Controllers;

use App\Models\SuratPengantar;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SuratPengantarController extends Controller
{
    /**
     * Buku Arsip Surat Pengantar Keluar
     * Menjawab Pertanyaan No 8 & 11: Pencarian cepat arsip 10 tahun ke belakang
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $tahun = $request->query('tahun');
        $jenis = $request->query('jenis');

        $query = SuratPengantar::with('warga.keluarga');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('warga', function ($w) use ($search) {
                        $w->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        if ($tahun) {
            $query->where('tahun_arsip', $tahun);
        }

        if ($jenis) {
            $query->where('jenis_surat', $jenis);
        }

        $surats = $query->latest('tanggal_surat')->paginate(15)->withQueryString();

        // Daftar tahun yang tersedia untuk filter arsip 10 tahun
        $daftarTahun = SuratPengantar::select('tahun_arsip')
            ->distinct()
            ->orderByDesc('tahun_arsip')
            ->pluck('tahun_arsip');

        return view('surat_pengantar.index', compact('surats', 'daftarTahun', 'search', 'tahun', 'jenis'));
    }

    /**
     * Form Buat Surat Pengantar
     */
    public function create(Request $request): View
    {
        $selectedWargaId = $request->query('warga_id');
        $wargas = Warga::aktif()->with('keluarga')->orderBy('nama_lengkap')->get();

        // Hitung nomor urut otomatis bulan ini
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $countThisMonth = SuratPengantar::whereMonth('tanggal_surat', $currentMonth)
            ->whereYear('tanggal_surat', $currentYear)
            ->count() + 1;

        $autoNomorSurat = sprintf('470/%03d/RT.03-RW.02/%s/%d', $countThisMonth, $bulanRomawi[$currentMonth] ?? 'XI', $currentYear);

        return view('surat_pengantar.create', compact('wargas', 'selectedWargaId', 'autoNomorSurat'));
    }

    /**
     * Simpan Surat Pengantar & Arsipkan
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => ['required', 'string', 'unique:surat_pengantars,nomor_surat'],
            'warga_id' => ['required', 'exists:wargas,id'],
            'jenis_surat' => ['required', 'string'],
            'keperluan' => ['required', 'string'],
            'dokumen_hilang' => ['nullable', 'string', 'max:255'],
            'tanggal_surat' => ['required', 'date'],
            'berlaku_sampai' => ['nullable', 'date'],
            'penandatangan_nama' => ['required', 'string'],
            'penandatangan_jabatan' => ['required', 'string'],
            'tanda_tangan_jenis' => ['nullable', 'in:manual,digital,qrcode,foto,pdf,upload'],
            'tanda_tangan_digital' => ['nullable', 'string'],
            'tanda_tangan_file' => ['nullable', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:5120'],
            'lokasi_arsip_fisik' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
        ]);

        $tanggal = Carbon::parse($validated['tanggal_surat']);
        $validated['tahun_arsip'] = $tanggal->year;
        $validated['status'] = 'selesai';
        $validated['tanda_tangan_jenis'] = $validated['tanda_tangan_jenis'] ?? 'foto';

        // Jika ada unggahan berkas foto / PDF tanda tangan
        if ($request->hasFile('tanda_tangan_file')) {
            $file = $request->file('tanda_tangan_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $path = $file->store('signatures', 'public');
            $validated['tanda_tangan_digital'] = 'storage/'.$path;
            $validated['tanda_tangan_jenis'] = ($ext === 'pdf') ? 'pdf' : 'foto';
        } elseif (! empty($request->input('tanda_tangan_digital'))) {
            // Jika memilih foto tersimpan atau goresan kanvas
            $validated['tanda_tangan_digital'] = $request->input('tanda_tangan_digital');
            if ($validated['tanda_tangan_jenis'] === 'digital') {
                $validated['tanda_tangan_jenis'] = 'foto';
            }
        } elseif ($validated['tanda_tangan_jenis'] === 'manual') {
            $validated['tanda_tangan_digital'] = null;
        }

        if (in_array($validated['tanda_tangan_jenis'], ['digital', 'qrcode', 'foto', 'pdf', 'upload'])) {
            $validated['qr_token'] = 'RT03-'.strtoupper(Str::random(8));
        }

        $surat = SuratPengantar::create($validated);

        return redirect()->route('surat-pengantar.show', $surat)
            ->with('success', 'Surat pengantar nomor '.$surat->nomor_surat.' berhasil dibuat dan siap dicetak!');
    }

    /**
     * Tampilan Detail Surat Pengantar
     */
    public function show(SuratPengantar $suratPengantar): View
    {
        $suratPengantar->load('warga.keluarga');

        return view('surat_pengantar.show', compact('suratPengantar'));
    }

    /**
     * Tampilan Cetak Resmi Surat Pengantar (Print-ready view)
     * Menjawab No 1: Memfasilitasi surat pengantar warga ke desa
     */
    public function print(SuratPengantar $suratPengantar): View
    {
        $suratPengantar->load('warga.keluarga');

        return view('surat_pengantar.print', compact('suratPengantar'));
    }

    /**
     * Hapus arsip surat
     */
    public function destroy(SuratPengantar $suratPengantar): RedirectResponse
    {
        $suratPengantar->delete();

        return redirect()->route('surat-pengantar.index')->with('success', 'Arsip surat pengantar berhasil dihapus.');
    }
}
