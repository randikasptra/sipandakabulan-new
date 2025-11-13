@extends('layouts.adminLayout')

@section('title', 'Edit Desa | SIPANDAKABULAN')

@section('content')
    <div class="mb-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex flex-wrap items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <i class="bi bi-house"></i>
                        Dashboard
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <a href="{{ route('admin.desa') }}" class="text-blue-600 hover:text-blue-800">
                        Data Desa
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-600">Edit {{ $desa->nama_desa }}</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-pencil-square text-white text-lg"></i>
                    </div>
                    Edit Data Desa
                </h2>
                <p class="text-gray-600 mt-2 flex items-center gap-2">
                    <i class="bi bi-building text-blue-500"></i>
                    Mengubah informasi desa {{ $desa->nama_desa }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT: Form Edit Desa -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6 mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-building text-blue-600 text-lg"></i>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800">Informasi Desa</h3>
                </div>

                <form action="{{ route('admin.desa.update', $desa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Desa -->
                        <div class="md:col-span-2">
                            <label for="nama_desa" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-building me-1 text-blue-500"></i>
                                Nama Desa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_desa" id="nama_desa"
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nama_desa') border-red-500 @enderror"
                                value="{{ old('nama_desa', $desa->nama_desa) }}" required>
                            @error('nama_desa')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Kode Desa -->
                        <div>
                            <label for="kode_desa" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-code me-1 text-blue-500"></i>
                                Kode Desa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kode_desa" id="kode_desa"
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('kode_desa') border-red-500 @enderror"
                                value="{{ old('kode_desa', $desa->kode_desa) }}" required>
                            @error('kode_desa')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Nama Kepala Desa -->
                        <div>
                            <label for="nama_kades" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-person-badge me-1 text-blue-500"></i>
                                Nama Kepala Desa
                            </label>
                            <input type="text" name="nama_kades" id="nama_kades"
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nama_kades') border-red-500 @enderror"
                                value="{{ old('nama_kades', $desa->nama_kades) }}">
                            @error('nama_kades')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-telephone me-1 text-blue-500"></i>
                                Nomor Telepon
                            </label>
                            <input type="text" name="no_telp" id="no_telp"
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('no_telp') border-red-500 @enderror"
                                value="{{ old('no_telp', $desa->no_telp) }}">
                            @error('no_telp')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Alamat Kantor -->
                        <div class="md:col-span-2">
                            <label for="alamat_kantor" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-geo-alt me-1 text-blue-500"></i>
                                Alamat Kantor
                            </label>
                            <textarea name="alamat_kantor" id="alamat_kantor" rows="3"
                                class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('alamat_kantor') border-red-500 @enderror">{{ old('alamat_kantor', $desa->alamat_kantor) }}</textarea>
                            @error('alamat_kantor')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-end mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.desa') }}"
                            class="flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
                            <i class="bi bi-x-circle"></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                            <i class="bi bi-save"></i>
                            Update Data
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-2xl shadow-lg border border-red-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                    <h3 class="font-bold text-xl text-red-700">Danger Zone</h3>
                </div>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Hapus desa ini beserta semua data terkait. Tindakan ini <span class="font-semibold text-red-700">tidak
                        dapat dibatalkan</span> dan akan menghapus semua user serta data penilaian yang terkait dengan desa
                    ini.
                </p>
                <button type="button"
                    class="flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all duration-200 font-semibold"
                    onclick="confirmDeleteDesa()">
                    <i class="bi bi-trash"></i>
                    Hapus Desa
                </button>

                <form id="delete-desa-form" action="{{ route('admin.desa.destroy', $desa->id) }}" method="POST"
                    class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <!-- RIGHT: Manage Users -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6 sticky top-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="bi bi-people text-purple-600 text-lg"></i>
                        </div>
                        <h3 class="font-bold text-xl text-gray-800">Operator Desa</h3>
                    </div>
                    <button type="button"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 font-semibold text-sm"
                        data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bi bi-plus-circle"></i>
                        Tambah
                    </button>
                </div>

                <!-- User List -->
                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @forelse($desa->users as $user)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-person text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-semibold text-gray-800 text-sm lg:text-base">{{ $user->name }}
                                        </h6>
                                        <p class="text-gray-600 text-xs lg:text-sm mt-1 flex items-center gap-1">
                                            <i class="bi bi-envelope"></i>
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="w-8 h-8 bg-gray-100 text-gray-600 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors"
                                        type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical text-sm"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-xl p-2 min-w-40">
                                        <li>
                                            <button
                                                class="dropdown-item flex items-center gap-2 py-2 px-3 rounded-lg hover:bg-blue-50 transition-colors text-sm"
                                                onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">
                                                <i class="bi bi-pencil text-blue-600"></i>
                                                Edit
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.desa.resetPassword', [$desa->id, $user->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="dropdown-item flex items-center gap-2 py-2 px-3 rounded-lg hover:bg-yellow-50 transition-colors text-sm w-full text-left">
                                                    <i class="bi bi-key text-yellow-600"></i>
                                                    Reset Password
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-2">
                                        </li>
                                        <li>
                                            <button
                                                class="dropdown-item flex items-center gap-2 py-2 px-3 rounded-lg hover:bg-red-50 transition-colors text-sm text-red-600"
                                                onclick="confirmDeleteUser({{ $user->id }})">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-calendar"></i>
                                    {{ $user->created_at->format('d M Y') }}
                                </span>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                                    {{ $user->role }}
                                </span>
                            </div>

                            <form id="delete-user-form-{{ $user->id }}"
                                action="{{ route('admin.desa.deleteUser', [$desa->id, $user->id]) }}" method="POST"
                                class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="bi bi-person-x text-4xl mb-3"></i>
                            <p class="font-medium">Belum ada user</p>
                            <p class="text-sm mt-1">Tambahkan user operator untuk desa ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add User -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered max-w-md">
            <div class="modal-content border-0 shadow-2xl rounded-2xl">
                <div class="modal-header bg-gradient-to-r from-green-600 to-green-500 text-white rounded-t-2xl p-6">
                    <h5 class="modal-title font-bold flex items-center gap-2">
                        <i class="bi bi-person-plus"></i>
                        Tambah User Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.desa.addUser', $desa->id) }}" method="POST">
                    @csrf
                    <div class="modal-body p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-person me-1 text-green-600"></i>
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name"
                                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-envelope me-1 text-green-600"></i>
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email"
                                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                    required>
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mt-4">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-info-circle text-blue-600 text-lg"></i>
                                <div>
                                    <p class="text-blue-800 text-sm font-medium">Password default: <code
                                            class="bg-white px-2 py-1 rounded border">password123</code></p>
                                    <p class="text-blue-700 text-xs mt-1">User dapat mengganti password setelah login
                                        pertama</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 rounded-b-2xl p-6">
                        <div class="flex gap-3 w-full">
                            <button type="button"
                                class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold"
                                data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold">
                                Tambah User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered max-w-md">
            <div class="modal-content border-0 shadow-2xl rounded-2xl">
                <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-t-2xl p-6">
                    <h5 class="modal-title font-bold flex items-center gap-2">
                        <i class="bi bi-pencil"></i>
                        Edit User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-person me-1 text-blue-600"></i>
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="editUserName"
                                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-envelope me-1 text-blue-600"></i>
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="editUserEmail"
                                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 rounded-b-2xl p-6">
                        <div class="flex gap-3 w-full">
                            <button type="button"
                                class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold"
                                data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Credentials -->
    @if (session('show_credentials'))
        <div class="modal fade" id="credentialsModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered max-w-md">
                <div class="modal-content border-0 shadow-2xl rounded-2xl">
                    <div class="modal-header bg-gradient-to-r from-green-600 to-green-500 text-white rounded-t-2xl p-6">
                        <h5 class="modal-title font-bold flex items-center gap-2">
                            <i class="bi bi-check-circle"></i>
                            Berhasil!
                        </h5>
                    </div>
                    <div class="modal-body p-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-exclamation-triangle text-yellow-600 text-lg"></i>
                                <div>
                                    <strong class="text-yellow-800 text-sm">Penting!</strong>
                                    <p class="text-yellow-700 text-xs mt-1">Catat informasi ini. Password hanya ditampilkan
                                        sekali.</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700 text-sm">Email</span>
                                <div class="flex items-center gap-2">
                                    <code id="emailText"
                                        class="bg-white px-2 py-1 rounded border text-xs">{{ session('credentials.email') }}</code>
                                    <button
                                        class="w-7 h-7 bg-blue-100 text-blue-600 rounded flex items-center justify-center hover:bg-blue-200 transition-colors"
                                        onclick="copyText('emailText')">
                                        <i class="bi bi-clipboard text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="font-semibold text-gray-700 text-sm">Password</span>
                                <div class="flex items-center gap-2">
                                    <code id="passwordText"
                                        class="bg-white px-2 py-1 rounded border text-red-600 text-xs">{{ session('credentials.password') }}</code>
                                    <button
                                        class="w-7 h-7 bg-blue-100 text-blue-600 rounded flex items-center justify-center hover:bg-blue-200 transition-colors"
                                        onclick="copyText('passwordText')">
                                        <i class="bi bi-clipboard text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 rounded-b-2xl p-6">
                        <button type="button"
                            class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold"
                            data-bs-dismiss="modal">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .sticky {
            position: sticky;
        }

        @media (max-width: 1024px) {
            .sticky {
                position: static;
            }
        }

        .dropdown-menu {
            min-width: 160px;
        }
    </style>
@endpush

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            document.addEventListener('DOMContentLoaded', function() {
                var credentialsModal = new bootstrap.Modal(document.getElementById('credentialsModal'));
                credentialsModal.show();
            });
        @endif

        function confirmDeleteDesa() {
            Swal.fire({
                title: 'PERINGATAN!',
                text: "Yakin hapus desa {{ $desa->nama_desa }}? Semua data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                iconColor: '#dc2626',
                customClass: {
                    popup: 'rounded-2xl',
                    title: 'text-lg lg:text-xl text-red-700',
                    htmlContainer: 'text-sm lg:text-base'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-desa-form').submit();
                }
            });
        }

        function confirmDeleteUser(userId) {
            Swal.fire({
                title: 'Yakin hapus user?',
                text: "User akan dihapus dari sistem",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl',
                    title: 'text-lg lg:text-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-user-form-' + userId).submit();
                }
            });
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

        // Responsive adjustments
        window.addEventListener('resize', function() {
            const userSection = document.querySelector('.sticky');
            if (window.innerWidth < 1024) {
                userSection.classList.remove('sticky');
            } else {
                userSection.classList.add('sticky');
            }
        });
    </script>
@endsection
