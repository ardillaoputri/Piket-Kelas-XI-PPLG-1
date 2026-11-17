@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Laporan Piket Harian</h2>
        <p class="text-xs md:text-sm text-gray-500 dark:text-piket-muted">Rekap tugas siswa per tanggal beserta status penyelesaian.</p>
    </div>

    <!-- 2 OPSI FILTER: Semua Laporan ATAU Per Tanggal -->
    <div class="flex items-center gap-2 flex-wrap">
        <!-- Opsi 1: Tombol Tampilkan Semua Laporan -->
        <a href="{{ route('public.reports', ['tanggal' => 'semua']) }}" 
           class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition shadow-sm {{ $filterTanggal === 'semua' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-[#15231C] text-gray-700 dark:text-gray-300 hover:bg-emerald-600 hover:text-white border border-gray-200 dark:border-[#2C4135]' }}">
            📋 Semua Laporan
        </a>

        <!-- Opsi 2: Filter Berdasarkan Tanggal / Bulan / Tahun -->
        <!-- Opsi 2: Filter Berdasarkan Tanggal / Bulan / Tahun -->
        <form method="GET" action="{{ route('public.reports') }}" class="flex items-center gap-1.5">
            <input type="date" 
                   name="tanggal" 
                   id="input-filter-tanggal"
                   onclick="this.showPicker()"
                   value="{{ $filterTanggal !== 'semua' ? $filterTanggal : date('Y-m-d') }}" 
                   class="px-3 py-1.5 text-xs rounded-xl bg-white dark:bg-[#15231C] border border-gray-200 dark:border-[#2C4135] text-gray-800 dark:text-white shadow-sm focus:outline-none cursor-pointer [color-scheme:light] dark:[color-scheme:dark]">
            <button type="submit" 
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold shadow transition cursor-pointer {{ $filterTanggal !== 'semua' ? 'bg-emerald-600 text-white' : 'bg-gray-200 dark:bg-[#203429] text-gray-800 dark:text-gray-200 hover:bg-emerald-600 hover:text-white' }}">
                Tampilkan
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="mb-5 p-3.5 bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 rounded-xl text-xs md:text-sm font-semibold">
        {{ session('success') }}
    </div>
@endif

<!-- Form Catat Laporan Baru -->
<div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 md:p-6 shadow-card mb-8">
    <h3 class="font-bold text-sm md:text-base text-gray-800 dark:text-white mb-4 flex items-center gap-2">
        <span>✍️</span> <span>Catat Tugas Piket</span>
    </h3>

    <form method="POST" action="{{ route('public.reports.store') }}" 
          onsubmit="return confirm('Apakah data tugas piket ini sudah benar dan siap dikirim?')" 
          class="grid grid-cols-1 md:grid-cols-5 gap-4">
        @csrf
        <!-- Input Tanggal Piket -->
        <div>
            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Tanggal Piket</label>
            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required 
                   class="w-full px-3 py-2 text-sm rounded-xl bg-gray-50 dark:bg-[#15231C] border border-gray-200 dark:border-[#2C4135] text-gray-800 dark:text-white">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Nama Siswa</label>
            <select name="nama" required class="w-full px-3 py-2 text-sm rounded-xl bg-gray-50 dark:bg-[#15231C] border border-gray-200 dark:border-[#2C4135] text-gray-800 dark:text-white">
                <option value="">-- Pilih Nama --</option>
                @foreach($allMembers as $nama)
                    <option value="{{ $nama }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Hari</label>
            <select name="hari" required class="w-full px-3 py-2 text-sm rounded-xl bg-gray-50 dark:bg-[#15231C] border border-gray-200 dark:border-[#2C4135] text-gray-800 dark:text-white">
                @foreach($hariList as $h)
                    <option value="{{ $h }}">{{ $h }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Aktivitas</label>
            <input type="text" name="tugas" placeholder="Contoh: Menyapu & buang sampah" required
                   class="w-full px-3 py-2 text-sm rounded-xl bg-gray-50 dark:bg-[#15231C] border border-gray-200 dark:border-[#2C4135] text-gray-800 dark:text-white">
        </div>

        <div class="flex items-end">
            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm rounded-xl shadow transition active:scale-95 cursor-pointer">
                Kirim Laporan
            </button>
        </div>
    </form>
</div>

<!-- Tabel Laporan Piket -->
<div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] shadow-card overflow-hidden">
    <div class="p-4 border-b border-gray-100 dark:border-[#2C4135] flex justify-between items-center">
        <h4 class="font-bold text-xs md:text-sm text-gray-800 dark:text-white">
            Filter: 
            <span class="text-emerald-500 font-semibold">
                {{ $filterTanggal === 'semua' ? 'Semua Laporan' : date('d M Y', strtotime($filterTanggal)) }}
            </span>
        </h4>
        <span class="text-xs text-gray-400">Total: {{ $totalItems }} data</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs md:text-sm">
            <thead class="bg-gray-50 dark:bg-[#15231C] border-b border-gray-200 dark:border-[#2C4135] text-gray-500 dark:text-gray-300">
                <tr>
                    <th class="py-3 px-4 w-12 text-center">No</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Nama Siswa</th>
                    <th class="py-3 px-4">Hari</th>
                    <th class="py-3 px-4">Aktivitas</th>
                    <th class="py-3 px-4">Waktu Lapor</th>
                    <th class="py-3 px-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-[#26382E]">
                @forelse($reports as $index => $r)
                    @php
                        $nomorUrut = (($currentPage - 1) * $perPage) + ($index + 1);
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-[#1B2A22] transition">
                        <td class="py-3.5 px-4 text-center text-gray-400 font-medium">{{ $nomorUrut }}</td>
                        <td class="py-3.5 px-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ isset($r['tanggal']) ? date('d M Y', strtotime($r['tanggal'])) : '-' }}
                        </td>
                        <td class="py-3.5 px-4 font-semibold text-gray-800 dark:text-gray-100">{{ $r['nama'] }}</td>
                        <td class="py-3.5 px-4 text-emerald-500 font-medium">{{ $r['hari'] }}</td>
                        <td class="py-3.5 px-4 text-gray-600 dark:text-gray-300">{{ $r['tugas'] }}</td>
                        <td class="py-3.5 px-4 text-xs text-gray-400">{{ $r['waktu'] }}</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300">
                                ✓ {{ $r['status'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400 text-xs">Belum ada laporan piket untuk opsi ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    @if($totalPages > 1)
        <div class="p-4 border-t border-gray-100 dark:border-[#2C4135] flex items-center justify-between">
            <span class="text-xs text-gray-500 dark:text-piket-muted">
                Halaman {{ $currentPage }} dari {{ $totalPages }}
            </span>
            <div class="flex items-center gap-2">
                @if($currentPage > 1)
                    <a href="{{ route('public.reports', ['tanggal' => $filterTanggal, 'page' => $currentPage - 1]) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-200 dark:bg-[#1E2D25] text-gray-700 dark:text-gray-200 hover:bg-emerald-600 hover:text-white transition">
                        &larr; Prev
                    </a>
                @endif

                @if($currentPage < $totalPages)
                    <a href="{{ route('public.reports', ['tanggal' => $filterTanggal, 'page' => $currentPage + 1]) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-200 dark:bg-[#1E2D25] text-gray-700 dark:text-gray-200 hover:bg-emerald-600 hover:text-white transition">
                        Next &rarr;
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection