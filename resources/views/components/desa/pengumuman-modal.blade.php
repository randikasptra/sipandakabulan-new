<!-- Modal Detail Pengumuman -->
<div id="modalDetail" class="fixed inset-0 bg-black bg-opacity-50 z-[100] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden animate-modal">
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

<script>
    const modal = document.getElementById('modalDetail');

    async function showDetail(id) {
        // Show modal with loading state
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden'; // Prevent body scroll

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
        document.body.style.overflow = ''; // Restore body scroll
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
    /* Smooth modal animation */
    .animate-modal {
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
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
