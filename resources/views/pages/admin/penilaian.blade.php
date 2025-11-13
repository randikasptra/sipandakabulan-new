@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Daftar Desa')

@section('content')
    <h2 class="text-2xl font-bold mb-4">
        🏘️ Daftar Desa ({{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }})
    </h2>

    {{-- ================================
        🎯 FILTER FORM
    ================================= --}}
    <form method="GET" class="row g-3 align-items-center mb-4">
        {{-- Tahun --}}
        <div class="col-md-2">
            <label class="form-label fw-semibold">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="{{ request('tahun', now()->year) }}" min="2020"
                max="{{ now()->year }}">
        </div>

        {{-- Bulan --}}
        <div class="col-md-3">
            <label class="form-label fw-semibold">Bulan</label>
            <select name="bulan" class="form-select">
                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $b)
                    <option value="{{ $b }}" {{ request('bulan', now()->format('F')) === $b ? 'selected' : '' }}>
                        {{ $b }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div class="col-md-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        {{-- Tombol --}}
        <div class="col-md-4 d-flex gap-2 mt-4">
            <button class="btn btn-primary">
                <i class="bi bi-search"></i> Terapkan Filter
            </button>
            <a href="{{ route('admin.penilaian') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>

    {{-- ================================
        📈 MINI GRAFIK STATUS
    ================================= --}}
    <div class="bg-white shadow rounded-4 p-4 mb-4">
        <h5 class="fw-bold text-primary mb-3">📊 Status Penilaian Bulan Ini</h5>
        <div class="row align-items-center">
            <div class="col-md-6">
                <canvas id="chartStatus" height="180"></canvas>
            </div>
            <div class="col-md-6">
                <ul class="list-group small">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ✅ Disetujui
                        <span class="badge bg-success rounded-pill">{{ $totalApproved ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ⚠️ Menunggu
                        <span class="badge bg-warning text-dark rounded-pill">{{ $totalPending ?? 0 }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ❌ Ditolak
                        <span class="badge bg-danger rounded-pill">{{ $totalRejected ?? 0 }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ================================
        🔎 SEARCH BAR
    ================================= --}}
    <div class="d-flex justify-content-end mb-3">
        <input type="text" id="searchDesa" class="form-control w-50" placeholder="🔍 Cari nama desa...">
    </div>

    {{-- ================================
        📋 TABEL DESA
    ================================= --}}
    <div class="bg-white shadow rounded-xl p-4">
        <table id="tableDesa" class="table table-striped align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Desa</th>
                    <th>Menunggu</th>
                    <th>Disetujui</th>
                    <th>Ditolak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
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
                    @endphp

                    @if ($show)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $desa->nama_desa }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $desa->total_pending }}</span></td>
                            <td><span class="badge bg-success">{{ $desa->total_approved }}</span></td>
                            <td><span class="badge bg-danger">{{ $desa->total_rejected }}</span></td>
                            <td>
                                <a href="{{ route('admin.penilaian.desa', [
                                    'desa' => $desa->id,
                                    'tahun' => request('tahun'),
                                    'bulan' => request('bulan'),
                                ]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Lihat Klaster
                                </a>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Tidak ada data desa ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================================
        📊 SCRIPTS
    ================================= --}}
@endsection


@section('scripts')
    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(() => {
            const table = $('#tableDesa').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ desa",
                    zeroRecords: "Tidak ada hasil ditemukan.",
                    paginate: {
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 10,
                order: [
                    [1, 'asc']
                ]
            });

            // Custom Search Desa
            $('#searchDesa').on('keyup', function() {
                table.search(this.value).draw();
            });
        });


        // ================================
        // 📊 DOUGHNUT CHART
        // ================================
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
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                        borderWidth: 2,
                        hoverOffset: 10
                    }]
                },
                options: {
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        }
    </script>

    <style>
        /* Mini Chart */
        #chartStatus {
            max-width: 180px;
            /* ukuran kecil */
            max-height: 180px;
            /* batas tinggi */
            margin: 0 auto;
            display: block;
        }
    </style>


    <style>
        canvas {
            background: #ffffff !important;
            border-radius: 14px;
            padding: 8px;
        }
    </style>
@endsection
