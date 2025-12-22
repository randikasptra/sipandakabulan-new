@extends('layouts.desaLayout')

@section('title', 'Tutorial Penggunaan SIPANDAKABULAN')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 mt-24">
        {{-- HEADER --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                <i class="bi bi-journal-code text-white text-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Panduan Lengkap Pengisian Penilaian Desa</h2>
        </div>

        {{-- CARD WRAPPER --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 p-6">
            <p class="text-gray-600 mb-6">
                Ikuti panduan langkah demi langkah untuk mengisi dan menyelesaikan penilaian Desa Layak Anak.
                Pastikan semua indikator di semua klaster mencapai status <b class="text-green-600">DISETUJUI</b>.
            </p>

            {{-- ACCORDION --}}
            <div class="space-y-4" id="accordion">
                {{-- STEP 1: MEMILIH KLASTER --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(1)" class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                            <span class="font-semibold text-gray-800">Memulai: Memilih Klaster dari Dashboard</span>
                        </div>
                        <i id="icon-1" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-1" class="hidden p-6 text-gray-600 leading-relaxed">
                        <div class="mb-4 rounded-xl overflow-hidden border border-gray-300 shadow-md">
                            <img src="{{ asset('images/tutorial/1.png') }}" alt="Dashboard Klaster" class="w-full h-auto object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/800x300/3b82f6/ffffff?text=Gambar+1+Dashboard+Klaster'">
                            <div class="bg-gray-800 text-white p-3 text-sm text-center">Gambar 1: Dashboard untuk memilih klaster yang akan diisi.</div>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-3">🎯 Langkah-Langkah:</h4>
                        <ol class="list-decimal pl-5 space-y-2">
                            <li>Buka <b>Dashboard Utama</b> untuk melihat daftar semua klaster (Kelembagaan, Hak Sipil, dll).</li>
                            <li>Perhatikan <b>status warna</b> pada setiap kartu klaster.
                                <ul class="list-disc pl-5 mt-2 text-sm">
                                    <li><b class="text-gray-500">Abu-abu</b>: Belum mulai diisi.</li>
                                    <li><b class="text-yellow-600">Kuning</b>: Sudah diisi, status <b>MENUNGGU</b> review admin.</li>
                                    <li><b class="text-red-600">Merah</b>: <b>DITOLAK</b>, perlu diulang.</li>
                                    <li><b class="text-green-600">Hijau</b>: <b>DISETUJUI</b>, selesai.</li>
                                </ul>
                            </li>
                            <li>Klik tombol <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm rounded-lg font-medium shadow"> <i class="bi bi-pencil-square"></i> Proses Penilaian </span> pada klaster yang ingin dikerjakan (prioritaskan yang kuning atau merah).</li>
                        </ol>
                    </div>
                </div>

                {{-- STEP 2: MENGISI INDIKATOR & DOWNLOAD TEMPLATE --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(2)" class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                            <span class="font-semibold text-gray-800">Mengisi Indikator dan Download Panduan</span>
                        </div>
                        <i id="icon-2" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-2" class="hidden p-6 text-gray-600 leading-relaxed">
                        <div class="mb-4 rounded-xl overflow-hidden border border-gray-300 shadow-md">
                            <img src="{{ asset('images/tutorial/2.png') }}" alt="Form Indikator" class="w-full h-auto object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/800x300/10b981/ffffff?text=Gambar+2+Form+Indikator'">
                            <div class="bg-gray-800 text-white p-3 text-sm text-center">Gambar 2: Halaman untuk memilih poin indikator dan mengunggah dokumen.</div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">📝 Isi Poin Indikator:</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    <li>Pilih <b>poin nilai</b> (misal: 0, 5, 10) yang sesuai dengan kondisi lapangan di desa Anda.</li>
                                    <li>Isi <b>Catatan</b> opsional untuk memberikan penjelasan tambahan.</li>
                                    <li>Gunakan tombol <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-sm rounded-lg font-medium shadow"> <i class="bi bi-download"></i> Download Template Excel </span> sebagai panduan untuk format data yang perlu diunggah.</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">📎 Dokumen Pendukung:</h4>
                                <p class="text-sm mb-2">Dokumen pendukung bersifat <b>opsional</b>, tetapi sangat disarankan untuk memperkuat penilaian.</p>
                                <p class="text-xs text-gray-500">Format yang didukung: PDF, Excel,  (maks. 30MB per file).</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 3 & 4: UPLOAD DINAMIS DI KELEMBAGAAN --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(3)" class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                            <span class="font-semibold text-gray-800">Upload Dinamis: Contoh di Klaster Kelembagaan</span>
                        </div>
                        <i id="icon-3" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-3" class="hidden p-6 text-gray-600 leading-relaxed">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/3.png') }}" alt="Upload Dokumen Patokan" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x250/8b5cf6/ffffff?text=Gambar+3+Upload+Dokumen+Patokan'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">Gambar 3: Unggah hingga 9 dokumen (opsional) di kategori yang sudah ada.</div>
                            </div>
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/4.png') }}" alt="Tambah Kategori Baru" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x250/f59e0b/ffffff?text=Gambar+4+Tambah+Kategori+Baru'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">Gambar 4: Menambah kategori baru jika dokumen lebih dari 9 atau jenisnya berbeda.</div>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-3">🔄 Cara Kerja Upload Dinamis:</h4>
                        <div class="space-y-4">
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h5 class="font-semibold text-gray-700 mb-2">📄 Situasi Normal (Poin 1 Kelembagaan):</h5>
                                <p class="text-sm">Tersedia <b>9 kolom upload</b> untuk dokumen seperti SK Gugus Tugas. Anda boleh mengisi <b>semua, sebagian, atau tidak sama sekali</b> (opsional).</p>
                            </div>
                            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                <h5 class="font-semibold text-gray-700 mb-2">➕ Jika Dokumen Lebih dari 9 atau Jenis Berbeda:</h5>
                                <ol class="list-decimal pl-5 text-sm space-y-1">
                                    <li>Klik tombol <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs rounded-lg font-medium shadow"> <i class="bi bi-plus-circle"></i> Tambah Kategori Upload </span>.</li>
                                    <li>Isi <b>Nama Kategori Baru</b> (misal: "SK Tambahan" atau "Laporan Kegiatan").</li>
                                    <li>Unggah file (PDF/Excel) pada kolom yang baru muncul.</li>
                                    <li>Ulangi langkah ini untuk menambah kategori ke-11, 12, dan seterusnya.</li>
                                </ol>
                                <p class="text-xs text-gray-600 mt-2">📌 <b>Fitur ini berlaku sama untuk semua poin di semua klaster.</b></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 6,7,8: MEMAHAMI STATUS INDIKATOR --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(4)" class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</div>
                            <span class="font-semibold text-gray-800">Memahami Tiga Status Indikator</span>
                        </div>
                        <i id="icon-4" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-4" class="hidden p-6 text-gray-600 leading-relaxed">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="text-center p-4 border border-yellow-300 bg-gradient-to-b from-yellow-50 to-amber-50 rounded-xl">
                                <div class="w-12 h-12 bg-yellow-500 text-white rounded-full flex items-center justify-center text-xl mx-auto mb-3 shadow">⏳</div>
                                <h5 class="font-bold text-gray-800">Status: <span class="text-yellow-700">MENUNGGU</span></h5>
                                <img src="{{ asset('images/tutorial/7.png') }}" alt="Status Menunggu" class="w-full h-32 object-cover rounded-lg my-2 border" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x150/eab308/ffffff?text=Status+MENUNGGU'">
                                <p class="text-xs text-gray-600">Indikator telah disimpan dan dikirim, <b>belum direview oleh Admin</b>. Warna: <b class="text-yellow-600">KUNING</b>.</p>
                            </div>
                            <div class="text-center p-4 border border-green-300 bg-gradient-to-b from-green-50 to-emerald-50 rounded-xl">
                                <div class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center text-xl mx-auto mb-3 shadow">✅</div>
                                <h5 class="font-bold text-gray-800">Status: <span class="text-green-700">DISETUJUI</span></h5>
                                <img src="{{ asset('images/tutorial/6.png') }}" alt="Status Disetujui" class="w-full h-32 object-cover rounded-lg my-2 border" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x150/22c55e/ffffff?text=Status+DISETUJUI'">
                                <p class="text-xs text-gray-600">Admin telah menyetujui. <b>Nilai dan dokumen sudah final</b>. Warna: <b class="text-green-600">HIJAU</b>. <i>(Ini yang kita tuju)</i>.</p>
                            </div>
                            <div class="text-center p-4 border border-red-300 bg-gradient-to-b from-red-50 to-rose-50 rounded-xl">
                                <div class="w-12 h-12 bg-red-500 text-white rounded-full flex items-center justify-center text-xl mx-auto mb-3 shadow">❌</div>
                                <h5 class="font-bold text-gray-800">Status: <span class="text-red-700">DITOLAK</span></h5>
                                <img src="{{ asset('images/tutorial/8.png') }}" alt="Status Ditolak" class="w-full h-32 object-cover rounded-lg my-2 border" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x150/ef4444/ffffff?text=Status+DITOLAK'">
                                <p class="text-xs text-gray-600">Admin menolak. <b>Cek alasan penolakan, lalu perbaiki dan isi ulang poin/dokumennya</b>. Warna: <b class="text-red-600">MERAH</b>.</p>
                            </div>
                        </div>
                        <div class="p-4 bg-red-50 rounded-lg border border-red-300">
                            <p class="text-sm text-red-800"><i class="bi bi-exclamation-octagon mr-2"></i><b>Penting untuk Status DITOLAK:</b> Anda <b>harus</b> membuka indikator tersebut kembali, membaca alasan penolakan dari Admin, melakukan perbaikan, dan menyimpan ulang untuk dikirim kembali ke status <b>MENUNGGU</b>.</p>
                        </div>
                    </div>
                </div>

                {{-- STEP 9 & 10: STATUS KLASTER & FINAL --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(5)" class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">5</div>
                            <span class="font-semibold text-gray-800">Status Akhir Klaster dan Penyelesaian</span>
                        </div>
                        <i id="icon-5" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-5" class="hidden p-6 text-gray-600 leading-relaxed">
                        <div class="mb-4 rounded-xl overflow-hidden border border-gray-300 shadow-md">
                            <img src="{{ asset('images/tutorial/10.png') }}" alt="Dashboard Klaster Lengkap" class="w-full h-auto object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/800x300/8b5cf6/ffffff?text=Gambar+8+Dashboard+Klaster+Lengkap'">
                            <div class="bg-gray-800 text-white p-3 text-sm text-center">Gambar 8: Tampak penuh semua klaster dengan statusnya masing-masing di Dashboard.</div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">📊 Bacaan Dashboard Akhir:</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    <li><b class="text-green-600">HIJAU (DISETUJUI)</b>: Klaster telah selesai dan benar. Tidak perlu tindakan lebih lanjut.</li>
                                    <li><b class="text-yellow-600">KUNING (MENUNGGU)</b>: Sedalam dalam proses review Admin. Harus ditunggu.</li>
                                    <li><b class="text-red-600">MERAH (DITOLAK)</b>: Ada indikator yang harus <b>ditinjau ulang dan diperbaiki</b>.</li>
                                    <li><b class="text-gray-500">ABU-ABU</b>: Belum mulai diisi.</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">🎉 Tujuan Akhir yang Berhasil:</h4>
                                <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md mb-3">
                                    <img src="{{ asset('images/tutorial/9.png') }}" alt="Status Final Disetujui" class="w-full h-32 object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x200/22c55e/ffffff?text=Gambar+9+Semua+Disetujui'">
                                    <div class="bg-gray-800 text-white p-2 text-xs text-center">Gambar 9: Semua indikator dalam satu klaster berstatus DISETUJUI (Hijau).</div>
                                </div>
                                <p class="text-sm">Ketika <b>semua indikator</b> dalam satu klaster berwarna <b class="text-green-600">hijau</b>, berarti klaster tersebut telah <b>berhasil diselesaikan</b> sesuai nilai dan dokumen pendukung. Tugas Anda untuk klaster itu selesai.</p>
                            </div>
                        </div>
                        <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-100 rounded-xl border border-green-300">
                            <p class="text-green-800 font-semibold"><i class="bi bi-flag mr-2"></i>Tujuan Utama: Usahakan agar seluruh klaster di Dashboard Anda berwarna <b class="text-green-700">HIJAU</b>, yang menandakan seluruh penilaian telah <b>DISETUJUI</b> oleh Admin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT ACCORDION --}}
    <script>
        function toggleAcc(id) {
            const content = document.getElementById('acc-' + id);
            const icon = document.getElementById('icon-' + id);
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-up');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
            }
        }
    </script>
@endsection