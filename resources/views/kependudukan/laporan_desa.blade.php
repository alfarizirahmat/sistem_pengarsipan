@extends('layouts.app')

@section('title', 'Laporan Bulanan Perkembangan Penduduk ke Desa')
@section('header_title', 'Laporan Kependudukan Bulanan ke Kantor Desa')

@section('content')
<div class="space-y-6">

    <!-- Header & Filter Periode (Non-print) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Format Laporan Bulanan Perkembangan Penduduk ke Desa</h1>
            <p class="text-xs text-slate-500">Menjawab kewajiban pelaporan RT setiap bulan ke Desa (Lahir, Mati, Pindah, Datang)</p>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('kependudukan.laporan-desa') }}" method="GET" class="flex items-center gap-2">
                <select name="bulan" onchange="this.form.submit()" class="px-3 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-emerald-500">
                    @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                <select name="tahun" onchange="this.form.submit()" class="px-3 py-1.5 bg-white border border-slate-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-emerald-500">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>

            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-sm transition-colors">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Laporan Desa</span>
            </button>
        </div>
    </div>

    <!-- Lembar Dokumen Resmi Format Desa (Tampil di Layar dan Dicetak) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 sm:p-12 print:border-none print:shadow-none print:p-0">
        
        <!-- KOP SURAT PEMERINTAHAN DESA / RT RESMI -->
        <div class="flex items-center justify-between pb-3 border-b-[3px] border-black">
            <!-- Lambang Garuda Pancasila -->
            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 flex items-center justify-center">
                <svg viewBox="0 0 100 100" class="w-14 h-14 sm:w-16 sm:h-16 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                </svg>
            </div>

            <!-- Teks Kop Resmi Berjenjang -->
            <div class="flex-1 text-center px-2">
                <h3 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-black leading-tight">PEMERINTAH KABUPATEN BOGOR</h3>
                <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-black leading-tight">KECAMATAN CILODONG</h4>
                <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-black leading-tight">DESA SUKAMAJU</h4>
                <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-black leading-tight mt-0.5">RUKUN TETANGGA 03 / RUKUN WARGA 02</h2>
                <p class="text-[10px] text-black font-sans mt-0.5 leading-tight">
                    Sekretariat: Jl. Kenanga No. 12 RT 03/RW 02 Desa Sukamaju, Kec. Cilodong, Kab. Bogor 16413
                </p>
                <p class="text-[9px] text-black font-sans leading-tight">
                    Pos-el: rt03rw02.sukamaju@desa.id | Laman: sukamaju.desa.id | Kontak: 0812-3456-7890
                </p>
            </div>

            <!-- Monogram RT Kanan -->
            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 hidden sm:flex items-center justify-center">
                <div class="w-12 h-12 rounded-full border-2 border-black flex flex-col items-center justify-center text-[7px] font-black uppercase leading-none">
                    <span>RT 03</span>
                    <span class="text-[6px] font-normal my-0.5">RW 02</span>
                    <span>SUKAMAJU</span>
                </div>
            </div>
        </div>
        <div class="border-b border-black mb-6 mt-0.5"></div>

        <!-- Judul Laporan -->
        <div class="text-center my-6">
            <h4 class="text-sm sm:text-base font-extrabold uppercase underline tracking-wide text-slate-900">
                LAPORAN PERKEMBANGAN PENDUDUK BULAN {{ strtoupper([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'][$bulan] ?? '') }} TAHUN {{ $tahun }}
            </h4>
            <p class="text-xs text-slate-600 mt-1">Diserahkan kepada: Pemerintah Desa Sukamaju</p>
        </div>

        <!-- Tabel Rekapitulasi Angka Perkembangan Penduduk -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-xs border-collapse border border-slate-400 text-center">
                <thead class="bg-slate-100 font-bold uppercase text-[11px]">
                    <tr>
                        <th rowspan="2" class="border border-slate-400 px-3 py-2">No</th>
                        <th rowspan="2" class="border border-slate-400 px-4 py-2 text-left">Uraian Perkembangan Penduduk</th>
                        <th colspan="2" class="border border-slate-400 px-3 py-1">Jenis Kelamin</th>
                        <th rowspan="2" class="border border-slate-400 px-3 py-2">Jumlah Total</th>
                    </tr>
                    <tr>
                        <th class="border border-slate-400 px-3 py-1">Laki-Laki</th>
                        <th class="border border-slate-400 px-3 py-1">Perempuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-slate-400 px-3 py-2 font-bold">1</td>
                        <td class="border border-slate-400 px-4 py-2 text-left font-semibold">Penduduk Awal Bulan</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono">{{ $totalLakiAktif }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono">{{ $totalPerempuanAktif }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono font-bold">{{ $totalLakiAktif + $totalPerempuanAktif }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-400 px-3 py-2 font-bold">2</td>
                        <td class="border border-slate-400 px-4 py-2 text-left">Mutasi Lahir (Kelahiran)</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-emerald-700">+{{ $mutasiLahirL }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-emerald-700">+{{ $mutasiLahirP }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono font-bold text-emerald-700">+{{ $mutasiLahirL + $mutasiLahirP }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-400 px-3 py-2 font-bold">3</td>
                        <td class="border border-slate-400 px-4 py-2 text-left">Mutasi Mati (Kematian)</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-rose-700">-{{ $mutasiMatiL }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-rose-700">-{{ $mutasiMatiP }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono font-bold text-rose-700">-{{ $mutasiMatiL + $mutasiMatiP }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-400 px-3 py-2 font-bold">4</td>
                        <td class="border border-slate-400 px-4 py-2 text-left">Mutasi Datang (Masuk Domisili / Kontrak)</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-blue-700">+{{ $mutasiDatangL }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-blue-700">+{{ $mutasiDatangP }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono font-bold text-blue-700">+{{ $mutasiDatangL + $mutasiDatangP }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-400 px-3 py-2 font-bold">5</td>
                        <td class="border border-slate-400 px-4 py-2 text-left">Mutasi Pindah (Keluar Domisili)</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-amber-700">-{{ $mutasiPindahL }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono text-amber-700">-{{ $mutasiPindahP }}</td>
                        <td class="border border-slate-400 px-3 py-2 font-mono font-bold text-amber-700">-{{ $mutasiPindahL + $mutasiPindahP }}</td>
                    </tr>
                    <tr class="bg-slate-100 font-bold">
                        <td colspan="2" class="border border-slate-400 px-4 py-2.5 text-right uppercase">Penduduk Akhir Bulan (Jiwa)</td>
                        <td class="border border-slate-400 px-3 py-2.5 font-mono">{{ $totalLakiAktif + $mutasiLahirL + $mutasiDatangL - $mutasiMatiL - $mutasiPindahL }}</td>
                        <td class="border border-slate-400 px-3 py-2.5 font-mono">{{ $totalPerempuanAktif + $mutasiLahirP + $mutasiDatangP - $mutasiMatiP - $mutasiPindahP }}</td>
                        <td class="border border-slate-400 px-3 py-2.5 font-mono text-emerald-800">
                            {{ ($totalLakiAktif + $mutasiLahirL + $mutasiDatangL - $mutasiMatiL - $mutasiPindahL) + ($totalPerempuanAktif + $mutasiLahirP + $mutasiDatangP - $mutasiMatiP - $mutasiPindahP) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Rincian Daftar Nama Warga yang Mengalami Mutasi Bulan Ini -->
        <h5 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-2">Rincian Peristiwa / Mutasi Bulan Ini:</h5>
        <div class="overflow-x-auto mb-8">
            <table class="w-full text-xs border border-slate-300 border-collapse">
                <thead class="bg-slate-50 font-bold uppercase text-[10px]">
                    <tr>
                        <th class="border border-slate-300 px-2 py-1.5 text-center">No</th>
                        <th class="border border-slate-300 px-3 py-1.5 text-left">Nama Warga & NIK</th>
                        <th class="border border-slate-300 px-2 py-1.5 text-center">L/P</th>
                        <th class="border border-slate-300 px-3 py-1.5 text-left">Jenis Mutasi</th>
                        <th class="border border-slate-300 px-3 py-1.5 text-left">Tanggal</th>
                        <th class="border border-slate-300 px-3 py-1.5 text-left">Keterangan / Tujuan Pindah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($daftarMutasi as $idx => $m)
                    <tr>
                        <td class="border border-slate-300 px-2 py-1.5 text-center">{{ $idx + 1 }}</td>
                        <td class="border border-slate-300 px-3 py-1.5 font-semibold text-slate-900">
                            {{ $m->nama_lengkap }}
                            <div class="text-[10px] text-slate-500 font-mono">{{ $m->nik }}</div>
                        </td>
                        <td class="border border-slate-300 px-2 py-1.5 text-center">{{ $m->jenis_kelamin }}</td>
                        <td class="border border-slate-300 px-3 py-1.5 font-bold uppercase text-[10px]">
                            @if($m->status_kependudukan === 'pindah')
                                <span class="text-amber-700">Pindah Keluar</span>
                            @elseif($m->status_kependudukan === 'meninggal')
                                <span class="text-rose-700">Meninggal</span>
                            @else
                                <span class="text-emerald-700">Lahir / Masuk</span>
                            @endif
                        </td>
                        <td class="border border-slate-300 px-3 py-1.5">
                            {{ $m->tgl_mutasi ? $m->tgl_mutasi->format('d/m/Y') : ($m->tanggal_lahir ? $m->tanggal_lahir->format('d/m/Y') : '-') }}
                        </td>
                        <td class="border border-slate-300 px-3 py-1.5 text-slate-700">
                            {{ $m->keterangan_mutasi ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border border-slate-300 px-3 py-4 text-center text-slate-400">Tidak ada catatan mutasi warga pada periode bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Kolom Tanda Tangan -->
        <div class="grid grid-cols-2 gap-8 text-center text-xs text-slate-800 pt-4">
            <div>
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala Desa Sukamaju</p>
                <div class="h-20"></div>
                <p class="font-bold underline">( .................................................... )</p>
                <p class="text-[11px] text-slate-500">NIP. -</p>
            </div>
            <div>
                <p>Sukamaju, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold">Ketua RT 03 / RW 02</p>
                <div class="h-20 flex items-center justify-center">
                    <span class="text-[11px] text-slate-400 italic font-mono">[Cap Stempel & TTD]</span>
                </div>
                <p class="font-bold underline">HARTONO</p>
                <p class="text-[11px] text-slate-500">Ketua RT 03 Desa Sukamaju</p>
            </div>
        </div>

    </div>

</div>
@endsection

