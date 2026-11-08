<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pelayanan & Pendataan Warga') - RT 005 / RW 013 Perumahan Bumi Mutiara Indah II</title>
    
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
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased font-sans flex flex-col justify-between bg-slate-100">

    <div>
        <!-- TOP HEADER RESMI PENGURUS -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-18 py-2">
                    
                    <!-- BRAND / IDENTITAS RESMI RT -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                            <div class="w-11 h-11 rounded-xl bg-blue-700 text-white flex items-center justify-center font-bold text-lg shadow-sm flex-shrink-0 group-hover:bg-blue-800 transition-colors">
                                <i data-lucide="building-2" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h1 class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">
                                        RT 005 / RW 013
                                    </h1>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">
                                        Pengurus
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 font-medium leading-tight truncate max-w-xs sm:max-w-md">
                                    Perumahan Bumi Mutiara Indah II
                                </p>
                            </div>
                        </a>
                    </div>

                    <!-- USER INFO & SHORTCUTS -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        @unless(request()->routeIs('dashboard'))
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-blue-700 bg-slate-100 hover:bg-blue-50 px-3 py-2 rounded-xl transition-colors border border-slate-200">
                                <i data-lucide="arrow-left" class="w-4 h-4 text-blue-700"></i>
                                <span class="hidden sm:inline">Kembali ke</span>
                                <span>Menu Utama</span>
                            </a>
                        @endunless

                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <i data-lucide="user-check" class="w-4 h-4 text-blue-700 flex-shrink-0"></i>
                            <div>
                                <span class="font-bold text-slate-900 block leading-tight">{{ auth()->user()->name ?? 'Pengurus RT' }}</span>
                                <span class="text-[10px] text-slate-500 block leading-none">{{ auth()->user()->jabatan ?? 'Ketua RT 005' }}</span>
                            </div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    title="Keluar dari Sistem"
                                    class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </header>

        <!-- FLASH NOTIFICATIONS -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start gap-3 shadow-xs">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                    <div class="flex-grow">
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-900 flex items-start gap-3 shadow-xs">
                    <i data-lucide="alert-octagon" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                    <div class="flex-grow">
                        <p class="font-bold text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-900 shadow-xs">
                    <div class="flex items-center gap-2 font-bold text-sm mb-1">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i>
                        <span>Mohon periksa kesalahan pengisian formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-red-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- MAIN BODY CONTENT -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @yield('content')
        </main>
    </div>

    <!-- FOOTER RESMI -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-xs text-slate-500 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="font-bold text-slate-800 text-sm">
                Perancangan Sistem Informasi Pendataan dan Pelayanan Warga Berbasis Web
            </p>
            <p class="text-xs text-slate-500 mt-1">
                RT 005 RW 013 Perumahan Bumi Mutiara Indah II &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
