@extends('layouts.desaLayout')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4 text-center">
        Form Penilaian Klaster {{ $klaster->title }}
    </h2>
    <p class="text-muted text-center mb-5">
        Isi sesuai kondisi lapangan dan unggah dokumen pendukung untuk memastikan penilaian yang akurat dan transparan.
    </p>

    {{-- ALERT BERHASIL --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('desa.penilaian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @foreach ($klaster->indikators as $index => $indikator)
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">{{ $index + 1 }}. {{ $indikator->nama }}</h5>
                    <p class="text-muted mb-3">Total Nilai: {{ $indikator->total_nilai }}</p>

                    {{-- OPSI NILAI --}}
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        @foreach ($indikator->opsiNilai as $opsi)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="indikator_{{ $indikator->id }}"
                                    id="opsi_{{ $opsi->id }}"
                                    value="{{ $opsi->poin }}">
                                <label class="form-check-label" for="opsi_{{ $opsi->id }}">
                                    {{ $opsi->label }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- UPLOAD DOKUMEN PER KATEGORI --}}
                    <h6 class="mt-3 mb-2">Unggah Dokumen Pendukung</h6>
                    @foreach ($indikator->kategoriUploads as $upload)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ $upload->nama_kategori }}</label>
                            <input type="file" name="file_{{ $upload->id }}" class="form-control">
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                Simpan & Upload
            </button>
        </div>
    </form>
</div>
@endsection
