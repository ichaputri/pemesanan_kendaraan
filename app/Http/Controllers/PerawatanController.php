<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perawatan;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Log;

class PerawatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { {
            // Mengambil semua data perawatan dengan relasi kendaraan
            $perawatans = Perawatan::with('kendaraan')->get();
            $kendaraans = Kendaraan::all(); // Mengambil semua kendaraan untuk dropdown
            return view('perawatan', compact('perawatans', 'kendaraans'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        if ($request->ajax()) {
            $validated = $request->validate([
                'kendaraan_id' => 'required|exists:kendaraan,id',
                'tanggal_perawatan' => 'required|date',
                'bbm' => 'required|numeric|min:0',
                'jadwal_service' => 'required|date',
                'riwayat_pakai' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);

            // Menyimpan kendaraan baru
            $perawatans = Perawatan::create([
                'kendaraan_id' => $validated['kendaraan_id'],
                'tanggal_perawatan' => $validated['tanggal_perawatan'],
                'bbm' => $validated['bbm'],
                'jadwal_service' => $validated['jadwal_service'],
                'riwayat_pakai' => $validated['riwayat_pakai'],
                'keterangan' => $validated['keterangan'],

            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Perawatan added successfully',
                'perawatan' => $perawatans
            ]);

            // Redirect atau kembalikan respons
            return response()->json(['status' => 'error', 'message' => 'Invalid request']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->ajax()) {
            // Validasi input
            $validated = $request->validate([
                'editKendaraan' => 'required|exists:kendaraan,id',
                'editTanggalPerawatan' => 'required|date',
                'editBbm' => 'required|numeric|min:0',
                'editJadwalService' => 'required|date',
                'editRiwayatPakai' => 'nullable|string',
                'editKeterangan' => 'nullable|string',
            ]);

            // Temukan pemesanan berdasarkan ID
            $perawatan = Perawatan::findOrFail($id);

            // Update data kendaraan
            $perawatan->kendaraan_id = $validated['editKendaraan'];
            $perawatan->tanggal_perawatan = $validated['editTanggalPerawatan'];
            $perawatan->bbm = $validated['editBbm'];
            $perawatan->jadwal_service = $validated['editJadwalService'];
            $perawatan->riwayat_pakai = $validated['editRiwayatPakai'];
            $perawatan->keterangan = $validated['editKeterangan'];

            // Simpan perubahan ke database
            $perawatan->save();

            Log::info('Update method called with:', [
                'request' => $perawatan
            ]);

            // Return response success
            return response()->json([
                'status' => 'success',
                'message' => 'Perawatan berhasil diperbarui',
                // 'redirect_url' => route('kendaraan.index')
                'perawatan' => $perawatan
            ]);
        }

        // Return response error jika bukan request AJAX
        return response()->json(['status' => 'error', 'message' => 'Request tidak valid']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Mencari pemesanan berdasarkan ID
            $perawatan = Perawatan::findOrFail($id);

            // Menghapus perawatan
            $perawatan->delete();

            // Mengembalikan response sukses
            return redirect()->route('perawatan.index')->with('success', 'perawatan berhasil dihapus.');
        } catch (\Exception $e) {
            // Mengembalikan response error jika terjadi kesalahan
            return redirect()->route('perawatan.index')->with('error', 'Terjadi kesalahan saat menghapus pemesanan.');
        }
    }
}
