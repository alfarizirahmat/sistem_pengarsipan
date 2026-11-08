@extends('layouts.app')

@section('title', 'Masukkan Dokumen Surat RT & Terbitkan Kode Warga')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 py-2 sm:py-4"
     x-data="{
        namaLengkap: '{{ old('nama_lengkap', '') }}',
        nik: '{{ old('nik', '') }}',
        jenisSurat: '{{ old('jenis_surat', 'keterangan_domisili') }}',
        nomorSurat: '{{ old('nomor_surat', $autoNomorSurat) }}',
        tanggalSurat: '{{ old('tanggal_surat', date('Y-m-d')) }}',
        keperluan: '{{ old('keperluan', '') }}',
        
        // Berkas Dokumen Surat
        previewUrl: null,
        fileName: '',
        fileSize: '',
        fileType: '', // 'image', 'pdf', ''

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

    <!-- HEADER RESMI -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                    Pelayanan Cepat RT
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">RT 005 / RW 013 Perumahan Bumi Mutiara Indah II</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                Masukkan Dokumen Surat &amp; Terbitkan Kode
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Unggah dokumen surat yang sudah dibuat (PDF / Foto). Sistem otomatis membuatkan kode surat untuk diambil warga via website.
            </p>
        </div>

        <a href="{{ route('surat-pengantar.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3.5 py-2.5 rounded-xl transition-colors self-start sm:self-center">
            <i data-lucide="list" class="w-4 h-4"></i>
            <span>Daftar Arsip Surat</span>
        </a>
    </div>

    <!-- GRID FORM & LIVE PREVIEW (RESPONSIF: 1 KOLOM DI HP, 2 KOLOM DI LAPTOP) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: FORMULIR INPUT & UPLOAD (LG: 6 KOLOM) -->
        <div class="lg:col-span-6 space-y-5">
            <form action="{{ route('surat-pengantar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- BAGIAN 1: IDENTITAS PEMOHON -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-xl bg-blue-700 text-white font-black text-xs flex items-center justify-center">1</span>
                        <div>
                            <h2 class="text-xs font-black uppercase tracking-wider text-slate-900">Identitas Warga Pemohon</h2>
                            <p class="text-[11px] text-slate-400">Ketik nama dan/atau NIK warga penerima surat</p>
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
                                    Jenis Kelamin
                                </label>
                                <select name="jenis_kelamin" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-600">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: DATA SURAT -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-xl bg-blue-700 text-white font-black text-xs flex items-center justify-center">2</span>
                        <div>
                            <h2 class="text-xs font-black uppercase tracking-wider text-slate-900">Data Surat Pengantar</h2>
                            <p class="text-[11px] text-slate-400">Nomor surat dan jenis keperluan warga</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                    Nomor Surat Pengantar <span class="text-red-500">*</span>
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
                                Jenis Pelayanan Surat <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_surat" 
                                    x-model="jenisSurat" 
                                    required 
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:ring-2 focus:ring-blue-600">
                                <option value="keterangan_domisili">Surat Keterangan Domisili Tempat Tinggal</option>
                                <option value="ktp_baru">Pengantar Pembuatan / Perpanjangan KTP</option>
                                <option value="perubahan_kk">Pengantar Perubahan / Pembuatan KK</option>
                                <option value="sktm">Surat Keterangan Tidak Mampu (SKTM)</option>
                                <option value="sku">Surat Keterangan Usaha (SKU)</option>
                                <option value="pindah_domisili">Surat Pengantar Pindah Domisili</option>
                                <option value="warga_datang">Surat Keterangan Warga Datang</option>
                                <option value="kehilangan_dokumen">Surat Keterangan Kehilangan Dokumen</option>
                                <option value="kematian">Surat Keterangan Kematian</option>
                                <option value="lainnya">Keperluan Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Catatan / Perihal Keperluan (Opsional):
                            </label>
                            <textarea name="keperluan" 
                                      x-model="keperluan" 
                                      rows="2" 
                                      placeholder="Contoh: Pengurusan rekening bank perumahan / perpanjangan kerja"
                                      class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-blue-600"></textarea>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: MASUKKAN DOKUMEN SURAT YANG SUDAH DIBUAT (UNGGAH BERKAS) -->
                <div class="bg-white rounded-2xl p-5 border-2 border-dashed border-emerald-300 bg-emerald-50/20 shadow-xs space-y-3">
                    <div class="flex items-center justify-between pb-2 border-b border-emerald-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center">3</span>
                            <div>
                                <h2 class="text-xs font-black uppercase tracking-wider text-slate-900">Masukkan Dokumen Surat RT</h2>
                                <p class="text-[11px] text-slate-500">Pilih berkas surat yang sudah dibuat (PDF / Foto scan HP)</p>
                            </div>
                        </div>

                        <template x-if="fileName">
                            <button type="button" @click="resetFile()" class="text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                <span>Ganti Berkas</span>
                            </button>
                        </template>
                    </div>

                    <!-- Area Input File -->
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
                                <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                            </div>
                            <span class="font-extrabold text-xs sm:text-sm text-slate-800 block">
                                Klik untuk Memilih Dokumen Surat (PDF / Foto)
                            </span>
                            <span class="text-[11px] text-slate-400 mt-0.5 block">
                                Format didukung: PDF, Foto Kamera (JPG, PNG). Maksimal 15 MB.
                            </span>
                        </label>
                    </div>

                    <!-- Indikator Berkas Terpilih -->
                    <template x-if="fileName">
                        <div class="p-3 bg-white rounded-xl border border-emerald-200 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5 truncate">
                                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    <span x-text="fileType === 'pdf' ? 'PDF' : 'IMG'"></span>
                                </div>
                                <div class="truncate">
                                    <span class="font-bold text-slate-900 block truncate" x-text="fileName"></span>
                                    <span class="text-[10px] text-slate-400 font-medium" x-text="fileSize"></span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md flex-shrink-0">
                                Siap Dikirim
                            </span>
                        </div>
                    </template>
                </div>

                <!-- TOMBOL SUBMIT & TERBITKAN KODE -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm sm:text-base py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all active:scale-[0.99] flex items-center justify-center gap-2.5">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>Masukkan Surat &amp; Buat Kode Warga</span>
                    </button>
                    <p class="text-[11px] text-slate-400 text-center mt-2">
                        Sistem akan langsung menerbitkan Kode Pelacakan unik untuk warga setelah tombol ditekan.
                    </p>
                </div>

            </form>
        </div>

        <!-- KOLOM KANAN: LIVE PREVIEW DOKUMEN (LG: 6 KOLOM) -->
        <div class="lg:col-span-6 space-y-3">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <i data-lucide="eye" class="w-4 h-4 text-slate-600"></i>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-700">
                        Pratinjau Dokumen Surat
                    </h3>
                </div>
                <span class="text-[11px] font-semibold text-slate-400" x-text="fileName ? 'Tampilan Dokumen Terpilih' : 'Pratinjau Awal'"></span>
            </div>

            <!-- CONTAINER PRATINJAU DOKUMEN -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-5 min-h-[460px] flex flex-col justify-between">
                
                <!-- 1. JIKA USER UPLOAD FOTO / SCAN DOKUMEN -->
                <template x-if="fileType === 'image' && previewUrl">
                    <div class="space-y-3">
                        <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl overflow-hidden flex items-center justify-center max-h-[500px]">
                            <img :src="previewUrl" alt="Pratinjau Dokumen Surat" class="max-h-[480px] w-auto object-contain rounded-lg shadow-xs">
                        </div>
                        <div class="text-center">
                            <span class="text-xs font-bold text-slate-800" x-text="fileName"></span>
                            <p class="text-[11px] text-slate-400">Foto dokumen surat berhasil dimuat dan siap diterbitkan ke warga.</p>
                        </div>
                    </div>
                </template>

                <!-- 2. JIKA USER UPLOAD FILE PDF -->
                <template x-if="fileType === 'pdf' && previewUrl">
                    <div class="space-y-3">
                        <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50 h-[480px]">
                            <iframe :src="previewUrl" class="w-full h-full rounded-lg" frameborder="0"></iframe>
                        </div>
                        <div class="text-center">
                            <span class="text-xs font-bold text-slate-800" x-text="fileName"></span>
                            <p class="text-[11px] text-slate-400">Berkas PDF berhasil dimuat. Warga akan dapat mengunduh dokumen ini dengan kode surat.</p>
                        </div>
                    </div>
                </template>

                <!-- 3. JIKA BELUM ADA BERKAS YANG DIUPLOAD (TAMPILAN LEMBAR DINAS RESMI RT) -->
                <template x-if="!previewUrl">
                    <div class="space-y-4">
                        <!-- Lembar Pratinjau Kertas Resmi RT -->
                        <div class="border-2 border-slate-200 rounded-xl p-5 bg-slate-50/50 space-y-3 font-serif">
                            <!-- Kop Surat -->
                            <div class="text-center border-b-2 border-slate-800 pb-3 font-sans">
                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 leading-tight">RUKUN TETANGGA (RT) 005 / RW 013</h4>
                                <h5 class="text-[10px] font-bold uppercase tracking-wider text-slate-800 leading-tight">PERUMAHAN BUMI MUTIARA INDAH II</h5>
                                <p class="text-[8px] italic text-slate-500 mt-0.5">Sekretariat: Perumahan Bumi Mutiara Indah II, RT 005 / RW 013</p>
                            </div>

                            <!-- Judul Surat -->
                            <div class="text-center font-sans py-1">
                                <div class="font-bold underline text-xs tracking-wider">SURAT PENGANTAR</div>
                                <div class="text-[10px] font-bold text-slate-700" x-text="'Nomor: ' + nomorSurat"></div>
                            </div>

                            <p class="text-[10px] text-justify indent-3 font-sans leading-relaxed text-slate-700">
                                Yang bertanda tangan di bawah ini Ketua Rukun Tetangga (RT) 005 RW 013 Perumahan Bumi Mutiara Indah II menerangkan bahwa:
                            </p>

                            <!-- Data Pemohon -->
                            <div class="space-y-1 font-sans text-[10px] bg-white p-3 rounded-lg border border-slate-200">
                                <div class="grid grid-cols-12">
                                    <span class="col-span-4 text-slate-500">Nama Pemohon</span>
                                    <span class="col-span-1">:</span>
                                    <strong class="col-span-7 font-bold text-slate-900 uppercase" x-text="namaLengkap || '(Belum diisi)'"></strong>
                                </div>
                                <div class="grid grid-cols-12">
                                    <span class="col-span-4 text-slate-500">NIK KTP</span>
                                    <span class="col-span-1">:</span>
                                    <span class="col-span-7 font-mono font-bold text-slate-800" x-text="nik || '-'"></span>
                                </div>
                                <div class="grid grid-cols-12">
                                    <span class="col-span-4 text-slate-500">Keperluan</span>
                                    <span class="col-span-1">:</span>
                                    <span class="col-span-7 text-slate-800 capitalize" x-text="jenisSurat.replace(/_/g, ' ')"></span>
                                </div>
                            </div>

                            <div class="p-3 bg-amber-50 rounded-lg border border-amber-200 text-center font-sans">
                                <p class="text-[11px] font-bold text-amber-900">
                                    Pilih &amp; Unggah Dokumen Surat Asli Anda di formulir sebelah kiri
                                </p>
                                <p class="text-[10px] text-amber-700 mt-0.5">
                                    Dokumen berupa foto scan atau PDF akan langsung tampil di sini dan dapat dicek warga.
                                </p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Footer Pratinjau -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span>RT 005 / RW 013 Bumi Mutiara Indah II</span>
                    <span class="font-mono text-[10px]">Token Otomatis: BMI2-XXXXXX</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
