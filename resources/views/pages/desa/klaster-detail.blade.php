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
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form action="{{ route('desa.penilaian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @foreach ($klaster->indikators as $index => $indikator)
                @php
                    $penilaian = $penilaians[$indikator->id] ?? null;
                    $isApproved = $penilaian && $penilaian->status === 'approved';
                @endphp

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-2">{{ $index + 1 }}. {{ $indikator->nama }}</h5>
                        <p class="text-muted mb-3">Total Nilai: {{ $indikator->total_nilai }}</p>

                        {{-- OPSI NILAI --}}
                        <div class="d-flex flex-wrap gap-3 mb-3">
                            @if ($indikator->penilaians()->where('desa_id', Auth::user()->desa_id)->where('tahun', now()->year)->where('status', 'approved')->exists())
                                <div class="alert alert-success">Data ini sudah disetujui dan tidak bisa diubah.</div>
                            @else
                                {{-- Form input --}}

                                @foreach ($indikator->opsiNilai as $opsi)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="indikator_{{ $indikator->id }}"
                                            id="opsi_{{ $opsi->id }}" value="{{ $opsi->poin }}"
                                            @checked(optional($penilaian)->nilai == $opsi->poin) {{ $isApproved ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="opsi_{{ $opsi->id }}">
                                            {{ $opsi->label }}
                                        </label>
                                    </div>
                                @endforeach
                        </div>
            @endif

            {{-- Jika sudah diapprove, beri label --}}
            @if ($isApproved)
                <div class="alert alert-success py-2 mb-3">
                    <i class="bi bi-check-circle"></i> Penilaian ini sudah disetujui dan tidak dapat diubah.
                </div>
            @endif

            {{-- Download template jika ada --}}
            @if ($indikator->template_excel)
                <a href="{{ asset('templates/' . $indikator->template_excel) }}" class="btn btn-success btn-sm mb-3">
                    <i class="bi bi-download"></i> Download Template Excel
                </a>
            @endif

            {{-- UPLOAD DOKUMEN --}}
            <h6 class="mt-3 mb-2">Unggah Dokumen Pendukung</h6>
            @foreach ($indikator->kategoriUploads as $upload)
                @php
                    $berkas = \App\Models\BerkasUpload::whereHas('penilaian', function ($q) use ($indikator) {
                        $q->where('indikator_id', $indikator->id)->where('user_id', Auth::id());
                    })
                        ->where('kategori_upload_id', $upload->id)
                        ->first();
                @endphp

                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ $upload->nama_kategori }}</label>

                    @if ($berkas)
                        <p class="text-success small mb-1">
                            <i class="bi bi-file-earmark-check"></i>
                            Sudah diunggah:
                            <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $berkas->path_file }}"
                                target="_blank">
                                {{ basename($berkas->path_file) }}
                            </a>
                        </p>
                    @endif

                    @if (!$isApproved)
                        <input type="file" name="file_{{ $upload->id }}" class="form-control">
                    @else
                        <input type="file" class="form-control" disabled>
                    @endif
                </div>
            @endforeach
    </div>
    </div>
    @endforeach

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-lg px-5" {{ $klaster->status === 'approved' ? 'disabled' : '' }}>
            Simpan & Upload
        </button>
    </div>
    </form>
    </div>
@endsection
