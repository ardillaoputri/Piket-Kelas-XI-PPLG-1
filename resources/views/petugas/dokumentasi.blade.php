@extends('layouts.petugas')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white">Kelola Dokumentasi Kebersihan</h2>
    <p class="text-xs text-piket-muted mt-1">Upload foto bukti kebersihan kelas atau tugas MBG yang akan tampil di halaman publik.</p>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-emerald-950 border border-emerald-800 text-emerald-300 rounded-xl text-xs">
        {{ session('success') }}
    </div>
@endif

<div class="bg-piket-forest rounded-2xl border border-piket-border p-6 shadow-xl mb-8">
    <h3 class="font-bold text-sm text-white mb-4 flex items-center gap-2">
        <span>📸</span> <span>Upload Dokumentasi Baru</span>
    </h3>
    <form method="POST" action="{{ route('petugas.dokumentasi.store') }}" 
          enctype="multipart/form-data" 
          onsubmit="return confirm('Apakah dokumentasi foto sudah benar dan siap disimpan?')"
          class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-300 mb-1">Jenis Piket</label>
                <select name="type" required class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white">
                    <option value="Piket Kelas">Piket Kelas</option>
                    <option value="Piket MBG">Piket MBG</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-300 mb-1">Catatan Tambahan (Opsional)</label>
                <input type="text" name="note" placeholder="Contoh: Sudah diperiksa dan rapi" class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-300 mb-1">Upload File Foto</label>
            <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-gray-300">
            <span class="text-[11px] text-gray-400 mt-1 block">Atau masukkan Link/URL Gambar di bawah ini jika tidak ada file lokal:</span>
            <input type="url" name="image_url" placeholder="https://..." class="w-full mt-1.5 px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-300 mb-1">Deskripsi Kondisi Kebersihan</label>
            <textarea name="description" rows="2" required placeholder="Contoh: Lantai disapu bersih, dipel, dan sampah telah dibuang."
                      class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white"></textarea>
        </div>

        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm rounded-xl shadow transition cursor-pointer">
            + Simpan Dokumentasi
        </button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($reports as $index => $item)
        <div class="bg-piket-forest rounded-2xl border border-piket-border overflow-hidden shadow-xl">
            <img src="{{ $item['image_path'] }}" alt="Dokumentasi" class="w-full h-44 object-cover">
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-gray-400 font-medium">#{{ $index + 1 }} &bull; {{ $item['date'] }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold bg-emerald-950 text-emerald-300 border border-emerald-800">
                        {{ $item['type'] }}
                    </span>
                </div>
                <p class="text-xs text-gray-300 mt-2">{{ $item['description'] }}</p>
                <div class="mt-4 pt-3 border-t border-piket-border flex items-center justify-between">
                    <span class="text-[11px] text-gray-400 italic">"{{ $item['note'] ?? '-' }}"</span>
                    <form method="POST" action="{{ route('petugas.dokumentasi.delete', $item['id']) }}"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto dokumentasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 font-semibold cursor-pointer">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-8 text-piket-muted text-xs">Belum ada dokumentasi tersimpan.</div>
    @endforelse
</div>
@endsection