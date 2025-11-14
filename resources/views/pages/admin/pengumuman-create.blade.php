@extends('layouts.adminLayout')

@section('title', 'Tambah Pengumuman | SIPANDAKABULAN')

@section('content')
    <div class="mb-6">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <i class="bi bi-house"></i> Dashboard
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <a href="{{ route('admin.pengumuman') }}" class="text-blue-600 hover:text-blue-800">
                        Pengumuman
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-600">Tambah Pengumuman</span>
                </li>
            </ol>
        </nav>

        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                <i class="bi bi-plus-circle text-white text-lg"></i>
            </div>
            Tambah Pengumuman
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Judul -->
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">
                    Judul Pengumuman <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul') border-red-500 @enderror"
                    placeholder="Contoh: Pembaruan Sistem Penilaian" required>
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi -->
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">
                    Isi Pengumuman <span class="text-red-500">*</span>
                </label>
                <textarea name="isi" rows="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('isi') border-red-500 @enderror"
                    placeholder="Tuliskan isi pengumuman..." required>{{ old('isi') }}</textarea>
                @error('isi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Upload -->
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">
                    File Lampiran <span class="text-gray-500 text-sm font-normal">(Opsional, Max: 5MB)</span>
                </label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 @error('file') border-red-500 @enderror">
                <p class="text-gray-500 text-xs mt-1">Format: PDF, DOC, DOCX, JPG, PNG</p>
                @error('file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Target Desa -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-3">
                    Target Desa <span class="text-red-500">*</span>
                </label>

                <!-- Desa Selector Component -->
                <div class="border border-gray-300 rounded-xl p-4 bg-gray-50">
                    <!-- Select All -->
                    <div class="mb-4 pb-3 border-b border-gray-200">
                        <label
                            class="flex items-center gap-2 cursor-pointer hover:bg-blue-50 p-2 rounded-lg transition-colors">
                            <input type="checkbox" id="checkAllDesa"
                                class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="font-semibold text-gray-700">Pilih Semua Desa</span>
                        </label>
                    </div>

                    <!-- Desa List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-h-80 overflow-y-auto">
                        @foreach ($desas as $desa)
                            <label
                                class="flex items-center gap-2 cursor-pointer hover:bg-blue-50 p-2 rounded-lg transition-colors">
                                <input type="checkbox" name="desa_ids[]" value="{{ $desa->id }}"
                                    class="desa-check w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                                    {{ in_array($desa->id, old('desa_ids', [])) ? 'checked' : '' }}>
                                <span class="text-gray-700 text-sm">{{ $desa->nama_desa }}</span>
                            </label>
                        @endforeach
                    </div>

                    <!-- Counter -->
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold" id="selectedCount">0</span> desa dipilih
                        </p>
                    </div>
                </div>

                @error('desa_ids')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-xl hover:shadow-lg transition-all duration-200 font-semibold flex items-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    Simpan Pengumuman
                </button>

                <a href="{{ route('admin.pengumuman') }}"
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold flex items-center gap-2">
                    <i class="bi bi-x-circle"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAllDesa');
            const desaChecks = document.querySelectorAll('.desa-check');
            const selectedCount = document.getElementById('selectedCount');

            // Update counter
            function updateCounter() {
                const count = document.querySelectorAll('.desa-check:checked').length;
                selectedCount.textContent = count;
            }

            // Check All functionality
            checkAll.addEventListener('change', function() {
                desaChecks.forEach(cb => cb.checked = this.checked);
                updateCounter();
            });

            // Individual checkbox change
            desaChecks.forEach(cb => {
                cb.addEventListener('change', function() {
                    // Update "Select All" state
                    checkAll.checked = Array.from(desaChecks).every(c => c.checked);
                    updateCounter();
                });
            });

            // Initial count
            updateCounter();
        });
    </script>
@endsection
