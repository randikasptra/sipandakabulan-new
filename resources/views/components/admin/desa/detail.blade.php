<div class="modal-header bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-2xl p-4 lg:p-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
            <i class="bi bi-building text-white text-lg"></i>
        </div>
        <div>
            <h5 class="modal-title font-bold text-lg lg:text-xl">
                Detail Desa – {{ $desa->nama_desa }}
            </h5>
            <p class="text-blue-100 text-sm flex items-center gap-1 mt-1">
                <i class="bi bi-info-circle"></i>
                Informasi lengkap data desa
            </p>
        </div>
    </div>
    <button type="button" class="btn-close btn-close-white flex-shrink-0" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4 lg:p-6">
    <!-- Informasi Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6">
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-building text-blue-600"></i>
                </div>
                <h6 class="font-bold text-gray-800 text-sm lg:text-base">Informasi Desa</h6>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-blue-100">
                    <span class="text-gray-600 text-sm font-medium">Nama Desa</span>
                    <span class="text-gray-800 font-semibold text-sm lg:text-base">{{ $desa->nama_desa }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-blue-100">
                    <span class="text-gray-600 text-sm font-medium">Kode Desa</span>
                    <span
                        class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-mono font-semibold">{{ $desa->kode_desa }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-blue-100">
                    <span class="text-gray-600 text-sm font-medium">No Telepon</span>
                    <span class="text-gray-800 font-semibold text-sm lg:text-base">{{ $desa->no_telp ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-calendar-check text-green-600"></i>
                </div>
                <h6 class="font-bold text-gray-800 text-sm lg:text-base">Informasi Sistem</h6>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-green-100">
                    <span class="text-gray-600 text-sm font-medium">Jumlah User</span>
                    <span
                        class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                        <i class="bi bi-people"></i>
                        {{ $desa->users->count() }} user
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-green-100">
                    <span class="text-gray-600 text-sm font-medium">Dibuat Pada</span>
                    <span
                        class="text-gray-800 font-semibold text-xs lg:text-sm">{{ $desa->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600 text-sm font-medium">Terakhir Update</span>
                    <span
                        class="text-gray-800 font-semibold text-xs lg:text-sm">{{ $desa->updated_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alamat Kantor -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-geo-alt text-gray-600"></i>
            </div>
            <h6 class="font-bold text-gray-800 text-sm lg:text-base">Alamat Kantor Desa</h6>
        </div>
        <p class="text-gray-700 text-sm lg:text-base leading-relaxed">
            {{ $desa->alamat_kantor ?? 'Alamat belum diisi' }}
        </p>
    </div>

    <!-- User Operator -->
    <div class="border border-gray-200 rounded-xl overflow-hidden">
        <div class="bg-gradient-to-r from-purple-900 to-purple-700 text-white p-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="bi bi-people text-white"></i>
                </div>
                <h6 class="font-bold text-sm lg:text-base">
                    User Operator ({{ $desa->users->count() }})
                </h6>
            </div>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse ($desa->users as $user)
                <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-person text-purple-600"></i>
                            </div>
                            <div>
                                <h6 class="font-semibold text-gray-800 text-sm lg:text-base">{{ $user->name }}</h6>
                                <p class="text-gray-600 text-xs lg:text-sm mt-1 flex items-center gap-1">
                                    <i class="bi bi-envelope"></i>
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-semibold capitalize">
                                {{ $user->role }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <i class="bi bi-person-x text-3xl mb-3 opacity-50"></i>
                    <p class="text-sm font-medium">Tidak ada user operator</p>
                    <p class="text-xs mt-1">Belum ada user yang terdaftar untuk desa ini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="modal-footer bg-gray-50 rounded-b-2xl p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row gap-3 w-full">
        <button type="button"
            class="flex items-center justify-center gap-2 px-6 py-2 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-lg hover:shadow-lg transition-all duration-200 font-semibold text-sm lg:text-base order-2 sm:order-1 w-full sm:w-auto"
            data-bs-dismiss="modal">
            <i class="bi bi-check-lg"></i>
            Tutup
        </button>
        <div class="flex gap-2 order-1 sm:order-2 w-full sm:w-auto">
            <a href="{{ route('admin.desa.edit', $desa->id) }}"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-all duration-200 font-semibold text-sm lg:text-base w-full sm:w-auto">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
            <button type="button"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all duration-200 font-semibold text-sm lg:text-base w-full sm:w-auto"
                onclick="confirmDelete({{ $desa->id }})">
                <i class="bi bi-trash"></i>
                Hapus
            </button>
        </div>
    </div>
</div>

<style>
    @media (max-width: 640px) {
        .modal-body {
            padding: 1rem;
        }

        .modal-header,
        .modal-footer {
            padding: 1rem;
        }
    }

    @media (max-width: 1024px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data desa dan semua user terkait akan dihapus permanen!",
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
</script>
