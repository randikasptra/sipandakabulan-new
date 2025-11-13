@extends('layouts.adminLayout')

@section('content')
    <div class="bg-white rounded-xl p-4 shadow">
        <h4 class="fw-bold mb-4">Tambah Desa</h4>

        <form action="{{ route('admin.desa.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Desa</label>
                <input type="text" name="nama_desa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kode Desa</label>
                <input type="text" name="kode_desa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Alamat Kantor</label>
                <textarea name="alamat_kantor" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Nama Kepala Desa</label>
                <input type="text" name="nama_kades" class="form-control">
            </div>

            <div class="mb-3">
                <label>No Telepon</label>
                <input type="text" name="no_telp" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.desa') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
