@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Daftar Desa')

@section('content')
<div class="mb-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clipboard-check text-white text-lg"></i>
                </div>
                Verifikasi Penilaian Desa
            </h2>
            <p class="text-gray-600 mt-2 flex items-center gap-2">
                <i class="bi bi-calendar-check text-blue-500"></i>
                Periode: {{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }}
            </p>
        </div>
    </div>
</div>

{{-- ================================
        🎯 FILTER FORM
    ================================= --}}
<div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl shadow-lg p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
        <!-- Tahun -->
        <div>
            <label class="block text-white text-sm font-semibold mb-2">
                <i class="bi bi-calendar3 me-1"></i>Tahun
            </label>
            <input type="number" name="tahun"
                class="w-full p-3 bg-white/90 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200"
                value="{{ request('tahun', now()->year) }}" min="2020" max="{{ now()->year }}">
        </div>

        <!-- Bulan -->
        <div>
            <label class="block text-white text-sm font-semibold mb-2">
                <i class="bi bi-calendar-month me-1"></i>Bulan
            </label>
            <select name="bulan"
                class="w-full p-3 bg-white/90 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200">
                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $b)
                <option value="{{ $b }}"
                    {{ request('bulan', now()->format('F')) === $b ? 'selected' : '' }}>
                    {{ $b }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-white text-sm font-semibold mb-2">
                <i class="bi bi-funnel me-1"></i>Status
            </label>
            <select name="status"
                class="w-full p-3 bg-white/90 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex gap-2">
            <button type="submit"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-white text-blue-900 rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                <i class="bi bi-search"></i>
                Terapkan
            </button>
            <a href="{{ route('admin.penilaian') }}"
                class="flex items-center justify-center gap-2 px-4 py-3 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-all duration-200 font-semibold">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </form>
</div>

{{-- ================================
        📈 MINI GRAFIK STATUS
    ================================= --}}
<div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6 mb-6">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <i class="bi bi-pie-chart text-blue-600 text-lg"></i>
        </div>
        <h3 class="font-bold text-xl text-gray-800">Status Penilaian Bulan Ini</h3>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
        <!-- Chart -->
        <div class="flex justify-center">
            <canvas id="chartStatus" style="max-width: 250px; max-height: 250px;"></canvas>
        </div>

        <!-- Status List -->
        <div class="space-y-3">
            <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-xl hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="font-semibold text-green-800 text-lg">Disetujui</span>
                </div>
                <span class="bg-green-600 text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalApproved ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-xl hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock text-yellow-600 text-xl"></i>
                    </div>
                    <span class="font-semibold text-yellow-800 text-lg">Menunggu</span>
                </div>
                <span class="bg-yellow-600 text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalPending ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-xl hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-x-circle text-red-600 text-xl"></i>
                    </div>
                    <span class="font-semibold text-red-800 text-lg">Ditolak</span>
                </div>
                <span class="bg-red-600 text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalRejected ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>


{{-- ================================
        🔎 SEARCH BAR
    ================================= --}}
<form method="GET" class="relative w-full lg:w-96 mb-8 flex items-center gap-2">
    <input type="hidden" name="tahun" value="{{ $tahun }}">
    <input type="hidden" name="bulan" value="{{ $bulan }}">
    <input type="hidden" name="status" value="{{ $status }}">

    <div class="relative flex-1">
        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Cari nama desa..."
            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <button
        type="submit"
        class="px-5 py-3 bg-blue-600 text-white rounded-xl
               hover:bg-blue-700 transition font-semibold flex items-center gap-2">
        <i class="bi bi-search"></i>
        Cari
    </button>
</form>



{{-- ================================
        📋 TABEL DESA (DIUBAH)
    ================================= --}}
<div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                <tr>
                    <th class="py-4 px-6 w-20">No</th>
                    <th class="py-4 px-6 text-left">Nama Desa</th>
                    <th class="py-4 px-6 text-center">Total Data</th>
                    <th class="py-4 px-6 text-center">Status Progress</th>
                    <th class="py-4 px-6 text-center w-40">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($desas as $index => $desa)
                @php
                $totalData = $desa->total_approved + $desa->total_pending + $desa->total_rejected;
                $approvedPercentage = $totalData ? ($desa->total_approved / $totalData) * 100 : 0;
                $pendingPercentage = $totalData ? ($desa->total_pending / $totalData) * 100 : 0;
                $rejectedPercentage = $totalData ? ($desa->total_rejected / $totalData) * 100 : 0;
                @endphp

                <tr class="hover:bg-blue-50 transition">
                    <td class="text-center py-4">
                        {{ $desas->firstItem() + $index }}
                    </td>

                    <td class="py-4 px-6">
                        <div class="font-semibold">{{ $desa->nama_desa }}</div>
                        <div class="text-xs text-gray-500">
                            ID: DES{{ str_pad($desa->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </td>

                    <td class="text-center py-4">
                        <span class="text-2xl font-bold text-blue-700">{{ $totalData }}</span>
                    </td>

                    <td class="py-4 px-6">
                        <div class="relative h-5 bg-gray-200 rounded-full overflow-hidden">
                            <div class="absolute h-full bg-green-500" style="width: {{ $approvedPercentage }}%"></div>
                            <div class="absolute h-full bg-yellow-500"
                                style="left: {{ $approvedPercentage }}%; width: {{ $pendingPercentage }}%"></div>
                            <div class="absolute h-full bg-red-500"
                                style="left: {{ $approvedPercentage + $pendingPercentage }}%; width: {{ $rejectedPercentage }}%"></div>
                        </div>
                    </td>

                    <td class="text-center py-4">
                        <a href="{{ route('admin.penilaian.desa', [
                            'desa' => $desa->id,
                            'tahun' => $tahun,
                            'bulan' => $bulan
                        ]) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400">
                        Tidak ada data desa ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="p-6 border-t bg-gray-50">
        {{ $desas->links() }}
        <p class="text-sm text-gray-600 mt-2">
            Menampilkan {{ $desas->firstItem() }} – {{ $desas->lastItem() }}
            dari {{ $desas->total() }} desa
        </p>
    </div>
</div>

@endsection

@section('scripts')
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ================================
        // 📊 DOUGHNUT CHART
        // ================================
        const canvas = document.getElementById('chartStatus');

        if (canvas) {
            const ctx = canvas.getContext('2d');

            const totalApproved = {
                {
                    $totalApproved ?? 0
                }
            };
            const totalPending = {
                {
                    $totalPending ?? 0
                }
            };
            const totalRejected = {
                {
                    $totalRejected ?? 0
                }
            };
            const totalData = totalApproved + totalPending + totalRejected;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Disetujui', 'Menunggu', 'Ditolak'],
                    datasets: [{
                        data: [totalApproved, totalPending, totalRejected],
                        backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                        borderWidth: 4,
                        borderColor: '#ffffff',
                        hoverOffset: 15,
                        hoverBorderWidth: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const percentage = totalData > 0 ? ((value / totalData) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                },
                plugins: [{
                    id: 'centerText',
                    beforeDraw: function(chart) {
                        const width = chart.width;
                        const height = chart.height;
                        const ctx = chart.ctx;
                        ctx.restore();

                        const fontSize = (height / 114).toFixed(2);
                        ctx.font = `bold ${fontSize}em sans-serif`;
                        ctx.textBaseline = 'middle';

                        const text = totalData.toString();
                        const textX = Math.round((width - ctx.measureText(text).width) / 2);
                        const textY = height / 2;

                        ctx.fillStyle = '#1e3a8a';
                        ctx.fillText(text, textX, textY - 10);

                        ctx.font = `${(fontSize * 0.4)}em sans-serif`;
                        ctx.fillStyle = '#64748b';
                        const subText = 'Total Data';
                        const subTextX = Math.round((width - ctx.measureText(subText).width) / 2);
                        ctx.fillText(subText, subTextX, textY + 15);

                        ctx.save();
                    }
                }]
            });
        }
    });
