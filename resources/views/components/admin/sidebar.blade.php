<aside
    class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white shadow-lg flex flex-col justify-between z-50">
    {{-- Logo / Header --}}
    <div>
        <div class="px-6 py-5 border-b border-blue-600 flex items-center gap-3">
            <!-- Logo Image -->
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                <img src="{{ asset('images/logo-sipandakabulan.png') }}" alt="SIPANDAKABULAN"
                    class="w-8 h-8 object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-blue-600 to-blue-400 rounded flex items-center justify-center text-white font-bold text-sm hidden">
                    SIP
                </div>
            </div>
            <div>
                <div class="font-bold text-lg leading-tight">SIPANDAKABULAN</div>
                <div class="text-blue-200 text-xs">Admin System</div>
            </div>
        </div>

        {{-- Navigasi Menu --}}
        <nav class="mt-5 flex flex-col space-y-1 px-4">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-800 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 shadow-lg' : '' }}">
                <div class="w-8 h-8 rounded-lg bg-blue-800 flex items-center justify-center">
                    <i class="bi bi-speedometer2 text-sm"></i>
                </div>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.desa') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-800 transition-all duration-200 {{ request()->routeIs('admin.desa*') ? 'bg-blue-800 shadow-lg' : '' }}">
                <div class="w-8 h-8 rounded-lg bg-blue-800 flex items-center justify-center">
                    <i class="bi bi-building text-sm"></i>
                </div>
                <span class="font-medium">Kelola Desa</span>
            </a>

            <a href="{{ route('admin.penilaian') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-800 transition-all duration-200 {{ request()->routeIs('admin.penilaian*') ? 'bg-blue-800 shadow-lg' : '' }}">
                <div class="w-8 h-8 rounded-lg bg-blue-800 flex items-center justify-center">
                    <i class="bi bi-clipboard-data text-sm"></i>
                </div>
                <span class="font-medium">Verifikasi Penilaian</span>
            </a>

            <a href="{{ route('admin.pengumuman') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-800 transition-all duration-200 {{ request()->routeIs('admin.pengumuman*') ? 'bg-blue-800 shadow-lg' : '' }}">
                <div class="w-8 h-8 rounded-lg bg-blue-800 flex items-center justify-center">
                    <i class="bi bi-megaphone-fill text-sm"></i>
                </div>
                <span class="font-medium">Pengumuman</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-blue-800 transition-all duration-200 {{ request()->routeIs('admin.laporan*') ? 'bg-blue-800 shadow-lg' : '' }}">
                <div class="w-8 h-8 rounded-lg bg-blue-800 flex items-center justify-center">
                    <i class="bi bi-bar-chart-line text-sm"></i>
                </div>
                <span class="font-medium">Laporan</span>
            </a>
        </nav>
    </div>

    {{-- User Info & Logout --}}
    <div class="px-4 pb-6">
        <!-- User Info -->
        <div class="flex items-center gap-3 px-3 py-3 mb-3 bg-blue-800 rounded-xl">
            <div
                class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full flex items-center justify-center">
                <i class="bi bi-person-fill text-white"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-sm truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-blue-200 text-xs truncate">{{ Auth::user()->email ?? 'admin@sipandakabulan.com' }}
                </div>
            </div>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-red-500 py-3 rounded-xl hover:bg-red-600 transition-all duration-200 font-medium">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Overlay -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" id="sidebarOverlay"></div>

<style>
    /* Smooth sidebar transitions */
    aside {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Custom scrollbar for sidebar */
    aside nav {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
    }

    aside nav::-webkit-scrollbar {
        width: 4px;
    }

    aside nav::-webkit-scrollbar-track {
        background: transparent;
    }

    aside nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    /* Hover effects */
    aside nav a {
        transition: all 0.2s ease;
    }

    aside nav a:hover {
        transform: translateX(4px);
    }

    /* Active state enhancements */
    aside nav a.bg-blue-800 {
        border-left: 4px solid #60a5fa;
        margin-left: -4px;
    }

    /* Mobile responsive */
    @media (max-width: 1024px) {
        aside {
            transform: translateX(-100%);
        }

        aside.mobile-open {
            transform: translateX(0);
        }
    }

    /* Logo fallback styling */
    .logo-fallback {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
    }
</style>

<script>
    // Mobile sidebar functionality
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('sidebarOverlay');
        const sidebar = document.querySelector('aside');

        // Toggle sidebar on mobile
        function toggleSidebar() {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('hidden');
        }

        // Close sidebar when clicking overlay
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        // Add toggle button for mobile (you can add this button in your header)
        // <button id="sidebarToggle" class="lg:hidden">☰</button>
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }

        // Close sidebar when clicking on links in mobile
        if (window.innerWidth < 1024) {
            const navLinks = document.querySelectorAll('aside nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', toggleSidebar);
            });
        }
    });
</script>
