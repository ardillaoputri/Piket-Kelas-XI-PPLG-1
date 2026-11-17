<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Petugas - PiketKelas XI PPLG 1</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        piket: {
                            charcoal: '#131E18',
                            sidebar: '#17241D',
                            forest: '#1E2D24',
                            border: '#26382E',
                            muted: '#809488',
                            accent: '#10B981',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-piket-charcoal text-gray-100 min-h-screen flex">
    <aside class="w-64 bg-piket-sidebar border-r border-piket-border flex flex-col justify-between shrink-0 min-h-screen p-5">
        <div>
            <div class="flex items-center gap-3 pb-6 border-b border-piket-border mb-6">
                <span class="text-2xl">🌱</span>
                <div>
                    <h1 class="font-bold text-base text-white leading-tight">PiketKelas</h1>
                    <span class="text-[11px] text-piket-muted">Panel Petugas</span>
                </div>
            </div>

            <nav class="space-y-1.5 text-sm font-medium">
                <a href="{{ route('petugas.denda') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('petugas.denda') ? 'bg-piket-border text-white' : 'text-piket-muted hover:text-white hover:bg-piket-forest' }}">
                    <span>💳</span> <span>Kelola Denda</span>
                </a>
                <a href="{{ route('petugas.laporan') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('petugas.laporan') ? 'bg-piket-border text-white' : 'text-piket-muted hover:text-white hover:bg-piket-forest' }}">
                    <span>📋</span> <span>Laporan Murid</span>
                </a>
                <a href="{{ route('petugas.dokumentasi') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('petugas.dokumentasi') ? 'bg-piket-border text-white' : 'text-piket-muted hover:text-white hover:bg-piket-forest' }}">
                    <span>📸</span> <span>Dokumentasi Foto</span>
                </a>
                <a href="{{ route('petugas.pengumuman') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('petugas.pengumuman') ? 'bg-piket-border text-white' : 'text-piket-muted hover:text-white hover:bg-piket-forest' }}">
                    <span>📢</span> <span>Kelola Pengumuman</span>
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-piket-muted hover:text-white hover:bg-piket-forest transition pt-4">
                    <span>🌐</span> <span>Kembali ke Web Publik</span>
                </a>
            </nav>
        </div>

        <div class="pt-4 border-t border-piket-border">
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-3.5 py-2.5 rounded-xl text-red-400 hover:bg-red-950/40 text-sm font-semibold transition">
                    <span>🚪</span> <span>Logout Petugas</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>