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
        $status = $request->query('status');

        $query = SuratPengantar::with('warga.keluarga');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('qr_token', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('warga', function ($w) use ($search) {
                        $w->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($tahun) {
            $query->where('tahun_arsip', $tahun);
        }

        if ($jenis) {
            $query->where('jenis_surat', $jenis);
        }

        $surats = $query->latest('created_at')->paginate(15)->withQueryString();

        $totalSurat = SuratPengantar::count();
        $totalMenunggu = SuratPengantar::where('status', 'menunggu_validasi')->count();
        $totalSelesai = SuratPengantar::where('status', 'selesai')->count();

        // Daftar tahun yang tersedia untuk filter arsip 10 tahun
        $daftarTahun = SuratPengantar::select('tahun_arsip')
            ->distinct()
            ->orderByDesc('tahun_arsip')
            ->pluck('tahun_arsip');

        return view('surat_pengantar.index', compact(
            'surats',
            'daftarTahun',
            'search',
            'tahun',
            'jenis',
            'status',
            'totalSurat',
            'totalMenunggu',
            'totalSelesai'
        ));
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

        $autoNomorSurat = sprintf('470/%03d/RT.005-RW.013/%s/%d', $countThisMonth, $bulanRomawi[$currentMonth] ?? 'XI', $currentYear);

        return view('surat_pengantar.create', compact('wargas', 'selectedWargaId', 'autoNomorSurat'));
    }

    /**
     * Simpan Surat Pengantar & Arsipkan
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => ['required', 'string', 'unique:surat_pengantars,nomor_surat'],
            'warga_id' => ['nullable', 'exists:wargas,id'],
            'nama_lengkap' => ['nullable', 'string', 'max:255'],
            'nik' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:500'],
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

        if (empty($validated['warga_id']) && empty($validated['nama_lengkap']) && empty($validated['nik'])) {
            return back()->withErrors(['nama_lengkap' => 'Silakan masukkan Nama Lengkap atau NIK pemohon.'])->withInput();
        }

        $warga = Warga::resolveFromInput($validated);
        $validated['warga_id'] = $warga->id;

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

        if (in_array($validated['tanda_tangan_jenis'], ['digital', 'qrcode', 'foto', 'pdf', 'upload']) || empty($validated['qr_token'] ?? null)) {
            $validated['qr_token'] = 'BMI2-'.strtoupper(Str::random(6));
        }

        $surat = SuratPengantar::create($validated);

        return redirect()->route('surat-pengantar.show', $surat)
            ->with('success', 'Surat pengantar nomor '.$surat->nomor_surat.' berhasil dibuat dengan Kode Warga: '.$surat->qr_token);
    }

    /**
     * Validasi dan Sahkan Surat Permohonan Warga
     */
    public function validasi(Request $request, SuratPengantar $suratPengantar): RedirectResponse
    {
        $user = $request->user();
        $token = $suratPengantar->qr_token ?: ('BMI2-'.strtoupper(Str::random(6)));

        $suratPengantar->update([
            'status' => 'selesai',
            'penandatangan_nama' => $user->name,
            'penandatangan_jabatan' => $user->jabatan ?: 'Ketua RT 005',
            'qr_token' => $token,
            'tanda_tangan_jenis' => $suratPengantar->tanda_tangan_jenis ?: 'qrcode',
        ]);

        return redirect()->back()->with('success', 'Surat berhasil divalidasi & disahkan! Berikan Kode Warga: '.$token.' kepada pemohon.');
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
