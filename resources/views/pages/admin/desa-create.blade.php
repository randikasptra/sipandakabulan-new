@extends('layouts.adminLayout')

@section('title', 'Tambah Desa | SIPANDAKABULAN')

@section('content')
    <div class="mb-6">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex flex-wrap items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <i class="bi bi-house"></i>
                        Dashboard
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <a href="{{ route('admin.desa') }}" class="text-blue-600 hover:text-blue-800">
                        Data Desa
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-600">Tambah Desa</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center lg:text-left">
            <h2
                class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center justify-center lg:justify-start gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                    <i class="bi bi-plus-circle text-white text-lg"></i>
                </div>
                Tambah Desa Baru
            </h2>
            <p class="text-gray-600 mt-2 flex items-center justify-center lg:justify-start gap-2">
                <i class="bi bi-info-circle text-blue-500"></i>
                Tambahkan desa baru beserta akun operatornya
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-building text-blue-600 text-lg"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-800">Informasi Desa</h3>
            </div>

            <form action="{{ route('admin.desa.store') }}" method="POST" id="formTambahDesa">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Nama Desa -->
                    <div class="lg:col-span-2">
                        <label for="nama_desa" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-building me-1 text-blue-500"></i>
                            Nama Desa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_desa" id="nama_desa"
                            class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nama_desa') border-red-500 @enderror"
                            value="{{ old('nama_desa') }}" placeholder="Contoh: Desa Sukamakmur" required autofocus>
                        @error('nama_desa')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="mt-2 text-sm text-gray-600 bg-blue-50 rounded-lg p-3">
                            <i class="bi bi-envelope text-blue-500 me-1"></i>
                            Email akan otomatis dibuat:
                            <strong id="previewEmail" class="text-blue-700 font-mono">-</strong>
                        </div>
                    </div>

                    <!-- Kode Desa -->
                    <div>
                        <label for="kode_desa" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-code me-1 text-blue-500"></i>
                            Kode Desa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode_desa" id="kode_desa"
                            class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('kode_desa') border-red-500 @enderror"
                            value="{{ old('kode_desa') }}" placeholder="Contoh: 3206012001" maxlength="50" required>
                        @error('kode_desa')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-2 flex items-center gap-1">
                            <i class="bi bi-info-circle"></i>
                            Kode desa sesuai kode wilayah Kemendagri
                        </p>
                    </div>

                    <!-- Nama Kepala Desa -->
                    <div>
                        <label for="nama_kades" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-person-badge me-1 text-blue-500"></i>
                            Nama Kepala Desa
                        </label>
                        <input type="text" name="nama_kades" id="nama_kades"
                            class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('nama_kades') border-red-500 @enderror"
                            value="{{ old('nama_kades') }}" placeholder="Contoh: H. Ahmad Sudrajat, S.Sos">
                        @error('nama_kades')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-telephone me-1 text-blue-500"></i>
                            Nomor Telepon
                        </label>
                        <input type="text" name="no_telp" id="no_telp"
                            class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('no_telp') border-red-500 @enderror"
                            value="{{ old('no_telp') }}" placeholder="Contoh: 0265-1234567">
                        @error('no_telp')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Alamat Kantor -->
                    <div class="lg:col-span-2">
                        <label for="alamat_kantor" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-geo-alt me-1 text-blue-500"></i>
                            Alamat Kantor Desa
                        </label>
                        <textarea name="alamat_kantor" id="alamat_kantor"
                            class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('alamat_kantor') border-red-500 @enderror"
                            rows="3" placeholder="Contoh: Jl. Raya Desa Sukamakmur No. 123">{{ old('alamat_kantor') }}</textarea>
                        @error('alamat_kantor')
                            <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 mt-6">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-info-circle text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-800 text-sm mb-1">Informasi Penting</h4>
                            <p class="text-blue-700 text-sm leading-relaxed">
                                Sistem akan otomatis membuat akun operator dengan email berdasarkan nama desa dan password
                                default:
                                <code
                                    class="bg-white px-2 py-1 rounded border border-blue-300 text-blue-800 font-mono text-xs">password123</code>
                            </p>
                            <p class="text-blue-600 text-xs mt-2 flex items-center gap-1">
                                <i class="bi bi-shield-check"></i>
                                User dapat mengganti password setelah login pertama kali
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-end mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.desa') }}"
                        class="flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold order-2 sm:order-1">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 font-semibold order-1 sm:order-2">
                        <i class="bi bi-save"></i>
                        Simpan Desa
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Custom focus styles */
        input:focus,
        textarea:focus {
            outline: none;
            ring: 2px;
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .max-w-4xl {
                margin-left: 1rem;
                margin-right: 1rem;
            }
        }
    </style>
@endpush

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr config
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000"
        };

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        // Preview email generation
        function generateEmailSlug(text) {
            return text.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        document.getElementById('nama_desa').addEventListener('input', function() {
            let namaDesa = this.value.trim();
            let previewEmail = document.getElementById('previewEmail');

            if (namaDesa) {
                let slug = generateEmailSlug(namaDesa);
                previewEmail.textContent = slug + '@tasikdesa.com';
                previewEmail.classList.remove('text-gray-500');
                previewEmail.classList.add('text-blue-700', 'font-semibold');
            } else {
                previewEmail.textContent = '-';
                previewEmail.classList.remove('text-blue-700', 'font-semibold');
                previewEmail.classList.add('text-gray-500');
            }
        });

        // Format kode desa (hanya angka)
        document.getElementById('kode_desa').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Format no telepon
        document.getElementById('no_telp').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9\-\+\s]/g, '');
        });

        // Real-time validation
        document.getElementById('formTambahDesa').addEventListener('submit', function(e) {
            let namaDesa = document.getElementById('nama_desa').value.trim();
            let kodeDesa = document.getElementById('kode_desa').value.trim();

            if (!namaDesa) {
                e.preventDefault();
                toastr.error('Nama desa harus diisi');
                document.getElementById('nama_desa').focus();
                return;
            }

            if (!kodeDesa) {
                e.preventDefault();
                toastr.error('Kode desa harus diisi');
                document.getElementById('kode_desa').focus();
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    Menyimpan...
                </div>
            `;
            submitBtn.disabled = true;

            // Re-enable after 5 seconds if still processing
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });

        // Auto-capitalize first letter of each word for nama desa
        document.getElementById('nama_desa').addEventListener('blur', function() {
            this.value = this.value.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        });

        // Auto-capitalize for nama kades
        document.getElementById('nama_kades').addEventListener('blur', function() {
            this.value = this.value.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        });
    </script>
@endsection
