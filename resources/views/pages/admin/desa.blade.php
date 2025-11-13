@extends('layouts.adminLayout')

@section('title', 'Data Desa | SIPANDAKABULAN')

@section('content')
    <div class="mb-4">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Data Desa</h2>
                <p class="text-gray-600 mt-1">Kelola data desa dan operator</p>
            </div>
            <a href="{{ route('admin.desa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Desa
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-4 border-b">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Total: <strong>{{ $desas->total() }}</strong> desa
                </div>
                <div class="flex gap-2">
                    <input type="text" id="searchInput" placeholder="Cari desa..." class="form-control form-control-sm"
                        style="width: 250px;">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0" id="desaTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Desa</th>
                        <th>Kode Desa</th>
                        <th>No. Telepon</th>
                        <th>Alamat Kantor</th>
                        <th style="width: 100px;">Jumlah User</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($desas as $index => $desa)
                        <tr>
                            <td>{{ $desas->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $desa->nama_desa }}</div>
                                <small class="text-muted">{{ $desa->alamat_kantor ?? '-' }}</small>
                            </td>
                            <td><code>{{ $desa->kode_desa }}</code></td>
                            <td>{{ $desa->no_telp ?? '-' }}</td>
                            <td>{{ $desa->alamat_kantor ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $desa->users_count }} user</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">

                                    <!-- DETAIL BUTTON -->
                                    <button type="button" class="btn btn-info text-white"
                                        onclick="openDetail({{ $desa->id }})" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <a href="{{ route('admin.desa.edit', $desa->id) }}" class="btn btn-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete({{ $desa->id }})" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $desa->id }}"
                                    action="{{ route('admin.desa.destroy', $desa->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">Belum ada data desa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($desas->hasPages())
            <div class="p-4 border-t">
                {{ $desas->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Credentials -->
    @if (session('show_credentials'))
        <div class="modal fade" id="credentialsModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle me-2"></i>Akun Berhasil Dibuat
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Penting!</strong> Catat informasi ini. Password hanya ditampilkan sekali.
                        </div>

                        <table class="table table-bordered">
                            <tr>
                                <td class="fw-bold" width="35%">Desa</td>
                                <td>{{ session('credentials.nama_desa') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
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
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            Saya Sudah Mencatat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Detail Desa -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" id="detailContent">
                <!-- AJAX content will be loaded here -->
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr config
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Show toast notifications
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Auto show credentials modal
        @if (session('show_credentials'))
            var credentialsModal = new bootstrap.Modal(document.getElementById('credentialsModal'));
            credentialsModal.show();
        @endif

        // Search function
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#desaTable tbody tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });

        // Delete confirmation
        function confirmDelete(id) {
            if (confirm('Yakin ingin menghapus desa ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // Copy to clipboard
        function copyText(elementId) {
            let text = document.getElementById(elementId).textContent;
            navigator.clipboard.writeText(text).then(() => {
                toastr.success('Berhasil disalin!');
            });
        }

        function openDetail(id) {
            fetch(`/admin/desa/${id}/ajax-detail`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('detailContent').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                })
                .catch(err => {
                    toastr.error("Gagal memuat detail desa");
                });
        }
    </script>
@endsection
