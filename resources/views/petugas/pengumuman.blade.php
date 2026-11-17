@extends('layouts.petugas')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white">Kelola Pengumuman</h2>
    <p class="text-xs text-piket-muted mt-1">Buat pengumuman baru untuk ditampilkan kepada seluruh anggota kelas.</p>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-emerald-950 border border-emerald-800 text-emerald-300 rounded-xl text-xs">
        {{ session('success') }}
    </div>
@endif

<div class="bg-piket-forest rounded-2xl border border-piket-border p-6 shadow-xl mb-8">
    <h3 class="font-bold text-sm text-white mb-4">Buat Pengumuman Baru</h3>
    <form method="POST" action="{{ route('petugas.pengumuman.store') }}" 
          onsubmit="return confirm('Publikasikan pengumuman baru ini ke halaman publik?')"
          class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-300 mb-1">Judul Pengumuman</label>
            <input type="text" name="title" required placeholder="Contoh: Evaluasi Piket Kelas"
                   class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-300 mb-1">Isi Pesan</label>
            <textarea name="content" rows="3" required placeholder="Tuliskan isi pengumuman..."
                      class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white"></textarea>
        </div>
        <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm rounded-xl shadow cursor-pointer">
            + Publikasikan
        </button>
    </form>
</div>

<div class="bg-piket-forest rounded-2xl border border-piket-border shadow-xl overflow-hidden">
    <div class="p-4 border-b border-piket-border text-xs text-gray-400 font-semibold">
        DAFTAR PENGUMUMAN AKTIF ({{ count($announcements) }})
    </div>
    <div class="divide-y divide-[#26382E]">
        @foreach($announcements as $index => $a)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400 font-medium">#{{ $index + 1 }}</span>
                        <h4 class="font-bold text-white text-sm">{{ $a['title'] }}</h4>
                        <span class="text-[11px] text-emerald-400 font-medium">{{ $a['date'] ?? '' }}</span>
                    </div>
                    <p class="text-xs text-gray-300 mt-1">{{ $a['content'] }}</p>
                </div>
                @if(isset($a['id']))
                    <form method="POST" action="{{ route('petugas.pengumuman.delete', $a['id']) }}"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2.5 py-1 text-xs bg-red-600 hover:bg-red-500 text-white rounded-lg cursor-pointer">
                            Hapus
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection