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

    <div class="bg-white shadow-sm rounded-4 p-4">
        <table id="tableLaporan" class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Desa</th>
                    <th>Approved</th>
                    <th>Pending</th>
                    <th>Rejected</th>
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
