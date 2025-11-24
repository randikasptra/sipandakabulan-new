@extends('layouts.adminLayout')
@section('title', 'Laporan Penilaian Desa')

@section('content')
    @php
        $tahun = $tahun ?? now()->year;
    @endphp

    <div class="mb-6">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-file-earmark-bar-graph text-white text-lg"></i>
                    </div>
                    Laporan Penilaian Desa
                </h2>
                <p class="text-gray-600 mt-2 flex items-center gap-2">
                    <i class="bi bi-calendar-check text-blue-500"></i>
                    Periode: {{ $bulan }} {{ $tahun }}
                </p>
            </div>

            <!-- Export Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.exportExcel', ['tahun' => $tahun, 'bulan' => $bulan]) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>
                <a href="{{ route('admin.laporan.exportPdf', ['tahun' => $tahun, 'bulan' => $bulan]) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
                    <i class="bi bi-filetype-pdf"></i>
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl shadow-lg p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <!-- Tahun -->
                <div>
                    <label class="block text-white text-sm font-semibold mb-2">
                        <i class="bi bi-calendar3 me-1"></i>Tahun
                    </label>
                    <input type="number" name="tahun"
                        class="w-full p-3 bg-white/90 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                        value="{{ $tahun }}" min="2020" max="{{ now()->year }}">
                </div>

                <!-- Bulan -->
                <div>
                    <label class="block text-white text-sm font-semibold mb-2">
                        <i class="bi bi-calendar-month me-1"></i>Bulan
                    </label>
                    <select name="bulan"
                        class="w-full p-3 bg-white/90 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200">
                        @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $b)
                            <option value="{{ $b }}" {{ $bulan === $b ? 'selected' : '' }}>
                                {{ $b }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-white text-blue-900 rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                        <i class="bi bi-search"></i>
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="flex items-center justify-center gap-2 px-4 py-3 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-all duration-200 font-semibold">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-semibold mb-1">Total Disetujui</p>
                    <p class="text-3xl font-bold text-green-800">{{ $totalApproved }}</p>
                    <p class="text-xs text-green-600 mt-1">Penilaian Approved</p>
                </div>
                <div class="w-14 h-14 bg-green-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-600 text-sm font-semibold mb-1">Total Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-800">{{ $totalPending }}</p>
                    <p class="text-xs text-yellow-600 mt-1">Penilaian Pending</p>
                </div>
                <div class="w-14 h-14 bg-yellow-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-sm font-semibold mb-1">Total Ditolak</p>
                    <p class="text-3xl font-bold text-red-800">{{ $totalRejected }}</p>
                    <p class="text-xs text-red-600 mt-1">Penilaian Rejected</p>
                </div>
                <div class="w-14 h-14 bg-red-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-x-circle text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-bar-chart text-blue-600 text-lg"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800">Visualisasi Penilaian {{ $bulan }} {{ $tahun }}</h3>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Status Chart -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="font-semibold text-gray-700 mb-4 text-center">Status Penilaian</h4>
                <div class="flex justify-center">
                    <canvas id="statusChart" style="max-height: 250px;"></canvas>
                </div>
            </div>

            <!-- Nilai Chart -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="font-semibold text-gray-700 mb-4 text-center">Rata-rata Nilai per Desa</h4>
                <div class="flex justify-center">
                    <canvas id="nilaiChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="flex justify-end mb-4">
        <div class="relative w-full lg:w-96">
            <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="searchDesa"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                placeholder="Cari nama desa...">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tableLaporan" class="w-full">
                <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold rounded-tl-2xl whitespace-nowrap w-20">No</th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-building mr-2"></i>Nama Desa
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-28">
                            <i class="bi bi-check-circle mr-2"></i>Disetujui
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-28">
                            <i class="bi bi-clock mr-2"></i>Menunggu
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-28">
                            <i class="bi bi-x-circle mr-2"></i>Ditolak
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">
                            <i class="bi bi-star mr-2"></i>Rata-rata
                        </th>
                        <th class="py-4 px-6 text-center font-semibold rounded-tr-2xl whitespace-nowrap w-40">
                            <i class="bi bi-eye mr-2"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($desas as $i => $desa)
                        <tr class="hover:bg-blue-50 transition-all duration-200 data-row">
                            <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap text-center">
                                {{ $i + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800">{{ $desa->nama_desa }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[3rem] bg-green-100 text-green-800 px-4 py-2 rounded-full text-base font-bold">
                                    {{ $desa->total_approved }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[3rem] bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-base font-bold">
                                    {{ $desa->total_pending }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[3rem] bg-red-100 text-red-800 px-4 py-2 rounded-full text-base font-bold">
                                    {{ $desa->total_rejected }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-lg font-bold">
                                    {{ number_format($desa->rata_rata ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('admin.laporan.desa', ['desa' => $desa->id, 'tahun' => $tahun, 'bulan' => $bulan]) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
                                    <i class="bi bi-eye"></i>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="bi bi-inbox text-5xl mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada data laporan</p>
                                    <p class="text-sm mt-1">Pilih periode waktu yang berbeda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Chart
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Disetujui', 'Menunggu', 'Ditolak'],
                    datasets: [{
                        data: [{{ $totalApproved }}, {{ $totalPending }}, {{ $totalRejected }}],
                        backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 15,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 13,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });

            // Nilai Chart
            const ctxNilai = document.getElementById('nilaiChart').getContext('2d');
            new Chart(ctxNilai, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($desas->pluck('nama_desa')) !!},
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: {!! json_encode($desas->pluck('rata_rata')) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 6,
                        hoverBackgroundColor: 'rgba(37, 99, 235, 0.9)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                stepSize: 20
                            },
                            grid: {
                                color: '#e5e7eb'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });

            // Search functionality
            const searchInput = document.getElementById('searchDesa');
            const tableRows = document.querySelectorAll('.data-row');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const desaCell = row.querySelector('td:nth-child(2)');
                    if (desaCell) {
                        const desaName = desaCell.textContent.toLowerCase();
                        row.style.display = desaName.includes(searchTerm) ? '' : 'none';
                    }
                });
            });
        });
    </script>

    <style>
        #tableLaporan tbody td span {
            transition: all 0.2s ease;
        }

        #tableLaporan tbody tr:hover td span {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
