@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Daftar Desa')

@section('content')

    <h2 class="text-2xl font-bold mb-6">
        🏘️ Daftar Desa ({{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }})
    </h2>

    <form method="GET" class="d-flex gap-2 mb-4 align-items-center">
        <input type="number" name="tahun" class="form-control w-auto" value="{{ request('tahun', now()->year) }}"
            min="2020" max="{{ now()->year }}">

        <select name="bulan" class="form-select w-auto">
            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $b)
                <option value="{{ $b }}" {{ request('bulan', now()->format('F')) === $b ? 'selected' : '' }}>
                    {{ $b }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-primary">
            <i class="bi bi-search"></i> Filter
        </button>
    </form>

    <div class="bg-white shadow rounded-xl p-5">
        <table id="tableDesa" class="table table-striped align-middle">
            <thead class="bg-gray-100">
                <tr>
                    <th>#</th>
                    <th>Nama Desa</th>
                    <th>Pending</th>
                    <th>Approved</th>
                    <th>Rejected</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($desas as $i => $desa)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $desa->nama_desa }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $desa->total_pending }}</span></td>
                        <td><span class="badge bg-success">{{ $desa->total_approved }}</span></td>
                        <td><span class="badge bg-danger">{{ $desa->total_rejected }}</span></td>
                        <td>
                            <a href="{{ route('admin.penilaian.desa', $desa->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Klaster
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(() => {
            $('#tableDesa').DataTable();
        });
    </script>
@endsection
