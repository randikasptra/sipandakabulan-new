@extends('layouts.desaLayout')

@section('title', 'Tutorial Penggunaan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- HEADER TUTORIAL --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                <i class="bi bi-journal-code text-white text-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Tutorial Pengisian Penilaian Desa Layak Anak</h2>
        </div>

        {{-- CARD WRAPPER --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-200 p-6">

            <p class="text-gray-600 mb-6">
                Halaman ini berisi panduan lengkap mengenai proses pengisian penilaian pada setiap klaster,
                mulai dari memilih klaster sampai penilaian diverifikasi.
            </p>

            {{-- ACCORDION --}}
            <div class="space-y-4" id="accordion">

                {{-- ITEM 1 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(1)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">1. Masuk ke Dashboard</span>
                        <i id="icon-1" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-1" class="hidden p-4 text-gray-600 leading-relaxed">
                        Setelah login sebagai operator desa, Anda akan diarahkan ke dashboard utama.
                        Di sana Anda bisa melihat informasi desa, progres evaluasi, dan daftar semua klaster.
                    </div>
                </div>

                {{-- ITEM 2 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(2)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">2. Pilih Klaster yang Ingin Dinilai</span>
                        <i id="icon-2" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-2" class="hidden p-4 text-gray-600 leading-relaxed">
                        Setiap klaster berisi indikator-indikator yang harus diisi. Klik tombol
                        <b class="text-blue-700">Proses Penilaian</b> pada klaster yang ingin Anda kerjakan.
                    </div>
                </div>

                {{-- ITEM 3 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(3)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">3. Buka Daftar Indikator</span>
                        <i id="icon-3" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-3" class="hidden p-4 text-gray-600 leading-relaxed">
                        Setiap indikator memiliki nilai EM yang harus dimasukkan berdasarkan kondisi desa.
                        Bacalah setiap indikator dengan teliti sebelum memberikan nilai.
                    </div>
                </div>

                {{-- ITEM 4 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(4)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">4. Mendownload Template Excel (Jika diperlukan)</span>
                        <i id="icon-4" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-4" class="hidden p-4 text-gray-600 leading-relaxed">
                        Beberapa klaster memiliki template Excel untuk mempermudah pengisian.
                        Klik tombol <b class="text-blue-700">Download Template</b> jika tersedia.
                    </div>
                </div>

                {{-- ITEM 5 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(5)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">5. Mengisi Nilai EM</span>
                        <i id="icon-5" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-5" class="hidden p-4 text-gray-600 leading-relaxed">
                        Masukkan nilai EM sesuai dengan kondisi yang sebenarnya. Nilai yang dimasukkan akan memengaruhi
                        total nilai akhir klaster tersebut.
                    </div>
                </div>

                {{-- ITEM 6 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(6)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">6. Mengupload Bukti Pendukung (Opsional)</span>
                        <i id="icon-6" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-6" class="hidden p-4 text-gray-600 leading-relaxed">
                        Anda dapat mengunggah foto atau dokumen sebagai bukti pendukung indikator tertentu jika diperlukan.
                    </div>
                </div>

                {{-- ITEM 7 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(7)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">7. Menyimpan Penilaian</span>
                        <i id="icon-7" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-7" class="hidden p-4 text-gray-600 leading-relaxed">
                        Setelah semua nilai diisi, klik <b class="text-blue-700">Simpan Penilaian</b>.
                        Sistem akan menyimpan data dan memperbarui progres klaster Anda.
                    </div>
                </div>

                {{-- ITEM 8 --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button onclick="toggleAcc(8)"
                        class="w-full flex justify-between items-center p-4 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-800">8. Menunggu Verifikasi / Status Klaster</span>
                        <i id="icon-8" class="bi bi-chevron-down text-gray-600"></i>
                    </button>
                    <div id="acc-8" class="hidden p-4 text-gray-600 leading-relaxed">
                        Setiap klaster akan memiliki status:
                        <ul class="list-disc pl-5 mt-2">
                            <li><b class="text-green-600">Disetujui</b> → Penilaian diterima dan tidak bisa diubah.</li>
                            <li><b class="text-yellow-500">Menunggu</b> → Menunggu verifikasi. Penilaian masih bisa diubah.
                            </li>
                            <li><b class="text-red-600">Ditolak</b> → Penilaian ditolak dan harus diperbaiki lalu dikirim
                                ulang.</li>
                            <li><b class="text-gray-500">Draft / In Progress</b> → Penilaian belum lengkap.</li>
                        </ul>
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

@endsection
