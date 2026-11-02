<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIP-RT 03') - Sistem Informasi & Arsip Digital RT</title>
    
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
        @media print {
            .no-print { display: none !important; }
        }
        /* Custom scrollbar for modern feel */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.4);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(51, 65, 85, 0.6);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.6);
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased flex flex-col font-sans" 
      x-data="{ 
          sidebarOpen: false, 
          desktopSidebarOpen: (localStorage.getItem('rt_sidebar_open') !== 'false') 
      }">

    <div class="flex h-screen overflow-hidden bg-slate-100 relative">
        
        <!-- SIDEBAR MODERN & KEREN (DESKTOP) - BISA DIBUKA / DITUTUP BEBAS -->
        <aside class="hidden lg:flex flex-shrink-0 transition-all duration-300 ease-in-out z-30"
               :class="desktopSidebarOpen ? 'w-72' : 'w-0 overflow-hidden'">
            <div class="flex flex-col w-72 h-full bg-slate-950 border-r border-slate-800/80 text-white relative shadow-2xl transition-transform duration-300 ease-in-out"
                 :class="desktopSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                
                <!-- Ambient Subtle Top Glow -->
                <div class="absolute top-0 left-0 right-0 h-40 bg-gradient-to-b from-emerald-600/10 to-transparent pointer-events-none"></div>

                <!-- Brand Header -->
                <div class="flex items-center justify-between px-6 h-20 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 p-0.5 shadow-lg shadow-emerald-950/60 flex items-center justify-center flex-shrink-0">
                            <div class="w-full h-full bg-slate-950/30 rounded-[14px] flex items-center justify-center backdrop-blur-sm">
                                <i data-lucide="archive" class="w-5 h-5 text-emerald-300"></i>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <h1 class="text-base font-black tracking-tight text-white leading-tight">SIP-RT 03</h1>
                                <span class="text-[9px] font-black uppercase px-1.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Pro</span>
                            </div>
                            <p class="text-[11px] text-slate-400 font-medium">RW 02 Sukamaju</p>
                        </div>
                    </div>
                    <!-- Tombol Tutup Sidebar di Dalam Sidebar -->
                    <button type="button" 
                            @click="desktopSidebarOpen = false; localStorage.setItem('rt_sidebar_open', 'false')"
                            class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-800/80 rounded-xl transition-colors"
                            title="Tutup sidebar agar layar penuh">
                        <i data-lucide="panel-left-close" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Tombol Buat Surat Utama (Keren & Glowing) -->
                <div class="p-4 border-b border-slate-800/80 relative z-10">
                    <a href="{{ route('surat-pengantar.create') }}" class="group relative flex items-center justify-center gap-2.5 w-full bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-sm py-3.5 px-4 rounded-2xl shadow-xl shadow-emerald-950/50 border border-emerald-400/30 transition-all duration-300 active:scale-95 overflow-hidden">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-200"></i>
                        <span>+ BUAT SURAT WARGA</span>
                    </a>
                </div>

                <!-- Navigasi Menu Elegan & Modern -->
                <div class="flex-1 flex flex-col overflow-y-auto px-4 py-4 space-y-6 relative z-10">
                    
                    <!-- Menu Surat & Arsip Langsung (Menjawab Permintaan User) -->
                    <div>
                        <p class="px-2 text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Pelayanan & Arsip Surat</p>
                        <nav class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-emerald-500 text-white shadow-md shadow-emerald-900/50' : 'bg-slate-900 text-slate-400' }}">
                                    <i data-lucide="home" class="w-4 h-4"></i>
                                </div>
                                <span>Halaman Utama</span>
                            </a>

                            <a href="{{ route('arsip.semua') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('arsip.semua') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('arsip.semua') ? 'bg-emerald-500 text-white shadow-md shadow-emerald-900/50' : 'bg-slate-900 text-slate-400' }}">
                                    <i data-lucide="folders" class="w-4 h-4"></i>
                                </div>
                                <span class="flex-1">Semua Surat & Berkas</span>
                                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300">Pusat</span>
                            </a>

                            <a href="{{ route('surat-pengantar.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('surat-pengantar.*') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('surat-pengantar.*') ? 'bg-emerald-500 text-white shadow-md shadow-emerald-900/50' : 'bg-slate-900 text-slate-400' }}">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <span class="flex-1">Surat Pengantar (Keluar)</span>
                                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300">Lihat</span>
                            </a>

                            <a href="{{ route('surat-masuk.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('surat-masuk.*') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('surat-masuk.*') ? 'bg-emerald-500 text-white shadow-md shadow-emerald-900/50' : 'bg-slate-900 text-slate-400' }}">
                                    <i data-lucide="inbox" class="w-4 h-4"></i>
                                </div>
                                <span class="flex-1">Surat Masuk (Desa/RW)</span>
                                <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded bg-blue-500/20 text-blue-300">Berkas</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Kependudukan & Laporan Desa -->
                    <div>
                        <p class="px-2 text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Administrasi Warga</p>
                        <nav class="space-y-1">
                            <a href="{{ route('warga.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('warga.index') || request()->routeIs('warga.create') || request()->routeIs('warga.edit') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('warga.index') ? 'bg-emerald-500 text-white' : 'bg-slate-900 text-slate-400' }}">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                </div>
                                <span>Data Semua Warga</span>
                            </a>

                            <a href="{{ route('warga.kontrak') }}" class="flex items-center justify-between px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('warga.kontrak') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-amber-200/90 hover:bg-slate-900 hover:text-amber-300' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-500/20 text-amber-300">
                                        <i data-lucide="building-2" class="w-4 h-4"></i>
                                    </div>
                                    <span>Warga Kontrak & Kost</span>
                                </div>
                                <span class="text-[10px] font-black bg-amber-500/30 text-amber-200 px-2 py-0.5 rounded-full border border-amber-400/30">Pantau</span>
                            </a>

                            <a href="{{ route('keluarga.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('keluarga.index') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-900 text-slate-400">
                                    <i data-lucide="folder" class="w-4 h-4"></i>
                                </div>
                                <span>Kartu Keluarga (KK)</span>
                            </a>

                            <a href="{{ route('kependudukan.laporan-desa') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('kependudukan.laporan-desa') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-900 text-slate-400">
                                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                                </div>
                                <span>Laporan Bulanan Desa</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Keuangan & Keamanan -->
                    <div>
                        <p class="px-2 text-[11px] font-black uppercase tracking-wider text-slate-400 mb-2">Kas RT, Iuran & Ronda</p>
                        <nav class="space-y-1">
                            <a href="{{ route('keuangan.kas.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('keuangan.kas.*') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-900 text-slate-400">
                                    <i data-lucide="wallet" class="w-4 h-4"></i>
                                </div>
                                <span>Buku Kas RT</span>
                            </a>

                            <a href="{{ route('keuangan.iuran.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('keuangan.iuran.*') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-900 text-slate-400">
                                    <i data-lucide="coins" class="w-4 h-4"></i>
                                </div>
                                <span>Iuran Warga (Humas)</span>
                            </a>

                            <a href="{{ route('keamanan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-bold rounded-xl transition-all duration-200 {{ request()->routeIs('keamanan.*') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-900 text-slate-400">
                                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                                </div>
                                <span>Jadwal Ronda / Kamtibmas</span>
                            </a>
                        </nav>
                    </div>

                </div>

                <!-- Profil Pengurus -->
                <div class="p-4 border-t border-slate-800/80 bg-slate-900/60 backdrop-blur-md relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center font-black text-sm text-white shadow-md">
                                    {{ substr(Auth::user()->name ?? 'RT', 0, 2) }}
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-slate-950"></span>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs font-black text-white truncate">{{ Auth::user()->name ?? 'Pengurus RT' }}</p>
                                <p class="text-[11px] text-emerald-400 font-bold truncate">{{ Auth::user()->jabatan ?? 'Ketua RT 03' }}</p>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" title="Keluar dari Aplikasi" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800/80 rounded-xl transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Area Konten Utama -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header Atas: Modern & Sleek -->
            <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 h-20 flex items-center justify-between px-4 sm:px-8 z-10 no-print sticky top-0 shadow-sm">
                <div class="flex items-center gap-3">
                    <!-- Tombol Buka / Tutup Sidebar Desktop (Bebas diatur pengurus) -->
                    <button type="button" 
                            @click="desktopSidebarOpen = !desktopSidebarOpen; localStorage.setItem('rt_sidebar_open', desktopSidebarOpen)"
                            class="hidden lg:inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 hover:text-slate-900 border border-slate-300 font-bold text-xs transition-all shadow-sm active:scale-95 group"
                            :title="desktopSidebarOpen ? 'Tutup sidebar agar layar lebih lebar' : 'Buka kembali sidebar menu'">
                        <i data-lucide="panel-left-close" x-show="desktopSidebarOpen" class="w-4 h-4 text-emerald-600 group-hover:scale-110 transition-transform"></i>
                        <i data-lucide="panel-left-open" x-show="!desktopSidebarOpen" class="w-4 h-4 text-emerald-600 group-hover:scale-110 transition-transform"></i>
                        <span x-text="desktopSidebarOpen ? 'Tutup Menu' : 'Buka Menu'"></span>
                    </button>

                    <!-- Tombol Menu Mobile -->
                    <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2.5 rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 transition-colors">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>

                    <div>
                        <h2 class="text-base sm:text-xl font-black text-slate-900 leading-tight">@yield('header_title', 'Administrasi RT 03')</h2>
                        <p class="text-xs text-slate-500 font-semibold hidden sm:block">RT 03 / RW 02 Desa Sukamaju • Tahun {{ date('Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('surat-pengantar.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs sm:text-sm font-black px-4 py-2.5 rounded-xl shadow-md shadow-emerald-900/20 transition-all active:scale-95">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        <span>+ Buat Surat Pengantar</span>
                    </a>
                </div>
            </header>

            <!-- Isi Halaman Utama -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-8 bg-slate-100/90">
                <!-- Notifikasi Berhasil -->
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3.5 bg-emerald-50 border-2 border-emerald-400 text-emerald-950 px-5 py-4 rounded-2xl shadow-sm no-print">
                        <div class="p-2 rounded-xl bg-emerald-200 text-emerald-800 flex-shrink-0">
                            <i data-lucide="check-circle" class="w-6 h-6"></i>
                        </div>
                        <div class="text-sm sm:text-base font-bold">{{ session('success') }}</div>
                    </div>
                @endif

                <!-- Notifikasi Info -->
                @if(session('info'))
                    <div class="mb-6 flex items-center gap-3.5 bg-blue-50 border-2 border-blue-400 text-blue-950 px-5 py-4 rounded-2xl shadow-sm no-print">
                        <div class="p-2 rounded-xl bg-blue-200 text-blue-800 flex-shrink-0">
                            <i data-lucide="info" class="w-6 h-6"></i>
                        </div>
                        <div class="text-sm sm:text-base font-bold">{{ session('info') }}</div>
                    </div>
                @endif

                <!-- Notifikasi Error -->
                @if($errors->any())
                    <div class="mb-6 bg-rose-50 border-2 border-rose-400 text-rose-950 px-5 py-4 rounded-2xl shadow-sm no-print">
                        <div class="flex items-center gap-2 font-extrabold text-sm sm:text-base mb-1.5 text-rose-900">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 flex-shrink-0"></i>
                            <span>Mohon periksa kembali isian formulir:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs sm:text-sm space-y-1 text-rose-800 font-semibold pl-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Floating Quick Button to reopen sidebar when closed on desktop -->
    <div x-cloak x-show="!desktopSidebarOpen" class="hidden lg:block fixed bottom-6 left-6 z-40">
        <button type="button" @click="desktopSidebarOpen = true; localStorage.setItem('rt_sidebar_open', 'true')"
                class="px-4 py-2.5 bg-slate-950 text-white rounded-2xl shadow-2xl border border-slate-700 hover:border-emerald-500 text-xs font-black flex items-center gap-2 transition-all active:scale-95 group">
            <i data-lucide="panel-left-open" class="w-4 h-4 text-emerald-400 group-hover:scale-110 transition-transform"></i>
            <span>Buka Menu Sidebar</span>
        </button>
    </div>

    <!-- Mobile Sidebar Backdrop & Content -->
    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-md lg:hidden" @click="sidebarOpen = false"></div>
    <div x-cloak x-show="sidebarOpen" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white p-5 flex flex-col lg:hidden transition ease-in-out duration-300">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <span class="font-black text-white text-lg">SIP-RT 03</span>
            <button @click="sidebarOpen = false" class="p-2 text-slate-400 hover:text-white rounded-lg">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="mt-4 space-y-2 overflow-y-auto flex-1 font-bold text-sm">
            <a href="{{ route('surat-pengantar.create') }}" class="block p-3 rounded-2xl bg-emerald-600 text-white text-center font-black mb-4">+ BUAT SURAT WARGA</a>
            <a href="{{ route('dashboard') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Halaman Utama</a>
            <a href="{{ route('arsip.semua') }}" class="block p-3 rounded-xl text-emerald-400 bg-emerald-950/40 border border-emerald-500/30">Semua Surat & Berkas (Pusat)</a>
            <a href="{{ route('surat-pengantar.index') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Surat Pengantar (Keluar)</a>
            <a href="{{ route('surat-masuk.index') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Surat Masuk (Desa/RW)</a>
            <a href="{{ route('warga.index') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Data Warga</a>
            <a href="{{ route('warga.kontrak') }}" class="block p-3 rounded-xl text-amber-300 hover:bg-slate-800">Warga Kontrak</a>
            <a href="{{ route('keluarga.index') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Kartu Keluarga</a>
            <a href="{{ route('kependudukan.laporan-desa') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Laporan Desa</a>
            <a href="{{ route('keuangan.kas.index') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Kas RT</a>
            <a href="{{ route('keuangan.iuran.index') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Iuran Warga</a>
            <a href="{{ route('keamanan.index') }}" class="block p-3 rounded-xl text-slate-200 hover:bg-slate-800">Keamanan</a>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
