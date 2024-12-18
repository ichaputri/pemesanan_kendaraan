<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Kendaraan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kendaraan';

    protected $fillable = [
        'jenis_kendaraan_id',
        'nama_kendaraan',
        'nomor_polisi',
        'status',
        'ketersediaan',
    ];

    /**
     * Get the associated jenis kendaraan.
     */
    public function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class);
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'kendaraan_id', 'id');
    }

    public function isAvailable($tanggal_pinjam, $tanggal_kembali)
    {
        return !$this->pemesanan()
            ->where(function ($query) use ($tanggal_pinjam, $tanggal_kembali) {
                // Cek apakah ada pemesanan yang tanggal peminjamannya tumpang tindih
                // atau tanggal kembalinya tumpang tindih dengan rentang tanggal yang diminta
                $query->where(function ($query) use ($tanggal_pinjam, $tanggal_kembali) {
                    $query->whereBetween('tanggal_pinjam', [$tanggal_pinjam, $tanggal_kembali])
                        ->orWhereBetween('tanggal_kembali', [$tanggal_pinjam, $tanggal_kembali]);
                })
                    // Atau pemesanan yang dimulai sebelum dan berakhir setelah rentang yang diminta
                    ->orWhere(function ($query) use ($tanggal_pinjam, $tanggal_kembali) {
                        $query->where('tanggal_pinjam', '<=', $tanggal_pinjam)
                            ->where('tanggal_kembali', '>=', $tanggal_kembali);
                    });
            })
            ->exists();
    }
    public function updateKetersediaan($status)
    {
        $this->ketersediaan = $status;
    }

    public function markAsAvailable()
    {
        $this->ketersediaan = 'tersedia';
    }
}
