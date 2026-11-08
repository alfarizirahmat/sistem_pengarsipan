<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Digital Resmi - {{ $suratPengantar->nomor_surat }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background-color: #f1f5f9;
        }
        .surat-kertas {
            font-family: 'Times New Roman', Times, serif;
        }
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .surat-kertas {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="p-3 sm:p-8 text-slate-800 font-sans min-h-screen">

    <!-- BAR AKSI DI ATAS (NON-PRINT) -->
    <div class="max-w-3xl mx-auto mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-200 no-print flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('portal.warga') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Portal</span>
            </a>
            <div class="text-xs">
                <span class="text-slate-500">Kode Unik:</span>
                <span class="font-mono font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">{{ $suratPengantar->qr_token }}</span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-xs transition-colors">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak / Unduh PDF</span>
            </button>
        </div>
    </div>

    <!-- BANNER VERIFIKASI KEABSAHAN (NON-PRINT) -->
    <div class="max-w-3xl mx-auto mb-6 no-print">
        @if($suratPengantar->status === 'selesai')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Dokumen Terverifikasi &amp; Sah</p>
                        <p class="text-xs text-emerald-700">Diterbitkan dan disahkan secara resmi oleh Pengurus RT 005 / RW 013 Perumahan Bumi Mutiara Indah II.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center gap-3 shadow-xs">
                <i data-lucide="clock" class="w-5 h-5 text-amber-600 flex-shrink-0"></i>
                <div>
                    <p class="font-bold text-sm">Status: Menunggu Validasi Pengurus</p>
                    <p class="text-xs text-amber-700">Permohonan surat sedang diperiksa oleh Pengurus RT 005. Silakan cek kembali dalam waktu dekat.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- LEMBAR SURAT RESMI (FORMAT TATA NASKAH DINAS PEMERINTAHAN INDONESIA) -->
    <div class="surat-kertas max-w-3xl mx-auto bg-white p-8 sm:p-14 border border-slate-300 shadow-md text-black leading-relaxed">
        
        <!-- KOP SURAT RESMI RT 005 / RW 013 -->
        <div class="text-center pb-2 border-b-[3px] border-black">
            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-black leading-tight">PENGURUS RUKUN TETANGGA 005 / RUKUN WARGA 013</h3>
            <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-black leading-tight mt-0.5">PERUMAHAN BUMI MUTIARA INDAH II</h2>
            <p class="text-[10px] sm:text-xs text-black font-sans mt-1 leading-tight">
                Sekretariat: Perumahan Bumi Mutiara Indah II, RT 005 / RW 013
            </p>
            <p class="text-[9px] sm:text-[10px] text-black font-sans leading-tight">
                Sistem Informasi Pendataan dan Pelayanan Warga Berbasis Web | Kode Verifikasi: {{ $suratPengantar->qr_token }}
            </p>
        </div>
        <div class="border-b border-black mb-6 mt-0.5"></div>

        <!-- JUDUL SURAT -->
        <div class="text-center mb-6">
            <h3 class="text-base sm:text-lg font-bold uppercase underline tracking-wider">SURAT PENGANTAR</h3>
            <p class="text-xs font-semibold mt-0.5 font-sans">Nomor: {{ $suratPengantar->nomor_surat }}</p>
        </div>

        <!-- PARAGRAF PEMBUKA -->
        <p class="text-sm text-justify mb-4 leading-relaxed indent-8">
            Yang bertanda tangan di bawah ini Ketua Rukun Tetangga (RT) 005 Rukun Warga (RW) 013 Perumahan Bumi Mutiara Indah II, dengan ini menerangkan bahwa:
        </p>

        <!-- TABEL IDENTITAS PEMOHON -->
        <div class="text-sm mb-4 pl-2 sm:pl-6">
            <table class="w-full text-sm">
                <tbody>
                    <tr class="align-top">
                        <td class="w-36 sm:w-44 py-1">Nama Lengkap</td>
                        <td class="w-3 py-1">:</td>
                        <td class="py-1 font-bold">{{ $suratPengantar->warga->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">NIK (No. KTP)</td>
                        <td class="py-1">:</td>
                        <td class="py-1 font-mono">{{ $suratPengantar->warga->nik ?? '-' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Nomor Kartu Keluarga</td>
                        <td class="py-1">:</td>
                        <td class="py-1 font-mono">{{ $suratPengantar->warga->keluarga->nomor_kk ?? '-' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Tempat / Tanggal Lahir</td>
                        <td class="py-1">:</td>
                        <td class="py-1">
                            {{ $suratPengantar->warga->tempat_lahir ?? '-' }}, 
                            {{ $suratPengantar->warga->tanggal_lahir ? \Carbon\Carbon::parse($suratPengantar->warga->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                        </td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Jenis Kelamin</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ ($suratPengantar->warga->jenis_kelamin ?? 'L') === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Agama</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $suratPengantar->warga->agama ?? 'Islam' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Pekerjaan</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $suratPengantar->warga->pekerjaan ?? '-' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Status Perkawinan</td>
                        <td class="py-1">:</td>
                        <td class="py-1">{{ $suratPengantar->warga->status_perkawinan ?? 'Kawin' }}</td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Alamat Tinggal</td>
                        <td class="py-1">:</td>
                        <td class="py-1">
                            {{ $suratPengantar->warga->keluarga->alamat ?? 'Perumahan Bumi Mutiara Indah II' }}, RT 005 / RW 013
                        </td>
                    </tr>
                    <tr class="align-top">
                        <td class="py-1">Status Tempat Tinggal</td>
                        <td class="py-1">:</td>
                        <td class="py-1 capitalize">Warga {{ $suratPengantar->warga->status_tinggal ?? 'tetap' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ISI KETERANGAN & KEPERLUAN -->
        <p class="text-sm text-justify mb-3 leading-relaxed">
            Orang tersebut di atas adalah benar-benar warga yang berdomisili di lingkungan RT 005 / RW 013 Perumahan Bumi Mutiara Indah II. Surat Pengantar ini dibuat dan diberikan kepadanya untuk keperluan:
        </p>

        <!-- KOTAK KEPERLUAN -->
        <div class="my-3 p-3.5 border-l-4 border-black bg-slate-50 text-sm">
            <p class="font-bold text-black uppercase">
                &ldquo;{{ $suratPengantar->keperluan }}&rdquo;
            </p>
            @if($suratPengantar->dokumen_hilang)
                <p class="text-xs text-black mt-1">
                    Keterangan Dokumen Terkait: <strong>{{ $suratPengantar->dokumen_hilang }}</strong>
                </p>
            @endif
        </div>

        <!-- PARAGRAF PENUTUP -->
        <p class="text-sm text-justify mb-8 leading-relaxed indent-8">
            Demikian Surat Pengantar ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
        </p>

        <!-- AREA TANDA TANGAN (KIRI PEMOHON, KANAN KETUA RT + QR VERIFIKASI) -->
        <div class="grid grid-cols-2 gap-4 text-sm mt-8 pt-4">
            <!-- Tanda Tangan Pemohon -->
            <div class="text-center">
                <p class="text-xs mb-1">Mengetahui,</p>
                <p class="font-bold">Pemohon</p>
                <div class="h-20 sm:h-24 flex items-end justify-center">
                    <p class="font-bold underline uppercase">{{ $suratPengantar->warga->nama_lengkap ?? 'Pemohon' }}</p>
                </div>
            </div>

            <!-- Tanda Tangan Pengurus RT -->
            <div class="text-center">
                <p class="text-xs mb-1">Bumi Mutiara Indah II, {{ \Carbon\Carbon::parse($suratPengantar->tanggal_surat)->translatedFormat('d F Y') }}</p>
                <p class="font-bold">{{ $suratPengantar->penandatangan_jabatan ?: 'Ketua RT 005' }}</p>
                
                <!-- STAMP / QR CODE DIGITAL -->
                <div class="h-20 sm:h-24 flex flex-col items-center justify-center my-1">
                    <div class="p-1 border border-slate-300 rounded bg-white shadow-2xs flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data={{ urlencode(route('portal.digital', $suratPengantar->qr_token ?: $suratPengantar->id)) }}" 
                             alt="QR Validasi" 
                             class="w-16 h-16">
                    </div>
                    <span class="text-[8px] font-mono mt-0.5 text-slate-600 font-sans">Token: {{ $suratPengantar->qr_token }}</span>
                </div>

                <p class="font-bold underline uppercase">{{ $suratPengantar->penandatangan_nama ?: 'Ketua RT 005' }}</p>
                <p class="text-[10px] text-slate-600 font-sans">RT 005 / RW 013</p>
            </div>
        </div>

        <!-- FOOTER CATATAN RESMI -->
        <div class="mt-12 pt-3 border-t border-slate-200 text-[10px] text-slate-500 font-sans flex justify-between items-center">
            <span>Surat ini sah diverifikasi digital via sistem kearsipan RT 005</span>
            <span>Masa berlaku: s.d {{ $suratPengantar->berlaku_sampai ? \Carbon\Carbon::parse($suratPengantar->berlaku_sampai)->translatedFormat('d F Y') : '30 Hari sejak diterbitkan' }}</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
