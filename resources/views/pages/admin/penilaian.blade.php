@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Daftar Desa')

@section('content')
<div class="mb-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
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
                <option value="{{ $b }}" {{ request('bulan', now()->format('F')) === $b ? 'selected' : '' }}>
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
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
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

        <!-- Status List - GUNAKAN CLASS CUSTOM DENGAN WARNA YANG SAMA -->
        <div class="space-y-3" id="statusList" data-permanent="true">
            <div class="flex items-center justify-between p-4 status-success-bg border rounded-xl hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 status-success-icon-bg rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle status-success-icon text-xl"></i>
                    </div>
                    <span class="font-semibold status-success-text text-lg">Disetujui</span>
                </div>
                <span class="status-success-badge text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalApproved ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between p-4 status-pending-bg border rounded-xl hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 status-pending-icon-bg rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock status-pending-icon text-xl"></i>
                    </div>
                    <span class="font-semibold status-pending-text text-lg">Menunggu</span>
                </div>
                <span class="status-pending-badge text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalPending ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between p-4 status-rejected-bg border rounded-xl hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 status-rejected-icon-bg rounded-lg flex items-center justify-center">
                        <i class="bi bi-x-circle status-rejected-icon text-xl"></i>
                    </div>
                    <span class="font-semibold status-rejected-text text-lg">Ditolak</span>
                </div>
                <span class="status-rejected-badge text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalRejected ?? 0 }}</span>
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
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama desa..."
            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <button type="submit"
        class="px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center gap-2">
        <i class="bi bi-search"></i>
        Cari
    </button>
</form>

{{-- ================================
        📋 TABEL DESA
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
                        <div class="relative h-5 bg-gray-200 rounded-full overflow-hidden" data-permanent="true">
                            <div class="absolute h-full progress-success transition-all duration-500 ease-out" style="width: {{ $approvedPercentage }}%"></div>
                            <div class="absolute h-full progress-pending transition-all duration-500 ease-out"
                                style="left: {{ $approvedPercentage }}%; width: {{ $pendingPercentage }}%"></div>
                            <div class="absolute h-full progress-rejected transition-all duration-500 ease-out"
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ================================
        // 📊 DOUGHNUT CHART
        // ================================
        const canvas = document.getElementById('chartStatus');

        if (canvas) {
            const ctx = canvas.getContext('2d');

            // Data dari backend
            const totalApproved = {{ $totalApproved ?? 0 }};
            const totalPending = {{ $totalPending ?? 0 }};
            const totalRejected = {{ $totalRejected ?? 0 }};
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
                        hoverOffset: 8,
                        hoverBorderWidth: 4
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
                        duration: 800,
                        easing: 'easeOutQuart'
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
    /* ================================
       🎨 CUSTOM COLOR VARIABLES
       Menggunakan warna yang sama dengan Tailwind original
       tapi dengan nama class custom untuk menghindari auto-hide
    ================================= */
    :root {
        /* Status Success Colors - sama dengan green */
        --status-success-50: #f0fdf4;
        --status-success-100: #dcfce7;
        --status-success-200: #bbf7d0;
        --status-success-500: #22c55e;
        --status-success-600: #16a34a;
        --status-success-800: #166534;

        /* Status Pending Colors - sama dengan yellow */
        --status-pending-50: #fefce8;
        --status-pending-100: #fef9c3;
        --status-pending-200: #fef08a;
        --status-pending-500: #eab308;
        --status-pending-600: #ca8a04;
        --status-pending-800: #854d0e;

        /* Status Rejected Colors - sama dengan red */
        --status-rejected-50: #fef2f2;
        --status-rejected-100: #fee2e2;
        --status-rejected-200: #fecaca;
        --status-rejected-500: #ef4444;
        --status-rejected-600: #dc2626;
        --status-rejected-800: #991b1b;
    }

    /* Status Card Backgrounds */
    .status-success-bg {
        background-color: var(--status-success-50);
        border-color: var(--status-success-200);
    }

    .status-success-icon-bg {
        background-color: var(--status-success-100);
    }

    .status-success-icon {
        color: var(--status-success-600);
    }

    .status-success-text {
        color: var(--status-success-800);
    }

    .status-success-badge {
        background-color: var(--status-success-600);
    }

    .status-pending-bg {
        background-color: var(--status-pending-50);
        border-color: var(--status-pending-200);
    }

    .status-pending-icon-bg {
        background-color: var(--status-pending-100);
    }

    .status-pending-icon {
        color: var(--status-pending-600);
    }

    .status-pending-text {
        color: var(--status-pending-800);
    }

    .status-pending-badge {
        background-color: var(--status-pending-600);
    }

    .status-rejected-bg {
        background-color: var(--status-rejected-50);
        border-color: var(--status-rejected-200);
    }

    .status-rejected-icon-bg {
        background-color: var(--status-rejected-100);
    }

    .status-rejected-icon {
        color: var(--status-rejected-600);
    }

    .status-rejected-text {
        color: var(--status-rejected-800);
    }

    .status-rejected-badge {
        background-color: var(--status-rejected-600);
    }

    /* Progress Bar Colors */
    .progress-success {
        background-color: var(--status-success-500);
    }

    .progress-pending {
        background-color: var(--status-pending-500);
    }

    .progress-rejected {
        background-color: var(--status-rejected-500);
    }

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
    .relative.h-5.bg-gray-200 {
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Table row hover effect */
    table tbody tr:hover {
        background-color: #f0f7ff;
    }

    /* Smooth transitions for table */
    table tbody tr {
        transition: background-color 0.2s ease;
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
        table {
            font-size: 0.875rem;
        }

        table th,
        table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>
@endsection