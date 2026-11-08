@extends('layouts.app')

@section('title', 'Portal Pengurus RT 005')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 sm:space-y-8 py-2 sm:py-4">

    <!-- HEADER RINGKAS & BERSIH -->
    <div class="text-center space-y-2">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-xs font-bold">
            <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
            <span>RT 005 / RW 013 &bull; Perumahan Bumi Mutiara Indah II</span>
        </div>
        
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
            Meja Pengurus RT 005
        </h1>
        
        <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto">
            Selamat datang, <strong>{{ auth()->user()->name ?? 'Bapak Pengurus' }}</strong> ({{ auth()->user()->jabatan ?? 'Ketua RT 005' }}). Pilih menu di bawah ini untuk mengelola data dan pelayanan:
        </p>
    </div>

    @php
        $pendingSurats = \App\Models\SuratPengantar::with('warga.keluarga')
            ->where('status', 'menunggu_validasi')
            ->latest()
            ->get();
    @endphp

    <!-- NOTIFIKASI AJUAN SURAT DARI WARGA (JIKA ADA PERMOHONAN MASUK) -->
    @if($pendingSurats->count() > 0)
        <a href="{{ route('surat-pengantar.index', ['status' => 'menunggu_validasi']) }}" 
           class="group block bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition-all active:scale-[0.99]">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="bell-ring" class="w-5 h-5 text-white animate-bounce"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-black uppercase tracking-wider bg-white/20 px-2 py-0.5 rounded-md">Perlu Diproses</span>
                            <span class="text-xs font-bold text-amber-100">{{ $pendingSurats->count() }} Permohonan Surat Baru Masuk</span>
                        </div>
                        <p class="text-xs sm:text-sm font-semibold mt-0.5 text-white">Warga mengajukan permohonan melalui portal online. Klik di sini untuk memeriksa &amp; mengesahkan.</p>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-xs font-bold bg-white text-amber-900 px-3.5 py-2 rounded-xl flex-shrink-0 group-hover:bg-amber-50 transition-colors">
                    <span>Periksa</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </div>
        </a>
    @endif

    <!-- TOMBOL UTAMA: BUAT SURAT PENGANTAR (PALING BESAR & MUDAH DISENTUH) -->
    <div>
        <a href="{{ route('surat-pengantar.create') }}" 
           class="group block bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-md hover:shadow-lg transition-all active:scale-[0.99] border-2 border-emerald-500">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white flex-shrink-0 group-hover:scale-105 transition-transform">
                        <i data-lucide="file-plus-2" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-black uppercase tracking-wider bg-white/20 px-2.5 py-0.5 rounded-full">Aksi Cepat</span>
                            <span class="text-xs text-emerald-100 font-medium hidden sm:inline">Pelayanan Warga RT 005</span>
                        </div>
                        <h2 class="text-lg sm:text-2xl font-black tracking-tight text-white mt-0.5">
                            + Buat Surat Pengantar Warga
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-100 mt-0.5 leading-relaxed">
                            Ketik nama/NIK warga pemohon, pilih keperluan, bubuhkan TTD foto/QR, dan cetak surat dinas.
                        </p>
                    </div>
                </div>
                <div class="hidden sm:flex items-center gap-2 bg-white text-emerald-800 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-xs group-hover:bg-emerald-50 transition-colors flex-shrink-0">
                    <span>Buka Form</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- KUMPULAN TOMBOL MENU DI TENGAH HALAMAN (GRID RESPONSIVE 2 KOLOM DI HP, 3-4 KOLOM DI DESKTOP) -->
    <div>
        <div class="flex items-center justify-between mb-3 px-1">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-500">
                Menu Kelola Sistem (8 Modul ERD &amp; LRS):
            </h2>
            <span class="text-[11px] text-slate-400 font-medium hidden sm:inline">Sentuh salah satu menu untuk masuk</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">

            <!-- 1. Pelayanan Surat Pengantar -->
            <a href="{{ route('surat-pengantar.index') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-blue-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i data-lucide="file-text" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-blue-700 transition-colors leading-tight">
                            Pelayanan Surat Pengantar
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Daftar arsip surat pengantar warga, kode pelacakan &amp; cetak
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Total:</span>
                    <span class="font-black text-slate-900">{{ $totalSuratPengantar }} Surat</span>
                </div>
            </a>

            <!-- 2. Buku Data Warga (Buku Induk Kependudukan) -->
            <a href="{{ route('warga.index') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-indigo-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i data-lucide="users" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-indigo-700 transition-colors leading-tight">
                            Buku Induk Kependudukan
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Buku data kependudukan warga tetap, NIK, jenis kelamin &amp; mutasi
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Total:</span>
                    <span class="font-black text-slate-900">{{ $totalWargaAktif }} Jiwa</span>
                </div>
            </a>

            <!-- 3. Buku Kartu Keluarga (Buku KK) -->
            <a href="{{ route('keluarga.index') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-sky-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition-colors">
                            <i data-lucide="home" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-sky-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-sky-700 transition-colors leading-tight">
                            Buku Kartu Keluarga
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Data Kepala Keluarga perumahan, No KK, Blok &amp; anggota keluarga
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Total:</span>
                    <span class="font-black text-slate-900">{{ $totalKk }} KK</span>
                </div>
            </a>

            <!-- 4. Warga Kontrak & Kost -->
            <a href="{{ route('warga.kontrak') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-amber-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <i data-lucide="key-round" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-amber-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-amber-700 transition-colors leading-tight">
                            Data Warga Kontrak
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Daftar penghuni sewa/kost, nama pemilik rumah kontrakan &amp; masa sewa
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Total:</span>
                    <span class="font-black text-amber-700">{{ $totalKkKontrak }} Rumah</span>
                </div>
            </a>

            <!-- 5. Iuran Warga Bulanan -->
            <a href="{{ route('keuangan.iuran.index') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-purple-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <i data-lucide="receipt" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-purple-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-purple-700 transition-colors leading-tight">
                            Iuran Warga Bulanan
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Penarikan iuran bulanan posyandu, sampah, kematian &amp; kas RW
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Terkumpul:</span>
                    <span class="font-black text-purple-700">Rp {{ number_format($iuranLunasBulanIni, 0, ',', '.') }}</span>
                </div>
            </a>

            <!-- 6. Buku Kas RT -->
            <a href="{{ route('keuangan.kas.index') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-emerald-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i data-lucide="wallet" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-emerald-700 transition-colors leading-tight">
                            Buku Kas RT
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Pencatatan kas pemasukan, pengeluaran &amp; saldo otomatis RT 005
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Saldo:</span>
                    <span class="font-black text-emerald-700">Rp {{ number_format($saldoKas, 0, ',', '.') }}</span>
                </div>
            </a>

            <!-- 7. Agenda Surat Masuk -->
            <a href="{{ route('surat-masuk.index') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-rose-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <i data-lucide="inbox" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-rose-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-rose-700 transition-colors leading-tight">
                            Agenda Surat Masuk
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Buku agenda arsip surat dinas dari Kantor Desa, RW, &amp; Instansi luar
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Total:</span>
                    <span class="font-black text-slate-900">{{ $totalSuratMasuk }} Surat</span>
                </div>
            </a>

            <!-- 8. Jurnal Ronda & Keamanan -->
            <a href="{{ route('keamanan.index') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-orange-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-orange-50 text-orange-700 flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors">
                            <i data-lucide="shield-alert" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-orange-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-orange-700 transition-colors leading-tight">
                            Jurnal Ronda &amp; Keamanan
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Laporan ronda pos kamling malam, tamu 24 jam &amp; situasi lingkungan
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Status:</span>
                    <span class="font-black text-emerald-700">Aman / Kondusif</span>
                </div>
            </a>

            <!-- 9. Laporan Rekapitulasi Desa -->
            <a href="{{ route('kependudukan.laporan-desa') }}" 
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-teal-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <i data-lucide="file-spreadsheet" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-teal-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-teal-700 transition-colors leading-tight">
                            Laporan Rekap Desa
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Rekapitulasi mutasi kependudukan bulanan siap cetak untuk diserahkan ke desa
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Bulan:</span>
                    <span class="font-black text-slate-900">{{ \Carbon\Carbon::now()->format('m / Y') }}</span>
                </div>
            </a>

            <!-- 10. Buka Portal Publik Warga -->
            <a href="{{ route('portal.warga') }}" 
               target="_blank"
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-blue-400 hover:shadow-md transition-all active:scale-[0.98] flex flex-col justify-between min-h-[140px] sm:min-h-[160px]">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i data-lucide="external-link" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-blue-700 transition-colors leading-tight">
                            Buka Portal Warga
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            Cek tampilan website pencarian kode surat mandiri yang dilihat warga
                        </p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Mode:</span>
                    <span class="font-black text-blue-700">Publik &rarr;</span>
                </div>
            </a>

        </div>
    </div>

</div>
@endsection
