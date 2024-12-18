<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerawatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perawatan')->insert([
            [
                'kendaraan_id' => 1,
                'tanggal_perawatan' => '2024-11-28',
                'bbm' => '35.00',
                'jadwal_service' => '2024-11-29',
                'riwayat_pakai' => '',
                'keterangan' => '',
                'created_at' => '2024-11-28 11:12:07',
                'updated_at' => '2024-11-28 11:12:07',
            ],
            [
                'kendaraan_id' => 2,
                'tanggal_perawatan' => '2024-11-29',
                'bbm' => '35.00',
                'jadwal_service' => '2024-11-30',
                'riwayat_pakai' => '',
                'keterangan' => '',
                'created_at' => '2024-11-28 11:15:13',
                'updated_at' => '2024-11-28 11:15:13',
            ],
        ]);
    }
}
