<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTime = now(); // Get the current timestamp

        DB::table('kendaraan')->insert([
            [
                'jenis_kendaraan_id' => 1,  // Assuming 'angkutan orang' has ID 1
                'nama_kendaraan' => 'Toyota Avanza',
                'nomor_polisi' => 'AB 1234 CD',
                'status' => 'milik perusahaan',
                'ketersediaan' => 'tersedia',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'jenis_kendaraan_id' => 2,  // Assuming 'angkutan barang' has ID 2
                'nama_kendaraan' => 'Isuzu ELF',
                'nomor_polisi' => 'AB 5678 EF',
                'status' => 'sewa',
                'ketersediaan' => 'sedang dipakai',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ]);
    }
}
