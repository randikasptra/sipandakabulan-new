@extends('layouts.adminLayout')
@section('title', 'Laporan Desa - Detail Klaster')

@section('content')
    <h2 class="text-2xl font-bold mb-3 text-primary">
        📋 Laporan Desa {{ $desa->nama_desa }} ({{ $bulan }} {{ $tahun }})
    </h2>


    <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary mb-4">
        ← Kembali
    </a>

    <div class="bg-white shadow rounded-4 p-4">
        <table id="tableKlaster" class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Klaster</th>
                    <th>Disetujui</th>
                    <th>Menunggu</th>
                    <th>Ditolak</th>
                    <th>Rata-rata Nilai</th>
                    <th>Status Klaster</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($klasters as $i => $klaster)
                    @php
                        $status = 'Pending';
                        $badge = 'bg-warning text-dark';
                        if ($klaster->rejected > 0) {
                            $status = 'Rejected';
                            $badge = 'bg-danger';
                        } elseif ($klaster->pending == 0 && $klaster->approved > 0) {
                            $status = 'Approved';
                            $badge = 'bg-success';
                        }
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $klaster->title }}</td>
                        <td><span class="badge bg-success">{{ $klaster->approved }}</span></td>
                        <td><span class="badge bg-warning text-dark">{{ $klaster->pending }}</span></td>
                        <td><span class="badge bg-danger">{{ $klaster->rejected }}</span></td>
                        <td><strong>{{ number_format($klaster->rata_rata, 2) }}</strong></td>
                        <td><span class="badge {{ $badge }}">{{ $status }}</span></td>
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

    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(() => $('#tableKlaster').DataTable());
    </script>
@endsection
