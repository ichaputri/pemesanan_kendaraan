@extends('layouts.layout')

@section('title', 'Daftar User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Daftar User</h4>
 
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User List</h5>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class='bx bxs-user-plus'></i> &nbsp Add User
                </button>
            </div>

            <div class="card-body">
                <table id="userTable" class="table">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-xs editUserBtn"
                                    data-id="{{ $user->id }}" data-username="{{ $user->username }}"
                                    data-email="{{ $user->email }}" data-role="{{ $user->role }}" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal">
                                    <i class='bx bxs-edit'></i>Edit
                                </button>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"><i
                                            class="bx bx-trash me-1"></i>Delete</button>
                                </form>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Add User --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form id="addUserForm" method="POST" action="{{ route('users.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="Masukkan Username.." required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="xxxx@xxxx.com"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="********"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="direktur">Direktur</option>
                            <option value="manajer">Manajer</option>
                            <option value="pengelola">Pengelola</option>
                            <option value="driver">Driver</option>
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
    {{-- End Modal Add User --}}

    {{-- Modal Edit User --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="updateUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editUserId" name="id" required>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="direktur">Direktur</option>
                                <option value="manajer">Manajer</option>
                                <option value="pengelola">Pengelola</option>
                                <option value="driver">Driver</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Edit User --}}
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Set up the CSRF token for Ajax requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Ajax Add User
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('users.store') }}', // URL to send data to the store route
                    type: 'POST',
                    data: $(this).serialize(), // Serialize the form data
                    success: function(response) {
                        if (response.status === 'success') {
                            // Close the modal
                            $('#addUserModal').modal('hide');
                            // Reload the page to show the new user
                            location.reload();
                        } else {
                            // Show error message if the user could not be added
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Log the error
                        alert('There was an error adding the user. Please try again.');
                    }
                });
            });
            // End Ajax add User

            // Ajax Edit User
            $('.editUserBtn').on('click', function() {
                const userId = $(this).data('id');
                const username = $(this).data('username');
                const email = $(this).data('email');
                const role = $(this).data('role');

                $('#editUserId').val(userId);
                $('#editUsername').val(username);
                $('#editEmail').val(email);
                $('#editRole').val(role);
            });

            // Handle form submission for updating user
            $('#updateUserForm').on('submit', function(e) {
                e.preventDefault();

                const userId = $('#editUserId').val();
                const formData = $(this).serialize();

                $.ajax({
                    url: '/users/' + userId,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#editUserModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('An error occurred while updating the user.');
                    }
                });
            });
        });
        // End Ajax Edit User
    </script>
@endsection
