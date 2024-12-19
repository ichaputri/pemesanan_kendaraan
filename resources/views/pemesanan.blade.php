@extends('layouts.layout')

@section('title', 'Daftar Pemesanan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Daftar Pemesanan</h4>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pemesanan List</h5>

                <!-- Button trigger modal -->
                <!-- Button trigger modal -->
                @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                    <div class="d-flex gap-2">
                        <!-- Export Button -->
                        <a href="{{ route('pemesanan.export') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-download"></i> &nbsp; Export to Excel
                        </a>
                        <!-- Add Pemesanan Button -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addPemesananModal">
                            <i class='bx bx-plus-circle'></i> &nbsp; Add Pemesanan
                        </button>
                    </div>
                @endcanany
            </div>
            <div class="card-body">
                <table id="pemesananTable" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th></th>
                            <th>Kendaraan</th>
                            <th>Pengelola</th>
                            <th>Penyetuju 1</th>
                            <th>Penyetuju 2</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status Setuju 1</th>
                            <th>Status Setuju 2</th>
                            @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                                <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($pemesanans as $pemesanan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pemesanan->kendaraan->nama_kendaraan }}</td>
                                <td>{{ $pemesanan->pengelolaUser->username ?? 'N/A' }}</td>
                                <td>{{ $pemesanan->penyetuju1User->username ?? 'N/A' }}</td>
                                <td>{{ $pemesanan->penyetuju2User->username ?? 'N/A' }}</td>
                                <td>{{ $pemesanan->tanggal_pinjam }}</td>
                                <td>{{ $pemesanan->tanggal_kembali }}</td>
                                <td>
                                    @if ($pemesanan->status_persetujuan1 === 'disetujui')
                                        <span class="badge bg-success">{{ $pemesanan->status_persetujuan1 }}</span>
                                    @elseif ($pemesanan->status_persetujuan1 === 'ditolak')
                                        <span class="badge bg-danger">{{ $pemesanan->status_persetujuan1 }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $pemesanan->status_persetujuan1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pemesanan->status_persetujuan2 === 'disetujui')
                                        <span class="badge bg-success">{{ $pemesanan->status_persetujuan2 }}</span>
                                    @elseif ($pemesanan->status_persetujuan2 === 'ditolak')
                                        <span class="badge bg-danger">{{ $pemesanan->status_persetujuan2 }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $pemesanan->status_persetujuan2 }}</span>
                                    @endif
                                </td>
                                @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                                    <td>
                                        {{-- Edit and Delete Buttons can be added here --}}
                                        <button type="button" class="btn btn-warning btn-xs editPemesananBtn"
                                            data-id="{{ $pemesanan->id }}" data-kendaraan-id="{{ $pemesanan->kendaraan_id }}"
                                            data-pengelola-user-id="{{ $pemesanan->pengelola }}"
                                            data-penyetuju1-user-id="{{ $pemesanan->penyetuju1 }}"
                                            data-penyetuju2-user-id="{{ $pemesanan->penyetuju2 }}"
                                            data-tanggal-pinjam="{{ $pemesanan->tanggal_pinjam }}"
                                            data-tanggal-kembali="{{ $pemesanan->tanggal_kembali }}" data-bs-toggle="modal"
                                            data-bs-target="#editPemesananModal">
                                            <i class='bx bxs-edit'></i>Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('pemesanan.destroy', $pemesanan->id) }}" method="POST"
                                            style="display:inline-block;" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Add Penyewaan --}}
    <div class="modal fade" id="addPemesananModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form id="addPemesananForm" method="POST" action="{{ route('pemesanan.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Kendaraan -->
                    <div class="mb-3">
                        <label for="kendaraan_id" class="form-label">Kendaraan</label>
                        <select id="kendaraan_id" name="kendaraan_id" class="form-select" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($kendaraans as $kendaraan)
                                @if ($kendaraan->ketersediaan == 'tersedia')
                                    <option value="{{ $kendaraan->id }}">{{ $kendaraan->nama_kendaraan }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Pengelola -->
                    <div class="mb-3">
                        <label for="pengelola_user_id" class="form-label">Pengelola</label>
                        <select id="pengelola_user_id" name="pengelola_user_id" class="form-select" required>
                            <option value="">Pilih Pengelola</option>
                            @foreach ($users as $user)
                                @if ($user->role == 'pengelola')
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Penyetuju 1 -->
                    <div class="mb-3">
                        <label for="penyetuju1_user_id" class="form-label">Penyetuju 1</label>
                        <select id="penyetuju1_user_id" name="penyetuju1_user_id" class="form-select" required>
                            <option value="">Pilih Penyetuju 1</option>
                            @foreach ($users as $user)
                                @if ($user->role == 'direktur')
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Penyetuju 2 -->
                    <div class="mb-3">
                        <label for="penyetuju2_user_id" class="form-label">Penyetuju 2</label>
                        <select id="penyetuju2_user_id" name="penyetuju2_user_id" class="form-select" required>
                            <option value="">Pilih Penyetuju 2</option>
                            @foreach ($users as $user)
                                @if ($user->role == 'manajer')
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control" required>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Add Penyewaan --}}

    {{-- Modal Edit Pemesanan --}}
    <div class="modal fade" id="editPemesananModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form id="editPemesananForm" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editPemesananId" name="id">

                    <!-- Kendaraan -->
                    <div class="mb-3">
                        <label for="edit_kendaraan_id" class="form-label">Kendaraan</label>
                        <select id="edit_kendaraan_id" name="edit_kendaraan_id" class="form-select" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}">{{ $kendaraan->nama_kendaraan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pengelola -->
                    <div class="mb-3">
                        <label for="edit_pengelola_user_id" class="form-label">Pengelola</label>
                        <select id="edit_pengelola_user_id" name="edit_pengelola_user_id" class="form-select" required>
                            <option value="">Pilih Pengelola</option>
                            @foreach ($users as $user)
                                @if ($user->role == 'pengelola')
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Penyetuju 1 -->
                    <div class="mb-3">
                        <label for="edit_penyetuju1_user_id" class="form-label">Penyetuju 1</label>
                        <select id="edit_penyetuju1_user_id" name="edit_penyetuju1_user_id" class="form-select" required>
                            <option value="">Pilih Penyetuju 1</option>
                            @foreach ($users as $user)
                                @if ($user->role == 'direktur')
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Penyetuju 2 -->
                    <div class="mb-3">
                        <label for="edit_penyetuju2_user_id" class="form-label">Penyetuju 2</label>
                        <select id="edit_penyetuju2_user_id" name="edit_penyetuju2_user_id" class="form-select" required>
                            <option value="">Pilih Penyetuju 2</option>
                            @foreach ($users as $user)
                                @if ($user->role == 'manajer')
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="mb-3">
                        <label for="edit_tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" id="edit_tanggal_pinjam" name="edit_tanggal_pinjam" class="form-control"
                            required>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div class="mb-3">
                        <label for="edit_tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" id="edit_tanggal_kembali" name="edit_tanggal_kembali" class="form-control"
                            required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Edit Kendaraan --}}


@endsection

@section('scripts')
    <!-- Include DataTables JS and CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pemesananTable').DataTable(); // Initialize DataTable
        });

        // Ajax Add Pemesanan
        $('#addPemesananForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('pemesanan.store') }}', // URL to send data to the store route
                type: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal
                        $('#addPemesananModal').modal('hide');
                        // Reload the page to show the new user
                        location.reload();
                    } else {
                        // Show error message if the user could not be added
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Log the error
                    // alert('There was an error adding the user. Please try again.');
                    alert(xhr.responseText);
                }
            });
        });
        // End Ajax add Pemesanan

        // Ajax Edit pemesanan
        $('.editPemesananBtn').on('click', function() {
            const pemesananId = $(this).data('id');
            const kendaraanId = $(this).data('kendaraan-id');
            const pengelolaUserId = $(this).data('pengelola-user-id');
            const penyetuju1UserId = $(this).data('penyetuju1-user-id');
            const penyetuju2UserId = $(this).data('penyetuju2-user-id');
            const tanggalPinjam = $(this).data('tanggal-pinjam');
            const tanggalKembali = $(this).data('tanggal-kembali');

            // Set nilai form pada modal
            $('#editPemesananId').val(pemesananId);
            $('#edit_kendaraan_id').val(kendaraanId);
            $('#edit_pengelola_user_id').val(pengelolaUserId);
            $('#edit_penyetuju1_user_id').val(penyetuju1UserId);
            $('#edit_penyetuju2_user_id').val(penyetuju2UserId);
            $('#edit_tanggal_pinjam').val(tanggalPinjam);
            $('#edit_tanggal_kembali').val(tanggalKembali);
        });

        // Handle form submission for updating kendaraan
        $('#editPemesananForm').on('submit', function(e) {
            e.preventDefault();

            const pemesananId = $('#editPemesananId').val();
            const formData = $(this).serialize(); // Serialisasi data form

            // Send the update request using Ajax
            $.ajax({
                url: '/pemesanan/' + pemesananId,
                type: 'PUT', // PUT method for update
                data: formData, // Serialized form data
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal and reload the page
                        $('#editPemesananModal').modal('hide');
                        window.location.href = '/pemesanan';
                    } else {
                        alert(response.message); // Handle error message
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors
                    alert('An error occurred while updating the vehicle.');
                }
            });
        });
        // End Ajax Edit
    </script>
@endsection
