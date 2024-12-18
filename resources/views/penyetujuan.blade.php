@extends('layouts.layout')

@section('title', 'Daftar Pemesanan Kendaraan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Daftar Pemesanan yang perlu disetujui</h4>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pemesanan List</h5>
            </div>

            <div class="card-body">
                <table id="approval-table" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Nama Kendaraan</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Kembali</th>
                            <th scope="col">Persetujuan Direktur</th>
                            <th scope="col">Persetujuan Manajer</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesanans as $pemesanan)
                            @if ($pemesanan->status_persetujuan1 == 'menunggu' || $pemesanan->status_persetujuan2 == 'menunggu')
                                <tr>
                                    <td>{{ $pemesanan->kendaraan->nama_kendaraan }}</td>
                                    <td>{{ $pemesanan->tanggal_pinjam }}</td>
                                    <td>{{ $pemesanan->tanggal_kembali }}</td>
                                    <td>
                                        <!-- Tampilkan status persetujuan direktur -->
                                        @if ($pemesanan->status_persetujuan1 == 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($pemesanan->status_persetujuan1 == 'disetujui')
                                            <span class="badge bg-success">Disetujui Direktur</span>
                                        @elseif ($pemesanan->status_persetujuan1 == 'ditolak')
                                            <span class="badge bg-danger">Ditolak Direktur</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Tampilkan status persetujuan manajer -->
                                        @if ($pemesanan->status_persetujuan2 == 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($pemesanan->status_persetujuan2 == 'disetujui')
                                            <span class="badge bg-success">Disetujui Manajer</span>
                                        @elseif ($pemesanan->status_persetujuan2 == 'ditolak')
                                            <span class="badge bg-danger">Ditolak Manajer</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->role == 'direktur' && $pemesanan->status_persetujuan1 == 'menunggu')
                                            <!-- Tombol untuk Direktur -->
                                            <form action="{{ route('approval.update', $pemesanan->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="action" value="setuju"
                                                    class="btn btn-success btn-sm me-2">Setuju Direktur</button>
                                                <button type="submit" name="action" value="ditolak"
                                                    class="btn btn-danger btn-sm">Tolak Direktur</button>
                                            </form>
                                        @elseif (auth()->user()->role == 'manajer' && $pemesanan->status_persetujuan2 == 'menunggu')
                                            <!-- Tombol untuk Manajer -->
                                            <form action="{{ route('approval.update', $pemesanan->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="action" value="setuju"
                                                    class="btn btn-success btn-sm me-2">Setuju Manajer</button>
                                                <button type="submit" name="action" value="ditolak"
                                                    class="btn btn-danger btn-sm">Tolak Manajer</button>
                                            </form>
                                        @elseif (auth()->user()->role == 'admin')
                                            <span>Hanya Direktur atau Manajer yang bisa menyetujui</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include DataTables JS and CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#approval-table').DataTable(); // Initialize DataTable
        });
    </script>
@endsection
