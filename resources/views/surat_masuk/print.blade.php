<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi Surat Masuk - {{ $suratMasuk->nomor_agenda }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #f8fafc;
        }
        @media print {
            body {
                background: #fff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <!-- Tombol Cetak Melayang (Non-print) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print font-['Plus_Jakarta_Sans'] bg-white p-4 rounded-xl shadow-md border border-slate-200">
        <div class="flex items-center gap-3">
            <a href="{{ route('surat-masuk.show', $suratMasuk) }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali</span>
            </a>
            <span class="text-xs text-slate-500 font-medium">Format Lembar Disposisi Kedinasan Indonesia</span>
        </div>
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-lg shadow transition-colors">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Cetak Disposisi Sekarang (Print / PDF)</span>
        </button>
    </div>

    <!-- Lembar Disposisi Resmi A4 (Standar Tata Naskah Dinas Pemerintah Indonesia) -->
    <div class="print-page max-w-3xl mx-auto bg-white p-10 sm:p-14 border border-slate-300 shadow-xl text-black leading-relaxed">
        
        <!-- KOP SURAT PEMERINTAHAN DESA / RT RESMI -->
        <div class="flex items-center justify-between pb-2 border-b-[3px] border-black">
            <!-- Lambang Garuda Pancasila -->
            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 flex items-center justify-center">
                <svg viewBox="0 0 100 100" class="w-14 h-14 sm:w-16 sm:h-16 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                </svg>
            </div>

            <!-- Teks Kop Resmi Berjenjang -->
            <div class="flex-1 text-center px-2">
                <h3 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-black leading-tight">PENGURUS RUKUN TETANGGA 005 / RUKUN WARGA 013</h3>
                <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-black leading-tight">PERUMAHAN BUMI MUTIARA INDAH II</h4>
                <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-black leading-tight mt-0.5">LEMBAR DISPOSISI AGENDA SURAT MASUK</h2>
                <p class="text-[10px] text-black font-sans mt-0.5 leading-tight">
                    Sekretariat: Perumahan Bumi Mutiara Indah II Blok B3 No. 12 RT 005 / RW 013
                </p>
                <p class="text-[9px] text-black font-sans leading-tight">
                    Pos-el: rt005rw013@bumimutiara.id | Kontak: 0812-3456-7890
                </p>
            </div>

            <!-- Monogram RT Kanan -->
            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 hidden sm:flex items-center justify-center">
                <div class="w-12 h-12 rounded-full border-2 border-black flex flex-col items-center justify-center text-[7px] font-black uppercase leading-none">
                    <span>RT 005</span>
                    <span class="text-[6px] font-normal my-0.5">RW 013</span>
                    <span>BMI II</span>
                </div>
            </div>
        </div>
        <div class="border-b border-black mb-5 mt-0.5"></div>

        <!-- Judul Lembar Disposisi -->
        <div class="text-center mb-5">
            <h3 class="text-base font-bold uppercase underline tracking-wider font-serif">LEMBAR DISPOSISI SURAT MASUK</h3>
            <p class="text-xs font-semibold font-mono mt-0.5">NO. AGENDA KEDINASAN : {{ $suratMasuk->nomor_agenda }}</p>
        </div>

        <!-- Format Tabel Kotak Tata Naskah Dinas Kedinasan -->
        <table class="w-full border-collapse border-2 border-black text-xs mb-5">
            <tbody>
                <tr class="border-b border-black">
                    <td class="w-1/2 p-2.5 border-r border-black align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Indeks Klasifikasi Berkas :</span>
                        <strong class="text-sm font-mono block">470 / Kependudukan & Ketatausahaan</strong>
                    </td>
                    <td class="w-1/2 p-2.5 align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Tingkat Keamanan / Sifat Surat :</span>
                        <div class="flex items-center gap-3 mt-1 font-sans text-xs">
                            <span class="font-normal">[ ] Sangat Rahasia</span>
                            <span class="font-normal">[ ] Rahasia</span>
                            <span class="font-bold">[X] Biasa</span>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-black">
                    <td class="p-2.5 border-r border-black align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Tanggal Diterima :</span>
                        <strong class="text-sm block">{{ $suratMasuk->tanggal_terima->translatedFormat('d F Y') }}</strong>
                    </td>
                    <td class="p-2.5 align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Nomor Agenda Surat :</span>
                        <strong class="text-sm font-mono block">{{ $suratMasuk->nomor_agenda }}</strong>
                    </td>
                </tr>

                <tr class="border-b border-black">
                    <td colspan="2" class="p-2.5 align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Asal Surat (Instansi / Pengirim) :</span>
                        <strong class="text-sm block text-slate-900">{{ $suratMasuk->pengirim }}</strong>
                    </td>
                </tr>

                <tr class="border-b border-black">
                    <td class="p-2.5 border-r border-black align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Nomor Surat Masuk :</span>
                        <strong class="text-sm font-mono block">{{ $suratMasuk->nomor_surat_pengirim }}</strong>
                    </td>
                    <td class="p-2.5 align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Tanggal Surat Masuk :</span>
                        <span class="text-sm block">{{ $suratMasuk->tanggal_surat->translatedFormat('d F Y') }}</span>
                    </td>
                </tr>

                <tr class="border-b border-black">
                    <td colspan="2" class="p-2.5 align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Perihal / Hal Surat :</span>
                        <strong class="text-sm block text-slate-900">{{ $suratMasuk->perihal }}</strong>
                    </td>
                </tr>

                <tr class="border-b border-black">
                    <td colspan="2" class="p-2.5 align-top">
                        <span class="text-[10px] text-slate-600 uppercase block font-sans font-bold">Ringkasan Pokok Isi Surat :</span>
                        <p class="text-xs text-justify mt-1 leading-relaxed">
                            {{ $suratMasuk->ringkasan_isi ?: 'Surat kedinasan resmi mengenai administrasi lingkungan RT 005 / RW 013 Perumahan Bumi Mutiara Indah II. Berkas fisik lengkap tersimpan dalam lemari arsip.' }}
                        </p>
                    </td>
                </tr>

                <!-- Pembagian Disposisi Kepada Seksi & Petunjuk -->
                <tr class="border-b border-black">
                    <td class="p-2.5 border-r border-black align-top">
                        <span class="text-[10px] text-slate-700 uppercase block font-sans font-bold mb-1.5">Diteruskan Kepada Seksi :</span>
                        <div class="space-y-1 font-sans text-xs">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'sekretaris') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                <span>Sekretaris RT (Arsip & Surat)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'bendahara') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                <span>Bendahara RT (Keuangan & Kas)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'humas') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                <span>Seksi Humas (Warga & Sosialisasi)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'keamanan') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                <span>Seksi Keamanan (Kamtibmas/Ronda)</span>
                            </label>
                        </div>
                    </td>

                    <td class="p-2.5 align-top">
                        <span class="text-[10px] text-slate-700 uppercase block font-sans font-bold mb-1.5">Petunjuk / Disposisi :</span>
                        <div class="space-y-1 font-sans text-xs">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" checked class="w-3.5 h-3.5">
                                <span>Untuk diketahui / dipedomani</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" checked class="w-3.5 h-3.5">
                                <span>Tindak lanjuti / laksanakan</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="w-3.5 h-3.5">
                                <span>Koordinasikan dengan warga</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" checked class="w-3.5 h-3.5">
                                <span>Simpan dalam arsip 10 tahun</span>
                            </label>
                        </div>
                    </td>
                </tr>

                <!-- Catatan / Arahan Khusus Ketua RT -->
                <tr>
                    <td colspan="2" class="p-3 align-top bg-slate-50">
                        <span class="text-[10px] text-slate-700 uppercase block font-sans font-bold mb-1">Catatan / Arahan Khusus Ketua RT 005 :</span>
                        <p class="text-xs italic font-serif leading-relaxed">
                            "{{ $suratMasuk->disposisi ?: 'Segera koordinasikan sesuai bidang kerja masing-masing seksi dan dokumentasikan dalam buku arsip RT.' }}"
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Posisi Lemari Arsip & Pengesahan Kedinasan -->
        <div class="grid grid-cols-2 gap-6 text-sm pt-2">
            <div class="border border-black p-3 font-sans text-xs">
                <strong class="block uppercase text-black mb-1 font-bold">Penyimpanan Berkas Fisik:</strong>
                <p class="font-bold text-slate-900 font-mono">{{ $suratMasuk->lokasi_arsip_fisik ?: 'Ordner Surat Masuk RT 005' }}</p>
                <p class="text-slate-600 mt-1">Buku Agenda Tahun: {{ $suratMasuk->tahun_arsip }}</p>
                @if($suratMasuk->file_lampiran)
                    <p class="text-emerald-800 font-bold mt-2">✓ Berkas Scan Digital Tersimpan Resmi di Sistem</p>
                @endif
            </div>

            <div class="text-center font-serif">
                <p class="text-xs">Bumi Mutiara Indah II, {{ $suratMasuk->tanggal_terima->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-xs uppercase tracking-wider">Ketua RT 005 / RW 013,</p>
                
                <div class="h-20 flex items-center justify-center relative my-1">
                    <!-- Stempel Dinas Violet Resmi -->
                    <div class="w-16 h-16 rounded-full border-2 border-indigo-900 text-indigo-900 text-[5px] font-bold flex flex-col items-center justify-center rotate-[-10deg] bg-indigo-50/40 opacity-90">
                        <span>★ PENGURUS RT ★</span>
                        <span class="font-black text-[6.5px] my-0.5">RT 005 / RW 013</span>
                        <span>BUMI MUTIARA INDAH II</span>
                    </div>
                </div>

                <p class="font-bold underline uppercase tracking-wider">( HARTONO )</p>
            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
