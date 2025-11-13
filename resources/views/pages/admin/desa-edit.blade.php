@extends('layouts.adminLayout')

@section('title', 'Edit Desa | SIPANDAKABULAN')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.desa') }}">Data Desa</a></li>
                <li class="breadcrumb-item active">Edit {{ $desa->nama_desa }}</li>
            </ol>
        </nav>
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Desa</h2>
    </div>

    <div class="row">
        <!-- LEFT: Form Edit Desa -->
        <div class="col-lg-7">
            <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-building me-2"></i>Informasi Desa
                </h5>

                <form action="{{ route('admin.desa.update', $desa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_desa" class="form-label fw-bold">
                            Nama Desa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_desa" id="nama_desa"
                            class="form-control @error('nama_desa') is-invalid @enderror"
                            value="{{ old('nama_desa', $desa->nama_desa) }}" required>
                        @error('nama_desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kode_desa" class="form-label fw-bold">
                            Kode Desa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="kode_desa" id="kode_desa"
                            class="form-control @error('kode_desa') is-invalid @enderror"
                            value="{{ old('kode_desa', $desa->kode_desa) }}" required>
                        @error('kode_desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_kades" class="form-label fw-bold">Nama Kepala Desa</label>
                        <input type="text" name="nama_kades" id="nama_kades"
                            class="form-control @error('nama_kades') is-invalid @enderror"
                            value="{{ old('nama_kades', $desa->nama_kades) }}">
                        @error('nama_kades')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat_kantor" class="form-label fw-bold">Alamat Kantor</label>
                        <textarea name="alamat_kantor" id="alamat_kantor" class="form-control @error('alamat_kantor') is-invalid @enderror"
                            rows="3">{{ old('alamat_kantor', $desa->alamat_kantor) }}</textarea>
                        @error('alamat_kantor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label fw-bold">Nomor Telepon</label>
                        <input type="text" name="no_telp" id="no_telp"
                            class="form-control @error('no_telp') is-invalid @enderror"
                            value="{{ old('no_telp', $desa->no_telp) }}">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.desa') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-lg shadow-sm p-4 border-danger border">
                <h5 class="fw-bold text-danger mb-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                </h5>
                <p class="text-muted mb-3">
                    Hapus desa ini beserta semua data terkait. Tindakan ini tidak dapat dibatalkan!
                </p>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteDesa()">
                    <i class="bi bi-trash me-1"></i> Hapus Desa
                </button>

                <form id="delete-desa-form" action="{{ route('admin.desa.destroy', $desa->id) }}" method="POST"
                    class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <!-- RIGHT: Manage Users -->
        <div class="col-lg-5">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-people me-2"></i>Operator Desa
                    </h5>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
                        <i class="bi bi-plus-circle me-1"></i> Tambah User
                    </button>
                </div>

                <!-- User List -->
                @forelse($desa->users as $user)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item"
                                            onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">
                                            <i class="bi bi-pencil me-2"></i> Edit
                                        </button>
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.desa.resetPassword', [$desa->id, $user->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-key me-2"></i> Reset Password
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger"
                                            onclick="confirmDeleteUser({{ $user->id }})">
                                            <i class="bi bi-trash me-2"></i> Hapus
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-calendar me-1"></i> Dibuat: {{ $user->created_at->format('d M Y') }}
                        </div>

                        <form id="delete-user-form-{{ $user->id }}"
                            action="{{ route('admin.desa.deleteUser', [$desa->id, $user->id]) }}" method="POST"
                            class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-person-x" style="font-size: 3rem;"></i>
                        <p class="mt-2">Belum ada user</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Add User -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.desa.addUser', $desa->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="alert alert-info mb-0">
                            <small><i class="bi bi-info-circle me-1"></i> Password default:
                                <code>password123</code></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="editUserName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="editUserEmail" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Credentials -->
    @if (session('show_credentials'))
        <div class="modal fade" id="credentialsModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle me-2"></i>Berhasil!
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Penting!</strong> Catat informasi ini.
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td class="fw-bold" width="35%">Email</td>
                                <td>
                                    <code id="emailText">{{ session('credentials.email') }}</code>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyText('emailText')">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Password</td>
                                <td>
                                    <code id="passwordText"
                                        class="text-danger">{{ session('credentials.password') }}</code>
                                    <button class="btn btn-sm btn-outline-secondary ms-2"
                                        onclick="copyText('passwordText')">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('show_credentials'))
            var credentialsModal = new bootstrap.Modal(document.getElementById('credentialsModal'));
            credentialsModal.show();
        @endif

        function confirmDeleteDesa() {
            if (confirm('PERINGATAN!\n\nYakin hapus desa {{ $desa->nama_desa }}?\nSemua data akan dihapus!')) {
                document.getElementById('delete-desa-form').submit();
            }
        }

        function confirmDeleteUser(userId) {
            if (confirm('Yakin hapus user ini?')) {
                document.getElementById('delete-user-form-' + userId).submit();
            }
        }

        function editUser(userId, name, email) {
            document.getElementById('editUserName').value = name;
            document.getElementById('editUserEmail').value = email;
            document.getElementById('editUserForm').action =
                "{{ route('admin.desa.updateUser', [$desa->id, ':userId']) }}".replace(':userId', userId);

            var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        }

        function copyText(elementId) {
            let text = document.getElementById(elementId).textContent;
            navigator.clipboard.writeText(text).then(() => {
                toastr.success('Berhasil disalin!');
            });
        }

        // Format kode desa
        document.getElementById('kode_desa').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Format no telepon
        document.getElementById('no_telp').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9\-\+\s]/g, '');
        });
    </script>
@endsection
