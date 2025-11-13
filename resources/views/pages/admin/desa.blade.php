@extends('layouts.adminLayout')

@section('content')

    <x-admin.desa.modal-detail />
    <x-admin.desa.modal-edit />

    <div class="bg-white p-4 rounded-xl shadow">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }} <br>

                @if (session('desa_user_email'))
                    <b>Email:</b> {{ session('desa_user_email') }} <br>
                    <b>Password:</b> {{ session('desa_user_password') }}
                @endif
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h4 class="fw-bold">Daftar Desa</h4>

            {{-- Tombol Tambah Desa (pakai modal create?) --}}
            <a href="{{ route('admin.desa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Desa
            </a>

        </div>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Desa</th>
                    <th>Kode</th>
                    <th>Kades</th>
                    <th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($desas as $desa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $desa->nama_desa }}</td>
                        <td>{{ $desa->kode_desa }}</td>
                        <td>{{ $desa->nama_kades }}</td>
                        <td>{{ $desa->users->count() }} user</td>

                        <td>
                            <button class="btn btn-info btnDetailDesa" data-id="{{ $desa->id }}">
                                <i class="bi bi-eye"></i>
                            </button>

                            <button class="btn btn-warning btnEditDesa" data-id="{{ $desa->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <form method="POST" action="{{ route('admin.desa.destroy', $desa->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Hapus desa?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

@endsection

@section('scripts')
    <script>
        // ================= DETAIL MODAL =================
        $(".btnDetailDesa").click(function() {
            let id = $(this).data("id");
            $("#modalDetailDesa").modal("show");
            $("#detailContent").html("Memuat...");

            $.get(`/admin/desa/${id}/ajax-detail`, function(res) {
                $("#detailContent").html(res);
            });
        });

        // ================= EDIT MODAL =================
        $(".btnEditDesa").click(function() {
            let id = $(this).data("id");
            $("#modalEditDesa").modal("show");
            $("#editContent").html("Memuat...");
            $("#formEditDesa").attr("action", `/admin/desa/${id}`);

            $.get(`/admin/desa/${id}/ajax-edit`, function(res) {
                $("#editContent").html(res);
            });
        });
    </script>
@endsection
