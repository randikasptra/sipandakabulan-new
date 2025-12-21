@extends('layouts.desaLayout')

@section('title', 'Tutorial Penggunaan SIPANDAKABULAN')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 mt-24">

        {{-- HEADER TUTORIAL --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                <i class="bi bi-journal-code text-white text-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Tutorial Lengkap Penggunaan SIPANDAKABULAN</h2>
        </div>

        {{-- CARD WRAPPER --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 p-6">

            <p class="text-gray-600 mb-6">
                Panduan langkah demi langkah untuk mengisi penilaian Desa Layak Anak melalui sistem SIPANDAKABULAN.
                Pastikan semua indikator di semua klaster berstatus <b class="text-green-600">DISETUJUI</b> untuk menyelesaikan evaluasi.
            </p>


            {{-- ACCORDION --}}
            <div class="space-y-4" id="accordion">

                {{-- ITEM 1: DASHBOARD --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(1)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                            <span class="font-semibold text-gray-800">Dashboard Utama - Memantau Progress</span>
                        </div>
                        <i id="icon-1" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-1" class="hidden p-6 text-gray-600 leading-relaxed">
                        {{-- IMAGE SECTION --}}
                        <div class="mb-4 rounded-xl overflow-hidden border border-gray-300 shadow-md">
                            <img src="{{ asset('images/tutorial/1.png') }}" 
                                 alt="Dashboard Utama" 
                                 class="w-full h-auto object-cover"
                                 onerror="this.src='https://via.placeholder.com/800x400/3b82f6/ffffff?text=Gambar+1+Dashboard'">
                            <div class="bg-gray-800 text-white p-3 text-sm text-center">
                                Gambar 1: Tampilan Dashboard Utama
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">📊 Ringkasan Dashboard:</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    <li><b>Progress Total</b> - Persentase keseluruhan evaluasi</li>
                                    <li><b>Nilai EM</b> - Total nilai yang sudah diperoleh</li>
                                    <li><b>Nilai Maksimal</b> - Target nilai yang harus dicapai</li>
                                    <li><b>Ringkasan Status</b> - Jumlah klaster per status</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">🎯 Warna Status Klaster:</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                        <span class="text-sm"><b class="text-green-600">DISETUJUI</b> - Sudah diverifikasi admin</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                        <span class="text-sm"><b class="text-yellow-600">MENUNGGU</b> - Belum direview admin</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                        <span class="text-sm"><b class="text-red-600">DITOLAK</b> - Perlu revisi sesuai alasan penolakan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-300">
                            <p class="text-sm text-blue-800">
                                <i class="bi bi-info-circle mr-2"></i>
                                <b>Tips:</b> Pilih klaster yang masih berstatus <b class="text-yellow-600">MENUNGGU</b> atau <b class="text-red-600">DITOLAK</b> untuk diproses terlebih dahulu.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ITEM 2: PILIH KLASTER --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(2)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                            <span class="font-semibold text-gray-800">Memilih Klaster untuk Dinilai</span>
                        </div>
                        <i id="icon-2" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-2" class="hidden p-6 text-gray-600 leading-relaxed">
                        {{-- IMAGE SECTION --}}
                        <div class="mb-4 rounded-xl overflow-hidden border border-gray-300 shadow-md">
                            <img src="{{ asset('images/tutorial/2.png') }}" 
                                 alt="Memilih Klaster" 
                                 class="w-full h-auto object-cover"
                                 onerror="this.src='https://via.placeholder.com/800x300/10b981/ffffff?text=Gambar+2+Memilih+Klaster'">
                            <div class="bg-gray-800 text-white p-3 text-sm text-center">
                                Gambar 2: Memilih Klaster dari Dashboard
                            </div>
                        </div>
                        
                        <h4 class="font-bold text-gray-800 mb-3">🎯 Cara Memilih Klaster:</h4>
                        <ol class="list-decimal pl-5 space-y-3">
                            <li>Pada dashboard, cari kartu klaster yang ingin Anda kerjakan</li>
                            <li>Perhatikan <b>status klaster</b> di pojok kanan atas kartu</li>
                            <li>Klik tombol <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm rounded-lg font-medium shadow-md hover:shadow-lg transition">
                                <i class="bi bi-pencil-square"></i> Proses Penilaian
                            </span></li>
                            <li>Anda akan diarahkan ke halaman detail klaster tersebut</li>
                        </ol>
                        
                        <div class="mt-4 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border border-yellow-300">
                            <p class="text-sm text-yellow-800">
                                <i class="bi bi-exclamation-triangle mr-2"></i>
                                <b>Perhatian:</b> Klaster yang berstatus <b class="text-green-600">DISETUJUI</b> sudah terkunci dan tidak bisa diubah.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ITEM 3: FORM PENILAIAN --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(3)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                            <span class="font-semibold text-gray-800">Mengisi Form Penilaian Indikator</span>
                        </div>
                        <i id="icon-3" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-3" class="hidden p-6 text-gray-600 leading-relaxed">
                        {{-- IMAGE SECTION --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/3.png') }}" 
                                     alt="Form Penilaian" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.src='https://via.placeholder.com/400x200/8b5cf6/ffffff?text=Gambar+3+Form+Penilaian'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">
                                    Gambar 3: Form Penilaian Indikator
                                </div>
                            </div>
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/4.png') }}" 
                                     alt="Template Excel" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.src='https://via.placeholder.com/400x200/10b981/ffffff?text=Gambar+4+Template+Excel'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">
                                    Gambar 4: Download Template Excel
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">📝 Komponen Form:</h4>
                                <ul class="list-disc pl-5 space-y-2">
                                    <li><b>Indikator Penilaian</b> - Pertanyaan/kondisi yang dinilai</li>
                                    <li><b>Pilihan Nilai</b> - Radio button/dropdown untuk memilih poin</li>
                                    <li><b>Catatan</b> - Keterangan tambahan (opsional)</li>
                                    <li><b>Template Excel</b> - Panduan pengisian (jika tersedia)</li>
                                    <li><b>Dokumen Pendukung</b> - Area upload bukti dokumen</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-3">⚙️ Cara Pengisian:</h4>
                                <ol class="list-decimal pl-5 space-y-2">
                                    <li>Baca indikator dengan teliti</li>
                                    <li>Pilih nilai yang sesuai kondisi desa</li>
                                    <li>Isi catatan jika diperlukan</li>
                                    <li>Upload dokumen pendukung (opsional)</li>
                                    <li>Lanjut ke indikator berikutnya</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg border border-blue-300">
                            <p class="text-sm text-blue-800">
                                <i class="bi bi-lightbulb mr-2"></i>
                                <b>Saran:</b> Gunakan <b class="text-blue-700">Download Template Excel</b> jika tersedia untuk memandu pengisian data.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ITEM 4: UPLOAD DOKUMEN --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(4)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</div>
                            <span class="font-semibold text-gray-800">Upload Dokumen Pendukung</span>
                        </div>
                        <i id="icon-4" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-4" class="hidden p-6 text-gray-600 leading-relaxed">
                        {{-- IMAGE SECTION --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/5.png') }}" 
                                     alt="Upload Dokumen" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.src='https://via.placeholder.com/400x200/f59e0b/ffffff?text=Gambar+5+Upload+Dokumen'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">
                                    Gambar 5: Area Upload Dokumen
                                </div>
                            </div>
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/6.png') }}" 
                                     alt="Tambah Kategori" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.src='https://via.placeholder.com/400x200/10b981/ffffff?text=Gambar+6+Tambah+Kategori'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">
                                    Gambar 6: Tambah Kategori Upload
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="font-bold text-gray-800 mb-3">📎 Fitur Upload Dokumen:</h4>
                        <div class="space-y-4">
                            <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border">
                                <h5 class="font-semibold text-gray-700 mb-2">✅ Dokumen yang bisa diupload:</h5>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <span class="px-3 py-1.5 bg-white border rounded-lg text-xs text-center">Surat Keputusan (SK)</span>
                                    <span class="px-3 py-1.5 bg-white border rounded-lg text-xs text-center">Foto Kegiatan</span>
                                    <span class="px-3 py-1.5 bg-white border rounded-lg text-xs text-center">Laporan PDF</span>
                                    <span class="px-3 py-1.5 bg-white border rounded-lg text-xs text-center">Dokumen Word</span>
                                    <span class="px-3 py-1.5 bg-white border rounded-lg text-xs text-center">File Excel</span>
                                    <span class="px-3 py-1.5 bg-white border rounded-lg text-xs text-center">Scan Dokumen</span>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                <h5 class="font-semibold text-gray-700 mb-2">➕ Tambah Kategori Upload:</h5>
                                <p class="text-sm mb-2">Jika dokumen tidak sesuai kategori yang ada:</p>
                                <ol class="list-decimal pl-5 text-sm space-y-1">
                                    <li>Klik <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs rounded-lg font-medium shadow">
                                        <i class="bi bi-plus-circle"></i> Tambah Kategori Baru
                                    </span></li>
                                    <li>Isi nama kategori baru</li>
                                    <li>Upload file sesuai kategori tersebut</li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border border-yellow-300">
                            <p class="text-sm text-yellow-800">
                                <i class="bi bi-exclamation-triangle mr-2"></i>
                                <b>Catatan:</b> Upload dokumen bersifat <b>opsional</b>, namun sangat disarankan untuk memperkuat validasi penilaian.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ITEM 5: STATUS & VERIFIKASI --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(5)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">5</div>
                            <span class="font-semibold text-gray-800">Memahami Status & Proses Verifikasi</span>
                        </div>
                        <i id="icon-5" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-5" class="hidden p-6 text-gray-600 leading-relaxed">
                        {{-- IMAGE SECTION --}}
                        <div class="mb-4 rounded-xl overflow-hidden border border-gray-300 shadow-md">
                            <img src="{{ asset('images/tutorial/7.png') }}" 
                                 alt="Status Verifikasi" 
                                 class="w-full h-auto object-cover"
                                 onerror="this.src='https://via.placeholder.com/800x300/ef4444/ffffff?text=Gambar+7+Status+Verifikasi'">
                            <div class="bg-gray-800 text-white p-3 text-sm text-center">
                                Gambar 7: Status Penilaian dan Verifikasi
                            </div>
                        </div>
                        
                        <h4 class="font-bold text-gray-800 mb-3">🔄 Flow Status Penilaian:</h4>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border border-yellow-200">
                                <div class="w-10 h-10 bg-yellow-500 text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-700">1. MENUNGGU (Pending) ⏳</h5>
                                    <p class="text-sm text-gray-600">Penilaian sudah dikirim dan menunggu review dari admin Dinsos.</p>
                                    <p class="text-xs text-yellow-600 mt-1">📌 Status ini masih bisa diubah</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                                <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-700">2. DISETUJUI (Approved) ✅</h5>
                                    <p class="text-sm text-gray-600">Admin telah menyetujui penilaian. Indikator terkunci dan tidak bisa diubah.</p>
                                    <p class="text-xs text-green-600 mt-1">📌 Status final - evaluasi selesai</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-red-50 to-rose-50 rounded-xl border border-red-200">
                                <div class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-700">3. DITOLAK (Rejected) ❌</h5>
                                    <p class="text-sm text-gray-600">Admin menolak penilaian. Periksa <b class="text-red-600">alasan penolakan</b> dan perbaiki sesuai saran.</p>
                                    <p class="text-xs text-red-600 mt-1">📌 Setelah diperbaiki, kirim ulang untuk verifikasi</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border border-red-300 shadow-sm">
                            <p class="text-sm text-red-800">
                                <i class="bi bi-exclamation-octagon mr-2"></i>
                                <b>Penting:</b> Jika penilaian <b class="text-red-600">DITOLAK</b>, Anda <b>harus</b> memperbaiki sesuai alasan yang diberikan sebelum mengirim ulang.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ITEM 6: SIMPAN & FINAL --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(6)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">6</div>
                            <span class="font-semibold text-gray-800">Menyimpan & Menyelesaikan Evaluasi</span>
                        </div>
                        <i id="icon-6" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-6" class="hidden p-6 text-gray-600 leading-relaxed">
                        {{-- IMAGE SECTION --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/8.png') }}" 
                                     alt="Tombol Simpan" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.src='https://via.placeholder.com/400x200/3b82f6/ffffff?text=Gambar+8+Tombol+Simpan'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">
                                    Gambar 8: Tombol Simpan & Kirim
                                </div>
                            </div>
                            <div class="rounded-xl overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset('images/tutorial/9.png') }}" 
                                     alt="Dashboard Final" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.src='https://via.placeholder.com/400x200/10b981/ffffff?text=Gambar+9+Dashboard+Final'">
                                <div class="bg-gray-800 text-white p-2 text-xs text-center">
                                    Gambar 9: Dashboard Setelah Selesai
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="font-bold text-gray-800 mb-3">💾 Proses Penyimpanan:</h4>
                        <div class="space-y-3">
                            <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-100 rounded-xl border shadow-sm">
                                <h5 class="font-semibold text-gray-700 mb-2">Simpan Sementara:</h5>
                                <p class="text-sm">Gunakan tombol <span class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white text-sm rounded-lg font-medium shadow hover:shadow-md transition">
                                    <i class="bi bi-save"></i> Simpan Draft
                                </span> jika ingin menyimpan progress tanpa mengirim untuk verifikasi.</p>
                                <p class="text-xs text-gray-500 mt-2">📌 Status tetap DRAFT - bisa diubah kapan saja</p>
                            </div>
                            
                            <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-100 rounded-xl border border-green-300 shadow-sm">
                                <h5 class="font-semibold text-gray-700 mb-2">Kirim untuk Verifikasi:</h5>
                                <p class="text-sm">Gunakan tombol <span class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-sm rounded-lg font-medium shadow hover:shadow-md transition">
                                    <i class="bi bi-send-check"></i> Simpan & Kirim Verifikasi
                                </span> untuk mengirim penilaian ke admin.</p>
                                <p class="text-xs text-green-600 mt-2">📌 Status berubah menjadi MENUNGGU - menunggu review admin</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-300 shadow-sm">
                            <p class="text-sm text-green-800">
                                <i class="bi bi-flag mr-2"></i>
                                <b>Tujuan Akhir:</b> Semua klaster harus berstatus <b class="text-green-600">DISETUJUI</b> untuk menyelesaikan evaluasi Desa Layak Anak.
                            </p>
                        </div>
                        
                        <div class="mt-4 p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border border-purple-300 shadow-sm">
                            <h5 class="font-semibold text-purple-800 mb-3 flex items-center gap-2">
                                <i class="bi bi-check-circle"></i> 📋 Checklist Penyelesaian:
                            </h5>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="flex items-center gap-2 p-2 bg-white rounded-lg border">
                                    <i class="bi bi-check-lg text-green-500"></i>
                                    <span class="text-sm">Semua indikator telah diisi</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 bg-white rounded-lg border">
                                    <i class="bi bi-check-lg text-green-500"></i>
                                    <span class="text-sm">Dokumen pendukung terupload</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 bg-white rounded-lg border">
                                    <i class="bi bi-check-lg text-green-500"></i>
                                    <span class="text-sm">Semua status DISETUJUI</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 bg-white rounded-lg border">
                                    <i class="bi bi-check-lg text-green-500"></i>
                                    <span class="text-sm">Progress total 100%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- FAQ SECTION --}}
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-4">
                    <i class="bi bi-question-circle text-2xl text-blue-600"></i>
                    <h3 class="text-xl font-bold text-gray-800">Pertanyaan yang Sering Ditanyakan</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                            <i class="bi bi-question-circle text-blue-500"></i>
                            Apa yang harus dilakukan jika penilaian ditolak?
                        </h4>
                        <p class="text-sm text-gray-600 mt-2 pl-6">Buka kembali indikator yang ditolak, baca alasan penolakan, perbaiki nilai/dokumen yang diminta, lalu kirim ulang.</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                            <i class="bi bi-question-circle text-blue-500"></i>
                            Bisakah mengubah penilaian yang sudah disetujui?
                        </h4>
                        <p class="text-sm text-gray-600 mt-2 pl-6"><b>Tidak bisa.</b> Penilaian yang sudah DISETUJUI terkunci permanen. Hubungi admin jika ada kesalahan kritis.</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                            <i class="bi bi-question-circle text-blue-500"></i>
                            Berapa lama waktu verifikasi oleh admin?
                        </h4>
                        <p class="text-sm text-gray-600 mt-2 pl-6">Biasanya 1-3 hari kerja. Status akan berubah otomatis setelah admin melakukan review.</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                            <i class="bi bi-question-circle text-blue-500"></i>
                            Bagaimana jika dokumen terlalu besar?
                        </h4>
                        <p class="text-sm text-gray-600 mt-2 pl-6">Maksimal ukuran file adalah 10MB per file. Kompres file atau gunakan format PDF untuk mengurangi ukuran.</p>
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
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>

    <style>
        /* Modern styling untuk gambar */
        .tutorial-image {
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #3b82f6, #8b5cf6) border-box;
        }
        
        .tutorial-image:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }
        
        /* Gradient borders untuk card */
        .gradient-border {
            position: relative;
            border-radius: 1rem;
            background: white;
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, #3b82f6, #10b981, #f59e0b);
            border-radius: 1.1rem;
            z-index: -1;
        }
        
        /* Animasi untuk checklist */
        @keyframes checkPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .check-animate {
            animation: checkPulse 2s infinite;
        }
    </style>

@endsection