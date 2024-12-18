<?php

namespace App\Http\Controllers;

use App\Exports\PemesananExport;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemesanans = Pemesanan::with(['kendaraan', 'pengelolaUser', 'penyetuju1User', 'penyetuju2User'])->get();
        $kendaraans = Kendaraan::all();
        $users = User::all();

        return view('pemesanan', compact('pemesanans', 'kendaraans', 'users'));
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
                'pengelola_user_id' => 'required|exists:users,id',
                'penyetuju1_user_id' => 'required|exists:users,id',
                'penyetuju2_user_id' => 'required|exists:users,id',
                'tanggal_pinjam' => 'required|date|after_or_equal:today',
                'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            ]);

            $kendaraan = Kendaraan::find($request->kendaraan_id);

            // Cek ketersediaan kendaraan
            if (!$kendaraan->isAvailable($validated['tanggal_pinjam'], $validated['tanggal_kembali'])) {
                return response()->json(['message' => 'Kendaraan tidak tersedia pada tanggal yang dipilih.'], 400);
            }

            $kendaraan->ketersediaan = 'sedang dipakai';
            $kendaraan->save();

            // Menyimpan kendaraan baru
            $pemesanans = Pemesanan::create([
                'kendaraan_id' => $validated['kendaraan_id'],
                'pengelola' => $validated['pengelola_user_id'],
                'penyetuju1' => $validated['penyetuju1_user_id'],
                'penyetuju2' => $validated['penyetuju2_user_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pemesanan added successfully',
                'pemesanan' => $pemesanans
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
                'edit_kendaraan_id' => 'required|exists:kendaraan,id',
                'edit_pengelola_user_id' => 'required|exists:users,id',
                'edit_penyetuju1_user_id' => 'required|exists:users,id',
                'edit_penyetuju2_user_id' => 'required|exists:users,id',
                'edit_tanggal_pinjam' => 'required|date|after_or_equal:today',
                'edit_tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            ]);

            // Temukan pemesanan berdasarkan ID
            $pemesanan = Pemesanan::findOrFail($id);

            // Update data kendaraan
            $pemesanan->kendaraan_id = $validated['edit_kendaraan_id']; // Pastikan ini sesuai dengan kolom di tabel
            $pemesanan->pengelola = $validated['edit_pengelola_user_id'];
            $pemesanan->penyetuju1 = $validated['edit_penyetuju1_user_id'];
            $pemesanan->penyetuju2 = $validated['edit_penyetuju2_user_id'];
            $pemesanan->tanggal_pinjam = $validated['edit_tanggal_pinjam'];
            $pemesanan->tanggal_kembali = $validated['edit_tanggal_kembali'];

            // Simpan perubahan ke database
            $pemesanan->save();

            Log::info('Update method called with:', [
                'request' => $pemesanan
            ]);

            // Return response success
            return response()->json([
                'status' => 'success',
                'message' => 'Pemesanan berhasil diperbarui',
                'pemesanan' => $pemesanan
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
        // Mencari pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan) {
            // Mengembalikan ketersediaan kendaraan
            $kendaraan = $pemesanan->kendaraan;

            // Hapus pemesanan
            $pemesanan->delete();

            $kendaraan->ketersediaan = 'tersedia';
            $kendaraan->save();

            return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil di hapus, kendaraan kembali tersedia');

        }

        return response()->json(['message' => 'Pemesanan tidak ditemukan.'], 404);
    }

    // Menampilkan data pemesanan untuk proses persetujuan
    public function showApprovalPage()
    {
        $user = auth()->user();

        // Filter data berdasarkan peran pengguna
        $pemesanans = Pemesanan::query()
            ->when($user->role == 'direktur', function ($query) {
                $query->where('status_persetujuan1', 'menunggu');
            })
            ->when($user->role == 'manajer', function ($query) {
                $query->where('status_persetujuan2', 'menunggu');
            })
            ->with(['kendaraan', 'pengelolaUser', 'penyetuju1User', 'penyetuju2User'])
            ->get();

        return view('penyetujuan', compact('pemesanans'));
    }

    public function setujui(Request $request, string $id)
    {
        $user = $request->user();
        $pemesanan = Pemesanan::findOrFail($id);

        // Validasi apakah pengguna memiliki hak akses untuk menyetujui
        if ($user->id == $pemesanan->penyetuju1) {
            $pemesanan->status_persetujuan1 = $request->status;
        } elseif ($user->id == $pemesanan->penyetuju2) {
            $pemesanan->status_persetujuan2 = $request->status;
        } else {
            return redirect()->route('approval.index')->withErrors('Anda tidak memiliki akses untuk menyetujui pemesanan ini.');
        }

        $pemesanan->save();

        return redirect()->route('approval.index')->with('success', 'Status persetujuan berhasil diperbarui.');
    }

    public function updateApproval(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'action' => 'required|in:setuju,ditolak',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $user = $request->user();

        // Perbarui status persetujuan berdasarkan role pengguna
        if ($user->role == 'direktur' && $pemesanan->status_persetujuan1 == 'menunggu') {
            $pemesanan->status_persetujuan1 = $validated['action'] == 'setuju' ? 'disetujui' : 'ditolak';
        } elseif ($user->role == 'manajer' && $pemesanan->status_persetujuan2 == 'menunggu') {
            $pemesanan->status_persetujuan2 = $validated['action'] == 'setuju' ? 'disetujui' : 'ditolak';
        } else {
            return redirect()->route('approval.index')->withErrors('Anda tidak memiliki akses untuk memperbarui pemesanan ini.');
        }

        $pemesanan->save();

        return redirect()->route('approval.index')->with('success', 'Status persetujuan berhasil diperbarui.');
    }

    public function export()
    {
        return Excel::download(new PemesananExport, 'pemesanan.xlsx');
    }
}
