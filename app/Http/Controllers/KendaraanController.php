<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\JenisKendaraan;
use Illuminate\Support\Facades\Log;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with('JenisKendaraan')->get(); // Eager load related data
        return view('kendaraan', compact('kendaraans'));
    }

    // Menyimpan data kendaraan baru
    public function store(Request $request)
    {
        // Validasi input
        if ($request->ajax()) {
            $validated = $request->validate([
                'jenis_kendaraan_id' => 'required|exists:jenis_kendaraan,id', // Pastikan jenis kendaraan ada di tabel jenis_kendaraan
                'namaKendaraan' => 'required|string|max:255',
                'nopol' => 'required|string|max:50|unique:kendaraan,nomor_polisi', // Nomor polisi harus unik
                'status' => 'required|in:milik perusahaan,sewa', // Validasi nilai status
                'ketersediaan' => 'required|in:tersedia,sedang dipakai', // Validasi nilai ketersediaan
            ]);

            // Menyimpan kendaraan baru
            $kendaraans = Kendaraan::create([
                'jenis_kendaraan_id' => $validated['jenis_kendaraan_id'],
                'nama_kendaraan' => $validated['namaKendaraan'],
                'nomor_polisi' => $validated['nopol'],
                'status' => $validated['status'],
                'ketersediaan' => $validated['ketersediaan'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Kendaraan added successfully',
                'kendaraan' => $kendaraans
            ]);

            // Redirect atau kembalikan respons
            return response()->json(['status' => 'error', 'message' => 'Invalid request']);
        }
    }

    // update kendaraan
    public function update(Request $request, $id)
    {

        if ($request->ajax()) {
            // Validasi input
            $validated = $request->validate([
                'editJenisKendaraan' => 'required|exists:jenis_kendaraan,id', // Pastikan jenis kendaraan ada di tabel jenis_kendaraan
                'editNamaKendaraan' => 'required|string|max:255',
                'editNopol' => 'required|string|max:50|unique:kendaraan,nomor_polisi,' . $id, // Nomor polisi harus unik
                'editStatus' => 'required|in:milik perusahaan,sewa', // Validasi nilai status
                'editKetersediaan' => 'required|in:tersedia,sedang dipakai', // Validasi nilai ketersediaan
            ]);

            // Temukan kendaraan berdasarkan ID
            $kendaraan = Kendaraan::findOrFail($id);

            // Update data kendaraan
            $kendaraan->jenis_kendaraan_id = $validated['editJenisKendaraan']; // Pastikan ini sesuai dengan kolom di tabel
            $kendaraan->nama_kendaraan = $validated['editNamaKendaraan'];
            $kendaraan->nomor_polisi = $validated['editNopol'];
            $kendaraan->status = $validated['editStatus'];
            $kendaraan->ketersediaan = $validated['editKetersediaan'];

            // Simpan perubahan ke database
            $kendaraan->save();


            Log::info('Update method called with:', [
                'request' => $kendaraan
            ]);

            // Return response success
            return response()->json([
                'status' => 'success',
                'message' => 'Kendaraan berhasil diperbarui',
                // 'redirect_url' => route('kendaraan.index')
                'kendaraan' => $kendaraan
            ]);
        }

        // Return response error jika bukan request AJAX
        return response()->json(['status' => 'error', 'message' => 'Request tidak valid']);
    }

    // Menghapus pengguna
    public function destroy(Kendaraan $kendaraan)
    {
        try {
            // Try to delete the kendaraan
            $kendaraan->delete();
            return redirect()->route('kendaraan.index')->with('success', 'Kendaraan deleted successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            // If there is a foreign key constraint violation (or other database-related issues)
            if ($e->getCode() == 23000) {
                // Foreign key constraint violation code
                return redirect()->route('kendaraan.index')->with('error', 'Kendaraan cannot be deleted because it is referenced in another record.');
            }

            // Handle other types of exceptions
            return redirect()->route('kendaraan.index')->with('error', 'An error occurred while deleting the kendaraan.');
        }
    }
}
