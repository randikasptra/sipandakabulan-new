{{-- resources/views/pages/admin/profile/index.blade.php --}}
@extends('layouts.adminLayout')

@section('title', 'Profil Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Profil Admin</h1>
        <p class="text-gray-600 text-sm mt-1">Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Profil -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <!-- Avatar -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-3">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-600 flex items-center gap-1 mt-1">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        {{ ucfirst(auth()->user()->role) }}
                    </p>
                    <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <!-- Status Badges -->
                <div class="flex flex-wrap justify-center gap-2 mb-6">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                        <i data-lucide="check-circle" class="w-3 h-3"></i>
                        Aktif
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                        ID: {{ auth()->user()->id }}
                    </span>
                </div>

                <!-- Info -->
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500 flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3"></i>
                        Bergabung: {{ auth()->user()->created_at ? auth()->user()->created_at->format('d M Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button 
                            type="button"
                            onclick="switchTab('profile')"
                            id="tab-profile"
                            class="tab-button active flex items-center gap-2 px-6 py-4 text-sm font-medium border-b-2 border-blue-600 text-blue-600">
                            <i data-lucide="user-pen" class="w-4 h-4"></i>
                            Edit Profil
                        </button>
                        <button 
                            type="button"
                            onclick="switchTab('password')"
                            id="tab-password"
                            class="tab-button flex items-center gap-2 px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300">
                            <i data-lucide="key" class="w-4 h-4"></i>
                            Ubah Password
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Tab 1: Edit Profil -->
                    <div id="content-profile" class="tab-content">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Profil</h2>

                        @if(session('success') && session('tab') == 'profile')
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                        @endif

                        @if(session('error') && session('tab') == 'profile')
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap *
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', auth()->user()->name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                    required>
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email *
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', auth()->user()->email) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                    required>
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role (readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Role
                                </label>
                                <input 
                                    type="text" 
                                    value="{{ ucfirst(auth()->user()->role) }}"
                                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600"
                                    readonly>
                                <p class="mt-1 text-xs text-gray-500">Role tidak dapat diubah</p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end gap-3 pt-4">
                                <button 
                                    type="reset"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <i data-lucide="undo-2" class="w-4 h-4 inline-block mr-1"></i>
                                    Reset
                                </button>
                                <button 
                                    type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                    <i data-lucide="save" class="w-4 h-4 inline-block mr-1"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: Ubah Password -->
                    <div id="content-password" class="tab-content hidden">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h2>

                        @if(session('success') && session('tab') == 'password')
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                        @endif

                        @if(session('error') && session('tab') == 'password')
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                        @endif

                        <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Saat Ini *
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="current_password" 
                                        name="current_password"
                                        class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror"
                                        required>
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('current_password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Baru *
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="new_password" 
                                        name="new_password"
                                        class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('new_password') border-red-500 @enderror"
                                        required>
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('new_password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                                @error('new_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password Baru *
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="new_password_confirmation" 
                                        name="new_password_confirmation"
                                        class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('new_password_confirmation')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Tips -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <i data-lucide="lightbulb" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                                    <div>
                                        <h4 class="text-sm font-medium text-blue-900 mb-2">Tips Password Aman:</h4>
                                        <ul class="text-xs text-blue-800 space-y-1">
                                            <li>• Minimal 8 karakter</li>
                                            <li>• Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                                            <li>• Jangan gunakan password yang mudah ditebak</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="flex justify-end pt-4">
                                <button 
                                    type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                    <i data-lucide="key" class="w-4 h-4 inline-block mr-1"></i>
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab switching
    function switchTab(tabName) {
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active from all buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'border-blue-600', 'text-blue-600');
            button.classList.add('border-transparent', 'text-gray-600');
        });
        
        // Show selected content
        document.getElementById('content-' + tabName).classList.remove('hidden');
        
        // Activate selected button
        const activeButton = document.getElementById('tab-' + tabName);
        activeButton.classList.add('active', 'border-blue-600', 'text-blue-600');
        activeButton.classList.remove('border-transparent', 'text-gray-600');
        
        // Reinit lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const icon = button.querySelector('[data-lucide]');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            field.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        
        // Reinit lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // Check active tab from session
    document.addEventListener('DOMContentLoaded', function() {
        const sessionTab = '{{ session("tab", "profile") }}';
        if (sessionTab === 'password') {
            switchTab('password');
        }
        
        // Init lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush