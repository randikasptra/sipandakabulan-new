@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Klaster per Desa')

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
                    <span class="text-gray-600">Klaster {{ $desa->nama_desa }}</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clipboard-data text-white text-lg"></i>
                    </div>
                    Penilaian Desa {{ $desa->nama_desa }}
                </h2>
                <p class="text-gray-600 mt-2 flex items-center gap-2">
                    <i class="bi bi-calendar-check text-blue-500"></i>
                    Periode: {{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }}
                </p>
            </div>
            <a href="{{ route('admin.penilaian') }}"
                class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Daftar Desa
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-semibold">Total Klaster</p>
                    <p class="text-2xl font-bold text-blue-800">{{ $klasters->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-layers text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-2xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-semibold">Total Disetujui</p>
                    <p class="text-2xl font-bold text-green-800">{{ $klasters->sum('total_approved') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-2xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-600 text-sm font-semibold">Total Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-800">{{ $klasters->sum('total_pending') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tableKlaster" class="w-full">
                <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold rounded-tl-2xl whitespace-nowrap">
                            No
                        </th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-layers mr-2"></i>Nama Klaster
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap">
                            <i class="bi bi-list-check mr-2"></i>Total Indikator
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap">
                            <i class="bi bi-check-circle mr-2"></i>Disetujui
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap">
                            <i class="bi bi-clock mr-2"></i>Menunggu
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap">
                            <i class="bi bi-x-circle mr-2"></i>Ditolak
                        </th>
                        <th class="py-4 px-6 text-center font-semibold rounded-tr-2xl whitespace-nowrap">
                            <i class="bi bi-gear mr-2"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($klasters as $i => $k)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap">
                                {{ $i + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800 text-sm lg:text-base">{{ $k->title }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="bi bi-list-check"></i>
                                    {{ $k->total_indikator }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="bi bi-check-circle"></i>
                                    {{ $k->total_approved }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="bi bi-clock"></i>
                                    {{ $k->total_pending }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="bi bi-x-circle"></i>
                                    {{ $k->total_rejected }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('admin.penilaian.klaster', [$desa->id, $k->id]) }}?tahun={{ request('tahun') }}&bulan={{ request('bulan') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
                                    <i class="bi bi-eye"></i>
                                    Lihat Indikator
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple table functionality without DataTables
            const table = document.getElementById('tableKlaster');
            const rows = table.querySelectorAll('tbody tr');

            // Add hover effects
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Responsive table adjustments
            function handleTableResponsive() {
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
        #tableKlaster {
            border-collapse: separate;
            border-spacing: 0;
        }

        #tableKlaster th {
            border: none;
            font-weight: 600;
            font-size: 0.875rem;
        }

        #tableKlaster td {
            border: none;
            border-bottom: 1px solid #e5e7eb;
        }

        #tableKlaster tbody tr:last-child td {
            border-bottom: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #tableKlaster {
                font-size: 0.75rem;
            }

            #tableKlaster th,
            #tableKlaster td {
                padding: 0.5rem 0.25rem;
            }

            .grid-cols-3 {
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
    </style>
@endsection
