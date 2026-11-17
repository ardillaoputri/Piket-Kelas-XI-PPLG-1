<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\Announcement;
use App\Models\Fine;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PiketSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Petugas Login
        User::updateOrCreate(
            ['email' => 'petugas@piket.test'],
            [
                'name' => 'Petugas Kebersihan',
                'password' => Hash::make('password123'),
            ]
        );

        $dataPiket = [
            'Senin' => [
                'kelas' => ['Angeliska', 'Galuh', 'Septiani', 'Fadilah', 'Rubilio', "Ba'san"],
                'mbg'   => ['Khadaffi', 'Rizki', 'Karim']
            ],
            'Selasa' => [
                'kelas' => ['Amelia', 'Dahlia', 'Namira', 'Putra', 'Rasyid', 'Umu'],
                'mbg'   => ['Revan', 'Rizky', 'Devara']
            ],
            'Rabu' => [
                'kelas' => ['Dhara', 'Dzakia', 'Salwatun', 'Maudy', 'ABDAD', 'Aldentra'],
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

        foreach ($dataPiket as $hari => $tugas) {
            foreach ($tugas['kelas'] as $nama) {
                $member = Member::firstOrCreate(['name' => $nama]);
                Schedule::create([
                    'member_id' => $member->id,
                    'type' => 'kelas',
                    'day' => $hari
                ]);
            }
            foreach ($tugas['mbg'] as $nama) {
                $member = Member::firstOrCreate(['name' => $nama]);
                Schedule::create([
                    'member_id' => $member->id,
                    'type' => 'mbg',
                    'day' => $hari
                ]);
            }
        }

        // Pengumuman Awal
        Announcement::create([
            'title' => 'Piket Bersih Kelas',
            'content' => 'Laksanakan tugas piket sesuai jadwal dan jaga kebersihan kelas!',
            'date' => now(),
        ]);

        // Contoh Laporan Dokumentasi Kebersihan Awal
        Report::create([
            'date' => now()->toDateString(),
            'type' => 'kelas',
            'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&auto=format&fit=crop&q=80',
            'description' => 'Lantai disapu, pel bersih, papan tulis bersih, dan sampah sudah dibuang.',
            'status' => 'Disetujui',
            'note' => 'Bagus dan rapi'
        ]);

        // Contoh Denda Awal (Fix Rp 10.000)
        $memberDenda = Member::where('name', 'Angeliska')->first();
        if ($memberDenda) {
            Fine::create([
                'member_id' => $memberDenda->id,
                'violation' => 'Tidak piket',
                'amount' => 10000,
                'status' => 'Belum lunas',
                'date' => now()->toDateString(),
            ]);
        }
    }
}