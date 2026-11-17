@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Denda Piket & Kas Kelas</h2>
        <p class="text-xs md:text-sm text-gray-500 dark:text-piket-muted">Nominal denda tetap Rp 10.000 per pelanggaran tidak piket.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/40 p-4 rounded-2xl shadow-sm">
        <span class="text-xs text-amber-800 dark:text-amber-300 block font-medium">Total Belum Lunas</span>
        <span class="text-xl md:text-2xl font-bold text-amber-900 dark:text-amber-200">
            Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}
        </span>
    </div>

    <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/40 p-4 rounded-2xl shadow-sm">
        <span class="text-xs text-emerald-800 dark:text-emerald-300 block font-medium">Total Terkumpul (Lunas)</span>
        <span class="text-xl md:text-2xl font-bold text-emerald-900 dark:text-emerald-200">
            Rp {{ number_format($totalLunas, 0, ',', '.') }}
        </span>
    </div>

    <div class="bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/40 p-4 rounded-2xl shadow-sm">
        <span class="text-xs text-blue-800 dark:text-blue-300 block font-medium">Total Keseluruhan Denda</span>
        <span class="text-xl md:text-2xl font-bold text-blue-900 dark:text-blue-200">
            Rp {{ number_format($totalSemua, 0, ',', '.') }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] shadow-card overflow-hidden flex flex-col justify-between">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs md:text-sm">
                <thead class="bg-[#F4F7F2] dark:bg-[#15231C] border-b border-gray-200 dark:border-[#2C4135] text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="py-3.5 px-3 w-10 text-center">No</th>
                        <th class="py-3.5 px-3">Tanggal</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Pelanggaran</th>
                        <th class="py-3.5 px-4">Nominal</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#24372B]">
                    @forelse($fines as $index => $fine)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#1D2E24] transition">
                            <td class="py-3 px-3 text-center text-gray-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ isset($fine['tanggal']) ? date('d M Y', strtotime($fine['tanggal'])) : '-' }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-gray-800 dark:text-gray-100">{{ $fine['name'] }}</td>
                            <td class="py-3 px-4 text-gray-600 dark:text-gray-300">{{ $fine['violation'] }}</td>
                            <td class="py-3 px-4 font-semibold text-gray-800 dark:text-gray-100">Rp {{ number_format($fine['amount'], 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ ($fine['status'] ?? '') === 'Lunas' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300' }}">
                                    {{ $fine['status'] ?? 'Belum lunas' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 text-xs">Tidak ada catatan denda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-piket-cardLight dark:bg-piket-forest rounded-2xl border border-piket-borderLight dark:border-[#2C4135] p-5 shadow-card flex flex-col items-center text-center">
        <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Bayar via QRIS Kas</h3>
        <p class="text-xs text-gray-500 dark:text-piket-muted mb-4">Scan kode QR di bawah ini untuk pembayaran denda atau uang kas.</p>
        
        <div class="bg-white p-3 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-md w-full max-w-[240px]">
            <img src="{{ asset('images/qris-kas.jpeg') }}" 
                 alt="QRIS KAS XI PPLG 1" 
                 class="w-full h-auto rounded-xl object-contain mx-auto"
                 onerror="this.onerror=null; this.src='https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=KAS%20XI%20PPLG%201%20ID1026553609136';">
        </div>

        <div class="mt-4 w-full text-xs text-left bg-gray-50 dark:bg-[#14201A] p-3 rounded-xl border border-gray-200/60 dark:border-[#26382E]">
            <div class="flex justify-between py-1 border-b border-gray-200/40 dark:border-[#26382E]">
                <span class="text-gray-500 dark:text-gray-400">Merchant:</span>
                <span class="font-semibold text-gray-800 dark:text-gray-200">KAS XI PPLG 1</span>
            </div>
            <div class="flex justify-between py-1 border-b border-gray-200/40 dark:border-[#26382E]">
                <span class="text-gray-500 dark:text-gray-400">NMID:</span>
                <span class="font-mono text-gray-800 dark:text-gray-200">ID1026553609136</span>
            </div>
            <p class="text-[11px] text-gray-400 mt-2 text-center">
                Setelah transfer, kirim bukti bayar ke bendahara kelas untuk verifikasi.
            </p>
        </div>
    </div>
</div>
@endsection