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
                <canvas id="chartStatus" height="200"></canvas>
            </div>

            <!-- Status List -->
            <div class="space-y-3">
                <div
                    class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-xl hover:shadow-md transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="bi bi-check-circle text-green-600 text-xl"></i>
                        </div>
                        <span class="font-semibold text-green-800 text-lg">Disetujui</span>
                    </div>
                    <span
                        class="bg-green-600 text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalApproved ?? 0 }}</span>
                </div>

                <div
                    class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-xl hover:shadow-md transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="bi bi-clock text-yellow-600 text-xl"></i>
                        </div>
                        <span class="font-semibold text-yellow-800 text-lg">Menunggu</span>
                    </div>
                    <span
                        class="bg-yellow-600 text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalPending ?? 0 }}</span>
                </div>

                <div
                    class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-xl hover:shadow-md transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="bi bi-x-circle text-red-600 text-xl"></i>
                        </div>
                        <span class="font-semibold text-red-800 text-lg">Ditolak</span>
                    </div>
                    <span
                        class="bg-red-600 text-white px-4 py-2 rounded-full text-lg font-bold min-w-[3rem] text-center">{{ $totalRejected ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================
        🔎 SEARCH BAR
    ================================= --}}
    <div class="flex justify-end mb-4">
        <div class="relative w-full lg:w-96">
            <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="searchDesa"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                placeholder="Cari nama desa...">
        </div>
    </div>

    {{-- ================================
        📋 TABEL DESA
    ================================= --}}
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tableDesa" class="w-full">
                <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold rounded-tl-2xl whitespace-nowrap w-20">
                            No
                        </th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-building mr-2"></i>Nama Desa
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">
                            <i class="bi bi-check-circle mr-2"></i>Disetujui
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">
                            <i class="bi bi-clock mr-2"></i>Menunggu
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">
                            <i class="bi bi-x-circle mr-2"></i>Ditolak
                        </th>
                        <th class="py-4 px-6 text-center font-semibold rounded-tr-2xl whitespace-nowrap w-40">
                            <i class="bi bi-eye mr-2"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $filteredDesas = [];
                        $currentIndex = 0;
                    @endphp

                    @forelse ($desas as $i => $desa)
                        @php
                            $status = request('status');
                            $show = true;
                            if ($status === 'pending' && $desa->total_pending == 0) {
                                $show = false;
                            }
                            if ($status === 'approved' && $desa->total_approved == 0) {
                                $show = false;
                            }
                            if ($status === 'rejected' && $desa->total_rejected == 0) {
                                $show = false;
                            }

                            if ($show) {
                                $filteredDesas[] = $desa;
                            }
                        @endphp
                    @empty
                    @endforelse

                    @if (count($filteredDesas) > 0)
                        @foreach ($filteredDesas as $index => $desa)
                            <tr class="hover:bg-blue-50 transition-all duration-200 data-row {{ $index >= 20 ? 'hidden' : '' }}"
                                data-index="{{ $index }}">
                                <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-gray-800 text-sm lg:text-base">{{ $desa->nama_desa }}
                                    </div>
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
                                    <a href="{{ route('admin.penilaian.desa', [
                                        'desa' => $desa->id,
                                        'tahun' => request('tahun'),
                                        'bulan' => request('bulan'),
                                    ]) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
                                        <i class="bi bi-eye"></i>
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="bi bi-inbox text-5xl mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada data desa ditemukan</p>
                                    <p class="text-sm mt-1">Coba ubah filter atau periode waktu</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Load More Button -->
        @if (count($filteredDesas) > 20)
            <div class="border-t border-gray-200 p-6 text-center bg-gray-50">
                <button id="loadMoreBtn"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                    <i class="bi bi-arrow-down-circle"></i>
                    <span id="loadMoreText">Tampilkan 20 Data Lagi</span>
                    <span id="loadMoreCounter" class="bg-white/20 px-2 py-0.5 rounded-full text-sm">
                        ({{ count($filteredDesas) - 20 }} tersisa)
                    </span>
                </button>

                <div id="showLessContainer" class="mt-3 hidden">
                    <button id="showLessBtn"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all duration-200 font-semibold">
                        <i class="bi bi-arrow-up-circle"></i>
                        Tampilkan Lebih Sedikit
                    </button>
                </div>

                <p id="dataInfo" class="mt-3 text-sm text-gray-600">
                    Menampilkan <span id="currentShowing" class="font-bold text-blue-600">20</span> dari
                    <span class="font-bold text-blue-600">{{ count($filteredDesas) }}</span> desa
                </p>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ================================
        // 📊 DOUGHNUT CHART
        // ================================
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('chartStatus');

            if (canvas) {
                const ctx = canvas.getContext('2d');

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Disetujui', 'Menunggu', 'Ditolak'],
                        datasets: [{
                            data: [
                                {{ $totalApproved ?? 0 }},
                                {{ $totalPending ?? 0 }},
                                {{ $totalRejected ?? 0 }},
                            ],
                            backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverOffset: 15,
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
                                    pointStyle: 'circle',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
            }

            // ================================
            // 📄 PAGINATION / LOAD MORE
            // ================================
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const showLessBtn = document.getElementById('showLessBtn');
            const showLessContainer = document.getElementById('showLessContainer');
            const currentShowingSpan = document.getElementById('currentShowing');
            const loadMoreCounter = document.getElementById('loadMoreCounter');
            const dataRows = document.querySelectorAll('.data-row');
            const totalRows = dataRows.length;
            let currentlyShowing = 20;

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const hiddenRows = document.querySelectorAll('.data-row.hidden');
                    let count = 0;

                    hiddenRows.forEach(row => {
                        if (count < 20) {
                            row.classList.remove('hidden');
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.style.transition = 'opacity 0.5s ease';
                                row.style.opacity = '1';
                            }, count * 30);
                            count++;
                            currentlyShowing++;
                        }
                    });

                    // Update counter
                    currentShowingSpan.textContent = currentlyShowing;
                    const remaining = totalRows - currentlyShowing;

                    if (remaining > 0) {
                        loadMoreCounter.textContent = `(${remaining} tersisa)`;
                    } else {
                        loadMoreBtn.style.display = 'none';
                        showLessContainer.classList.remove('hidden');
                    }

                    // Smooth scroll to new content
                    setTimeout(() => {
                        const lastVisibleRow = document.querySelector(
                            '.data-row:not(.hidden):last-child');
                        if (lastVisibleRow) {
                            lastVisibleRow.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }, 300);
                });

                // Show Less functionality
                if (showLessBtn) {
                    showLessBtn.addEventListener('click', function() {
                        dataRows.forEach((row, index) => {
                            if (index >= 20) {
                                row.classList.add('hidden');
                            }
                        });

                        currentlyShowing = 20;
                        currentShowingSpan.textContent = currentlyShowing;
                        loadMoreCounter.textContent = `(${totalRows - 20} tersisa)`;
                        loadMoreBtn.style.display = 'inline-flex';
                        showLessContainer.classList.add('hidden');

                        // Scroll to top of table
                        document.querySelector('#tableDesa').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                }
            }

            // ================================
            // 🔍 SEARCH FUNCTIONALITY
            // ================================
            const searchInput = document.getElementById('searchDesa');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                dataRows.forEach(row => {
                    const desaCell = row.querySelector('td:nth-child(2)');
                    if (desaCell) {
                        const desaName = desaCell.textContent.toLowerCase();
                        if (desaName.includes(searchTerm)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });

                // Hide load more button when searching
                if (searchTerm !== '') {
                    if (loadMoreBtn) loadMoreBtn.style.display = 'none';
                    if (showLessContainer) showLessContainer.classList.add('hidden');
                    document.getElementById('dataInfo').style.display = 'none';
                } else {
                    // Reset to initial state
                    dataRows.forEach((row, index) => {
                        if (index >= currentlyShowing) {
                            row.classList.add('hidden');
                        } else {
                            row.classList.remove('hidden');
                        }
                        row.style.display = '';
                    });

                    if (loadMoreBtn && totalRows > 20) {
                        if (currentlyShowing >= totalRows) {
                            loadMoreBtn.style.display = 'none';
                            showLessContainer.classList.remove('hidden');
                        } else {
                            loadMoreBtn.style.display = 'inline-flex';
                            showLessContainer.classList.add('hidden');
                        }
                    }
                    document.getElementById('dataInfo').style.display = 'block';
                }
            });

            // ================================
            // 📱 RESPONSIVE ADJUSTMENTS
            // ================================
            function handleResize() {
                const chart = document.getElementById('chartStatus');
                if (window.innerWidth < 1024) {
                    chart.style.maxHeight = '180px';
                    chart.style.maxWidth = '180px';
                } else {
                    chart.style.maxHeight = '200px';
                    chart.style.maxWidth = '200px';
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Initial call
        });
    </script>

    <style>
        /* Custom chart styling */
        #chartStatus {
            max-width: 200px;
            max-height: 200px;
            margin: 0 auto;
        }

        /* Badge styling - larger and bolder */
        #tableDesa tbody td span {
            font-size: 1rem;
            font-weight: 700;
            min-height: 2.5rem;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        /* Hover effect untuk badge */
        #tableDesa tbody tr:hover td span {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Status List Cards Hover */
        .space-y-3>div {
            cursor: default;
        }

        /* Responsive table adjustments */
        @media (max-width: 768px) {
            #tableDesa {
                font-size: 0.875rem;
            }

            #tableDesa th,
            #tableDesa td {
                padding: 0.75rem 0.5rem;
            }

            #tableDesa tbody td span {
                font-size: 0.875rem;
                padding: 0.25rem 0.75rem;
                min-height: 2rem;
            }
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
    </style>
@endsection
