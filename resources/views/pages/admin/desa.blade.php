@extends('layouts.adminLayout')

@section('title', 'Data Desa | SIPANDAKABULAN')

@section('content')
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <div
                        class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-building text-white text-sm lg:text-lg"></i>
                    </div>
                    Data Desa
                </h2>
                <p class="text-gray-600 mt-2 flex items-center gap-2 text-sm lg:text-base">
                    <i class="bi bi-info-circle text-blue-500"></i>
                    Kelola data desa dan operator
                </p>
            </div>
            <a href="{{ route('admin.desa.create') }}"
                class="flex items-center gap-2 px-4 py-2 lg:px-6 lg:py-3 bg-gradient-to-r from-blue-900 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 w-full lg:w-auto justify-center">
                <i class="bi bi-plus-circle"></i>
                Tambah Desa
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
        <div class="p-4 lg:p-6 border-b border-blue-200">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="text-sm text-gray-600 flex items-center gap-2">
                    <i class="bi bi-database text-blue-500"></i>
                    Total: <strong class="text-blue-900">{{ $desas->total() }}</strong> desa
                </div>
                <div class="flex gap-3 w-full lg:w-auto">
                    <div class="relative flex-1 lg:flex-none">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchInput" placeholder="Cari desa..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            style="min-width: 250px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-full" id="desaTable">
                <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                    <tr>
                        <th class="py-3 px-4 lg:py-4 lg:px-6 text-left font-semibold rounded-tl-2xl whitespace-nowrap">
                            No
                        </th>
                        <th class="py-3 px-4 lg:py-4 lg:px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-building mr-2 hidden sm:inline"></i>Nama Desa
                        </th>
                        <th
                            class="py-3 px-4 lg:py-4 lg:px-6 text-left font-semibold whitespace-nowrap hidden md:table-cell">
                            <i class="bi bi-code mr-2"></i>Kode Desa
                        </th>
                        <th
                            class="py-3 px-4 lg:py-4 lg:px-6 text-left font-semibold whitespace-nowrap hidden lg:table-cell">
                            <i class="bi bi-telephone mr-2"></i>Telepon
                        </th>
                        <th
                            class="py-3 px-4 lg:py-4 lg:px-6 text-left font-semibold whitespace-nowrap hidden xl:table-cell">
                            <i class="bi bi-geo-alt mr-2"></i>Alamat
                        </th>
                        <th class="py-3 px-4 lg:py-4 lg:px-6 text-center font-semibold whitespace-nowrap">
                            <i class="bi bi-people mr-2 hidden sm:inline"></i>User
                        </th>
                        <th class="py-3 px-4 lg:py-4 lg:px-6 text-center font-semibold rounded-tr-2xl whitespace-nowrap">
                            <i class="bi bi-gear mr-2 hidden sm:inline"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($desas as $index => $desa)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="py-3 px-4 lg:py-4 lg:px-6 text-gray-600 font-medium whitespace-nowrap">
                                {{ $desas->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-4 lg:py-4 lg:px-6">
                                <div class="font-bold text-gray-800 text-sm lg:text-base">{{ $desa->nama_desa }}</div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <i class="bi bi-geo-alt text-xs"></i>
                                    <span class="md:hidden">{{ Str::limit($desa->alamat_kantor, 30) ?? '-' }}</span>
                                    <span class="hidden md:inline">{{ $desa->alamat_kantor ?? '-' }}</span>
                                </div>
                                <div class="md:hidden mt-2">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-mono">
                                        {{ $desa->kode_desa }}
                                    </span>
                                    @if ($desa->no_telp)
                                        <div class="flex items-center gap-1 mt-1 text-xs text-gray-600">
                                            <i class="bi bi-telephone"></i>
                                            {{ $desa->no_telp }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 lg:py-4 lg:px-6 hidden md:table-cell">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-mono">
                                    {{ $desa->kode_desa }}
                                </span>
                            </td>
                            <td class="py-3 px-4 lg:py-4 lg:px-6 hidden lg:table-cell">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-telephone text-gray-400 text-sm"></i>
                                    <span class="text-gray-700 text-sm lg:text-base">{{ $desa->no_telp ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 lg:py-4 lg:px-6 hidden xl:table-cell">
                                <span class="text-gray-700 text-sm lg:text-base">{{ $desa->alamat_kantor ?? '-' }}</span>
                            </td>
                            <td class="py-3 px-4 lg:py-4 lg:px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-2 lg:px-3 py-1 rounded-full text-xs lg:text-sm font-semibold">
                                    <i class="bi bi-person-check"></i>
                                    {{ $desa->users_count }}
                                </span>
                            </td>
                            <td class="py-3 px-4 lg:py-4 lg:px-6">
                                <div class="flex justify-center gap-1 lg:gap-2">
                                    <!-- DETAIL BUTTON -->
                                    <button type="button"
                                        class="w-8 h-8 lg:w-10 lg:h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-all duration-200 transform hover:scale-105"
                                        onclick="openDetail({{ $desa->id }})" title="Detail">
                                        <i class="bi bi-eye text-sm lg:text-base"></i>
                                    </button>

                                    <!-- EDIT BUTTON -->
                                    <a href="{{ route('admin.desa.edit', $desa->id) }}"
                                        class="w-8 h-8 lg:w-10 lg:h-10 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center hover:bg-yellow-200 transition-all duration-200 transform hover:scale-105"
                                        title="Edit">
                                        <i class="bi bi-pencil text-sm lg:text-base"></i>
                                    </a>

                                    <!-- DELETE BUTTON -->
                                    <button type="button"
                                        class="w-8 h-8 lg:w-10 lg:h-10 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-all duration-200 transform hover:scale-105"
                                        onclick="confirmDelete({{ $desa->id }})" title="Hapus">
                                        <i class="bi bi-trash text-sm lg:text-base"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $desa->id }}"
                                    action="{{ route('admin.desa.destroy', $desa->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 lg:py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 px-4">
                                    <i class="bi bi-inbox text-4xl lg:text-5xl mb-3 lg:mb-4"></i>
                                    <p class="text-base lg:text-lg font-medium">Belum ada data desa</p>
                                    <p class="text-xs lg:text-sm mt-1 text-center">Klik tombol "Tambah Desa" untuk
                                        menambahkan data</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($desas->hasPages())
            <div class="p-4 lg:p-6 border-t border-blue-200 bg-blue-50 rounded-b-2xl">
                <div class="overflow-x-auto">
                    {{ $desas->onEachSide(1)->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Credentials -->
    @if (session('show_credentials'))
        <div class="modal fade" id="credentialsModal" tabindex="-1" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl">

                <div class="modal-content border-0 shadow-2xl mx-2">
                    <div
                        class="modal-header bg-gradient-to-r from-green-600 to-green-500 text-white rounded-t-2xl p-4 lg:p-5">
                        <h5 class="modal-title flex items-center gap-2 font-bold text-sm lg:text-base">
                            <i class="bi bi-check-circle-fill"></i>
                            Akun Berhasil Dibuat
                        </h5>
                    </div>
                    <div class="modal-body p-4 lg:p-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 lg:p-4 mb-4">
                            <div class="flex items-center gap-3">
                                <i
                                    class="bi bi-exclamation-triangle-fill text-yellow-600 text-lg lg:text-xl flex-shrink-0"></i>
                                <div>
                                    <strong class="text-yellow-800 text-sm lg:text-base">Penting!</strong>
                                    <p class="text-yellow-700 text-xs lg:text-sm mt-1">Catat informasi ini. Password hanya
                                        ditampilkan sekali.</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 lg:space-y-4">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-gray-50 rounded-lg gap-2">
                                <span class="font-semibold text-gray-700 text-sm lg:text-base">Desa</span>
                                <span
                                    class="text-gray-900 text-sm lg:text-base text-right sm:text-left">{{ session('credentials.nama_desa') }}</span>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-gray-50 rounded-lg gap-2">
                                <span class="font-semibold text-gray-700 text-sm lg:text-base">Email</span>
                                <div class="flex items-center gap-2">
                                    <code id="emailText"
                                        class="bg-white px-2 py-1 rounded border text-xs lg:text-sm break-all">{{ session('credentials.email') }}</code>
                                    <button
                                        class="w-7 h-7 lg:w-8 lg:h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center hover:bg-blue-200 transition-colors flex-shrink-0"
                                        onclick="copyText('emailText')">
                                        <i class="bi bi-clipboard text-xs lg:text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-gray-50 rounded-lg gap-2">
                                <span class="font-semibold text-gray-700 text-sm lg:text-base">Password</span>
                                <div class="flex items-center gap-2">
                                    <code id="passwordText"
                                        class="bg-white px-2 py-1 rounded border text-red-600 text-xs lg:text-sm break-all">{{ session('credentials.password') }}</code>
                                    <button
                                        class="w-7 h-7 lg:w-8 lg:h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center hover:bg-blue-200 transition-colors flex-shrink-0"
                                        onclick="copyText('passwordText')">
                                        <i class="bi bi-clipboard text-xs lg:text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 rounded-b-2xl p-4 lg:p-5">
                        <button type="button"
                            class="w-full px-4 py-2 lg:px-6 lg:py-2 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-lg hover:shadow-lg transition-all duration-200 font-semibold text-sm lg:text-base"
                            data-bs-dismiss="modal">
                            Saya Sudah Mencatat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Detail Desa -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">

            <div class="modal-content border-0 shadow-2xl rounded-2xl" id="detailContent">
                <!-- AJAX content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Custom responsive pagination */
        @media (max-width: 640px) {
            .pagination {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.25rem;
            }

            .pagination .page-item .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        /* Ensure table responsiveness */
        @media (max-width: 768px) {
            #desaTable {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            document.addEventListener('DOMContentLoaded', function() {
                var credentialsModal = new bootstrap.Modal(document.getElementById('credentialsModal'));
                credentialsModal.show();
            });
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
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data desa akan dihapus permanen!",
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
                    title: 'text-lg lg:text-xl',
                    htmlContainer: 'text-sm lg:text-base'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Copy to clipboard
        function copyText(elementId) {
            let text = document.getElementById(elementId).textContent;
            navigator.clipboard.writeText(text).then(() => {
                toastr.success('Berhasil disalin ke clipboard!');
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

        // Handle window resize for better mobile experience
        window.addEventListener('resize', function() {
            // Adjust table responsiveness on resize
            const table = document.getElementById('desaTable');
            if (window.innerWidth < 768) {
                table.classList.add('text-sm');
            } else {
                table.classList.remove('text-sm');
            }
        });
    </script>
@endsection
