@extends('layouts.app')

@section('title', 'Data Warga RT 005')
@section('header_title', 'Buku Induk Data Warga RT 005')

@section('content')
<div class="space-y-6" x-data="{ mutasiModalOpen: false, selectedWarga: null, selectedWargaNama: '', mutasiAction: 'pindah' }">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">Buku Induk Warga RT 005</h1>
            <p class="text-sm text-slate-600 font-medium">Data seluruh warga, status tempat tinggal (Tetap vs Kontrak), dan status kependudukan</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('warga.kontrak') }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 sm:gap-2 bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-extrabold px-3 sm:px-4 py-2.5 rounded-xl shadow-sm transition-all whitespace-nowrap">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                <span>Warga Kontrak</span>
            </a>
            <a href="{{ route('warga.create') }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 sm:gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-extrabold px-3 sm:px-4 py-2.5 rounded-xl shadow-sm transition-all whitespace-nowrap">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span class="hidden sm:inline">+ Tambah Warga Baru</span>
                <span class="sm:hidden font-black">+ Warga</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian Sederhana -->
    <div class="bg-white rounded-2xl p-5 border-2 border-slate-200 shadow-sm">
        <form action="{{ route('warga.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Cari Nama Warga / NIK:</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama warga, NIK 16 digit, atau pekerjaan..."
                        class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold focus:ring-4 focus:ring-emerald-200">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Status Rumah Tinggal:</label>
                <select name="status_tinggal" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold focus:ring-4 focus:ring-emerald-200">
                    <option value="">Semua Tempat Tinggal</option>
                    <option value="tetap" {{ $statusTinggal === 'tetap' ? 'selected' : '' }}>Warga Tetap (Rumah Sendiri)</option>
                    <option value="kontrak" {{ $statusTinggal === 'kontrak' ? 'selected' : '' }}>Warga Kontrak / Sewa</option>
                    <option value="kost" {{ $statusTinggal === 'kost' ? 'selected' : '' }}>Warga Kost</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Status Kependudukan:</label>
                <select name="status_kependudukan" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold focus:ring-4 focus:ring-emerald-200">
                    <option value="aktif" {{ $statusKependudukan === 'aktif' ? 'selected' : '' }}>Warga Aktif</option>
                    <option value="pindah" {{ $statusKependudukan === 'pindah' ? 'selected' : '' }}>Pindah (Keluar)</option>
                    <option value="meninggal" {{ $statusKependudukan === 'meninggal' ? 'selected' : '' }}>Meninggal Dunia</option>
                    <option value="semua" {{ $statusKependudukan === 'semua' ? 'selected' : '' }}>Semua Riwayat</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Tabel Warga -->
    <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-800">
                <thead class="bg-slate-100 border-b-2 border-slate-200 text-slate-700 font-extrabold uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">Nama Lengkap & NIK</th>
                        <th class="px-5 py-4">L/P & Usia</th>
                        <th class="px-5 py-4">Alamat Rumah</th>
                        <th class="px-5 py-4">Status Tinggal</th>
                        <th class="px-5 py-4">Status Warga</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($wargas as $w)
                    <tr class="hover:bg-slate-50 {{ $w->status_kependudukan !== 'aktif' ? 'bg-slate-50 opacity-75' : '' }}">
                        <td class="px-5 py-4">
                            <div class="font-extrabold text-slate-900 text-base">{{ $w->nama_lengkap }}</div>
                            <div class="text-xs text-slate-500 font-mono">NIK: {{ $w->nik }}</div>
                            @if($w->no_hp)
                                <div class="text-xs text-emerald-700 font-bold mt-0.5">HP: {{ $w->no_hp }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-block px-2 py-0.5 rounded text-xs font-extrabold {{ $w->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-900' : 'bg-pink-100 text-pink-900' }}">
                                {{ $w->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                            <div class="text-xs text-slate-500 font-bold mt-1">{{ $w->usia }} tahun</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-slate-900 font-bold">{{ $w->keluarga->alamat ?? 'Perumahan Bumi Mutiara Indah II' }}</div>
                            <div class="text-xs text-slate-500 font-medium">{{ $w->status_hubungan_keluarga }} • {{ $w->pekerjaan }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($w->status_tinggal === 'tetap')
                                <span class="bg-emerald-100 text-emerald-900 font-extrabold px-2.5 py-1 rounded-md text-xs">Rumah Sendiri (Tetap)</span>
                            @else
                                <span class="bg-amber-100 text-amber-900 font-extrabold px-2.5 py-1 rounded-md text-xs">Kontrak / Kost</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($w->status_kependudukan === 'aktif')
                                <span class="text-emerald-700 font-extrabold text-xs flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                    <span>Aktif</span>
                                </span>
                            @elseif($w->status_kependudukan === 'pindah')
                                <span class="text-amber-800 font-extrabold text-xs block">Pindah Keluar</span>
                                <span class="text-[11px] text-slate-500">{{ $w->tgl_mutasi ? $w->tgl_mutasi->format('d/m/Y') : '' }}</span>
                            @else
                                <span class="text-rose-700 font-extrabold text-xs block">Meninggal</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('surat-pengantar.create', ['warga_id' => $w->id]) }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold shadow-sm flex items-center gap-1">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                    <span>Buat Surat</span>
                                </a>

                                <button type="button" @click="mutasiModalOpen = true; selectedWarga = '{{ $w->id }}'; selectedWargaNama = '{{ addslashes($w->nama_lengkap) }}'" class="p-1.5 bg-slate-100 hover:bg-amber-100 text-slate-700 hover:text-amber-800 rounded-lg text-xs font-bold" title="Catat Mutasi Pindah/Wafat">
                                    <i data-lucide="user-x" class="w-4 h-4"></i>
                                </button>

                                <a href="{{ route('warga.edit', $w) }}" class="p-1.5 bg-slate-100 hover:bg-blue-100 text-slate-700 hover:text-blue-800 rounded-lg text-xs font-bold" title="Edit Data">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-400 font-bold">
                            Tidak ada data warga yang sesuai pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($wargas->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $wargas->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Catat Mutasi Warga (Pindah / Meninggal) -->
    <div x-cloak x-show="mutasiModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="mutasiModalOpen = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="text-base font-extrabold text-slate-900">Perbarui Status Mutasi Warga</h3>
                    <button @click="mutasiModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <p class="text-sm text-slate-700 mb-4">
                    Nama Warga: <strong class="text-slate-900 text-base" x-text="selectedWargaNama"></strong>
                </p>

                <form :action="'{{ url('kependudukan/warga') }}/' + selectedWarga + '/mutasi'" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Status Kependudukan Baru:</label>
                        <select name="status_kependudukan" x-model="mutasiAction" class="w-full px-3 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold focus:ring-4 focus:ring-emerald-200">
                            <option value="pindah">Pindah Keluar dari RT 005</option>
                            <option value="meninggal">Meninggal Dunia</option>
                            <option value="aktif">Kembali Aktif Berdomisili</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Tanggal Peristiwa / Tanggal Lapor:</label>
                        <input type="date" name="tgl_mutasi" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-bold">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase mb-1">Keterangan / Tujuan Pindah:</label>
                        <textarea name="keterangan_mutasi" rows="3" required placeholder="Contoh: Pindah ke Karawang / Wafat di RS..." class="w-full px-3 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-sm font-medium"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="mutasiModalOpen = false" class="px-4 py-2 border border-slate-300 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-xs sm:text-sm font-extrabold rounded-xl hover:bg-emerald-700 shadow-sm">Simpan Mutasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
