@extends('layouts.app')

@section('title', 'Detail & Pratinjau Surat: ' . $suratPengantar->nomor_surat)
@section('header_title', 'Arsip Surat Pengantar')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('surat-pengantar.index') }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                    {{ $suratPengantar->label_jenis_surat }}
                </span>
                <h1 class="text-lg font-black text-slate-900 mt-1 font-mono">{{ $suratPengantar->nomor_surat }}</h1>
                <p class="text-xs text-slate-500 font-medium">Tercatat di Lemari Arsip: <strong class="text-slate-800">{{ $suratPengantar->lokasi_arsip_fisik ?? 'Map Arsip' }}</strong> (Tahun {{ $suratPengantar->tahun_arsip }})</p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            @if($suratPengantar->status === 'menunggu_validasi')
                <form action="{{ route('surat-pengantar.validasi', $suratPengantar) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Sahkan surat pengantar ini sekarang?')"
                            class="w-full sm:w-auto justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>Sahkan Surat Ini</span>
                    </button>
                </form>
            @endif

            @php
                $linkWarga = route('portal.warga', ['kode' => $suratPengantar->qr_token]);
                $pesanWa = "Halo Bapak/Ibu " . ($suratPengantar->warga->nama_lengkap ?? 'Warga') . ", Surat Pengantar RT 005 RW 013 Anda telah selesai dibuat. Kode Surat Anda: *" . $suratPengantar->qr_token . "*. Silakan periksa & unduh surat di: " . $linkWarga;
            @endphp
            <button type="button" 
                    onclick="navigator.clipboard.writeText('{{ addslashes($pesanWa) }}'); alert('Pesan WhatsApp siap kirim berhasil disalin!');"
                    class="w-full sm:w-auto justify-center px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs rounded-xl shadow-2xs transition-colors flex items-center gap-2">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Salin Pesan WA</span>
            </button>

            <a href="{{ route('surat-pengantar.print', $suratPengantar) }}" target="_blank" class="w-full sm:w-auto justify-center px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Lembar Surat</span>
            </a>
        </div>
    </div>

    <!-- KOTAK KODE SURAT WARGA (UNTUK DIBERIKAN KE PEMOHON) -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white rounded-2xl p-5 sm:p-6 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-wider bg-white/20 px-2.5 py-0.5 rounded-full text-blue-100">
                    Kode Surat Warga
                </span>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-2xl sm:text-3xl font-black font-mono tracking-wider text-yellow-300">
                        {{ $suratPengantar->qr_token }}
                    </span>
                    <button type="button" 
                            onclick="navigator.clipboard.writeText('{{ $suratPengantar->qr_token }}'); alert('Kode surat berhasil disalin: {{ $suratPengantar->qr_token }}');"
                            class="px-3 py-1 bg-white/20 hover:bg-white/30 text-white rounded-lg text-xs font-bold transition-colors">
                        Salin Kode
                    </button>
                </div>
                <p class="text-xs text-blue-100 max-w-xl">
                    Berikan kode ini kepada warga (<strong>{{ $suratPengantar->warga->nama_lengkap ?? 'Pemohon' }}</strong>). Warga dapat memasukkan kode ini di portal website untuk memeriksa &amp; mengunduh dokumen surat.
                </p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="https://wa.me/?text={{ urlencode($pesanWa) }}" target="_blank"
                   class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Kirim via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>

    @if($suratPengantar->file_dokumen)
        <!-- JIKA ADA DOKUMEN ASLI YANG DIUNGGAH OLEH PAK RT -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="file-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Berkas Dokumen Asli yang Diunggah</h2>
                        <p class="text-xs text-slate-500">Berkas surat resmi yang siap dicek dan diunduh oleh warga</p>
                    </div>
                </div>

                <a href="{{ asset($suratPengantar->file_dokumen) }}" target="_blank" download
                   class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-colors shadow-2xs">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Unduh Dokumen Asli</span>
                </a>
            </div>

            <!-- Preview Dokumen Asli -->
            @php
                $ext = strtolower(pathinfo($suratPengantar->file_dokumen, PATHINFO_EXTENSION));
            @endphp
            @if(in_array($ext, ['png', 'jpg', 'jpeg', 'webp']))
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center max-h-[600px] overflow-hidden">
                    <img src="{{ asset($suratPengantar->file_dokumen) }}" alt="Dokumen Surat" class="max-h-[580px] w-auto object-contain rounded-lg shadow-sm">
                </div>
            @elseif($ext === 'pdf')
                <div class="border border-slate-200 rounded-xl overflow-hidden h-[550px]">
                    <iframe src="{{ asset($suratPengantar->file_dokumen) }}" class="w-full h-full" frameborder="0"></iframe>
                </div>
            @endif
        </div>

        <!-- Detail Teks Lembar Surat (Disembunyikan dalam Accordion agar Rapi) -->
        <details class="bg-white rounded-2xl border border-slate-200 p-4 transition-all group">
            <summary class="text-xs font-bold text-slate-700 cursor-pointer flex items-center justify-between list-none">
                <span class="flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i>
                    <span>Lihat Format Naskah Teks Digital Surat</span>
                </span>
                <span class="text-[11px] text-blue-600 group-open:hidden">Buka &darr;</span>
                <span class="text-[11px] text-slate-400 hidden group-open:inline">Tutup &uarr;</span>
            </summary>
            <div class="pt-4 border-t border-slate-100 mt-3">
    @endif

    <!-- Tampilan Langsung Lembar Surat Fisik (Format Tata Naskah Dinas Pemerintahan Indonesia) -->
    <div class="overflow-x-auto pb-2">
        <div class="min-w-[310px] bg-white rounded-3xl border border-slate-300 shadow-md p-4 sm:p-14 max-w-4xl mx-auto font-serif text-slate-900 relative">
        
        <!-- Watermark Arsip Digital Resmi -->
        <div class="absolute top-6 right-6 border border-blue-300 bg-blue-50/70 text-blue-800 px-3 py-1.5 rounded-xl font-sans text-xs font-bold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4 text-blue-600"></i>
            <span>Arsip Sah RT 005 / RW 013 | {{ $suratPengantar->qr_token }}</span>
        </div>

        <!-- KOP SURAT RT 005 / RW 013 RESMI -->
        <div class="flex items-center justify-between pb-2 pt-6 sm:pt-0 border-b-[3px] border-black">
            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 flex items-center justify-center">
                <svg viewBox="0 0 100 100" class="w-14 h-14 sm:w-16 sm:h-16 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                </svg>
            </div>

            <!-- Teks Kop Resmi Berjenjang -->
            <div class="flex-1 text-center px-2">
                <h4 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-black leading-tight">PENGURUS RUKUN TETANGGA 005 / RUKUN WARGA 013</h4>
                <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-black leading-tight mt-0.5">PERUMAHAN BUMI MUTIARA INDAH II</h2>
                <p class="text-[10px] sm:text-xs text-black font-sans mt-0.5 leading-tight">
                    Sekretariat: Perumahan Bumi Mutiara Indah II, RT 005 / RW 013
                </p>
                <p class="text-[9px] sm:text-[10px] text-black font-sans leading-tight">
                    Sistem Informasi Pendataan dan Pelayanan Warga Berbasis Web | Kode Verifikasi: {{ $suratPengantar->qr_token }}
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
        <div class="border-b border-black mb-6 mt-0.5"></div>

        <!-- Judul & Nomor Surat Dinas -->
        <div class="text-center mb-6">
            <h4 class="text-base sm:text-lg font-bold uppercase underline tracking-wider font-serif">SURAT PENGANTAR</h4>
            <p class="text-xs sm:text-sm font-bold font-serif mt-0.5">Nomor : {{ $suratPengantar->nomor_surat }}</p>
        </div>

        <!-- Paragraf Pembuka Baku -->
        <p class="text-sm text-justify mb-3 leading-relaxed indent-8">
            Yang bertanda tangan di bawah ini Ketua Rukun Tetangga (RT) 005 Rukun Warga (RW) 013 Perumahan Bumi Mutiara Indah II, dengan ini menerangkan bahwa:
        </p>

        <!-- Tabel Identitas Warga Pemohon (Standar Naskah Dinas Desa) -->
        <div class="text-sm mb-5 pl-2 sm:pl-6">
            <table class="w-full border-collapse">
                <tbody>
                    <tr class="align-top">
                        <td class="w-6 py-0.5 text-slate-700">1.</td>
                        <td class="w-48 sm:w-52 py-0.5 text-slate-700">Nama Lengkap</td>
                        <td class="w-4 py-0.5">:</td>
                        <td class="py-0.5 font-bold uppercase text-slate-900">{{ $suratPengantar->warga->nama_lengkap }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">2.</td>
                        <td class="py-0.5 text-slate-700">Nomor Induk Kependudukan (NIK)</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 font-mono font-bold text-slate-900">{{ $suratPengantar->warga->nik }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">3.</td>
                        <td class="py-0.5 text-slate-700">Nomor Kartu Keluarga (No. KK)</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 font-mono text-slate-800">{{ $suratPengantar->warga->keluarga->nomor_kk ?? '-' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">4.</td>
                        <td class="py-0.5 text-slate-700">Tempat, Tanggal Lahir / Usia</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 text-slate-800">{{ $suratPengantar->warga->tempat_lahir }}, {{ $suratPengantar->warga->tanggal_lahir?->translatedFormat('d F Y') }} ({{ $suratPengantar->warga->usia }} Tahun)</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">5.</td>
                        <td class="py-0.5 text-slate-700">Jenis Kelamin</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 text-slate-800">{{ $suratPengantar->warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">6.</td>
                        <td class="py-0.5 text-slate-700">Kewarganegaraan</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 text-slate-800">Warga Negara Indonesia (WNI)</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">7.</td>
                        <td class="py-0.5 text-slate-700">Agama</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 text-slate-800">{{ $suratPengantar->warga->agama }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">8.</td>
                        <td class="py-0.5 text-slate-700">Pekerjaan</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 text-slate-800">{{ $suratPengantar->warga->pekerjaan }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">9.</td>
                        <td class="py-0.5 text-slate-700">Status Perkawinan</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 text-slate-800">{{ $suratPengantar->warga->status_perkawinan ?? 'Kawin' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">10.</td>
                        <td class="py-0.5 text-slate-700">Status Tempat Tinggal</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 font-medium text-slate-800">{{ ucfirst($suratPengantar->warga->status_tinggal) }} di Lingkungan RT 005 / RW 013</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-0.5 text-slate-700">11.</td>
                        <td class="py-0.5 text-slate-700">Alamat KTP / Domisili</td>
                        <td class="py-0.5">:</td>
                        <td class="py-0.5 text-slate-800">{{ $suratPengantar->warga->keluarga->alamat ?? 'Perumahan Bumi Mutiara Indah II, RT 005 / RW 013' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paragraf Pernyataan & Keperluan Baku -->
        <p class="text-sm text-justify mb-2 leading-relaxed indent-8">
            Bahwa orang yang namanya tersebut di atas adalah benar-benar warga yang bertempat tinggal dan berdomisili sah di lingkungan Rukun Tetangga (RT) 005 Rukun Warga (RW) 013 Perumahan Bumi Mutiara Indah II.
        </p>

        <p class="text-sm text-justify mb-2 leading-relaxed indent-8">
            Surat pengantar ini dibuat dan diberikan kepada yang bersangkutan untuk melengkapi berkas persyaratan:
        </p>

        <div class="text-sm border-l-4 border-black pl-4 py-2.5 my-3 bg-slate-50 italic rounded-r-lg font-semibold">
            "{{ $suratPengantar->keperluan }}"
        </div>

        @if($suratPengantar->dokumen_hilang)
        <div class="text-sm my-4 p-4 border border-black bg-slate-50 rounded-xl">
            <strong class="text-slate-900 block mb-1 font-sans text-xs uppercase">Rincian Dokumen yang Dilaporkan Hilang / Rusak Akibat Musibah:</strong>
            <span class="text-slate-800 font-medium">{{ $suratPengantar->dokumen_hilang }}</span>
        </div>
        @endif

        <p class="text-sm text-justify mt-4 mb-6 leading-relaxed indent-8">
            Demikian Surat Pengantar ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
        </p>

        <!-- Titimangsa & Kolom Tanda Tangan Resmi Dua Sisi (Pemohon & Ketua RT) -->
        <div class="grid grid-cols-2 gap-4 text-sm text-center pt-4 border-t border-slate-200">
            <div>
                <p class="mb-1 text-xs">Tanda Tangan Pemohon,</p>
                <div class="h-20 flex items-end justify-center pb-2">
                    <span class="text-[9px] text-slate-400 italic">[ Tanda Tangan ]</span>
                </div>
                <p class="font-bold underline uppercase tracking-wider">( {{ $suratPengantar->warga->nama_lengkap }} )</p>
                <p class="text-[9px] text-slate-500 font-mono mt-0.5">NIK: {{ $suratPengantar->warga->nik }}</p>
            </div>

            <div>
                <p class="mb-0.5 text-xs">Bumi Mutiara Indah II, {{ $suratPengantar->tanggal_surat->translatedFormat('d F Y') }}</p>
                <p class="font-bold text-xs uppercase tracking-wider">{{ $suratPengantar->penandatangan_jabatan }},</p>

                <!-- Area Tanda Tangan & Cap Stempel RT (Tinta Violet Resmi) -->
                <div class="h-24 flex items-center justify-center relative my-1">
                    @if(in_array($suratPengantar->tanda_tangan_jenis, ['digital', 'foto']) && $suratPengantar->tanda_tangan_digital && ! $suratPengantar->is_pdf_signature)
                        <!-- Stempel Dinas RT Cap Ungu Violet Resmi Pemerintahan -->
                        <div class="w-20 h-20 rounded-full border-2 border-indigo-900 text-indigo-900 text-[6px] font-bold flex flex-col items-center justify-center rotate-[-12deg] bg-indigo-50/30 absolute z-0 select-none opacity-90">
                            <span class="tracking-widest uppercase text-[5.5px]">★ RUKUN TETANGGA ★</span>
                            <span class="font-black text-[8px] my-0.5">RT 005 / RW 013</span>
                            <span class="tracking-wider uppercase text-[5.5px]">BUMI MUTIARA INDAH II</span>
                        </div>
                        <img src="{{ $suratPengantar->tanda_tangan_url }}" alt="Foto Tanda Tangan Ketua RT" class="h-16 max-w-[160px] object-contain relative z-10 mx-auto">
                    @elseif($suratPengantar->is_pdf_signature)
                        <div class="flex items-center gap-2 p-1.5 border border-slate-400 rounded-lg bg-slate-50 relative z-10 shadow-sm font-sans text-left">
                            <div class="w-9 h-9 bg-emerald-50 border border-emerald-400 rounded flex items-center justify-center">
                                <span class="text-xs font-black text-emerald-800">PDF</span>
                            </div>
                            <div class="text-left text-[8.5px] leading-tight">
                                <div class="font-bold text-emerald-900">TTD PDF TERVERIFIKASI</div>
                                <div class="font-mono text-[7.5px] text-slate-700">{{ $suratPengantar->qr_token ?? 'BMI2-VALID' }}</div>
                                <div class="text-[7.5px] text-slate-500">Berkas Sah RT 005</div>
                            </div>
                        </div>
                    @elseif($suratPengantar->tanda_tangan_jenis === 'qrcode' || $suratPengantar->qr_token)
                        <div class="flex items-center gap-2 p-1.5 border border-slate-400 rounded-lg bg-slate-50 relative z-10 shadow-sm font-sans">
                            <div class="w-10 h-10 bg-white p-0.5 border border-slate-300 rounded flex items-center justify-center">
                                <i data-lucide="qr-code" class="w-8 h-8 text-slate-900"></i>
                            </div>
                            <div class="text-left text-[8.5px] leading-tight">
                                <div class="font-bold text-slate-900">TTD ELEKTRONIK SAH</div>
                                <div class="font-mono text-[7.5px] text-slate-700">{{ $suratPengantar->qr_token ?? 'BMI2-VALID' }}</div>
                                <div class="text-[7.5px] text-slate-500">Terdaftar RT 005 RW 013</div>
                            </div>
                        </div>
                    @else
                        <div class="w-20 h-20 rounded-full border border-dashed border-slate-400 text-slate-400 text-[6.5px] font-bold flex flex-col items-center justify-center rotate-[-8deg] absolute z-0 select-none">
                            <span>[ CAP STEMPEL RT 005 ]</span>
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

        <!-- Pengesahan Mengetahui Ketua RW 013 -->
        <div class="text-center text-sm pt-6 mt-4 border-t border-dotted border-slate-300">
            <p class="text-xs">Mengetahui,</p>
            <p class="font-bold text-xs uppercase tracking-wider">Ketua Rukun Warga (RW) 013 Perumahan Bumi Mutiara Indah II</p>
            <div class="h-16 flex items-end justify-center pb-1">
                <span class="text-[9px] text-slate-400 italic">[ Tanda Tangan & Cap RW 013 ]</span>
            </div>
            <p class="font-bold underline uppercase tracking-wider">( ............................................................ )</p>
        </div>

    </div>
    </div>

    @if($suratPengantar->file_dokumen)
            </div>
        </details>
    @endif

</div>
@endsection
