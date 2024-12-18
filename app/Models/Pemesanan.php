<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pemesanan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kendaraan_id',
        'pengelola',
        'penyetuju1',
        'penyetuju2',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status_persetujuan1',
        'status_persetujuan2',
    ];

    /**
     * Get the kendaraan associated with the pemesanan.
     */
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pengelolaUser()
    {
        return $this->belongsTo(User::class, 'pengelola', 'id');
    }

    public function penyetuju1User()
    {
        return $this->belongsTo(User::class, 'penyetuju1', 'id');
    }

    public function penyetuju2User()
    {
        return $this->belongsTo(User::class, 'penyetuju2', 'id');
    }

    
}
