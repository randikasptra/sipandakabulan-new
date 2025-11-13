@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Daftar Desa')

@section('content')
    <h2 class="text-2xl font-bold mb-6">
        🏘️ Daftar Desa ({{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }})
    </h2>

    {{-- 🔍 FILTER FORM --}}
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

    {{-- 🔢 TABEL DESA --}}
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
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada data desa ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📊 DataTables --}}
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(() => {
            $('#tableDesa').DataTable({
                language: {
                    search: "Cari Desa:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ desa",
                    paginate: {
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    zeroRecords: "Tidak ada hasil ditemukan."
                },
                pageLength: 10,
                order: [
                    [1, 'asc']
                ]
            });
        });
    </script>
@endsection
