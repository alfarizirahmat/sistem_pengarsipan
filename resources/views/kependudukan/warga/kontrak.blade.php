@extends('layouts.app')

@section('title', 'Pengawasan Warga Kontrak & Kost RT 03')
@section('header_title', 'Pengawasan Warga Kontrak & Kost')

@section('content')
<div class="space-y-6">

    <!-- Penjelasan Solusi RT No 7 -->
    <div class="bg-amber-600 text-white rounded-2xl p-6 sm:p-8 shadow-md">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white flex-shrink-0">
                <i data-lucide="building-2" class="w-8 h-8"></i>
            </div>
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-amber-200">Solusi Masalah Warga Kontrak (Poin No. 7)</span>
                <h2 class="text-xl sm:text-2xl font-black mt-1">Daftar Rumah Kontrakan & Kontak Pemilik</h2>
                <p class="text-xs sm:text-sm text-amber-100 mt-1 max-w-3xl leading-relaxed">
                    Untuk mencegah warga kontrak pindah mendadak tanpa melapor ke RT, di bawah ini tercantum <strong>Nomor HP Pemilik Rumah</strong> agar pengurus RT bisa langsung menghubungi pemilik kontrakan jika ada warga sewa yang bermasalah atau pindah.
                </p>
            </div>
        </div>
    </div>

    <!-- Kartu Rumah Kontrakan & Kontak Pemilik (Besar & Jelas) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($keluargasKontrak as $kk)
        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between gap-2 mb-2">
                    <div>
                        <span class="text-xs font-extrabold uppercase text-amber-900 bg-amber-100 px-2.5 py-1 rounded-md">Rumah Sewa / Kontrakan</span>
                        <h3 class="text-lg font-black text-slate-900 mt-2">{{ $kk->kepala_keluarga }}</h3>
                        <p class="text-xs text-slate-500 font-mono">No. KK: {{ $kk->nomor_kk }}</p>
                    </div>
                    <span class="text-xs font-extrabold text-slate-700 bg-slate-100 px-3 py-1 rounded-xl">
                        {{ $kk->wargas->count() }} Jiwa
                    </span>
                </div>

                <div class="space-y-2 text-xs sm:text-sm text-slate-700 my-4 pt-3 border-t border-slate-100 font-medium">
                    <p class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                        <span>Alamat: <strong>{{ $kk->alamat }}</strong></span>
                    </p>
                    <p class="flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                        <span>Pemilik Rumah: <strong>{{ $kk->nama_pemilik_kontrakan ?? 'Belum ada data' }}</strong></span>
                    </p>
                    @if($kk->kontak_pemilik_kontrakan)
                    <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] text-emerald-800 font-bold block">No. HP / WA Pemilik:</span>
                            <span class="font-extrabold text-emerald-950 text-sm font-mono">{{ $kk->kontak_pemilik_kontrakan }}</span>
                        </div>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kk->kontak_pemilik_kontrakan) }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-extrabold flex items-center gap-1 shadow-sm">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                            <span>Chat WA</span>
                        </a>
                    </div>
                    @endif
                    <p class="text-xs text-slate-500">
                        Masa Sewa: {{ $kk->tgl_mulai_tinggal ? $kk->tgl_mulai_tinggal->format('d/m/Y') : '-' }} s/d {{ $kk->tgl_selesai_kontrak ? $kk->tgl_selesai_kontrak->format('d/m/Y') : 'Aktif' }}
                    </p>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                <span class="text-xs text-slate-500 font-medium truncate">{{ $kk->keterangan ?? 'Warga sewa aktif' }}</span>
                <a href="{{ route('warga.index', ['search' => $kk->kepala_keluarga]) }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-900 text-xs font-bold rounded-xl whitespace-nowrap">
                    Lihat Warga di KK Ini →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-2 bg-white rounded-2xl p-8 text-center text-slate-400 font-bold border-2 border-slate-200">
            Belum ada keluarga kontrak yang terdaftar di RT 03.
        </div>
        @endforelse
    </div>

</div>
@endsection
