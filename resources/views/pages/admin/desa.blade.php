@extends('layouts.adminLayout')
@section('title', 'Pengelolaan Desa')

@section('content')
    <div class="bg-white shadow rounded-xl p-4 mb-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}

                @if (session('desa_user_email'))
                    <br>
                    <strong>Email User:</strong> {{ session('desa_user_email') }} <br>
                    <strong>Password:</strong> {{ session('desa_user_password') }}
                @endif
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h4 class="fw-bold">Daftar Desa</h4>
            <a href="{{ route('desa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Desa
            </a>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Desa</th>
                    <th>Kode</th>
                    <th>Kades</th>
                    <th>User Desa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($desas as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nama_desa }}</td>
                        <td>{{ $d->kode_desa }}</td>
                        <td>{{ $d->nama_kades }}</td>
                        <td>{{ $d->users->count() }} user</td>
                        <td>
                            <a href="{{ route('desa.show', $d->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('desa.edit', $d->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('desa.destroy', $d->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus desa?')">
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
