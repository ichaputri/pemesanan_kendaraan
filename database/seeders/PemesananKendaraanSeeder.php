<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemesananKendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pemesanan')->insert([
            [
                'kendaraan_id' => 1,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-02',
                'tanggal_kembali' => '2024-12-04',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-11-25 8:12:41',
                'updated_at' => '2024-11-27 10:31:45',
            ],
            [
                'kendaraan_id' => 2,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-02',
                'tanggal_kembali' => '2024-12-02',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-11-26 10:18:21',
                'updated_at' => '2024-11-27 10:32:15',
            ],
            [
                'kendaraan_id' => 2,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-03',
                'tanggal_kembali' => '2024-12-03',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-11-27 07:11:11',
                'updated_at' => '2024-11-28 09:12:15',
            ],
            [
                'kendaraan_id' => 2,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-04',
                'tanggal_kembali' => '2024-12-06',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-11-28 09:10:11',
                'updated_at' => '2024-11-29 09:10:15',
            ],
            [
                'kendaraan_id' => 1,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-09',
                'tanggal_kembali' => '2024-12-09',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-12-02 11:40:24',
                'updated_at' => '2024-12-04 07:20:47',
            ],
            [
                'kendaraan_id' => 1,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-11',
                'tanggal_kembali' => '2024-12-11',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-12-04 14:10:54',
                'updated_at' => '2024-12-05 07:50:47',
            ],
            [
                'kendaraan_id' => 1,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-13',
                'tanggal_kembali' => '2024-12-13',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-12-05 12:11:51',
                'updated_at' => '2024-12-05 13:10:47',
            ],
            [
                'kendaraan_id' => 2,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-10',
                'tanggal_kembali' => '2024-12-12',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-12-04 09:13:04',
                'updated_at' => '2024-12-04 10:01:12',
            ],
            [
                'kendaraan_id' => 2,
                'pengelola' => '4',
                'penyetuju1' => '3',
                'penyetuju2' => '2',
                'tanggal_pinjam' => '2024-12-13',
                'tanggal_kembali' => '2024-12-17',
                'status_persetujuan1' => 'disetujui',
                'status_persetujuan2' => 'disetujui',
                'created_at' => '2024-12-06 07:31:24',
                'updated_at' => '2024-12-09 10:01:56',
            ],
        ]);
    }
}
