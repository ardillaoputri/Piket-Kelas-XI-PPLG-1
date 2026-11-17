<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PublicController;

class PetugasController extends Controller
{
    public static function getDefaultDokumentasi()
    {
        return [
            [
                'id' => 1,
                'date' => '21 Okt 2026',
                'type' => 'Piket Kelas',
                'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80',
                'description' => 'Lantai disapu bersih, dipel, dan sampah sudah dibuang ke TPS.',
                'status' => 'Disetujui',
                'note' => 'Bagus dan rapi'
            ],
            [
                'id' => 2,
                'date' => '21 Okt 2026',
                'type' => 'Piket MBG',
                'image_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80',
                'description' => 'Konsumsi makan bergizi telah dibagikan dan wadah makanan dikembalikan rapi.',
                'status' => 'Selesai',
                'note' => 'Tertib'
            ]
        ];
    }

    public function exportDenda(Request $request)
    {
        $fines = session('fines', [
            ['id' => 1, 'tanggal' => '2026-10-25', 'name' => 'Angeliska', 'violation' => 'Tidak piket', 'amount' => 10000, 'status' => 'Belum lunas'],
            ['id' => 2, 'tanggal' => '2026-10-26', 'name' => 'Galuh', 'violation' => 'Terlambat piket', 'amount' => 10000, 'status' => 'Lunas']
        ]);

        $filterTanggal = $request->query('tanggal', 'semua');

        if ($filterTanggal !== 'semua' && !empty($filterTanggal)) {
            $fines = array_values(array_filter($fines, function ($item) use ($filterTanggal) {
                return ($item['tanggal'] ?? '') === $filterTanggal;
            }));
            $labelTanggal = date('d_M_Y', strtotime($filterTanggal));
            $judulPeriode = 'TANGGAL ' . strtoupper(date('d F Y', strtotime($filterTanggal)));
        } else {
            $labelTanggal = 'SEMUA';
            $judulPeriode = 'SEMUA PERIODE';
        }

        $fileName = 'Rekap_Denda_Piket_XI_PPLG_1_' . $labelTanggal . '.xls';

        $totalBelumLunas = array_sum(array_map(fn($f) => ($f['status'] ?? '') === 'Belum lunas' ? ($f['amount'] ?? 10000) : 0, $fines));
        $totalLunas = array_sum(array_map(fn($f) => ($f['status'] ?? '') === 'Lunas' ? ($f['amount'] ?? 10000) : 0, $fines));
        $totalSemua = array_sum(array_map(fn($f) => ($f['amount'] ?? 10000), $fines));

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($fines, $totalBelumLunas, $totalLunas, $totalSemua, $judulPeriode) {
            echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            echo '<head><meta charset="utf-8">';
            echo '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
            echo '<x:Name>Rekap Denda</x:Name>';
            echo '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>';
            echo '</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
            echo '</head><body>';

            echo '<table cellpadding="6" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11pt;">';

            // Judul Laporan
            echo '<tr><td colspan="6" align="center" style="font-size: 14pt; font-weight: bold; background-color: #1E2D24; color: #FFFFFF; border: 1px solid #141E18; padding: 10px;">REKAPITULASI DENDA PIKET KELAS XI PPLG 1 (' . $judulPeriode . ')</td></tr>';
            echo '<tr><td colspan="6" align="center" style="font-size: 10pt; background-color: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; padding: 6px;">Tanggal Unduh: ' . date('d F Y, H:i') . ' WIB</td></tr>';

            echo '<tr><td colspan="6" style="height: 10px;"></td></tr>';

            // Header Tabel
            echo '<tr style="text-align: center;">
                    <th style="border: 1px solid #1E2D24; background-color: #2D4A3E; color: #FFFFFF; width: 45px; padding: 8px;">No</th>
                    <th style="border: 1px solid #1E2D24; background-color: #2D4A3E; color: #FFFFFF; width: 110px; padding: 8px;">Tanggal</th>
                    <th style="border: 1px solid #1E2D24; background-color: #2D4A3E; color: #FFFFFF; width: 200px; padding: 8px;">Nama Siswa</th>
                    <th style="border: 1px solid #1E2D24; background-color: #2D4A3E; color: #FFFFFF; width: 190px; padding: 8px;">Keterangan Pelanggaran</th>
                    <th style="border: 1px solid #1E2D24; background-color: #2D4A3E; color: #FFFFFF; width: 140px; padding: 8px;">Nominal Denda</th>
                    <th style="border: 1px solid #1E2D24; background-color: #2D4A3E; color: #FFFFFF; width: 110px; padding: 8px;">Status</th>
                  </tr>';

            // Baris Data
            foreach ($fines as $index => $row) {
                $status = $row['status'] ?? 'Belum lunas';
                $tglFormatted = !empty($row['tanggal']) ? date('d/m/Y', strtotime($row['tanggal'])) : '-';
                $bgStatus = ($status === 'Lunas') ? 'background-color: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0;' : 'background-color: #FEF2F2; color: #991B1B; border: 1px solid #FECACA;';
                $nominal = $row['amount'] ?? 10000;

                echo '<tr>';
                echo '<td align="center" style="border: 1px solid #D1D5DB; padding: 6px;">' . ($index + 1) . '</td>';
                echo '<td align="center" style="border: 1px solid #D1D5DB; padding: 6px;">' . $tglFormatted . '</td>';
                echo '<td style="border: 1px solid #D1D5DB; padding: 6px;">' . htmlspecialchars($row['name'] ?? '-') . '</td>';
                echo '<td style="border: 1px solid #D1D5DB; padding: 6px;">' . htmlspecialchars($row['violation'] ?? '-') . '</td>';
                echo '<td align="right" style="border: 1px solid #D1D5DB; padding: 6px;">Rp ' . number_format($nominal, 0, ',', '.') . '</td>';
                echo '<td align="center" style="font-weight: bold; ' . $bgStatus . ' padding: 6px;">' . $status . '</td>';
                echo '</tr>';
            }

            echo '<tr><td colspan="6" style="height: 10px;"></td></tr>';

            // Ringkasan
            echo '<tr>
                    <td colspan="4" align="right" style="border: 1px solid #D1D5DB; font-weight: bold; background-color: #F9FAFB; padding: 7px;">Total Denda Lunas (Terkumpul):</td>
                    <td align="right" style="border: 1px solid #D1D5DB; font-weight: bold; color: #047857; background-color: #ECFDF5; padding: 7px;">Rp ' . number_format($totalLunas, 0, ',', '.') . '</td>
                    <td align="center" style="border: 1px solid #D1D5DB; font-weight: bold; color: #047857; background-color: #ECFDF5;">Terkumpul</td>
                  </tr>';

            echo '<tr>
                    <td colspan="4" align="right" style="border: 1px solid #D1D5DB; font-weight: bold; background-color: #F9FAFB; padding: 7px;">Total Denda Belum Lunas:</td>
                    <td align="right" style="border: 1px solid #D1D5DB; font-weight: bold; color: #B91C1C; background-color: #FEF2F2; padding: 7px;">Rp ' . number_format($totalBelumLunas, 0, ',', '.') . '</td>
                    <td align="center" style="border: 1px solid #D1D5DB; font-weight: bold; color: #B91C1C; background-color: #FEF2F2;">Tertunggak</td>
                  </tr>';

            echo '<tr>
                    <td colspan="4" align="right" style="border: 2px solid #1E2D24; font-weight: bold; font-size: 11pt; background-color: #E2E8F0; padding: 8px;">TOTAL KESELURUHAN DENDA:</td>
                    <td align="right" style="border: 2px solid #1E2D24; font-weight: bold; font-size: 11pt; background-color: #E2E8F0; padding: 8px;">Rp ' . number_format($totalSemua, 0, ',', '.') . '</td>
                    <td align="center" style="border: 2px solid #1E2D24; font-weight: bold; background-color: #E2E8F0;">Grand Total</td>
                  </tr>';

            echo '</table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    public function denda(Request $request)
    {
        $allFines = session('fines');
        if (empty($allFines)) {
            $allFines = [
                ['id' => 1, 'tanggal' => '2026-10-25', 'name' => 'Angeliska', 'violation' => 'Tidak piket', 'amount' => 10000, 'status' => 'Belum lunas'],
                ['id' => 2, 'tanggal' => '2026-10-26', 'name' => 'Galuh', 'violation' => 'Terlambat piket', 'amount' => 10000, 'status' => 'Lunas']
            ];
            session(['fines' => $allFines]);
        }

        $filterTanggal = $request->query('tanggal', 'semua');

        if ($filterTanggal !== 'semua' && !empty($filterTanggal)) {
            $fines = array_values(array_filter($allFines, function ($item) use ($filterTanggal) {
                return ($item['tanggal'] ?? '') === $filterTanggal;
            }));
        } else {
            $fines = $allFines;
        }

        $members = PublicController::getAllMembersList();
        return view('petugas.denda', compact('fines', 'members', 'filterTanggal'));
    }

    public function storeDenda(Request $request)
    {
        $fines = session('fines', []);

        $fines[] = [
            'id' => time(),
            'tanggal' => $request->tanggal ?? date('Y-m-d'),
            'name' => $request->name,
            'violation' => $request->violation ?? 'Tidak piket',
            'amount' => 10000,
            'status' => 'Belum lunas'
        ];

        session(['fines' => $fines]);
        return back()->with('success', 'Catatan denda Rp 10.000 berhasil ditambahkan.');
    }

    public function toggleDenda($id)
    {
        $fines = session('fines', []);
        foreach ($fines as &$f) {
            if ($f['id'] == $id) {
                $f['status'] = ($f['status'] === 'Lunas') ? 'Belum lunas' : 'Lunas';
            }
        }
        session(['fines' => $fines]);
        return back()->with('success', 'Status denda berhasil diperbarui.');
    }

    public function deleteDenda($id)
    {
        $fines = session('fines', []);
        $fines = array_filter($fines, fn($f) => $f['id'] != $id);
        session(['fines' => array_values($fines)]);
        return back()->with('success', 'Data denda berhasil dihapus.');
    }

    public function laporan()
    {
        $reports = session('laporan_piket', [
            ['id' => 1, 'nama' => 'Ardilla', 'tugas' => 'Menyapu ruang kelas dan buang sampah', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:45 WIB'],
            ['id' => 2, 'nama' => 'Galuh', 'tugas' => 'Mengepel lantai kelas', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:50 WIB']
        ]);
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        return view('petugas.laporan', compact('reports', 'hariList'));
    }

    public function deleteLaporan($id)
    {
        $reports = session('laporan_piket', []);
        $reports = array_filter($reports, fn($r) => $r['id'] != $id);
        session(['laporan_piket' => array_values($reports)]);
        return back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function pengumuman()
    {
        if (!session()->has('announcements') || empty(session('announcements'))) {
            session(['announcements' => [
                ['id' => 1, 'title' => 'Piket Bersih Kelas', 'content' => 'Laksanakan tugas piket sesuai jadwal dan rapikan ruang kelas sebelum pulang!', 'date' => '22 Okt 2026'],
                ['id' => 2, 'title' => 'Tugas MBG Harian', 'content' => 'Petugas MBG wajib standby untuk mengambil konsumsi tepat pukul 11:30 WIB.', 'date' => '22 Okt 2026']
            ]]);
        }

        $announcements = session('announcements');
        return view('petugas.pengumuman', compact('announcements'));
    }

    public function storePengumuman(Request $request)
    {
        $request->validate(['title' => 'required', 'content' => 'required']);

        $defaultAnnouncements = [
            ['id' => 1, 'title' => 'Piket Bersih Kelas', 'content' => 'Laksanakan tugas piket sesuai jadwal dan rapikan ruang kelas sebelum pulang!', 'date' => '22 Okt 2026'],
            ['id' => 2, 'title' => 'Tugas MBG Harian', 'content' => 'Petugas MBG wajib standby untuk mengambil konsumsi tepat pukul 11:30 WIB.', 'date' => '22 Okt 2026']
        ];
        
        $announcements = session('announcements', $defaultAnnouncements);

        array_unshift($announcements, [
            'id' => time(),
            'title' => $request->title,
            'content' => $request->content,
            'date' => date('d M Y')
        ]);

        session(['announcements' => $announcements]);
        return back()->with('success', 'Pengumuman berhasil dipublikasikan!');
    }

    public function deletePengumuman($id)
    {
        $announcements = session('announcements', []);
        $announcements = array_filter($announcements, fn($a) => ($a['id'] ?? 0) != $id);
        session(['announcements' => array_values($announcements)]);
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function dokumentasi()
    {
        if (!session()->has('dokumentasi_list') || empty(session('dokumentasi_list'))) {
            session(['dokumentasi_list' => self::getDefaultDokumentasi()]);
        }

        $reports = session('dokumentasi_list');
        return view('petugas.dokumentasi', compact('reports'));
    }

    public function storeDokumentasi(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'description' => 'required',
        ]);

        $imagePath = 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80';
        
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/dokumentasi'), $filename);
            $imagePath = asset('uploads/dokumentasi/' . $filename);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $defaultDocs = [
            [
                'id' => 1,
                'date' => '21 Okt 2026',
                'type' => 'Piket Kelas',
                'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80',
                'description' => 'Lantai disapu bersih, dipel, dan sampah sudah dibuang ke TPS.',
                'status' => 'Disetujui',
                'note' => 'Bagus dan rapi'
            ],
            [
                'id' => 2,
                'date' => '21 Okt 2026',
                'type' => 'Piket MBG',
                'image_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80',
                'description' => 'Konsumsi makan bergizi telah dibagikan dan wadah makanan dikembalikan rapi.',
                'status' => 'Selesai',
                'note' => 'Tertib'
            ]
        ];

        $list = session('dokumentasi_list', $defaultDocs);

        array_unshift($list, [
            'id' => time(),
            'date' => date('d M Y'),
            'type' => $request->type,
            'image_path' => $imagePath,
            'description' => $request->description,
            'status' => 'Disetujui',
            'note' => $request->note ?? 'Sudah diperiksa'
        ]);

        session(['dokumentasi_list' => $list]);
        return back()->with('success', 'Dokumentasi foto berhasil ditambahkan!');
    }

    public function deleteDokumentasi($id)
    {
        $list = session('dokumentasi_list', []);
        $list = array_filter($list, fn($d) => ($d['id'] ?? 0) != $id);
        session(['dokumentasi_list' => array_values($list)]);
        return back()->with('success', 'Dokumentasi berhasil dihapus.');
    }
}