@extends('layouts.app')

@section('title', 'Buku Kas Umum RT (Bendahara)')
@section('header_title', 'Buku Kas Keuangan RT (Bendahara)')

@section('content')
<div class="space-y-6" x-data="{ catatKasModalOpen: false, jenisTransaksi: 'pemasukan' }">

    <!-- Header & Tombol Tambah Kas -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">Buku Kas Keuangan RT 005</h1>
            <p class="text-sm text-slate-600 font-medium">Pengelolaan dana kas RT, pemasukan iuran warga, dan pengeluaran operasional</p>
        </div>
        <button type="button" @click="catatKasModalOpen = true" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-extrabold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl shadow-md transition-all active:scale-95 w-full sm:w-auto">
            <i data-lucide="plus-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
            <span>+ CATAT TRANSAKSI KAS BARU</span>
        </button>
    </div>

    <!-- Tiga Kartu Angka Kas (Besar & Kontras Tinggi) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Saldo Kas RT -->
        <div class="bg-gradient-to-tr from-emerald-800 to-teal-700 rounded-2xl p-6 text-white shadow-md sm:col-span-1">
            <span class="text-xs font-black uppercase tracking-wider text-emerald-200">SISA UANG KAS RT SAAT INI</span>
            <div class="text-3xl font-black text-white mt-2">
                Rp {{ number_format($saldoTotalAllTime, 0, ',', '.') }}
            </div>
            <p class="text-xs text-emerald-100 font-medium mt-2">Uang kas siap pakai RT 005 / RW 013</p>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm">
            <span class="text-xs font-extrabold uppercase text-slate-500">Total Uang Masuk (Tahun {{ $tahun }})</span>
            <div class="text-2xl font-black text-emerald-700 mt-2">
                +Rp {{ number_format($totalMasuk, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 font-semibold mt-1">Dari iuran warga & sumbangan</p>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm">
            <span class="text-xs font-extrabold uppercase text-slate-500">Total Uang Keluar (Tahun {{ $tahun }})</span>
            <div class="text-2xl font-black text-rose-700 mt-2">
                -Rp {{ number_format($totalKeluar, 0, ',', '.') }}
            </div>
            <p class="text-xs text-slate-500 font-semibold mt-1">Operasional, pos ronda, santunan</p>
        </div>
    </div>

    <!-- Tabel Catatan Buku Kas -->
    <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b-2 border-slate-200 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Riwayat Catatan Kas RT</h3>
            <span class="text-xs font-bold text-slate-500">Total: {{ $transaksis->total() }} Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-800">
                <thead class="bg-slate-100 border-b-2 border-slate-200 text-slate-700 font-extrabold uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">Tanggal Transaksi</th>
                        <th class="px-5 py-4">Jenis & Kategori</th>
                        <th class="px-5 py-4">Keterangan Penggunaan Uang</th>
                        <th class="px-5 py-4">Nominal (Rupiah)</th>
                        <th class="px-5 py-4">Dicatat Oleh</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="font-extrabold text-slate-900 text-base">{{ $t->tanggal->format('d/m/Y') }}</div>
                            <span class="text-xs text-slate-500 font-mono">{{ $t->nomor_bukti ?? 'No Bukti -' }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($t->jenis === 'pemasukan')
                                <span class="bg-emerald-100 text-emerald-900 font-extrabold px-3 py-1 rounded-md text-xs inline-flex items-center gap-1">
                                    <span>↓ Pemasukan</span>
                                </span>
                            @else
                                <span class="bg-rose-100 text-rose-900 font-extrabold px-3 py-1 rounded-md text-xs inline-flex items-center gap-1">
                                    <span>↑ Pengeluaran</span>
                                </span>
                            @endif
                            <div class="text-xs text-slate-600 font-bold mt-1">{{ ucwords(str_replace('_', ' ', $t->kategori)) }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-bold text-slate-900 text-sm">{{ $t->keterangan }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($t->jenis === 'pemasukan')
                                <span class="text-base font-black text-emerald-700 font-mono">+Rp {{ number_format($t->nominal, 0, ',', '.') }}</span>
                            @else
                                <span class="text-base font-black text-rose-700 font-mono">-Rp {{ number_format($t->nominal, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-slate-600 font-medium text-xs">
                            {{ $t->dicatat_oleh }}
                        </td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <form action="{{ route('keuangan.kas.destroy', $t) }}" method="POST" onsubmit="return confirm('Hapus transaksi kas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-slate-100 hover:bg-rose-100 text-slate-700 hover:text-rose-700 rounded-xl font-bold text-xs" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-400 font-bold">Belum ada transaksi kas yang dicatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transaksis->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Catat Kas Baru -->
    <div x-cloak x-show="catatKasModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="catatKasModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6 sm:p-8">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="text-lg font-extrabold text-slate-900">Catat Uang Kas RT Baru</h3>
                    <button @click="catatKasModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form action="{{ route('keuangan.kas.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Pilih Jenis Arus Uang <span class="text-rose-500">*</span></label>
                        <select name="jenis" x-model="jenisTransaksi" required class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-black focus:ring-4 focus:ring-emerald-200">
                            <option value="pemasukan">Uang Masuk ke Kas RT (Pemasukan)</option>
                            <option value="pengeluaran">Uang Keluar / Biaya Belanja (Pengeluaran)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Tanggal Transaksi:</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold">
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Jumlah Uang (Rp):</label>
                            <input type="number" name="nominal" required placeholder="Contoh: 150000" min="1000" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-black text-slate-900">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Kategori Penggunaan Uang:</label>
                        <select name="kategori" required class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold">
                            <template x-if="jenisTransaksi === 'pemasukan'">
                                <optgroup label="Pemasukan">
                                    <option value="iuran_warga">Setoran Iuran Warga Bulanan</option>
                                    <option value="bantuan_desa">Bantuan Pemerintah Desa</option>
                                    <option value="donasi">Sumbangan / Donasi Sukarela</option>
                                    <option value="saldo_awal">Saldo Pindahan Kas</option>
                                    <option value="lainnya">Pemasukan Lainnya</option>
                                </optgroup>
                            </template>
                            <template x-if="jenisTransaksi === 'pengeluaran'">
                                <optgroup label="Pengeluaran">
                                    <option value="keamanan_ronda">Perlengkapan Pos Ronda & Senter</option>
                                    <option value="posyandu">Bantuan Posyandu Balita</option>
                                    <option value="santunan_kematian">Santunan Wafat / Pemakaman</option>
                                    <option value="operasional_rt">ATK & Kertas Surat RT</option>
                                    <option value="perbaikan_lingkungan">Kerja Bakti Saluran Air / Parit</option>
                                    <option value="kebersihan_sampah">Kebersihan & Sampah Lingkungan</option>
                                    <option value="lainnya">Pengeluaran Lainnya</option>
                                </optgroup>
                            </template>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Keterangan / Keperluan:</label>
                        <textarea name="keterangan" rows="2" required placeholder="Contoh: Pembelian lampu pos ronda dan kopi siskamling..." class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-medium"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="catatKasModalOpen = false" class="px-5 py-2.5 border-2 border-slate-300 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-100">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white text-sm font-extrabold rounded-xl hover:bg-emerald-700 shadow-md">Simpan Catatan Kas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
