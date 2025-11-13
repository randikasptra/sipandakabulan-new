@extends('layouts.adminLayout')

@section('title', 'Tambah Desa | SIPANDAKABULAN')

@section('content')
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.desa') }}">Data Desa</a></li>
                <li class="breadcrumb-item active">Tambah Desa</li>
            </ol>
        </nav>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Desa Baru</h2>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <form action="{{ route('admin.desa.store') }}" method="POST" id="formTambahDesa">
                    @csrf

                    <!-- Nama Desa -->
                    <div class="mb-3">
                        <label for="nama_desa" class="form-label fw-bold">
                            Nama Desa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_desa" id="nama_desa"
                            class="form-control @error('nama_desa') is-invalid @enderror" value="{{ old('nama_desa') }}"
                            placeholder="Contoh: Desa Sukamakmur" required autofocus>
                        @error('nama_desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Email akan otomatis dibuat: <strong id="previewEmail">-</strong></small>
                    </div>

                    <!-- Kode Desa -->
                    <div class="mb-3">
                        <label for="kode_desa" class="form-label fw-bold">
                            Kode Desa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="kode_desa" id="kode_desa"
                            class="form-control @error('kode_desa') is-invalid @enderror" value="{{ old('kode_desa') }}"
                            placeholder="Contoh: 3206012001" maxlength="50" required>
                        @error('kode_desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kode desa sesuai kode wilayah Kemendagri</small>
                    </div>

                    <!-- Nama Kepala Desa -->
                    <div class="mb-3">
                        <label for="nama_kades" class="form-label fw-bold">Nama Kepala Desa</label>
                        <input type="text" name="nama_kades" id="nama_kades"
                            class="form-control @error('nama_kades') is-invalid @enderror" value="{{ old('nama_kades') }}"
                            placeholder="Contoh: H. Ahmad Sudrajat, S.Sos">
                        @error('nama_kades')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Kantor -->
                    <div class="mb-3">
                        <label for="alamat_kantor" class="form-label fw-bold">Alamat Kantor Desa</label>
                        <textarea name="alamat_kantor" id="alamat_kantor" class="form-control @error('alamat_kantor') is-invalid @enderror"
                            rows="3" placeholder="Contoh: Jl. Raya Desa Sukamakmur No. 123">{{ old('alamat_kantor') }}</textarea>
                        @error('alamat_kantor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div class="mb-3">
                        <label for="no_telp" class="form-label fw-bold">Nomor Telepon</label>
                        <input type="text" name="no_telp" id="no_telp"
                            class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}"
                            placeholder="Contoh: 0265-1234567">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Informasi:</strong>
                        Sistem akan otomatis membuat akun operator dengan email berdasarkan nama desa dan password default:
                        <code>password123</code>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.desa') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Desa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr config
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
        };

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Preview email generation
        document.getElementById('nama_desa').addEventListener('input', function() {
            let namaDesa = this.value.trim();
            if (namaDesa) {
                let slug = namaDesa.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                document.getElementById('previewEmail').textContent = slug + '@tasikdesa.com';
            } else {
                document.getElementById('previewEmail').textContent = '-';
            }
        });

        // Format kode desa (hanya angka)
        document.getElementById('kode_desa').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Format no telepon
        document.getElementById('no_telp').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9\-\+\s]/g, '');
        });
    </script>
@endsection
