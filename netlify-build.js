import fs from 'node:fs';
import path from 'node:path';

console.log('--- Memulai Build Khusus Netlify untuk Sistem Pengarsipan RT 03 ---');

const publicDir = path.resolve('public');
const indexPath = path.join(publicDir, 'index.html');

const htmlContent = `<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP-RT 03 - Sistem Informasi & Arsip Digital RT (Netlify Edition)</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Times+New+Roman&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Times New Roman"', 'Times', 'serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        @media print {
            .no-print { display: none !important; }
            .print-page { border: none !important; box-shadow: none !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; }
        }
    </style>
</head>
<body class="h-full flex flex-col font-sans text-slate-800" x-data="{
    activeTab: 'surat',
    selectedTemplate: 'banjir',
    nomorSurat: '470/012/RT.03-RW.02/XI/2026',
    namaWarga: 'Bambang Sudibyo',
    nikWarga: '3201011203850001',
    keperluan: 'Sebagai pengantar permohonan penerbitan kembali KTP Elektronik dan Kartu Keluarga (KK) ke Kantor Desa / Disdukcapil dikarenakan dokumen asli rusak / hilang terendam musibah banjir bandang di wilayah RT 03.',
    dokumenHilang: 'KTP Elektronik dan Kartu Keluarga (KK) Asli',
    
    applyTemplate(type) {
        this.selectedTemplate = type;
        if (type === 'banjir') {
            this.dokumenHilang = 'KTP Elektronik dan Kartu Keluarga (KK) Asli';
            this.keperluan = 'Sebagai pengantar permohonan penerbitan kembali KTP Elektronik dan Kartu Keluarga (KK) ke Kantor Desa / Disdukcapil dikarenakan dokumen asli rusak / hilang terendam musibah banjir bandang di wilayah RT 03.';
        } else if (type === 'ktp') {
            this.dokumenHilang = '';
            this.keperluan = 'Sebagai pengantar permohonan perekaman dan penerbitan Kartu Tanda Penduduk Elektronik (KTP-el) baru ke Kantor Desa Sukamaju / Kantor Kecamatan.';
        } else if (type === 'kk') {
            this.dokumenHilang = '';
            this.keperluan = 'Sebagai pengantar permohonan pembaruan susunan anggota keluarga pada Kartu Keluarga (KK) dan penerbitan Akta Kelahiran anak ke Kantor Desa Sukamaju.';
        } else if (type === 'domisili') {
            this.dokumenHilang = '';
            this.keperluan = 'Surat Keterangan bahwa yang bersangkutan adalah benar warga yang berdomisili dan tinggal menetap di lingkungan RT 03 / RW 02 Desa Sukamaju untuk keperluan administrasi pekerjaan / perbankan.';
        }
    }
}" x-init="$nextTick(() => { lucide.createIcons(); })">

    <!-- Top Banner Pemberitahuan Status Netlify -->
    <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 text-white px-4 py-2.5 text-xs text-center border-b border-emerald-800 flex items-center justify-center gap-2 no-print">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>Aplikasi Sistem Pengarsipan RT 03 Berhasil Aktif di <strong>Netlify</strong></span>
        <span class="hidden sm:inline text-slate-400">• Untuk backend database PHP mandiri, dapat juga dihubungkan ke Railway / Laravel Cloud.</span>
    </div>

    <!-- Header Navigasi -->
    <header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4 flex items-center justify-between no-print shadow-sm sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-black flex items-center justify-center text-sm shadow-md shadow-emerald-900/20">
                RT
            </div>
            <div>
                <h1 class="text-base sm:text-lg font-black text-slate-900 leading-tight">SIP-RT 03 DESA SUKAMAJU</h1>
                <p class="text-[11px] text-slate-500 font-semibold">Sistem Administrasi Surat Menyurat & Kearsipan Warga</p>
            </div>
        </div>

        <!-- Tab Navigasi -->
        <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-2xl border border-slate-200 text-xs font-bold">
            <button @click="activeTab = 'surat'; $nextTick(() => lucide.createIcons())" 
                :class="activeTab === 'surat' ? 'bg-white text-emerald-800 shadow font-black' : 'text-slate-600 hover:text-slate-900'"
                class="px-3 py-2 rounded-xl flex items-center gap-1.5 transition-all">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Surat Pengantar A4</span>
            </button>
            <button @click="activeTab = 'disposisi'; $nextTick(() => lucide.createIcons())" 
                :class="activeTab === 'disposisi' ? 'bg-white text-emerald-800 shadow font-black' : 'text-slate-600 hover:text-slate-900'"
                class="px-3 py-2 rounded-xl flex items-center gap-1.5 transition-all">
                <i data-lucide="inbox" class="w-4 h-4"></i>
                <span>Lembar Disposisi</span>
            </button>
            <button @click="activeTab = 'arsip'; $nextTick(() => lucide.createIcons())" 
                :class="activeTab === 'arsip' ? 'bg-white text-emerald-800 shadow font-black' : 'text-slate-600 hover:text-slate-900'"
                class="px-3 py-2 rounded-xl flex items-center gap-1.5 transition-all">
                <i data-lucide="archive" class="w-4 h-4"></i>
                <span>Arsip 10 Tahun</span>
            </button>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-1 p-4 sm:p-8 max-w-5xl mx-auto w-full space-y-6">

        <!-- ==================== TAB 1: SURAT PENGANTAR RESMI A4 ==================== -->
        <div x-show="activeTab === 'surat'" class="space-y-6">
            
            <!-- Filter Template Cepat 1-Klik -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm space-y-3 no-print">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center">1</span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-slate-900">Uji Coba Template Surat 1-Klik</h2>
                    </div>
                    <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black rounded-xl shadow flex items-center gap-1.5 transition-colors">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        <span>Cetak Lembar A4 Ini</span>
                    </button>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1 text-xs">
                    <button type="button" @click="applyTemplate('banjir')" :class="selectedTemplate === 'banjir' ? 'bg-emerald-600 text-white font-black shadow' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border'" class="p-3 rounded-2xl text-left">
                        <div class="font-bold">Kehilangan Banjir</div>
                        <div class="text-[10px] opacity-80">KTP/KK hanyut banjir</div>
                    </button>
                    <button type="button" @click="applyTemplate('ktp')" :class="selectedTemplate === 'ktp' ? 'bg-emerald-600 text-white font-black shadow' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border'" class="p-3 rounded-2xl text-left">
                        <div class="font-bold">Pembuatan e-KTP</div>
                        <div class="text-[10px] opacity-80">Rekam KTP-el baru</div>
                    </button>
                    <button type="button" @click="applyTemplate('kk')" :class="selectedTemplate === 'kk' ? 'bg-emerald-600 text-white font-black shadow' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border'" class="p-3 rounded-2xl text-left">
                        <div class="font-bold">Perubahan Data KK</div>
                        <div class="text-[10px] opacity-80">Kelahiran anak baru</div>
                    </button>
                    <button type="button" @click="applyTemplate('domisili')" :class="selectedTemplate === 'domisili' ? 'bg-emerald-600 text-white font-black shadow' : 'bg-slate-50 text-slate-700 hover:bg-slate-100 border'" class="p-3 rounded-2xl text-left">
                        <div class="font-bold">Keterangan Domisili</div>
                        <div class="text-[10px] opacity-80">Pekerjaan / bank</div>
                    </button>
                </div>
            </div>

            <!-- Lembar Kertas Resmi Format Naskah Dinas Pemerintah Indonesia -->
            <div class="print-page bg-white p-8 sm:p-14 rounded-3xl border border-slate-300 shadow-xl text-black font-serif leading-relaxed max-w-3xl mx-auto">
                
                <!-- KOP SURAT DINAS PEMERINTAHAN BERJENJANG -->
                <div class="flex items-center justify-between pb-2 border-b-[3px] border-black">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 flex items-center justify-center">
                        <svg viewBox="0 0 100 100" class="w-14 h-14 sm:w-16 sm:h-16 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                            <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                        </svg>
                    </div>

                    <div class="flex-1 text-center px-2">
                        <h3 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-black leading-tight">PEMERINTAH KABUPATEN BOGOR</h3>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-black leading-tight">KECAMATAN CILODONG</h4>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-black leading-tight">DESA SUKAMAJU</h4>
                        <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-black leading-tight mt-0.5">RUKUN TETANGGA 03 / RUKUN WARGA 02</h2>
                        <p class="text-[10px] text-black font-sans mt-0.5 leading-tight">
                            Sekretariat: Jl. Kenanga No. 12 RT 03/RW 02 Desa Sukamaju, Kec. Cilodong, Kab. Bogor 16413
                        </p>
                        <p class="text-[9px] text-black font-sans leading-tight">
                            Pos-el: rt03rw02.sukamaju@desa.id | Laman: sukamaju.desa.id | Kontak: 0812-3456-7890
                        </p>
                    </div>

                    <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 hidden sm:flex items-center justify-center">
                        <div class="w-12 h-12 rounded-full border-2 border-black flex flex-col items-center justify-center text-[7px] font-black uppercase leading-none">
                            <span>RT 03</span>
                            <span class="text-[6px] font-normal my-0.5">RW 02</span>
                            <span>SUKAMAJU</span>
                        </div>
                    </div>
                </div>
                <div class="border-b border-black mb-5 mt-0.5"></div>

                <div class="text-center mb-5">
                    <h3 class="text-base font-bold uppercase underline tracking-wider font-serif">SURAT PENGANTAR</h3>
                    <p class="text-xs font-semibold mt-0.5" x-text="'Nomor : ' + nomorSurat"></p>
                </div>

                <p class="text-sm text-justify mb-3 leading-relaxed indent-8">
                    Yang bertanda tangan di bawah ini Ketua Rukun Tetangga (RT) 03 Rukun Warga (RW) 02 Desa Sukamaju, Kecamatan Cilodong, Kabupaten Bogor, dengan ini menerangkan bahwa:
                </p>

                <!-- Tabel Biodata Warga -->
                <div class="text-sm mb-4 pl-2 sm:pl-6">
                    <table class="w-full border-collapse">
                        <tbody>
                            <tr class="align-top"><td class="w-6 py-0.5">1.</td><td class="w-48 py-0.5">Nama Lengkap</td><td class="w-4 py-0.5">:</td><td class="py-0.5 font-bold uppercase" x-text="namaWarga"></td></tr>
                            <tr class="align-top"><td class="py-0.5">2.</td><td class="py-0.5">Nomor Induk Kependudukan (NIK)</td><td class="py-0.5">:</td><td class="py-0.5 font-mono font-bold" x-text="nikWarga"></td></tr>
                            <tr class="align-top"><td class="py-0.5">3.</td><td class="py-0.5">Nomor Kartu Keluarga (KK)</td><td class="py-0.5">:</td><td class="py-0.5 font-mono">3201010101010001</td></tr>
                            <tr class="align-top"><td class="py-0.5">4.</td><td class="py-0.5">Tempat, Tgl Lahir / Usia</td><td class="py-0.5">:</td><td class="py-0.5">Bogor, 12 Maret 1985 (39 Tahun)</td></tr>
                            <tr class="align-top"><td class="py-0.5">5.</td><td class="py-0.5">Jenis Kelamin / Kewarganegaraan</td><td class="py-0.5">:</td><td class="py-0.5">Laki-laki / WNI</td></tr>
                            <tr class="align-top"><td class="py-0.5">6.</td><td class="py-0.5">Agama / Pekerjaan</td><td class="py-0.5">:</td><td class="py-0.5">Islam / PNS Guru</td></tr>
                            <tr class="align-top"><td class="py-0.5">7.</td><td class="py-0.5">Status Tempat Tinggal</td><td class="py-0.5">:</td><td class="py-0.5 font-medium">Tetap di Lingkungan RT 03</td></tr>
                            <tr class="align-top"><td class="py-0.5">8.</td><td class="py-0.5">Alamat KTP / Domisili</td><td class="py-0.5">:</td><td class="py-0.5">Jl. Kenanga No. 12 RT 03 / RW 02 Desa Sukamaju</td></tr>
                        </tbody>
                    </table>
                </div>

                <p class="text-sm text-justify mb-2 leading-relaxed indent-8">
                    Bahwa orang yang namanya tersebut di atas adalah benar-benar warga yang berdomisili sah di lingkungan RT 03 / RW 02 Desa Sukamaju, dan surat pengantar ini diberikan untuk melengkapi berkas persyaratan:
                </p>

                <div class="text-sm border-l-4 border-black pl-4 py-2 my-2 bg-slate-50 italic font-semibold">
                    "<span x-text="keperluan"></span>"
                </div>

                <div x-show="dokumenHilang" class="text-sm my-3 p-3 border border-black bg-slate-50">
                    <strong class="block mb-0.5 font-sans text-xs uppercase">Rincian Dokumen yang Dilaporkan Hilang / Rusak Akibat Musibah:</strong>
                    <span x-text="dokumenHilang"></span>
                </div>

                <p class="text-sm text-justify mt-3 mb-6 leading-relaxed indent-8">
                    Demikian Surat Pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
                </p>

                <!-- Titimangsa & Tanda Tangan -->
                <div class="grid grid-cols-2 gap-4 text-sm text-center pt-2">
                    <div>
                        <p class="mb-1 text-xs">Tanda Tangan Pemohon,</p>
                        <div class="h-20 flex items-end justify-center pb-2">
                            <span class="text-[9px] text-slate-400 italic">[ Tanda Tangan ]</span>
                        </div>
                        <p class="font-bold underline uppercase tracking-wider" x-text="'( ' + namaWarga + ' )'"></p>
                    </div>

                    <div>
                        <p class="mb-0.5 text-xs">Sukamaju, 02 November 2026</p>
                        <p class="font-bold text-xs uppercase tracking-wider">Ketua RT 03 / RW 02 Sukamaju,</p>

                        <div class="h-24 flex items-center justify-center relative my-1">
                            <div class="w-20 h-20 rounded-full border-2 border-indigo-900 text-indigo-900 text-[6.5px] font-bold flex flex-col items-center justify-center rotate-[-12deg] bg-indigo-50/30 absolute z-0 select-none opacity-90">
                                <span class="tracking-widest uppercase text-[6px]">★ PEMERINTAH DESA ★</span>
                                <span class="font-black text-[9px] my-0.5">RT 03 / RW 02</span>
                                <span class="tracking-wider uppercase text-[6px]">DESA SUKAMAJU</span>
                            </div>
                        </div>

                        <p class="font-bold underline uppercase tracking-wider">( HARTONO )</p>
                    </div>
                </div>

                <div class="text-center text-sm pt-6 mt-4 border-t border-dotted border-slate-300">
                    <p class="text-xs">Mengetahui,</p>
                    <p class="font-bold text-xs uppercase tracking-wider">Ketua Rukun Warga (RW) 02 Desa Sukamaju</p>
                    <div class="h-16 flex items-end justify-center pb-1">
                        <span class="text-[9px] text-slate-400 italic">[ Tanda Tangan & Cap RW 02 ]</span>
                    </div>
                    <p class="font-bold underline uppercase tracking-wider">( ............................................................ )</p>
                </div>

            </div>
        </div>

        <!-- ==================== TAB 2: LEMBAR DISPOSISI ==================== -->
        <div x-show="activeTab === 'disposisi'" class="space-y-6">
            <div class="print-page bg-white p-8 sm:p-14 rounded-3xl border border-slate-300 shadow-xl text-black leading-relaxed max-w-3xl mx-auto font-serif">
                <div class="text-center mb-4">
                    <h3 class="text-base font-bold uppercase underline tracking-wider">LEMBAR DISPOSISI SURAT MASUK</h3>
                    <p class="text-xs font-semibold font-mono mt-0.5">NO. AGENDA : AG-2026-001</p>
                </div>
                <table class="w-full border-collapse border-2 border-black text-xs mb-4">
                    <tbody>
                        <tr class="border-b border-black">
                            <td class="w-1/2 p-2.5 border-r border-black"><span class="text-[10px] text-slate-600 block uppercase font-bold font-sans">Indeks Berkas:</span><strong>470 / Kependudukan & Ketatausahaan</strong></td>
                            <td class="w-1/2 p-2.5"><span class="text-[10px] text-slate-600 block uppercase font-bold font-sans">Sifat Surat:</span><strong>[X] Biasa</strong></td>
                        </tr>
                        <tr class="border-b border-black">
                            <td class="p-2.5 border-r border-black"><span class="text-[10px] text-slate-600 block uppercase font-bold font-sans">Tanggal Terima:</span><strong>02 November 2026</strong></td>
                            <td class="p-2.5"><span class="text-[10px] text-slate-600 block uppercase font-bold font-sans">Asal Pengirim:</span><strong>Kantor Desa Sukamaju</strong></td>
                        </tr>
                        <tr class="border-b border-black">
                            <td colspan="2" class="p-2.5"><span class="text-[10px] text-slate-600 block uppercase font-bold font-sans">Perihal:</span><strong>Surat Edaran Pendataan Warga Kontrak & Banjir</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="p-2.5 bg-slate-50"><span class="text-[10px] text-slate-700 block uppercase font-bold font-sans">Instruksi Disposisi Ketua RT 03:</span><p class="italic text-xs mt-0.5">"Segera sosialisasikan kepada seluruh warga RT 03 dan masukkan ke ordner lemari arsip 10 tahun."</p></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ==================== TAB 3: INFORMASI ARSIP ==================== -->
        <div x-show="activeTab === 'arsip'" class="space-y-6">
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900">Penyimpanan & Manajemen Arsip RT 03</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Sistem ini mengelola data manual dan digital warga serta surat-menyurat secara rapi hingga 10 tahun ke belakang sesuai standar kearsipan sekretariat RT.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl">
                        <div class="text-emerald-800 text-xs font-bold uppercase">Surat Keluar / Pengantar</div>
                        <div class="text-2xl font-black text-emerald-950 mt-1">Tercatat</div>
                    </div>
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl">
                        <div class="text-blue-800 text-xs font-bold uppercase">Buku Agenda Surat Masuk</div>
                        <div class="text-2xl font-black text-blue-950 mt-1">Disposisi Sah</div>
                    </div>
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                        <div class="text-amber-800 text-xs font-bold uppercase">Ordner Fisik Lemari RT</div>
                        <div class="text-2xl font-black text-amber-950 mt-1">10 Tahun Aman</div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer Bersih -->
    <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center text-xs text-slate-500 no-print">
        SIP-RT 03 Desa Sukamaju • Rukun Tetangga 03 / Rukun Warga 02 Kecamatan Cilodong
    </footer>

</body>
</html>
`;

fs.writeFileSync(indexPath, htmlContent, 'utf-8');
console.log('✓ File public/index.html berhasil dibuat khusus untuk deployment Netlify!');
