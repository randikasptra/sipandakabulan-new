@extends('layouts.desaLayout')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Dashboard Desa Layak Anak</h2>

    <div class="row">
        @foreach ($klasters as $klaster)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ $klaster->title }}</h5>
                    <p class="text-muted mb-2">Nilai Maksimal: {{ $klaster->nilai_maksimal }}</p>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: {{ $klaster->progres }}%"
                             aria-valuenow="{{ $klaster->progres }}"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                    <a href="{{ route('desa.klaster.detail', $klaster->slug) }}" class="btn btn-primary btn-sm w-100">
                        Lihat Klaster
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
