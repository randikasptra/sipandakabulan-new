@extends('layouts.adminLayout')

@section('content')
    <div class="bg-white shadow rounded-xl p-4">
        <h4 class="fw-bold mb-4">Edit Desa</h4>

        <form action="{{ route('desa.update', $desa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Desa</label>
                <input type="text" name="nama_desa" class="form-control" value="{{ $desa->nama_desa }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Desa</label>
                <input type="text" name="kode_desa" class="form-control" value="{{ $desa->kode_desa }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Kantor</label>
                <textarea name="alamat_kantor" class="form-control">{{ $desa->alamat_kantor }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Kepala Desa</label>
                <input type="text" name="nama_kades" class="form-control" value="{{ $desa->nama_kades }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="{{ $desa->no_telp }}">
            </div>

            <button class="btn btn-success">Update</button>
            <a href="{{ route('desa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
