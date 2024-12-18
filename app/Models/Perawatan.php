<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai dengan nama model (Perawatan)
    protected $table = 'perawatan';

    // Kolom-kolom yang dapat diisi massal
    protected $fillable = [
        'kendaraan_id',
        'tanggal_perawatan',
        'bbm',
        'jadwal_service',
        'riwayat_pakai',
        'keterangan',
    ];

    // Relasi dengan model Kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id', 'id');
    }
}
