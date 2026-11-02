<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Masuk Sistem - SIP-RT 03 Desa Sukamaju</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
        /* Smooth scrolling on all devices */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased flex flex-col justify-between py-6 px-4 sm:px-6 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white" 
      x-data="{ tab: 'quick', showPassword: false }">

    <!-- Ambient Subtle Background Glow (Mobile-Safe) -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[340px] sm:w-[600px] h-[250px] sm:h-[400px] bg-gradient-to-b from-emerald-600/20 via-teal-500/10 to-transparent blur-3xl pointer-events-none -z-10"></div>
    <div class="fixed bottom-0 right-0 w-64 sm:w-96 h-64 sm:h-96 bg-emerald-700/10 blur-3xl pointer-events-none -z-10"></div>

    <!-- Header & Brand Logo -->
    <header class="w-full max-w-xl mx-auto text-center pt-2 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-xs font-bold tracking-wide uppercase mb-3 shadow-inner">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Aplikasi Resmi Pengurus RT 03 / RW 02</span>
        </div>
        
        <div class="flex items-center justify-center gap-3">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 p-0.5 shadow-xl shadow-emerald-950/60 flex items-center justify-center flex-shrink-0">
                <div class="w-full h-full bg-slate-950/40 rounded-[14px] flex items-center justify-center backdrop-blur-sm">
                    <i data-lucide="archive" class="w-6 h-6 sm:w-7 sm:h-7 text-emerald-300"></i>
                </div>
            </div>
            <div class="text-left">
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight">SIP-RT 03 DIGITAL</h1>
                <p class="text-xs sm:text-sm text-slate-400 font-medium">Desa Sukamaju • Administrasi & Arsip Surat</p>
            </div>
        </div>
    </header>

    <!-- Main Login Card (Fully Responsive for All Screen Sizes) -->
    <main class="w-full max-w-xl mx-auto my-auto">
        <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-800 rounded-3xl shadow-2xl p-5 sm:p-8 relative">
            
            <!-- Notifikasi Error -->
            @if($errors->any())
                <div class="mb-5 bg-rose-950/70 border border-rose-800 text-rose-200 text-xs sm:text-sm p-4 rounded-2xl flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-400 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="font-bold block">Gagal Masuk:</strong>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <!-- Tab Switcher (Touch-friendly 44px) -->
            <div class="flex p-1.5 bg-slate-950/80 border border-slate-800 rounded-2xl mb-6">
                <button type="button" @click="tab = 'quick'" 
                        :class="tab === 'quick' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black shadow-md shadow-emerald-950/50' : 'text-slate-400 font-bold hover:text-white'"
                        class="flex-1 py-3 text-xs sm:text-sm rounded-xl transition-all flex items-center justify-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4 text-emerald-300"></i>
                    <span>1-Klik Masuk Pengurus</span>
                </button>
                <button type="button" @click="tab = 'manual'" 
                        :class="tab === 'manual' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black shadow-md shadow-emerald-950/50' : 'text-slate-400 font-bold hover:text-white'"
                        class="flex-1 py-3 text-xs sm:text-sm rounded-xl transition-all flex items-center justify-center gap-2">
                    <i data-lucide="key-round" class="w-4 h-4 text-emerald-300"></i>
                    <span>Masuk Manual (Email)</span>
                </button>
            </div>

            <!-- TAB 1: 1-Klik Masuk Pengurus (Touch Cards) -->
            <div x-show="tab === 'quick'" class="space-y-3">
                <div class="text-center pb-1">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pilih Profil Pengurus untuk Langsung Masuk:</p>
                    <p class="text-[11px] text-emerald-400 font-medium">Bapak-bapak tidak perlu repot mengetik password, cukup klik nama di bawah</p>
                </div>

                <!-- 1. Ketua RT -->
                <a href="{{ route('quick-login', 'ketua_rt') }}" class="group block p-3.5 sm:p-4 rounded-2xl bg-slate-950/60 hover:bg-emerald-950/40 border border-slate-800 hover:border-emerald-500/80 transition-all duration-200 active:scale-98">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-xl shadow-lg shadow-emerald-950/40 flex-shrink-0">
                                👑
                            </div>
                            <div>
                                <div class="text-sm sm:text-base font-black text-white group-hover:text-emerald-400 transition-colors">
                                    Bapak Hartono
                                    <span class="ml-1 text-[10px] font-black uppercase text-emerald-300 bg-emerald-500/20 px-2 py-0.5 rounded-full border border-emerald-500/30">Ketua RT</span>
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">Tanda Tangan Surat, Pantau Warga & Laporan Desa</div>
                            </div>
                        </div>
                        <i data-lucide="arrow-right" class="w-5 h-5 text-slate-500 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                    </div>
                </a>

                <!-- 2. Sekretaris -->
                <a href="{{ route('quick-login', 'sekretaris') }}" class="group block p-3.5 sm:p-4 rounded-2xl bg-slate-950/60 hover:bg-blue-950/40 border border-slate-800 hover:border-blue-500/80 transition-all duration-200 active:scale-98">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600 to-cyan-400 flex items-center justify-center text-xl shadow-lg shadow-blue-950/40 flex-shrink-0">
                                📝
                            </div>
                            <div>
                                <div class="text-sm sm:text-base font-black text-white group-hover:text-blue-400 transition-colors">
                                    Bapak Ahmad Faisal
                                    <span class="ml-1 text-[10px] font-black uppercase text-blue-300 bg-blue-500/20 px-2 py-0.5 rounded-full border border-blue-500/30">Sekretaris</span>
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">Pembuat Arsip Surat, Catat Surat Masuk & Data Warga</div>
                            </div>
                        </div>
                        <i data-lucide="arrow-right" class="w-5 h-5 text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                    </div>
                </a>

                <!-- 3. Bendahara -->
                <a href="{{ route('quick-login', 'bendahara') }}" class="group block p-3.5 sm:p-4 rounded-2xl bg-slate-950/60 hover:bg-amber-950/40 border border-slate-800 hover:border-amber-500/80 transition-all duration-200 active:scale-98">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-600 to-yellow-400 flex items-center justify-center text-xl shadow-lg shadow-amber-950/40 flex-shrink-0">
                                💰
                            </div>
                            <div>
                                <div class="text-sm sm:text-base font-black text-white group-hover:text-amber-400 transition-colors">
                                    Ibu Hj. Siti Nurjanah
                                    <span class="ml-1 text-[10px] font-black uppercase text-amber-300 bg-amber-500/20 px-2 py-0.5 rounded-full border border-amber-500/30">Bendahara</span>
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">Buku Kas Keuangan RT, Saldo Kas Masuk & Keluar</div>
                            </div>
                        </div>
                        <i data-lucide="arrow-right" class="w-5 h-5 text-slate-500 group-hover:text-amber-400 group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                    </div>
                </a>

                <!-- 4. Humas -->
                <a href="{{ route('quick-login', 'humas') }}" class="group block p-3.5 sm:p-4 rounded-2xl bg-slate-950/60 hover:bg-purple-950/40 border border-slate-800 hover:border-purple-500/80 transition-all duration-200 active:scale-98">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-purple-600 to-pink-400 flex items-center justify-center text-xl shadow-lg shadow-purple-950/40 flex-shrink-0">
                                📢
                            </div>
                            <div>
                                <div class="text-sm sm:text-base font-black text-white group-hover:text-purple-400 transition-colors">
                                    Bapak Rudi Kurniawan
                                    <span class="ml-1 text-[10px] font-black uppercase text-purple-300 bg-purple-500/20 px-2 py-0.5 rounded-full border border-purple-500/30">Humas</span>
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">Penarikan Iuran Bulanan (Posyandu, RW, Kematian, Sampah)</div>
                            </div>
                        </div>
                        <i data-lucide="arrow-right" class="w-5 h-5 text-slate-500 group-hover:text-purple-400 group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                    </div>
                </a>

                <!-- 5. Keamanan -->
                <a href="{{ route('quick-login', 'keamanan') }}" class="group block p-3.5 sm:p-4 rounded-2xl bg-slate-950/60 hover:bg-cyan-950/40 border border-slate-800 hover:border-cyan-500/80 transition-all duration-200 active:scale-98">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-cyan-600 to-blue-500 flex items-center justify-center text-xl shadow-lg shadow-cyan-950/40 flex-shrink-0">
                                🛡️
                            </div>
                            <div>
                                <div class="text-sm sm:text-base font-black text-white group-hover:text-cyan-400 transition-colors">
                                    Bapak Agus Santoso
                                    <span class="ml-1 text-[10px] font-black uppercase text-cyan-300 bg-cyan-500/20 px-2 py-0.5 rounded-full border border-cyan-500/30">Keamanan</span>
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">Jadwal Siskamling Ronda Malam & Laporan Bencana / Banjir</div>
                            </div>
                        </div>
                        <i data-lucide="arrow-right" class="w-5 h-5 text-slate-500 group-hover:text-cyan-400 group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                    </div>
                </a>
            </div>

            <!-- TAB 2: Masuk Manual (Email & Sandi) -->
            <div x-cloak x-show="tab === 'manual'" class="space-y-4">
                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Alamat Email Pengurus:</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', 'rt@rt03.test') }}" required
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-950/80 border border-slate-700 rounded-2xl text-sm sm:text-base text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Kata Sandi:</label>
                            <button type="button" @click="showPassword = !showPassword" class="text-xs text-emerald-400 hover:text-emerald-300 font-semibold">
                                <span x-text="showPassword ? 'Sembunyikan' : 'Perlihatkan'"></span>
                            </button>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" value="password" required
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-950/80 border border-slate-700 rounded-2xl text-sm sm:text-base text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-sm sm:text-base shadow-xl shadow-emerald-950/60 border border-emerald-400/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                            <i data-lucide="log-in" class="w-5 h-5"></i>
                            <span>MASUK KE SISTEM RT</span>
                        </button>
                    </div>
                </form>

                <!-- Informasi Bantuan Akun Standar -->
                <div class="p-4 bg-slate-950/60 rounded-2xl border border-slate-800 text-xs text-slate-400 space-y-1">
                    <strong class="text-slate-300 font-bold block">Contoh Akun Pengurus:</strong>
                    <p>Ketua RT: <code class="text-emerald-400 font-mono">rt@rt03.test</code> (Sandi: <code class="text-slate-300 font-mono">password</code>)</p>
                    <p>Sekretaris: <code class="text-blue-400 font-mono">sekretaris@rt03.test</code></p>
                </div>
            </div>

        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
