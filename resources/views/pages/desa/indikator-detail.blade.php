@extends('layouts.desaLayout')

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-light mb-3">&larr; Kembali</a>

    <h3 class="fw-bold">{{ $indikator->nama }}</h3>
    <p class="text-muted">Nilai Maksimal: {{ $indikator->total_nilai }}</p>

    <h5>Opsi Nilai:</h5>
    <ul class="list-group mb-4">
        @foreach ($indikator->opsiNilai as $opsi)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $opsi->label }}
                <span class="badge bg-success">{{ $opsi->poin }}</span>
            </li>
        @endforeach
    </ul>

    <h5>Dokumen yang Diperlukan:</h5>
    <ul class="list-group">
        @foreach ($indikator->kategoriUploads as $upload)
            <li class="list-group-item">{{ $upload->nama_kategori }}</li>
        @endforeach
    </ul>
</div>
@endsection
