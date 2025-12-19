@extends('layouts.adminLayout')
@section('title', 'Verifikasi Penilaian | Indikator Klaster')

@section('content')
<div class="mb-6">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="flex flex-wrap items-center space-x-2 text-sm text-gray-600">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </li>
            <li class="flex items-center gap-2">
                <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('admin.penilaian') }}" class="text-blue-600 hover:text-blue-800">
                    Verifikasi Penilaian
                </a>
            </li>
            <li class="flex items-center gap-2">
                <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('admin.penilaian.desa', $desa->id) }}?tahun={{ request('tahun') }}&bulan={{ request('bulan') }}"
                    class="text-blue-600 hover:text-blue-800">
                    {{ $desa->nama_desa }}
                </a>
            </li>
            <li class="flex items-center gap-2">
                <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                <span class="font-medium">{{ $klaster->title }}</span>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center shadow-md">
                    <i class="bi bi-list-check text-white text-lg"></i>
                </div>
                Klaster "{{ $klaster->title }}"
            </h2>
            <p class="text-gray-600 mt-2 flex items-center gap-2 text-sm">
                <i class="bi bi-building text-blue-500"></i>
                Desa {{ $desa->nama_desa }} •
                <i class="bi bi-calendar-check text-blue-500"></i>
                {{ request('bulan', now()->format('F')) }} {{ request('tahun', now()->year) }}
            </p>
        </div>

        <a href="{{ route('admin.penilaian.desa', $desa->id) }}?tahun={{ request('tahun') }}&bulan={{ request('bulan') }}"
            class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold text-sm">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Daftar Klaster
        </a>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table id="tableIndikator" class="w-full text-sm">
            <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                <tr>
                    <th class="py-4 px-4 text-left font-semibold min-w-12">No</th>
                    <th class="py-4 px-6 text-left font-semibold">Indikator</th>
                    <th class="py-4 px-4 text-center font-semibold min-w-20">Nilai</th>
                    <th class="py-4 px-6 text-left font-semibold min-w-40">Opsi Dipilih</th>
                    <th class="py-4 px-4 text-center font-semibold min-w-28">Status</th>
                    <th class="py-4 px-4 text-center font-semibold min-w-24">Catatan</th>
                    <th class="py-4 px-6 text-left font-semibold min-w-56">Dokumen (Kategori)</th>
                    <th class="py-4 px-4 text-center font-semibold min-w-28">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($penilaians as $i => $p)
                @php
                    $berkasGrouped = $p->berkasUploads->groupBy('kategori_upload_id');
                @endphp
                <tr id="row-{{ $p->id }}" class="hover:bg-blue-50 transition-all duration-200">
                    <!-- No -->
                    <td class="px-4 py-4 text-gray-600 font-medium">
                        {{ $loop->iteration }}
                    </td>

                    <!-- Indikator -->
                    <td class="px-6 py-4 align-top">
                        <p class="font-semibold text-gray-800 leading-relaxed break-words">
                            {{ $p->indikator->nama_indikator }}
                        </p>

                        @if ($p->status == 'rejected' && $p->rejection_reason)
                        <div class="mt-3 p-3 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <p class="text-xs font-semibold text-red-800 mb-1">
                                <i class="bi bi-exclamation-triangle-fill mr-1"></i> Alasan Penolakan
                            </p>
                            <p class="text-xs text-red-700 leading-relaxed">
                                {{ $p->rejection_reason }}
                            </p>
                        </div>
                        @endif
                    </td>

                    <!-- Nilai -->
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-800 rounded-full font-bold text-lg">
                            {{ $p->nilai ?? '-' }}
                        </span>
                    </td>

                    <!-- Opsi Dipilih -->
                    <td class="px-6 py-4">
                        @php
                            $opsiDipilih = $p->indikator->opsiNilai->firstWhere('poin', $p->nilai);
                        @endphp
                        @if ($opsiDipilih)
                            <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-medium">
                                {{ $opsiDipilih->label }}
                            </span>
                        @else
                            <span class="text-gray-400 italic text-xs">-</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold
                            {{ $p->status == 'approved' ? 'bg-green-100 text-green-800' :
                               ($p->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            <i class="bi {{ $p->status == 'approved' ? 'bi-check-circle' : ($p->status == 'pending' ? 'bi-clock' : 'bi-x-circle') }}"></i>
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>

                    <!-- Catatan -->
                    <td class="px-4 py-4 text-center">
                        @if ($p->catatan)
                            <button onclick="toggleCatatan({{ $p->id }})"
                                class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                                <i class="bi bi-eye mr-1"></i>Lihat
                            </button>
                        @else
                            <span class="text-gray-400 italic text-xs">-</span>
                        @endif
                    </td>

                    <!-- Dokumen per Kategori (Collapsible) -->
                    <td class="px-6 py-4 align-top">
                        @if($berkasGrouped->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($berkasGrouped as $kategoriId => $berkasList)
                                    @php
                                        $kategori = $berkasList->first()->kategoriUpload ?? null;
                                        $kategoriName = $kategori ? $kategori->nama_kategori : 'Tanpa Kategori';
                                    @endphp

                                    <div class="border border-blue-200 rounded-xl overflow-hidden bg-blue-25">
                                        <!-- Header Kategori -->
                                        <button
                                            onclick="toggleKategori({{ $p->id }}, {{ $kategoriId ?? 0 }})"
                                            class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white flex items-center justify-between hover:from-blue-600 hover:to-blue-700 transition">
                                            <div class="flex items-center gap-2">
                                                <i class="bi bi-folder2"></i>
                                                <span class="font-medium text-sm">{{ $kategoriName }}</span>
                                                <span class="bg-white/20 px-2.5 py-1 rounded-full text-xs font-bold">
                                                    {{ $berkasList->count() }}
                                                </span>
                                            </div>
                                            <i class="bi bi-chevron-down transition-transform duration-300" id="icon-{{ $p->id }}-{{ $kategoriId ?? 0 }}"></i>
                                        </button>

                                        <!-- Daftar File -->
                                        <div id="files-{{ $p->id }}-{{ $kategoriId ?? 0 }}" class="bg-white px-4 py-3 space-y-2 hidden">
                                            @foreach($berkasList as $b)
                                                @php
                                                    $filename = basename($b->path_file);
                                                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                                    $icon = match($ext) {
                                                        'pdf' => 'bi-file-earmark-pdf text-red-600',
                                                        'jpg','jpeg','png','gif' => 'bi-file-earmark-image text-green-600',
                                                        'doc','docx' => 'bi-file-earmark-word text-blue-600',
                                                        'xls','xlsx' => 'bi-file-earmark-excel text-green-700',
                                                        default => 'bi-file-earmark text-gray-600'
                                                    };
                                                @endphp
                                                <a href="{{ env('SUPABASE_URL') }}/storage/v1/object/public/{{ env('SUPABASE_STORAGE_BUCKET') }}/{{ $b->path_file }}"
                                                   target="_blank"
                                                   class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg hover:bg-blue-50 hover:shadow transition group">
                                                    <i class="bi {{ $icon }} text-lg"></i>
                                                    <span class="text-xs text-gray-700 truncate group-hover:text-blue-600 group-hover:underline">
                                                        {{ $filename }}
                                                    </span>
                                                    <i class="bi bi-box-arrow-up-right text-gray-400 text-xs group-hover:text-blue-600"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">Tidak ada dokumen</span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="px-4 py-4 text-center">
                        @if ($p->status == 'pending')
                            <div class="flex justify-center gap-3">
                                <button class="w-10 h-10 bg-green-500 text-white rounded-xl hover:bg-green-600 transition shadow-md btn-approve"
                                        data-id="{{ $p->id }}" title="Setujui">
                                    <i class="bi bi-check-lg text-lg"></i>
                                </button>
                                <button class="w-10 h-10 bg-red-500 text-white rounded-xl hover:bg-red-600 transition shadow-md btn-reject"
                                        data-id="{{ $p->id }}" title="Tolak">
                                    <i class="bi bi-x-lg text-lg"></i>
                                </button>
                            </div>
                        @else
                            <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>

                <!-- Row Catatan (Hidden by default) -->
                @if ($p->catatan)
                <tr id="catatan-{{ $p->id }}" class="hidden bg-blue-50">
                    <td colspan="8" class="px-8 py-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-chat-left-text text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-blue-900 mb-2">Catatan dari Desa</p>
                                <p class="text-gray-700 leading-relaxed">{{ $p->catatan->catatan }}</p>
                                <p class="text-xs text-gray-500 mt-3">
                                    Oleh <span class="font-medium">{{ $p->catatan->user->name }}</span> •
                                    {{ $p->catatan->updated_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="8" class="py-16 text-center text-gray-500">
                        <div class="flex flex-col items-center gap-4">
                            <i class="bi bi-inbox text-5xl text-gray-300"></i>
                            <p class="font-medium">Tidak ada data penilaian untuk klaster ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Toggle catatan
    function toggleCatatan(id) {
        const row = document.getElementById('catatan-' + id);
        row.classList.toggle('hidden');
    }

    // Toggle kategori dokumen
    function toggleKategori(penilaianId, kategoriId) {
        const filesDiv = document.getElementById(`files-${penilaianId}-${kategoriId}`);
        const icon = document.getElementById(`icon-${penilaianId}-${kategoriId}`);

        filesDiv.classList.toggle('hidden');
        if (filesDiv.classList.contains('hidden')) {
            icon.style.transform = 'rotate(0deg)';
        } else {
            icon.style.transform = 'rotate(180deg)';
        }
    }

    // Approve & Reject functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Approve
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = this.dataset.id;
                const row = document.getElementById(`row-${id}`);

                const result = await Swal.fire({
                    title: 'Setujui Penilaian?',
                    text: 'Penilaian ini akan disetujui dan tidak dapat diubah lagi.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Setujui',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#6b7280',
                    customClass: { popup: 'rounded-2xl' }
                });

                if (result.isConfirmed) {
                    this.innerHTML = '<div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';
                    this.disabled = true;

                    try {
                        const res = await fetch(`/admin/penilaian/${id}/approve`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();

                        if (data.success) {
                            Swal.fire('Disetujui!', data.message, 'success');
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-50px)';
                            setTimeout(() => row.remove(), 400);
                        }
                    } catch (err) {
                        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                        this.innerHTML = '<i class="bi bi-check-lg text-lg"></i>';
                        this.disabled = false;
                    }
                }
            });
        });

        // Reject
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = this.dataset.id;
                const row = document.getElementById(`row-${id}`);

                const result = await Swal.fire({
                    title: 'Tolak Penilaian',
                    html: `
                        <div class="text-left space-y-3">
                            <label class="block font-medium text-gray-700">Alasan Penolakan</label>
                            <select id="reason-select" class="swal2-select w-full">
                                <option value="">-- Pilih alasan --</option>
                                <option value="Data tidak lengkap">Data tidak lengkap</option>
                                <option value="Format dokumen salah">Format dokumen salah</option>
                                <option value="Bukti tidak valid">Bukti tidak valid</option>
                                <option value="Nilai tidak sesuai">Nilai tidak sesuai</option>
                                <option value="other">Lainnya...</option>
                            </select>
                            <textarea id="reason-manual" class="swal2-textarea w-full" placeholder="Tulis alasan lain..." rows="4" style="display:none;"></textarea>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Tolak',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                    preConfirm: () => {
                        const select = document.getElementById('reason-select').value;
                        const manual = document.getElementById('reason-manual').value.trim();
                        if (!select && !manual) {
                            Swal.showValidationMessage('Harus memilih atau mengisi alasan');
                            return false;
                        }
                        if (select === 'other' && !manual) {
                            Swal.showValidationMessage('Harus mengisi alasan lainnya');
                            return false;
                        }
                        return select === 'other' ? manual : select;
                    },
                    didOpen: () => {
                        document.getElementById('reason-select').addEventListener('change', function () {
                            const manual = document.getElementById('reason-manual');
                            manual.style.display = this.value === 'other' ? 'block' : 'none';
                        });
                    }
                });

                if (result.isConfirmed) {
                    Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                    try {
                        const res = await fetch(`/admin/penilaian/${id}/reject`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ reason: result.value })
                        });
                        const data = await res.json();

                        if (data.success) {
                            Swal.fire('Ditolak!', 'Penilaian telah ditolak dengan alasan.', 'success');
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-50px)';
                            setTimeout(() => row.remove(), 400);
                        }
                    } catch (err) {
                        Swal.fire('Error', 'Gagal memproses penolakan', 'error');
                    }
                }
            });
        });
    });
</script>

<style>
    /* Table responsive & clean */
    #tableIndikator th, #tableIndikator td {
        vertical-align: top;
    }

    @media (max-width: 1024px) {
        #tableIndikator {
            font-size: 0.8125rem;
        }
        #tableIndikator th, #tableIndikator td {
            padding: 0.75rem 0.5rem;
        }
    }

    @media (max-width: 768px) {
        #tableIndikator {
            font-size: 0.75rem;
        }
        #tableIndikator th, #tableIndikator td {
            padding: 0.5rem 0.375rem;
        }
        .truncate {
            max-width: 10rem;
        }
    }

    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 999px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 999px;
    }

    /* Smooth row removal */
    #tableIndikator tbody tr {
        transition: all 0.4s ease;
    }
</style>
@endsection