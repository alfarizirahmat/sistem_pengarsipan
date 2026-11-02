@extends('layouts.app')

@section('title', 'Buku Arsip Surat Pengantar')
@section('header_title', 'Buku Arsip Surat Pengantar RT')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, activeSurat: null }">

    <!-- Header & Tombol Tambah Surat -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Buku Arsip Surat Pengantar RT</h1>
            <p class="text-xs sm:text-sm text-slate-600 font-medium">Bapak-bapak pengurus dapat mencari arsip 10 tahun ke belakang, melihat berkas langsung di layar, dan mencetak dengan 1-klik.</p>
        </div>
        <a href="{{ route('surat-pengantar.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-sm font-black px-6 py-3.5 rounded-2xl shadow-lg shadow-emerald-950/20 transition-all active:scale-95">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>+ BUAT SURAT BARU</span>
        </a>
    </div>

    <!-- Kotak Pencarian Besar & Sederhana untuk Bapak-bapak -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border-2 border-slate-200/90 shadow-sm">
        <form action="{{ route('surat-pengantar.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Cari Nama Warga / No. Surat:</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama warga atau nomor surat..."
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-600">
                </div>
            </div>

            <!-- Filter Tahun Arsip (10 Tahun Sesuai Wawancara RT) -->
            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Pilih Tahun Arsip:</label>
                <select name="tahun" onchange="this.form.submit()" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-emerald-100 focus:border-emerald-600">
                    <option value="">Semua Tahun Arsip (10 Tahun)</option>
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>Tahun Arsip {{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-700 uppercase tracking-wider mb-1.5">Kategori Keperluan:</label>
                <select name="jenis" onchange="this.form.submit()" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-300 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-emerald-100 focus:border-emerald-600">
                    <option value="">Semua Jenis Surat</option>
                    <option value="kehilangan_dokumen" {{ $jenis === 'kehilangan_dokumen' ? 'selected' : '' }}>Hilang Kena Banjir / Musibah</option>
                    <option value="ktp_baru" {{ $jenis === 'ktp_baru' ? 'selected' : '' }}>Pembuatan KTP Baru</option>
                    <option value="perubahan_kk" {{ $jenis === 'perubahan_kk' ? 'selected' : '' }}>Ubah KK (Kelahiran Baru)</option>
                    <option value="keterangan_domisili" {{ $jenis === 'keterangan_domisili' ? 'selected' : '' }}>Keterangan Domisili</option>
                    <option value="pindah_domisili" {{ $jenis === 'pindah_domisili' ? 'selected' : '' }}>Pindah Keluar Lingkungan</option>
                    <option value="sktm" {{ $jenis === 'sktm' ? 'selected' : '' }}>SKTM (Tidak Mampu)</option>
                    <option value="sku" {{ $jenis === 'sku' ? 'selected' : '' }}>SKU (Keterangan Usaha)</option>
                    <option value="kematian" {{ $jenis === 'kematian' ? 'selected' : '' }}>Kematian</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Tabel Arsip Surat Pengantar -->
    <div class="bg-white rounded-3xl border-2 border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-800">
                <thead class="bg-slate-100/90 border-b-2 border-slate-200 text-slate-700 font-black uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nomor & Tanggal Surat</th>
                        <th class="px-6 py-4">Nama Warga Pemohon</th>
                        <th class="px-6 py-4">Keperluan & Jenis</th>
                        <th class="px-6 py-4">Posisi Lemari Fisik</th>
                        <th class="px-6 py-4 text-center sticky right-0 bg-slate-100 z-10 shadow-[-12px_0_15px_-4px_rgba(0,0,0,0.08)]">Aksi & Lihat Surat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($surats as $s)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-black text-slate-900 font-mono text-sm block">{{ $s->nomor_surat }}</span>
                            <span class="text-xs text-slate-500 font-bold">Tgl Terbit: {{ $s->tanggal_surat->format('d/m/Y') }}</span>
                            @if($s->tanda_tangan_jenis === 'digital')
                                <span class="inline-flex items-center gap-1 text-[10px] font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 mt-1">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> TTD Online
                                </span>
                            @elseif($s->tanda_tangan_jenis === 'qrcode')
                                <span class="inline-flex items-center gap-1 text-[10px] font-black text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200 mt-1">
                                    <i data-lucide="qr-code" class="w-3 h-3"></i> QR Barcode
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full mt-1">
                                    ✍️ TTD Basah
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-black text-slate-900 text-base">{{ $s->warga->nama_lengkap ?? 'Warga' }}</div>
                            <div class="text-xs text-slate-500 font-mono font-bold">NIK: {{ $s->warga->nik ?? '-' }}</div>
                            <div class="text-xs text-slate-600 truncate max-w-xs">{{ $s->warga->keluarga->alamat ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-extrabold bg-emerald-100 text-emerald-900 mb-1">
                                {{ $s->label_jenis_surat }}
                            </span>
                            <p class="text-xs text-slate-600 line-clamp-2">{{ $s->keperluan }}</p>
                            @if($s->dokumen_hilang)
                                <span class="text-[11px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 mt-1 inline-block">
                                    Hilang Banjir: {{ $s->dokumen_hilang }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold text-slate-700 text-xs flex items-center gap-1.5">
                                <i data-lucide="archive" class="w-4 h-4 text-emerald-600"></i>
                                <span>{{ $s->lokasi_arsip_fisik ?? 'Map Arsip RT' }}</span>
                            </span>
                            <span class="text-[11px] text-slate-400 block font-mono">Arsip Tahun {{ $s->tahun_arsip }}</span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-slate-50 z-10 shadow-[-12px_0_15px_-4px_rgba(0,0,0,0.08)]">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Tombol Lihat Berkas Langsung (In-page Viewer) -->
                                <button type="button" @click="activeSurat = {{ Js::from($s) }}; showModal = true" 
                                    class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black flex items-center gap-1.5 shadow-md shadow-emerald-950/20 transition-all active:scale-95">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    <span>LIHAT SURAT</span>
                                </button>
                                <!-- Tombol Cetak Langsung -->
                                <a href="{{ route('surat-pengantar.print', $s) }}" target="_blank" 
                                    class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold flex items-center gap-1 transition-colors" title="Buka format cetak A4">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                    <span>Cetak</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold">
                            <i data-lucide="file-question" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                            <p>Tidak ada surat pengantar yang cocok dengan pencarian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($surats->hasPages())
            <div class="p-5 border-t border-slate-200">
                {{ $surats->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL PRATINJAU SURAT LANGSUNG (IN-PAGE DOCUMENT VIEWER) -->
    <div x-show="showModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
         style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px);">
        
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-4xl overflow-hidden my-8"
             @click.away="showModal = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Modal Header Toolbar -->
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                    <div>
                        <h3 class="font-black text-sm text-white">Pratinjau Berkas Dokumen Resmi RT 03</h3>
                        <p class="text-[11px] text-slate-400 font-mono" x-text="activeSurat ? 'No: ' + activeSurat.nomor_surat : ''"></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <template x-if="activeSurat">
                        <a :href="'/surat-pengantar/' + activeSurat.id + '/print'" target="_blank"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black rounded-xl shadow flex items-center gap-1.5 transition-colors">
                            <i data-lucide="printer" class="w-4 h-4"></i>
                            <span>Cetak Sekarang (A4)</span>
                        </a>
                    </template>
                    <button type="button" @click="showModal = false" 
                        class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body: Lembar Kertas Dokumen Fisik A4 -->
            <div class="p-6 sm:p-12 overflow-y-auto max-h-[75vh] bg-slate-100/60 font-serif">
                
                <div class="max-w-3xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-lg border border-slate-300 text-slate-900 leading-relaxed relative">
                    
                    <!-- KOP SURAT PEMERINTAHAN DESA / RT RESMI -->
                    <div class="flex items-center justify-between pb-2 border-b-[2px] border-black">
                        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center">
                            <svg viewBox="0 0 100 100" class="w-10 h-10 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                                <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-center px-1">
                            <h4 class="text-[9px] font-bold uppercase tracking-widest text-black leading-none">PEMERINTAH KABUPATEN BOGOR</h4>
                            <h5 class="text-[8px] font-bold uppercase tracking-wider text-black leading-none mt-0.5">KECAMATAN CILODONG • DESA SUKAMAJU</h5>
                            <h3 class="text-xs font-black uppercase tracking-wider text-black leading-tight mt-0.5">RUKUN TETANGGA 03 / RUKUN WARGA 02</h3>
                            <p class="text-[7.5px] italic text-slate-700 font-sans leading-none mt-0.5">Sekretariat: Jl. Kenanga No. 12 RT 03/RW 02 Desa Sukamaju 16413</p>
                        </div>
                        <div class="w-10 h-10 flex-shrink-0 hidden sm:flex items-center justify-center">
                            <div class="w-8 h-8 rounded-full border border-black flex flex-col items-center justify-center text-[5.5px] font-black uppercase leading-none">
                                <span>RT 03</span>
                                <span>RW 02</span>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-black mb-5 mt-0.5"></div>

                    <!-- Judul & Nomor Surat -->
                    <div class="text-center mb-5">
                        <h4 class="text-base font-bold uppercase underline tracking-wider">SURAT PENGANTAR</h4>
                        <p class="text-xs font-bold font-mono mt-0.5" x-text="activeSurat ? 'Nomor: ' + activeSurat.nomor_surat : ''"></p>
                    </div>

                    <!-- Paragraf Pembuka -->
                    <p class="text-xs sm:text-sm text-justify mb-4">
                        Yang bertanda tangan di bawah ini, Ketua Rukun Tetangga (RT) 03 / RW 02 Desa Sukamaju, dengan ini menerangkan bahwa:
                    </p>

                    <!-- Identitas Warga Pemohon -->
                    <template x-if="activeSurat && activeSurat.warga">
                        <div class="text-xs sm:text-sm mb-5 pl-2 sm:pl-6 space-y-1.5 font-sans">
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">Nama Lengkap</span>
                                <span class="col-span-1">:</span>
                                <strong class="col-span-7 font-black uppercase text-slate-900" x-text="activeSurat.warga.nama_lengkap"></strong>
                            </div>
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">NIK</span>
                                <span class="col-span-1">:</span>
                                <strong class="col-span-7 font-mono font-bold text-slate-900" x-text="activeSurat.warga.nik"></strong>
                            </div>
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">No. Kartu Keluarga (KK)</span>
                                <span class="col-span-1">:</span>
                                <span class="col-span-7 font-mono" x-text="activeSurat.warga.keluarga ? activeSurat.warga.keluarga.nomor_kk : '-'"></span>
                            </div>
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">Tempat / Tanggal Lahir</span>
                                <span class="col-span-1">:</span>
                                <span class="col-span-7" x-text="activeSurat.warga.tempat_lahir + ', ' + (activeSurat.warga.tanggal_lahir ? activeSurat.warga.tanggal_lahir.substring(0, 10) : '-')"></span>
                            </div>
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">Jenis Kelamin / Agama</span>
                                <span class="col-span-1">:</span>
                                <span class="col-span-7" x-text="(activeSurat.warga.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan') + ' • ' + activeSurat.warga.agama"></span>
                            </div>
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">Pekerjaan</span>
                                <span class="col-span-1">:</span>
                                <span class="col-span-7" x-text="activeSurat.warga.pekerjaan"></span>
                            </div>
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">Status Tinggal</span>
                                <span class="col-span-1">:</span>
                                <span class="col-span-7 font-semibold capitalize" x-text="activeSurat.warga.status_tinggal + ' di RT 03'"></span>
                            </div>
                            <div class="grid grid-cols-12">
                                <span class="col-span-4 text-slate-600">Alamat Domisili</span>
                                <span class="col-span-1">:</span>
                                <span class="col-span-7" x-text="activeSurat.warga.keluarga ? activeSurat.warga.keluarga.alamat : 'RT 03 / RW 02'"></span>
                            </div>
                        </div>
                    </template>

                    <!-- Pernyataan & Keperluan -->
                    <p class="text-xs sm:text-sm text-justify mb-2">
                        Bahwa orang yang namanya tersebut di atas adalah benar-benar warga yang berdomisili di lingkungan RT 03 / RW 02 Desa Sukamaju. Surat ini diberikan untuk keperluan:
                    </p>

                    <div class="text-xs sm:text-sm font-semibold border-l-4 border-emerald-600 pl-4 py-2.5 my-3 bg-slate-50 italic rounded-r-lg" x-text="activeSurat ? activeSurat.keperluan : ''">
                    </div>

                    <template x-if="activeSurat && activeSurat.dokumen_hilang">
                        <div class="text-xs my-3 p-3 border border-dashed border-amber-500 bg-amber-50 rounded-xl font-sans">
                            <strong class="text-amber-900 block mb-0.5">Rincian Dokumen Hilang / Rusak Akibat Musibah:</strong>
                            <span class="text-amber-950 font-bold" x-text="activeSurat.dokumen_hilang"></span>
                        </div>
                    </template>

                    <p class="text-xs sm:text-sm text-justify mt-4 mb-8">
                        Demikian surat pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
                    </p>

                    <!-- Tanda Tangan & Tanggal -->
                    <div class="grid grid-cols-2 gap-4 text-xs sm:text-sm text-center pt-4 border-t border-slate-200">
                        <div>
                            <p class="mb-1 text-xs">Pemohon / Warga,</p>
                            <div class="h-20 flex items-end justify-center pb-1">
                                <span class="text-[10px] text-slate-400 italic">[ Tanda Tangan Pemohon ]</span>
                            </div>
                            <p class="font-bold underline uppercase tracking-wider" x-text="activeSurat && activeSurat.warga ? activeSurat.warga.nama_lengkap : 'Warga'"></p>
                        </div>
                        <div>
                            <p class="mb-0.5 text-xs" x-text="activeSurat ? 'Sukamaju, ' + activeSurat.tanggal_surat.substring(0, 10) : ''"></p>
                            <p class="font-bold text-xs uppercase" x-text="activeSurat ? activeSurat.penandatangan_jabatan : 'Ketua RT 03'"></p>

                            <!-- Area Tanda Tangan Dinamis Sesuai Jenis -->
                            <div class="h-20 flex items-center justify-center relative my-1">
                                <template x-if="activeSurat && activeSurat.tanda_tangan_jenis === 'digital' && activeSurat.tanda_tangan_digital">
                                    <div class="relative flex items-center justify-center">
                                        <div class="w-16 h-16 rounded-full border-2 border-emerald-800 text-emerald-800 text-[6px] font-bold flex flex-col items-center justify-center rotate-[-12deg] bg-emerald-50/50 absolute z-0 opacity-80 pointer-events-none">
                                            <span>★ PENGURUS RT ★</span>
                                            <span class="font-black text-[8px]">RT 03 / RW 02</span>
                                            <span>DESA SUKAMAJU</span>
                                        </div>
                                        <img :src="activeSurat.tanda_tangan_digital" class="h-14 max-w-[130px] object-contain relative z-10" alt="TTD Digital">
                                    </div>
                                </template>

                                <template x-if="activeSurat && activeSurat.tanda_tangan_jenis === 'qrcode'">
                                    <div class="flex items-center gap-2 p-1.5 border border-slate-300 rounded bg-slate-50 relative z-10 shadow-sm font-sans">
                                        <i data-lucide="qr-code" class="w-8 h-8 text-slate-800 inline"></i>
                                        <div class="text-left text-[8px] leading-tight">
                                            <div class="font-bold text-emerald-800">TTD DIGITAL SAH</div>
                                            <div class="font-mono text-slate-600" x-text="activeSurat.qr_token || 'RT03-VALID'"></div>
                                            <div class="text-slate-400">Terdaftar RT 03</div>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="!activeSurat || (activeSurat.tanda_tangan_jenis !== 'digital' && activeSurat.tanda_tangan_jenis !== 'qrcode')">
                                    <div class="relative flex items-center justify-center">
                                        <div class="w-16 h-16 rounded-full border border-dashed border-slate-400 text-slate-400 text-[6px] font-bold flex flex-col items-center justify-center rotate-[-8deg] absolute z-0">
                                            <span>[ STEMPEL RT ]</span>
                                        </div>
                                        <span class="text-[9px] text-slate-400 italic relative z-10">[ TTD Basah & Cap ]</span>
                                    </div>
                                </template>
                            </div>

                            <p class="font-bold underline uppercase tracking-wider" x-text="activeSurat ? activeSurat.penandatangan_nama : 'Hartono'"></p>
                        </div>
                    </div>

                    <!-- Barcode Info Posisi Fisik -->
                    <div class="mt-8 pt-4 border-t border-dashed border-slate-200 flex items-center justify-between text-[11px] text-slate-500 font-sans">
                        <span class="flex items-center gap-1.5 font-bold text-slate-700">
                            <i data-lucide="archive" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span>Posisi Lemari Fisik: <strong class="text-slate-900" x-text="activeSurat ? activeSurat.lokasi_arsip_fisik : 'Map Arsip'"></strong></span>
                        </span>
                        <span class="font-mono" x-text="activeSurat ? 'Arsip Tahun ' + activeSurat.tahun_arsip : ''"></span>
                    </div>

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
