<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class PemesananExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
     * Menyediakan data yang akan diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Menyesuaikan format tanggal untuk setiap entri
        return Pemesanan::all()->map(function ($item, $key) {
            // Pastikan tanggal pinjam dan kembali adalah objek Carbon
            $tanggalPinjam = $item->tanggal_pinjam instanceof Carbon ? $item->tanggal_pinjam : Carbon::parse($item->tanggal_pinjam);
            $tanggalKembali = $item->tanggal_kembali instanceof Carbon ? $item->tanggal_kembali : Carbon::parse($item->tanggal_kembali);

            return [
                'no' => $key + 1,
                'kendaraan' => $item->kendaraan->nama_kendaraan,
                'pengelola' => $item->pengelolaUser ? $item->pengelolaUser->username : null,
                'penyetuju_1' => $item->penyetuju1User ? $item->penyetuju1User->username : null,
                'penyetuju_2' => $item->penyetuju2User ? $item->penyetuju2User->username : null,
                'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'), // Format tanggal
                'tanggal_kembali' => $tanggalKembali->format('Y-m-d'), // Format tanggal
                'status_persetujuan1' => $item->status_persetujuan1,
                'status_persetujuan2' => $item->status_persetujuan2,
            ];
        });
    }

    /**
     * Menyediakan judul kolom untuk spreadsheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Kendaraan',
            'Pengelola',
            'Penyetuju 1',
            'Penyetuju 2',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status Persetujuan 1',
            'Status Persetujuan 2'
        ];
    }

    /**
     * Menentukan format kolom.
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Format kolom tanggal pinjam
            'G' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Format kolom tanggal kembali
        ];


    }
}
