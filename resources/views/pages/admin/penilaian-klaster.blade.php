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
                    <div class="flex flex-col">
                        <span>Penilaian Desa {{ $desa->nama_desa }}</span>
                        <span class="text-sm font-normal text-gray-600 mt-1">
                            ID: DES{{ str_pad($desa->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </h2>
                <div class="flex flex-wrap items-center gap-3 mt-2">
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="bi bi-calendar-check text-blue-500"></i>
                        Periode: {{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }}
                    </p>
                    <span class="text-gray-400">•</span>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="bi bi-layers text-blue-500"></i>
                        {{ $klasters->count() }} Klaster
                    </p>
                    @php
                        $totalAllData = $klasters->sum('total_indikator');
                        $totalApproved = $klasters->sum('total_approved');
                        $completionPercentage = $totalAllData > 0 ? round(($totalApproved / $totalAllData) * 100, 1) : 0;
                    @endphp
                    <span class="text-gray-400">•</span>
                    <p class="flex items-center gap-2">
                        <span class="flex items-center gap-1">
                            <i class="bi bi-check-circle {{ $completionPercentage == 100 ? 'text-green-500' : 'text-blue-500' }}"></i>
                            <span class="font-medium {{ $completionPercentage == 100 ? 'text-green-600' : 'text-blue-600' }}">
                                {{ $completionPercentage }}% Selesai
                            </span>
                        </span>
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.penilaian') }}"
                class="inline-flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Daftar Desa
            </a>
        </div>
    </div>

    <!-- Overall Stats -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-speedometer2 text-blue-600 text-lg"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800">Ringkasan Progress Desa</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-semibold">Total Data</p>
                        <p class="text-2xl font-bold text-blue-800">{{ $totalAllData }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-200 rounded-lg flex items-center justify-center">
                        <i class="bi bi-database text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-semibold">Disetujui</p>
                        <p class="text-2xl font-bold text-green-800">{{ $totalApproved }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-200 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 text-sm font-semibold">Menunggu</p>
                        <p class="text-2xl font-bold text-yellow-800">{{ $klasters->sum('total_pending') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-200 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock text-yellow-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 text-sm font-semibold">Ditolak</p>
                        <p class="text-2xl font-bold text-red-800">{{ $klasters->sum('total_rejected') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-200 rounded-lg flex items-center justify-center">
                        <i class="bi bi-x-circle text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mt-6">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Progress Verifikasi Keseluruhan</span>
                <span class="font-semibold">{{ $completionPercentage }}%</span>
            </div>
            <div class="relative h-4 bg-gray-200 rounded-full overflow-hidden">
                <div class="absolute h-full bg-green-500 rounded-l-full" 
                     style="width: {{ $completionPercentage }}%">
                </div>
                <div class="absolute h-full bg-yellow-500" 
                     style="left: {{ $completionPercentage }}%; width: {{ 100 - $completionPercentage }}%">
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
                        <th class="py-4 px-6 text-left font-semibold rounded-tl-2xl whitespace-nowrap w-16">
                            No
                        </th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-layers mr-2"></i>Nama Klaster
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">
                            <i class="bi bi-list-check mr-2"></i>Total<br />Indikator
                        </th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-graph-up mr-2"></i>Status Progress
                        </th>
                        <th class="py-4 px-6 text-center font-semibold rounded-tr-2xl whitespace-nowrap w-40">
                            <i class="bi bi-gear mr-2"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($klasters as $i => $k)
                        @php
                            $totalData = $k->total_indikator;
                            $approvedPercentage = $totalData > 0 ? round(($k->total_approved / $totalData) * 100, 1) : 0;
                            $pendingPercentage = $totalData > 0 ? round(($k->total_pending / $totalData) * 100, 1) : 0;
                            $rejectedPercentage = $totalData > 0 ? round(($k->total_rejected / $totalData) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap text-center">
                                {{ $i + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800 text-sm lg:text-base">{{ $k->title }}</div>
                                @if($k->total_pending > 0)
                                    <div class="text-xs text-yellow-600 mt-1 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i>
                                        {{ $k->total_pending }} perlu verifikasi
                                    </div>
                                @elseif($approvedPercentage == 100)
                                    <div class="text-xs text-green-600 mt-1 flex items-center gap-1">
                                        <i class="bi bi-check-circle"></i>
                                        Selesai 100%
                                    </div>
                                @else
                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <i class="bi bi-info-circle"></i>
                                        {{ $approvedPercentage }}% selesai
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex flex-col items-center justify-center">
                                    <span class="text-2xl font-bold text-blue-700">
                                        {{ $k->total_indikator }}
                                    </span>
                                    <span class="text-xs text-gray-500 mt-1">Indikator</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col gap-3">
                                    <!-- Progress Bar -->
                                    <div class="relative h-4 bg-gray-200 rounded-full overflow-hidden">
                                        @if($totalData > 0)
                                            <div class="absolute h-full bg-green-500 rounded-l-full" 
                                                 style="width: {{ $approvedPercentage }}%"
                                                 title="Disetujui: {{ $k->total_approved }} ({{ $approvedPercentage }}%)">
                                            </div>
                                            <div class="absolute h-full bg-yellow-500" 
                                                 style="left: {{ $approvedPercentage }}%; width: {{ $pendingPercentage }}%"
                                                 title="Menunggu: {{ $k->total_pending }} ({{ $pendingPercentage }}%)">
                                            </div>
                                            <div class="absolute h-full bg-red-500 rounded-r-full" 
                                                 style="left: {{ $approvedPercentage + $pendingPercentage }}%; width: {{ $rejectedPercentage }}%"
                                                 title="Ditolak: {{ $k->total_rejected }} ({{ $rejectedPercentage }}%)">
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
                                            <span class="font-semibold text-green-700">{{ $k->total_approved }}</span>
                                            <span class="text-gray-600">Disetujui</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                            <span class="font-semibold text-yellow-700">{{ $k->total_pending }}</span>
                                            <span class="text-gray-600">Menunggu</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                            <span class="font-semibold text-red-700">{{ $k->total_rejected }}</span>
                                            <span class="text-gray-600">Ditolak</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('admin.penilaian.klaster', [$desa->id, $k->id]) }}?tahun={{ request('tahun') }}&bulan={{ request('bulan') }}"
                                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
                                        <i class="bi bi-eye"></i>
                                        Lihat Detail
                                    </a>
                                    @if($k->total_pending > 0)
                                        <div class="text-xs text-yellow-600 font-medium">
                                            <i class="bi bi-clock"></i> {{ $k->total_pending }} menunggu verifikasi
                                        </div>
                                    @endif
                                </div>
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

            // Table row hover effects
            const tableRows = document.querySelectorAll('#tableKlaster tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Responsive adjustments
            function handleResponsive() {
                const table = document.getElementById('tableKlaster');
                const progressContainers = document.querySelectorAll('.flex.flex-col.gap-3');
                
                if (window.innerWidth < 768) {
                    // Mobile adjustments
                    if (table) table.classList.add('text-sm');
                    
                    // Compact progress display
                    progressContainers.forEach(container => {
                        const detailCount = container.querySelector('.flex.justify-between.text-xs');
                        if (detailCount) {
                            detailCount.classList.add('flex-col', 'gap-1', 'items-start');
                            detailCount.classList.remove('justify-between');
                        }
                    });
                    
                } else {
                    // Desktop
                    if (table) table.classList.remove('text-sm');
                    
                    // Restore original layout
                    progressContainers.forEach(container => {
                        const detailCount = container.querySelector('.flex.justify-between.text-xs');
                        if (detailCount) {
                            detailCount.classList.remove('flex-col', 'gap-1', 'items-start');
                            detailCount.classList.add('justify-between');
                        }
                    });
                }
            }

            window.addEventListener('resize', handleResponsive);
            handleResponsive(); // Initial call
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
        #tableKlaster tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #tableKlaster tbody tr:hover {
            background-color: #f0f7ff;
        }

        #tableKlaster tbody tr:hover .relative.h-4.bg-gray-200 {
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.15);
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #tableKlaster {
                font-size: 0.75rem;
            }

            #tableKlaster th,
            #tableKlaster td {
                padding: 0.5rem 0.25rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }

            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .p-4 {
                padding: 0.75rem;
            }

            .flex.flex-col.gap-3 {
                gap: 0.5rem;
            }
        }

        @media (max-width: 640px) {
            .grid-cols-4 {
                grid-template-columns: 1fr;
            }

            .flex-wrap {
                flex-direction: column;
                gap: 0.5rem;
            }

            .flex-wrap .text-gray-400 {
                display: none;
            }
        }
    </style>
@endsection