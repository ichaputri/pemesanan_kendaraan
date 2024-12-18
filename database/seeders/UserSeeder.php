<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder untuk tabel users
        DB::table('users')->insert([
            [
                'username' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Direktur',
                'email' => 'direktur@gmail.com',
                'password' => Hash::make('direktur123'),
                'role' => 'direktur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Manajer',
                'email' => 'manajer@gmail.com',
                'password' => Hash::make('manajer123'),
                'role' => 'manajer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Pengelola',
                'email' => 'pengelola@gmail.com',
                'password' => Hash::make('pengelola123'),
                'role' => 'pengelola',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Driver',
                'email' => 'driver@gmail.com',
                'password' => Hash::make('driver123'),
                'role' => 'driver',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
