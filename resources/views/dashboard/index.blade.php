@extends('layouts.app')

@section('title', 'Meja Kerja Pengurus RT 005')

@section('content')
<div class="space-y-6">

    <!-- IDENTITAS MEJA KERJA RESMI PENGURUS -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200">
                    Meja Pelayanan &amp; Pendataan
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">RT 005 / RW 013 Perumahan Bumi Mutiara Indah II</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                Sistem Informasi Pendataan dan Pelayanan Warga
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                Selamat bertugas, <strong>{{ auth()->user()->name ?? 'Bapak Pengurus' }}</strong> ({{ auth()->user()->jabatan ?? 'Ketua RT 005' }}). Kelola pelayanan surat pengantar, pendataan kependudukan, iuran &amp; kas RT, serta keamanan lingkungan secara terpadu.
            </p>
        </div>

        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('surat-pengantar.create') }}" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-xs transition-colors">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>+ Buat Surat Pengantar</span>
            </a>
            <a href="{{ route('portal.warga') }}" target="_blank" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-3.5 py-2.5 rounded-xl transition-colors">
                <i data-lucide="globe" class="w-4 h-4"></i>
                <span>Cek Portal</span>
            </a>
        </div>
    </div>

    @php
        $pendingSurats = \App\Models\SuratPengantar::with('warga.keluarga')
            ->where('status', 'menunggu_validasi')
            ->latest()
            ->get();
    @endphp

    <!-- PERHATIAN: AJUAN SURAT DARI WARGA (JIKA ADA) -->
    @if($pendingSurats->count() > 0)
        <div class="bg-amber-50/70 border-2 border-amber-300 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-amber-200 mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                        <i data-lucide="bell-ring" class="w-4 h-4 animate-bounce"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-slate-900 text-sm">
                            Permohonan Surat dari Warga Menunggu Pengesahan ({{ $pendingSurats->count() }})
                        </h2>
                        <p class="text-xs text-amber-900">Warga mengajukan permohonan melalui portal online. Silakan periksa dan klik "Sahkan" di bawah ini.</p>
                    </div>
                </div>
                <a href="{{ route('surat-pengantar.index', ['status' => 'menunggu_validasi']) }}" class="text-xs font-bold text-amber-800 hover:underline">
                    Lihat Semua Ajuan &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left bg-white rounded-xl overflow-hidden border border-amber-200">
                    <thead class="bg-amber-100/70 text-amber-900 font-bold uppercase text-[10px]">
                        <tr>
                            <th class="p-3">Kode Warga</th>
                            <th class="p-3">Nama Pemohon &amp; NIK</th>
                            <th class="p-3">Jenis Surat &amp; Keperluan</th>
                            <th class="p-3">Tanggal Ajuan</th>
                            <th class="p-3 text-center">Tindakan Pengurus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100 font-medium">
                        @foreach($pendingSurats as $ps)
                        <tr class="hover:bg-amber-50/50">
                            <td class="p-3 whitespace-nowrap font-mono font-bold text-blue-700">
                                {{ $ps->qr_token }}
                            </td>
                            <td class="p-3">
                                <div class="font-bold text-slate-900">{{ $ps->warga->nama_lengkap ?? 'Warga' }}</div>
                                <div class="text-[11px] text-slate-500 font-mono">NIK: {{ $ps->warga->nik ?? '-' }}</div>
                            </td>
                            <td class="p-3">
                                <span class="font-semibold text-slate-800 capitalize">{{ str_replace('_', ' ', $ps->jenis_surat) }}</span>
                                <p class="text-slate-500 line-clamp-1">{{ $ps->keperluan }}</p>
                            </td>
                            <td class="p-3 whitespace-nowrap text-slate-500">
                                {{ \Carbon\Carbon::parse($ps->tanggal_surat)->format('d/m/Y') }}
                            </td>
                            <td class="p-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <form action="{{ route('surat-pengantar.validasi', $ps) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Sahkan surat untuk {{ $ps->warga->nama_lengkap ?? 'warga ini' }} sekarang?')"
                                                class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs flex items-center gap-1 shadow-2xs">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            <span>Sahkan &amp; Terbitkan</span>
                                        </button>
                                    </form>
                                    <a href="{{ route('surat-pengantar.show', $ps) }}" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-semibold text-xs">
                                        Periksa
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- PUSAT BUKU REGISTER RESMI (SESUAI 8 TABEL ERD & LRS) -->
    <div>
        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">
            Buku Register Administrasi RT 005 / RW 013:
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Register 1: Persuratan Warga -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-400">Tabel: surat_pengantars</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Pelayanan Surat Pengantar</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Arsip pembuatan surat pengantar KTP, KK, SKTM, Domisili, dan surat kematian untuk warga.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Total Terbit:</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $totalSuratPengantar }} Surat</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex gap-2">
                    <a href="{{ route('surat-pengantar.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Buka Register Surat &rarr;
                    </a>
                </div>
            </div>

            <!-- Register 2: Kependudukan (Warga & KK) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center font-bold">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-400">Tabel: wargas &amp; keluargas</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Buku Induk Kependudukan</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Pendataan seluruh warga, status tinggal tetap vs kontrak, data kartu keluarga, dan mutasi.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Warga Terdaftar:</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $totalWargaAktif }} Jiwa ({{ $totalKk }} KK)</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex gap-2">
                    <a href="{{ route('warga.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Buku Warga &rarr;
                    </a>
                    <a href="{{ route('keluarga.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Buku KK &rarr;
                    </a>
                </div>
            </div>

            <!-- Register 3: Keuangan (Iuran & Kas RT) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                            <i data-lucide="wallet" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-400">Tabel: iuran_wargas &amp; kas_rts</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Kas RT &amp; Iuran Warga</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Pencatatan penarikan iuran bulanan warga per rumah dan buku kas umum RT (pemasukan/pengeluaran).
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Saldo Kas RT:</span>
                        <span class="font-extrabold text-emerald-700 text-sm">Rp {{ number_format($saldoKas, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex gap-2">
                    <a href="{{ route('keuangan.iuran.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Iuran Warga &rarr;
                    </a>
                    <a href="{{ route('keuangan.kas.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Buku Kas &rarr;
                    </a>
                </div>
            </div>

            <!-- Register 4: Surat Masuk -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold">
                            <i data-lucide="inbox" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-400">Tabel: surat_masuks</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Agenda Surat Masuk</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Buku penerimaan surat dinas dari Kantor Kelurahan, Pengurus RW 013, Polsek, dan Puskesmas.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Surat Diarsipkan:</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $totalSuratMasuk }} Surat</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('surat-masuk.index') }}" class="w-full block bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Buka Agenda Surat Masuk &rarr;
                    </a>
                </div>
            </div>

            <!-- Register 5: Pos Ronda & Keamanan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                            <i data-lucide="shield" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-400">Tabel: laporan_keamanans</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Jurnal Ronda &amp; Keamanan</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Catatan kegiatan ronda malam pos kamling, laporan tamu menginap 1x24 jam, dan kondusifitas lingkungan.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Status Lingkungan:</span>
                        <span class="font-extrabold text-emerald-700 text-sm">Kondusif &amp; Aman</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('keamanan.index') }}" class="w-full block bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Buku Jurnal Ronda &rarr;
                    </a>
                </div>
            </div>

            <!-- Register 6: Laporan Rekap ke Desa -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center font-bold">
                            <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-400">Pelaporan Dinas</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Laporan Rekapitulasi Desa</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Rekapitulasi mutasi bulanan (lahir, mati, datang, pindah) siap cetak untuk diserahkan ke kantor desa.
                    </p>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Periode:</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('kependudukan.laporan-desa') }}" class="w-full block bg-slate-100 hover:bg-slate-200 text-slate-800 text-center font-bold py-2 rounded-xl text-xs transition-colors">
                        Lihat Rekap Bulanan &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- TABEL SURAT PENGANTAR TERBARU -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Surat Pengantar Terbaru yang Diterbitkan</h3>
                <p class="text-xs text-slate-500">Daftar surat pengantar keluar terbaru beserta kode warga untuk pengecekan mandiri</p>
            </div>
            <a href="{{ route('surat-pengantar.index') }}" class="text-xs font-bold text-blue-700 hover:underline">
                Lihat Semua Arsip Surat &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="p-3">Nomor &amp; Kode Surat</th>
                        <th class="p-3">Warga Pemohon</th>
                        <th class="p-3">Jenis &amp; Keperluan</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($recentSurats as $rs)
                    <tr class="hover:bg-slate-50/60">
                        <td class="p-3 whitespace-nowrap">
                            <span class="font-bold font-mono text-slate-900 block">{{ $rs->nomor_surat }}</span>
                            <span class="font-mono text-[10px] text-blue-700 font-semibold bg-blue-50 px-1.5 py-0.2 rounded border border-blue-200">
                                {{ $rs->qr_token }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="font-bold text-slate-900">{{ $rs->warga->nama_lengkap ?? 'Warga' }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">NIK: {{ $rs->warga->nik ?? '-' }}</div>
                        </td>
                        <td class="p-3">
                            <span class="capitalize text-slate-700 font-semibold">{{ str_replace('_', ' ', $rs->jenis_surat) }}</span>
                            <p class="text-slate-500 line-clamp-1 text-[11px]">{{ $rs->keperluan }}</p>
                        </td>
                        <td class="p-3 whitespace-nowrap">
                            @if($rs->status === 'menunggu_validasi')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-300">
                                    Menunggu Validasi
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-300">
                                    Sah / Selesai
                                </span>
                            @endif
                        </td>
                        <td class="p-3 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('surat-pengantar.show', $rs) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold">
                                    Detail
                                </a>
                                <a href="{{ route('surat-pengantar.print', $rs) }}" target="_blank" class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold border border-blue-200">
                                    Cetak
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-slate-400">Belum ada surat pengantar yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
