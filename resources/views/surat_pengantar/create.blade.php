@extends('layouts.app')

@section('title', 'Buat Surat Pengantar Warga')
@section('header_title', 'Pembuatan Surat Pengantar RT')

@section('content')
<div class="space-y-6" 
     x-data="{ 
        jenisSurat: '{{ old('jenis_surat', 'kehilangan_dokumen') }}',
        keperluan: `{{ old('keperluan', 'Sebagai pengantar permohonan penerbitan kembali KTP Elektronik dan Kartu Keluarga (KK) ke Kantor Desa / Disdukcapil dikarenakan dokumen asli rusak / hilang.') }}`,
        dokumenHilang: `{{ old('dokumen_hilang', 'KTP Elektronik dan Kartu Keluarga (KK) Asli') }}`,
        selectedTemplate: 'banjir',
        nomorSurat: '{{ old('nomor_surat', $autoNomorSurat) }}',
        tanggalSurat: '{{ old('tanggal_surat', date('Y-m-d')) }}',
        penandatanganNama: '{{ old('penandatangan_nama', 'Hartono') }}',
        penandatanganJabatan: '{{ old('penandatangan_jabatan', 'Ketua RT 005') }}',
        ttdJenis: '{{ old('tanda_tangan_jenis', 'foto') }}',
        selectedWargaId: '{{ old('warga_id', $selectedWargaId) }}',
        namaLengkap: '{{ old('nama_lengkap', '') }}',
        nik: '{{ old('nik', '') }}',
        jenisKelamin: '{{ old('jenis_kelamin', 'L') }}',
        tempatLahir: '{{ old('tempat_lahir', 'Bogor') }}',
        tanggalLahir: '{{ old('tanggal_lahir', '1990-01-01') }}',
        pekerjaan: '{{ old('pekerjaan', 'Wiraswasta') }}',
        alamat: `{{ old('alamat', 'Perumahan Bumi Mutiara Indah II, RT 005 / RW 013') }}`,
        viewMode: (window.innerWidth >= 1024 ? 'split' : 'form'),
        
        // Preview Foto / Berkas TTD
        signaturePreview: '{{ old('tanda_tangan_digital', '') }}',
        uploadedFileName: '',
        isPdf: false,
        presetSignature: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAACgCAYAAAAisjrVAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFhElEQVR4nO3dUW7bOBQFUKfoArKrLCvIsrKr7CDzM5m6HsmWKYl87/EcoB8BipiiFF5dSm0uFwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACANi+jB9DL6+fH9/XXX2/v0xw7wBl+jR4AADlNESC37QOA/aYIkCVCBWCfaQMEgH0ECABNygeIrSqAc5QPkHuEC0C7qQMEgHalA8Q/HgQ4T+kAAeA8AgSAJtMFyO02lgfpAG3KBojnHwDnKhsgAJxLgADQpOS2zpbtK1tcAPtoIAA0ESAANBEgADT5PXoAR/NsYyzzD/OYtoH4B4XHM4cwl2kDhD6ECtRVKkBsn4wjKGA+pQKEMR4Ft3CBmqYOEAsdQLupA4T9bBvCvMoEiIWsv3tzrt1BfWUCpAoLLZCFAAno9fPjO3qQbGl8WgjUViJA9mxfRVnklkIj6oJruxC4XIoESGUZ2ggwJwESwJaAiBIiz7aPKA0POJ4ACejr7f1l7ZdgjVyAbV3FI5AZKX2AHLGoRb1LXjuWKOPbKur8Zjb6ZgIulwIBkt2jAIzSRrSPOLK8bEF9AiSJkW1EeMRw76ZBiDBC6gCZbWGL0kZa2Mbax3wRUeoAya41AHu2kdlCOpq1m4OlmwkhQ28C5F/Zfhh7tJGjwyPbHI+2Nj9CnCgESHJV3tTij2dah1BmpLQBkn1r5cjxn9FGss9vVloHmaQNEP7vqDZyZni4Y172TOtY+ju33+vo8cESAXKlwg9i5je1ZqV1kFXKC/TMO+QeWze9todaFqZRY5txsTw6OMwpvWkghT3bRixA/WgdVCBAJuBNrTj2POt4pMIWLLkIkM5G3eU/aiO9xzXjYqd1UE26ADl7oau+sG2ZLwvasc5sHUvf8/azj/z+cC1dgLDfGQtX6ziuv6642GkdVCZAOor2kHrp80ePqYqerWPpM27HcubnMa9UARJtAa7gekEzn8fQOphFqgDpZcY7uFGLW6W5Htk6lj7z+uvM80pcv0cPYBbaU133Fmfnmco0EIbLeLe89vrzjwgvKmScV3JJ00DcwRPBlkXYtcks0gRIZsIvt6137hHP69fb+8v1+F8/P74jjpOcbGGtUP/7ijbfj7aorkXYroIRUjQQd/D0krltrKnSQq6PIeP4K0oRIJkJv+1GLXTPtB3nr6+1cyNMYhAgTGm20MjWQp45P8JkHAFyR7YfOh6ruEVVxRHPvYRJX+EnePQW0J7PHz32rI6et9naxj3RrsnWc/Ns2Iw+zqo0EEoSGrHtbYLPholmco7wEzn6jkkDGaN17mxRPTbquuwR6ppJX6EbSOYFOPPYs9E24up9bjSTvkJPWJRFuGUcUcae1aP5Exr7nH19RmuCmsk5QjcQ5rX2Bly0hYk/Ioe6ZnKO0BMT5S7+2XFEGXd2La91muvtjrhOI4fGFprJPmEbiEWYrY3DtdFflSaomewTdgKiBcgz44k29sz8ethz7bmu78l+fjSTbaY86BZbf9CExzl+5tV8HsvLCo8Jk3XTHOheAoSqlq7ZKltURxMmfwv7DAQYw3OndZ6Z/K3cAZ1lS7PQPshKaOwzazMpcRC9PLtfXOUioT4vKxxnpjCxhQX8t4h5WWG/mba5Ug12tHsNQ/sA7qnYTDQQgA5am0nkIPk1egCZ7HlHHuDH19v7y8+f0WPZQwM5gO0roNWe37Q4mgABCCJbmAgQgIAy7GSEH+BWGdIaqC/Dwn8UD9EBaCJAAGgiQABoMs1e3ZH8v0EAGkgTQQEgQA4jVIDZCBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAtvsHi3ErT/W5y6IAAAAASUVORK5CYII=',

        // Data warga untuk live preview / pencarian
        wargasList: {{ Js::from($wargas) }},

        init() {
            if (this.selectedWargaId && this.wargasList.length > 0) {
                const found = this.wargasList.find(w => w.id == this.selectedWargaId);
                if (found) {
                    this.fillFromWarga(found);
                }
            }
            if (!this.signaturePreview) {
                this.signaturePreview = this.presetSignature;
            }
        },

        fillFromWarga(w) {
            if (!w) return;
            this.selectedWargaId = w.id;
            this.namaLengkap = w.nama_lengkap;
            this.nik = w.nik;
            this.jenisKelamin = w.jenis_kelamin || 'L';
            this.tempatLahir = w.tempat_lahir || 'Bogor';
            this.tanggalLahir = w.tanggal_lahir ? w.tanggal_lahir.substring(0, 10) : '1990-01-01';
            this.pekerjaan = w.pekerjaan || 'Wiraswasta';
            this.alamat = (w.keluarga && w.keluarga.alamat) ? w.keluarga.alamat : 'Perumahan Bumi Mutiara Indah II, RT 005 / RW 013';
        },
        
        applyTemplate(type) {
            this.selectedTemplate = type;
            if (type === 'banjir') {
                this.jenisSurat = 'kehilangan_dokumen';
                this.dokumenHilang = 'KTP Elektronik dan Kartu Keluarga (KK) Asli';
                this.keperluan = 'Sebagai pengantar permohonan penerbitan kembali KTP Elektronik dan Kartu Keluarga (KK) ke Kantor Desa / Disdukcapil dikarenakan dokumen asli rusak / hilang.';
            } else if (type === 'ktp') {
                this.jenisSurat = 'ktp_baru';
                this.dokumenHilang = '';
                this.keperluan = 'Sebagai pengantar permohonan perekaman dan penerbitan Kartu Tanda Penduduk Elektronik (KTP-el) baru ke Kantor Kelurahan / Kecamatan.';
            } else if (type === 'kk') {
                this.jenisSurat = 'perubahan_kk';
                this.dokumenHilang = '';
                this.keperluan = 'Sebagai pengantar permohonan pembaruan susunan anggota keluarga pada Kartu Keluarga (KK) dan penerbitan Akta Kelahiran anak ke Kantor Kelurahan.';
            } else if (type === 'domisili') {
                this.jenisSurat = 'keterangan_domisili';
                this.dokumenHilang = '';
                this.keperluan = 'Surat Keterangan bahwa yang bersangkutan adalah benar warga yang berdomisili dan tinggal menetap di lingkungan RT 005 / RW 013 Perumahan Bumi Mutiara Indah II untuk keperluan administrasi pekerjaan / perbankan.';
            } else if (type === 'pindah') {
                this.jenisSurat = 'pindah_domisili';
                this.dokumenHilang = '';
                this.keperluan = 'Sebagai pengantar permohonan Surat Keterangan Pindah Domisili Tempat Tinggal dari lingkungan RT 005 / RW 013 Perumahan Bumi Mutiara Indah II ke alamat tempat tinggal baru.';
            } else if (type === 'sktm') {
                this.jenisSurat = 'sktm';
                this.dokumenHilang = '';
                this.keperluan = 'Surat Keterangan Tidak Mampu (SKTM) untuk persyaratan pengajuan bantuan pendidikan / beasiswa sekolah / keringanan biaya pengobatan rumah sakit.';
            } else if (type === 'sku') {
                this.jenisSurat = 'sku';
                this.dokumenHilang = '';
                this.keperluan = 'Surat Keterangan Usaha (SKU) bahwa yang bersangkutan benar memiliki usaha aktif di lingkungan RT 005 / RW 013 Perumahan Bumi Mutiara Indah II untuk keperluan pengajuan permodalan / perbankan.';
            } else if (type === 'mati') {
                this.jenisSurat = 'kematian';
                this.dokumenHilang = '';
                this.keperluan = 'Surat Keterangan Kematian untuk pengurusan Akta Kematian dan keperluan administrasi pemakaman.';
            }
        },

        handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.uploadedFileName = file.name;
            const ext = file.name.split('.').pop().toLowerCase();
            this.ttdJenis = (ext === 'pdf') ? 'pdf' : 'foto';
            this.isPdf = (ext === 'pdf');

            if (ext === 'pdf') {
                this.signaturePreview = '';
                document.getElementById('tanda_tangan_digital_input').value = '';
            } else {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.signaturePreview = e.target.result;
                    document.getElementById('tanda_tangan_digital_input').value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        usePresetSignature() {
            this.ttdJenis = 'foto';
            this.isPdf = false;
            this.uploadedFileName = 'Foto TTD Resmi Pak RT (Tersimpan)';
            this.signaturePreview = this.presetSignature;
            document.getElementById('tanda_tangan_digital_input').value = this.presetSignature;
            const fileInput = document.getElementById('tanda_tangan_file_input');
            if (fileInput) fileInput.value = '';
        }
     }">

    <!-- Top Bar Navigation & Layar View Switcher -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/90 shadow-sm">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Sistem Pembuatan Surat & TTD RT</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium">Buat surat dengan template cepat, masukkan tanda tangan foto/PDF, dan sesuaikan tampilan layar.</p>
        </div>

        <!-- Tombol Pengatur Tampilan Layar (Sangat Fleksibel untuk Semua Device) -->
        <div class="flex items-center justify-center sm:justify-start gap-1.5 p-1.5 bg-slate-100 rounded-2xl border border-slate-200 w-full sm:w-auto">
            <button type="button" @click="viewMode = 'form'"
                :class="viewMode === 'form' ? 'bg-white text-emerald-800 shadow font-black' : 'text-slate-600 font-bold hover:text-slate-900'"
                class="flex-1 sm:flex-initial px-3.5 py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition-all min-h-[42px]">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Isi Form</span>
            </button>

            <button type="button" @click="viewMode = 'preview'"
                :class="viewMode === 'preview' ? 'bg-white text-emerald-800 shadow font-black' : 'text-slate-600 font-bold hover:text-slate-900'"
                class="flex-1 sm:flex-initial px-3.5 py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition-all min-h-[42px]">
                <i data-lucide="eye" class="w-4 h-4"></i>
                <span>Lihat Lembar A4</span>
            </button>

            <button type="button" @click="viewMode = 'split'"
                :class="viewMode === 'split' ? 'bg-white text-emerald-800 shadow font-black' : 'text-slate-600 font-bold hover:text-slate-900'"
                class="hidden lg:flex px-3.5 py-2.5 rounded-xl text-xs items-center gap-1.5 transition-all min-h-[42px]">
                <i data-lucide="columns-2" class="w-4 h-4"></i>
                <span>Berdampingan</span>
            </button>
        </div>
    </div>

    <!-- Container Grid Sesuai Mode Tampilan (Split vs Form Only vs Preview Only) -->
    <div :class="{
        'grid grid-cols-1 lg:grid-cols-12 gap-8 items-start': viewMode === 'split',
        'max-w-4xl mx-auto space-y-6': viewMode === 'form',
        'max-w-4xl mx-auto space-y-6': viewMode === 'preview'
    }">
        
        <!-- ==================== KOLOM FORMULIR ==================== -->
        <div x-show="viewMode === 'form' || viewMode === 'split'" 
             :class="viewMode === 'split' ? 'lg:col-span-7 space-y-6' : 'space-y-6'">

            <!-- BAGIAN 1: TEMPLATE CEPAT 1-KLIK (BISA GANTI KAPAN SAJA) -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/90 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-md shadow-emerald-950/20">1</span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-slate-900">Pilih Template Surat 1-Klik</h2>
                    </div>
                    <span class="text-[11px] text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">Bisa Ganti Bebas</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                    <button type="button" @click="applyTemplate('banjir')" 
                            :class="selectedTemplate === 'banjir' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">🌊</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">Hilang / Banjir</div>
                            <div class="text-[10px] opacity-80">KTP/KK hanyut banjir</div>
                        </div>
                    </button>

                    <button type="button" @click="applyTemplate('ktp')" 
                            :class="selectedTemplate === 'ktp' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">🪪</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">Bikin KTP Baru</div>
                            <div class="text-[10px] opacity-80">Perekaman e-KTP</div>
                        </div>
                    </button>

                    <button type="button" @click="applyTemplate('kk')" 
                            :class="selectedTemplate === 'kk' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">👶</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">Ubah KK / Lahir</div>
                            <div class="text-[10px] opacity-80">Tambah anggota KK</div>
                        </div>
                    </button>

                    <button type="button" @click="applyTemplate('domisili')" 
                            :class="selectedTemplate === 'domisili' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">🏠</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">Ket. Domisili</div>
                            <div class="text-[10px] opacity-80">Tinggal di RT 005</div>
                        </div>
                    </button>

                    <button type="button" @click="applyTemplate('pindah')" 
                            :class="selectedTemplate === 'pindah' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">📦</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">Pindah Keluar</div>
                            <div class="text-[10px] opacity-80">Pindah domisili</div>
                        </div>
                    </button>

                    <button type="button" @click="applyTemplate('sktm')" 
                            :class="selectedTemplate === 'sktm' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">🏥</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">SKTM</div>
                            <div class="text-[10px] opacity-80">Bansos / Beasiswa</div>
                        </div>
                    </button>

                    <button type="button" @click="applyTemplate('sku')" 
                            :class="selectedTemplate === 'sku' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">🏪</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">Ket. Usaha</div>
                            <div class="text-[10px] opacity-80">Warung & Modal</div>
                        </div>
                    </button>

                    <button type="button" @click="applyTemplate('mati')" 
                            :class="selectedTemplate === 'mati' ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 border-emerald-600 shadow-md' : 'bg-slate-50 hover:bg-emerald-50 text-slate-800 border-slate-200'"
                            class="p-3 text-left rounded-2xl border transition-all flex flex-col justify-between h-24 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform">🕊️</span>
                        <div>
                            <div class="font-extrabold text-xs leading-tight">Kematian</div>
                            <div class="text-[10px] opacity-80">Akta kematian desa</div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- FORM UTAMA -->
            <form action="{{ route('surat-pengantar.store') }}" method="POST" id="formSurat" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="tanda_tangan_jenis" :value="ttdJenis">
                <input type="hidden" name="tanda_tangan_digital" id="tanda_tangan_digital_input" :value="signaturePreview">

                <!-- BAGIAN 2: DATA WARGA PEMOHON -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/90 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-md">2</span>
                            <div>
                                <h2 class="text-sm font-black uppercase tracking-wider text-slate-900">Identitas Warga Pemohon</h2>
                                <p class="text-[11px] text-slate-500 font-medium">Ketik langsung Nama dan/atau NIK pemohon (tidak perlu memilih jika data belum terdaftar)</p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="warga_id" :value="selectedWargaId">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Nama Lengkap Pemohon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama_lengkap" 
                                   x-model="namaLengkap" 
                                   placeholder="Contoh: Budi Santoso" 
                                   required
                                   list="list-warga-nama"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            <datalist id="list-warga-nama">
                                @foreach($wargas as $w)
                                    <option value="{{ $w->nama_lengkap }}">{{ $w->nik }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                NIK (Nomor Induk Kependudukan)
                            </label>
                            <input type="text" 
                                   name="nik" 
                                   x-model="nik" 
                                   maxlength="16"
                                   placeholder="Contoh: 320101XXXXXXXXXX" 
                                   list="list-warga-nik"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            <datalist id="list-warga-nik">
                                @foreach($wargas as $w)
                                    <option value="{{ $w->nik }}">{{ $w->nama_lengkap }}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" x-model="jenisKelamin"
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pekerjaan:</label>
                            <input type="text" name="pekerjaan" x-model="pekerjaan" placeholder="Contoh: Karyawan Swasta"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Domisili:</label>
                            <input type="text" name="alamat" x-model="alamat" placeholder="Contoh: Blok B2 No. 12"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: DETAIL ISI SURAT -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/90 shadow-sm space-y-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-md">3</span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-slate-900">Uraian Isi Surat Pengantar</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor Surat Pengantar:</label>
                            <input type="text" name="nomor_surat" x-model="nomorSurat" required
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kategori Surat:</label>
                            <input type="text" name="jenis_surat" x-model="jenisSurat" readonly
                                class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-300 rounded-xl text-xs font-bold text-slate-700">
                        </div>
                    </div>

                    <div x-show="jenisSurat === 'kehilangan_dokumen'" class="space-y-1">
                        <label class="block text-xs font-bold text-amber-900 uppercase">Dokumen yang Hilang / Rusak (Bencana Banjir):</label>
                        <input type="text" name="dokumen_hilang" x-model="dokumenHilang"
                            class="w-full px-3.5 py-2.5 bg-amber-50 border-2 border-amber-300 rounded-xl text-xs font-bold text-amber-950">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Uraian Keperluan Surat:</label>
                        <textarea name="keperluan" rows="3" required x-model="keperluan"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border-2 border-slate-300 rounded-xl text-xs font-semibold text-slate-900 leading-relaxed focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Surat:</label>
                            <input type="date" name="tanggal_surat" x-model="tanggalSurat" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Ketua RT:</label>
                            <input type="text" name="penandatangan_nama" x-model="penandatanganNama" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan:</label>
                            <input type="text" name="penandatangan_jabatan" x-model="penandatanganJabatan" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold">
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 4: SISTEM TANDA TANGAN (FOTO TTD / PDF / BASAH) -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 border-2 border-emerald-400/90 shadow-md space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-md">4</span>
                            <h2 class="text-sm font-black uppercase tracking-wider text-slate-900">Tanda Tangan & Cap RT</h2>
                        </div>
                        <span class="text-xs font-black text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full">Bisa Foto / PDF / Basah</span>
                    </div>

                    <!-- 3 Pilihan Metode TTD -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Opsi 1: Masukkan Foto / PDF TTD -->
                        <label class="flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                               :class="ttdJenis === 'foto' || ttdJenis === 'pdf' ? 'bg-emerald-50 border-emerald-600 ring-2 ring-emerald-200' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'">
                            <input type="radio" name="ttd_radio" value="foto" @click="ttdJenis = 'foto'" class="sr-only">
                            <span class="text-2xl mb-1">📸</span>
                            <span class="text-xs font-black text-slate-900">Upload Foto / PDF TTD</span>
                            <span class="text-[11px] text-slate-500 mt-1">Masukkan foto tanda tangan dari HP atau file PDF scan.</span>
                        </label>

                        <!-- Opsi 2: TTD Basah (Manual) -->
                        <label class="flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                               :class="ttdJenis === 'manual' ? 'bg-emerald-50 border-emerald-600 ring-2 ring-emerald-200' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'">
                            <input type="radio" name="ttd_radio" value="manual" @click="ttdJenis = 'manual'" class="sr-only">
                            <span class="text-2xl mb-1">✍️</span>
                            <span class="text-xs font-black text-slate-900">TTD Basah (Manual)</span>
                            <span class="text-[11px] text-slate-500 mt-1">Cetak dokumen kosong untuk tanda tangan pulpen & cap stempel fisik.</span>
                        </label>

                        <!-- Opsi 3: QR Code Verifikasi -->
                        <label class="flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition-all"
                               :class="ttdJenis === 'qrcode' ? 'bg-emerald-50 border-emerald-600 ring-2 ring-emerald-200' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'">
                            <input type="radio" name="ttd_radio" value="qrcode" @click="ttdJenis = 'qrcode'" class="sr-only">
                            <span class="text-2xl mb-1">🛡️</span>
                            <span class="text-xs font-black text-slate-900">QR Code Verifikasi</span>
                            <span class="text-[11px] text-slate-500 mt-1">Gunakan kode barcode token sah terverifikasi RT 005 / RW 013.</span>
                        </label>
                    </div>

                    <!-- KOTAK UNGGAH BERKAS FOTO TTD / PDF -->
                    <div x-show="ttdJenis === 'foto' || ttdJenis === 'pdf'" class="p-4 bg-slate-50 border-2 border-dashed border-emerald-300 rounded-2xl space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <span class="text-xs font-extrabold text-slate-800">Pilih Berkas Foto Tanda Tangan atau PDF:</span>
                                <p class="text-[11px] text-slate-500">Mendukung format JPG, PNG, JPEG, dan dokumen PDF scan.</p>
                            </div>
                            <!-- Tombol Shortcut TTD Pak RT -->
                            <button type="button" @click="usePresetSignature()" 
                                class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                <span>Pakai Foto TTD Pak RT</span>
                            </button>
                        </div>

                        <!-- Input File -->
                        <div>
                            <input type="file" name="tanda_tangan_file" id="tanda_tangan_file_input" accept="image/*,.pdf" @change="handleFileUpload($event)"
                                class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 file:cursor-pointer cursor-pointer">
                        </div>

                        <!-- Preview Foto TTD Terpasang -->
                        <div class="pt-2 flex items-center gap-4">
                            <template x-if="signaturePreview && !isPdf">
                                <div class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl shadow-sm">
                                    <div class="relative w-28 h-16 bg-slate-100 rounded-lg flex items-center justify-center p-1 border">
                                        <img :src="signaturePreview" alt="Preview TTD" class="max-h-full max-w-full object-contain">
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-emerald-800 block">✓ Foto TTD Siap Dicetak</span>
                                        <span class="text-[10px] text-slate-400" x-text="uploadedFileName || 'Foto Tanda Tangan Terpilih'"></span>
                                    </div>
                                </div>
                            </template>

                            <template x-if="isPdf">
                                <div class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl shadow-sm">
                                    <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center border border-emerald-300">
                                        <span class="text-xs font-black text-emerald-800">PDF</span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-emerald-800 block">✓ Berkas PDF TTD Terlampir</span>
                                        <span class="text-[10px] text-slate-500 font-mono" x-text="uploadedFileName"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                <!-- Tombol Submit & Aksi Cepat -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <button type="button" @click="viewMode = 'preview'" class="w-full sm:w-auto px-5 py-3 border-2 border-slate-300 text-slate-700 text-xs sm:text-sm font-bold rounded-2xl hover:bg-slate-100 flex items-center justify-center gap-2">
                        <i data-lucide="eye" class="w-4 h-4 text-emerald-600"></i>
                        <span>Lihat Pratinjau Lembar A4 Dahulu</span>
                    </button>
                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 hover:from-emerald-500 hover:to-teal-500 text-white text-base font-black rounded-2xl shadow-xl shadow-emerald-950/40 transition-all flex items-center justify-center gap-2 active:scale-95">
                        <i data-lucide="printer" class="w-5 h-5"></i>
                        <span>SIMPAN & CETAK SURAT LANGSUNG</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ==================== KOLOM PRATINJAU DOKUMEN FISIK A4 (Mengikuti Layar / Sticky) ==================== -->
        <div x-show="viewMode === 'preview' || viewMode === 'split'" 
             :class="viewMode === 'split' ? 'lg:col-span-5 lg:sticky lg:top-4 self-start' : 'w-full'">

            <div class="bg-slate-900 text-white rounded-3xl p-4 sm:p-5 shadow-2xl border border-slate-800 space-y-3 lg:max-h-[calc(100vh-6rem)] lg:overflow-y-auto">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        <h3 class="text-xs font-black uppercase tracking-wider text-emerald-400">Pratinjau Kertas Surat A4 (Langsung)</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] text-slate-400 font-mono">Format Sah A4</span>
                        <button type="button" x-show="viewMode === 'preview'" @click="viewMode = 'form'" 
                            class="text-xs text-emerald-400 hover:text-white font-bold flex items-center gap-1 underline ml-2">
                            <span>&larr; Lanjut Isi Form</span>
                        </button>
                    </div>
                </div>

                <!-- Lembar Kertas Dokumen Realistis A4 (Format Tata Naskah Dinas Pemerintah Indonesia) -->
                <div class="overflow-x-auto pb-2">
                    <div class="min-w-[300px] bg-white text-slate-900 rounded-2xl p-3.5 sm:p-5 shadow-2xl border border-slate-300 font-serif text-[10px] sm:text-[10.5px] leading-relaxed relative">
                    
                    <!-- KOP SURAT PEMERINTAHAN DESA / RT RESMI -->
                    <div class="flex items-center justify-between pb-2 border-b-[2px] border-black">
                        <!-- Lambang Garuda Pancasila -->
                        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center">
                            <svg viewBox="0 0 100 100" class="w-10 h-10 text-black fill-current" xmlns="http://www.w3.org/2000/svg">
                                <path d="M50 8 C44 8 40 12 37 16 C33 13 28 14 25 18 C19 19 14 24 13 31 C8 35 6 42 7 49 C9 58 15 65 23 68 C27 75 34 81 42 85 C46 87 48 90 50 92 C52 90 54 87 58 85 C66 81 73 75 77 68 C85 65 91 58 93 49 C94 42 92 35 87 31 C86 24 81 19 75 18 C72 14 67 13 63 16 C60 12 56 8 50 8 Z M50 15 C52 15 54 18 55 21 C53 23 51 24 50 24 C49 24 47 23 45 21 C46 18 48 15 50 15 Z M38 22 C41 21 44 23 45 26 C42 27 39 27 37 26 C36 24 37 23 38 22 Z M62 22 C63 23 64 24 63 26 C61 27 58 27 55 26 C56 23 59 21 62 22 Z M50 28 C57 28 63 34 63 42 C63 51 57 58 50 63 C43 58 37 51 37 42 C37 34 43 28 50 28 Z M50 33 C46 33 42 37 42 42 C42 48 46 53 50 56 C54 53 58 48 58 42 C58 37 54 33 50 33 Z M38 72 C33 68 28 62 26 56 C29 55 33 56 36 58 C37 63 37 68 38 72 Z M62 72 C63 68 63 63 64 58 C67 56 71 55 74 56 C72 62 67 68 62 72 Z M45 88 C40 85 36 81 33 76 C38 74 43 75 47 77 C46 81 45 85 45 88 Z M55 88 C55 85 54 81 53 77 C57 75 62 74 67 76 C64 81 60 85 55 88 Z" fill-rule="evenodd"/>
                            </svg>
                        </div>

                        <!-- Teks Jenjang Pemerintahan -->
                        <div class="flex-1 text-center px-1">
                            <h4 class="text-[9px] font-bold uppercase tracking-widest text-black leading-none">RUKUN TETANGGA 005 / RUKUN WARGA 013</h4>
                            <h5 class="text-[8px] font-bold uppercase tracking-wider text-black leading-none mt-0.5">PERUMAHAN BUMI MUTIARA INDAH II</h5>
                            <h3 class="text-xs font-black uppercase tracking-wider text-black leading-tight mt-0.5">PELAYANAN SURAT PENGANTAR WARGA</h3>
                            <p class="text-[7.5px] italic text-slate-700 font-sans leading-none mt-0.5">Sekretariat: Perumahan Bumi Mutiara Indah II Blok B3 No. 12 RT 005 / RW 013</p>
                        </div>

                        <!-- Monogram RT Kanan -->
                        <div class="w-10 h-10 flex-shrink-0 hidden sm:flex items-center justify-center">
                            <div class="w-8 h-8 rounded-full border border-black flex flex-col items-center justify-center text-[5.5px] font-black uppercase leading-none">
                                <span>RT 005</span>
                                <span>RW 013</span>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-black mb-3 mt-0.5"></div>

                    <!-- Judul & Nomor Surat Dinas -->
                    <div class="text-center my-2">
                        <div class="font-bold underline text-xs tracking-wider">SURAT PENGANTAR</div>
                        <div class="text-[9px] font-bold" x-text="'Nomor : ' + nomorSurat"></div>
                    </div>

                    <p class="text-[9.5px] mb-2 text-justify indent-4 leading-relaxed">
                        Yang bertanda tangan di bawah ini Ketua Rukun Tetangga (RT) 005 Rukun Warga (RW) 013 Perumahan Bumi Mutiara Indah II, menerangkan bahwa:
                    </p>

                    <!-- Identitas Warga Live Preview (Format Naskah Dinas Lengkap) -->
                    <div class="space-y-0.5 my-2 pl-2 border-l-2 border-emerald-600 font-sans text-[9px]">
                        <div class="grid grid-cols-12">
                            <span class="col-span-5 text-slate-600 font-medium">1. Nama Lengkap</span>
                            <span class="col-span-1">:</span>
                            <strong class="col-span-6 uppercase text-slate-950 font-bold" x-text="namaLengkap || 'Nama Warga'"></strong>
                        </div>
                        <div class="grid grid-cols-12">
                            <span class="col-span-5 text-slate-600 font-medium">2. NIK</span>
                            <span class="col-span-1">:</span>
                            <strong class="col-span-6 font-mono font-bold text-slate-950" x-text="nik || '320101xxxxxxxxxx'"></strong>
                        </div>
                        <div class="grid grid-cols-12">
                            <span class="col-span-5 text-slate-600 font-medium">3. Jenis Kelamin</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6" x-text="jenisKelamin === 'L' ? 'Laki-laki' : 'Perempuan'"></span>
                        </div>
                        <div class="grid grid-cols-12">
                            <span class="col-span-5 text-slate-600 font-medium">4. Kewarganegaraan</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6">WNI</span>
                        </div>
                        <div class="grid grid-cols-12">
                            <span class="col-span-5 text-slate-600 font-medium">5. Agama</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6">Islam</span>
                        </div>
                        <div class="grid grid-cols-12">
                            <span class="col-span-5 text-slate-600 font-medium">6. Pekerjaan</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6" x-text="pekerjaan || 'Wiraswasta'"></span>
                        </div>
                        <div class="grid grid-cols-12">
                            <span class="col-span-5 text-slate-600 font-medium">7. Alamat Domisili</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6" x-text="alamat || 'Perumahan Bumi Mutiara Indah II, RT 005 / RW 013'"></span>
                        </div>
                    </div>

                    <p class="text-[9.5px] my-2 text-justify indent-4 leading-relaxed">
                        Bahwa orang yang namanya tersebut di atas adalah benar warga yang berdomisili sah di lingkungan RT 005 / RW 013 Perumahan Bumi Mutiara Indah II, dan surat pengantar ini diberikan untuk keperluan:
                    </p>

                    <div class="p-2 bg-slate-50 border-l-2 border-black my-2 italic text-[9.5px] text-slate-900 rounded-r font-semibold">
                        "<span x-text="keperluan"></span>"
                    </div>

                    <div x-show="jenisSurat === 'kehilangan_dokumen'" class="p-2 bg-slate-100 border border-black rounded text-[9px] text-slate-900 my-1 font-semibold">
                        Dokumen Hilang (Bencana): <strong x-text="dokumenHilang"></strong>
                    </div>

                    <p class="text-[9.5px] my-2 text-justify indent-4 leading-relaxed">
                        Demikian Surat Pengantar ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
                    </p>

                    <!-- Titimangsa & Tanda Tangan Dua Sisi Resmi -->
                    <div class="mt-3 pt-2 border-t border-slate-300 flex items-end justify-between text-center text-[9px]">
                        <div>
                            <span>Tanda Tangan Pemohon,</span>
                            <div class="h-12 flex items-end justify-center pb-1">
                                <span class="text-[8px] text-slate-400 italic">[ Tanda Tangan ]</span>
                            </div>
                            <span class="font-bold underline uppercase" x-text="namaLengkap || 'Warga'"></span>
                        </div>
                        
                        <div class="relative">
                            <span x-text="'Bumi Mutiara Indah II, ' + tanggalSurat"></span><br>
                            <strong x-text="penandatanganJabatan + ','"></strong>
                            
                            <!-- Cap Stempel & Signature Preview -->
                            <div class="h-16 my-1 flex items-center justify-center relative">
                                <!-- Cap Stempel Dinas RT Violet Resmi -->
                                <div class="w-14 h-14 rounded-full border border-dashed border-indigo-900 text-indigo-900 text-[5px] font-bold flex flex-col items-center justify-center rotate-[-12deg] bg-indigo-50/50 absolute z-0 pointer-events-none">
                                    <span>* PENGURUS RT *</span>
                                    <span class="font-black text-[6.5px]">RT 005 / RW 013</span>
                                    <span>BUMI MUTIARA INDAH II</span>
                                </div>

                                <!-- Foto TTD Live Preview -->
                                <template x-if="(ttdJenis === 'foto' || ttdJenis === 'digital') && signaturePreview && !isPdf">
                                    <img :src="signaturePreview" class="h-12 max-w-[110px] object-contain relative z-10 mx-auto" alt="Foto TTD">
                                </template>

                                <!-- PDF TTD Preview -->
                                <template x-if="ttdJenis === 'pdf' || isPdf">
                                    <div class="p-1 bg-emerald-50 border border-emerald-300 rounded shadow-sm relative z-10 text-[8px] text-emerald-900 font-sans font-bold">
                                        ✓ TTD PDF Terlampir
                                    </div>
                                </template>

                                <!-- QR Code Preview -->
                                <template x-if="ttdJenis === 'qrcode'">
                                    <div class="p-1 bg-white border border-slate-300 rounded shadow-sm relative z-10">
                                        <i data-lucide="qr-code" class="w-7 h-7 text-slate-900 inline"></i>
                                    </div>
                                </template>

                                <!-- Manual Blank Space -->
                                <template x-if="ttdJenis === 'manual'">
                                    <span class="text-[8px] text-slate-400 italic relative z-10">[ Tanda Tangan Basah ]</span>
                                </template>
                            </div>

                            <strong class="underline block uppercase font-bold" x-text="penandatanganNama"></strong>
                        </div>
                    </div>

                    <!-- Mengetahui RW 013 -->
                    <div class="text-center text-[8.5px] pt-3 mt-2 border-t border-dotted border-slate-300">
                        <span>Mengetahui, Ketua RW 013 Perumahan Bumi Mutiara Indah II:</span>
                        <div class="h-8 flex items-end justify-center">
                            <span class="text-[7.5px] text-slate-400 italic">[ Tanda Tangan & Cap RW 013 ]</span>
                        </div>
                        <span class="font-bold underline uppercase">( ............................................................ )</span>
                    </div>

                </div>
                </div>

                <!-- Tombol Cetak dari Preview -->
                <div class="pt-1 flex items-center justify-end">
                    <button type="button" @click="document.getElementById('formSurat').submit()" 
                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-black shadow flex items-center justify-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        <span>Simpan & Cetak Lembar Ini</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
