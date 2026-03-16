@extends('layouts.desaLayout')
@section('title', 'Settings | SIPANDAKABULAN')
@section('meta_robots', 'noindex, nofollow')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                <i class="bi bi-gear text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Pengaturan</h1>
                <p class="text-gray-500 text-sm">Kelola profil dan data desa Anda</p>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
            </div>
            <div>
                <p class="font-semibold text-green-800">Berhasil!</p>
                <p class="text-green-600 text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="bi bi-x-circle-fill text-red-600 text-lg"></i>
            </div>
            <div>
                <p class="font-semibold text-red-800">Error!</p>
                <p class="text-red-600 text-sm">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Sidebar Navigation --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 sticky top-24">
                <nav class="space-y-1">
                    <a href="#profil" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors group">
                        <i class="bi bi-person text-lg text-gray-400 group-hover:text-blue-600"></i>
                        <span class="font-medium">Profil Pengguna</span>
                    </a>
                    <a href="#password" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors group">
                        <i class="bi bi-shield-lock text-lg text-gray-400 group-hover:text-blue-600"></i>
                        <span class="font-medium">Ubah Password</span>
                    </a>
                    <a href="#desa" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors group">
                        <i class="bi bi-building text-lg text-gray-400 group-hover:text-blue-600"></i>
                        <span class="font-medium">Data Desa</span>
                    </a>
                </nav>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Profil Pengguna --}}
            <div id="profil" class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="bi bi-person-circle"></i>
                        Profil Pengguna
                    </h2>
                    <p class="text-blue-200 text-sm">Informasi akun Anda</p>
                </div>
                <form action="{{ route('desa.settings.profile') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                                    placeholder="contoh@email.com">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <i class="bi bi-info-circle text-blue-500"></i>
                                <span>Role: <strong class="text-gray-800">{{ ucfirst($user->role) }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-600 hover:shadow-lg transition-all duration-300">
                            <i class="bi bi-check-lg"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Ubah Password --}}
            <div id="password" class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-600 to-orange-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="bi bi-shield-lock"></i>
                        Ubah Password
                    </h2>
                    <p class="text-orange-100 text-sm">Pastikan menggunakan password yang kuat</p>
                </div>
                <form action="{{ route('desa.settings.password') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Saat Ini <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('current_password') border-red-500 @enderror"
                                    placeholder="Masukkan password saat ini">
                                <button type="button" onclick="togglePassword('current_password', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Baru <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors @error('password') border-red-500 @enderror"
                                    placeholder="Masukkan password baru">
                                <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password Baru <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                                    placeholder="Ulangi password baru">
                                <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="bg-orange-50 rounded-xl p-4">
                            <p class="text-sm font-semibold text-orange-800 mb-2">Tips Password Kuat:</p>
                            <ul class="text-sm text-orange-700 space-y-1">
                                <li class="flex items-center gap-2"><i class="bi bi-check text-orange-600"></i> Minimal 8 karakter</li>
                                <li class="flex items-center gap-2"><i class="bi bi-check text-orange-600"></i> Kombinasi huruf besar & kecil</li>
                                <li class="flex items-center gap-2"><i class="bi bi-check text-orange-600"></i> Sertakan angka dan simbol</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-semibold px-6 py-3 rounded-xl hover:from-orange-700 hover:to-orange-600 hover:shadow-lg transition-all duration-300">
                            <i class="bi bi-shield-check"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- Data Desa --}}
            @if($desa)
            <div id="desa" class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-700 to-green-600 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="bi bi-building"></i>
                        Data Desa
                    </h2>
                    <p class="text-green-100 text-sm">Informasi lengkap desa Anda</p>
                </div>
                <form action="{{ route('desa.settings.desa') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="nama_desa" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Desa <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-building"></i>
                                </span>
                                <input type="text" name="nama_desa" id="nama_desa"
                                    value="{{ old('nama_desa', $desa->nama_desa) }}"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('nama_desa') border-red-500 @enderror"
                                    placeholder="Nama desa">
                            </div>
                            @error('nama_desa')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kode_desa" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Desa
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-qr-code"></i>
                                </span>
                                <input type="text" name="kode_desa" id="kode_desa"
                                    value="{{ old('kode_desa', $desa->kode_desa) }}"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('kode_desa') border-red-500 @enderror"
                                    placeholder="Kode unik desa">
                            </div>
                            @error('kode_desa')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="alamat_kantor" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Kantor Desa
                            </label>
                            <div class="relative">
                                <span class="absolute top-3 left-0 pl-4 flex items-start text-gray-400">
                                    <i class="bi bi-geo-alt"></i>
                                </span>
                                <textarea name="alamat_kantor" id="alamat_kantor" rows="3"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none @error('alamat_kantor') border-red-500 @enderror"
                                    placeholder="Alamat lengkap kantor desa">{{ old('alamat_kantor', $desa->alamat_kantor) }}</textarea>
                            </div>
                            @error('alamat_kantor')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_kades" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Kepala Desa
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-person-badge"></i>
                                </span>
                                <input type="text" name="nama_kades" id="nama_kades"
                                    value="{{ old('nama_kades', $desa->nama_kades) }}"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('nama_kades') border-red-500 @enderror"
                                    placeholder="Nama kepala desa">
                            </div>
                            @error('nama_kades')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="text" name="no_telp" id="no_telp"
                                    value="{{ old('no_telp', $desa->no_telp) }}"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('no_telp') border-red-500 @enderror"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                            @error('no_telp')
                                <p class="mt-1 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold px-6 py-3 rounded-xl hover:from-green-700 hover:to-green-600 hover:shadow-lg transition-all duration-300">
                            <i class="bi bi-check-lg"></i>
                            Simpan Data Desa
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div id="desa" class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-600 to-gray-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="bi bi-building"></i>
                        Data Desa
                    </h2>
                </div>
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-building text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Data Desa Tidak Tersedia</h3>
                    <p class="text-gray-500 text-sm">Akun Anda belum terhubung dengan data desa. Silakan hubungi administrator.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Smooth scroll for navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto hide alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]').forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
@endpush
@endsection
