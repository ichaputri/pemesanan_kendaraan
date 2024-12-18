<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JenisKendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_kendaraan')->insert([
            [
                'nama_jenis' => 'angkutan orang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jenis' => 'angkutan barang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
