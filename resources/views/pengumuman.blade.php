@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Pengumuman Kelas</h2>
    <p class="text-xs md:text-sm text-gray-500 dark:text-piket-muted">Informasi terbaru seputar kebersihan dan kegiatan kelas.</p>
</div>

<div class="space-y-4">
    @forelse($announcements as $index => $a)
        <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 shadow-card">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                    Pengumuman #{{ $index + 1 }}
                </span>
                <span class="text-xs text-gray-400">{{ $a['date'] ?? '22 Okt 2026' }}</span>
            </div>
            <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1.5">{{ $a['title'] }}</h3>
            <p class="text-xs md:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $a['content'] }}</p>
        </div>
    @empty
        <div class="text-center py-12 text-gray-400 text-xs">Belum ada pengumuman saat ini.</div>
    @endforelse
</div>
@endsection