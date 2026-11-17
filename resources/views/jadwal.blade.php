@extends('layouts.app')

@section('content')
<div class="mb-5">
    <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Jadwal Piket</h2>
    <p class="text-xs md:text-sm text-gray-500 dark:text-piket-muted">Lihat jadwal piket kelas dan MBG per hari.</p>
</div>

<div x-data="{ activeDay: 'Senin' }">
    <div class="flex items-center gap-1.5 overflow-x-auto pb-3 mb-4 scrollbar-none">
        @foreach(array_keys($dataPiket) as $hari)
            <button type="button"
                    @click="activeDay = '{{ $hari }}'"
                    :class="activeDay === '{{ $hari }}' 
                        ? 'bg-emerald-600 text-white font-bold shadow-md' 
                        : 'bg-white dark:bg-piket-forest text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-[#2C4135]'"
                    class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition active:scale-95">
                {{ $hari }}
            </button>
        @endforeach
    </div>

    @foreach($dataPiket as $hari => $tugas)
        <div x-show="activeDay === '{{ $hari }}'" class="space-y-4">
            <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 shadow-card">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-[#2C4135]">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">🧹</span>
                        <h3 class="font-bold text-sm md:text-base text-gray-800 dark:text-white">Piket Kelas</h3>
                    </div>
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                        {{ count($tugas['kelas']) }} siswa
                    </span>
                </div>
                <ul class="space-y-2">
                    @foreach($tugas['kelas'] as $index => $nama)
                        <li class="bg-[#F8FAF7] dark:bg-[#16231C] px-3.5 py-2 rounded-xl border border-gray-200/60 dark:border-[#273B2E] text-xs md:text-sm text-gray-700 dark:text-gray-200 flex justify-between items-center shadow-sm">
                            <span class="font-medium">{{ $index + 1 }}. {{ $nama }}</span>
                            <span class="text-[10px] text-gray-400">Kelas</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 shadow-card">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-[#2C4135]">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">🍱</span>
                        <h3 class="font-bold text-sm md:text-base text-amber-500">Piket MBG</h3>
                    </div>
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300">
                        {{ count($tugas['mbg']) }} siswa
                    </span>
                </div>
                <ul class="space-y-2">
                    @foreach($tugas['mbg'] as $index => $nama)
                        <li class="bg-[#F8FAF7] dark:bg-[#16231C] px-3.5 py-2 rounded-xl border border-gray-200/60 dark:border-[#273B2E] text-xs md:text-sm text-gray-700 dark:text-gray-200 flex justify-between items-center shadow-sm">
                            <span class="font-medium">{{ $index + 1 }}. {{ $nama }}</span>
                            <span class="text-[10px] font-semibold text-amber-500">MBG</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection