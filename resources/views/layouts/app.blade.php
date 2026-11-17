<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PiketKelas - XI PPLG 1</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        piket: {
                            bgLight: '#ECEFEA',
                            cardLight: '#FFFFFF',
                            charcoal: '#141E1A',
                            forest: '#1E2D26',
                            sage: '#385043',
                            muted: '#8B9E94',
                            borderLight: '#D8DDD6',
                            accent: '#10B981',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(27, 43, 36, 0.06)',
                        'card': '0 2px 10px rgba(0,0,0,0.05)',
                        'bottomNav': '0 -4px 20px rgba(0, 0, 0, 0.15)',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-piket-bgLight dark:bg-piket-charcoal text-[#223028] dark:text-[#E2EBE5] min-h-screen flex flex-col pb-20 md:pb-8">

    <header class="bg-piket-forest border-b border-[#293c33] text-white sticky top-0 z-40 shadow-soft">
        <div class="max-w-md md:max-w-7xl mx-auto px-4 h-14 md:h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5">
                <span class="text-xl md:text-2xl">🌱</span>
                <div>
                    <h1 class="font-bold text-sm md:text-base leading-none text-white">PiketKelas</h1>
                    <span class="text-[10px] md:text-[11px] text-piket-muted">XI PPLG 1</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('home') ? 'bg-piket-sage text-white font-semibold' : 'text-[#BAC8C0] hover:text-white' }}">Beranda</a>
                <a href="{{ route('public.schedule') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('public.schedule') ? 'bg-piket-sage text-white font-semibold' : 'text-[#BAC8C0] hover:text-white' }}">Jadwal Piket</a>
                <a href="{{ route('public.reports') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('public.reports') ? 'bg-piket-sage text-white font-semibold' : 'text-[#BAC8C0] hover:text-white' }}">Laporan Piket</a>
                <a href="{{ route('public.announcements') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('public.announcements') ? 'bg-piket-sage text-white font-semibold' : 'text-[#BAC8C0] hover:text-white' }}">Pengumuman</a>
                <a href="{{ route('public.documentation') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('public.documentation') ? 'bg-piket-sage text-white font-semibold' : 'text-[#BAC8C0] hover:text-white' }}">Dokumentasi</a>
                <a href="{{ route('public.fines') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('public.fines') ? 'bg-piket-sage text-white font-semibold' : 'text-[#BAC8C0] hover:text-white' }}">Denda</a>
                <a href="{{ route('public.contact') }}" class="px-3 py-1.5 rounded-lg transition {{ request()->routeIs('public.contact') ? 'bg-piket-sage text-white font-semibold' : 'text-[#BAC8C0] hover:text-white' }}">Kontak</a>
            </nav>

            <div class="flex items-center space-x-2">
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')"
                        class="p-2 md:px-3 md:py-1.5 rounded-full text-xs font-semibold bg-[#25362E] hover:bg-piket-sage text-[#D3DFD8] border border-[#384E42] shadow-sm transition active:scale-95 flex items-center gap-1">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode">☀️</span>
                    <span class="hidden md:inline" x-text="darkMode ? 'Light' : 'Dark'"></span>
                </button>

                <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-600 hover:bg-emerald-500 text-white shadow-md transition active:scale-95">
                    Petugas
                </a>
            </div>
        </div>
    </header>

    <main class="w-full max-w-md md:max-w-7xl mx-auto px-4 py-4 md:py-8 flex-1">
        @yield('content')
    </main>

    <!-- Bottom Navigation Bar Mobile -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-piket-forest/95 backdrop-blur-md border-t border-[#293c33] text-white shadow-bottomNav">
        <div class="max-w-md mx-auto grid grid-cols-6 h-16 items-center px-1 text-center">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center py-1 transition {{ request()->routeIs('home') ? 'text-emerald-400 font-bold' : 'text-piket-muted hover:text-white' }}">
                <span class="text-lg">🏠</span>
                <span class="text-[10px] mt-0.5">Beranda</span>
            </a>
            <a href="{{ route('public.schedule') }}" class="flex flex-col items-center justify-center py-1 transition {{ request()->routeIs('public.schedule') ? 'text-emerald-400 font-bold' : 'text-piket-muted hover:text-white' }}">
                <span class="text-lg">📅</span>
                <span class="text-[10px] mt-0.5">Jadwal</span>
            </a>
            <a href="{{ route('public.reports') }}" class="flex flex-col items-center justify-center py-1 transition {{ request()->routeIs('public.reports') ? 'text-emerald-400 font-bold' : 'text-piket-muted hover:text-white' }}">
                <span class="text-lg">✍️</span>
                <span class="text-[10px] mt-0.5">Lapor</span>
            </a>
            <a href="{{ route('public.announcements') }}" class="flex flex-col items-center justify-center py-1 transition {{ request()->routeIs('public.announcements') ? 'text-emerald-400 font-bold' : 'text-piket-muted hover:text-white' }}">
                <span class="text-lg">📢</span>
                <span class="text-[10px] mt-0.5">Info</span>
            </a>
            <a href="{{ route('public.fines') }}" class="flex flex-col items-center justify-center py-1 transition {{ request()->routeIs('public.fines') ? 'text-emerald-400 font-bold' : 'text-piket-muted hover:text-white' }}">
                <span class="text-lg">💳</span>
                <span class="text-[10px] mt-0.5">Denda</span>
            </a>
            <a href="{{ route('public.contact') }}" class="flex flex-col items-center justify-center py-1 transition {{ request()->routeIs('public.contact') ? 'text-emerald-400 font-bold' : 'text-piket-muted hover:text-white' }}">
                <span class="text-lg">📞</span>
                <span class="text-[10px] mt-0.5">Kontak</span>
            </a>
        </div>
    </nav>
</body>
</html>