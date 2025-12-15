@extends('layouts.desaLayout')
@section('content')
<div class="container">
    {{-- HEADER --}}
    <div class="text-center mb-5">
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
                            <div class="mb-4 p-3 border rounded-3 bg-light">
                                <label class="form-label fw-semibold text-dark mb-2">
                                    <i class="bi bi-file-earmark me-2 text-primary"></i>
                                    {{ $upload->nama_kategori }}
                                </label>
                                {{-- Show existing files --}}
                                @if ($berkasFiles->count() > 0)
                                <div class="alert alert-success border-0 bg-success bg-opacity-10 py-2 mb-2">
                                    <div class="fw-medium mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        File yang sudah diunggah:
                                    </div>
                                    @foreach ($berkasFiles as $berkas)
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $berkas->path_file }}"
                                           target="_blank"
                                           class="text-decoration-none text-primary">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>
                                            {{ basename($berkas->path_file) }}
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                @if (!$isApproved)
                                <input type="file"
                                       name="file_{{ $upload->id }}[]"
                                       class="form-control border-primary border-opacity-25"
                                       multiple
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls">
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Bisa upload lebih dari 1 file (tekan Ctrl/Cmd untuk pilih banyak)
                                </small>
                                @else
                                <input type="file" class="form-control" disabled>
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
                            <div class="mb-3 p-3 border rounded-3 custom-kategori-item position-relative">
                                @if (!$isApproved)
                                    <button type="button"
                                            onclick="deleteKategori({{ $custom->id }}, this)"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                            title="Hapus kategori ini">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                                <label class="form-label fw-semibold text-dark mb-2">
                                    <i class="bi bi-tag me-2 text-warning"></i>
                                    {{ $custom->nama_kategori }}
                                    <span class="badge badge-custom ms-2">Custom</span>
                                </label>
                                {{-- Show existing files --}}
                                @if ($customBerkasFiles->count() > 0)
                                <div class="alert alert-warning border-0 bg-warning bg-opacity-10 py-2 mb-2">
                                    <div class="fw-medium mb-2">
                                        <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                        File yang sudah diunggah:
                                    </div>
                                    @foreach ($customBerkasFiles as $berkas)
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $berkas->path_file }}"
                                           target="_blank"
                                           class="text-decoration-none text-warning">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>
                                            {{ basename($berkas->path_file) }}
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                @if (!$isApproved)
                                <input type="file"
                                       name="file_{{ $custom->id }}[]"
                                       class="form-control"
                                       multiple
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls">
                                @else
                                <input type="file" class="form-control" disabled>
                                @endif
                            </div>
                        @endforeach
                        {{-- TAMBAH CUSTOM BARU --}}
                        @if (!$isApproved)
                            <template x-for="(custom, idx) in newCustomKategoris" :key="idx">
                                <div class="mb-4 p-3 border rounded-3 custom-kategori-item position-relative">
                                    <button type="button"
                                            @click="removeNewKategori(idx)"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark mb-2">
                                            <i class="bi bi-tag me-2 text-warning"></i>
                                            Nama Kategori
                                            <span class="badge badge-custom ms-2">Custom Baru</span>
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               x-model="custom.nama"
                                               :name="'custom_kategori_nama_' + indikatorId + '_' + idx"
                                               placeholder="Contoh: SK Tambahan"
                                               required>
                                    </div>
                                    <div>
                                        <label class="form-label fw-semibold text-dark mb-2">
                                            <i class="bi bi-cloud-upload me-2 text-warning"></i>
                                            Upload File (Opsional)
                                        </label>
                                        <input type="file"
                                               class="form-control"
                                               :name="'custom_kategori_file_' + indikatorId + '_' + idx + '[]'"
                                               multiple
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls">
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Bisa upload lebih dari 1 file (opsional)
                                        </small>
                                    </div>
                                </div>
                            </template>
                            <button type="button"
                                    class="btn btn-add-kategori w-100 py-3 fw-semibold"
                                    @click="addNewKategori()">
                                <i class="bi bi-plus-circle me-2"></i>
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
                    class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm fw-bold">
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
            <button type="submit" class="btn btn-warning px-4 py-2 rounded-pill fw-semibold">
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
    .custom-kategori-item {
        background: linear-gradient(135deg, #fff9e6 0%, #fff3cc 100%);
        border-left: 4px solid #f39c12 !important;
    }
    .btn-add-kategori {
        border: 2px dashed #3498db;
        background: transparent;
        color: #3498db;
        transition: all 0.3s ease;
    }
    .btn-add-kategori:hover {
        background: #3498db;
        color: white;
        border-style: solid;
    }
    .badge-custom {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
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
            this.newCustomKategoris.push({ nama: '' });
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
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split"></i>';
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
            button.closest('.custom-kategori-item').remove();
            alert('✅ Kategori berhasil dihapus');
        } else {
            alert('❌ Gagal menghapus kategori');
            button.disabled = false;
            button.innerHTML = '<i class="bi bi-trash"></i>';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan');
        button.disabled = false;
        button.innerHTML = '<i class="bi bi-trash"></i>';
    }
}
</script>
@endpush
@endsection