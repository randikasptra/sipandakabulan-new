@extends('layouts.desaLayout')
@section('content')
<div class="container">
    {{-- HEADER --}}
    <div class="text-center mb-5 mt-24">
        <h2 class="fw-bold mb-3">Form Penilaian Klaster {{ $klaster->title }}</h2>
        <p class="text-muted">
            Isi penilaian, catatan, dan unggah dokumen pendukung sesuai kondisi lapangan.
        </p>
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

    {{-- FORM --}}
    <form action="{{ route('desa.penilaian.store') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf

        @foreach ($klaster->indikators as $index => $indikator)
        @php
        $penilaian = $penilaians[$indikator->id] ?? null;
        $isApproved = $penilaian && $penilaian->status === 'approved';
        $existingCatatan = \App\Models\CatatanIndikator::where([
        'indikator_id' => $indikator->id,
        'desa_id' => Auth::user()->desa_id,
        'tahun' => now()->year,
        ])->first();
        $customKategoris = $indikator->kategoriUploads
        ->where('is_custom', true)
        ->where('desa_id', Auth::user()->desa_id);
        @endphp

        <div class="card mb-4 shadow-lg border-0"
            x-data="uploadManager({{ $indikator->id }}, {{ $isApproved ? 'true' : 'false' }})">

            {{-- CARD HEADER --}}
            <div class="card-header bg-gradient-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-list-ol me-2"></i>
                            {{ $index + 1 }}. {{ $indikator->nama_indikator }}
                        </h5>
                        @if ($penilaian)
                        @if ($penilaian->status === 'approved')
                        <span class="badge bg-success text-white">
                            <i class="bi bi-check-circle me-1"></i> Disetujui
                        </span>
                        @elseif ($penilaian->status === 'rejected')
                        <span class="badge bg-danger text-white">
                            <i class="bi bi-x-circle me-1"></i> Ditolak
                        </span>
                        @else
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                        </span>
                        @endif
                        @else
                        <span class="badge bg-secondary">Belum Diisi</span>
                        @endif
                    </div>
                    <span class="badge bg-light text-primary fs-6">
                        <i class="bi bi-star-fill me-1"></i>
                        Total Nilai: {{ $indikator->total_nilai }}
                    </span>
                </div>
            </div>

            {{-- CARD BODY --}}
            <div class="card-body p-4">
                {{-- ALASAN PENOLAKAN --}}
                @if ($penilaian && $penilaian->status === 'rejected' && $penilaian->rejection_reason)
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 d-flex align-items-center mb-4">
                    <i class="bi bi-info-circle-fill text-danger me-2"></i>
                    <span class="fw-medium">Alasan penolakan: {{ $penilaian->rejection_reason }}</span>
                </div>
                @endif

                {{-- STATUS APPROVED --}}
                @if ($isApproved)
                <div class="alert alert-success border-0 bg-success bg-opacity-10 d-flex align-items-center mb-4">
                    <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                    <span class="fw-medium">Penilaian ini sudah disetujui dan tidak dapat diubah.</span>
                </div>
                @endif

                {{-- OPSI NILAI --}}
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-ui-radios me-2 text-primary"></i> Pilih Nilai
                    </h6>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($indikator->opsiNilai as $opsi)
                        <label class="form-check card-option">
                            <input type="radio"
                                name="indikator_{{ $indikator->id }}"
                                value="{{ $opsi->poin }}"
                                class="form-check-input"
                                @checked(optional($penilaian)->nilai == $opsi->poin)
                            {{ $isApproved ? 'disabled' : '' }}>
                            {{ $opsi->label }}
                        </label>
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

                {{-- CATATAN --}}
                <div class="mb-4 pt-4 border-top">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-journal-text me-2 text-info"></i> Catatan
                    </h6>
                    @if ($isApproved)
                    <div class="alert alert-secondary">
                        Catatan terkunci karena sudah disetujui.
                    </div>
                    @else
                    <textarea
                        name="catatan_{{ $indikator->id }}"
                        rows="3"
                        class="form-control border-primary border-opacity-25"
                        placeholder="Tulis catatan indikator...">{{ $existingCatatan->catatan ?? '' }}</textarea>
                    @endif
                </div>

                {{-- UPLOAD DOKUMEN --}}
                <div class="mb-3 pt-4 border-top">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-cloud-upload me-2 text-primary"></i> Dokumen Pendukung
                    </h6>

                    {{-- KATEGORI DEFAULT --}}
                    @foreach ($indikator->kategoriUploads->where('is_custom', false) as $upload)
                    @php
                    $berkasFiles = \App\Models\BerkasUpload::whereHas('penilaian', function ($q) use ($indikator) {
                    $q->where('indikator_id', $indikator->id)
                    ->where('desa_id', Auth::user()->desa_id)
                    ->where('tahun', now()->year);
                    })
                    ->where('kategori_upload_id', $upload->id)
                    ->get();
                    @endphp

                    <div class="mb-4 p-4 border rounded-3 upload-section"
                        style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-left: 4px solid #3498db !important;">
                        <label class="form-label fw-semibold text-dark mb-3 d-flex align-items-center">
                            <i class="bi bi-file-earmark-text text-primary me-2 fs-5"></i>
                            {{ $upload->nama_kategori }}
                        </label>

                        {{-- Show existing files --}}
                        @if ($berkasFiles->count() > 0)
                        <div class="alert alert-success border-0 rounded-2 mb-3"
                            style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-left: 4px solid #10b981;">
                            <div class="fw-medium mb-2 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                                File yang sudah diunggah:
                            </div>
                            <div class="space-y-2">
                                @foreach ($berkasFiles as $berkas)
                                <div class="d-flex align-items-center justify-content-between p-2 bg-white rounded-2 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi {{ $berkas->extension === 'pdf' ? 'bi-file-earmark-pdf-fill text-danger' : 'bi-file-earmark-excel-fill text-success' }} me-2"></i>
                                        <a href="{{ $berkas->full_url }}"
                                            target="_blank"
                                            class="text-decoration-none text-dark fw-medium">
                                            {{ $berkas->filename }}
                                        </a>
                                    </div>
                                    <a href="{{ $berkas->full_url }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-success rounded-pill">
                                        <i class="bi bi-download me-1"></i> Download
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if (!$isApproved)
                        <div class="file-upload-wrapper">
                            <input type="file"
                                name="file_{{ $upload->id }}[]"
                                class="form-control border-2 border-dashed border-blue-300 rounded-3 file-input"
                                data-kategori-id="{{ $upload->id }}"
                                multiple
                                accept=".pdf,.xlsx,.xls">
                            <div class="d-flex align-items-center mt-2">
                                <i class="bi bi-info-circle-fill text-blue-500 me-2"></i>
                                <small class="text-muted">
                                    Hanya PDF & Excel | Maksimal 30MB per file | Bisa upload lebih dari 1 file
                                </small>
                            </div>
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill border border-danger">
                                    <i class="bi bi-file-pdf me-1"></i>PDF
                                </span>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill border border-success">
                                    <i class="bi bi-file-excel me-1"></i>Excel (XLS/XLSX)
                                </span>
                            </div>
                            <!-- Error message container -->
                            <div id="error-{{ $upload->id }}" class="alert alert-danger mt-2 d-none">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <span class="error-message"></span>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-secondary border-0 rounded-3">
                            <i class="bi bi-lock-fill me-2"></i> Upload dinonaktifkan karena sudah disetujui
                        </div>
                        @endif
                    </div>
                    @endforeach

                    {{-- KATEGORI CUSTOM EXISTING --}}
                    @foreach ($customKategoris as $custom)
                    @php
                    $customBerkasFiles = \App\Models\BerkasUpload::whereHas('penilaian', function ($q) use ($indikator) {
                    $q->where('indikator_id', $indikator->id)
                    ->where('desa_id', Auth::user()->desa_id)
                    ->where('tahun', now()->year);
                    })
                    ->where('kategori_upload_id', $custom->id)
                    ->get();
                    @endphp

                    <div class="mb-3 p-4 border rounded-3 custom-kategori-item position-relative"
                        style="background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%); border-left: 4px solid #f59e0b !important;">

                        @if (!$isApproved)
                        <button type="button"
                            onclick="deleteKategori({{ $custom->id }}, this)"
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                            title="Hapus kategori ini">
                            <i class="bi bi-trash"></i>
                        </button>
                        @endif

                        <label class="form-label fw-semibold text-dark mb-3 d-flex align-items-center">
                            <i class="bi bi-tag-fill text-amber-600 me-2 fs-5"></i>
                            {{ $custom->nama_kategori }}
                            <span class="badge badge-custom ms-2">Custom</span>
                        </label>

                        {{-- Show existing files --}}
                        @if ($customBerkasFiles->count() > 0)
                        <div class="alert alert-warning border-0 rounded-2 mb-3"
                            style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-left: 4px solid #f59e0b;">
                            <div class="fw-medium mb-2 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-amber-600 me-2 fs-5"></i>
                                File yang sudah diunggah:
                            </div>
                            <div class="space-y-2">
                                @foreach ($customBerkasFiles as $berkas)
                                <div class="d-flex align-items-center justify-content-between p-2 bg-white rounded-2 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi {{ $berkas->extension === 'pdf' ? 'bi-file-earmark-pdf-fill text-danger' : 'bi-file-earmark-excel-fill text-success' }} me-2"></i>
                                        <a href="{{ $berkas->full_url }}"
                                            target="_blank"
                                            class="text-decoration-none text-dark fw-medium">
                                            {{ $berkas->filename }}
                                        </a>
                                    </div>
                                    <a href="{{ $berkas->full_url }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-warning rounded-pill">
                                        <i class="bi bi-download me-1"></i> Download
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if (!$isApproved)
                        <div class="file-upload-wrapper">
                            <input type="file"
                                name="file_{{ $custom->id }}[]"
                                class="form-control border-2 border-dashed border-amber-300 rounded-3 file-input"
                                data-kategori-id="{{ $custom->id }}"
                                multiple
                                accept=".pdf,.xlsx,.xls">
                            <div class="d-flex align-items-center mt-2">
                                <i class="bi bi-info-circle-fill text-amber-500 me-2"></i>
                                <small class="text-muted">
                                    Hanya PDF & Excel | Maksimal 30MB per file | Bisa upload lebih dari 1 file (opsional)
                                </small>
                            </div>
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill border border-danger">
                                    <i class="bi bi-file-pdf me-1"></i>PDF
                                </span>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill border border-success">
                                    <i class="bi bi-file-excel me-1"></i>Excel
                                </span>
                            </div>
                            <!-- Error message container -->
                            <div id="error-{{ $custom->id }}" class="alert alert-danger mt-2 d-none">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <span class="error-message"></span>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-secondary border-0 rounded-3">
                            <i class="bi bi-lock-fill me-2"></i> Upload dinonaktifkan
                        </div>
                        @endif
                    </div>
                    @endforeach

                    {{-- TAMBAH CUSTOM BARU --}}
                    @if (!$isApproved)
                    <template x-for="(custom, idx) in newCustomKategoris" :key="idx">
                        <div class="mb-4 p-4 border rounded-3 custom-kategori-item position-relative"
                            style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-left: 4px solid #10b981 !important;">

                            <button type="button"
                                @click="removeNewKategori(idx)"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2">
                                <i class="bi bi-trash"></i>
                            </button>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark mb-3 d-flex align-items-center">
                                    <i class="bi bi-plus-circle-fill text-emerald-600 me-2 fs-5"></i>
                                    Nama Kategori
                                    <span class="badge badge-success ms-2">Custom Baru</span>
                                </label>
                                <input type="text"
                                    class="form-control border-2 border-emerald-300 rounded-3"
                                    x-model="custom.nama"
                                    :name="'custom_kategori_nama_' + indikatorId + '_' + idx"
                                    placeholder="Contoh: SK Tambahan"
                                    required>
                            </div>

                            <div>
                                <label class="form-label fw-semibold text-dark mb-3 d-flex align-items-center">
                                    <i class="bi bi-cloud-upload-fill text-emerald-600 me-2 fs-5"></i>
                                    Upload File (Opsional)
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file"
                                        class="form-control border-2 border-dashed border-emerald-300 rounded-3 file-input"
                                        :name="'custom_kategori_file_' + indikatorId + '_' + idx + '[]'"
                                        :data-kategori-id="'new_' + indikatorId + '_' + idx"
                                        multiple
                                        accept=".pdf,.xlsx,.xls">
                                    <div class="d-flex align-items-center mt-2">
                                        <i class="bi bi-info-circle-fill text-emerald-500 me-2"></i>
                                        <small class="text-muted">
                                            Hanya PDF & Excel | Maksimal 30MB per file | Bisa upload lebih dari 1 file (opsional)
                                        </small>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill border border-danger">
                                            <i class="bi bi-file-pdf me-1"></i>PDF
                                        </span>
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill border border-success">
                                            <i class="bi bi-file-excel me-1"></i>Excel
                                        </span>
                                    </div>
                                    <!-- Error message container -->
                                    <div :id="'error-new_' + indikatorId + '_' + idx" class="alert alert-danger mt-2 d-none">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <span class="error-message"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <button type="button"
                        class="btn btn-add-kategori w-100 py-3 fw-semibold rounded-3 mt-3"
                        @click="addNewKategori()"
                        style="border: 2px dashed #3498db; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #3498db;">
                        <i class="bi bi-plus-circle me-2 fs-5"></i>
                        Tambah Kategori Upload Baru
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        {{-- SUBMIT --}}
        <div class="text-center mt-5">
            <button type="submit"
                class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm fw-bold"
                style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                <i class="bi bi-save me-2"></i>
                Simpan & Upload
            </button>
        </div>
    </form>

    {{-- Tombol Batalkan Pengiriman Seluruh Klaster --}}
    @php
    $hasPending = $penilaians->where('status', 'pending')->count() > 0;
    $hasApproved = $penilaians->where('status', 'approved')->count() > 0;
    @endphp

    @if ($hasPending && !$hasApproved)
    <form action="{{ route('desa.penilaian.cancelKlaster', $klaster->id) }}" method="POST"
        onsubmit="return confirm('Yakin ingin membatalkan semua penilaian di klaster ini? Semua data & berkas akan dihapus!')">
        @csrf
        @method('DELETE')
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-warning px-4 py-2 rounded-pill fw-semibold"
                style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="bi bi-x-circle me-2"></i>
                Batalkan Pengiriman Seluruh Klaster
            </button>
        </div>
    </form>
    @endif
