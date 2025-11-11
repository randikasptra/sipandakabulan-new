@extends('layouts.desaLayout')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-4">Form Penilaian Klaster {{ $klaster->title }}</h2>
        <p class="text-muted">Isi sesuai kondisi lapangan dan unggah dokumen pendukung untuk memastikan penilaian yang akurat dan transparan.</p>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
            <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
            <span class="fw-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center">
            <i class="bi bi-exclamation-circle-fill text-danger me-2 fs-5"></i>
            <span class="fw-medium">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('desa.penilaian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @foreach ($klaster->indikators as $index => $indikator)
            @php
                $penilaian = $penilaians[$indikator->id] ?? null;
                $isApproved = $penilaian && $penilaian->status === 'approved';
            @endphp

            <div class="card mb-4 border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-list-ol me-2"></i>
                            {{ $indikator->nama_indikator }}
                        </h5>
                        <span class="badge bg-light text-primary fs-6">
                            <i class="bi bi-star-fill me-1"></i>
                            Total Nilai: {{ $indikator->total_nilai }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- STATUS APPROVED --}}
                    @if ($isApproved)
                        <div class="alert alert-success border-0 bg-success bg-opacity-10 d-flex align-items-center mb-4">
                            <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                            <span class="fw-medium">Penilaian ini sudah disetujui dan tidak dapat diubah.</span>
                        </div>
                    @endif

                    {{-- OPSI NILAI --}}
                    <div class="mb-4">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i class="bi bi-ui-radios me-2 text-primary"></i>
                            Pilih Nilai:
                        </h6>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($indikator->opsiNilai as $opsi)
                                <div class="form-check card-option">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="indikator_{{ $indikator->id }}"
                                           id="opsi_{{ $opsi->id }}"
                                           value="{{ $opsi->poin }}"
                                           @checked(optional($penilaian)->nilai == $opsi->poin)
                                           {{ $isApproved ? 'disabled' : '' }}>
                                    <label class="form-check-label fw-medium" for="opsi_{{ $opsi->id }}">
                                        {{ $opsi->label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- TEMPLATE DOWNLOAD --}}
                    @if ($indikator->template_excel)
                        <div class="mb-4">
                            <a href="{{ asset('templates/' . $indikator->template_excel) }}"
                               class="btn btn-success btn-sm px-3 py-2 rounded-pill">
                                <i class="bi bi-download me-2"></i>
                                Download Template Excel
                            </a>
                        </div>
                    @endif

                    {{-- UPLOAD DOKUMEN --}}
                    @if(count($indikator->kategoriUploads) > 0)
                        <div class="upload-section">
                            <h6 class="fw-semibold text-dark mb-3">
                                <i class="bi bi-cloud-upload me-2 text-primary"></i>
                                Unggah Dokumen Pendukung
                            </h6>

                            @foreach ($indikator->kategoriUploads as $upload)
                                @php
                                    $berkas = \App\Models\BerkasUpload::whereHas('penilaian', function ($q) use ($indikator) {
                                        $q->where('indikator_id', $indikator->id)
                                          ->where('desa_id', Auth::user()->desa_id)
                                          ->where('tahun', now()->year);
                                    })
                                    ->where('kategori_upload_id', $upload->id)
                                    ->first();
                                @endphp

                                <div class="mb-4 p-3 border rounded-3 bg-light">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="bi bi-file-earmark me-2 text-primary"></i>
                                        {{ $upload->nama_kategori }}
                                    </label>

                                    @if ($berkas)
                                        <div class="alert alert-success border-0 bg-success bg-opacity-10 py-2 mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <span class="fw-medium">Sudah diunggah:</span>
                                                <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $berkas->path_file }}"
                                                   target="_blank"
                                                   class="text-decoration-none ms-2 fw-medium">
                                                    {{ basename($berkas->path_file) }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if (!$isApproved)
                                        <input type="file"
                                               name="file_{{ $upload->id }}"
                                               class="form-control border-primary border-opacity-25">
                                    @else
                                        <input type="file" class="form-control" disabled>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="text-center mt-5">
            <button type="submit"
                    class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm fw-bold">
                <i class="bi bi-save me-2"></i>
                Simpan & Upload
            </button>
        </div>
    </form>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
}

.card-option {
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.card-option:hover {
    border-color: #3498db;
    background-color: #f8f9fa;
}

.card-option .form-check-input:checked {
    background-color: #3498db;
    border-color: #3498db;
}

.upload-section .border {
    border-color: #e9ecef !important;
    transition: all 0.3s ease;
}

.upload-section .border:hover {
    border-color: #3498db !important;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, #27ae60 0%, #219653 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
}

.alert {
    border-radius: 10px;
}

.card {
    border-radius: 12px;
    overflow: hidden;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}
</style>
@endsection
