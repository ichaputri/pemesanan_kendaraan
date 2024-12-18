@extends('layouts.layout')

@section('title', 'Daftar User')

@section('content')


    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Daftar Kendaraan</h4>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Kendaraan List</h5>

                <!-- Button trigger modal -->
                @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKendaraanModal">
                        <i class='bx bxs-user-plus'></i> &nbsp Add Kendaraan
                    </button>
                @endcanany
            </div>
            <div class="card-body">
                <table id="kendaraanTable" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Jenis Kendaraan</th>
                            <th>Nama Kendaraan</th>
                            <th>Nomor Polisi</th>
                            <th>Status</th>
                            <th>Ketersediaan</th>
                            @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                                <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($kendaraans as $kendaraan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kendaraan->jenisKendaraan->nama_jenis }}</td>
                                <td>{{ $kendaraan->nama_kendaraan }}</td>
                                <td>{{ $kendaraan->nomor_polisi }}</td>
                                <td>
                                    @if ($kendaraan->status === 'milik perusahaan')
                                        <span class="badge bg-primary">{{ $kendaraan->status }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $kendaraan->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($kendaraan->ketersediaan === 'tersedia')
                                        <span class="badge bg-success">{{ $kendaraan->ketersediaan }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $kendaraan->ketersediaan }}</span>
                                    @endif
                                </td>
                                @canany(['isAdmin', 'isDirektur', 'isPengelola'])
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs editKendaraanBtn"
                                            data-id="{{ $kendaraan->id }}"
                                            data-jenis-kendaraan="{{ $kendaraan->jenisKendaraan->id }}"
                                            data-nama-kendaraan="{{ $kendaraan->nama_kendaraan }}"
                                            data-nopol="{{ $kendaraan->nomor_polisi }}" data-status="{{ $kendaraan->status }}"
                                            data-ketersediaan="{{ $kendaraan->ketersediaan }}" data-bs-toggle="modal"
                                            data-bs-target="#editKendaraanModal">
                                            <i class='bx bxs-edit'></i>Edit
                                        </button>

                                        <form id="" action="{{ route('kendaraan.destroy', $kendaraan->id) }}"
                                            method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs"><i
                                                    class="bx bx-trash me-1"></i>Delete</button>
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

    {{-- Modal Add Kendaraan --}}
    <div class="modal fade" id="addKendaraanModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form id="addKendaraanForm" method="POST" action="{{ route('kendaraan.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis_kendaraan_id" class="form-label"> Jenis Kendaraan</label>
                        <select id="jenis_kendaraan_id" name="jenis_kendaraan_id" class="form-select" required>
                            <option value="admin">Pilih Jenis Kendaraan</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->jenisKendaraan->id }}">
                                    {{ $kendaraan->jenisKendaraan->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="namaKendaraan" class="form-label">Nama Kendaraan</label>
                        <input type="namaKendaraan" id="namaKendaraan" name="namaKendaraan" class="form-control"
                            placeholder="Masukkan Nama Kendaraan.." required>
                    </div>
                    <div class="mb-3">
                        <label for="nopol" class="form-label">Nomor Polisi</label>
                        <input type="nopol" id="nopol" name="nopol" class="form-control" placeholder="N **** PQ"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="">Pilih Status Kendaraan</option>
                            <option value="milik perusahaan">Milik Perusahaan</option>
                            <option value="sewa">Sewa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ketersediaan" class="form-label">Ketersediaan</label>
                        <select id="ketersediaan" name="ketersediaan" class="form-select" required>
                            <option value="">Pilih Status Ketersediaan</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="sedang dipakai">Sedang Dipakai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Add Kendaraan --}}

    {{-- Modal Edit Kendaraan --}}
    <div class="modal fade" id="editKendaraanModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form id="editKendaraanForm" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editKendaraanId" name="id">

                    <div class="mb-3">
                        <label for="editJenisKendaraan" class="form-label">Jenis Kendaraan</label>
                        <select id="editJenisKendaraan" name="editJenisKendaraan" class="form-select" required>
                            <option value="">Pilih Jenis Kendaraan</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->jenisKendaraan->id }}">
                                    {{ $kendaraan->jenisKendaraan->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editNamaKendaraan" class="form-label">Nama Kendaraan</label>
                        <input type="text" id="editNamaKendaraan" name="editNamaKendaraan" class="form-control"
                            placeholder="Masukkan Nama Kendaraan.." required>
                    </div>

                    <div class="mb-3">
                        <label for="editNopol" class="form-label">Nomor Polisi</label>
                        <input type="text" id="editNopol" name="editNopol" class="form-control"
                            placeholder="N **** PQ" required>
                    </div>

                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select id="editStatus" name="editStatus" class="form-select" required>
                            <option value="">Pilih Status Kendaraan</option>
                            <option value="milik perusahaan">Milik Perusahaan</option>
                            <option value="sewa">Sewa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editKetersediaan" class="form-label">Ketersediaan</label>
                        <select id="editKetersediaan" name="editKetersediaan" class="form-select" required>
                            <option value="">Pilih Status Ketersediaan</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="sedang dipakai">Sedang Dipakai</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
            $('#kendaraanTable').DataTable(); // Initialize DataTable
        });

        // Ajax Add Kendaraan
        $('#addKendaraanForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('kendaraan.store') }}', // URL to send data to the store route
                type: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Success!', response.message, 'success');
                        $('#addKendaraanModal').modal('hide');
                        $('#kendaraanTable').DataTable().ajax.reload(); // Reload table if needed
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Log the error
                    // alert('There was an error adding the user. Please try again.');
                    alert(xhr.responseText);
                }
            });
        });
        // End Ajax add kendaraan

        // Ajax edit kendaraan
        $('.editKendaraanBtn').on('click', function() {
            const kendaraanId = $(this).data('id');
            const jenisKendaraan = $(this).data('jenis-kendaraan');
            const namaKendaraan = $(this).data('nama-kendaraan');
            const nopol = $(this).data('nopol');
            const status = $(this).data('status');
            const ketersediaan = $(this).data('ketersediaan');

            // Set values in the modal form
            $('#editKendaraanId').val(kendaraanId);
            $('#editJenisKendaraan').val(jenisKendaraan);
            $('#editNamaKendaraan').val(namaKendaraan);
            $('#editNopol').val(nopol);
            $('#editStatus').val(status);
            $('#editKetersediaan').val(ketersediaan);
        });

        // Handle form submission for updating kendaraan
        $('#editKendaraanForm').on('submit', function(e) {
            e.preventDefault();

            const kendaraanId = $('#editKendaraanId').val(); // Get the vehicle ID
            const formData = $(this).serialize(); // Serialize the form

            // Send the update request using Ajax
            $.ajax({
                url: '/kendaraan/' + kendaraanId,
                type: 'PUT', // PUT method for update
                data: formData, // Serialized form data
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal and reload the page
                        $('#editKendaraanModal').modal('hide');
                        window.location.href = '/kendaraan';
                        Swal.fire('Berhasil Mengupdate Kendaraan', 'success');
                    } else {
                        Swal.fire('Gagal Mengupdate Kendaraan', 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors
                    alert('An error occurred while updating the vehicle.');
                }
            });
        });
        // Ajax edit kendaraan
    </script>
@endsection
