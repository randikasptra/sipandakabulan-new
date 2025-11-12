@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Indikator Klaster')

@section('content')
    <h2 class="text-2xl font-bold mb-3">
        📋 Penilaian Klaster "{{ $klaster->title }}" - Desa {{ $desa->nama_desa }}
    </h2>
    <a href="{{ route('admin.penilaian.desa', $desa->id) }}" class="btn btn-secondary mb-4">← Kembali</a>

    <div class="bg-white shadow rounded-xl p-5">
        <table id="tableIndikator" class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Indikator</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaians as $i => $p)
                    <tr id="row-{{ $p->id }}">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->indikator->nama_indikator }}</td>
                        <td>{{ $p->nilai ?? '-' }}</td>
                        <td>
                            <span
                                class="badge
                        @if ($p->status == 'approved') bg-success
                        @elseif($p->status == 'pending') bg-warning text-dark
                        @else bg-danger @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            @foreach ($p->berkasUploads as $b)
                                <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $b->path_file }}"
                                    target="_blank" class="text-primary d-block">
                                    <i class="bi bi-file-earmark-text"></i> {{ basename($b->path_file) }}
                                </a>
                            @endforeach
                        </td>
                        <td>
                            @if ($p->status == 'pending')
                                <button class="btn btn-success btn-sm btn-approve" data-id="{{ $p->id }}">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-reject" data-id="{{ $p->id }}">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- AJAX Approve/Reject --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.dataset.id;
                const res = await fetch(`/admin/penilaian/${id}/approve`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    Swal.fire('Disetujui!', data.message, 'success');
                    document.querySelector(`#row-${id}`).remove();
                }
            });
        });

        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.dataset.id;
                const res = await fetch(`/admin/penilaian/${id}/reject`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    Swal.fire('Ditolak!', data.message, 'warning');
                    document.querySelector(`#row-${id}`).remove();
                }
            });
        });
    </script>

    <script>
        $(document).ready(() => $('#tableIndikator').DataTable());
    </script>
@endsection
