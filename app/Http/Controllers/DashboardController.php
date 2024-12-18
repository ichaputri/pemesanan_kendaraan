<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        return view('dashboard');
    }
}
