<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KependudukanController extends Controller
{
    /**
     * Daftar seluruh warga penduduk
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $statusTinggal = $request->query('status_tinggal');
        $statusKependudukan = $request->query('status_kependudukan', 'aktif');

        $query = Warga::with('keluarga');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('pekerjaan', 'like', "%{$search}%");
            });
        }

        if ($statusTinggal && in_array($statusTinggal, ['tetap', 'kontrak', 'kost'])) {
            $query->where('status_tinggal', $statusTinggal);
        }

        if ($statusKependudukan && in_array($statusKependudukan, ['aktif', 'pindah', 'meninggal', 'semua'])) {
            if ($statusKependudukan !== 'semua') {
                $query->where('status_kependudukan', $statusKependudukan);
            }
        }

        $wargas = $query->latest()->paginate(15)->withQueryString();
        $keluargas = Keluarga::orderBy('kepala_keluarga')->get();

        return view('kependudukan.warga.index', compact('wargas', 'keluargas', 'search', 'statusTinggal', 'statusKependudukan'));
    }

    /**
     * Halaman Khusus Pengawasan Warga Kontrak / Kost
     * Menjawab Pertanyaan No 7: Kendala warga ngontrak pindah tanpa lapor
     */
    public function wargaKontrak(Request $request): View
    {
        $search = $request->query('search');

        $query = Warga::with('keluarga')->kontrak();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $wargas = $query->latest()->paginate(15)->withQueryString();
        $keluargasKontrak = Keluarga::kontrak()->with('wargas')->get();

        return view('kependudukan.warga.kontrak', compact('wargas', 'keluargasKontrak', 'search'));
    }

    /**
     * Form tambah warga baru
     */
    public function create(): View
    {
        $keluargas = Keluarga::orderBy('kepala_keluarga')->get();

        return view('kependudukan.warga.create', compact('keluargas'));
    }

    /**
     * Simpan data warga baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'keluarga_id' => ['nullable', 'exists:keluargas,id'],
            'nik' => ['required', 'string', 'size:16', 'unique:wargas,nik'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'string'],
            'pekerjaan' => ['required', 'string'],
            'status_perkawinan' => ['required', 'string'],
            'status_hubungan_keluarga' => ['required', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'status_tinggal' => ['required', 'in:tetap,kontrak,kost'],
            'status_kependudukan' => ['required', 'in:aktif,pindah,meninggal'],
            'tgl_mutasi' => ['nullable', 'date'],
            'keterangan_mutasi' => ['nullable', 'string'],
        ]);

        Warga::create($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Form edit warga
     */
    public function edit(Warga $warga): View
    {
        $keluargas = Keluarga::orderBy('kepala_keluarga')->get();

        return view('kependudukan.warga.edit', compact('warga', 'keluargas'));
    }

    /**
     * Update data warga
     */
    public function update(Request $request, Warga $warga): RedirectResponse
    {
        $validated = $request->validate([
            'keluarga_id' => ['nullable', 'exists:keluargas,id'],
            'nik' => ['required', 'string', 'size:16', 'unique:wargas,nik,'.$warga->id],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'string'],
            'pekerjaan' => ['required', 'string'],
            'status_perkawinan' => ['required', 'string'],
            'status_hubungan_keluarga' => ['required', 'string'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'status_tinggal' => ['required', 'in:tetap,kontrak,kost'],
            'status_kependudukan' => ['required', 'in:aktif,pindah,meninggal'],
            'tgl_mutasi' => ['nullable', 'date'],
            'keterangan_mutasi' => ['nullable', 'string'],
        ]);

        $warga->update($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Update cepat status mutasi warga (pindah/meninggal)
     */
    public function updateMutasi(Request $request, Warga $warga): RedirectResponse
    {
        $validated = $request->validate([
            'status_kependudukan' => ['required', 'in:aktif,pindah,meninggal'],
            'tgl_mutasi' => ['required', 'date'],
            'keterangan_mutasi' => ['required', 'string', 'max:500'],
        ]);

        $warga->update($validated);

        return back()->with('success', 'Status mutasi warga '.$warga->nama_lengkap.' berhasil diperbarui.');
    }

    /**
     * Hapus warga
     */
    public function destroy(Warga $warga): RedirectResponse
    {
        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data warga telah dihapus.');
    }

    /**
     * Daftar Kartu Keluarga (KK)
     */
    public function keluargaIndex(): View
    {
        $keluargas = Keluarga::withCount('wargas')->latest()->paginate(15);

        return view('kependudukan.keluarga.index', compact('keluargas'));
    }

    /**
     * Simpan Kartu Keluarga Baru
     */
    public function keluargaStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_kk' => ['required', 'string', 'size:16', 'unique:keluargas,nomor_kk'],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'status_tempat_tinggal' => ['required', 'in:tetap,kontrak,kost'],
            'nama_pemilik_kontrakan' => ['nullable', 'string', 'max:255'],
            'kontak_pemilik_kontrakan' => ['nullable', 'string', 'max:50'],
            'tgl_mulai_tinggal' => ['nullable', 'date'],
            'tgl_selesai_kontrak' => ['nullable', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Keluarga::create($validated);

        return back()->with('success', 'Data Kartu Keluarga (KK) berhasil didaftarkan.');
    }

    /**
     * Laporan Perkembangan Penduduk Bulanan ke Desa
     * Menjawab Pertanyaan No 5 & No 10
     */
    public function laporanDesa(Request $request): View
    {
        $bulan = (int) $request->query('bulan', Carbon::now()->month);
        $tahun = (int) $request->query('tahun', Carbon::now()->year);

        // Data Awal Bulan
        $totalLakiAktif = Warga::aktif()->where('jenis_kelamin', 'L')->count();
        $totalPerempuanAktif = Warga::aktif()->where('jenis_kelamin', 'P')->count();

        // Mutasi Lahir
        $mutasiLahirL = Warga::aktif()->where('jenis_kelamin', 'L')
            ->whereMonth('tanggal_lahir', $bulan)->whereYear('tanggal_lahir', $tahun)->count();
        $mutasiLahirP = Warga::aktif()->where('jenis_kelamin', 'P')
            ->whereMonth('tanggal_lahir', $bulan)->whereYear('tanggal_lahir', $tahun)->count();

        // Mutasi Meninggal
        $mutasiMatiL = Warga::meninggal()->where('jenis_kelamin', 'L')
            ->whereMonth('tgl_mutasi', $bulan)->whereYear('tgl_mutasi', $tahun)->count();
        $mutasiMatiP = Warga::meninggal()->where('jenis_kelamin', 'P')
            ->whereMonth('tgl_mutasi', $bulan)->whereYear('tgl_mutasi', $tahun)->count();

        // Mutasi Pindah (Keluar)
        $mutasiPindahL = Warga::pindah()->where('jenis_kelamin', 'L')
            ->whereMonth('tgl_mutasi', $bulan)->whereYear('tgl_mutasi', $tahun)->count();
        $mutasiPindahP = Warga::pindah()->where('jenis_kelamin', 'P')
            ->whereMonth('tgl_mutasi', $bulan)->whereYear('tgl_mutasi', $tahun)->count();

        // Mutasi Datang (Masuk)
        $mutasiDatangL = Warga::aktif()->where('jenis_kelamin', 'L')
            ->whereNotNull('tgl_mutasi')
            ->where('status_hubungan_keluarga', '!=', 'Anak')
            ->whereMonth('tgl_mutasi', $bulan)->whereYear('tgl_mutasi', $tahun)->count();
        $mutasiDatangP = Warga::aktif()->where('jenis_kelamin', 'P')
            ->whereNotNull('tgl_mutasi')
            ->where('status_hubungan_keluarga', '!=', 'Anak')
            ->whereMonth('tgl_mutasi', $bulan)->whereYear('tgl_mutasi', $tahun)->count();

        $daftarMutasi = Warga::with('keluarga')
            ->where(function ($q) use ($bulan, $tahun) {
                $q->where(function ($sub) use ($bulan, $tahun) {
                    $sub->whereMonth('tgl_mutasi', $bulan)->whereYear('tgl_mutasi', $tahun);
                })->orWhere(function ($sub) use ($bulan, $tahun) {
                    $sub->whereMonth('tanggal_lahir', $bulan)->whereYear('tanggal_lahir', $tahun);
                });
            })
            ->get();

        return view('kependudukan.laporan_desa', compact(
            'bulan',
            'tahun',
            'totalLakiAktif',
            'totalPerempuanAktif',
            'mutasiLahirL',
            'mutasiLahirP',
            'mutasiMatiL',
            'mutasiMatiP',
            'mutasiPindahL',
            'mutasiPindahP',
            'mutasiDatangL',
            'mutasiDatangP',
            'daftarMutasi'
        ));
    }
}
