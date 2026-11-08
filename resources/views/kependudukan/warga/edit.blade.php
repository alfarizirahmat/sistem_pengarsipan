@extends('layouts.app')

@section('title', 'Edit Data Warga: ' . $warga->nama_lengkap)
@section('header_title', 'Perbarui Data Warga')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Perbarui Data: {{ $warga->nama_lengkap }}</h1>
            <p class="text-xs text-slate-500">Perubahan identitas, domisili, atau status kependudukan warga RT 005 / RW 013</p>
        </div>
        <a href="{{ route('warga.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Data Warga</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('warga.update', $warga) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Hubungkan ke Kartu Keluarga -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kartu Keluarga (KK)</label>
                <select name="keluarga_id" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                    <option value="">-- Pilih Kartu Keluarga / Mandiri --</option>
                    @foreach($keluargas as $kk)
                        <option value="{{ $kk->id }}" {{ old('keluarga_id', $warga->keluarga_id) == $kk->id ? 'selected' : '' }}>
                            {{ $kk->kepala_keluarga }} (No. KK: {{ $kk->nomor_kk }}) - {{ $kk->alamat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- NIK -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">NIK (16 Digit) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $warga->nik) }}" maxlength="16" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                        <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. WhatsApp / Telepon</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $warga->no_hp) }}" placeholder="Contoh: 081234567890"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tempat Lahir <span class="text-rose-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $warga->tanggal_lahir?->format('Y-m-d')) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Agama -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Agama <span class="text-rose-500">*</span></label>
                    <select name="agama" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                            <option value="{{ $agm }}" {{ old('agama', $warga->agama) === $agm ? 'selected' : '' }}>{{ $agm }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pekerjaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Status Perkawinan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Perkawinan <span class="text-rose-500">*</span></label>
                    <select name="status_perkawinan" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                        @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $sp)
                            <option value="{{ $sp }}" {{ old('status_perkawinan', $warga->status_perkawinan) === $sp ? 'selected' : '' }}>{{ $sp }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hubungan Keluarga -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kedudukan Dalam Keluarga <span class="text-rose-500">*</span></label>
                    <select name="status_hubungan_keluarga" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                        @foreach(['Kepala Keluarga', 'Istri', 'Anak', 'Orang Tua', 'Famili Lain'] as $hk)
                            <option value="{{ $hk }}" {{ old('status_hubungan_keluarga', $warga->status_hubungan_keluarga) === $hk ? 'selected' : '' }}>{{ $hk }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Tempat Tinggal -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Tempat Tinggal di RT <span class="text-rose-500">*</span></label>
                    <select name="status_tinggal" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        <option value="tetap" {{ old('status_tinggal', $warga->status_tinggal) === 'tetap' ? 'selected' : '' }}>Warga Tetap (Rumah Sendiri)</option>
                        <option value="kontrak" {{ old('status_tinggal', $warga->status_tinggal) === 'kontrak' ? 'selected' : '' }}>Warga Kontrak / Sewa</option>
                        <option value="kost" {{ old('status_tinggal', $warga->status_tinggal) === 'kost' ? 'selected' : '' }}>Warga Kost</option>
                    </select>
                </div>

                <!-- Status Kependudukan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Kependudukan <span class="text-rose-500">*</span></label>
                    <select name="status_kependudukan" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        <option value="aktif" {{ old('status_kependudukan', $warga->status_kependudukan) === 'aktif' ? 'selected' : '' }}>Aktif Berdomisili</option>
                        <option value="pindah" {{ old('status_kependudukan', $warga->status_kependudukan) === 'pindah' ? 'selected' : '' }}>Pindah (Keluar)</option>
                        <option value="meninggal" {{ old('status_kependudukan', $warga->status_kependudukan) === 'meninggal' ? 'selected' : '' }}>Meninggal Dunia</option>
                    </select>
                </div>

                <!-- Tanggal Mutasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Peristiwa / Lapor Mutasi</label>
                    <input type="date" name="tgl_mutasi" value="{{ old('tgl_mutasi', $warga->tgl_mutasi?->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Catatan Mutasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Keterangan Mutasi / Pindah</label>
                    <input type="text" name="keterangan_mutasi" value="{{ old('keterangan_mutasi', $warga->keterangan_mutasi) }}" placeholder="Keterangan pindah atau catatan khusus"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('warga.index') }}" class="w-full sm:w-auto text-center px-4 py-2.5 border border-slate-300 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-50">Batal</a>
                <button type="submit" class="w-full sm:w-auto justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md transition-colors">
                    Perbarui Data Warga
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

