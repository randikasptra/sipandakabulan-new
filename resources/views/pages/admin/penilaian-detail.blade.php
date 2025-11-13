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

    <!-- Stats Cards -->

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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        title: 'Tolak Penilaian?',
                        text: "Anda akan menolak penilaian ini",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Tolak!',
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
                                    `/admin/penilaian/${id}/reject`, {
                                        method: 'PATCH',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    });
                                const data = await res.json();

                                if (data.success) {
                                    Swal.fire({
                                        title: '❌ Ditolak!',
                                        text: data.message,
                                        icon: 'warning',
                                        confirmButtonColor: '#ef4444',
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
            handleTableResponsive(); // Initial call
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

            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .grid-cols-4 {
                grid-template-columns: 1fr;
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
    </style>
@endsection