</div>

{{-- STYLE --}}
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
    }

    .card-option {
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: white;
    }

    .card-option:hover {
        border-color: #3498db;
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15);
    }

    .card-option .form-check-input:checked {
        background-color: #3498db;
        border-color: #3498db;
    }

    .upload-section {
        border-color: #e2e8f0 !important;
        transition: all 0.3s ease;
    }

    .upload-section:hover {
        border-color: #3498db !important;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.1);
        transform: translateY(-1px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .alert {
        border-radius: 10px;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .custom-kategori-item {
        transition: all 0.3s ease;
    }

    .custom-kategori-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.15);
    }

    .btn-add-kategori {
        border: 2px dashed #3498db;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: #3498db;
        transition: all 0.3s ease;
    }

    .btn-add-kategori:hover {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        border-style: solid;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
    }

    .badge-custom {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .file-upload-wrapper input[type="file"] {
        padding: 12px;
        background: white;
    }

    .file-upload-wrapper input[type="file"]:hover {
        border-color: #3498db;
        background: #f8fafc;
    }

    /* File type badges */
    .badge.bg-blue-100 {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid #93c5fd;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .d-flex.flex-wrap.gap-3 {
            flex-direction: column;
            gap: 10px !important;
        }

        .card-option {
            width: 100%;
            text-align: left;
        }

        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .upload-section,
        .custom-kategori-item {
            padding: 1.25rem;
        }
    }

    /* Upload file input styling */
    .file-upload-wrapper input[type="file"]::-webkit-file-upload-button {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        margin-right: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-wrapper input[type="file"]::-webkit-file-upload-button:hover {
        background: linear-gradient(135deg, #2980b9 0%, #1c6ca4 100%);
        transform: translateY(-1px);
    }
</style>

{{-- ALPINE --}}
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('uploadManager', (indikatorId, isApproved) => ({
            indikatorId,
            isApproved,
            newCustomKategoris: [],
            addNewKategori() {
                this.newCustomKategoris.push({
                    nama: ''
                });
                // Smooth scroll to new category
                setTimeout(() => {
                    const lastCategory = document.querySelector('[x-for*="newCustomKategoris"]:last-of-type');
                    if (lastCategory) {
                        lastCategory.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }, 100);
            },
            removeNewKategori(index) {
                if (confirm('Hapus kategori ini?')) {
                    this.newCustomKategoris.splice(index, 1);
                }
            }
        }));
    });

    // Delete existing custom kategori (AJAX)
    async function deleteKategori(kategoriId, button) {
        if (!confirm('Yakin ingin menghapus kategori ini? Semua file terkait akan dihapus.')) {
            return;
        }

        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i>';
        button.disabled = true;

        try {
            const response = await fetch(`/desa/kategori-upload/${kategoriId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            if (result.success) {
                // Add fade out animation
                const element = button.closest('.custom-kategori-item');
                element.style.opacity = '0';
                element.style.transform = 'translateY(-10px)';
                element.style.transition = 'all 0.3s ease';

                setTimeout(() => {
                    element.remove();
                    // Show success toast
                    showToast('Kategori berhasil dihapus', 'success');
                }, 300);
            } else {
                showToast('Gagal menghapus kategori', 'error');
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'error');
            button.innerHTML = originalContent;
            button.disabled = false;
        }
    }

    // Toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
        <div class="toast-content">
            <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill'}"></i>
            <span>${message}</span>
        </div>
    `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Add toast styles
    const toastStyle = document.createElement('style');
    toastStyle.textContent = `
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 9999;
        min-width: 300px;
    }
    
    .toast-notification.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .toast-notification.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }
    
    .toast-notification.show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .toast-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .toast-content i {
        font-size: 1.2rem;
    }
`;
    document.head.appendChild(toastStyle);




    // ✅ FILE VALIDATION: PDF & Excel only, Max 30MB
    document.addEventListener('DOMContentLoaded', function() {
        const MAX_FILE_SIZE = 30 * 1024 * 1024; // 30MB in bytes
        const ALLOWED_TYPES = {
            'application/pdf': 'PDF',
            'application/vnd.ms-excel': 'Excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 'Excel',
            'application/vnd.ms-excel.sheet.macroEnabled.12': 'Excel'
        };
        const ALLOWED_EXTENSIONS = ['pdf', 'xls', 'xlsx', 'xlsm'];

        // Validate all file inputs
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                const kategoriId = this.dataset.kategoriId;
                const errorContainer = document.getElementById(`error-${kategoriId}`);
                const errorMessage = errorContainer?.querySelector('.error-message');

                // Clear previous errors
                if (errorContainer) {
                    errorContainer.classList.add('d-none');
                    if (errorMessage) errorMessage.textContent = '';
                }

                let errors = [];
                let validFiles = [];

                files.forEach((file, index) => {
                    // Get file extension
                    const extension = file.name.split('.').pop().toLowerCase();

                    // Validate extension
                    if (!ALLOWED_EXTENSIONS.includes(extension)) {
                        errors.push(`❌ File "${file.name}" bukan PDF atau Excel`);
                        return;
                    }

                    // Validate MIME type
                    if (!ALLOWED_TYPES[file.type] && !file.type.includes('excel') && file.type !== 'application/pdf') {
                        errors.push(`❌ File "${file.name}" memiliki tipe yang tidak valid`);
                        return;
                    }

                    // Validate file size
                    if (file.size > MAX_FILE_SIZE) {
                        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        errors.push(`❌ File "${file.name}" terlalu besar (${sizeMB}MB). Maksimal 30MB`);
                        return;
                    }

                    // File is valid
                    validFiles.push(file);
                });

                // Show errors if any
                if (errors.length > 0) {
                    if (errorContainer && errorMessage) {
                        errorMessage.innerHTML = errors.join('<br>');
                        errorContainer.classList.remove('d-none');
                    }

                    // Clear the input
                    e.target.value = '';

                    // Show alert
                    showToast(errors[0], 'error');
                    return;
                }

                // Show success message
                if (validFiles.length > 0) {
                    const fileNames = validFiles.map(f => f.name).join(', ');
                    const totalSize = (validFiles.reduce((sum, f) => sum + f.size, 0) / (1024 * 1024)).toFixed(2);
                    showToast(`✅ ${validFiles.length} file siap diupload (${totalSize}MB)`, 'success');
                }
            });
        });

        // Validate on form submit
        const form = document.querySelector('form[action*="penilaian.store"]');
        if (form) {
            form.addEventListener('submit', function(e) {
                let hasErrors = false;
                const fileInputs = document.querySelectorAll('.file-input');

                fileInputs.forEach(input => {
                    const files = Array.from(input.files);
                    if (files.length === 0) return; // Skip if no files selected

                    files.forEach(file => {
                        const extension = file.name.split('.').pop().toLowerCase();

                        // Check extension
                        if (!ALLOWED_EXTENSIONS.includes(extension)) {
                            hasErrors = true;
                            showToast(`❌ File "${file.name}" bukan PDF atau Excel`, 'error');
                        }

                        // Check size
                        if (file.size > MAX_FILE_SIZE) {
                            hasErrors = true;
                            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                            showToast(`❌ File "${file.name}" terlalu besar (${sizeMB}MB)`, 'error');
                        }
                    });
                });

                if (hasErrors) {
                    e.preventDefault();
                    showToast('⚠️ Perbaiki file yang error terlebih dahulu', 'error');
                    return false;
                }

                // Show loading overlay
                showLoadingOverlay();
            });
        }
    });

    // Loading overlay
    function showLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'upload-overlay';
        overlay.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; display: flex; align-items: center; justify-content: center;">
            <div style="background: white; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 fw-bold text-dark">Mengupload file...</p>
                <p class="text-muted small">Mohon tunggu, jangan tutup halaman ini</p>
            </div>
        </div>
    `;
        document.body.appendChild(overlay);
    }

    // Enhanced toast function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;

        const icon = type === 'success' ? 'bi-check-circle-fill' :
            type === 'error' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill';

        toast.innerHTML = `
        <div class="toast-content">
            <i class="bi ${icon}"></i>
            <span>${message}</span>
        </div>
    `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, type === 'error' ? 5000 : 3000); // Error messages stay longer
    }

    // Format file size helper
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
</script>
@endpush
@endsection