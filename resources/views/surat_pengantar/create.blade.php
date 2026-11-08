@extends('layouts.app')

@section('title', 'Unggah Dokumen Surat & Terbitkan Kode Warga')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 py-2 sm:py-4"
     x-data="{
        namaLengkap: '{{ old('nama_lengkap', '') }}',
        nik: '{{ old('nik', '') }}',
        jenisSurat: '{{ old('jenis_surat', 'keterangan_domisili') }}',
        nomorSurat: '{{ old('nomor_surat', $autoNomorSurat) }}',
        tanggalSurat: '{{ old('tanggal_surat', date('Y-m-d')) }}',
        keperluan: '{{ old('keperluan', '') }}',
        
        // Berkas Dokumen Surat (PDF / Foto)
        previewUrl: null,
        fileName: '',
        fileSize: '',
        fileType: '', // 'pdf', 'image', ''

        handleDocUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.fileName = file.name;
            this.fileSize = (file.size / (1024 * 1024) >= 1) 
                ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' 
                : Math.round(file.size / 1024) + ' KB';

            const ext = file.name.split('.').pop().toLowerCase();
            if (ext === 'pdf') {
                this.fileType = 'pdf';
                this.previewUrl = URL.createObjectURL(file);
            } else if (['jpg', 'jpeg', 'png', 'webp'].includes(ext)) {
                this.fileType = 'image';
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.fileType = 'other';
                this.previewUrl = null;
            }
        },

        resetFile() {
            this.previewUrl = null;
            this.fileName = '';
            this.fileSize = '';
            this.fileType = '';
            const input = document.getElementById('file_dokumen_input');
            if (input) input.value = '';
        }
     }">

    <!-- HEADER HALAMAN -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                    Pelayanan Surat RT
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">RT 005 / RW 013 Perumahan Bumi Mutiara Indah II</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                Unggah Dokumen Surat &amp; Terbitkan Kode
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Unggah berkas surat yang sudah selesai dibuat (PDF / Foto scan). Sistem otomatis menerbitkan kode unik bagi warga.
            </p>
        </div>

        <a href="{{ route('surat-pengantar.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-4 py-2.5 rounded-xl transition-colors self-start sm:self-center">
            <i data-lucide="folder-archive" class="w-4 h-4 text-slate-500"></i>
            <span>Daftar Arsip Surat</span>
        </a>
    </div>

    <!-- TAMPILAN 2 KOLOM: KIRI FORMULIR, KANAN PRATINJAU DOKUMEN ASLI -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: FORMULIR RINGKAS & SIMPLE (6 KOLOM) -->
        <div class="lg:col-span-6 space-y-4">
            <form action="{{ route('surat-pengantar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- KARTU DATA SURAT & PEMOHON -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-blue-700 text-white flex items-center justify-center font-black text-xs">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h2 class="text-xs font-black uppercase tracking-wider text-slate-900">1. Data Warga Pemohon</h2>
                            <p class="text-[11px] text-slate-400">Masukkan nama dan NIK warga penerima surat</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Nama Lengkap Pemohon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_lengkap" 
                                   x-model="namaLengkap" 
                                   value="{{ old('nama_lengkap') }}"
                                   placeholder="Contoh: Budi Santoso" 
                                   required
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    NIK (Nomor KTP)
                                </label>
                                <input type="text" 
                                       name="nik" 
                                       x-model="nik" 
                                       value="{{ old('nik') }}"
                                       maxlength="16"
                                       placeholder="16 Digit NIK (Opsional)" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Jenis Pelayanan Surat <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_surat" 
                                        x-model="jenisSurat" 
                                        required 
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:ring-2 focus:ring-blue-600">
                                    <option value="keterangan_domisili">Surat Keterangan Domisili</option>
                                    <option value="ktp_baru">Pengantar KTP</option>
                                    <option value="perubahan_kk">Pengantar KK</option>
                                    <option value="sktm">Surat Ket. Tidak Mampu (SKTM)</option>
                                    <option value="sku">Surat Keterangan Usaha (SKU)</option>
                                    <option value="pindah_domisili">Surat Pindah Domisili</option>
                                    <option value="warga_datang">Surat Warga Datang</option>
                                    <option value="kehilangan_dokumen">Surat Kehilangan</option>
                                    <option value="kematian">Surat Keterangan Kematian</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Nomor Surat <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nomor_surat" 
                                       x-model="nomorSurat" 
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 focus:ring-2 focus:ring-blue-600">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Tanggal Surat <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="tanggal_surat" 
                                       x-model="tanggalSurat" 
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:ring-2 focus:ring-blue-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Catatan / Keperluan Tambahan (Opsional)
                            </label>
                            <input type="text" 
                                   name="keperluan" 
                                   x-model="keperluan" 
                                   placeholder="Contoh: Pengurusan rekening bank / izin kerja" 
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>
                </div>

                <!-- KARTU UNGGAH DOKUMEN SURAT -->
                <div class="bg-white rounded-2xl p-5 sm:p-6 border-2 border-dashed border-emerald-300 bg-emerald-50/20 shadow-xs space-y-3">
                    <div class="flex items-center justify-between pb-2 border-b border-emerald-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-xs">
                                <i data-lucide="upload" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h2 class="text-xs font-black uppercase tracking-wider text-slate-900">2. Unggah Dokumen Surat</h2>
                                <p class="text-[11px] text-slate-500">Pilih berkas surat yang telah ditandatangani RT (PDF / Foto)</p>
                            </div>
                        </div>

                        <template x-if="fileName">
                            <button type="button" @click="resetFile()" class="text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1">
                                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                                <span>Ganti</span>
                            </button>
                        </template>
                    </div>

                    <!-- Area Dropzone / Klik File -->
                    <div>
                        <input type="file" 
                               name="file_dokumen" 
                               id="file_dokumen_input" 
                               accept=".pdf,.png,.jpg,.jpeg,.webp" 
                               @change="handleDocUpload($event)"
                               class="hidden">

                        <label for="file_dokumen_input" 
                               class="group block p-6 text-center rounded-xl border-2 border-dashed border-slate-300 hover:border-emerald-500 bg-white hover:bg-emerald-50/40 cursor-pointer transition-all">
                            <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                                <i data-lucide="file-up" class="w-6 h-6"></i>
                            </div>
                            <span class="font-extrabold text-xs sm:text-sm text-slate-800 block">
                                Klik untuk Memilih Dokumen Surat
                            </span>
                            <span class="text-[11px] text-slate-400 mt-0.5 block">
                                Format: PDF atau Foto Kamera (JPG, PNG). Maksimal 15 MB.
                            </span>
                        </label>
                    </div>

                    <!-- Keterangan Berkas Terpilih -->
                    <template x-if="fileName">
                        <div class="p-3 bg-white rounded-xl border border-emerald-200 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5 truncate">
                                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    <span x-text="fileType === 'pdf' ? 'PDF' : 'FOTO'"></span>
                                </div>
                                <div class="truncate">
                                    <span class="font-bold text-slate-900 block truncate" x-text="fileName"></span>
                                    <span class="text-[10px] text-slate-400 font-medium" x-text="fileSize"></span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md flex-shrink-0">
                                Siap Diunggah
                            </span>
                        </div>
                    </template>
                </div>

                <!-- TOMBOL SUBMIT & TERBITKAN KODE -->
                <div class="pt-1">
                    <button type="submit" 
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm sm:text-base py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all active:scale-[0.99] flex items-center justify-center gap-2.5">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>Unggah Dokumen &amp; Terbitkan Kode Warga</span>
                    </button>
                    <p class="text-[11px] text-slate-400 text-center mt-2">
                        Setelah disimpan, kode surat langsung dibuat untuk diberikan ke warga agar dapat diunduh di website.
                    </p>
                </div>

            </form>
        </div>

        <!-- KOLOM KANAN: MURNI PRATINJAU DOKUMEN YANG DIUPLOAD (BUKAN TEMPLATE SURAT) -->
        <div class="lg:col-span-6 space-y-3">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <i data-lucide="eye" class="w-4 h-4 text-slate-700"></i>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">
                        Pratinjau Dokumen Surat
                    </h3>
                </div>
                <template x-if="fileName">
                    <span class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Dokumen Terpilih
                    </span>
                </template>
            </div>

            <!-- CONTAINER PRATINJAU -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-5 min-h-[480px] flex flex-col justify-between">
                
                <!-- 1. JIKA USER UPLOAD FOTO / SCAN SURAT -->
                <template x-if="fileType === 'image' && previewUrl">
                    <div class="space-y-3">
                        <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl overflow-hidden flex items-center justify-center max-h-[520px]">
                            <img :src="previewUrl" alt="Pratinjau Dokumen Surat" class="max-h-[500px] w-auto object-contain rounded-lg shadow-xs">
                        </div>
                        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 block truncate" x-text="fileName"></span>
                                <span class="text-[10px] text-slate-500">Pratinjau foto dokumen surat yang akan diterima warga.</span>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-800 bg-white px-2 py-0.5 rounded border border-emerald-300" x-text="fileSize"></span>
                        </div>
                    </div>
                </template>

                <!-- 2. JIKA USER UPLOAD FILE PDF SURAT -->
                <template x-if="fileType === 'pdf' && previewUrl">
                    <div class="space-y-3">
                        <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50 h-[500px]">
                            <iframe :src="previewUrl" class="w-full h-full rounded-lg" frameborder="0"></iframe>
                        </div>
                        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 block truncate" x-text="fileName"></span>
                                <span class="text-[10px] text-slate-500">Pratinjau berkas PDF surat yang akan dapat diunduh warga.</span>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-800 bg-white px-2 py-0.5 rounded border border-emerald-300" x-text="fileSize"></span>
                        </div>
                    </div>
                </template>

                <!-- 3. JIKA BELUM ADA BERKAS YANG DIUNGGAH (TAMPILAN PLACEHOLDER BERSIH, BUKAN TEMPLATE SURAT) -->
                <template x-if="!previewUrl">
                    <div class="flex flex-col items-center justify-center text-center py-16 px-4 space-y-4 my-auto">
                        <div class="w-20 h-20 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center border-2 border-dashed border-slate-200">
                            <i data-lucide="file-text" class="w-10 h-10 stroke-[1.5]"></i>
                        </div>
                        <div class="max-w-xs space-y-1.5">
                            <h4 class="text-sm font-bold text-slate-800">
                                Belum Ada Dokumen Surat
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Pilih berkas surat (PDF atau Foto) pada formulir di sebelah kiri. Pratinjau dokumen surat yang Anda buat akan langsung tampil di sini.
                            </p>
                        </div>
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl text-[11px] text-blue-700 max-w-sm text-left flex items-start gap-2">
                            <i data-lucide="info" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5"></i>
                            <span>
                                Setelah Anda mengunggah dokumen dan menyimpannya, sistem akan membuatkan <strong>Kode Unik</strong> untuk diberikan kepada warga pemohon.
                            </span>
                        </div>
                    </div>
                </template>

                <!-- FOOTER PRATINJAU -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span>RT 005 / RW 013 Perumahan Bumi Mutiara Indah II</span>
                    <span class="font-mono text-[10px] bg-slate-100 px-2 py-0.5 rounded">Kode Otomatis</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
