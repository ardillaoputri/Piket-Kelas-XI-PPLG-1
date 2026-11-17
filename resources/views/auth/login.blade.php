<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas - PiketKelas XI PPLG 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0D1512 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff !important;
        }
    </style>
</head>
<body class="bg-[#0B130F] text-gray-200 min-h-screen flex items-center justify-center p-4 selection:bg-emerald-500 selection:text-white font-['Plus_Jakarta_Sans',sans-serif]">

    <div class="w-full max-w-md">
        <!-- Kartu Login -->
        <div class="bg-[#14201A] border border-[#23352A] rounded-3xl p-8 shadow-2xl relative">
            
            <!-- Header Logo & Judul -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#1C2C24] border border-[#2B4235] shadow-inner mb-3">
                    <svg class="w-7 h-7 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22v-7"></path>
                        <path d="M9 9a3 3 0 0 1 6 0c0 4-3 6-3 6s-3-2-3-6Z"></path>
                        <path d="M12 15a6 6 0 0 0 6-6c0-2-2-5-6-5s-6 3-6 5a6 6 0 0 0 6 6Z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Login Petugas</h1>
                <p class="text-xs text-gray-400 mt-1">Akses khusus seksi kebersihan & pengurus XI PPLG 1</p>
            </div>

            @if(session('error'))
                <div class="mb-5 p-3 rounded-xl bg-red-950/80 border border-red-800 text-red-300 text-xs font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form method="POST" action="{{ url('/login') }}" autocomplete="off" class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <label class="block text-xs font-semibold text-gray-300 mb-2">Email Petugas</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" 
                               name="email" 
                               required 
                               autocomplete="off"
                               placeholder="Masukkan email petugas..." 
                               value=""
                               class="w-full pl-10 pr-4 py-3 text-xs md:text-sm rounded-xl bg-[#0D1512] border border-[#283D31] text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition shadow-inner">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-xs font-semibold text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" 
                               name="password" 
                               id="password-input"
                               required 
                               autocomplete="new-password"
                               placeholder="Masukkan password..." 
                               value=""
                               class="w-full pl-10 pr-11 py-3 text-xs md:text-sm rounded-xl bg-[#0D1512] border border-[#283D31] text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition shadow-inner">
                        
                        <button type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-white transition cursor-pointer">
                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" 
                        class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-500 active:scale-[0.98] text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-950/40 transition flex items-center justify-center gap-2 cursor-pointer mt-3">
                    <span>Masuk ke Panel</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <!-- Navigasi Kembali -->
            <div class="mt-8 text-center pt-4 border-t border-[#23352A]">
                <a href="{{ url('/') }}" class="text-xs font-medium text-gray-400 hover:text-emerald-400 transition inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>
</html>