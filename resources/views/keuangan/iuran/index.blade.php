@extends('layouts.app')

@section('title', 'Iuran Bulanan Warga (Humas)')
@section('header_title', 'Buku Iuran Bulanan Warga (Seksi Humas)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">Buku Penarikan Iuran Warga (Humas)</h1>
            <p class="text-sm text-slate-600 font-medium">Iuran rutin RT untuk Posyandu, Kas RW, Dana Kematian, dan Sampah</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <form action="{{ route('keuangan.iuran.generate') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-extrabold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl shadow-md transition-all active:scale-95 w-full sm:w-auto">
                    <i data-lucide="refresh-cw" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    <span>+ GENERATE TAGIHAN BULAN INI</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Ringkasan Angka Iuran (Besar & Jelas) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-6 border-2 border-emerald-300 shadow-sm bg-emerald-50/50">
            <span class="text-xs font-extrabold uppercase tracking-wider text-emerald-900">Iuran Terkumpul (Lunas)</span>
            <div class="text-2xl sm:text-3xl font-black text-emerald-800 mt-2">
                Rp {{ number_format($totalLunas, 0, ',', '.') }}
            </div>
            <p class="text-xs text-emerald-700 font-bold mt-2">✓ {{ $countLunas }} KK telah lunas bayar</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border-2 border-amber-300 shadow-sm bg-amber-50/50">
            <span class="text-xs font-extrabold uppercase tracking-wider text-amber-900">Iuran Belum Tertagih</span>
            <div class="text-2xl sm:text-3xl font-black text-amber-800 mt-2">
                Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}
            </div>
            <p class="text-xs text-amber-700 font-bold mt-2">⏳ {{ $countBelumLunas }} KK belum ditarik</p>
        </div>

        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Tarif Iuran Warga RT 03:</span>
            <div class="text-xs font-bold text-slate-800 space-y-1 mt-2">
                <div>• Posyandu Balita: <strong>Rp 5.000</strong></div>
                <div>• Kas RW 02: <strong>Rp 10.000</strong></div>
                <div>• Dana Kematian: <strong>Rp 10.000</strong></div>
                <div>• Sampah Lingkungan: <strong>Rp 15.000</strong></div>
                <div class="pt-1 border-t border-slate-200 text-emerald-700">Total: <strong>Rp 40.000 / KK / Bulan</strong></div>
            </div>
        </div>
    </div>

    <!-- Filter Periode Bulan -->
    <div class="bg-white rounded-2xl p-5 border-2 border-slate-200 shadow-sm">
        <form action="{{ route('keuangan.iuran.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Pilih Bulan Tagihan:</label>
                <select name="bulan" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold focus:ring-4 focus:ring-emerald-200">
                    @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $num => $nama)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>Bulan {{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Pilih Tahun:</label>
                <select name="tahun" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold focus:ring-4 focus:ring-emerald-200">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Status Pembayaran:</label>
                <select name="status" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold focus:ring-4 focus:ring-emerald-200">
                    <option value="">Semua Status</option>
                    <option value="lunas" {{ $status === 'lunas' ? 'selected' : '' }}>Sudah Lunas</option>
                    <option value="belum_lunas" {{ $status === 'belum_lunas' ? 'selected' : '' }}>Belum Bayar</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Iuran KK -->
    <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-800">
                <thead class="bg-slate-100 border-b-2 border-slate-200 text-slate-700 font-extrabold uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">Nama Kepala Keluarga</th>
                        <th class="px-5 py-4">Alamat Rumah</th>
                        <th class="px-5 py-4">Total Iuran</th>
                        <th class="px-5 py-4">Status Bayar</th>
                        <th class="px-5 py-4 text-right">Tombol Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($iurans as $iu)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">
                            <div class="font-extrabold text-slate-900 text-base">{{ $iu->keluarga->kepala_keluarga ?? 'KK' }}</div>
                            <div class="text-xs text-slate-500 font-mono">No. KK: {{ $iu->keluarga->nomor_kk ?? '-' }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-slate-900 font-bold">{{ $iu->keluarga->alamat ?? '-' }}</span>
                            <div class="text-xs text-slate-500 font-semibold">{{ ucfirst($iu->keluarga->status_tempat_tinggal ?? 'tetap') }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-black text-slate-900 text-base font-mono">Rp {{ number_format($iu->total_iuran, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($iu->status === 'lunas')
                                <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-900 font-black px-3 py-1 rounded-lg text-xs">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-700"></i>
                                    <span>Lunas ({{ $iu->tanggal_bayar?->format('d/m/Y') }})</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-900 font-black px-3 py-1 rounded-lg text-xs">
                                    <span>Belum Bayar</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            @if($iu->status !== 'lunas')
                                <form action="{{ route('keuangan.iuran.bayar', $iu) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="metode_pembayaran" value="tunai">
                                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black inline-flex items-center gap-1.5 shadow-sm active:scale-95">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                        <span>TANDAI LUNAS TUNAI</span>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-emerald-700 font-extrabold">✓ Terverifikasi Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-slate-400 font-bold">
                            Belum ada tagihan iuran untuk bulan ini. Klik tombol <strong>"+ GENERATE TAGIHAN BULAN INI"</strong> di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($iurans->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $iurans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
