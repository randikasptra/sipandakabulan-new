@extends('layouts.desaLayout')

@section('content')
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-4">Form Penilaian Klaster {{ $klaster->title }}</h2>
            <p class="text-muted">Isi sesuai kondisi lapangan dan unggah dokumen pendukung untuk memastikan penilaian yang
                akurat dan transparan.</p>
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

        {{-- FORM PENILAIAN --}}
        <form action="{{ route('desa.penilaian.store') }}" method="POST" enctype="multipart/form-data" id="form-penilaian">
            @csrf

            @foreach ($klaster->indikators as $index => $indikator)
                @php
                    $penilaian = $penilaians[$indikator->id] ?? null;
                    $isApproved = $penilaian && $penilaian->status === 'approved';
                @endphp

                <div class="card mb-4 border-0 shadow-lg" 
                     x-data="uploadManager({{ $indikator->id }}, '{{ $indikator->nama_indikator }}', {{ $isApproved ? 'true' : 'false' }})">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="fw-bold mb-0">
                                    <i class="bi bi-list-ol me-2"></i>
                                    {{ $index + 1 }}. {{ $indikator->nama_indikator }}
                                </h5>

                                {{-- BADGE STATUS --}}
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
                            <h6 class="fw-semibold text-dark mb-3">
                                <i class="bi bi-ui-radios me-2 text-primary"></i>
                                Pilih Nilai:
                            </h6>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($indikator->opsiNilai as $opsi)
                                    <div class="form-check card-option">
                                        <input class="form-check-input" type="radio" name="indikator_{{ $indikator->id }}"
                                            id="opsi_{{ $opsi->id }}" value="{{ $opsi->poin }}"
                                            @checked(optional($penilaian)->nilai == $opsi->poin) {{ $isApproved ? 'disabled' : '' }}>
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
                        <div class="upload-section">
                            <h6 class="fw-semibold text-dark mb-3">
                                <i class="bi bi-cloud-upload me-2 text-primary"></i>
                                Unggah Dokumen Pendukung
                            </h6>

                                {{-- Kategori Default (dari seeder) --}}
                                @foreach ($indikator->kategoriUploads->where('is_custom', false) as $upload)
                                    @php
                                        $berkasFiles = \App\Models\BerkasUpload::whereHas('penilaian', function ($q) use ($indikator) {
                                            $q->where('indikator_id', $indikator->id)
                                                ->where('desa_id', Auth::user()->desa_id)
                                                ->where('bulan', now()->format('F'))
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

                                {{-- Kategori Custom (user-defined) --}}
                                @php
                                    $customKategoris = $indikator->kategoriUploads->where('is_custom', true)->where('desa_id', Auth::user()->desa_id);
                                @endphp

                                @foreach ($customKategoris as $custom)
                                    @php
                                        $customBerkasFiles = \App\Models\BerkasUpload::whereHas('penilaian', function ($q) use ($indikator) {
                                            $q->where('indikator_id', $indikator->id)
                                                ->where('desa_id', Auth::user()->desa_id)
                                                ->where('bulan', now()->format('F'))
                                                ->where('tahun', now()->year);
                                        })
                                        ->where('kategori_upload_id', $custom->id)
                                        ->get();
                                    @endphp

                                    <div class="mb-4 p-3 border rounded-3 custom-kategori-item position-relative">
                                        @if (!$isApproved)
                                            <button 
                                                type="button"
                                                onclick="deleteKategori({{ $custom->id }}, this)"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                title="Hapus kategori ini"
                                            >
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

                                {{-- Form Tambah Kategori Baru (Alpine.js) --}}
                                @if (!$isApproved)
                                    <template x-for="(custom, idx) in newCustomKategoris" :key="idx">
                                        <div class="mb-4 p-3 border rounded-3 custom-kategori-item position-relative">
                                            <button 
                                                @click="removeNewKategori(idx)"
                                                type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark mb-2">
                                                    <i class="bi bi-tag me-2 text-warning"></i>
                                                    Nama Kategori
                                                    <span class="badge badge-custom ms-2">Custom Baru</span>
                                                </label>
                                                <input 
                                                    type="text"
                                                    x-model="custom.nama"
                                                    :name="'custom_kategori_nama_' + {{ $indikator->id }} + '_' + idx"
                                                    placeholder="Contoh: SK Tambahan XYZ"
                                                    class="form-control"
                                                    required
                                                >
                                            </div>

                                            <div>
                                                <label class="form-label fw-semibold text-dark mb-2">
                                                    <i class="bi bi-cloud-upload me-2 text-warning"></i>
                                                    Upload File
                                                </label>
                                                <input 
                                                    type="file"
                                                    :name="'custom_kategori_file_' + {{ $indikator->id }} + '_' + idx + '[]'"
                                                    class="form-control"
                                                    multiple
                                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls"
                                                    @change="custom.files = Array.from($event.target.files)"
                                                    required
                                                >
                                                <small class="text-muted d-block mt-1">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Bisa upload lebih dari 1 file
                                                </small>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Tombol Tambah Kategori --}}
                                    <button 
                                        @click="addNewKategori()"
                                        type="button"
                                        class="btn btn-add-kategori w-100 py-3 fw-semibold"
                                    >
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Tambah Kategori Upload Baru
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Tombol Simpan --}}
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm fw-bold">
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

    @push('scripts')
    <script>
        // ✅ Register Alpine component SEBELUM Alpine start
        document.addEventListener('alpine:init', () => {
            Alpine.data('uploadManager', (indikatorId, nama, isApproved) => ({
                indikatorId: indikatorId,
                indikatorNama: nama,
                isApproved: isApproved,
                newCustomKategoris: [],

                init() {
                    console.log('Upload manager initialized for indikator:', this.indikatorId);
                },

                addNewKategori() {
                    console.log('Adding new kategori for indikator:', this.indikatorId);
                    this.newCustomKategoris.push({
                        nama: '',
                        files: null
                    });
                    console.log('Total custom kategoris:', this.newCustomKategoris.length);
                },

                removeNewKategori(index) {
                    if (confirm('Hapus kategori ini?')) {
                        this.newCustomKategoris.splice(index, 1);
                    }
                }
            }));
        });
    </script>

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

        // Handle form submit dengan custom kategoris
        document.getElementById('form-penilaian').addEventListener('submit', async function(e) {
            const customInputs = document.querySelectorAll('[name^="custom_kategori_nama_"]');
            
            if (customInputs.length === 0) {
                return; // No custom kategoris, submit normally
            }

            e.preventDefault();

            const formData = new FormData(this);
            const customKategoris = [];

            // Collect custom kategori data
            customInputs.forEach((input, idx) => {
                const nama = input.value;
                const indikatorId = input.name.match(/custom_kategori_nama_(\d+)_/)[1];
                
                if (nama) {
                    customKategoris.push({
                        nama: nama,
                        indikator_id: parseInt(indikatorId)
                    });
                }
            });

            try {
                // 1. Save custom kategoris first
                for (let i = 0; i < customKategoris.length; i++) {
                    const response = await fetch('/desa/kategori-upload/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(customKategoris[i])
                    });

                    // ✅ Debug: Log response
                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);

                    // ✅ Cek jika response bukan JSON (error page)
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        console.error('Response bukan JSON:', text.substring(0, 500));
                        alert('❌ Server error! Lihat console untuk detail.');
                        return;
                    }

                    const result = await response.json();
                    
                    if (result.success) {
                        // Update form with new kategori ID
                        const indikatorId = customKategoris[i].indikator_id;
                        const fileInputName = `custom_kategori_file_${indikatorId}_${i}[]`;
                        const fileInput = document.querySelector(`[name="${fileInputName}"]`);
                        
                        if (fileInput && fileInput.files.length > 0) {
                            // Remove old input
                            fileInput.remove();
                            
                            // Create new input with correct kategori ID
                            const newInput = document.createElement('input');
                            newInput.type = 'file';
                            newInput.name = `file_${result.data.id}[]`;
                            newInput.multiple = true;
                            newInput.style.display = 'none';
                            
                            // Transfer files
                            const dataTransfer = new DataTransfer();
                            for (let file of fileInput.files) {
                                dataTransfer.items.add(file);
                            }
                            newInput.files = dataTransfer.files;
                            
                            this.appendChild(newInput);
                        }
                    }
                }

                // 2. Submit form normally
                this.submit();

            } catch (error) {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat menyimpan kategori custom');
            }
        });
    </script>
    @endpush
@endsection