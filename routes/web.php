<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PerawatanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// auth
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/proseslogin', [AuthController::class, 'proseslogin'])->name('proseslogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// daftar user
// Route::resource('users', UserController::class);
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/prosesadd', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


// daftar kendaraan
Route::resource('kendaraan', KendaraanController::class)->except(['show']);
// Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan');
// Route::post('/prosesaddkendaraan', [KendaraanController::class, 'store'])->name('kendaraan.store');

// daftar penyewaan
// Route::get('/penyewaan', [PemesananController::class, 'index'])->name('pemesanan');
Route::resource('pemesanan', PemesananController::class)->except(['show']);
Route::get('/approval', [PemesananController::class, 'showApprovalPage'])->name('approval.index');
Route::put('/approval/{id}', [PemesananController::class, 'updateApproval'])->name('approval.update');

// daftar perawatan
Route::resource('perawatan', PerawatanController::class)->except(['show']);
// Route::get('/perawatan', [PerawatanController::class, 'index'])->name('perawatan');

// export
Route::get('/pemesanan/export', [PemesananController::class, 'export'])->name('pemesanan.export');
