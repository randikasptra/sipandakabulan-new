@extends('layouts.adminLayout')
@section('title', 'Laporan Penilaian Desa')

@section('content')
    @php
        $tahun = $tahun ?? now()->year;
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            📊 Laporan Penilaian Desa ({{ $bulan }} {{ $tahun }})
        </h2>

        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="{{ route('admin.laporan.exportExcel', ['tahun' => request('tahun'), 'bulan' => request('bulan')]) }}"
                class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>

            <a href="{{ route('admin.laporan.exportPdf', ['tahun' => request('tahun'), 'bulan' => request('bulan')]) }}"
                class="btn btn-danger">
                <i class="bi bi-filetype-pdf"></i> Export PDF
            </a>
        </div>


        <form method="GET" class="d-flex gap-2">
            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" min="2020"
                max="{{ now()->year }}">

            <select name="bulan" class="form-select">
                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $b)
                    <option value="{{ $b }}" {{ $bulan === $b ? 'selected' : '' }}>
                        {{ $b }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary">
                <i class="bi bi-search"></i> Filter
            </button>
        </form>

    </div>

    {{-- 🎨 Grafik Statistik --}}
    <div class="bg-white shadow rounded-4 p-4 mb-4">
        <h5 class="fw-bold mb-3 text-primary">📊 Visualisasi Penilaian Bulan {{ $bulan }} {{ $tahun }}</h5>

        <div class="row g-4">
            <div class="col-md-6">
                <canvas id="statusChart" height="200"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="nilaiChart" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- CDN Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==== 1️⃣ Doughnut Chart: Status Penilaian ====
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [{{ $totalApproved }}, {{ $totalPending }}, {{ $totalRejected }}],
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                        borderWidth: 2,
                        hoverOffset: 10,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });

            // ==== 2️⃣ Polar Area Chart: Rata-rata Nilai per Desa ====
            const ctxNilai = document.getElementById('nilaiChart').getContext('2d');
            new Chart(ctxNilai, {
                type: 'polarArea',
                data: {
                    labels: {!! json_encode($desas->pluck('nama_desa')) !!},
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: {!! json_encode($desas->pluck('rata_rata')) !!},
                        backgroundColor: [
                            '#3498db', '#9b59b6', '#1abc9c', '#f39c12', '#e74c3c',
                            '#16a085', '#2ecc71', '#f1c40f', '#8e44ad', '#27ae60'
                        ],
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            ticks: {
                                stepSize: 10
                            },
                            grid: {
                                color: '#eee'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 13
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>


    <div class="bg-white shadow-sm rounded-4 p-4">
        <table id="tableLaporan" class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Desa</th>
                    <th>Disetujui</th>
                    <th>Menunggu</th>
                    <th>Ditolak</th>
                    <th>Rata-rata Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($desas as $i => $desa)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $desa->nama_desa }}</td>
                        <td><span class="badge bg-success">{{ $desa->total_approved }}</span></td>
                        <td><span class="badge bg-warning text-dark">{{ $desa->total_pending }}</span></td>
                        <td><span class="badge bg-danger">{{ $desa->total_rejected }}</span></td>
                        <td><strong>{{ number_format($desa->rata_rata, 2) }}</strong></td>
                        <td>
                            <a href="{{ route('admin.laporan.desa', $desa->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end gap-2">
        <a href="{{ route('admin.laporan.exportExcel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.laporan.exportPdf') }}" class="btn btn-danger">
            <i class="bi bi-filetype-pdf"></i> Export PDF
        </a>
    </div>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(() => $('#tableLaporan').DataTable());
    </script>
@endsection
