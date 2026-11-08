@extends('layouts.app')

@section('title', 'Detail & Berkas Surat Masuk: ' . $suratMasuk->nomor_agenda)
@section('header_title', 'Buku Agenda Surat Masuk RT')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('surat-masuk.index') }}" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-800 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-200">
                    Agenda: {{ $suratMasuk->nomor_agenda }}
                </span>
                <h1 class="text-lg font-black text-slate-900 mt-1">{{ $suratMasuk->perihal }}</h1>
                <p class="text-xs text-slate-500 font-medium">Pengirim: <strong class="text-slate-800">{{ $suratMasuk->pengirim }}</strong> (Diterima: {{ $suratMasuk->tanggal_terima->translatedFormat('d F Y') }})</p>
            </div>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('surat-masuk.print', $suratMasuk) }}" target="_blank" class="flex-1 sm:flex-initial justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all flex items-center gap-2 active:scale-95 whitespace-nowrap">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak Lembar Disposisi</span>
            </a>
            @if($suratMasuk->file_lampiran)
                <a href="{{ asset('storage/' . $suratMasuk->file_lampiran) }}" target="_blank" download class="flex-1 sm:flex-initial justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all flex items-center gap-2 active:scale-95 whitespace-nowrap">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Unduh Berkas Scan</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Grid: Lembar Disposisi & Pratinjau Berkas Dokumen -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- KOLOM KIRI: LEMBAR DISPOSISI RESMI RT (7 KOLOM - FORMAT TATA NASKAH DINAS PEMERINTAHAN) -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-300 shadow-xl p-4 sm:p-8 space-y-5 font-serif text-slate-900 overflow-x-auto">
            
            <!-- KOP SURAT KEDINASAN -->
            <div class="flex items-center justify-between pb-2 border-b-[2px] border-black">
                <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center">
                    <svg viewBox="0 0 100 100" class="w-10 h-10 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1 text-center px-1">
                    <h4 class="text-[9px] font-bold uppercase tracking-widest text-black leading-none">RUKUN TETANGGA 005 / RUKUN WARGA 013</h4>
                    <h5 class="text-[8px] font-bold uppercase tracking-wider text-black leading-none mt-0.5">PERUMAHAN BUMI MUTIARA INDAH II</h5>
                    <h3 class="text-xs font-black uppercase tracking-wider text-black leading-tight mt-0.5">BUKU AGENDA DISPOSISI SURAT</h3>
                    <p class="text-[7.5px] italic text-slate-700 font-sans leading-none mt-0.5">Sekretariat: Perumahan Bumi Mutiara Indah II Blok B3 No. 12 RT 005 / RW 013</p>
                </div>
                <div class="w-10 h-10 flex-shrink-0 hidden sm:flex items-center justify-center">
                    <div class="w-8 h-8 rounded-full border border-black flex flex-col items-center justify-center text-[5.5px] font-black uppercase leading-none">
                        <span>RT 005</span>
                        <span>RW 013</span>
                    </div>
                </div>
            </div>
            <div class="border-b border-black mb-3 mt-0.5"></div>

            <div class="text-center">
                <h2 class="text-sm sm:text-base font-bold uppercase underline tracking-wider">LEMBAR DISPOSISI SURAT MASUK</h2>
                <p class="text-xs font-semibold font-mono mt-0.5 text-slate-700">NO. AGENDA: {{ $suratMasuk->nomor_agenda }}</p>
            </div>

            <!-- Tabel Kotak Naskah Dinas Disposisi -->
            <table class="w-full border-collapse border border-black text-xs">
                <tbody>
                    <tr class="border-b border-black">
                        <td class="w-1/2 p-2 border-r border-black align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Indeks Berkas:</span>
                            <strong class="font-mono text-xs">470 / Kependudukan & Umum</strong>
                        </td>
                        <td class="w-1/2 p-2 align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Tingkat Keamanan / Sifat:</span>
                            <span class="font-bold font-sans text-xs">[X] Biasa</span>
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td class="p-2 border-r border-black align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Tanggal Diterima:</span>
                            <strong>{{ $suratMasuk->tanggal_terima->translatedFormat('d F Y') }}</strong>
                        </td>
                        <td class="p-2 align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Nomor Agenda:</span>
                            <strong class="font-mono">{{ $suratMasuk->nomor_agenda }}</strong>
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td colspan="2" class="p-2 align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Asal Surat / Pengirim:</span>
                            <strong class="text-slate-900">{{ $suratMasuk->pengirim }}</strong>
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td class="p-2 border-r border-black align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Nomor Surat Masuk:</span>
                            <strong class="font-mono">{{ $suratMasuk->nomor_surat_pengirim }}</strong>
                        </td>
                        <td class="p-2 align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Tanggal Surat:</span>
                            <span>{{ $suratMasuk->tanggal_surat->translatedFormat('d F Y') }}</span>
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td colspan="2" class="p-2 align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Perihal / Hal Surat:</span>
                            <strong class="text-slate-900">{{ $suratMasuk->perihal }}</strong>
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td colspan="2" class="p-2 align-top">
                            <span class="text-[9.5px] text-slate-600 uppercase block font-sans font-bold">Ringkasan Pokok Isi Surat:</span>
                            <p class="text-xs text-justify mt-1 leading-relaxed">
                                {{ $suratMasuk->ringkasan_isi ?: 'Surat kedinasan resmi mengenai administrasi lingkungan RT 005 / RW 013 Perumahan Bumi Mutiara Indah II. Berkas fisik lengkap tersimpan dalam lemari arsip.' }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td class="p-2 border-r border-black align-top">
                            <span class="text-[9.5px] text-slate-700 uppercase block font-sans font-bold mb-1">Diteruskan Kepada:</span>
                            <div class="space-y-0.5 font-sans text-[11px]">
                                <div class="flex items-center gap-1.5">
                                    <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'sekretaris') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                    <span>Sekretaris RT</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'bendahara') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                    <span>Bendahara RT</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'humas') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                    <span>Seksi Humas</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <input type="checkbox" {{ str_contains(strtolower($suratMasuk->disposisi ?? ''), 'keamanan') ? 'checked' : '' }} class="w-3.5 h-3.5">
                                    <span>Seksi Keamanan</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 align-top">
                            <span class="text-[9.5px] text-slate-700 uppercase block font-sans font-bold mb-1">Petunjuk Disposisi:</span>
                            <div class="space-y-0.5 font-sans text-[11px]">
                                <div class="flex items-center gap-1.5"><input type="checkbox" checked class="w-3.5 h-3.5"><span>Untuk diketahui</span></div>
                                <div class="flex items-center gap-1.5"><input type="checkbox" checked class="w-3.5 h-3.5"><span>Tindak lanjuti</span></div>
                                <div class="flex items-center gap-1.5"><input type="checkbox" class="w-3.5 h-3.5"><span>Koordinasikan</span></div>
                                <div class="flex items-center gap-1.5"><input type="checkbox" checked class="w-3.5 h-3.5"><span>Arsipkan 10 tahun</span></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="p-2.5 bg-slate-50">
                            <span class="text-[9.5px] text-slate-700 uppercase block font-sans font-bold mb-1">Catatan / Arahan Disposisi Ketua RT 005:</span>
                            <p class="text-xs italic leading-relaxed text-slate-900 font-semibold">
                                "{{ $suratMasuk->disposisi ?: 'Diteruskan sesuai tugas dan fungsi seksi kepengurusan terkait.' }}"
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Footer Disposisi -->
            <div class="grid grid-cols-2 gap-4 text-xs pt-2">
                <div class="border border-slate-300 p-2.5 rounded font-sans">
                    <strong class="block uppercase text-slate-700 text-[10px] mb-0.5">Penyimpanan Fisik:</strong>
                    <p class="font-bold text-slate-900 font-mono">{{ $suratMasuk->lokasi_arsip_fisik ?: 'Ordner Surat Masuk' }}</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">Tahun Buku: {{ $suratMasuk->tahun_arsip }}</p>
                </div>
                <div class="text-center">
                    <p class="text-[10px]">Bumi Mutiara Indah II, {{ $suratMasuk->tanggal_terima->translatedFormat('d F Y') }}</p>
                    <p class="font-bold text-[11px] uppercase">Ketua RT 005 / RW 013,</p>
                    <div class="h-12 flex items-center justify-center relative my-0.5">
                        <div class="w-12 h-12 rounded-full border border-indigo-900 text-indigo-900 text-[5px] font-bold flex flex-col items-center justify-center rotate-[-10deg] bg-indigo-50/40">
                            <span>* PENGURUS RT *</span>
                            <span class="font-black text-[6.5px]">RT 005 / RW 013</span>
                            <span>BUMI MUTIARA INDAH II</span>
                        </div>
                    </div>
                    <p class="font-bold underline uppercase text-xs">( HARTONO )</p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: PRATINJAU LANGSUNG BERKAS SCAN (5 KOLOM) -->
        <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-emerald-600"></i>
                    <h3 class="text-sm font-black text-slate-900">Berkas Lampiran Scan</h3>
                </div>
                @if($suratMasuk->file_lampiran)
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Ada Berkas Digital</span>
                @else
                    <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Fisik di Lemari</span>
                @endif
            </div>

            @if($suratMasuk->file_lampiran)
                @php
                    $extension = pathinfo($suratMasuk->file_lampiran, PATHINFO_EXTENSION);
                    $fileUrl = asset('storage/' . $suratMasuk->file_lampiran);
                @endphp

                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                    <div class="rounded-2xl border-2 border-slate-200 overflow-hidden bg-slate-100 relative group">
                        <img src="{{ $fileUrl }}" alt="Scan Surat Masuk" class="w-full object-contain max-h-[550px] mx-auto shadow-inner">
                        <div class="p-3 bg-slate-900/90 text-white flex items-center justify-between text-xs">
                            <span class="truncate">{{ basename($suratMasuk->file_lampiran) }}</span>
                            <a href="{{ $fileUrl }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-bold underline flex items-center gap-1">
                                <span>Buka Resolusi Penuh</span>
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                @elseif(strtolower($extension) === 'pdf')
                    <div class="rounded-2xl border-2 border-slate-200 overflow-hidden h-[550px]">
                        <iframe src="{{ $fileUrl }}" class="w-full h-full border-0"></iframe>
                    </div>
                @else
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 text-center space-y-3">
                        <i data-lucide="file" class="w-12 h-12 text-slate-400 mx-auto"></i>
                        <p class="text-xs text-slate-600 font-medium">Berkas format <strong>.{{ $extension }}</strong> terlampir.</p>
                        <a href="{{ $fileUrl }}" target="_blank" download class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold shadow">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            <span>Unduh Berkas</span>
                        </a>
                    </div>
                @endif
            @else
                <div class="p-8 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 text-center space-y-3">
                    <i data-lucide="archive" class="w-12 h-12 text-slate-400 mx-auto"></i>
                    <h4 class="text-xs font-bold text-slate-800">Tidak Ada Unggahan File Digital</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Surat fisik aslinya disimpan rapi pada: <strong class="text-slate-800">{{ $suratMasuk->lokasi_arsip_fisik ?: 'Ordner Surat Masuk' }}</strong>. Anda tetap dapat mencetak lembar disposisi untuk pengurus lainnya.
                    </p>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection

