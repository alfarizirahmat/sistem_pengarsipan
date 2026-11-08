@extends('layouts.app')

@section('title', 'Buku Induk Semua Arsip Surat RT')
@section('header_title', 'Buku Induk Semua Arsip Surat')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, activeLetter: null }">

    <!-- Header & Keterangan Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Buku Induk Arsip Semua Surat RT</h1>
            <p class="text-xs sm:text-sm text-slate-600 font-medium">Bapak-bapak pengurus dapat melihat isi semua surat (baik surat pengantar keluar maupun surat masuk) secara langsung di layar.</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('surat-pengantar.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs sm:text-sm font-black px-4 sm:px-5 py-3 rounded-2xl shadow-lg shadow-emerald-950/20 transition-all active:scale-95 w-full sm:w-auto">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>+ BUAT SURAT BARU</span>
            </a>
        </div>
    </div>

    <!-- 4 KARTU STATISTIK ARSIP BESAR & JELAS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Semua Surat -->
        <div class="bg-white rounded-3xl p-5 border-2 border-slate-200 shadow-sm">
            <span class="text-xs font-black uppercase text-slate-500 block">Total Arsip Surat</span>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">
                {{ $stats['total_semua'] }} <span class="text-xs font-bold text-slate-400">Berkas</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Tersimpan 10 tahun rapi</p>
        </div>

        <!-- Surat Pengantar Keluar -->
        <div class="bg-white rounded-3xl p-5 border-2 border-emerald-300 shadow-sm bg-emerald-50/40">
            <span class="text-xs font-black uppercase text-emerald-900 block">Surat Pengantar (Keluar)</span>
            <div class="text-2xl sm:text-3xl font-black text-emerald-800 mt-1">
                {{ $stats['total_pengantar'] }} <span class="text-xs font-bold text-emerald-600">Surat</span>
            </div>
            <p class="text-[11px] text-emerald-700 mt-1">Pelayanan warga ke desa</p>
        </div>

        <!-- Surat Masuk Instansi -->
        <div class="bg-white rounded-3xl p-5 border-2 border-blue-300 shadow-sm bg-blue-50/40">
            <span class="text-xs font-black uppercase text-blue-900 block">Surat Masuk (Desa/RW)</span>
            <div class="text-2xl sm:text-3xl font-black text-blue-800 mt-1">
                {{ $stats['total_masuk'] }} <span class="text-xs font-bold text-blue-600">Surat</span>
            </div>
            <p class="text-[11px] text-blue-700 mt-1">Buku agenda & disposisi</p>
        </div>

        <!-- Berkas Scan Digital -->
        <div class="bg-white rounded-3xl p-5 border-2 border-purple-300 shadow-sm bg-purple-50/40">
            <span class="text-xs font-black uppercase text-purple-900 block">Berkas Scan Digital</span>
            <div class="text-2xl sm:text-3xl font-black text-purple-800 mt-1">
                {{ $stats['total_scan'] }} <span class="text-xs font-bold text-purple-600">Foto/PDF</span>
            </div>
            <p class="text-[11px] text-purple-700 mt-1">Bisa dilihat langsung</p>
        </div>
    </div>

    <!-- TAB FILTER KATEGORI SURAT (1-KLIK) -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 border-2 border-slate-200/90 shadow-sm space-y-4">
        
        <div class="flex flex-wrap items-center gap-2 pb-2 border-b border-slate-100">
            <a href="{{ route('arsip.semua', array_merge(request()->except('kategori'), ['kategori' => 'semua'])) }}"
                class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-black transition-all flex items-center gap-2 {{ $kategori === 'semua' ? 'bg-slate-900 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                <i data-lucide="folders" class="w-4 h-4"></i>
                <span>Semua Surat (Gabungan)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $kategori === 'semua' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-800' }}">{{ $stats['total_semua'] }}</span>
            </a>

            <a href="{{ route('arsip.semua', array_merge(request()->except('kategori'), ['kategori' => 'pengantar'])) }}"
                class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-black transition-all flex items-center gap-2 {{ $kategori === 'pengantar' ? 'bg-emerald-600 text-white shadow-md' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                <i data-lucide="send" class="w-4 h-4"></i>
                <span>Surat Pengantar Keluar</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $kategori === 'pengantar' ? 'bg-white/20 text-white' : 'bg-emerald-200 text-emerald-900' }}">{{ $stats['total_pengantar'] }}</span>
            </a>

            <a href="{{ route('arsip.semua', array_merge(request()->except('kategori'), ['kategori' => 'masuk'])) }}"
                class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-black transition-all flex items-center gap-2 {{ $kategori === 'masuk' ? 'bg-blue-600 text-white shadow-md' : 'bg-blue-50 text-blue-800 hover:bg-blue-100' }}">
                <i data-lucide="inbox" class="w-4 h-4"></i>
                <span>Surat Masuk dari Luar</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $kategori === 'masuk' ? 'bg-white/20 text-white' : 'bg-blue-200 text-blue-900' }}">{{ $stats['total_masuk'] }}</span>
            </a>
        </div>

        <!-- Form Pencarian & Tahun Arsip -->
        <form action="{{ route('arsip.semua') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <input type="hidden" name="kategori" value="{{ $kategori }}">
            
            <div class="sm:col-span-3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama warga, instansi, nomor surat, atau perihal surat..."
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-600">
                </div>
            </div>

            <div>
                <select name="tahun" onchange="this.form.submit()" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-emerald-100 focus:border-emerald-600">
                    <option value="">Semua Tahun (10 Tahun)</option>
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>Tahun Arsip {{ $t }}</option>
                    @endforeach
                </select>
            </div>
        </form>

    </div>

    <!-- TABEL GABUNGAN SEMUA SURAT -->
    <div class="bg-white rounded-3xl border-2 border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-800">
                <thead class="bg-slate-100/90 border-b-2 border-slate-200 text-slate-700 font-black uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Kategori & No. Surat</th>
                        <th class="px-6 py-4">Pihak Terkait</th>
                        <th class="px-6 py-4">Perihal & Uraian</th>
                        <th class="px-6 py-4">Lemari Fisik</th>
                        <th class="px-6 py-4 text-center sticky right-0 bg-slate-100 z-10 shadow-[-12px_0_15px_-4px_rgba(0,0,0,0.08)]">Aksi & Lihat Surat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($sortedLetters as $letter)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <!-- Kolom 1: Kategori & No Surat -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($letter['kategori'] === 'pengantar')
                                <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-900 mb-1">
                                    <i data-lucide="send" class="w-3 h-3"></i> Surat Pengantar
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-900 mb-1">
                                    <i data-lucide="inbox" class="w-3 h-3"></i> Surat Masuk
                                </span>
                            @endif
                            <div class="font-black text-slate-900 font-mono text-sm">{{ $letter['nomor'] }}</div>
                            <div class="text-xs text-slate-500 font-bold">Tgl: {{ $letter['tanggal_formatted'] }}</div>
                        </td>

                        <!-- Kolom 2: Pihak Terkait -->
                        <td class="px-6 py-4">
                            <div class="font-black text-slate-900 text-base">{{ $letter['pihak'] }}</div>
                            <div class="text-xs text-slate-500 font-mono">{{ $letter['sub_pihak'] }}</div>
                        </td>

                        <!-- Kolom 3: Perihal & Ringkasan -->
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 text-xs sm:text-sm block">{{ $letter['perihal'] }}</span>
                            <p class="text-xs text-slate-600 line-clamp-2 mt-0.5 leading-relaxed">{{ $letter['ringkasan'] }}</p>
                            @if(!empty($letter['dokumen_hilang']))
                                <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 mt-1 inline-block">
                                    Hilang Banjir: {{ $letter['dokumen_hilang'] }}
                                </span>
                            @endif
                        </td>

                        <!-- Kolom 4: Lemari Fisik -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <i data-lucide="archive" class="w-4 h-4 text-emerald-600"></i>
                                <span>{{ $letter['lokasi_arsip_fisik'] }}</span>
                            </div>
                            <span class="text-[11px] text-slate-400 block font-mono">Tahun {{ $letter['tahun_arsip'] }}</span>
                        </td>

                        <!-- Kolom 5: Tombol Aksi Lihat Isi Surat -->
                        <td class="px-6 py-4 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-slate-50 z-10 shadow-[-12px_0_15px_-4px_rgba(0,0,0,0.08)]">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" @click="activeLetter = {{ Js::from($letter) }}; showModal = true"
                                    class="px-4 py-2.5 {{ $letter['kategori'] === 'pengantar' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded-xl text-xs font-black flex items-center gap-1.5 shadow-md transition-all active:scale-95">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    <span>LIHAT ISI SURAT</span>
                                </button>

                                <a href="{{ $letter['print_url'] }}" target="_blank"
                                    class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors" title="Cetak Surat">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold">
                            <i data-lucide="file-question" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                            <p>Tidak ada arsip surat yang sesuai dengan pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL PRATINJAU DOKUMEN UNIVERSAL (BISA MELIHAT SURAT APA PUN SECARA LANGSUNG) -->
    <div x-show="showModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-3 sm:p-6"
         style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px);">
        
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-4xl overflow-hidden my-4 sm:my-8"
             @click.away="showModal = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Modal Header Toolbar -->
            <!-- Modal Header Toolbar -->
            <div class="px-4 sm:px-6 py-3.5 sm:py-4 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800 gap-2">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <span class="w-2.5 h-2.5 rounded-full animate-pulse flex-shrink-0" :class="activeLetter && activeLetter.kategori === 'pengantar' ? 'bg-emerald-400' : 'bg-blue-400'"></span>
                    <div class="min-w-0">
                        <h3 class="font-black text-xs sm:text-sm text-white truncate" x-text="activeLetter ? (activeLetter.kategori === 'pengantar' ? 'Pratinjau Surat Pengantar Warga' : 'Pratinjau Surat Masuk & Disposisi') : ''"></h3>
                        <p class="text-[10px] text-slate-400 font-mono truncate" x-text="activeLetter ? 'No: ' + activeLetter.nomor : ''"></p>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">
                    <template x-if="activeLetter">
                        <a :href="activeLetter.print_url" target="_blank"
                            class="px-3 sm:px-3.5 py-1.5 sm:py-2 text-white text-xs font-black rounded-xl shadow flex items-center gap-1.5 transition-colors whitespace-nowrap"
                            :class="activeLetter.kategori === 'pengantar' ? 'bg-emerald-600 hover:bg-emerald-500' : 'bg-blue-600 hover:bg-blue-500'">
                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                            <span class="hidden sm:inline">Cetak Dokumen</span>
                            <span class="sm:hidden">Cetak</span>
                        </a>
                    </template>
                    <button type="button" @click="showModal = false" 
                        class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body Content -->
            <div class="p-3 sm:p-8 overflow-y-auto max-h-[75vh] bg-slate-100/70">
                
                <!-- JIKA SURAT PENGANTAR (KELUAR) -->
                <template x-if="activeLetter && activeLetter.kategori === 'pengantar'">
                    <div class="overflow-x-auto pb-2">
                        <div class="min-w-[300px] max-w-3xl mx-auto bg-white p-4 sm:p-10 rounded-2xl shadow border border-slate-300 text-slate-900 font-serif leading-relaxed">
                        <!-- KOP SURAT PEMERINTAHAN DESA / RT RESMI -->
                        <div class="flex items-center justify-between pb-2 border-b-[2px] border-black">
                            <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center">
                                <svg viewBox="0 0 100 100" class="w-10 h-10 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-center px-1">
                                <h4 class="text-[9px] font-bold uppercase tracking-widest text-black leading-none">RUKUN TETANGGA 005 / RUKUN WARGA 013</h4>
                                <h5 class="text-[8px] font-bold uppercase tracking-wider text-black leading-none mt-0.5">PERUMAHAN BUMI MUTIARA INDAH II</h5>
                                <h3 class="text-xs font-black uppercase tracking-wider text-black leading-tight mt-0.5">BUKU ARSIP SURAT RESMI</h3>
                                <p class="text-[7.5px] italic text-slate-700 font-sans leading-none mt-0.5">Sekretariat: Perumahan Bumi Mutiara Indah II Blok B3 No. 12 RT 005 / RW 013</p>
                            </div>
                            <div class="w-10 h-10 flex-shrink-0 hidden sm:flex items-center justify-center">
                                <div class="w-8 h-8 rounded-full border border-black flex flex-col items-center justify-center text-[5.5px] font-black uppercase leading-none">
                                    <span>RT 005</span>
                                    <span>RW 013</span>
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-black mb-4 mt-0.5"></div>

                        <!-- Judul & Nomor Surat -->
                        <div class="text-center mb-5">
                            <h4 class="text-base font-bold uppercase underline tracking-wider">SURAT PENGANTAR</h4>
                            <p class="text-xs font-bold font-mono mt-0.5" x-text="'Nomor: ' + activeLetter.nomor"></p>
                        </div>

                        <p class="text-xs sm:text-sm text-justify mb-3">
                            Yang bertanda tangan di bawah ini, Ketua Rukun Tetangga (RT) 005 / RW 013 Perumahan Bumi Mutiara Indah II menerangkan bahwa:
                        </p>

                        <!-- Identitas Warga -->
                        <template x-if="activeLetter.warga">
                            <div class="text-xs sm:text-sm mb-4 pl-2 sm:pl-4 space-y-1 font-sans">
                                <div class="grid grid-cols-12">
                                    <span class="col-span-4 text-slate-500">Nama Lengkap</span>
                                    <span class="col-span-1">:</span>
                                    <strong class="col-span-7 uppercase text-slate-900" x-text="activeLetter.warga.nama_lengkap"></strong>
                                </div>
                                <div class="grid grid-cols-12">
                                    <span class="col-span-4 text-slate-500">NIK</span>
                                    <span class="col-span-1">:</span>
                                    <strong class="col-span-7 font-mono" x-text="activeLetter.warga.nik"></strong>
                                </div>
                                <div class="grid grid-cols-12">
                                    <span class="col-span-4 text-slate-500">Alamat Domisili</span>
                                    <span class="col-span-1">:</span>
                                    <span class="col-span-7" x-text="activeLetter.warga.keluarga ? activeLetter.warga.keluarga.alamat : 'Perumahan Bumi Mutiara Indah II, RT 005 / RW 013'"></span>
                                </div>
                                <div class="grid grid-cols-12">
                                    <span class="col-span-4 text-slate-500">Status Tinggal</span>
                                    <span class="col-span-1">:</span>
                                    <span class="col-span-7 capitalize font-semibold text-emerald-800" x-text="activeLetter.warga.status_tinggal + ' di RT 005 / RW 013'"></span>
                                </div>
                            </div>
                        </template>

                        <p class="text-xs sm:text-sm text-justify mb-2">
                            Surat pengantar ini diberikan untuk keperluan:
                        </p>

                        <div class="text-xs sm:text-sm font-semibold border-l-4 border-emerald-600 pl-4 py-2.5 my-3 bg-slate-50 italic rounded-r" x-text="activeLetter.ringkasan">
                        </div>

                        <template x-if="activeLetter.dokumen_hilang">
                            <div class="text-xs my-3 p-3 border border-dashed border-amber-500 bg-amber-50 rounded-xl font-sans">
                                <strong class="text-amber-900 block mb-0.5">Dokumen Hilang / Rusak (Banjir):</strong>
                                <span class="text-amber-950 font-bold" x-text="activeLetter.dokumen_hilang"></span>
                            </div>
                        </template>

                        <!-- Tanda Tangan & Cap Stempel -->
                        <div class="grid grid-cols-2 gap-4 text-xs sm:text-sm text-center pt-4 border-t border-slate-200 mt-6">
                            <div>
                                <p class="mb-1 text-xs">Pemohon / Warga,</p>
                                <div class="h-20 flex items-end justify-center pb-1">
                                    <span class="text-[9px] text-slate-400 italic">[ Tanda Tangan ]</span>
                                </div>
                                <p class="font-bold underline uppercase" x-text="activeLetter.pihak"></p>
                            </div>
                            <div>
                                <p class="mb-0.5 text-xs" x-text="'Bumi Mutiara Indah II, ' + activeLetter.tanggal_formatted"></p>
                                <p class="font-bold text-xs uppercase" x-text="activeLetter.penandatangan_jabatan"></p>

                                <div class="h-20 flex items-center justify-center relative my-1">
                                    <!-- Foto TTD -->
                                    <template x-if="activeLetter.tanda_tangan_url">
                                        <div class="relative flex items-center justify-center">
                                            <div class="w-16 h-16 rounded-full border-2 border-indigo-900 text-indigo-900 text-[5px] font-bold flex flex-col items-center justify-center rotate-[-12deg] bg-indigo-50/50 absolute z-0 opacity-80 pointer-events-none">
                                                <span>★ PENGURUS RT ★</span>
                                                <span class="font-black text-[6.5px]">RT 005 / RW 013</span>
                                                <span>BUMI MUTIARA INDAH II</span>
                                            </div>
                                            <img :src="activeLetter.tanda_tangan_url" class="h-14 max-w-[130px] object-contain relative z-10" alt="Foto TTD">
                                        </div>
                                    </template>

                                    <!-- QR Code -->
                                    <template x-if="!activeLetter.tanda_tangan_url && activeLetter.qr_token">
                                        <div class="flex items-center gap-2 p-1.5 border border-slate-300 rounded bg-slate-50 relative z-10 shadow-sm font-sans">
                                            <i data-lucide="qr-code" class="w-8 h-8 text-slate-800 inline"></i>
                                            <div class="text-left text-[8px] leading-tight">
                                                <div class="font-bold text-emerald-800">TTD DIGITAL SAH</div>
                                                <div class="font-mono text-slate-600" x-text="activeLetter.qr_token"></div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Basah Manual -->
                                    <template x-if="!activeLetter.tanda_tangan_url && !activeLetter.qr_token">
                                        <div class="relative flex items-center justify-center">
                                            <div class="w-16 h-16 rounded-full border border-dashed border-slate-400 text-slate-400 text-[6px] font-bold flex flex-col items-center justify-center rotate-[-8deg] absolute z-0">
                                                <span>[ STEMPEL RT ]</span>
                                            </div>
                                            <span class="text-[9px] text-slate-400 italic relative z-10">[ TTD Basah ]</span>
                                        </div>
                                    </template>
                                </div>

                                <p class="font-bold underline uppercase tracking-wider" x-text="activeLetter.penandatangan_nama"></p>
                            </div>
                        </div>

                    </div>
                    </div>
                </template>

                <!-- JIKA SURAT MASUK (DESA / RW / INSTANSI) -->
                <template x-if="activeLetter && activeLetter.kategori === 'masuk'">
                    <div class="space-y-6">
                        <!-- Lembar Disposisi RT -->
                        <div class="overflow-x-auto pb-2">
                            <div class="min-w-[300px] max-w-3xl mx-auto bg-white p-4 sm:p-10 rounded-2xl shadow border border-slate-300 text-slate-900 font-serif leading-relaxed">
                            <div class="text-center pb-2 border-b-2 border-double border-black">
                                <h2 class="text-base font-black uppercase tracking-widest leading-tight">PENGURUS RUKUN TETANGGA 005 / RW 013</h2>
                                <h3 class="text-xs font-bold uppercase tracking-wider leading-tight">PERUMAHAN BUMI MUTIARA INDAH II</h3>
                            </div>

                            <div class="text-center my-3">
                                <h4 class="text-base font-bold uppercase underline tracking-wider">LEMBAR DISPOSISI SURAT MASUK</h4>
                                <p class="text-xs font-bold font-mono mt-0.5" x-text="'NO. AGENDA: ' + activeLetter.nomor"></p>
                            </div>

                            <div class="border border-black text-xs font-sans mb-4">
                                <div class="grid grid-cols-2 border-b border-black">
                                    <div class="p-3 border-r border-black">
                                        <span class="text-slate-500 block text-[10px] uppercase font-bold">Instansi Pengirim:</span>
                                        <strong class="text-sm text-slate-900 block" x-text="activeLetter.pihak"></strong>
                                    </div>
                                    <div class="p-3">
                                        <span class="text-slate-500 block text-[10px] uppercase font-bold">Diterima Tanggal:</span>
                                        <strong class="text-sm text-slate-900 block" x-text="activeLetter.tanggal_formatted"></strong>
                                    </div>
                                </div>

                                <div class="p-3 border-b border-black">
                                    <span class="text-slate-500 block text-[10px] uppercase font-bold">Perihal / Hal Surat:</span>
                                    <strong class="text-sm text-slate-900 block" x-text="activeLetter.perihal"></strong>
                                </div>

                                <div class="p-3">
                                    <span class="text-slate-500 block text-[10px] uppercase font-bold">Ringkasan Isi Surat:</span>
                                    <p class="text-xs text-justify mt-1 text-slate-800 font-serif" x-text="activeLetter.ringkasan"></p>
                                </div>
                            </div>

                            <!-- Arahan Disposisi -->
                            <div class="border-2 border-blue-600 p-4 mb-3 bg-blue-50/60 rounded-xl font-sans">
                                <span class="text-xs font-black uppercase tracking-wider text-blue-900 block mb-1">
                                    Instruksi Disposisi / Tindak Lanjut Ketua RT:
                                </span>
                                <div class="text-xs sm:text-sm font-bold text-blue-950 italic p-2.5 bg-white rounded-lg border border-blue-200" x-text="activeLetter.disposisi || 'Diteruskan ke seksi terkait.'">
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs font-sans text-slate-500 pt-2 border-t border-slate-200">
                                <span>Posisi Fisik di Lemari: <strong class="text-slate-900" x-text="activeLetter.lokasi_arsip_fisik"></strong></span>
                                <span class="font-mono" x-text="'Arsip ' + activeLetter.tahun_arsip"></span>
                            </div>
                        </div>
                        </div>

                        <!-- Berkas Scan Asli (Jika Ada) -->
                        <template x-if="activeLetter.file_lampiran">
                            <div class="max-w-3xl mx-auto bg-white p-4 rounded-2xl border-2 border-slate-300 shadow space-y-3">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                        <i data-lucide="file-text" class="w-4 h-4 text-emerald-600"></i>
                                        <span>Berkas Scan Dokumen Asli Terlampir</span>
                                    </span>
                                    <a :href="'/storage/' + activeLetter.file_lampiran" target="_blank" download class="px-3 py-1 bg-emerald-600 text-white rounded-lg text-xs font-bold flex items-center gap-1">
                                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                        <span>Unduh Berkas</span>
                                    </a>
                                </div>
                                <div class="bg-slate-950 rounded-xl overflow-hidden p-2 text-center max-h-[550px] flex items-center justify-center">
                                    <img :src="'/storage/' + activeLetter.file_lampiran" alt="Scan Surat Masuk" class="max-h-[530px] max-w-full object-contain rounded">
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

            </div>

            <!-- Modal Bottom Bar (Ringkas & Bersih) -->
            <div class="px-5 sm:px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end">
                <button type="button" @click="showModal = false" 
                    class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 text-xs font-bold rounded-xl transition-colors">
                    Tutup Pratinjau
                </button>
            </div>

        </div>
    </div>

</div>
@endsection

