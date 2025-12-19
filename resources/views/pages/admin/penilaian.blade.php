@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Daftar Desa')

@section('content')
<div class="space-y-6">

    {{-- ================================
            📌 HEADER SECTION
        ================================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="fade-in">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-900 to-blue-700 rounded-xl flex items-center justify-center shadow-lg transform hover:rotate-12 transition-transform duration-300">
                    <i data-lucide="clipboard-check" class="text-white w-6 h-6"></i>
                </div>
                Verifikasi Penilaian Desa
            </h2>
            <p class="text-gray-600 mt-2 flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4 text-blue-500"></i>
                Periode: <span class="font-semibold text-blue-600">{{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }}</span>
            </p>
        </div>
    </div>

    {{-- ================================
            🎯 FILTER FORM
        ================================= --}}
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl shadow-lg p-6 slide-in-up">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <!-- Tahun -->
            <div class="form-group">
                <label class="block text-white text-sm font-semibold mb-2">
                    <i data-lucide="calendar" class="w-4 h-4 inline-block mr-1"></i>Tahun
                </label>
                <input type="number" name="tahun"
                    class="w-full p-3 bg-white/95 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 hover:bg-white"
                    value="{{ request('tahun', now()->year) }}" min="2020" max="{{ now()->year }}">
            </div>

            <!-- Bulan -->
            <div class="form-group">
                <label class="block text-white text-sm font-semibold mb-2">
                    <i data-lucide="calendar-days" class="w-4 h-4 inline-block mr-1"></i>Bulan
                </label>
                <select name="bulan"
                    class="w-full p-3 bg-white/95 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 hover:bg-white">
                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $b)
                    <option value="{{ $b }}" {{ request('bulan', now()->format('F')) === $b ? 'selected' : '' }}>
                        {{ $b }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label class="block text-white text-sm font-semibold mb-2">
                    <i data-lucide="filter" class="w-4 h-4 inline-block mr-1"></i>Status
                </label>
                <select name="status"
                    class="w-full p-3 bg-white/95 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 hover:bg-white">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Tombol -->
            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-white text-blue-900 rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 font-semibold active:scale-95">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    Terapkan
                </button>
                <a href="{{ route('admin.penilaian') }}"
                    class="flex items-center justify-center px-4 py-3 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-all duration-200 font-semibold active:scale-95"
                    title="Reset Filter">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- ================================
            📈 MINI GRAFIK STATUS
        ================================= --}}
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6 slide-in-up" style="animation-delay: 0.1s;">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i data-lucide="pie-chart" class="text-blue-600 w-5 h-5"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800">Status Penilaian Bulan Ini</h3>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Chart -->
            <div class="flex justify-center">
                <div class="relative" style="width: 280px; height: 280px;">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>

            <!-- Status List (SELALU TAMPILKAN KETIGA CARD) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-green-50 border-2 border-green-200 rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-md">
                            <i data-lucide="check-circle" class="text-white w-6 h-6"></i>
                        </div>
                        <span class="font-semibold text-green-800 text-lg">Disetujui</span>
                    </div>
                    <span class="bg-green-600 text-white px-5 py-2 rounded-full text-xl font-bold min-w-[4rem] text-center shadow-md">
                        {{ $totalApproved ?? 0 }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center shadow-md">
                            <i data-lucide="clock" class="text-white w-6 h-6"></i>
                        </div>
                        <span class="font-semibold text-yellow-800 text-lg">Menunggu</span>
                    </div>
                    <span class="bg-yellow-600 text-white px-5 py-2 rounded-full text-xl font-bold min-w-[4rem] text-center shadow-md">
                        {{ $totalPending ?? 0 }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-4 bg-red-50 border-2 border-red-200 rounded-xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center shadow-md">
                            <i data-lucide="x-circle" class="text-white w-6 h-6"></i>
                        </div>
                        <span class="font-semibold text-red-800 text-lg">Ditolak</span>
                    </div>
                    <span class="bg-red-600 text-white px-5 py-2 rounded-full text-xl font-bold min-w-[4rem] text-center shadow-md">
                        {{ $totalRejected ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================
            🔎 SEARCH BAR
        ================================= --}}
    <form method="GET" class="slide-in-up" style="animation-delay: 0.2s;">
        <input type="hidden" name="tahun" value="{{ $tahun }}">
        <input type="hidden" name="bulan" value="{{ $bulan }}">
        <input type="hidden" name="status" value="{{ $status }}">

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama desa..."
                    class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-300">
            </div>

            <button type="submit"
                class="px-6 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl active:scale-95">
                <i data-lucide="search" class="w-5 h-5"></i>
                Cari Desa
            </button>
        </div>
    </form>

    {{-- ================================
            📋 TABEL DESA
        ================================= --}}
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden slide-in-up" style="animation-delay: 0.3s;">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-center font-semibold w-20">No</th>
                        <th class="py-4 px-6 text-left font-semibold">Nama Desa</th>
                        <th class="py-4 px-6 text-center font-semibold">Total Data</th>
                        <th class="py-4 px-6 text-center font-semibold">Status Progress</th>
                        <th class="py-4 px-6 text-center font-semibold w-40">Aksi</th>
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

                    <tr class="table-row hover:bg-blue-50/50 transition-all duration-200" style="animation-delay: {{ $index * 0.05 }}s;">
                        <td class="text-center py-4 px-6">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-full font-semibold text-sm">
                                {{ $desas->firstItem() + $index }}
                            </span>
                        </td>

                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-500 rounded-lg flex items-center justify-center shadow-md">
                                    <i data-lucide="building-2" class="text-white w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $desa->nama_desa }}</div>
                                    <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                        <i data-lucide="hash" class="w-3 h-3"></i>
                                        DES{{ str_pad($desa->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="text-center py-4 px-6">
                            <span class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full font-bold text-lg">
                                {{ $totalData }}
                            </span>
                        </td>

                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                <!-- Progress Bar -->
                                <div class="relative h-6 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                                    <div class="absolute h-full bg-gradient-to-r from-green-500 to-green-400 transition-all duration-500" 
                                         style="width: {{ $approvedPercentage }}%"></div>
                                    <div class="absolute h-full bg-gradient-to-r from-yellow-500 to-yellow-400 transition-all duration-500"
                                         style="left: {{ $approvedPercentage }}%; width: {{ $pendingPercentage }}%"></div>
                                    <div class="absolute h-full bg-gradient-to-r from-red-500 to-red-400 transition-all duration-500"
                                         style="left: {{ $approvedPercentage + $pendingPercentage }}%; width: {{ $rejectedPercentage }}%"></div>
                                </div>
                                
                                <!-- Legend -->
                                <div class="flex gap-3 text-xs justify-center">
                                    <span class="flex items-center gap-1">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        {{ number_format($approvedPercentage, 0) }}%
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                        {{ number_format($pendingPercentage, 0) }}%
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        {{ number_format($rejectedPercentage, 0) }}%
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="text-center py-4 px-6">
                            <a href="{{ route('admin.penilaian.desa', [
                                'desa' => $desa->id,
                                'tahun' => $tahun,
                                'bulan' => $bulan
                            ]) }}"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg active:scale-95">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Tidak ada data desa ditemukan</p>
                                <p class="text-sm text-gray-400">Coba ubah filter atau kata kunci pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($desas->hasPages())
        <div class="p-6 border-t bg-gray-50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-semibold text-blue-600">{{ $desas->firstItem() }}</span> – 
                    <span class="font-semibold text-blue-600">{{ $desas->lastItem() }}</span>
                    dari <span class="font-semibold text-blue-600">{{ $desas->total() }}</span> desa
                </p>
                {{ $desas->links() }}
            </div>
        </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // ================================
    // 📊 DOUGHNUT CHART (Dengan perbaikan untuk nilai 0)
    // ================================
    const canvas = document.getElementById('chartStatus');
    if (canvas && typeof Chart !== 'undefined') {
        const ctx = canvas.getContext('2d');

        const totalApproved = {{ $totalApproved ?? 0 }};
        const totalPending  = {{ $totalPending ?? 0 }};
        const totalRejected = {{ $totalRejected ?? 0 }};
        const totalData = totalApproved + totalPending + totalRejected;

        // Data untuk chart: beri nilai sangat kecil jika 0 agar segmen tetap terlihat tipis
        const chartData = totalData > 0 
            ? [totalApproved || 0.001, totalPending || 0.001, totalRejected || 0.001]
            : [1, 1, 1]; // fallback kalau belum ada data sama sekali

        // Warna tetap sama
        const backgroundColors = totalData > 0 
            ? ['#22c55e', '#eab308', '#ef4444']
            : ['#94a3b8', '#94a3b8', '#94a3b8']; // abu-abu kalau kosong

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Disetujui', 'Menunggu', 'Ditolak'],
                datasets: [{
                    data: chartData,
                    backgroundColor: backgroundColors,
                    borderWidth: 6,
                    borderColor: '#ffffff',
                    hoverOffset: 20,
                    hoverBorderWidth: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        padding: 16,
                        cornerRadius: 12,
                        titleFont: { size: 15, weight: 'bold' },
                        bodyFont: { size: 14 },
                        callbacks: {
                            label: function(context) {
                                const originalValues = [totalApproved, totalPending, totalRejected];
                                const value = originalValues[context.dataIndex] || 0;
                                const percentage = totalData > 0 ? ((value / totalData) * 100).toFixed(1) : '0.0';
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1200,
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

                    const fontSize = (height / 100).toFixed(2);
                    ctx.font = `bold ${fontSize}em sans-serif`;
                    ctx.textBaseline = 'middle';

                    const text = totalData.toString();
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2 - 10;

                    ctx.fillStyle = totalData > 0 ? '#1e3a8a' : '#64748b';
                    ctx.fillText(text, textX, textY);

                    ctx.font = `${(fontSize * 0.35)}em sans-serif`;
                    ctx.fillStyle = '#64748b';
                    const subText = 'Total Data';
                    const subTextX = Math.round((width - ctx.measureText(subText).width) / 2);
                    ctx.fillText(subText, subTextX, textY + 25);

                    ctx.save();
                }
            }]
        });
    }

    // ================================
    // 🎨 TABLE ROW ANIMATIONS
    // ================================
    const tableRows = document.querySelectorAll('.table-row');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    tableRows.forEach(row => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = 'all 0.5s ease';
        observer.observe(row);
    });
});
</script>

