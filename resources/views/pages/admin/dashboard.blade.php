@extends('layouts.adminLayout')
@section('title', 'Dashboard Admin | SIPANDAKABULAN')

@section('content')
    <div class="space-y-6">



        {{-- ===========================
        STATISTIC CARDS
    ============================ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">

            <div
                class="bg-gradient-to-br from-blue-900 to-blue-700 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium flex items-center gap-1">
                            <i class="bi bi-house-door"></i>
                            Total Desa
                        </p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalDesa }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="bi bi-building text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-blue-800 to-blue-600 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium flex items-center gap-1">
                            <i class="bi bi-people"></i>
                            User Desa
                        </p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalUserDesa }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="bi bi-person-check text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-blue-700 to-blue-500 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium flex items-center gap-1">
                            <i class="bi bi-clipboard-data"></i>
                            Total Penilaian
                        </p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalPenilaian }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="bi bi-bar-chart-line text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-green-600 to-green-400 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium flex items-center gap-1">
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalApprovedThisMonth }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="bi bi-check-lg text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-yellow-600 to-yellow-400 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium flex items-center gap-1">
                            <i class="bi bi-clock-history"></i>
                            Pending
                        </p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalPendingThisMonth }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="bi bi-hourglass-split text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-red-600 to-red-400 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium flex items-center gap-1">
                            <i class="bi bi-x-circle-fill"></i>
                            Rejected
                        </p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalRejectedThisMonth }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="bi bi-x-lg text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>


        {{-- ===========================
        FILTER TAHUN & BULAN
    ============================ --}}
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 border border-blue-800 rounded-2xl shadow-lg p-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-white mb-2">
                        <i class="bi bi-calendar3 mr-2 text-blue-200"></i>
                        Tahun
                    </label>
                    <select name="tahun"
                        class="w-full p-3 bg-white/90 border border-blue-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200">
                        @for ($i = now()->year; $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-semibold text-white mb-2">
                        <i class="bi bi-calendar-month mr-2 text-blue-200"></i>
                        Bulan
                    </label>
                    <select name="bulan"
                        class="w-full p-3 bg-white/90 border border-blue-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200">
                        @foreach ($monthsOrder as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ $m }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button
                    class="flex items-center gap-2 px-6 py-3 bg-white text-blue-900 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 hover:bg-blue-50">
                    <i class="bi bi-funnel-fill"></i>
                    Terapkan Filter
                </button>
            </form>
        </div>


        {{-- ===========================
        CHARTS AREA
    ============================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Doughnut: Status Bulan Ini --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-pie-chart-fill text-white"></i>
                    </div>
                    <h2 class="font-bold text-xl text-gray-800">Status Penilaian (Bulan {{ $bulan }}
                        {{ $tahun }})</h2>
                </div>
                <canvas id="chartStatus" height="220"></canvas>
            </div>

            {{-- Line: Tahun --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-graph-up text-white"></i>
                    </div>
                    <h2 class="font-bold text-xl text-gray-800">Trend Penilaian Tahun {{ $tahun }}</h2>
                </div>
                <canvas id="chartLine" height="220"></canvas>
            </div>
        </div>


        {{-- ===========================
        BAR KLASTER
    ============================ --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100">
            <div class="flex items-center gap-3 mb-4">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                    <i class="bi bi-bar-chart-line text-white"></i>
                </div>
                <h2 class="font-bold text-xl text-gray-800">Rata-Rata Nilai per Klaster</h2>
            </div>
            <canvas id="chartKlaster" height="120"></canvas>
        </div>


        {{-- ===========================
        TOP DESA & PENDING
    ============================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Top Desa --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-trophy-fill text-white"></i>
                    </div>
                    <h2 class="font-bold text-xl text-gray-800">Top 5 Desa Nilai Tertinggi</h2>
                </div>

                <div class="space-y-3">
                    @foreach ($topDesa as $index => $d)
                        <div
                            class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-white rounded-xl border border-blue-200 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-blue-900 to-blue-700 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $d->nama_desa }}</span>
                            </div>
                            <span class="font-bold text-lg text-blue-900">{{ $d->rata }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pending --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100">
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle-fill text-white"></i>
                    </div>
                    <h2 class="font-bold text-xl text-gray-800">Desa Pending Terbanyak</h2>
                </div>

                <div class="space-y-3">
                    @foreach ($pendingDesa as $index => $d)
                        <div
                            class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-white rounded-xl border border-blue-200 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-blue-900 to-blue-700 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                </div>
                                <span class="font-medium text-gray-800">{{ $d->nama_desa }}</span>
                            </div>
                            <span class="font-bold text-lg text-blue-900">{{ $d->total_pending }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        {{-- ===========================
        AKTIVITAS
    ============================ --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100">
            <div class="flex items-center gap-3 mb-4">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                    <i class="bi bi-activity text-white"></i>
                </div>
                <h2 class="font-bold text-xl text-gray-800">Aktivitas Terbaru</h2>
            </div>

            <div class="space-y-4">
                @forelse ($aktivitas as $a)
                    <div
                        class="flex items-start gap-4 p-4 border border-blue-200 rounded-xl hover:bg-blue-50 transition-all duration-200">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-pencil-square text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800">
                                <span class="font-semibold text-blue-900">{{ $a->desa->nama_desa }}</span>
                                mengisi indikator <span
                                    class="font-semibold text-gray-900">{{ $a->indikator->judul }}</span>
                                <span class="text-gray-600">({{ $a->klaster->title }})</span>
                            </p>
                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                <i class="bi bi-clock"></i>
                                {{ $a->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-3 opacity-50"></i>
                        <p class="italic">Tidak ada aktivitas terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection


{{-- ===========================
    CHART JS
=========================== --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // DOUGHNUT (bulanan)
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Pending', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $totalApprovedThisMonth }},
                        {{ $totalPendingThisMonth }},
                        {{ $totalRejectedThisMonth }}
                    ],
                    backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                    borderWidth: 0,
                    borderRadius: 8
                }]
            },
            options: {
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });

        // LINE (1 tahun)
        new Chart(document.getElementById('chartLine'), {
            type: 'line',
            data: {
                labels: @json($monthsOrder),
                datasets: [{
                    label: 'Total Penilaian',
                    data: @json($trendYear),
                    borderWidth: 3,
                    tension: 0.4,
                    backgroundColor: 'rgba(30, 58, 138, 0.1)',
                    borderColor: '#1e3a8a',
                    fill: true,
                    pointBackgroundColor: '#1e3a8a',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // BAR (klaster)
        new Chart(document.getElementById('chartKlaster'), {
            type: 'bar',
            data: {
                labels: @json($klasterLabels),
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: @json($klasterData),
                    backgroundColor: 'rgba(30, 58, 138, 0.7)',
                    borderColor: '#1e3a8a',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection
