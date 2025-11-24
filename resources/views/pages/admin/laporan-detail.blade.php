@extends('layouts.adminLayout')
@section('title', 'Laporan Detail - ' . $desa->nama_desa)

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
                    <a href="{{ route('admin.laporan.index') }}" class="text-blue-600 hover:text-blue-800">
                        Laporan
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-600">{{ $desa->nama_desa }}</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-file-earmark-text text-white text-lg"></i>
                    </div>
                    Laporan {{ $desa->nama_desa }}
                </h2>
                <p class="text-gray-600 mt-2 flex items-center gap-2">
                    <i class="bi bi-calendar-check text-blue-500"></i>
                    Periode: {{ $bulan }} {{ $tahun }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @php
            $totalApproved = $klasters->sum('approved');
            $totalPending = $klasters->sum('pending');
            $totalRejected = $klasters->sum('rejected');
            $avgTotal = $klasters->avg('rata_rata');
            // Hitung total poin keseluruhan
            $grandTotalPoin = 0;
            foreach ($klasters as $k) {
                $grandTotalPoin += $k->indikators->flatMap->penilaians->where('status', 'approved')->sum('nilai');
            }
        @endphp

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
                    <p class="text-green-600 text-sm font-semibold">Disetujui</p>
                    <p class="text-2xl font-bold text-green-800">{{ $totalApproved }}</p>
                </div>
                <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-2xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-600 text-sm font-semibold">Total Poin</p>
                    <p class="text-2xl font-bold text-yellow-800">{{ number_format($grandTotalPoin, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-star-fill text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-600 text-sm font-semibold">Rata-rata</p>
                    <p class="text-2xl font-bold text-purple-800">{{ number_format($avgTotal ?? 0, 1) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-graph-up text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="flex justify-end gap-2 mb-4">
        <a href="{{ route('admin.laporan.exportExcel', ['desa_id' => $desa->id, 'tahun' => $tahun, 'bulan' => $bulan]) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
            <i class="bi bi-file-earmark-excel"></i>
            Export Excel
        </a>
        <a href="{{ route('admin.laporan.exportPdf', ['desa_id' => $desa->id, 'tahun' => $tahun, 'bulan' => $bulan]) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold text-sm">
            <i class="bi bi-filetype-pdf"></i>
            Export PDF
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tableKlaster" class="w-full">
                <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold rounded-tl-2xl whitespace-nowrap w-16">No</th>
                        <th class="py-4 px-6 text-left font-semibold whitespace-nowrap">
                            <i class="bi bi-layers mr-2"></i>Nama Klaster
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-28">
                            <i class="bi bi-check-circle mr-2"></i>Disetujui
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-28">
                            <i class="bi bi-clock mr-2"></i>Menunggu
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-32">
                            <i class="bi bi-star-fill mr-2"></i>Total Poin
                        </th>
                        <th class="py-4 px-6 text-center font-semibold whitespace-nowrap w-28">
                            <i class="bi bi-graph-up mr-2"></i>Rata-rata
                        </th>
                        <th class="py-4 px-6 text-center font-semibold rounded-tr-2xl whitespace-nowrap w-32">
                            <i class="bi bi-flag mr-2"></i>Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $totalPoinKeseluruhan = 0;
                    @endphp

                    @forelse ($klasters as $i => $klaster)
                        @php
                            // Hitung total poin dari klaster ini
                            $totalPoinKlaster = $klaster->indikators->flatMap->penilaians
                                ->where('status', 'approved')
                                ->sum('nilai');

                            $totalPoinKeseluruhan += $totalPoinKlaster;

                            $status = 'Pending';
                            $badge = 'bg-yellow-100 text-yellow-800';
                            $icon = 'bi-clock';

                            if ($klaster->rejected > 0) {
                                $status = 'Rejected';
                                $badge = 'bg-red-100 text-red-800';
                                $icon = 'bi-x-circle';
                            } elseif ($klaster->pending == 0 && $klaster->approved > 0) {
                                $status = 'Approved';
                                $badge = 'bg-green-100 text-green-800';
                                $icon = 'bi-check-circle';
                            }
                        @endphp
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap text-center">
                                {{ $i + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800">{{ $klaster->title }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[3rem] bg-green-100 text-green-800 px-4 py-2 rounded-full text-base font-bold">
                                    {{ $klaster->approved }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[3rem] bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-base font-bold">
                                    {{ $klaster->pending }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[4rem] bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-lg font-bold border-2 border-yellow-300">
                                    {{ number_format($totalPoinKlaster, 0) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-lg font-bold">
                                    {{ number_format($klaster->rata_rata, 2) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 {{ $badge }} px-3 py-1.5 rounded-full text-sm font-semibold">
                                    <i class="bi {{ $icon }}"></i>
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="bi bi-inbox text-5xl mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada data klaster</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <!-- Total Row -->
                    @if ($klasters->count() > 0)
                        <tr class="bg-gradient-to-r from-blue-100 to-blue-200 border-t-4 border-blue-600">
                            <td colspan="2" class="py-4 px-6 text-right font-bold text-gray-800 text-base">
                                <i class="bi bi-trophy-fill text-yellow-600 mr-2"></i>
                                TOTAL KESELURUHAN:
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[3rem] bg-green-600 text-white px-4 py-2 rounded-full text-base font-bold">
                                    {{ $klasters->sum('approved') }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[3rem] bg-yellow-600 text-white px-4 py-2 rounded-full text-base font-bold">
                                    {{ $klasters->sum('pending') }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center min-w-[4rem] bg-yellow-600 text-white px-5 py-2.5 rounded-full text-xl font-bold border-3 border-yellow-800 shadow-lg">
                                    {{ number_format($totalPoinKeseluruhan, 0) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded-full text-lg font-bold">
                                    {{ number_format($klasters->avg('rata_rata'), 2) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center gap-1 bg-green-600 text-white px-3 py-1.5 rounded-full text-sm font-bold">
                                    <i class="bi bi-check-circle-fill"></i>
                                    COMPLETE
                                </span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        #tableKlaster tbody td span {
            transition: all 0.2s ease;
        }

        #tableKlaster tbody tr:hover td span {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
