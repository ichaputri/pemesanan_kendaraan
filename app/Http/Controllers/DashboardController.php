<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $data = DB::table('kendaraan')
            ->leftJoin('pemesanan', 'kendaraan.id', '=', 'pemesanan.kendaraan_id')
            ->select('kendaraan.nama_kendaraan', DB::raw('COUNT(pemesanan.id) as total_pemakaian'))
            ->groupBy('kendaraan.nama_kendaraan')
            ->get();

        return view('dashboard', compact('data'));
    }
}
