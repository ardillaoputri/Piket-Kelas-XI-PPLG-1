<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public static function getDataPiket()
    {
        return [
            'Senin' => [
                'kelas' => ['Angeliska', 'Galuh', 'Septiani', 'Fadilah', 'Rubilio', "Ba'san"],
                'mbg'   => ['Khadaffi', 'Rizki', 'Karim']
            ],
            'Selasa' => [
                'kelas' => ['Amelia', 'Dahlia', 'Namira', 'Putra', 'Rasyid', 'Umu'],
                'mbg'   => ['Revan', 'Rizky', 'Devara']
            ],
            'Rabu' => [
                'kelas' => ['Dhara', 'Dzakia', 'Salwatun', 'Maudy', 'Abdad', 'Aldentra'],
                'mbg'   => ['Akbar', 'Attariq', 'Fardhan']
            ],
            'Kamis' => [
                'kelas' => ['Ardilla', 'Davina', 'Kinar', 'Tisya', 'Nuriky', 'Rafiqi'],
                'mbg'   => ['Abian', 'Fachri', 'Habib']
            ],
            'Jumat' => [
                'kelas' => ['Indah', 'Novia', 'Rahma', 'Rezqia', 'Syakila', 'Arsyavin', 'Calvin'],
                'mbg'   => ['Rahman', 'Haekal', 'Maliq']
            ]
        ];
    }

    public static function getAllMembersList()
    {
        $data = self::getDataPiket();
        $members = [];
        foreach ($data as $hari => $t) {
            foreach ($t['kelas'] as $m) $members[] = $m;
            foreach ($t['mbg'] as $m) $members[] = $m;
        }
        sort($members);
        return array_values(array_unique($members));
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');

        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $hariSekarang = $hariMap[date('l')] ?? 'Senin';
        $isLibur = in_array($hariSekarang, ['Sabtu', 'Minggu']);
        $hariJadwal = $isLibur ? 'Senin' : $hariSekarang;

        $allData = self::getDataPiket();
        $piketAktif = $allData[$hariJadwal];

        $defaultAnnouncements = [
            ['id' => 1, 'title' => 'Piket Bersih Kelas', 'content' => 'Laksanakan tugas piket sesuai jadwal dan rapikan ruang kelas sebelum pulang!', 'date' => '22 Okt 2026'],
            ['id' => 2, 'title' => 'Tugas MBG Harian', 'content' => 'Petugas MBG wajib standby untuk mengambil konsumsi tepat pukul 11:30 WIB.', 'date' => '22 Okt 2026']
        ];

        $announcements = session('announcements', $defaultAnnouncements);
        if (empty($announcements)) {
            $announcements = $defaultAnnouncements;
            session(['announcements' => $announcements]);
        }

        $firstAnnouncement = reset($announcements);

        $reports = session('laporan_piket', [
            ['id' => 1, 'nama' => 'Ardilla', 'tugas' => 'Menyapu ruang kelas dan buang sampah', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:45 WIB'],
            ['id' => 2, 'nama' => 'Galuh', 'tugas' => 'Mengepel lantai kelas', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:50 WIB']
        ]);

        return view('beranda', [
            'hariSekarang' => $hariSekarang,
            'isLibur' => $isLibur,
            'hariJadwal' => $hariJadwal,
            'piketKelas' => $piketAktif['kelas'],
            'piketMBG' => $piketAktif['mbg'],
            'pengumuman' => (object)($firstAnnouncement ?: ['title' => 'Belum Ada Pengumuman', 'content' => '-']),
            'totalLaporan' => count($reports)
        ]);
    }

    public function schedule()
    {
        $dataPiket = self::getDataPiket();
        return view('jadwal', compact('dataPiket'));
    }

    public function documentation()
    {
        $defaultDocs = [
            [
                'id' => 1,
                'date' => '21 Okt 2026',
                'type' => 'Piket Kelas',
                'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80',
                'description' => 'Lantai disapu bersih, dipel, dan sampah sudah dibuang ke tempat sampah.',
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

        $reports = session('dokumentasi_list', $defaultDocs);
        if (empty($reports)) {
            $reports = $defaultDocs;
            session(['dokumentasi_list' => $reports]);
        }

        return view('dokumentasi', compact('reports'));
    }

    public function fines()
    {
        $fines = session('fines', [
            ['id' => 1, 'tanggal' => '2026-10-25', 'name' => 'Angeliska', 'violation' => 'Tidak piket', 'amount' => 10000, 'status' => 'Belum lunas'],
            ['id' => 2, 'tanggal' => '2026-10-26', 'name' => 'Galuh', 'violation' => 'Terlambat piket', 'amount' => 10000, 'status' => 'Lunas']
        ]);
        
        $totalBelumLunas = array_sum(array_map(fn($f) => ($f['status'] ?? '') === 'Belum lunas' ? ($f['amount'] ?? 10000) : 0, $fines));
        $totalLunas = array_sum(array_map(fn($f) => ($f['status'] ?? '') === 'Lunas' ? ($f['amount'] ?? 10000) : 0, $fines));
        $totalSemua = array_sum(array_map(fn($f) => ($f['amount'] ?? 10000), $fines));
        
        return view('denda', compact('fines', 'totalBelumLunas', 'totalLunas', 'totalSemua'));
    }

    public function contact()
    {
        return view('kontak');
    }

    public function announcements()
    {
        $defaultAnnouncements = [
            ['id' => 1, 'title' => 'Piket Bersih Kelas', 'content' => 'Laksanakan tugas piket sesuai jadwal dan rapikan ruang kelas sebelum pulang!', 'date' => '22 Okt 2026'],
            ['id' => 2, 'title' => 'Tugas MBG Harian', 'content' => 'Petugas MBG wajib standby untuk mengambil konsumsi tepat pukul 11:30 WIB.', 'date' => '22 Okt 2026']
        ];
        $announcements = session('announcements', $defaultAnnouncements);
        return view('pengumuman', compact('announcements'));
    }

    public function reports(Request $request)
    {
        $allReports = session('laporan_piket', [
            ['id' => 1, 'nama' => 'Ardilla', 'tugas' => 'Menyapu ruang kelas dan buang sampah', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:45 WIB'],
            ['id' => 2, 'nama' => 'Galuh', 'tugas' => 'Mengepel lantai kelas', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:50 WIB'],
        ]);

        $filterTanggal = $request->query('tanggal', 'semua');

        if ($filterTanggal === 'semua' || empty($filterTanggal)) {
            $filtered = $allReports;
        } else {
            $filtered = array_values(array_filter($allReports, function ($r) use ($filterTanggal) {
                return ($r['tanggal'] ?? '') === $filterTanggal;
            }));
        }

        $perPage = 5;
        $currentPage = (int) $request->query('page', 1);
        $totalItems = count($filtered);
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        $currentPage = min(max(1, $currentPage), $totalPages);
        $offset = ($currentPage - 1) * $perPage;

        $reportsPaginated = array_slice($filtered, $offset, $perPage);
        $allMembers = self::getAllMembersList();
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('laporan', [
            'reports' => $reportsPaginated,
            'allMembers' => $allMembers,
            'hariList' => $hariList,
            'filterTanggal' => $filterTanggal,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'perPage' => $perPage,
        ]);
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required',
            'tugas' => 'required',
            'hari' => 'required',
        ]);

        $reports = session('laporan_piket', [
            ['id' => 1, 'nama' => 'Ardilla', 'tugas' => 'Menyapu ruang kelas dan buang sampah', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:45 WIB'],
            ['id' => 2, 'nama' => 'Galuh', 'tugas' => 'Mengepel lantai kelas', 'hari' => 'Kamis', 'tanggal' => '2026-10-22', 'status' => 'Selesai', 'waktu' => '15:50 WIB'],
        ]);

        date_default_timezone_set('Asia/Jakarta');

        $reports[] = [
            'id' => time(),
            'nama' => $request->nama,
            'tugas' => $request->tugas,
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'status' => 'Selesai',
            'waktu' => date('H:i') . ' WIB'
        ];

        session(['laporan_piket' => $reports]);
        return redirect()->route('public.reports', ['tanggal' => $request->tanggal])
                         ->with('success', 'Laporan piket berhasil dicatat!');
    }
}