<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Pengantar - {{ $suratPengantar->nomor_surat }}</title>
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
            <a href="{{ route('surat-pengantar.show', $suratPengantar) }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali</span>
            </a>
            <span class="text-xs text-slate-500 font-medium">Format Resmi Tata Naskah Dinas Pemerintahan Indonesia</span>
        </div>
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-lg shadow transition-colors">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Cetak Sekarang (Print / PDF)</span>
        </button>
    </div>

    <!-- Lembar Surat Resmi A4 (Format Tata Naskah Dinas Pemerintah Indonesia) -->
    <div class="print-page max-w-3xl mx-auto bg-white p-10 sm:p-14 border border-slate-300 shadow-xl text-black leading-relaxed">
        
        <!-- KOP SURAT PEMERINTAHAN DESA / RT RESMI -->
        <div class="flex items-center justify-between pb-2 border-b-[3px] border-black">
            <!-- Lambang Garuda Pancasila / Logo Daerah -->
            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 flex items-center justify-center">
                <svg viewBox="0 0 100 100" class="w-14 h-14 sm:w-16 sm:h-16 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                </svg>
            </div>

            <!-- Teks Kop Resmi Berjenjang -->
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

            <!-- Monogram RT Kanan (Keseimbangan Kop) -->
            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 hidden sm:flex items-center justify-center">
                <div class="w-12 h-12 rounded-full border-2 border-black flex flex-col items-center justify-center text-[7px] font-black uppercase leading-none">
                    <span>RT 03</span>
                    <span class="text-[6px] font-normal my-0.5">RW 02</span>
                    <span>SUKAMAJU</span>
                </div>
            </div>
        </div>
        <div class="border-b border-black mb-5 mt-0.5"></div>

        <!-- Judul & Nomor Surat Dinas -->
        <div class="text-center mb-5">
            <h3 class="text-base font-bold uppercase underline tracking-wider font-serif">SURAT PENGANTAR</h3>
            <p class="text-xs font-semibold mt-0.5">Nomor : {{ $suratPengantar->nomor_surat }}</p>
        </div>

        <!-- Paragraf Pembuka Baku -->
        <p class="text-sm text-justify mb-3 leading-relaxed indent-8">
            Yang bertanda tangan di bawah ini Ketua Rukun Tetangga (RT) 03 Rukun Warga (RW) 02 Desa Sukamaju, Kecamatan Cilodong, Kabupaten Bogor, dengan ini menerangkan bahwa:
        </p>

        <!-- Tabel Identitas Lengkap Pemohon (Standar Naskah Dinas Desa) -->
        <div class="text-sm mb-4 pl-2 sm:pl-6">
            <table class="w-full border-collapse">
                <tbody>
                    <tr class="align-top">
                        <td class="w-6 py-0.5">1.</td>
                        <td class="w-48 sm:w-52 py-0.5">Nama Lengkap</td>
                        <td class="w-4 py-0.5">:</td>
                        <td class="py-0.5 font-bold uppercase">{{ $suratPengantar->warga->nama_lengkap }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">2.</td>
                        <td class="py-0.5">Nomor Induk Kependudukan (NIK)</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 font-mono font-bold">{{ $suratPengantar->warga->nik }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">3.</td>
                        <td class="py-0.5">Nomor Kartu Keluarga (No. KK)</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 font-mono">{{ $suratPengantar->warga->keluarga->nomor_kk ?? '-' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">4.</td>
                        <td class="py-0.5">Tempat, Tanggal Lahir / Usia</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5">{{ $suratPengantar->warga->tempat_lahir }}, {{ $suratPengantar->warga->tanggal_lahir?->translatedFormat('d F Y') }} ({{ $suratPengantar->warga->usia }} Tahun)</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">5.</td>
                        <td class="py-0.5">Jenis Kelamin</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5">{{ $suratPengantar->warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">6.</td>
                        <td class="py-0.5">Kewarganegaraan</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5">Warga Negara Indonesia (WNI)</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">7.</td>
                        <td class="py-0.5">Agama</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5">{{ $suratPengantar->warga->agama }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">8.</td>
                        <td class="py-0.5">Pekerjaan</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5">{{ $suratPengantar->warga->pekerjaan }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">9.</td>
                        <td class="py-0.5">Status Perkawinan</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5">{{ $suratPengantar->warga->status_perkawinan ?? 'Kawin' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">10.</td>
                        <td class="py-0.5">Status Tempat Tinggal</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 font-medium">{{ ucfirst($suratPengantar->warga->status_tinggal) }} di Lingkungan RT 03</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5">11.</td>
                        <td class="py-0.5">Alamat KTP / Domisili</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5">{{ $suratPengantar->warga->keluarga->alamat ?? 'RT 03 / RW 02 Desa Sukamaju, Kec. Cilodong, Kab. Bogor' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paragraf Pernyataan & Keperluan Baku -->
        <p class="text-sm text-justify mb-2 leading-relaxed indent-8">
            Bahwa orang yang namanya tersebut di atas adalah benar-benar warga yang bertempat tinggal dan berdomisili sah di lingkungan Rukun Tetangga (RT) 03 Rukun Warga (RW) 02 Desa Sukamaju, Kecamatan Cilodong, Kabupaten Bogor.
        </p>

        <p class="text-sm text-justify mb-2 leading-relaxed indent-8">
            Surat pengantar ini dibuat dan diberikan kepada yang bersangkutan untuk melengkapi berkas persyaratan:
        </p>

        <div class="text-sm border-l-4 border-black pl-4 py-2 my-2 bg-slate-50 italic font-semibold">
            "{{ $suratPengantar->keperluan }}"
        </div>

        @if($suratPengantar->dokumen_hilang)
        <div class="text-sm my-3 p-3 border border-black bg-slate-50">
            <strong class="block mb-0.5 font-sans text-xs uppercase">Rincian Dokumen yang Dilaporkan Hilang / Rusak Akibat Musibah:</strong>
            <span>{{ $suratPengantar->dokumen_hilang }}</span>
        </div>
        @endif

        <p class="text-sm text-justify mt-3 mb-6 leading-relaxed indent-8">
            Demikian Surat Pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
        </p>

        <!-- Titimangsa & Kolom Tanda Tangan Resmi Dua Sisi (Pemohon & Ketua RT) -->
        <div class="grid grid-cols-2 gap-4 text-sm text-center pt-2">
            <div>
                <p class="mb-1 text-xs">Tanda Tangan Pemohon,</p>
                <div class="h-20 flex items-end justify-center pb-2">
                    <span class="text-[9px] text-slate-400 italic">[ Tanda Tangan ]</span>
                </div>
                <p class="font-bold underline uppercase tracking-wider">( {{ $suratPengantar->warga->nama_lengkap }} )</p>
                <p class="text-[9px] text-slate-600 font-mono mt-0.5">NIK: {{ $suratPengantar->warga->nik }}</p>
            </div>

            <div>
                <p class="mb-0.5 text-xs">Sukamaju, {{ $suratPengantar->tanggal_surat->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-xs uppercase tracking-wider">{{ $suratPengantar->penandatangan_jabatan }} Sukamaju,</p>

                <!-- Area Tanda Tangan & Cap Stempel RT (Tinta Violet Resmi) -->
                <div class="h-24 flex items-center justify-center relative my-1">
                    
                    @if(in_array($suratPengantar->tanda_tangan_jenis, ['digital', 'foto']) && $suratPengantar->tanda_tangan_digital && ! $suratPengantar->is_pdf_signature)
                        <!-- Stempel Dinas RT Cap Ungu Violet Resmi Pemerintahan -->
                        <div class="w-20 h-20 rounded-full border-2 border-indigo-900 text-indigo-900 text-[6.5px] font-bold flex flex-col items-center justify-center rotate-[-12deg] bg-indigo-50/30 absolute z-0 select-none opacity-90">
                            <span class="tracking-widest uppercase text-[6px]">★ PEMERINTAH DESA ★</span>
                            <span class="font-black text-[9px] my-0.5">RT 03 / RW 02</span>
                            <span class="tracking-wider uppercase text-[6px]">DESA SUKAMAJU</span>
                        </div>
                        <!-- Gambar Foto / Scan TTD Asli -->
                        <img src="{{ $suratPengantar->tanda_tangan_url }}" alt="Foto Tanda Tangan Ketua RT" class="h-16 max-w-[160px] object-contain relative z-10 mx-auto">
                    @elseif($suratPengantar->is_pdf_signature)
                        <!-- Tanda Tangan PDF Terverifikasi -->
                        <div class="flex items-center gap-2 p-1.5 border border-slate-400 rounded-lg bg-slate-50 relative z-10 shadow-sm font-sans text-left">
                            <div class="w-9 h-9 bg-emerald-50 border border-emerald-400 rounded flex items-center justify-center">
                                <span class="text-xs font-black text-emerald-800">PDF</span>
                            </div>
                            <div class="text-left text-[8.5px] leading-tight">
                                <div class="font-bold text-emerald-900">TTD PDF TERVERIFIKASI</div>
                                <div class="font-mono text-[7.5px] text-slate-700">{{ $suratPengantar->qr_token ?? 'RT03-VALID' }}</div>
                                <div class="text-[7.5px] text-slate-500">Berkas Sah RT 03</div>
                            </div>
                        </div>
                    @elseif($suratPengantar->tanda_tangan_jenis === 'qrcode' || $suratPengantar->qr_token)
                        <!-- TTD Elektronik QR Code Sah -->
                        <div class="flex items-center gap-2 p-1.5 border border-slate-400 rounded-lg bg-slate-50 relative z-10 shadow-sm font-sans">
                            <div class="w-10 h-10 bg-white p-0.5 border border-slate-300 rounded flex items-center justify-center">
                                <svg class="w-9 h-9 text-slate-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <div class="text-left text-[8.5px] leading-tight">
                                <div class="font-bold text-slate-900">TTD ELEKTRONIK SAH</div>
                                <div class="font-mono text-[7.5px] text-slate-700">{{ $suratPengantar->qr_token ?? 'RT03-VALID' }}</div>
                                <div class="text-[7.5px] text-slate-500">Terdaftar RT 03 Sukamaju</div>
                            </div>
                        </div>
                    @else
                        <!-- Tanda Tangan Basah Manual -->
                        <div class="w-20 h-20 rounded-full border border-dashed border-slate-400 text-slate-400 text-[6.5px] font-bold flex flex-col items-center justify-center rotate-[-8deg] absolute z-0 select-none">
                            <span>[ CAP STEMPEL RT ]</span>
                        </div>
                        <span class="text-[9px] text-slate-400 italic relative z-10">[ Tanda Tangan Basah & Cap ]</span>
                    @endif

                </div>

                <p class="font-bold underline uppercase tracking-wider">( {{ $suratPengantar->penandatangan_nama }} )</p>
                @if($suratPengantar->qr_token)
                    <p class="text-[8px] text-slate-500 font-mono mt-0.5">Reg. ID: {{ $suratPengantar->qr_token }}</p>
                @endif
            </div>
        </div>

        <!-- Pengesahan Mengetahui Ketua RW 02 (Standar Surat Pengantar Wilayah Desa) -->
        <div class="text-center text-sm pt-6 mt-4 border-t border-dotted border-slate-300">
            <p class="text-xs">Mengetahui,</p>
            <p class="font-bold text-xs uppercase tracking-wider">Ketua Rukun Warga (RW) 02 Desa Sukamaju</p>
            <div class="h-16 flex items-end justify-center pb-1">
                <span class="text-[9px] text-slate-400 italic">[ Tanda Tangan & Cap RW 02 ]</span>
            </div>
            <p class="font-bold underline uppercase tracking-wider">( ............................................................ )</p>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
