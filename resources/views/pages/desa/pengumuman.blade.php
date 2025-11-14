@extends('layouts.desaLayout')

@section('title', 'Pengumuman')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="bi bi-megaphone text-white text-lg"></i>
                    </div>
                    Pengumuman
                </h2>
                <p class="text-gray-600 mt-2">Informasi dan pengumuman terbaru untuk desa Anda</p>
            </div>

            <!-- Stats Badge -->
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-xl font-semibold">
                    <i class="bi bi-envelope"></i>
                    {{ $pengumumans->total() }} Pengumuman
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-4 mb-6">
        <form method="GET" class="flex flex-col lg:flex-row gap-3">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengumuman..."
                        class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Filter Bulan -->
            <select name="bulan" class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Bulan</option>
                @foreach ($bulanList as $num => $nama)
                    <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                @endforeach
            </select>

            <!-- Filter Tahun -->
            <select name="tahun" class="px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Tahun</option>
                @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>

            <!-- Buttons -->
            <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold">
                <i class="bi bi-funnel"></i> Filter
            </button>

            @if (request()->anyFilled(['search', 'bulan', 'tahun']))
                <a href="{{ route('desa.pengumuman') }}"
                    class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all duration-200 font-semibold">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Pengumuman Cards -->
    @if ($pengumumans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach ($pengumumans as $item)
                <div
                    class="bg-white rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <!-- Header Card -->
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <h3 class="font-bold text-gray-800 text-lg line-clamp-2 flex-1">
                                {{ $item->judul }}
                            </h3>

                            @if ($item->created_at->diffInDays(now()) <= 7)
                                <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                                    BARU
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="bi bi-calendar-event"></i>
                            <span>{{ $item->created_at->format('d M Y') }}</span>
                            <span>•</span>
                            <i class="bi bi-clock"></i>
                            <span>{{ $item->created_at->format('H:i') }}</span>
                        </div>
                    </div>

                    <!-- Content Preview -->
                    <div class="p-5">
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($item->isi), 120) }}
                        </p>

                        <!-- File Attachment -->
                        @if ($item->file)
                            <div class="flex items-center gap-2 p-3 bg-blue-50 border border-blue-200 rounded-lg mb-4">
                                <i class="bi bi-paperclip text-blue-600"></i>
                                <span class="text-sm text-gray-700 truncate flex-1">
                                    {{ basename($item->file) }}
                                </span>
                            </div>
                        @endif

                        <!-- Actions -->
                        <button onclick="showDetail({{ $item->id }})"
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold flex items-center justify-center gap-2 group-hover:scale-105">
                            <i class="bi bi-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($pengumumans->hasPages())
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-4">
                {{ $pengumumans->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-inbox text-gray-400 text-5xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Pengumuman</h3>
            <p class="text-gray-600 mb-4">
                @if (request()->anyFilled(['search', 'bulan', 'tahun']))
                    Tidak ada pengumuman yang sesuai dengan pencarian Anda.
                @else
                    Belum ada pengumuman untuk desa Anda saat ini.
                @endif
            </p>
            @if (request()->anyFilled(['search', 'bulan', 'tahun']))
                <a href="{{ route('desa.pengumuman') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 font-semibold">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Lihat Semua Pengumuman
                </a>
            @endif
        </div>
    @endif

    <!-- Modal Detail -->
    <div id="modalDetail" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white p-6 flex items-center justify-between">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="bi bi-megaphone"></i>
                    <span id="modalJudul">Loading...</span>
                </h3>
                <button onclick="closeModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                <!-- Tanggal -->
                <div class="flex items-center gap-2 text-gray-500 text-sm mb-4 pb-4 border-b">
                    <i class="bi bi-calendar-check"></i>
                    <span id="modalTanggal">-</span>
                </div>

                <!-- Isi Pengumuman -->
                <div class="prose max-w-none mb-6">
                    <div id="modalIsi" class="text-gray-700 leading-relaxed whitespace-pre-wrap"></div>
                </div>

                <!-- File Attachment -->
                <div id="modalFileContainer" class="hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-file-earmark-text text-white text-2xl"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">File Lampiran</p>
                                    <p class="text-sm text-gray-500" id="modalFileName">document.pdf</p>
                                </div>
                            </div>
                            <a id="modalFileLink" href="#" target="_blank"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                <i class="bi bi-download"></i>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 bg-gray-50 border-t flex justify-end">
                <button onclick="closeModal()"
                    class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all duration-200 font-semibold">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const modal = document.getElementById('modalDetail');

        async function showDetail(id) {
            // Show modal with loading state
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('modalJudul').textContent = 'Memuat...';
            document.getElementById('modalIsi').textContent = 'Memuat pengumuman...';

            try {
                const response = await fetch(`/desa/pengumuman/${id}`);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;

                    // Update modal content
                    document.getElementById('modalJudul').textContent = data.judul;
                    document.getElementById('modalTanggal').textContent = data.created_at;
                    document.getElementById('modalIsi').textContent = data.isi;

                    // Show/hide file attachment
                    const fileContainer = document.getElementById('modalFileContainer');
                    if (data.file_url) {
                        fileContainer.classList.remove('hidden');
                        document.getElementById('modalFileName').textContent = data.file_name;
                        document.getElementById('modalFileLink').href = data.file_url;
                    } else {
                        fileContainer.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error loading detail:', error);
                document.getElementById('modalIsi').textContent = 'Gagal memuat pengumuman.';
            }
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal on outside click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    </script>

    <style>
        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth modal animation */
        #modalDetail {
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Prose styling for content */
        .prose {
            line-height: 1.75;
        }

        .prose p {
            margin-bottom: 1em;
        }
    </style>
@endsection