</script>

<style>
    /* Custom chart styling */
    #chartStatus {
        max-width: 250px;
        max-height: 250px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        #chartStatus {
            max-width: 200px;
            max-height: 200px;
        }
    }

    @media (max-width: 480px) {
        #chartStatus {
            max-width: 180px;
            max-height: 180px;
        }
    }

    /* Progress Bar Styling */
    .relative.h-6.bg-gray-200 {
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .relative.h-6.bg-gray-200 div[class*="absolute h-full"] {
        transition: all 0.3s ease;
        transform-origin: center;
    }

    /* Status indicator circles */
    .w-3.h-3.rounded-full {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    /* Table row hover effect */
    #tableDesa tbody tr:hover {
        background-color: #f0f7ff;
    }

    #tableDesa tbody tr:hover .relative.h-6.bg-gray-200 {
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Smooth transitions for table */
    #tableDesa tbody tr {
        transition: all 0.3s ease;
    }

    /* Animation for newly shown rows */
    #tableDesa tbody tr.data-row {
        opacity: 1;
        transition: opacity 0.5s ease;
    }

    /* Load More Button Animation */
    #loadMoreBtn:hover {
        transform: translateY(-2px);
    }

    #loadMoreBtn:active {
        transform: translateY(0);
    }

    /* Custom scrollbar for table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #tableDesa {
            font-size: 0.875rem;
        }

        #tableDesa th,
        #tableDesa td {
            padding: 0.75rem 0.5rem;
        }

        #tableDesa tbody td .flex.flex-col.gap-3 {
            gap: 0.5rem;
        }

        #tableDesa tbody td .relative.h-6 {
            height: 1rem;
        }
    }
</style>
@endsection