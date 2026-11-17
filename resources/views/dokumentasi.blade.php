=@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Dokumentasi Piket</h2>
    <p class="text-xs md:text-sm text-gray-500 dark:text-piket-muted">Foto kondisi kebersihan ruang kelas dan kegiatan MBG.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($reports as $index => $item)
        <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] overflow-hidden shadow-card">
            <img src="{{ $item['image_path'] }}" alt="Dokumentasi" class="w-full h-48 object-cover">
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-gray-400 font-medium">#{{ $index + 1 }} &bull; {{ $item['date'] }}</span>
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                        {{ $item['type'] }}
                    </span>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">{{ $item['description'] }}</p>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-12 text-gray-400 text-xs">Belum ada dokumentasi tersimpan.</div>
    @endforelse
</div>
@endsection