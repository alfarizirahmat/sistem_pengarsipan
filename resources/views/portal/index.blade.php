<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelayanan Warga RT 005 / RW 013 - Perumahan Bumi Mutiara Indah II</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased font-sans flex flex-col justify-between"
      x-data="{ showForm: false }">

    <!-- HEADER RESMI -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-700 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                    <i data-lucide="building-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">
                        RT 005 / RW 013
                    </h1>
                    <p class="text-xs text-slate-500 font-medium leading-tight">
                        Perumahan Bumi Mutiara Indah II
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs px-3.5 py-2 rounded-lg transition-colors shadow-xs">
                        <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        <span>Meja Pengurus</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-blue-700 hover:bg-slate-100 px-3 py-2 rounded-lg transition-colors">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk Pengurus RT</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO & PENCARIAN SURAT -->
    <main class="flex-grow">
        <!-- Title Banner -->
        <div class="bg-gradient-to-b from-blue-50/70 via-white to-slate-50 border-b border-slate-200/80 pt-10 pb-12 px-4 sm:px-6">
            <div class="max-w-3xl mx-auto text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100/80 text-blue-800 border border-blue-200 mb-4">
                    <i data-lucide="file-check-2" class="w-3.5 h-3.5"></i>
                    Portal Pelayanan Mandiri Warga
                </span>
                
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                    Periksa &amp; Ambil Surat Digital Warga
                </h2>
                
                <p class="text-sm text-slate-600 mt-2 max-w-xl mx-auto leading-relaxed">
                    Masukkan <strong>Kode Surat</strong> yang diberikan Pengurus RT (misal: <code class="bg-white px-1.5 py-0.5 rounded text-blue-700 border border-slate-200 font-mono text-xs">BMI2-XXXXX</code>), Nomor Surat, atau NIK untuk memeriksa status &amp; mengunduh surat pengantar resmi.
                </p>

                <!-- FORM PENCARIAN CEPAT -->
                <form action="{{ route('portal.warga') }}" method="GET" class="mt-6 max-w-xl mx-auto">
                    <div class="flex flex-col sm:flex-row gap-2 bg-white p-2 rounded-2xl shadow-md border border-slate-200">
                        <div class="relative flex-grow">
                            <i data-lucide="search" class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text" 
                                   name="kode" 
                                   value="{{ $search }}" 
                                   placeholder="Contoh: BMI2-A1B2C3 atau 3201..." 
                                   required
                                   class="w-full pl-11 pr-4 py-3 text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800 placeholder-slate-400 font-medium">
                        </div>
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm px-6 py-3 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            <span>Cari Surat</span>
                        </button>
                    </div>
                </form>

                <!-- Short info tips -->
                <div class="mt-3 flex items-center justify-center gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                        <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i> Sah Tanda Tangan &amp; QR
                    </span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="printer" class="w-3.5 h-3.5 text-blue-600"></i> Siap Cetak PDF
                    </span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i> Lacak Status Realtime
                    </span>
                </div>
            </div>
        </div>

        <!-- HASIL PENCARIAN SURAT -->
        <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start gap-3">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                        <p class="text-xs text-emerald-700 mt-0.5">Silakan simpan kode pelacakan Anda di tempat yang aman.</p>
                    </div>
                </div>
            @endif

            @if($searched)
                @if($foundSurat)
                    <!-- KARTU HASIL TEMUAN SURAT -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                        <!-- Header Status -->
                        <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 {{ $foundSurat->status === 'selesai' ? 'bg-emerald-50/50' : 'bg-amber-50/50' }}">
                            <div>
                                <span class="text-xs font-semibold text-slate-500">Hasil Pelacakan Surat Warga:</span>
                                <h3 class="text-lg font-extrabold text-slate-900 font-mono mt-0.5">
                                    {{ $foundSurat->nomor_surat }}
                                </h3>
                            </div>
                            <div>
                                @if($foundSurat->status === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <i data-lucide="badge-check" class="w-4 h-4 text-emerald-600"></i>
                                        Surat Sah &amp; Siap Diambil
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                        <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
                                        Menunggu Validasi Pengurus RT
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Rincian Data Surat -->
                        <div class="p-6 space-y-4 text-sm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                                    <span class="text-xs font-medium text-slate-500 block">Nama Pemohon:</span>
                                    <span class="font-bold text-slate-900 text-base">{{ $foundSurat->warga->nama_lengkap ?? '-' }}</span>
                                    <span class="text-xs text-slate-500 block font-mono mt-0.5">NIK: {{ $foundSurat->warga->nik ?? '-' }}</span>
                                </div>
                                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                                    <span class="text-xs font-medium text-slate-500 block">Kode Unik Digital (Token):</span>
                                    <span class="font-bold text-blue-700 font-mono text-base">{{ $foundSurat->qr_token ?? '-' }}</span>
                                    <span class="text-xs text-slate-500 block mt-0.5">Gunakan kode ini untuk akses langsung</span>
                                </div>
                            </div>

                            <div class="border-t border-slate-100 pt-3 space-y-2">
                                <div class="flex justify-between py-1">
                                    <span class="text-slate-500">Jenis Surat:</span>
                                    <span class="font-semibold text-slate-900 capitalize">{{ str_replace('_', ' ', $foundSurat->jenis_surat) }}</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="text-slate-500">Keperluan:</span>
                                    <span class="font-semibold text-slate-900 text-right max-w-xs">{{ $foundSurat->keperluan }}</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="text-slate-500">Tanggal Diterbitkan:</span>
                                    <span class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($foundSurat->tanggal_surat)->translatedFormat('d F Y') }}</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="text-slate-500">Penandatangan:</span>
                                    <span class="font-semibold text-slate-900">{{ $foundSurat->penandatangan_nama }} ({{ $foundSurat->penandatangan_jabatan }})</span>
                                </div>
                            </div>

                            <!-- Tombol Aksi Surat -->
                            <div class="pt-4 flex flex-col sm:flex-row gap-3 border-t border-slate-200">
                                <a href="{{ route('portal.digital', $foundSurat->qr_token ?: $foundSurat->id) }}" 
                                   target="_blank"
                                   class="flex-1 bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-xl text-center flex items-center justify-center gap-2 transition-colors shadow-xs">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                    <span>Buka Lembar Surat Digital</span>
                                </a>

                                <a href="{{ route('surat-pengantar.print', $foundSurat) }}" 
                                   target="_blank"
                                   class="bg-white hover:bg-slate-50 text-slate-700 font-bold py-3 px-5 rounded-xl border border-slate-300 text-center flex items-center justify-center gap-2 transition-colors">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                    <span>Cetak PDF</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- TIDAK DITEMUKAN -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center shadow-xs mb-8">
                        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="alert-circle" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Surat Tidak Ditemukan</h4>
                        <p class="text-sm text-slate-500 mt-1 max-w-md mx-auto">
                            Tidak ada surat pengantar yang cocok dengan pencarian <code class="font-mono text-slate-700 font-semibold">{{ $search }}</code>. Pastikan kode surat, nomor surat, atau NIK sudah sesuai.
                        </p>
                        <a href="{{ route('portal.warga') }}" class="inline-block mt-4 text-xs font-bold text-blue-700 hover:underline">
                            &larr; Bersihkan pencarian
                        </a>
                    </div>
                @endif
            @endif

            <!-- BAGIAN AJUKAN SURAT MANDIRI -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="send" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base">Butuh Surat Pengantar RT?</h3>
                            <p class="text-xs text-slate-500">Ajukan permohonan secara mandiri di sini tanpa perlu antre</p>
                        </div>
                    </div>
                    <button type="button" 
                            @click="showForm = !showForm" 
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-colors"
                            :class="showForm ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-xs'">
                        <span x-text="showForm ? 'Tutup Formulir' : '+ Ajukan Sekarang'"></span>
                    </button>
                </div>

                <!-- Formulir Pengajuan (Bisa di-toggle) -->
                <div x-show="showForm" x-cloak class="pt-6">
                    <form action="{{ route('portal.ajukan') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Pilih Nama Pemohon (Warga RT 005) <span class="text-red-500">*</span>
                            </label>
                            <select name="warga_id" required class="w-full text-sm bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800">
                                <option value="">-- Pilih Nama Warga Pemohon --</option>
                                @foreach($wargas as $w)
                                    <option value="{{ $w->id }}">{{ $w->nama_lengkap }} (NIK: {{ $w->nik }})</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-500 mt-1">Jika nama belum terdaftar, silakan hubungi pengurus RT untuk pendaftaran data warga terlebih dahulu.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Jenis Pelayanan Surat <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_surat" required class="w-full text-sm bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800">
                                    <option value="ktp_baru">Pembuatan / Perpanjangan KTP</option>
                                    <option value="perubahan_kk">Perubahan / Pembuatan Kartu Keluarga (KK)</option>
                                    <option value="keterangan_domisili">Surat Keterangan Domisili Tinggal</option>
                                    <option value="sktm">Surat Keterangan Tidak Mampu (SKTM)</option>
                                    <option value="sku">Surat Keterangan Usaha (SKU)</option>
                                    <option value="pindah_domisili">Surat Pengantar Pindah Keluar</option>
                                    <option value="warga_datang">Surat Keterangan Warga Datang / Pindahan</option>
                                    <option value="kehilangan_dokumen">Surat Keterangan Kehilangan Dokumen</option>
                                    <option value="kematian">Surat Keterangan Kematian</option>
                                    <option value="lainnya">Keperluan Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nomor WhatsApp Anda (Opsional)
                                </label>
                                <input type="text" 
                                       name="no_whatsapp" 
                                       placeholder="Contoh: 081234567890" 
                                       class="w-full text-sm bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800">
                                <p class="text-[11px] text-slate-500 mt-1">Untuk konfirmasi saat surat telah disahkan</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Keperluan Surat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="keperluan" 
                                      rows="3" 
                                      required 
                                      placeholder="Jelaskan secara singkat keperluan surat, contoh: Persyaratan pendaftaran sekolah anak / Persyaratan administrasi perbankan..."
                                      class="w-full text-sm bg-slate-50 border border-slate-300 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800"></textarea>
                        </div>

                        <div class="pt-2 flex justify-end gap-2">
                            <button type="button" @click="showForm = false" class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                                Batal
                            </button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                                <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                <span>Kirim Permohonan Surat</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- FOOTER RESMI -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <p class="font-medium text-slate-700">
            Perancangan Sistem Informasi Pendataan dan Pelayanan Warga Berbasis Web
        </p>
        <p class="mt-0.5">
            RT 005 RW 013 Perumahan Bumi Mutiara Indah II &copy; {{ date('Y') }}
        </p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>