<style>
/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes slideInUp {
    0%   { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

.fade-in { animation: fadeIn 0.6s ease-out forwards; }
.slide-in-up { animation: slideInUp 0.6s ease-out forwards; opacity: 0; }

/* Form group animation */
.form-group {
    animation: slideInUp 0.5s ease-out forwards;
    opacity: 0;
}
.form-group:nth-child(1) { animation-delay: 0s; }
.form-group:nth-child(2) { animation-delay: 0.1s; }
.form-group:nth-child(3) { animation-delay: 0.2s; }

/* Chart hover */
#chartStatus { transition: transform 0.3s ease; }
#chartStatus:hover { transform: scale(1.02); }

/* Progress bar */
.relative.h-6 > div { transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1); }

/* Table */
table tbody tr { transition: all 0.3s ease; }
table tbody tr:hover { background-color: rgba(239, 246, 255, 0.6); transform: scale(1.01); }

/* Scrollbar */
.overflow-x-auto::-webkit-scrollbar { height: 10px; }
.overflow-x-auto::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
.overflow-x-auto::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 10px; }
.overflow-x-auto::-webkit-scrollbar-thumb:hover { background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); }

@media (max-width: 768px) {
    table { font-size: 0.875rem; }
    table th, table td { padding: 0.75rem 0.5rem; }
    #chartStatus { max-width: 220px; max-height: 220px; }
}

@media (max-width: 480px) {
    #chartStatus { max-width: 200px; max-height: 200px; }
}
</style>
@endsection