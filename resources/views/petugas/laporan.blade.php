@extends('layouts.petugas')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white">Laporan Murid (Dikelompokkan per Hari)</h2>
    <p class="text-xs text-piket-muted mt-1">Daftar rekapan pekerjaan kebersihan yang dilaporkan oleh siswa.</p>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-emerald-950 border border-emerald-800 text-emerald-300 rounded-xl text-xs">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-6">
    @foreach($hariList as $hari)
        @php
            $laporanHari = array_values(array_filter($reports, function($r) use ($hari) {
                return ($r['hari'] ?? '') === $hari;
            }));
        @endphp
        <div class="bg-piket-forest rounded-2xl border border-piket-border shadow-xl overflow-hidden">
            <div class="p-4 bg-[#14221B] border-b border-piket-border flex items-center justify-between">
                <h4 class="font-bold text-sm text-emerald-400">📅 Laporan Hari {{ $hari }}</h4>
                <span class="text-xs text-piket-muted">{{ count($laporanHari) }} Laporan Masuk</span>
            </div>
            <table class="w-full text-left text-sm">
                <thead class="bg-[#15231B] border-b border-piket-border text-gray-300 text-xs">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Tugas Selesai</th>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#26382E]">
                    @forelse($laporanHari as $idx => $r)
                        @php
                            $namaSiswa = $r['nama'] ?? '-';
                        @endphp
                        <tr class="hover:bg-[#1A2820] transition">
                            <td class="py-3 px-4 text-center text-gray-400 font-medium">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4 font-semibold text-white">{{ $namaSiswa }}</td>
                            <td class="py-3 px-4 text-gray-300">{{ $r['tugas'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-xs text-gray-400">{{ $r['waktu'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <form method="POST" action="{{ route('petugas.laporan.delete', $r['id']) }}"
                                      onsubmit="return confirm('Hapus laporan tugas milik {{ $namaSiswa }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 text-xs bg-red-600 hover:bg-red-500 text-white rounded-lg cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-piket-muted text-xs">Belum ada laporan untuk hari {{ $hari }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach
</div>
@endsection