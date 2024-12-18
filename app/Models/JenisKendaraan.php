<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKendaraan extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'jenis_kendaraan';

    protected $fillable = [
        'nama_jenis',
    ];

    /**
     * Get the vehicles associated with this jenis kendaraan.
     */
    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
