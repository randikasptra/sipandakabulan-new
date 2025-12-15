@extends('layouts.adminLayout')
@section('title', 'Laporan Penilaian Desa')

@section('content')
    @php
        $tahun = $tahun ?? now()->year;
        $totalAllData = $totalApproved + $totalPending + $totalRejected;
        $completionPercentage = $totalAllData > 0 ? round(($totalApproved / $totalAllData) * 100, 1) : 0;
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
                    <div class="flex flex-col">
                        <span>Laporan Penilaian Desa</span>
                        <span class="text-sm font-normal text-gray-600 mt-1">
                            Periode: {{ $bulan }} {{ $tahun }}
                        </span>
                    </div>
                </h2>
            </div>

            <!-- Export Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.exportExcel', ['tahun' => $tahun, 'bulan' => $bulan]) }}"
                    class="inline-flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>
                <a href="{{ route('admin.laporan.exportPdf', ['tahun' => $tahun, 'bulan' => $bulan]) }}"
                    class="inline-flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
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

    <!-- Overall Progress -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="bi bi-speedometer2 text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white text-xl">Progress Verifikasi Keseluruhan</h3>
                    <p class="text-white/80 text-sm">Status penyelesaian semua desa</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-white">{{ $completionPercentage }}%</div>
                <div class="text-white/80 text-sm">Completion Rate</div>
            </div>
        </div>
        
        <!-- Overall Progress Bar -->
        <div class="relative h-6 bg-white/20 rounded-full overflow-hidden mb-4">
            <div class="absolute h-full bg-green-400 rounded-full" 
                 style="width: {{ $completionPercentage }}%">
            </div>
            <div class="absolute h-full bg-yellow-400" 
                 style="left: {{ $completionPercentage }}%; width: {{ $pendingPercentage = $totalAllData > 0 ? round(($totalPending / $totalAllData) * 100, 1) : 0 }}%">
            </div>
            <div class="absolute h-full bg-red-400" 
                 style="left: {{ $completionPercentage + $pendingPercentage }}%; width: {{ $rejectedPercentage = $totalAllData > 0 ? round(($totalRejected / $totalAllData) * 100, 1) : 0 }}%">
            </div>
        </div>
        
        <!-- Stats Detail -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Total Data</p>
                        <p class="text-2xl font-bold text-white">{{ $totalAllData }}</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="bi bi-database text-white text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Telah Disetujui</p>
                        <p class="text-2xl font-bold text-white">{{ $totalApproved }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-300 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Belum Selesai</p>
                        <p class="text-2xl font-bold text-white">{{ $totalPending + $totalRejected }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock text-yellow-300 text-lg"></i>
                    </div>
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
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">
                            <i class="bi bi-database mr-2"></i>Total<br />Data
                        </th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-graph-up mr-2"></i>Status Progress
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
                        @php
                            $totalDesaData = $desa->total_approved + $desa->total_pending + $desa->total_rejected;
                            $approvedPercentage = $totalDesaData > 0 ? round(($desa->total_approved / $totalDesaData) * 100, 1) : 0;
                            $pendingPercentage = $totalDesaData > 0 ? round(($desa->total_pending / $totalDesaData) * 100, 1) : 0;
                            $rejectedPercentage = $totalDesaData > 0 ? round(($desa->total_rejected / $totalDesaData) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-blue-50 transition-all duration-200 data-row">
                            <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap text-center">
                                {{ $i + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800 text-sm lg:text-base">{{ $desa->nama_desa }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    ID: DES{{ str_pad($desa->id, 4, '0', STR_PAD_LEFT) }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex flex-col items-center justify-center">
                                    <span class="text-2xl font-bold text-blue-700">
                                        {{ $totalDesaData }}
                                    </span>
                                    <span class="text-xs text-gray-500 mt-1">Data</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col gap-3">
                                    <!-- Progress Bar -->
                                    <div class="relative h-4 bg-gray-200 rounded-full overflow-hidden">
                                        @if($totalDesaData > 0)
                                            <div class="absolute h-full bg-green-500 rounded-l-full" 
                                                 style="width: {{ $approvedPercentage }}%"
                                                 title="Disetujui: {{ $desa->total_approved }} ({{ $approvedPercentage }}%)">
                                            </div>
                                            <div class="absolute h-full bg-yellow-500" 
                                                 style="left: {{ $approvedPercentage }}%; width: {{ $pendingPercentage }}%"
                                                 title="Menunggu: {{ $desa->total_pending }} ({{ $pendingPercentage }}%)">
                                            </div>
                                            <div class="absolute h-full bg-red-500 rounded-r-full" 
                                                 style="left: {{ $approvedPercentage + $pendingPercentage }}%; width: {{ $rejectedPercentage }}%"
                                                 title="Ditolak: {{ $desa->total_rejected }} ({{ $rejectedPercentage }}%)">
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-xs text-gray-500">Belum ada data</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Detail Count -->
                                    <div class="flex justify-between text-xs">
                                        <div class="flex items-center gap-1">
                                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                            <span class="font-semibold text-green-700">{{ $desa->total_approved }}</span>
                                            <span class="text-gray-600">Disetujui</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                            <span class="font-semibold text-yellow-700">{{ $desa->total_pending }}</span>
                                            <span class="text-gray-600">Menunggu</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                            <span class="font-semibold text-red-700">{{ $desa->total_rejected }}</span>
                                            <span class="text-gray-600">Ditolak</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center min-w-[4rem] bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-3 rounded-xl text-lg font-bold shadow-md">
                                        {{ number_format($desa->rata_rata ?? 0, 1) }}
                                    </span>
                                    <div class="text-xs text-gray-600 mt-1">
                                        @if(($desa->rata_rata ?? 0) >= 80)
                                            <span class="text-green-600 font-semibold flex items-center gap-1">
                                                <i class="bi bi-trophy"></i> Excellent
                                            </span>
                                        @elseif(($desa->rata_rata ?? 0) >= 60)
                                            <span class="text-blue-600 font-semibold flex items-center gap-1">
                                                <i class="bi bi-check-circle"></i> Good
                                            </span>
                                        @elseif(($desa->rata_rata ?? 0) > 0)
                                            <span class="text-yellow-600 font-semibold flex items-center gap-1">
                                                <i class="bi bi-exclamation-triangle"></i> Needs Improvement
                                            </span>
                                        @else
                                            <span class="text-gray-500">No Data</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('admin.laporan.desa', ['desa' => $desa->id, 'tahun' => $tahun, 'bulan' => $bulan]) }}"
                                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
                                        <i class="bi bi-eye"></i>
                                        Lihat Detail
                                    </a>
                                    @if($desa->total_pending > 0)
                                        <div class="text-xs text-yellow-600 font-medium">
                                            <i class="bi bi-clock"></i> {{ $desa->total_pending }} menunggu
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
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
                        backgroundColor: function(context) {
                            const value = context.raw || 0;
                            if (value >= 80) return 'rgba(34, 197, 94, 0.8)'; // Green
                            if (value >= 60) return 'rgba(59, 130, 246, 0.8)'; // Blue
                            if (value > 0) return 'rgba(234, 179, 8, 0.8)'; // Yellow
                            return 'rgba(209, 213, 219, 0.8)'; // Gray
                        },
                        borderColor: function(context) {
                            const value = context.raw || 0;
                            if (value >= 80) return 'rgb(34, 197, 94)';
                            if (value >= 60) return 'rgb(59, 130, 246)';
                            if (value > 0) return 'rgb(234, 179, 8)';
                            return 'rgb(209, 213, 219)';
                        },
                        borderWidth: 2,
                        borderRadius: 6,
                        hoverBackgroundColor: function(context) {
                            const value = context.raw || 0;
                            if (value >= 80) return 'rgba(34, 197, 94, 0.9)';
                            if (value >= 60) return 'rgba(59, 130, 246, 0.9)';
                            if (value > 0) return 'rgba(234, 179, 8, 0.9)';
                            return 'rgba(209, 213, 219, 0.9)';
                        }
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
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw || 0;
                                    let status = '';
                                    if (value >= 80) status = ' (Excellent)';
                                    else if (value >= 60) status = ' (Good)';
                                    else if (value > 0) status = ' (Needs Improvement)';
                                    else status = ' (No Data)';
                                    
                                    return `Nilai: ${value.toFixed(1)}${status}`;
                                }
                            }
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

            // Progress bar hover effects
            const progressBars = document.querySelectorAll('.relative.h-4.bg-gray-200');
            
            progressBars.forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    const segments = this.querySelectorAll('div[class*="absolute h-full"]');
                    segments.forEach(segment => {
                        segment.style.filter = 'brightness(1.2)';
                        segment.style.transform = 'scaleY(1.2)';
                    });
                });
                
                bar.addEventListener('mouseleave', function() {
                    const segments = this.querySelectorAll('div[class*="absolute h-full"]');
                    segments.forEach(segment => {
                        segment.style.filter = 'brightness(1)';
                        segment.style.transform = 'scaleY(1)';
                    });
                });
            });
        });
    </script>

    <style>
        /* Progress Bar Styling */
        .relative.h-4.bg-gray-200 {
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .relative.h-4.bg-gray-200 div[class*="absolute h-full"] {
            transition: all 0.3s ease;
            transform-origin: center;
        }

        /* Status indicator circles */
        .w-3.h-3.rounded-full {
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        /* Table row hover effect */
        #tableLaporan tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #tableLaporan tbody tr:hover {
            background-color: #f0f7ff;
        }

        #tableLaporan tbody tr:hover .relative.h-4.bg-gray-200 {
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.15);
        }

        /* Score badge gradient */
        .bg-gradient-to-r.from-blue-600.to-blue-500 {
            transition: all 0.3s ease;
        }

        #tableLaporan tbody tr:hover .bg-gradient-to-r.from-blue-600.to-blue-500 {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #tableLaporan {
                font-size: 0.75rem;
            }

            #tableLaporan th,
            #tableLaporan td {
                padding: 0.5rem 0.25rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }

            .flex.flex-col.gap-3 {
                gap: 0.5rem;
            }

            .flex.justify-between.text-xs {
                flex-direction: column;
                gap: 0.25rem;
                align-items: flex-start;
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
    </style>
@endsection