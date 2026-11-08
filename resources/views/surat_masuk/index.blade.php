@extends('layouts.app')

@section('title', 'Buku Agenda Surat Masuk')
@section('header_title', 'Arsip Surat Masuk RT')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, activeSurat: null, previewTab: 'disposisi' }">

    <!-- Header & Tombol Tambah Surat Masuk -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Buku Agenda Arsip Surat Masuk</h1>
            <p class="text-xs sm:text-sm text-slate-600 font-medium">Pencatatan surat masuk dari Pemerintah Desa, RW, Puskesmas, Kepolisian, dan instansi lainnya.</p>
        </div>
        <a href="{{ route('surat-masuk.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs sm:text-sm font-black px-4 sm:px-6 py-3 sm:py-3.5 rounded-2xl shadow-lg shadow-blue-950/20 transition-all active:scale-95 w-full sm:w-auto">
            <i data-lucide="plus-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
            <span>+ CATAT SURAT MASUK</span>
        </a>
    </div>

    <!-- Kotak Pencarian & Filter Sederhana -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border-2 border-slate-200/90 shadow-sm">
        <form action="{{ route('surat-masuk.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Cari Nomor Agenda, Pengirim, atau Perihal:</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik instansi pengirim, perihal surat, atau nomor agenda..."
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Pilih Tahun Agenda:</label>
                <select name="tahun" onchange="this.form.submit()" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-100 focus:border-blue-600">
                    <option value="">Semua Tahun Agenda</option>
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>Tahun Agenda {{ $t }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Tabel Surat Masuk -->
    <div class="bg-white rounded-3xl border-2 border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-800">
                <thead class="bg-slate-100/90 border-b-2 border-slate-200 text-slate-700 font-black uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No. Agenda & Terima</th>
                        <th class="px-6 py-4">Instansi Pengirim & Asli</th>
                        <th class="px-6 py-4">Perihal & Pokok Isi</th>
                        <th class="px-6 py-4">Disposisi RT</th>
                        <th class="px-6 py-4">Posisi Lemari Fisik</th>
                        <th class="px-6 py-4 text-center sticky right-0 bg-slate-100 z-10 shadow-[-12px_0_15px_-4px_rgba(0,0,0,0.08)]">Aksi & Lihat Berkas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($suratMasuks as $sm)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-black text-slate-900 font-mono text-sm block">{{ $sm->nomor_agenda }}</span>
                            <span class="text-xs text-slate-500 font-bold">Diterima: {{ $sm->tanggal_terima->format('d/m/Y') }}</span>
                            @if($sm->file_lampiran)
                                <span class="inline-flex items-center gap-1 text-[10px] font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 mt-1">
                                    <i data-lucide="paperclip" class="w-3 h-3"></i> Ada Berkas Scan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-black text-slate-900 text-base">{{ $sm->pengirim }}</div>
                            <div class="text-xs text-slate-600 font-mono font-bold">No: {{ $sm->nomor_surat_pengirim }}</div>
                            <div class="text-[11px] text-slate-400">Tgl Tertera: {{ $sm->tanggal_surat->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-extrabold text-slate-900 text-sm block">{{ $sm->perihal }}</span>
                            @if($sm->ringkasan_isi)
                                <p class="text-xs text-slate-600 line-clamp-2 mt-1 leading-relaxed">{{ $sm->ringkasan_isi }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($sm->disposisi)
                                <span class="bg-blue-50 text-blue-900 font-extrabold px-3 py-1 rounded-xl text-xs border border-blue-200 inline-block leading-tight">
                                    {{ $sm->disposisi }}
                                </span>
                            @else
                                <span class="text-slate-400 text-xs italic">- Belum ada -</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <i data-lucide="archive" class="w-4 h-4 text-blue-600"></i>
                                <span>{{ $sm->lokasi_arsip_fisik ?: 'Ordner Surat Masuk' }}</span>
                            </div>
                            <span class="text-[11px] text-slate-400 block font-mono">Tahun {{ $sm->tahun_arsip }}</span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-slate-50 z-10 shadow-[-12px_0_15px_-4px_rgba(0,0,0,0.08)]">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Tombol Lihat Berkas Masuk Langsung (In-page Viewer) -->
                                <button type="button" @click="activeSurat = {{ Js::from($sm) }}; previewTab = (activeSurat.file_lampiran ? 'scan' : 'disposisi'); showModal = true" 
                                    class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-black flex items-center gap-1.5 shadow-md shadow-blue-950/20 transition-all active:scale-95">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    <span>LIHAT BERKAS</span>
                                </button>
                                
                                <a href="{{ route('surat-masuk.show', $sm) }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors" title="Buka Detail">
                                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('surat-masuk.destroy', $sm) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip surat masuk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-700 rounded-xl transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-bold">
                            <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                            <p>Belum ada catatan surat masuk yang cocok.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratMasuks->hasPages())
            <div class="p-5 border-t border-slate-200">
                {{ $suratMasuks->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL PRATINJAU SURAT MASUK LANGSUNG (IN-PAGE DOCUMENT VIEWER) -->
    <div x-show="showModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
         style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px);">
        
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-5xl overflow-hidden my-8"
             @click.away="showModal = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Modal Header Toolbar -->
            <div class="px-4 sm:px-6 py-3.5 sm:py-4 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800 gap-2">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-400 animate-pulse flex-shrink-0"></span>
                    <div class="min-w-0">
                        <h3 class="font-black text-xs sm:text-sm text-white truncate">Pratinjau Berkas Surat Masuk & Disposisi</h3>
                        <p class="text-[10px] text-slate-400 font-mono truncate" x-text="activeSurat ? 'Agenda: ' + activeSurat.nomor_agenda + ' • Dari: ' + activeSurat.pengirim : ''"></p>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">
                    <template x-if="activeSurat">
                        <a :href="'/surat-masuk/' + activeSurat.id + '/print'" target="_blank"
                            class="px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-black rounded-xl shadow flex items-center gap-1.5 transition-colors whitespace-nowrap">
                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                            <span class="hidden sm:inline">Cetak Disposisi</span>
                            <span class="sm:hidden">Cetak</span>
                        </a>
                    </template>
                    <button type="button" @click="showModal = false" 
                        class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Tab Switcher di Dalam Modal (Disposisi vs Berkas Lampiran Scan) -->
            <div class="bg-slate-100 px-4 sm:px-6 py-2.5 sm:py-3 border-b border-slate-200 flex flex-wrap sm:flex-nowrap items-center justify-between gap-2">
                <div class="flex items-center gap-1.5 sm:gap-2 w-full sm:w-auto">
                    <button type="button" @click="previewTab = 'disposisi'"
                        :class="previewTab === 'disposisi' ? 'bg-white text-blue-900 shadow font-black border-blue-300' : 'text-slate-600 font-bold hover:bg-white/50'"
                        class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 rounded-xl text-xs border transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="clipboard-list" class="w-3.5 h-3.5 text-blue-600"></i>
                        <span>Lembar Disposisi</span>
                    </button>

                    <button type="button" @click="previewTab = 'scan'"
                        :class="previewTab === 'scan' ? 'bg-white text-emerald-900 shadow font-black border-emerald-300' : 'text-slate-600 font-bold hover:bg-white/50'"
                        class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 rounded-xl text-xs border transition-all flex items-center justify-center gap-1.5">
                        <i data-lucide="file-text" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>Berkas Scan Dokumen Asli</span>
                        <template x-if="activeSurat && activeSurat.file_lampiran">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </template>
                    </button>
                </div>

                <div class="text-[11px] sm:text-xs font-bold text-slate-500">
                    Lokasi: <span class="text-slate-900 font-mono" x-text="activeSurat ? activeSurat.lokasi_arsip_fisik : '-'"></span>
                </div>
            </div>

            <!-- Modal Body Content -->
            <div class="p-3 sm:p-8 overflow-y-auto max-h-[72vh] bg-slate-50">
                
                <!-- TAB 1: LEMBAR DISPOSISI RESMI RT -->
                <div x-show="previewTab === 'disposisi'" class="overflow-x-auto pb-2">
                    <div class="min-w-[300px] max-w-3xl mx-auto bg-white p-4 sm:p-10 rounded-2xl shadow border border-slate-300 text-slate-900 font-serif leading-relaxed">
                    <!-- Kop RT -->
                    <div class="text-center pb-2 border-b-2 border-double border-black">
                        <h2 class="text-base font-black uppercase tracking-widest leading-tight">PENGURUS RUKUN TETANGGA 005 / RUKUN WARGA 013</h2>
                        <h3 class="text-xs font-bold uppercase tracking-wider leading-tight">PERUMAHAN BUMI MUTIARA INDAH II</h3>
                        <p class="text-[10px] italic text-slate-600 font-sans mt-0.5">Sekretariat: Perumahan Bumi Mutiara Indah II Blok B3 No. 12 RT 005 / RW 013</p>
                    </div>

                    <div class="text-center my-4">
                        <h4 class="text-base font-bold uppercase underline tracking-wider">LEMBAR DISPOSISI SURAT MASUK</h4>
                        <p class="text-xs font-bold font-mono mt-0.5" x-text="activeSurat ? 'NO. AGENDA: ' + activeSurat.nomor_agenda : ''"></p>
                    </div>

                    <!-- Tabel Info Surat Masuk -->
                    <div class="border border-black text-xs font-sans mb-4">
                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-3 border-r border-black">
                                <span class="text-slate-500 block text-[10px] uppercase font-bold">Instansi Pengirim:</span>
                                <strong class="text-sm text-slate-900 block" x-text="activeSurat ? activeSurat.pengirim : ''"></strong>
                            </div>
                            <div class="p-3">
                                <span class="text-slate-500 block text-[10px] uppercase font-bold">Diterima Tanggal:</span>
                                <strong class="text-sm text-slate-900 block" x-text="activeSurat ? activeSurat.tanggal_terima.substring(0, 10) : ''"></strong>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 border-b border-black">
                            <div class="p-3 border-r border-black">
                                <span class="text-slate-500 block text-[10px] uppercase font-bold">Nomor Surat Asli:</span>
                                <strong class="font-mono text-slate-900 block" x-text="activeSurat ? activeSurat.nomor_surat_pengirim : ''"></strong>
                            </div>
                            <div class="p-3">
                                <span class="text-slate-500 block text-[10px] uppercase font-bold">Tanggal Surat Asli:</span>
                                <span class="text-slate-900 block" x-text="activeSurat ? activeSurat.tanggal_surat.substring(0, 10) : ''"></span>
                            </div>
                        </div>

                        <div class="p-3 border-b border-black">
                            <span class="text-slate-500 block text-[10px] uppercase font-bold">Perihal / Hal Surat:</span>
                            <strong class="text-sm text-slate-900 block" x-text="activeSurat ? activeSurat.perihal : ''"></strong>
                        </div>

                        <div class="p-3">
                            <span class="text-slate-500 block text-[10px] uppercase font-bold">Ringkasan / Pokok Isi Surat:</span>
                            <p class="text-xs text-justify mt-1 text-slate-800 leading-relaxed font-serif" x-text="activeSurat ? activeSurat.ringkasan_isi : 'Tidak ada ringkasan teks.'"></p>
                        </div>
                    </div>

                    <!-- Kotak Disposisi & Tindak Lanjut -->
                    <div class="border-2 border-blue-600 p-4 mb-4 bg-blue-50/50 rounded-xl font-sans">
                        <span class="text-xs font-black uppercase tracking-wider text-blue-900 block mb-1">
                            Instruksi Disposisi / Tindak Lanjut Ketua RT 005:
                        </span>
                        <div class="text-sm font-bold text-blue-950 italic p-3 bg-white rounded-lg border border-blue-200" x-text="activeSurat && activeSurat.disposisi ? activeSurat.disposisi : 'Diteruskan ke seksi terkait.'">
                        </div>
                    </div>

                    <!-- Info Lemari & Tanda Tangan -->
                    <div class="grid grid-cols-2 gap-4 text-xs font-sans pt-2">
                        <div class="p-3 border border-slate-300 rounded-xl bg-slate-50">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Lokasi Lemari Berkas Fisik:</span>
                            <strong class="text-slate-900" x-text="activeSurat ? activeSurat.lokasi_arsip_fisik : 'Ordner RT'"></strong>
                        </div>
                        <div class="text-center font-serif">
                            <span class="text-[11px]" x-text="activeSurat ? 'Bumi Mutiara Indah II, ' + activeSurat.tanggal_terima.substring(0, 10) : ''"></span><br>
                            <strong class="text-xs">Ketua RT 005 / RW 013</strong>
                            <div class="h-12 flex items-center justify-center">
                                <span class="text-[8px] text-blue-800 font-bold">[ CAP STEMPEL RT 005 ]</span>
                            </div>
                            <strong class="underline block uppercase font-bold">HARTONO</strong>
                        </div>
                    </div>
                </div>
                </div>

                <!-- TAB 2: PRATINJAU BERKAS SCAN ASLI -->
                <div x-show="previewTab === 'scan'" class="max-w-3xl mx-auto space-y-4">
                    <template x-if="activeSurat && activeSurat.file_lampiran">
                        <div class="bg-white p-4 rounded-2xl border-2 border-slate-300 shadow-lg space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="image" class="w-5 h-5 text-emerald-600"></i>
                                    <span class="text-xs font-bold text-slate-800" x-text="'Berkas: ' + activeSurat.file_lampiran"></span>
                                </div>
                                <a :href="'/storage/' + activeSurat.file_lampiran" target="_blank" download class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center gap-1 shadow">
                                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                    <span>Unduh Dokumen</span>
                                </a>
                            </div>

                            <!-- Preview Container -->
                            <div class="bg-slate-900 rounded-xl overflow-hidden p-2 text-center max-h-[600px] flex items-center justify-center">
                                <img :src="'/storage/' + activeSurat.file_lampiran" alt="Dokumen Surat Masuk" class="max-h-[580px] max-w-full object-contain rounded shadow">
                            </div>
                        </div>
                    </template>

                    <template x-if="!activeSurat || !activeSurat.file_lampiran">
                        <div class="bg-white p-12 rounded-3xl border-2 border-dashed border-slate-300 text-center space-y-3">
                            <i data-lucide="archive" class="w-16 h-16 text-slate-300 mx-auto"></i>
                            <h4 class="text-sm font-black text-slate-800">Berkas Fisik Tersimpan di Lemari RT</h4>
                            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                                Surat masuk ini dicatat dalam agenda dan berkas kertas aslinya disimpan rapi di: <br>
                                <strong class="text-slate-900 text-sm font-mono mt-1 inline-block" x-text="activeSurat ? activeSurat.lokasi_arsip_fisik : 'Ordner Surat Masuk'"></strong>
                            </p>
                            <div class="pt-2">
                                <button type="button" @click="previewTab = 'disposisi'" class="px-4 py-2 bg-blue-50 text-blue-800 font-bold text-xs rounded-xl border border-blue-200">
                                    Lihat Lembar Disposisi RT &rarr;
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

            </div>

            <!-- Modal Bottom Bar (Ringkas & Bersih) -->
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end">
                <button type="button" @click="showModal = false" 
                    class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 text-xs font-bold rounded-xl transition-colors">
                    Tutup Pratinjau
                </button>
            </div>

        </div>
    </div>

</div>
@endsection
