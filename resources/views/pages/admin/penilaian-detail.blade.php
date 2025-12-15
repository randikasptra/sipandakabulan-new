@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Indikator Klaster')

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
                <a href="{{ route('admin.penilaian') }}" class="text-blue-600 hover:text-blue-800">
                    Verifikasi Penilaian
                </a>
            </li>
            <li class="flex items-center gap-2">
                <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('admin.penilaian.desa', $desa->id) }}?tahun={{ request('tahun') }}&bulan={{ request('bulan') }}"
                    class="text-blue-600 hover:text-blue-800">
                    {{ $desa->nama_desa }}
                </a>
            </li>
            <li class="flex items-center gap-2">
                <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-600">{{ $klaster->title }}</span>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                    <i class="bi bi-list-check text-white text-lg"></i>
                </div>
                Klaster "{{ $klaster->title }}"
            </h2>
            <p class="text-gray-600 mt-2 flex items-center gap-2">
                <i class="bi bi-building text-blue-500"></i>
                Desa {{ $desa->nama_desa }} •
                <i class="bi bi-calendar-check text-blue-500"></i>
                {{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }}
            </p>
        </div>
        <a href="{{ route('admin.penilaian.desa', $desa->id) }}?tahun={{ request('tahun') }}&bulan={{ request('bulan') }}"
            class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Klaster
        </a>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table id="tableIndikator" class="w-full">
            <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                <tr>
                    <th class="py-4 px-6 text-left font-semibold rounded-tl-2xl whitespace-nowrap">
                        <i class="bi bi-hash mr-2"></i>No
                    </th>
                    <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                        <i class="bi bi-card-checklist mr-2"></i>Indikator
                    </th>
                    <th class="py-4 px-6 text-center font-semibold whitespace-nowrap">
                        <i class="bi bi-star mr-2"></i>Nilai
                    </th>
                    <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                        <i class="bi bi-ui-radios mr-2"></i>Opsi Dipilih
                    </th>
                    <th class="py-4 px-6 text-center font-semibold whitespace-nowrap">
                        <i class="bi bi-flag mr-2"></i>Status
                    </th>
                    <th class="py-4 px-6 text-center">
                        <i class="bi bi-journal-text"></i>
                    </th>

                    <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                        <i class="bi bi-files mr-2"></i>Dokumen
                    </th>
                    <th class="py-4 px-6 text-center font-semibold rounded-tr-2xl whitespace-nowrap">
                        <i class="bi bi-gear mr-2"></i>Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($penilaians as $i => $p)
                <tr id="row-{{ $p->id }}" class="hover:bg-blue-50 transition-all duration-200">
                    <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap">
                        {{ $i + 1 }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-semibold text-gray-800 text-sm lg:text-base">
                            {{ $p->indikator->nama_indikator }}
                        </div>

                        <!-- Tampilkan alasan reject jika ada -->
                        @if ($p->status == 'rejected' && $p->rejection_reason)
                        <div class="mt-2 p-3 bg-red-50 border-l-4 border-red-400 rounded">
                            <div class="flex items-start gap-2">
                                <i class="bi bi-exclamation-triangle-fill text-red-500 mt-0.5"></i>
                                <div>
                                    <p class="text-xs font-semibold text-red-800 mb-1">Alasan Penolakan:</p>
                                    <p class="text-xs text-red-700">{{ $p->rejection_reason }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-800 rounded-full font-bold text-lg">
                            {{ $p->nilai ?? '-' }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        @php
                        $opsiDipilih = $p->indikator->opsiNilai->firstWhere('poin', $p->nilai);
                        @endphp
                        @if ($opsiDipilih)
                        <span class="text-gray-600 text-sm italic bg-gray-100 px-3 py-1 rounded-lg">
                            {{ $opsiDipilih->label }}
                        </span>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold
                                    @if ($p->status == 'approved') bg-green-100 text-green-800
                                    @elseif($p->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                            <i
                                class="bi
                                        @if ($p->status == 'approved') bi-check-circle
                                        @elseif($p->status == 'pending') bi-clock
                                        @else bi-x-circle @endif">
                            </i>
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if ($p->catatan)
                        <button
                            onclick="toggleCatatan({{ $p->id }})"
                            class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm hover:bg-blue-200">
                            <i class="bi bi-eye"></i>
                            Lihat
                        </button>
                        @else
                        <span class="text-gray-400 text-xs italic">-</span>
                        @endif
                    </td>

                    <td class="py-4 px-6">
                        <div class="space-y-1">
                            @forelse ($p->berkasUploads as $b)
                            <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $b->path_file }}"
                                target="_blank"
                                class="flex items-center gap-2 text-blue-600 hover:text-blue-800 transition-colors text-sm">
                                <i class="bi bi-file-earmark-text"></i>
                                <span class="truncate max-w-xs">{{ basename($b->path_file) }}</span>
                            </a>
                            @empty
                            <span class="text-gray-400 text-sm">Tidak ada dokumen</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if ($p->status == 'pending')
                        <div class="flex justify-center gap-2">
                            <button
                                class="w-10 h-10 bg-green-500 text-white rounded-lg flex items-center justify-center hover:bg-green-600 transition-all duration-200 transform hover:scale-105 btn-approve"
                                data-id="{{ $p->id }}" title="Setujui">
                                <i class="bi bi-check-lg"></i>
                            </button>
                            <button
                                class="w-10 h-10 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600 transition-all duration-200 transform hover:scale-105 btn-reject"
                                data-id="{{ $p->id }}" title="Tolak">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        @else
                        <span class="text-gray-400 text-sm">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>

                @if ($p->catatan)
                <tr id="catatan-{{ $p->id }}" class="hidden bg-blue-50">
                    <td colspan="8" class="px-8 py-4">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center">
                                <i class="bi bi-chat-left-text"></i>
                            </div>

                            <div class="flex-1">
                                <p class="font-semibold text-blue-900 mb-1">
                                    Catatan dari Desa
                                </p>

                                <p class="text-gray-700 text-sm leading-relaxed">
                                    {{ $p->catatan->catatan }}
                                </p>

                                <p class="text-xs text-gray-500 mt-2">
                                    Oleh {{ $p->catatan->user->name }}
                                    • {{ $p->catatan->updated_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleCatatan(id) {
        const el = document.getElementById('catatan-' + id);
        if (!el) return;

        el.classList.toggle('hidden');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Approve functionality
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.dataset.id;
                const row = document.querySelector(`#row-${id}`);

                Swal.fire({
                    title: 'Setujui Penilaian?',
                    text: "Anda akan menyetujui penilaian ini",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal',
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        this.innerHTML =
                            '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';
                        this.disabled = true;

                        try {
                            const res = await fetch(
                                `/admin/penilaian/${id}/approve`, {
                                    method: 'PATCH',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                });
                            const data = await res.json();

                            if (data.success) {
                                Swal.fire({
                                    title: '✅ Disetujui!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#22c55e',
                                    background: '#fff',
                                    customClass: {
                                        popup: 'rounded-2xl'
                                    }
                                });
                                // Remove row with fade out effect
                                row.style.opacity = '0';
                                row.style.transform = 'translateX(-100px)';
                                setTimeout(() => row.remove(), 300);
                            }
                        } catch (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat memproses',
                                icon: 'error',
                                confirmButtonColor: '#ef4444',
                                background: '#fff',
                                customClass: {
                                    popup: 'rounded-2xl'
                                }
                            });
                            // Reset button
                            this.innerHTML = '<i class="bi bi-check-lg"></i>';
                            this.disabled = false;
                        }
                    }
                });
            });
        });

        // Reject functionality
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.dataset.id;
                const row = document.querySelector(`#row-${id}`);

                Swal.fire({
                    title: 'Tolak Penilaian',
                    html: `
                            <div class="text-left">
                                <label class="block mb-2 font-semibold text-gray-700">Pilih Alasan Penolakan:</label>
                                <select id="reject_reason_select" class="swal2-input w-full">
                                    <option value="">-- Pilih alasan --</option>
                                    <option value="Data tidak lengkap">Data tidak lengkap</option>
                                    <option value="Format dokumen salah">Format dokumen salah</option>
                                    <option value="Bukti tidak valid">Bukti tidak valid</option>
                                    <option value="Nilai tidak sesuai">Nilai tidak sesuai</option>
                                    <option value="other">Lainnya...</option>
                                </select>

                                <textarea id="reject_reason_manual" class="swal2-textarea w-full mt-2" placeholder="Tulis alasan lainnya..." style="display:none" rows="4"></textarea>
                            </div>
                        `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Tolak',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    customClass: {
                        popup: 'rounded-2xl'
                    },
                    preConfirm: () => {
                        const dropdown = document.getElementById(
                            'reject_reason_select').value;
                        const manual = document.getElementById(
                            'reject_reason_manual').value;

                        // Validasi: harus ada salah satu yang diisi
                        if (dropdown === "" && manual.trim() === "") {
                            Swal.showValidationMessage(
                                'Harap pilih atau isi alasan penolakan');
                            return false;
                        }

                        // Jika pilih "Lainnya" tapi tidak isi manual
                        if (dropdown === 'other' && manual.trim() === "") {
                            Swal.showValidationMessage(
                                'Harap isi alasan penolakan');
                            return false;
                        }

                        // Return alasan yang dipilih
                        if (dropdown === 'other') {
                            return manual.trim();
                        }

                        return dropdown || manual.trim();
                    },
                    didOpen: () => {
                        const select = document.getElementById(
                            'reject_reason_select');
                        const manual = document.getElementById(
                            'reject_reason_manual');

                        select.addEventListener('change', () => {
                            manual.style.display = select.value ===
                                'other' ? 'block' : 'none';
                            if (select.value !== 'other') {
                                manual.value = '';
                            }
                        });
                    }
                }).then(async (result) => {
                    if (result.isConfirmed && result.value) {
                        // Show loading
                        Swal.fire({
                            title: 'Memproses...',
                            html: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        try {
                            const res = await fetch(
                                `/admin/penilaian/${id}/reject`, {
                                    method: 'PATCH',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        reason: result.value
                                    })
                                });

                            const data = await res.json();

                            if (data.success) {
                                Swal.fire({
                                    title: '❌ Ditolak!',
                                    text: 'Penilaian telah ditolak beserta alasannya.',
                                    icon: 'success',
                                    confirmButtonColor: '#22c55e',
                                    customClass: {
                                        popup: 'rounded-2xl'
                                    }
                                });

                                // Remove row with fade out effect
                                row.style.opacity = '0';
                                row.style.transform = 'translateX(-100px)';
                                setTimeout(() => row.remove(), 300);
                            } else {
                                throw new Error(data.message ||
                                    'Gagal menolak penilaian');
                            }

                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message ||
                                    'Terjadi kesalahan saat memproses',
                                confirmButtonColor: '#ef4444',
                                customClass: {
                                    popup: 'rounded-2xl'
                                }
                            });
                        }
                    }
                });
            });
        });

        // Responsive table adjustments
        function handleTableResponsive() {
            const table = document.getElementById('tableIndikator');
            if (window.innerWidth < 768) {
                table.classList.add('text-sm');
            } else {
                table.classList.remove('text-sm');
            }
        }

        window.addEventListener('resize', handleTableResponsive);
        handleTableResponsive();
    });
</script>

<style>
    /* Custom table styling */
    #tableIndikator {
        border-collapse: separate;
        border-spacing: 0;
    }

    #tableIndikator th {
        border: none;
        font-weight: 600;
        font-size: 0.875rem;
    }

    #tableIndikator td {
        border: none;
        border-bottom: 1px solid #e5e7eb;
    }

    #tableIndikator tbody tr:last-child td {
        border-bottom: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #tableIndikator {
            font-size: 0.75rem;
        }

        #tableIndikator th,
        #tableIndikator td {
            padding: 0.5rem 0.25rem;
        }
    }

    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 10px;
    }

    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Animation for row removal */
    #tableIndikator tbody tr {
        transition: all 0.3s ease;
    }

    /* Rejection reason box styling */
    .swal2-input,
    .swal2-textarea {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem;
    }

    .swal2-input:focus,
    .swal2-textarea:focus {
        border-color: #3b82f6;
        outline: none;
    }
</style>
@endsection