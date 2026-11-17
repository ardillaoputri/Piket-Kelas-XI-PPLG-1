@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Kontak Petugas & Bendahara</h2>
    <p class="text-xs md:text-sm text-gray-500 dark:text-piket-muted">Hubungi pengurus untuk konfirmasi denda atau perizinan jadwal.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Kartu Bendahara Kelas -->
    <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-6 shadow-card flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <span class="text-3xl">💰</span>
                <div>
                    <h3 class="font-bold text-base text-gray-800 dark:text-white">Bendahara Kelas</h3>
                    <span class="text-xs text-gray-400">Pembayaran Denda & Kas Kelas</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-300 mb-5 leading-relaxed">
                Pembayaran denda piket sebesar Rp 10.000 atau konfirmasi transfer kas dapat menghubungi kontak berikut:
            </p>

            <div class="space-y-3 mb-2">
                <!-- Bendahara 1 -->
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 dark:bg-[#14201A] border border-gray-100 dark:border-[#26382E]">
                    <div>
                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200 block">Bendahara 1: Maudy</span>
                        <span class="text-sm font-semibold text-emerald-500 dark:text-emerald-400 font-mono tracking-wide mt-0.5 block">+62 895 0544 1414</span>
                    </div>
                    <a href="https://wa.me/6289505441414?text=Halo%20Maudy,%20saya%20ingin%20konfirmasi%20pembayaran%20denda/kas%20piket." 
                       target="_blank"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow transition active:scale-95">
                        <span>💬</span> <span>Chat WA</span>
                    </a>
                </div>

                <!-- Bendahara 2 -->
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 dark:bg-[#14201A] border border-gray-100 dark:border-[#26382E]">
                    <div>
                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200 block">Bendahara 2: Amel</span>
                        <span class="text-sm font-semibold text-emerald-500 dark:text-emerald-400 font-mono tracking-wide mt-0.5 block">+62 895 3301 41832</span>
                    </div>
                    <a href="https://wa.me/62895330141832?text=Halo%20Amel,%20saya%20ingin%20konfirmasi%20pembayaran%20denda/kas%20piket." 
                       target="_blank"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow transition active:scale-95">
                        <span>💬</span> <span>Chat WA</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Seksi Kebersihan -->
    <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-6 shadow-card flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <span class="text-3xl">🧹</span>
                <div>
                    <h3 class="font-bold text-base text-gray-800 dark:text-white">Seksi Kebersihan</h3>
                    <span class="text-xs text-gray-400">Jadwal, Penggantian & Tugas Kebersihan</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-300 mb-5 leading-relaxed">
                Untuk izin tukar jadwal piket atau perizinan sakit/keperluan penting, konfirmasi paling lambat H-1:
            </p>

            <div class="space-y-3 mb-2">
                <!-- Seksi Kebersihan 1 -->
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 dark:bg-[#14201A] border border-gray-100 dark:border-[#26382E]">
                    <div>
                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200 block">Seksi Kebersihan 1: Revan</span>
                        <span class="text-sm font-semibold text-emerald-500 dark:text-emerald-400 font-mono tracking-wide mt-0.5 block">+62 812 1370 5467</span>
                    </div>
                    <a href="https://wa.me/6281213705467?text=Halo%20Revan,%20saya%20ingin%20izin%20konfirmasi%20jadwal%20piket." 
                       target="_blank"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow transition active:scale-95">
                        <span>💬</span> <span>Chat WA</span>
                    </a>
                </div>

                <!-- Seksi Kebersihan 2 -->
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 dark:bg-[#14201A] border border-gray-100 dark:border-[#26382E]">
                    <div>
                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200 block">Seksi Kebersihan 2: Galuh</span>
                        <span class="text-sm font-semibold text-emerald-500 dark:text-emerald-400 font-mono tracking-wide mt-0.5 block">+62 822 9885 5161</span>
                    </div>
                    <a href="https://wa.me/6282298855161?text=Halo%20Galuh,%20saya%20ingin%20izin%20konfirmasi%20jadwal%20piket." 
                       target="_blank"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow transition active:scale-95">
                        <span>💬</span> <span>Chat WA</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection