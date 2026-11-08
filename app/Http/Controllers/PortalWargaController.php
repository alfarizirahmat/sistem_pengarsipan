<?php

namespace App\Http\Controllers;

use App\Models\SuratPengantar;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortalWargaController extends Controller
{
    /**
     * Halaman Utama Portal Pelayanan Warga RT 005 / RW 013
     */
    public function index(Request $request): View
    {
        $search = trim($request->query('kode', ''));
        $foundSurat = null;
        $searched = false;

        if (! empty($search)) {
            $searched = true;
            $foundSurat = SuratPengantar::with('warga.keluarga')
                ->where('qr_token', $search)
                ->orWhere('nomor_surat', $search)
                ->orWhereHas('warga', function ($q) use ($search) {
                    $q->where('nik', $search);
                })
                ->latest('tanggal_surat')
                ->first();
        }

        // Daftar warga untuk pilihan saat pengajuan mandiri
        $wargas = Warga::aktif()->orderBy('nama_lengkap')->get(['id', 'nik', 'nama_lengkap']);

        return view('portal.index', compact('search', 'foundSurat', 'searched', 'wargas'));
    }

    /**
     * Warga mengajukan surat pengantar secara mandiri
     */
    public function ajukanSurat(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => ['nullable', 'string', 'max:255'],
            'nik' => ['nullable', 'string', 'max:20'],
            'warga_id' => ['nullable', 'exists:wargas,id'],
            'jenis_surat' => ['required', 'string'],
            'keperluan' => ['required', 'string', 'max:500'],
            'dokumen_hilang' => ['nullable', 'string', 'max:255'],
            'no_whatsapp' => ['nullable', 'string', 'max:20'],
        ]);

        if (empty($validated['nama_lengkap']) && empty($validated['nik']) && empty($validated['warga_id'])) {
            return back()->withErrors(['nama_lengkap' => 'Silakan masukkan Nama Lengkap atau NIK pemohon.'])->withInput();
        }

        $warga = Warga::resolveFromInput($validated);

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        $countThisMonth = SuratPengantar::whereMonth('tanggal_surat', $currentMonth)
            ->whereYear('tanggal_surat', $currentYear)
            ->count() + 1;

        $nomorSurat = sprintf('470/%03d/RT.005-RW.013/%s/%d', $countThisMonth, $bulanRomawi[$currentMonth] ?? 'XI', $currentYear);
        $qrToken = 'BMI2-'.strtoupper(Str::random(6));

        $catatan = 'Pengajuan mandiri oleh warga via Portal Web RT 005';
        if (! empty($validated['no_whatsapp'])) {
            $catatan .= ' | WA: '.$validated['no_whatsapp'];
        }

        $surat = SuratPengantar::create([
            'nomor_surat' => $nomorSurat,
            'warga_id' => $warga->id,
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'dokumen_hilang' => $validated['dokumen_hilang'] ?? null,
            'tanggal_surat' => Carbon::now()->toDateString(),
            'berlaku_sampai' => Carbon::now()->addDays(30)->toDateString(),
            'tahun_arsip' => $currentYear,
            'penandatangan_nama' => 'Bapak Hartono',
            'penandatangan_jabatan' => 'Ketua RT 005',
            'tanda_tangan_jenis' => 'qrcode',
            'qr_token' => $qrToken,
            'status' => 'menunggu_validasi',
            'catatan' => $catatan,
        ]);

        return redirect()->route('portal.warga', ['kode' => $qrToken])
            ->with('success_token', $qrToken)
            ->with('success', 'Permohonan surat pengantar berhasil dikirim! Simpan kode pelacakan Anda: '.$qrToken);
    }

    /**
     * Halaman Publik Surat Digital Resmi (Bisa diakses langsung oleh warga via kode token)
     */
    public function digitalSurat(string $token): View
    {
        $suratPengantar = SuratPengantar::with('warga.keluarga')
            ->where('qr_token', $token)
            ->orWhere('id', $token)
            ->firstOrFail();

        return view('portal.digital_surat', compact('suratPengantar'));
    }
}
