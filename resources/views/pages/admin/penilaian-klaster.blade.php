@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Klaster per Desa')

@section('content')
    <h2 class="text-2xl font-bold mb-3">
        📊 Penilaian Desa {{ $desa->nama_desa }} ({{ request('bulan', now()->format('F')) }}
        {{ request('tahun', now()->year) }})
    </h2>

    <a href="{{ route('admin.penilaian') }}" class="btn btn-secondary mb-4">← Kembali</a>

    <div class="bg-white shadow rounded-xl p-5">
        <table id="tableKlaster" class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Klaster</th>
                    <th>Total Indikator</th>
                    <th>Approved</th>
                    <th>Pending</th>
                    <th>Rejected</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($klasters as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $k->title }}</td>
                        <td>{{ $k->total_indikator }}</td>
                        <td><span class="badge bg-success">{{ $k->total_approved }}</span></td>
                        <td><span class="badge bg-warning text-dark">{{ $k->total_pending }}</span></td>
                        <td><span class="badge bg-danger">{{ $k->total_rejected }}</span></td>
                        <td>
                            <a href="{{ route('admin.penilaian.klaster', [$desa->id, $k->id]) }}"
                                class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Indikator
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(() => $('#tableKlaster').DataTable());
    </script>
@endsection
