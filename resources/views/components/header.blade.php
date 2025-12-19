<header class="fixed top-0 left-0 w-full bg-gradient-header text-white shadow-md z-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-2.5 sm:py-3 flex justify-between items-center">
        {{-- Logo dan Nama Desa --}}
        <div class="flex items-center gap-2 sm:gap-3">
             <img src="{{ asset('assets/images/LogoKKLA.png') }}" alt="Logo KKLA"
            class="w-12 h-12 object-contain drop-shadow-md">
            <h1 class="font-bold text-sm sm:text-base lg:text-lg">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-white hidden sm:inline">
                     SIPANDAKABULAN
                </span>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-white sm:hidden">
                    SIPANDAKABULAN
                </span>
            </h1>
        </div>

        {{-- Desktop Navigation --}}
        <div class="hidden lg:flex items-center gap-3 xl:gap-4">
            <a href="{{ route('desa.dashboard') }}"
                class="flex items-center gap-1.5 hover:text-blue-200 smooth-transition font-medium text-sm xl:text-base">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('desa.tutorial') }}"
                class="flex items-center gap-1.5 hover:text-blue-200 smooth-transition font-medium text-sm xl:text-base">
                <i class="bi bi-journal-code"></i>
                <span>Tutorial</span>
            </a>

            <a href="{{ route('desa.pengumuman') }}"
                class="flex items-center gap-1.5 hover:text-blue-200 smooth-transition font-medium text-sm xl:text-base">
                <i class="bi bi-megaphone-fill"></i>
                <span>Pengumuman</span>
            </a>

            <a href="{{ route('desa.settings') }}"
                class="flex items-center gap-1.5 hover:text-blue-200 smooth-transition font-medium text-sm xl:text-base">
                <i class="bi bi-gear-fill"></i>
                <span>Settings</span>
            </a>

            {{-- Tombol Logout Desktop --}}
            <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                @csrf
                <button type="submit"
                    class="flex items-center gap-1.5 bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-md smooth-transition font-medium text-sm xl:text-base ml-2">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        {{-- Mobile Menu Button --}}
        <div class="flex items-center gap-2 lg:hidden">
            {{-- Tombol Logout Mobile (icon only) --}}
            <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                @csrf
                <button type="submit"
                    class="flex items-center justify-center w-9 h-9 bg-red-500 rounded-md hover:bg-red-600 smooth-transition"
                    title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>

            <button id="mobile-menu-button" class="p-1.5 rounded-md hover:bg-white/10 smooth-transition">
                <i class="bi bi-list text-xl"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="lg:hidden hidden bg-gradient-header border-t border-white/20 px-3 py-2">
        <div class="flex flex-col space-y-2">
            <a href="{{ route('desa.dashboard') }}"
                class="flex items-center gap-3 p-2.5 rounded-md hover:bg-white/10 smooth-transition font-medium text-sm">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('desa.tutorial') }}"
                class="flex items-center gap-3 p-2.5 rounded-md hover:bg-white/10 smooth-transition font-medium text-sm">
                <i class="bi bi-journal-code"></i>
                <span>Tutorial</span>
            </a>

            <a href="{{ route('desa.pengumuman') }}"
                class="flex items-center gap-3 p-2.5 rounded-md hover:bg-white/10 smooth-transition font-medium text-sm">
                <i class="bi bi-megaphone-fill"></i>
                <span>Pengumuman</span>
            </a>

            <a href="{{ route('desa.settings') }}"
                class="flex items-center gap-3 p-2.5 rounded-md hover:bg-white/10 smooth-transition font-medium text-sm">
                <i class="bi bi-gear-fill"></i>
                <span>Settings</span>
            </a>
        </div>
    </div>
</header>

{{-- JavaScript untuk Mobile Menu --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');

            // Ubah icon menu
            const icon = mobileMenuButton.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            } else {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-x-lg');
            }
        });

        // Tutup menu saat klik di luar
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuButton.querySelector('i');
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            }
        });

        // Tutup menu saat link diklik (untuk SPA-like experience)
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuButton.querySelector('i');
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            });
        });
    });
</script>