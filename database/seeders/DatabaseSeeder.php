<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(JenisKendaraanSeeder::class);
        $this->call(KendaraanSeeder::class);
        $this->call(PemesananKendaraanSeeder::class);
        $this->call(PerawatanSeeder::class);

    }
}
