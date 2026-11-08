<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Pengurus - RT 005 / RW 013 Perumahan Bumi Mutiara Indah II</title>
    
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
<body class="min-h-screen bg-slate-100 text-slate-800 font-sans antialiased flex flex-col justify-between py-8 px-4 sm:px-6" 
      x-data="{ tab: 'quick', showPassword: false }">

    <!-- Header & Brand Logo -->
    <header class="w-full max-w-xl mx-auto text-center pt-2 pb-4">
        <a href="{{ route('portal.warga') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-700 mb-4 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Portal Publik Warga</span>
        </a>

        <div class="flex items-center justify-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-blue-700 text-white flex items-center justify-center font-bold text-xl shadow-sm flex-shrink-0">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
            <div class="text-left">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-tight">RT 005 / RW 013</h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">Perumahan Bumi Mutiara Indah II</p>
            </div>
        </div>
        <p class="text-xs text-slate-500 mt-2 font-medium">
            Perancangan Sistem Informasi Pendataan dan Pelayanan Warga Berbasis Web
        </p>
    </header>

    <!-- Main Login Card -->
    <main class="w-full max-w-xl mx-auto my-auto">
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 sm:p-8">
            
            <!-- Notifikasi Error -->
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-900 text-xs sm:text-sm p-4 rounded-xl flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="font-bold block">Gagal Masuk:</strong>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <!-- Tab Switcher -->
            <div class="flex p-1 bg-slate-100 rounded-xl mb-6">
                <button type="button" @click="tab = 'quick'" 
                        :class="tab === 'quick' ? 'bg-white text-blue-700 font-bold shadow-xs' : 'text-slate-500 font-medium hover:text-slate-800'"
                        class="flex-1 py-2.5 text-xs sm:text-sm rounded-lg transition-all flex items-center justify-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4"></i>
                    <span>Pilih Akun Pengurus</span>
                </button>
                <button type="button" @click="tab = 'manual'" 
                        :class="tab === 'manual' ? 'bg-white text-blue-700 font-bold shadow-xs' : 'text-slate-500 font-medium hover:text-slate-800'"
                        class="flex-1 py-2.5 text-xs sm:text-sm rounded-lg transition-all flex items-center justify-center gap-2">
                    <i data-lucide="key-round" class="w-4 h-4"></i>
                    <span>Masuk Manual (Email)</span>
                </button>
            </div>

            <!-- TAB 1: 1-Klik Masuk Pengurus -->
            <div x-show="tab === 'quick'" class="space-y-2.5">
                <div class="text-center pb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                        @if($demoUsers->count() === 1)
                            Akun Pengurus Tersedia (1-Klik Masuk):
                        @else
                            Pilih Profil Pengurus untuk Masuk Langsung:
                        @endif
                    </p>
                </div>

                @forelse($demoUsers as $u)
                    <a href="{{ route('quick-login', $u->role) }}" class="group block p-3.5 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-700 text-white flex items-center justify-center text-lg font-bold flex-shrink-0">
                                    @if($u->role === 'ketua_rt') 👑
                                    @elseif($u->role === 'sekretaris') 📝
                                    @elseif($u->role === 'bendahara') 💰
                                    @elseif($u->role === 'humas') 📢
                                    @elseif($u->role === 'keamanan') 🛡️
                                    @else 👤
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 group-hover:text-blue-700 transition-colors">
                                        {{ $u->name }}
                                        <span class="ml-1 text-[10px] font-bold uppercase text-blue-800 bg-blue-100 px-2 py-0.5 rounded-full">{{ $u->jabatan ?? ucfirst($u->role) }}</span>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $u->email }}</div>
                                </div>
                            </div>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-400 group-hover:text-blue-700 group-hover:translate-x-1 transition-all flex-shrink-0"></i>
                        </div>
                    </a>
                @empty
                    <p class="text-center text-xs text-slate-500 py-4">Belum ada akun pengurus terdaftar. Silakan gunakan tab Masuk Manual.</p>
                @endforelse
            </div>

            <!-- TAB 2: Masuk Manual (Email & Sandi) -->
            <div x-cloak x-show="tab === 'manual'" class="space-y-4">
                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email Pengurus:</label>
                        <div class="relative">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="email" name="email" value="{{ old('email', 'rt@bumimutiara.id') }}" required
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi:</label>
                            <button type="button" @click="showPassword = !showPassword" class="text-xs text-blue-700 hover:underline font-semibold">
                                <span x-text="showPassword ? 'Sembunyikan' : 'Perlihatkan'"></span>
                            </button>
                        </div>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input :type="showPassword ? 'text' : 'password'" name="password" value="password" required
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full py-3 px-6 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm shadow-xs transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                            <span>Masuk ke Meja Kerja Pengurus</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-xl mx-auto text-center text-xs text-slate-500 pt-6">
        <p>RT 005 RW 013 Perumahan Bumi Mutiara Indah II &copy; {{ date('Y') }}</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
