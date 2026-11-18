@extends('layouts.app')

@section('title', 'Pelayanan Surat Pengantar Warga')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, activeSurat: null, showUploadModal: false, uploadSurat: null }">

    <!-- Header & Tombol Tambah Surat -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200">
                    Buku Register Surat
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">RT 005 / RW 013 Perumahan Bumi Mutiara Indah II</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1">Pelayanan Surat Pengantar Warga</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola permohonan surat dari warga, sahkan tanda tangan digital &amp; QR, serta berikan kode pelacakan kepada pemohon.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('surat-pengantar.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-xs sm:text-sm font-bold px-5 py-3 rounded-xl shadow-xs transition-colors w-full sm:w-auto">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>+ Buat Surat Langsung</span>
            </a>
        </div>
    </div>

    <!-- TAB FILTER STATUS SURAT -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2 overflow-x-auto text-xs font-bold">
        <a href="{{ route('surat-pengantar.index') }}" 
           class="px-4 py-2 rounded-xl transition-colors flex items-center gap-2 {{ empty($status) ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Semua Surat</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ empty($status) ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $totalSurat }}</span>
        </a>

        <a href="{{ route('surat-pengantar.index', ['status' => 'menunggu_validasi']) }}" 
           class="px-4 py-2 rounded-xl transition-colors flex items-center gap-2 {{ $status === 'menunggu_validasi' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Ajuan Warga (Perlu Validasi)</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'menunggu_validasi' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-800' }}">{{ $totalMenunggu }}</span>
        </a>

        <a href="{{ route('surat-pengantar.index', ['status' => 'selesai']) }}" 
           class="px-4 py-2 rounded-xl transition-colors flex items-center gap-2 {{ $status === 'selesai' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <span>Surat Selesai / Terbit</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'selesai' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800' }}">{{ $totalSelesai }}</span>
        </a>
    </div>

    <!-- Kotak Pencarian & Filter Ringkas -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-xs">
        <form action="{{ route('surat-pengantar.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <input type="hidden" name="status" value="{{ $status }}">
            
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">Cari Nama / NIK / No. Surat / Kode:</label>
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama warga, NIK, nomor surat, atau kode BMI2-..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Arsip:</label>
                <select name="tahun" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-blue-600">
                    <option value="">Semua Tahun</option>
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Surat:</label>
                <select name="jenis" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-blue-600">
                    <option value="">Semua Jenis</option>
                    <option value="ktp_baru" {{ $jenis === 'ktp_baru' ? 'selected' : '' }}>KTP Baru</option>
                    <option value="perubahan_kk" {{ $jenis === 'perubahan_kk' ? 'selected' : '' }}>Perubahan KK</option>
                    <option value="keterangan_domisili" {{ $jenis === 'keterangan_domisili' ? 'selected' : '' }}>Keterangan Domisili</option>
                    <option value="sktm" {{ $jenis === 'sktm' ? 'selected' : '' }}>SKTM</option>
                    <option value="sku" {{ $jenis === 'sku' ? 'selected' : '' }}>SKU</option>
                    <option value="pindah_domisili" {{ $jenis === 'pindah_domisili' ? 'selected' : '' }}>Pindah Domisili</option>
                    <option value="kehilangan_dokumen" {{ $jenis === 'kehilangan_dokumen' ? 'selected' : '' }}>Kehilangan Dokumen</option>
                    <option value="kematian" {{ $jenis === 'kematian' ? 'selected' : '' }}>Kematian</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Tabel Arsip Surat Pengantar -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase text-[11px] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Nomor &amp; Kode Warga</th>
                        <th class="px-5 py-3.5">Pemohon (Warga)</th>
                        <th class="px-5 py-3.5">Keperluan &amp; Kategori</th>
                        <th class="px-5 py-3.5">Status Dokumen</th>
                        <th class="px-5 py-3.5 text-center">Aksi Pelayanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($surats as $s)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Nomor & Token Warga -->
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-extrabold text-slate-900 font-mono text-xs block">{{ $s->nomor_surat }}</span>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="font-mono text-[11px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                                    {{ $s->qr_token ?: 'BMI2-'.str_pad($s->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                                <button type="button" 
                                        onclick="navigator.clipboard.writeText('{{ $s->qr_token }}'); alert('Kode surat disalin: {{ $s->qr_token }}')" 
                                        class="text-slate-400 hover:text-blue-700 p-0.5" 
                                        title="Salin kode surat untuk dikirim ke warga">
                                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Tgl: {{ \Carbon\Carbon::parse($s->tanggal_surat)->format('d/m/Y') }}</span>
                        </td>

                        <!-- Pemohon -->
                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $s->warga->nama_lengkap ?? 'Warga' }}</div>
                            <div class="text-[11px] text-slate-500 font-mono">NIK: {{ $s->warga->nik ?? '-' }}</div>
                            <div class="text-[11px] text-slate-500 truncate max-w-xs">{{ $s->warga->keluarga->alamat ?? 'RT 005 / RW 013' }}</div>
                        </td>

                        <!-- Keperluan -->
                        <td class="px-5 py-4">
                            <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 uppercase mb-1">
                                {{ str_replace('_', ' ', $s->jenis_surat) }}
                            </span>
                            <p class="text-xs text-slate-700 line-clamp-2">{{ $s->keperluan }}</p>
                            @if($s->dokumen_hilang)
                                <span class="text-[10px] font-semibold text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200 mt-1 inline-block">
                                    Dokumen Terkait: {{ $s->dokumen_hilang }}
                                </span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($s->status === 'menunggu_validasi')
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-800 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-300">
                                    <i data-lucide="clock" class="w-3 h-3 text-amber-600"></i>
                                    <span>Menunggu Validasi</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-300">
                                    <i data-lucide="check-circle" class="w-3 h-3 text-emerald-600"></i>
                                    <span>Sah / Selesai</span>
                                </span>
                            @endif
                        </td>

                        <!-- Aksi Pelayanan -->
                        <td class="px-5 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($s->status === 'menunggu_validasi')
                                    <!-- Tombol Masukkan Surat RT yang Sudah Dibuat -->
                                    <button type="button" 
                                            @click="uploadSurat = {{ Js::from($s) }}; showUploadModal = true" 
                                            class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 shadow-2xs transition-colors whitespace-nowrap"
                                            title="Unggah / Masukkan Dokumen Surat Jadi dari Pak RT">
                                        <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                        <span>+ Masukkan Surat RT</span>
                                    </button>
                                @else
                                    @if($s->file_dokumen)
                                        <button type="button" 
                                                @click="uploadSurat = {{ Js::from($s) }}; showUploadModal = true" 
                                                class="px-2 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-lg text-xs font-semibold flex items-center gap-1 border border-emerald-200 transition-colors"
                                                title="Ganti Berkas Dokumen Surat RT">
                                            <i data-lucide="file-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                            <span class="text-[10px]">Ganti Berkas</span>
                                        </button>
                                    @else
                                        <button type="button" 
                                                @click="uploadSurat = {{ Js::from($s) }}; showUploadModal = true" 
                                                class="px-2 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold flex items-center gap-1 transition-colors"
                                                title="Unggah Berkas Dokumen Surat RT">
                                            <i data-lucide="upload" class="w-3.5 h-3.5 text-slate-500"></i>
                                            <span class="text-[10px]">+ Berkas</span>
                                        </button>
                                    @endif
                                @endif

                                <!-- Tombol Salin Pesan WA -->
                                @php
                                    $linkWarga = route('portal.warga', ['kode' => $s->qr_token]);
                                    if ($s->status === 'selesai') {
                                        $pesanWa = "Halo Bapak/Ibu " . ($s->warga->nama_lengkap ?? 'Warga') . ", Surat Pengantar RT 005 RW 013 Anda telah selesai dibuat & disahkan oleh Pak RT. Kode Surat: *" . $s->qr_token . "*. Silakan periksa & unduh berkas surat di: " . $linkWarga;
                                    } else {
                                        $pesanWa = "Halo Bapak/Ibu " . ($s->warga->nama_lengkap ?? 'Warga') . ", Permohonan Surat Pengantar RT 005 RW 013 Anda telah kami terima dan sedang diproses oleh Pak RT. Kode Pelacakan: *" . $s->qr_token . "*. Silakan pantau status di: " . $linkWarga;
                                    }
                                @endphp
                                <button type="button" 
                                        onclick="navigator.clipboard.writeText('{{ addslashes($pesanWa) }}'); alert('Teks pesan WhatsApp berhasil disalin ke clipboard! Silakan paste langsung di chat warga.');"
                                        class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold flex items-center gap-1 border border-emerald-200 transition-colors"
                                        title="Salin Pesan WA untuk Warga">
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>WA</span>
                                </button>

                                <!-- Tombol Lihat Surat -->
                                <button type="button" @click="activeSurat = {{ Js::from($s) }}; showModal = true" 
                                    class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg text-xs font-semibold flex items-center gap-1 transition-colors">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>Lihat</span>
                                </button>

                                <!-- Tombol Cetak Langsung -->
                                <a href="{{ route('surat-pengantar.print', $s) }}" target="_blank" 
                                    class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold flex items-center gap-1 border border-blue-200 transition-colors" title="Buka format cetak A4">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                </a>

                                <!-- Tombol Hapus Surat -->
                                <form action="{{ route('surat-pengantar.destroy', $s) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip surat pengantar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-700 rounded-lg text-xs font-semibold transition-colors" title="Hapus Surat">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i data-lucide="file-question" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                            <p class="font-medium text-xs">Tidak ada surat pengantar yang cocok dengan filter pencarian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($surats->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $surats->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL PRATINJAU SURAT RESMI -->
    <div x-show="showModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
         style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);">
        
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-3xl overflow-hidden my-8"
             @click.away="showModal = false">

            <!-- Modal Header Toolbar -->
            <div class="px-5 py-3.5 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>
                    <h3 class="font-bold text-xs sm:text-sm text-white">Lembar Surat Pengantar Digital RT 005</h3>
                </div>

                <div class="flex items-center gap-2">
                    <template x-if="activeSurat">
                        <a :href="'/surat-pengantar/' + activeSurat.id + '/print'" target="_blank"
                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-lg shadow-xs flex items-center gap-1.5 transition-colors">
                            <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                            <span>Cetak A4 / PDF</span>
                        </a>
                    </template>
                    <button type="button" @click="showModal = false" 
                        class="p-1 text-slate-400 hover:text-white rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body: Lembar Kertas Dokumen Fisik A4 -->
            <div class="p-4 sm:p-8 overflow-y-auto max-h-[75vh] bg-slate-100 font-serif">
                <div class="bg-white p-6 sm:p-10 rounded-xl shadow-xs border border-slate-300 text-black leading-relaxed">
                    
                    <!-- KOP SURAT RT 005 / RW 013 -->
                    <div class="text-center pb-2 border-b-[2px] border-black">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-black">PENGURUS RUKUN TETANGGA 005 / RUKUN WARGA 013</h4>
                        <h3 class="text-base font-black uppercase tracking-wider text-black mt-0.5">PERUMAHAN BUMI MUTIARA INDAH II</h3>
                        <p class="text-[9px] text-slate-700 font-sans mt-0.5">Sekretariat: Perumahan Bumi Mutiara Indah II, RT 005 / RW 013</p>
                    </div>
                    <div class="border-b border-black mb-4 mt-0.5"></div>

                    <!-- Judul & Nomor Surat -->
                    <div class="text-center mb-4">
                        <h4 class="text-sm sm:text-base font-bold uppercase underline tracking-wider">SURAT PENGANTAR</h4>
                        <p class="text-xs font-mono font-bold mt-0.5" x-text="activeSurat ? 'Nomor: ' + activeSurat.nomor_surat : ''"></p>
                    </div>

                    <p class="text-xs sm:text-sm text-justify mb-3">
                        Yang bertanda tangan di bawah ini Ketua Rukun Tetangga (RT) 005 / RW 013 Perumahan Bumi Mutiara Indah II, dengan ini menerangkan bahwa:
                    </p>

                    <!-- Data Warga -->
                    <template x-if="activeSurat && activeSurat.warga">
                        <div class="text-xs sm:text-sm mb-4 pl-2 sm:pl-4 space-y-1 font-sans">
                            <div class="flex">
                                <span class="w-36 text-slate-600">Nama Lengkap</span>
                                <span class="mr-2">:</span>
                                <strong class="font-bold uppercase" x-text="activeSurat.warga.nama_lengkap"></strong>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-slate-600">NIK</span>
                                <span class="mr-2">:</span>
                                <span class="font-mono font-bold" x-text="activeSurat.warga.nik"></span>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-slate-600">Alamat</span>
                                <span class="mr-2">:</span>
                                <span x-text="activeSurat.warga.keluarga ? activeSurat.warga.keluarga.alamat : 'Perumahan Bumi Mutiara Indah II'"></span>
                            </div>
                        </div>
                    </template>

                    <p class="text-xs sm:text-sm text-justify mb-2">
                        Adalah benar warga yang bertempat tinggal di lingkungan kami, dan surat pengantar ini diberikan untuk keperluan:
                    </p>

                    <div class="my-2 p-2.5 bg-slate-50 border-l-3 border-black text-xs font-bold font-sans">
                        <span x-text="activeSurat ? activeSurat.keperluan : ''"></span>
                    </div>

                    <p class="text-xs sm:text-sm text-justify mb-6">
                        Demikian surat pengantar ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
                    </p>

                    <div class="flex justify-between items-end text-xs font-sans mt-6 pt-4">
                        <div class="text-center w-36">
                            <p class="mb-14">Pemohon,</p>
                            <p class="font-bold underline uppercase" x-text="activeSurat && activeSurat.warga ? activeSurat.warga.nama_lengkap : 'Pemohon'"></p>
                        </div>
                        <div class="text-center w-48">
                            <p class="text-[10px] text-slate-600 mb-1">Bumi Mutiara Indah II</p>
                            <p class="font-bold" x-text="activeSurat ? activeSurat.penandatangan_jabatan : 'Ketua RT 005'"></p>
                            <div class="h-16 flex items-center justify-center my-1">
                                <span class="text-[9px] font-mono text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200" x-text="activeSurat ? 'Token: ' + activeSurat.qr_token : ''"></span>
                            </div>
                            <p class="font-bold underline uppercase" x-text="activeSurat ? activeSurat.penandatangan_nama : 'Ketua RT 005'"></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL MASUKKAN SURAT YANG SUDAH DIBIKIN OLEH RT (ADMIN) -->
    <div x-show="showUploadModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
         style="background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px);">
        
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden my-8"
             @click.away="showUploadModal = false">
             
            <!-- Header Modal -->
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white flex-shrink-0">
                        <i data-lucide="upload" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-sm sm:text-base text-white">Masukkan Dokumen Surat Jadi dari RT</h3>
                        <p class="text-xs text-slate-400">Unggah berkas resmi (PDF / Foto Scan) untuk disahkan & diterbitkan ke warga</p>
                    </div>
                </div>
                <button type="button" @click="showUploadModal = false" class="p-1.5 text-slate-400 hover:text-white rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Body Modal -->
            <template x-if="uploadSurat">
                <form :action="'{{ url('surat-pengantar') }}/' + uploadSurat.id + '/validasi'" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="p-6 space-y-4">
                    @csrf

                    <!-- Ringkasan Pemohon -->
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div>
                            <span class="text-slate-400 block font-semibold">Nama Pemohon:</span>
                            <span class="font-extrabold text-slate-900 text-sm" x-text="uploadSurat.warga ? uploadSurat.warga.nama_lengkap : 'Warga'"></span>
                            <span class="text-slate-500 block font-mono" x-text="'NIK: ' + (uploadSurat.warga ? uploadSurat.warga.nik : '-')"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-semibold">Jenis & Keperluan Surat:</span>
                            <span class="font-bold text-blue-700 uppercase" x-text="uploadSurat.jenis_surat ? uploadSurat.jenis_surat.replace(/_/g, ' ') : '-'"></span>
                            <p class="text-slate-600 italic mt-0.5 line-clamp-2" x-text="uploadSurat.keperluan"></p>
                        </div>
                    </div>

                    <!-- Input Form -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor Surat Resmi <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_surat" :value="uploadSurat.nomor_surat" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Surat <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_surat" :value="uploadSurat.tanggal_surat ? uploadSurat.tanggal_surat.substring(0, 10) : '{{ date('Y-m-d') }}'" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>

                    <!-- Area Unggah Berkas Dokumen -->
                    <div class="p-4 bg-emerald-50/50 rounded-2xl border-2 border-dashed border-emerald-300 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-black uppercase text-emerald-900">
                                Berkas Dokumen Surat yang Dibuat RT (PDF / Foto Scan)
                            </label>
                            <template x-if="uploadSurat.file_dokumen">
                                <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full">
                                    Sudah Ada Berkas Sebelumnya
                                </span>
                            </template>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Pilih file scan surat/dokumen yang sudah ditandatangani dan dicap oleh Pak RT. Setelah disimpan, warga dapat langsung mengunduh berkas ini di website melalui kode pelacakan mereka.
                        </p>
                        <input type="file" name="file_dokumen" accept=".pdf,.png,.jpg,.jpeg,.webp" class="w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Penandatangan</label>
                            <input type="text" name="penandatangan_nama" :value="uploadSurat.penandatangan_nama || '{{ auth()->user()->name ?? 'Bapak Hartono' }}'" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan Penandatangan</label>
                            <input type="text" name="penandatangan_jabatan" :value="uploadSurat.penandatangan_jabatan || '{{ auth()->user()->jabatan ?? 'Ketua RT 005' }}'" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium">
                        </div>
                    </div>

                    <!-- Tombol Aksi Modal -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                        <button type="button" @click="showUploadModal = false" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Simpan & Terbitkan ke Warga</span>
                        </button>
                    </div>
                </form>
            </template>

        </div>
    </div>

</div>
@endsection
