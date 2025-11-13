@extends('layouts.adminLayout')
@section('title', 'Dashboard Admin | SIPANDAKABULAN')

@section('content')
    <div class="space-y-6">

        {{-- ===========================
        FILTER TAHUN & BULAN
    ============================ --}}
        <form method="GET" class="flex gap-4 bg-white p-4 rounded-xl shadow">

            <div>
                <label class="text-sm font-medium">Tahun</label>
                <select name="tahun" class="p-2 border rounded-lg">
                    @for ($i = now()->year; $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="text-sm font-medium">Bulan</label>
                <select name="bulan" class="p-2 border rounded-lg">
                    @foreach ($monthsOrder as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ $m }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Terapkan</button>
        </form>


        {{-- ===========================
        STATISTIC CARDS
    ============================ --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">

            <div class="p-5 bg-white rounded-xl shadow">
                <p class="text-gray-500 text-sm">Total Desa</p>
                <p class="text-3xl font-bold">{{ $totalDesa }}</p>
            </div>

            <div class="p-5 bg-white rounded-xl shadow">
                <p class="text-gray-500 text-sm">User Desa</p>
                <p class="text-3xl font-bold">{{ $totalUserDesa }}</p>
            </div>

            <div class="p-5 bg-white rounded-xl shadow">
                <p class="text-gray-500 text-sm">Total Penilaian</p>
                <p class="text-3xl font-bold">{{ $totalPenilaian }}</p>
            </div>

            <div class="p-5 bg-green-50 border border-green-200 rounded-xl shadow">
                <p class="text-green-700 text-sm">Approved Bulan Ini</p>
                <p class="text-3xl font-bold text-green-700">{{ $totalApprovedThisMonth }}</p>
            </div>

            <div class="p-5 bg-yellow-50 border border-yellow-200 rounded-xl shadow">
                <p class="text-yellow-700 text-sm">Pending Bulan Ini</p>
                <p class="text-3xl font-bold text-yellow-700">{{ $totalPendingThisMonth }}</p>
            </div>

            <div class="p-5 bg-red-50 border border-red-200 rounded-xl shadow">
                <p class="text-red-700 text-sm">Rejected Bulan Ini</p>
                <p class="text-3xl font-bold text-red-700">{{ $totalRejectedThisMonth }}</p>
            </div>
        </div>


        {{-- ===========================
        CHARTS AREA
    ============================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Doughnut: Status Bulan Ini --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-3">Status Penilaian (Bulan {{ $bulan }} {{ $tahun }})</h2>
                <canvas id="chartStatus" height="220"></canvas>
            </div>

            {{-- Line: Tahun --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-3">Trend Penilaian Tahun {{ $tahun }}</h2>
                <canvas id="chartLine" height="220"></canvas>
            </div>
        </div>


        {{-- ===========================
        BAR KLASTER
    ============================ --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="font-bold text-lg mb-3">Rata-Rata Nilai per Klaster</h2>
            <canvas id="chartKlaster" height="120"></canvas>
        </div>


        {{-- ===========================
        TOP DESA & PENDING
    ============================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Top Desa --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-4">Top 5 Desa Nilai Tertinggi</h2>

                <table class="w-full">
                    @foreach ($topDesa as $d)
                        <tr class="border-b">
                            <td class="py-2">{{ $d->nama_desa }}</td>
                            <td class="py-2 font-bold text-right">{{ $d->rata }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{-- Pending --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-4">Desa Pending Terbanyak</h2>

                <table class="w-full">
                    @foreach ($pendingDesa as $d)
                        <tr class="border-b">
                            <td class="py-2">{{ $d->nama_desa }}</td>
                            <td class="py-2 font-bold text-right">{{ $d->total_pending }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>


        {{-- ===========================
        AKTIVITAS
    ============================ --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="font-bold text-lg mb-4">Aktivitas Terbaru</h2>

            @forelse ($aktivitas as $a)
                <div class="border-b py-3">
                    <p class="text-sm">
                        <b class="text-blue-700">{{ $a->desa->nama_desa }}</b>
                        mengisi indikator <b>{{ $a->indikator->judul }}</b>
                        ({{ $a->klaster->title }})
                    </p>
                    <p class="text-xs text-gray-500">{{ $a->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-gray-500 italic">Tidak ada aktivitas terbaru.</p>
            @endforelse
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
                    backgroundColor: ['#22c55e', '#eab308', '#ef4444']
                }]
            },
            options: {
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom'
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
                    borderWidth: 2,
                    tension: 0.3
                }]
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
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection
