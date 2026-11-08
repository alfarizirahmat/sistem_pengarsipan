@extends('layouts.app')

@section('title', 'Catat Surat Masuk Baru')
@section('header_title', 'Pencatatan Surat Masuk')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Pencatatan Surat Masuk ke Agenda RT</h1>
            <p class="text-xs text-slate-500">Mencatat surat resmi dari Pemerintah Desa, RW, Puskesmas, maupun pihak luar</p>
        </div>
        <a href="{{ route('surat-masuk.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Agenda</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nomor Agenda -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor Agenda Surat Masuk <span class="text-rose-500">*</span></label>
                    <input type="text" name="nomor_agenda" value="{{ old('nomor_agenda', $autoNomorAgenda) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-bold focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Nomor Surat Pengirim -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor Surat Asli dari Pengirim <span class="text-rose-500">*</span></label>
                    <input type="text" name="nomor_surat_pengirim" value="{{ old('nomor_surat_pengirim') }}" required placeholder="Contoh: 140/012/Pem-Des/2026"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Instansi Pengirim -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Instansi / Pihak Pengirim <span class="text-rose-500">*</span></label>
                    <input type="text" name="pengirim" value="{{ old('pengirim') }}" required placeholder="Contoh: Pemerintah Kelurahan / Pengurus RW 013"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Perihal -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Perihal / Hal Surat <span class="text-rose-500">*</span></label>
                    <input type="text" name="perihal" value="{{ old('perihal') }}" required placeholder="Contoh: Undangan Rapat Koordinasi Ronda / Jadwal Posyandu"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Tanggal Surat -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Surat Tertera <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Tanggal Terima -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Diterima RT <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima', date('Y-m-d')) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <!-- Ringkasan Isi -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ringkasan Isi / Catatan Surat</label>
                <textarea name="ringkasan_isi" rows="3" placeholder="Ringkasan poin utama dari surat masuk..."
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">{{ old('ringkasan_isi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Disposisi / Tindak Lanjut -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Disposisi / Tindak Lanjut</label>
                    <input type="text" name="disposisi" value="{{ old('disposisi') }}" placeholder="Contoh: Diteruskan ke Seksi Keamanan / Seksi Humas"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Lokasi Arsip Fisik -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Lokasi Arsip Fisik di Lemari RT</label>
                    <input type="text" name="lokasi_arsip_fisik" value="{{ old('lokasi_arsip_fisik', 'Ordner Surat Masuk ' . date('Y') . ' / Sekat 1') }}" placeholder="Contoh: Bantex Surat Masuk 2026 - No. 05"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <!-- Upload File Scan Lampiran -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Unggah Berkas Scan / Foto Surat (PDF, JPG, PNG)</label>
                <input type="file" name="file_lampiran" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <p class="text-[11px] text-slate-500 mt-1">Maksimal ukuran berkas 5MB (Opsional jika hanya disimpan fisiknya di lemari RT).</p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('surat-masuk.index') }}" class="w-full sm:w-auto text-center px-4 py-2.5 border border-slate-300 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-50">Batal</a>
                <button type="submit" class="w-full sm:w-auto justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Catat ke Agenda Arsip</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

