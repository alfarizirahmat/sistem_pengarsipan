@extends('layouts.app')

@section('title', 'Seksi Keamanan & Jadwal Ronda')
@section('header_title', 'Seksi Keamanan & Jadwal Ronda')

@section('content')
<div class="space-y-6" x-data="{ catatLaporanModalOpen: false }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">Jadwal Siskamling & Buku Keamanan RT</h1>
            <p class="text-sm text-slate-600 font-medium">Jadwal pos ronda malam, pemantauan wilayah, dan laporan kondusifitas lingkungan</p>
        </div>
        <button type="button" @click="catatLaporanModalOpen = true" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-extrabold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl shadow-md transition-all active:scale-95 w-full sm:w-auto">
            <i data-lucide="plus-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
            <span>+ TULIS LAPORAN RONDA BARU</span>
        </button>
    </div>

    <!-- Jadwal Ronda Siskamling (Kotak Besar & Jelas) -->
    <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center justify-between pb-4 border-b-2 border-slate-100 mb-5">
            <div class="flex items-center gap-2.5">
                <i data-lucide="shield-check" class="w-6 h-6 text-emerald-600"></i>
                <h2 class="text-base sm:text-lg font-black text-slate-900">JADWAL REGU RONDA MALAM (23:00 - 04:30 WIB)</h2>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">Pos Keamanan Utama RT 005</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs sm:text-sm">
            <div class="p-4 bg-slate-50 rounded-2xl border-2 border-slate-200">
                <span class="font-black text-slate-900 text-sm block mb-2 text-blue-900">Senin & Selasa (Regu 1)</span>
                <p class="text-slate-700 font-bold leading-relaxed">• Bambang Sudibyo (Koord)<br>• Agus Santoso<br>• Warga Blok A</p>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border-2 border-slate-200">
                <span class="font-black text-slate-900 text-sm block mb-2 text-cyan-900">Rabu & Kamis (Regu 2)</span>
                <p class="text-slate-700 font-bold leading-relaxed">• Eko Prasetyo (Koord)<br>• Rudi Kurniawan<br>• Warga Blok B</p>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border-2 border-slate-200">
                <span class="font-black text-slate-900 text-sm block mb-2 text-amber-900">Jumat & Sabtu (Regu 3)</span>
                <p class="text-slate-700 font-bold leading-relaxed">• Dedi Iskandar (Koord)<br>• Ahmad Faisal<br>• Warga Blok C & Rumah Hunian</p>
            </div>
            <div class="p-4 bg-emerald-50 rounded-2xl border-2 border-emerald-300 text-emerald-950">
                <span class="font-black text-sm block mb-2 text-emerald-900">Malam Minggu (Regu Gabungan)</span>
                <p class="font-bold leading-relaxed">• Semua Pengurus RT<br>• Pemuda Warga BMI II<br>• Patroli Keliling Lingkungan</p>
            </div>
        </div>
    </div>

    <!-- Buku Catatan Mutasi Ronda -->
    <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b-2 border-slate-200 flex items-center justify-between">
            <h3 class="text-base font-extrabold text-slate-900">Catatan Kegiatan Patroli & Ketertiban</h3>
            <span class="text-xs font-bold text-slate-500">Total: {{ $laporans->total() }} Laporan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-800">
                <thead class="bg-slate-100 border-b-2 border-slate-200 text-slate-700 font-extrabold uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">Tanggal & Kategori</th>
                        <th class="px-5 py-4">Kegiatan / Kejadian</th>
                        <th class="px-5 py-4">Petugas yang Hadir</th>
                        <th class="px-5 py-4">Situasi Lingkungan</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($laporans as $lp)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="font-extrabold text-slate-900 text-base">{{ $lp->tanggal->format('d/m/Y') }}</div>
                            <span class="text-xs font-bold text-slate-500 uppercase">{{ ucwords(str_replace('_', ' ', $lp->kategori)) }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-extrabold text-slate-900 text-sm block">{{ $lp->judul }}</span>
                            <p class="text-xs text-slate-600 mt-1">{{ $lp->keterangan }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-800 text-xs">{{ $lp->petugas_ronda ?? '-' }}</div>
                            <div class="text-[11px] text-slate-500 font-medium">{{ $lp->lokasi }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="bg-emerald-100 text-emerald-900 font-black px-3 py-1 rounded-lg text-xs">
                                ✓ {{ ucfirst($lp->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <form action="{{ route('keamanan.destroy', $lp) }}" method="POST" onsubmit="return confirm('Hapus catatan keamanan ini?')">
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
                        <td colspan="5" class="px-5 py-10 text-center text-slate-400 font-bold">Belum ada catatan keamanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporans->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $laporans->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Catat Laporan Ronda Baru -->
    <div x-cloak x-show="catatLaporanModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="catatLaporanModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6 sm:p-8">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="text-lg font-extrabold text-slate-900">Tulis Laporan Ronda Baru</h3>
                    <button @click="catatLaporanModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form action="{{ route('keamanan.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Tanggal Ronda:</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Kategori:</label>
                            <select name="kategori" required class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold">
                                <option value="ronda_malam">Ronda Siskamling Malam</option>
                                <option value="kondusifitas">Patroli Wilayah</option>
                                <option value="banjir_musibah">Pantauan Banjir / Hujan</option>
                                <option value="tamu_menginap">Tamu Menginap 1x24 Jam</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Judul Kegiatan / Laporan:</label>
                        <input type="text" name="judul" required placeholder="Contoh: Kegiatan Ronda Malam Regu 1" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Nama Petugas yang Hadir:</label>
                        <input type="text" name="petugas_ronda" placeholder="Contoh: Agus Santoso, Bambang Sudibyo, Dedi Iskandar" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Keterangan Situasi:</label>
                        <textarea name="keterangan" rows="3" required placeholder="Uraikan kondisi keamanan, jam patroli, atau catatan situasi..." class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-medium"></textarea>
                    </div>

                    <input type="hidden" name="lokasi" value="Perumahan Bumi Mutiara Indah II RT 005 / RW 013">
                    <input type="hidden" name="status" value="kondusif">

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="catatLaporanModalOpen = false" class="px-5 py-2.5 border-2 border-slate-300 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-100">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white text-sm font-extrabold rounded-xl hover:bg-emerald-700 shadow-md">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
