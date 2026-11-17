@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Card dengan Jam & Tanggal Besar di Samping Kanan -->
    <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-6 shadow-card">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <!-- Sisi Kiri: Info Piket -->
            <div>
                <span class="text-xs font-semibold px-3.5 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                    {{ $hariSekarang }}
                </span>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white mt-3">
                    Piket {{ $isLibur ? 'Berikutnya (Senin)' : 'Hari Ini (' . $hariSekarang . ')' }}
                </h2>
                <p class="text-xs md:text-sm text-gray-500 dark:text-piket-muted mt-1">
                    Jaga kebersihan kelas XI PPLG 1 demi kenyamanan belajar bersama.
                </p>
                <div class="mt-4 flex items-center gap-2 text-xs text-gray-400">
                    <span>Total Laporan Selesai:</span>
                    <span class="font-bold text-emerald-500 text-sm">{{ $totalLaporan }}</span>
                </div>
            </div>

            <!-- Sisi Kanan: Jam Digital & Tanggal Berukuran Besar -->
            <div class="bg-white/80 dark:bg-[#14201A] border border-gray-200 dark:border-[#273B2E] rounded-2xl p-4 md:p-5 flex flex-col items-start md:items-end justify-center shadow-sm shrink-0 min-w-[240px]">
                <span id="live-time" class="text-3xl md:text-4xl font-mono font-extrabold text-emerald-600 dark:text-emerald-400 tracking-wider">
                    --:--:--
                </span>
                <div class="flex items-center gap-2 mt-1.5">
                    <span id="live-date" class="text-xs md:text-sm font-semibold text-gray-700 dark:text-gray-200"></span>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-900/60 text-emerald-300 border border-emerald-700/60">WIB</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Piket Hari Ini / Senin -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 shadow-card">
            <h3 class="font-bold text-sm md:text-base text-gray-800 dark:text-white mb-3 flex items-center gap-2">
                <span>🧹</span> <span>Petugas Piket Kelas</span>
            </h3>
            <ul class="space-y-2">
                @foreach($piketKelas as $idx => $nama)
                    <li class="bg-gray-50 dark:bg-[#16231C] px-3.5 py-2.5 rounded-xl text-xs md:text-sm text-gray-700 dark:text-gray-200 border border-gray-100 dark:border-[#273B2E] flex justify-between items-center">
                        <span class="font-medium">{{ $idx + 1 }}. {{ $nama }}</span>
                        <span class="text-[11px] text-gray-400">Kelas</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 shadow-card">
            <h3 class="font-bold text-sm md:text-base text-amber-500 mb-3 flex items-center gap-2">
                <span>🍱</span> <span>Petugas Piket MBG</span>
            </h3>
            <ul class="space-y-2">
                @foreach($piketMBG as $idx => $nama)
                    <li class="bg-gray-50 dark:bg-[#16231C] px-3.5 py-2.5 rounded-xl text-xs md:text-sm text-gray-700 dark:text-gray-200 border border-gray-100 dark:border-[#273B2E] flex justify-between items-center">
                        <span class="font-medium">{{ $idx + 1 }}. {{ $nama }}</span>
                        <span class="text-[11px] font-semibold text-amber-500">MBG</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Info Pengumuman Terbaru -->
    @if(isset($pengumuman->title))
        <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 shadow-card">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-lg">📢</span>
                <h3 class="font-bold text-sm text-gray-800 dark:text-white">{{ $pengumuman->title }}</h3>
            </div>
            <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">{{ $pengumuman->content }}</p>
        </div>
    @endif
</div>

<!-- SCRIPT JAM DIGITAL BESAR & TANGGAL -->
<script>
    function perbaruiWaktu() {
        const waktuSekarang = new Date();

        // Format Tanggal: Contoh "1 November 2026"
        const opsi = { day: 'numeric', month: 'long', year: 'numeric' };
        const teksTgl = waktuSekarang.toLocaleDateString('id-ID', opsi);

        // Format Jam 24 Jam
        const jam = String(waktuSekarang.getHours()).padStart(2, '0');
        const menit = String(waktuSekarang.getMinutes()).padStart(2, '0');
        const detik = String(waktuSekarang.getSeconds()).padStart(2, '0');

        const elJam = document.getElementById('live-time');
        const elTgl = document.getElementById('live-date');

        if (elJam) elJam.innerText = `${jam}:${menit}:${detik}`;
        if (elTgl) elTgl.innerText = teksTgl;
    }

    perbaruiWaktu();
    setInterval(perbaruiWaktu, 1000);
</script>
@endsection