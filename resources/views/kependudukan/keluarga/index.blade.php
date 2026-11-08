@extends('layouts.app')

@section('title', 'Data Kartu Keluarga (KK) RT 005')
@section('header_title', 'Administrasi Kartu Keluarga (KK)')

@section('content')
<div class="space-y-6" x-data="{ addKkModalOpen: false }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Buku Register Kartu Keluarga (KK) RT 005</h1>
            <p class="text-xs text-slate-500">Pendataan kepala keluarga, kepemilikan rumah, dan masa sewa kontrakan</p>
        </div>
        <button type="button" @click="addKkModalOpen = true" class="inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition-colors w-full sm:w-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Daftarkan KK Baru</span>
        </button>
    </div>

    <!-- Tabel Kartu Keluarga -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-4 py-3.5">Nomor KK & Kepala Keluarga</th>
                        <th class="px-4 py-3.5">Alamat Lingkungan</th>
                        <th class="px-4 py-3.5">Status Tempat Tinggal</th>
                        <th class="px-4 py-3.5">Pemilik Kontrakan / Catatan</th>
                        <th class="px-4 py-3.5">Jumlah Anggota</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($keluargas as $kk)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3">
                            <div class="font-bold text-slate-900 text-sm">{{ $kk->kepala_keluarga }}</div>
                            <div class="text-[11px] text-slate-500 font-mono">No. KK: {{ $kk->nomor_kk }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-slate-800">{{ $kk->alamat }}</span>
                            <div class="text-[10px] text-slate-400">RT {{ $kk->rt }} / RW {{ $kk->rw }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($kk->status_tempat_tinggal === 'tetap')
                                <span class="bg-emerald-50 text-emerald-700 font-semibold px-2 py-0.5 rounded-full border border-emerald-200">Rumah Sendiri (Tetap)</span>
                            @elseif($kk->status_tempat_tinggal === 'kontrak')
                                <span class="bg-amber-50 text-amber-700 font-semibold px-2 py-0.5 rounded-full border border-amber-200">Sewa / Kontrakan</span>
                            @else
                                <span class="bg-purple-50 text-purple-700 font-semibold px-2 py-0.5 rounded-full border border-purple-200">Kost</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($kk->nama_pemilik_kontrakan)
                                <div class="font-medium text-amber-800">Pemilik: {{ $kk->nama_pemilik_kontrakan }}</div>
                                @if($kk->kontak_pemilik_kontrakan)
                                    <div class="text-[10px] text-slate-500">HP: {{ $kk->kontak_pemilik_kontrakan }}</div>
                                @endif
                            @else
                                <span class="text-slate-400">{{ $kk->keterangan ?? '-' }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-lg">
                                <i data-lucide="users" class="w-3 h-3 text-slate-500"></i>
                                <span>{{ $kk->wargas_count }} Jiwa</span>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('warga.index', ['search' => $kk->kepala_keluarga]) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold">
                                Lihat Anggota
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada Kartu Keluarga yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($keluargas->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $keluargas->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah KK Baru -->
    <div x-cloak x-show="addKkModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="addKkModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="text-base font-bold text-slate-900">Daftarkan Kartu Keluarga (KK) Baru</h3>
                    <button @click="addKkModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('keluarga.store') }}" method="POST" class="space-y-4" x-data="{ statusTinggal: 'tetap' }">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor Kartu Keluarga (16 Digit) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nomor_kk" maxlength="16" required placeholder="Contoh: 3201011203850001" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Kepala Keluarga <span class="text-rose-500">*</span></label>
                        <input type="text" name="kepala_keluarga" required placeholder="Nama lengkap kepala keluarga" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Rumah / Blok <span class="text-rose-500">*</span></label>
                        <input type="text" name="alamat" required placeholder="Contoh: Perumahan Bumi Mutiara Indah II Blok B3 No. 12" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">RT</label>
                            <input type="text" name="rt" value="005" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">RW</label>
                            <input type="text" name="rw" value="013" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Tempat Tinggal <span class="text-rose-500">*</span></label>
                        <select name="status_tempat_tinggal" x-model="statusTinggal" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                            <option value="tetap">Warga Tetap (Milik Sendiri)</option>
                            <option value="kontrak">Sewa / Kontrakan</option>
                            <option value="kost">Kost</option>
                        </select>
                    </div>

                    <!-- Input Khusus jika Kontrak/Kost -->
                    <div x-show="statusTinggal === 'kontrak' || statusTinggal === 'kost'" class="p-3 bg-amber-50 rounded-xl border border-amber-200 space-y-3">
                        <p class="text-[11px] font-bold text-amber-900">Data Pemilik Rumah Kontrakan (Penting untuk Pengawasan RT):</p>
                        <div>
                            <input type="text" name="nama_pemilik_kontrakan" placeholder="Nama Pemilik Rumah Kontrakan" class="w-full px-3 py-2 bg-white border border-amber-300 rounded-xl text-xs focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <input type="text" name="kontak_pemilik_kontrakan" placeholder="No. HP / WA Pemilik Kontrakan" class="w-full px-3 py-2 bg-white border border-amber-300 rounded-xl text-xs focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="addKkModalOpen = false" class="px-4 py-2 border border-slate-300 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 shadow-sm">Daftarkan KK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

