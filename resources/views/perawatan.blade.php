@extends('layouts.layout')

@section('title', 'Daftar Perawatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Daftar Perawatan</h4>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Perawatan List</h5>

                <!-- Button trigger modal -->
                @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPerawatanModal">
                        <i class='bx bx-plus-circle'></i> &nbsp Add Perawatan
                    </button>
                @endcanany
            </div>
            <div class="card-body">
                <table id="perawatanTable" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Kendaraan</th>
                            <th>Tanggal Perawatan</th>
                            <th>BBM</th>
                            <th>Jadwal Service</th>
                            <th>Riwayat Pakai</th>
                            <th>Keterangan</th>
                            @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                                <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($perawatans as $perawatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $perawatan->kendaraan->nama_kendaraan }}</td>
                                <td>{{ $perawatan->tanggal_perawatan }}</td>
                                <td>{{ $perawatan->bbm }} Liter</td>
                                <td>{{ $perawatan->jadwal_service }}</td>
                                <td>{{ $perawatan->riwayat_pakai }}</td>
                                <td>{{ $perawatan->keterangan ?? 'N/A' }}</td>
                                @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                                    <td>
                                        {{-- Edit and Delete Buttons can be added here --}}
                                        <button type="button" class="btn btn-warning btn-sm editPerawatanBtn"
                                            data-id="{{ $perawatan->id }}" data-kendaraan-id="{{ $perawatan->kendaraan_id }}"
                                            data-tanggal-perawatan="{{ $perawatan->tanggal_perawatan }}"
                                            data-bbm="{{ $perawatan->bbm }}"
                                            data-jadwal-service="{{ $perawatan->jadwal_service }}"
                                            data-riwayat-pakai="{{ $perawatan->riwayat_pakai }}"
                                            data-keterangan="{{ $perawatan->keterangan }}" data-bs-toggle="modal"
                                            data-bs-target="#editPerawatanModal">
                                            <i class='bx bxs-edit'></i>Edit
                                        </button>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('perawatan.destroy', $perawatan->id) }}" method="POST"
                                            style="display: inline;" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i
                                                    class="bx bx-trash me-1"></i>Delete
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

    <!-- Modal Add Perawatan -->
    <div class="modal fade" id="addPerawatanModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form id="addPerawatanForm" method="POST" action="{{ route('perawatan.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Perawatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Kendaraan -->
                    <div class="mb-3">
                        <label for="kendaraan_id" class="form-label">Kendaraan</label>
                        <select id="kendaraan_id" name="kendaraan_id" class="form-select" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}">{{ $kendaraan->nama_kendaraan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Perawatan -->
                    <div class="mb-3">
                        <label for="tanggal_perawatan" class="form-label">Tanggal Perawatan</label>
                        <input type="date" id="tanggal_perawatan" name="tanggal_perawatan" class="form-control" required>
                    </div>

                    <!-- BBM -->
                    <div class="mb-3">
                        <label for="bbm" class="form-label">BBM (Liter)</label>
                        <input type="number" id="bbm" name="bbm" class="form-control" min="0"
                            step="any" required>
                    </div>

                    <!-- Jadwal Service -->
                    <div class="mb-3">
                        <label for="jadwal_service" class="form-label">Jadwal Service</label>
                        <input type="date" id="jadwal_service" name="jadwal_service" class="form-control" required>
                    </div>

                    <!-- Riwayat Pakai -->
                    <div class="mb-3">
                        <label for="riwayat_pakai" class="form-label">Riwayat Pakai</label>
                        <textarea id="riwayat_pakai" name="riwayat_pakai" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal Add Perawatan -->

    {{-- Modal Edit Perawatan --}}
    <div class="modal fade" id="editPerawatanModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form id="editPerawatanForm" method="POST" action="{{ route('perawatan.update', 'perawatan_id') }}"
                class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Perawatan Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Kendaraan -->
                    <div class="mb-3">
                        <label for="editKendaraan" class="form-label">Kendaraan</label>
                        <select id="editKendaraan" name="editKendaraan" class="form-select" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}">
                                    {{ $kendaraan->nama_kendaraan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Perawatan -->
                    <div class="mb-3">
                        <label for="editTanggalPerawatan" class="form-label">Tanggal Perawatan</label>
                        <input type="date" id="editTanggalPerawatan" name="editTanggalPerawatan" class="form-control"
                            required>
                    </div>

                    <!-- BBM -->
                    <div class="mb-3">
                        <label for="editBbm" class="form-label">BBM (Liter)</label>
                        <input type="number" id="editBbm" name="editBbm" class="form-control" min="0"
                            step="any" required>
                    </div>

                    <!-- Jadwal Service -->
                    <div class="mb-3">
                        <label for="editJadwalService" class="form-label">Jadwal Service</label>
                        <input type="date" id="editJadwalService" name="editJadwalService" class="form-control"
                            required>
                    </div>

                    <!-- Riwayat Pakai -->
                    <div class="mb-3">
                        <label for="editRiwayatPakai" class="form-label">Riwayat Pakai</label>
                        <textarea id="editRiwayatPakai" name="editRiwayatPakai" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="editKeterangan" class="form-label">Keterangan</label>
                        <textarea id="editKeterangan" name="editKeterangan" class="form-control" rows="3"></textarea>
                    </div>

                    <input type="hidden" id="editPerawatanId" name="id">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Edit Perawatan --}}

@endsection

@section('scripts')
    <!-- Include DataTables JS and CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#perawatanTable').DataTable(); // Initialize DataTable
        });

        // Ajax Add perawatan
        $('#addPerawatanForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('perawatan.store') }}', // URL to send data to the store route
                type: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal
                        $('#addPerawatanModal').modal('hide');
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
        // End Ajax add perawatan

        // Ajax edit kendaraan
        $('.editPerawatanBtn').on('click', function() {
            const id = $(this).data('id');
            const kendaraan_id = $(this).data('kendaraan-id');
            const tanggal_perawatan = $(this).data('tanggal-perawatan');
            const bbm = $(this).data('bbm');
            const jadwal_service = $(this).data('jadwal-service');
            const riwayat_pakai = $(this).data('riwayat-pakai');
            const keterangan = $(this).data('keterangan');


            // Set values in the modal form
            $('#editPerawatanId').val(id);
            $('#editKendaraan').val(kendaraan_id);
            $('#editTanggalPerawatan').val(tanggal_perawatan);
            $('#editBbm').val(bbm);
            $('#editJadwalService').val(jadwal_service);
            $('#editRiwayatPakai').val(riwayat_pakai);
            $('#editKeterangan').val(keterangan);
        });

        // Handle form submission for updating kendaraan
        $('#editPerawatanForm').on('submit', function(e) {
            e.preventDefault();

            const perawatanId = $('#editPerawatanId').val(); // Get the vehicle ID
            const formData = $(this).serialize(); // Serialize the form

            // Send the update request using Ajax
            $.ajax({
                url: '/perawatan/' + perawatanId,
                type: 'PUT', // PUT method for update
                data: formData, // Serialized form data
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal and reload the page
                        $('#editPerawatanModal').modal('hide');
                        window.location.href = '/perawatan';
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
        // Ajax edit perawatan
    </script>
@endsection
