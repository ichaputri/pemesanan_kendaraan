<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;




class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function proseslogin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email-username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengecek apakah login menggunakan email atau username
        $credentials = [
            'password' => $request->password
        ];

         // Mengecek apakah input adalah email atau username
         if (filter_var($request->input('email-username'), FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->input('email-username'); // Perbaiki akses input
        } else {
            $credentials['username'] = $request->input('email-username'); // Perbaiki akses input
        }

        // Cek login
        if (Auth::attempt($credentials)) {
            // Jika login berhasil, redirect ke dashboard atau halaman lain
            return redirect()->route('dashboard');
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'email-username' => ['These credentials do not match our records.'],
        ]);
    }

    // Menangani proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // Ganti dengan route login
    }

}
