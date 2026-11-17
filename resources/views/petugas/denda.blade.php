@extends('layouts.petugas')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Kelola Denda Piket</h2>
        <p class="text-xs text-piket-muted mt-1">Daftar siswa terlambat/tidak piket (Tarif tetap Rp 10.000)</p>
    </div>

    <!-- Filter Tanggal & Tombol Ekspor Excel -->
    <div class="flex items-end gap-2 flex-wrap">
        <!-- Input Pemilihan Tanggal & Bulan -->
        <form method="GET" action="{{ route('petugas.denda') }}" id="form-filter-denda" class="flex flex-col">
            <label class="text-[11px] font-semibold text-gray-300 mb-1">Tanggal</label>
            <div class="flex items-center gap-1.5">
                <input type="date" 
                       name="tanggal" 
                       id="filter-tanggal-input"
                       onclick="this.showPicker()"
                       onchange="document.getElementById('form-filter-denda').submit()"
                       value="{{ $filterTanggal !== 'semua' ? $filterTanggal : date('Y-m-d') }}" 
                       class="px-3 py-2 text-xs rounded-xl bg-[#14201A] border border-piket-border text-white shadow-sm focus:outline-none cursor-pointer [color-scheme:dark]">
                
                @if(($filterTanggal ?? 'semua') !== 'semua')
                    <a href="{{ route('petugas.denda', ['tanggal' => 'semua']) }}" 
                       title="Lihat Semua Tanggal"
                       class="px-2.5 py-2 text-xs rounded-xl bg-gray-700/60 hover:bg-gray-700 text-gray-300 transition">
                        ✕ Semua
                    </a>
                @endif
            </div>
        </form>

        <!-- Tombol Ekspor Excel Sesuai Tanggal yang Sedang Dipilih -->
        <div class="flex flex-col">
            <span class="text-[11px] opacity-0 mb-1 select-none">Aksi</span>
            <a href="javascript:void(0)" 
               onclick="unduhExcelSesuaiTanggal()"
               class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-semibold shadow transition active:scale-95 cursor-pointer">
                <span>📊</span>
                <span>Ekspor ke Excel (.xls)</span>
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="mb-5 p-3.5 bg-emerald-950/80 border border-emerald-800 text-emerald-300 rounded-xl text-xs font-semibold">
        {{ session('success') }}
    </div>
@endif

<!-- Form Tambah Catatan Denda -->
<div class="bg-piket-forest rounded-2xl border border-piket-border p-6 shadow-xl mb-8">
    <h3 class="font-bold text-sm text-white mb-4 flex items-center gap-2">
        <span>➕</span> <span>Tambah Catatan Denda (Rp 10.000)</span>
    </h3>
    <form method="POST" action="{{ route('petugas.denda.store') }}" 
          onsubmit="return confirm('Apakah Anda yakin ingin menambahkan denda Rp 10.000 untuk siswa ini?')"
          class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-300 mb-1.5">Tanggal</label>
            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" onclick="this.showPicker()" required 
                   class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white cursor-pointer [color-scheme:dark]">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-300 mb-1.5">Pilih Siswa</label>
            <select name="name" required class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white">
                <option value="">-- Pilih Nama Siswa --</option>
                @foreach($members as $nama)
                    <option value="{{ $nama }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-300 mb-1.5">Pelanggaran</label>
            <input type="text" name="violation" value="Tidak piket" required class="w-full px-3 py-2 text-sm rounded-xl bg-[#14201A] border border-piket-border text-white">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm rounded-xl shadow transition cursor-pointer">
                Simpan Denda
            </button>
        </div>
    </form>
</div>

<!-- Tabel Data Denda -->
<div class="bg-piket-forest rounded-2xl border border-piket-border shadow-xl overflow-hidden">
    <div class="px-5 py-3 border-b border-piket-border flex justify-between items-center text-xs text-gray-400">
        <span>Periode: 
            <strong class="text-emerald-400">
                {{ ($filterTanggal ?? 'semua') === 'semua' ? 'Semua Periode' : date('d F Y', strtotime($filterTanggal)) }}
            </strong>
        </span>
        <span>Total: {{ count($fines) }} data denda</span>
    </div>

    <table class="w-full text-left text-sm">
        <thead class="bg-[#15231B] border-b border-piket-border text-gray-300 text-xs">
            <tr>
                <th class="py-3 px-3 w-10 text-center">No</th>
                <th class="py-3 px-3">Tanggal</th>
                <th class="py-3 px-4">Nama Siswa</th>
                <th class="py-3 px-4">Pelanggaran</th>
                <th class="py-3 px-4">Nominal</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#26382E]">
            @forelse($fines as $index => $fine)
                @php
                    $namaSiswa = $fine['name'] ?? '-';
                    $statusDenda = $fine['status'] ?? 'Belum lunas';
                @endphp
                <tr class="hover:bg-[#1A2820] transition">
                    <td class="py-3 px-3 text-center text-gray-400 font-medium">{{ $index + 1 }}</td>
                    <td class="py-3 px-3 text-gray-400 text-xs whitespace-nowrap">
                        {{ !empty($fine['tanggal']) ? date('d/m/Y', strtotime($fine['tanggal'])) : '-' }}
                    </td>
                    <td class="py-3 px-4 font-semibold text-white">{{ $namaSiswa }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $fine['violation'] ?? '-' }}</td>
                    <td class="py-3 px-4 font-semibold text-white">Rp {{ number_format($fine['amount'] ?? 10000, 0, ',', '.') }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusDenda === 'Lunas' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : 'bg-red-950 text-red-300 border border-red-800' }}">
                            {{ $statusDenda }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <form method="POST" action="{{ route('petugas.denda.toggle', $fine['id']) }}"
                                  onsubmit="return confirm('Ubah status denda {{ $namaSiswa }}?')">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusDenda === 'Lunas' ? 'bg-amber-600 hover:bg-amber-500' : 'bg-emerald-600 hover:bg-emerald-500' }} text-white cursor-pointer">
                                    {{ $statusDenda === 'Lunas' ? 'Batal Lunas' : 'Tandai Lunas' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('petugas.denda.delete', $fine['id']) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus denda {{ $namaSiswa }} secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-600 hover:bg-red-500 text-white cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="py-6 text-center text-piket-muted">Belum ada catatan denda untuk tanggal ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function unduhExcelSesuaiTanggal() {
        const inputTgl = document.getElementById('filter-tanggal-input');
        const tglVal = inputTgl ? inputTgl.value : '{{ $filterTanggal }}';
        const urlExport = "{{ route('petugas.denda.export') }}?tanggal=" + encodeURIComponent(tglVal);
        window.location.href = urlExport;
    }
</script>
@endsection