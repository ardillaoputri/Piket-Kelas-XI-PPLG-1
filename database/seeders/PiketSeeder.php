<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\Announcement;

class PiketSeeder extends Seeder
{
    public function run(): void
    {
        // Anggota Piket Kelas (Senin)
        $piketKelas = ['Angeliska', 'Galuh', 'Septiani', 'Fadilah', 'Rubilio', "Ba'san"];
        foreach ($piketKelas as $nama) {
            $member = Member::create(['name' => $nama, 'gender' => 'L']);
            Schedule::create([
                'member_id' => $member->id,
                'type' => 'kelas',
                'day' => 'Senin',
            ]);
        }

        // Anggota Piket MBG (Senin)
        $piketMBG = ['Khadaffi', 'Rizki', 'Karim'];
        foreach ($piketMBG as $nama) {
            $member = Member::create(['name' => $nama, 'gender' => 'L']);
            Schedule::create([
                'member_id' => $member->id,
                'type' => 'mbg',
                'day' => 'Senin',
            ]);
        }

        // Pengumuman Awal
        Announcement::create([
            'title' => 'Piket Bersih Kelas',
            'content' => 'Jangan lupa buang sampah dan rapikan meja sebelum pulang!',
            'date' => now(),
        ]);
    }
}