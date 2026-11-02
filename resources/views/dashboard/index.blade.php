@extends('layouts.app')

@section('title', 'Halaman Utama RT 03')
@section('header_title', 'Halaman Utama Pengurus RT 03')

@section('content')
<div class="space-y-6">

    <!-- 4 TOMBOL MENU UTAMA PALING BESAR & MUDAH DITEKAN (KHUSUS BAPAK-BAPAK) -->
    <div>
        <h2 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-3">Tindakan Cepat (Klik Menu yang Ingin Dipilih):</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Tombol 1: Buat Surat (Paling Utama) -->
            <a href="{{ route('surat-pengantar.create') }}" class="p-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white shadow-md hover:shadow-lg transition-all flex items-center gap-4 border-2 border-emerald-500 active:scale-95 group">
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="printer" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-100">Pelayanan Surat</span>
                    <h3 class="text-base sm:text-lg font-black leading-tight mt-0.5">BUAT SURAT PENGANTAR</h3>
                    <p class="text-xs text-emerald-100 mt-1">Pakai template 1-klik</p>
                </div>
            </a>

            <!-- Tombol 2: Data Warga -->
            <a href="{{ route('warga.index') }}" class="p-6 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg transition-all flex items-center gap-4 border-2 border-blue-500 active:scale-95 group">
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <span class="text-xs uppercase font-extrabold tracking-wider text-blue-100">Kependudukan</span>
                    <h3 class="text-base sm:text-lg font-black leading-tight mt-0.5">DATA SEMUA WARGA</h3>
                    <p class="text-xs text-blue-100 mt-1">Cari nama, NIK & alamat</p>
                </div>
            </a>

            <!-- Tombol 3: Pantau Warga Kontrak (Solusi Masalah No 7) -->
            <a href="{{ route('warga.kontrak') }}" class="p-6 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white shadow-md hover:shadow-lg transition-all flex items-center gap-4 border-2 border-amber-500 active:scale-95 group">
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="building-2" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <span class="text-xs uppercase font-extrabold tracking-wider text-amber-100">Pengawasan</span>
                    <h3 class="text-base sm:text-lg font-black leading-tight mt-0.5">PANTAU WARGA KONTRAK</h3>
                    <p class="text-xs text-amber-100 mt-1">{{ $totalWargaKontrak }} warga sewa terdaftar</p>
                </div>
            </a>

            <!-- Tombol 4: Laporan Desa -->
            <a href="{{ route('kependudukan.laporan-desa') }}" class="p-6 rounded-2xl bg-purple-700 hover:bg-purple-800 text-white shadow-md hover:shadow-lg transition-all flex items-center gap-4 border-2 border-purple-600 active:scale-95 group">
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <i data-lucide="file-spreadsheet" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <span class="text-xs uppercase font-extrabold tracking-wider text-purple-200">Laporan Bulanan</span>
                    <h3 class="text-base sm:text-lg font-black leading-tight mt-0.5">CETAK LAPORAN DESA</h3>
                    <p class="text-xs text-purple-200 mt-1">Rekap mutasi ke kantor desa</p>
                </div>
            </a>

        </div>
    </div>

    <!-- KARTU ANGKA RINGKASAN BESAR & JELAS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Warga -->
        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm">
            <span class="text-xs font-extrabold uppercase text-slate-500">Jumlah Warga RT 03</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900">{{ $totalWargaAktif }}</span>
                <span class="text-sm font-bold text-slate-500">Orang</span>
            </div>
            <div class="mt-3 text-xs font-bold text-slate-600 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-900 px-2 py-0.5 rounded-lg">L: {{ $totalWargaLaki }}</span>
                <span class="bg-pink-100 text-pink-900 px-2 py-0.5 rounded-lg">P: {{ $totalWargaPerempuan }}</span>
            </div>
        </div>

        <!-- Total KK -->
        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm">
            <span class="text-xs font-extrabold uppercase text-slate-500">Kartu Keluarga (KK)</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900">{{ $totalKk }}</span>
                <span class="text-sm font-bold text-slate-500">Kepala Keluarga</span>
            </div>
            <div class="mt-3 text-xs font-bold text-slate-600 flex items-center gap-2">
                <span class="text-emerald-800">Tetap: {{ $totalKk - $totalKkKontrak }}</span>
                <span>•</span>
                <span class="text-amber-800">Kontrak: {{ $totalKkKontrak }}</span>
            </div>
        </div>

        <!-- Surat Pengantar Dibuat -->
        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm">
            <span class="text-xs font-extrabold uppercase text-slate-500">Surat Pengantar Dibuat</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900">{{ $totalSuratPengantar }}</span>
                <span class="text-sm font-bold text-emerald-700">(+{{ $suratPengantarBulanIni }} bln ini)</span>
            </div>
            <p class="mt-3 text-xs font-semibold text-slate-500">Arsip tersimpan aman</p>
        </div>

        <!-- Uang Kas RT -->
        <div class="bg-white rounded-2xl p-6 border-2 border-emerald-300 shadow-sm bg-emerald-50/40">
            <span class="text-xs font-extrabold uppercase text-emerald-900">Saldo Kas RT (Bendahara)</span>
            <div class="mt-2 text-2xl sm:text-3xl font-black text-emerald-800">
                Rp {{ number_format($saldoKas, 0, ',', '.') }}
            </div>
            <a href="{{ route('keuangan.kas.index') }}" class="mt-3 inline-block text-xs font-extrabold text-emerald-700 underline">Buka Buku Kas RT →</a>
        </div>
    </div>

    <!-- TABEL SURAT TERBARU (DENGAN TOMBOL CETAK BESAR) -->
    <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Pelayanan Surat Pengantar Terakhir</h3>
                <p class="text-xs text-slate-500 font-medium">Klik tombol "Cetak" untuk langsung print surat</p>
            </div>
            <a href="{{ route('surat-pengantar.index') }}" class="text-xs sm:text-sm font-bold text-emerald-700 hover:text-emerald-800">
                Buka Semua Arsip Surat →
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($recentSurats as $surat)
            <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="text-base font-extrabold text-slate-900">{{ $surat->warga->nama_lengkap ?? 'Warga' }}</span>
                        <span class="text-xs bg-emerald-100 text-emerald-800 font-extrabold px-2 py-0.5 rounded-md">
                            {{ $surat->label_jenis_surat }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 font-medium line-clamp-1">No. Surat: {{ $surat->nomor_surat }} • Keperluan: {{ $surat->keperluan }}</p>
                    <p class="text-[11px] text-slate-400 font-semibold">Tgl Surat: {{ $surat->tanggal_surat->format('d/m/Y') }} • Posisi Map: {{ $surat->lokasi_arsip_fisik ?? 'Map Arsip' }}</p>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('surat-pengantar.show', $surat) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition-colors">
                        Lihat Rincian
                    </a>
                    <a href="{{ route('surat-pengantar.print', $surat) }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold flex items-center gap-1.5 shadow-sm transition-colors active:scale-95">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        <span>CETAK SURAT</span>
                    </a>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 font-medium">
                Belum ada surat pengantar yang dibuat.
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
