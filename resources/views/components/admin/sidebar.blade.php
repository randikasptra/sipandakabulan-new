{{-- components/admin/sidebar.blade.php --}}

<aside
    class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white shadow-2xl flex flex-col justify-between z-50 transition-transform duration-300 ease-out -translate-x-full lg:translate-x-0"
    id="sidebar">

    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-800 rounded-full -translate-x-32 -translate-y-32 opacity-10"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full translate-x-48 translate-y-48 opacity-5"></div>
    </div>

    {{-- Logo / Header dengan Animasi --}}
    <div class="relative z-10">
        <div class="px-6 py-5 border-b border-blue-600/50 flex items-center gap-3 transform transition-all duration-300 hover:scale-[1.02] hover:bg-blue-800/30 rounded-xl mx-4 mt-2">
            <!-- Logo Image dengan Animasi Rotasi -->
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg transform transition-transform duration-700 hover:rotate-[360deg]">
                <img src="{{ asset('assets/images/LogoKKLA.png') }}" alt="SIPANDAKABULAN"
                    class="w-8 h-8 object-contain transition-all duration-500"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-blue-600 to-blue-400 rounded flex items-center justify-center text-white font-bold text-sm hidden animate-pulse">
                    SIP
                </div>
            </div>
            <div class="overflow-hidden">
                <div class="font-bold text-lg leading-tight">SIPANDAKABULAN</div>
                <div class="text-blue-200 text-xs">Admin System</div>
            </div>
        </div>

        {{-- Navigasi Menu dengan Stagger Animation --}}
        <nav class="mt-6 flex flex-col space-y-2 px-4" id="sidebarMenu">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-menu-item group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 transform hover:translate-x-2 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-800 to-blue-600 shadow-lg scale-[1.02]' : 'hover:bg-blue-800/50' }}"
                data-index="0">
                <div class="w-9 h-9 rounded-lg bg-blue-800/80 flex items-center justify-center 
                          transform transition-all duration-300 group-hover:scale-110 group-hover:bg-blue-700
                          {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 scale-110' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 transition-transform duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-medium flex-1">Dashboard</span>
                <div class="w-2 h-2 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>

            <a href="{{ route('admin.desa') }}"
                class="sidebar-menu-item group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 transform hover:translate-x-2 {{ request()->routeIs('admin.desa*') ? 'bg-gradient-to-r from-blue-800 to-blue-600 shadow-lg scale-[1.02]' : 'hover:bg-blue-800/50' }}"
                data-index="1">
                <div class="w-9 h-9 rounded-lg bg-blue-800/80 flex items-center justify-center 
                          transform transition-all duration-300 group-hover:scale-110 group-hover:bg-blue-700
                          {{ request()->routeIs('admin.desa*') ? 'bg-blue-700 scale-110' : '' }}">
                    <i data-lucide="building-2" class="w-5 h-5 transition-transform duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-medium flex-1">Kelola Desa</span>
                <div class="w-2 h-2 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>

            <a href="{{ route('admin.penilaian') }}"
                class="sidebar-menu-item group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 transform hover:translate-x-2 {{ request()->routeIs('admin.penilaian*') ? 'bg-gradient-to-r from-blue-800 to-blue-600 shadow-lg scale-[1.02]' : 'hover:bg-blue-800/50' }}"
                data-index="2">
                <div class="w-9 h-9 rounded-lg bg-blue-800/80 flex items-center justify-center 
                          transform transition-all duration-300 group-hover:scale-110 group-hover:bg-blue-700
                          {{ request()->routeIs('admin.penilaian*') ? 'bg-blue-700 scale-110' : '' }}">
                    <i data-lucide="clipboard-check" class="w-5 h-5 transition-transform duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-medium flex-1">Verifikasi Penilaian</span>
                <div class="w-2 h-2 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>

            <a href="{{ route('admin.pengumuman') }}"
                class="sidebar-menu-item group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 transform hover:translate-x-2 {{ request()->routeIs('admin.pengumuman*') ? 'bg-gradient-to-r from-blue-800 to-blue-600 shadow-lg scale-[1.02]' : 'hover:bg-blue-800/50' }}"
                data-index="3">
                <div class="w-9 h-9 rounded-lg bg-blue-800/80 flex items-center justify-center 
                          transform transition-all duration-300 group-hover:scale-110 group-hover:bg-blue-700
                          {{ request()->routeIs('admin.pengumuman*') ? 'bg-blue-700 scale-110' : '' }}">
                    <i data-lucide="megaphone" class="w-5 h-5 transition-transform duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-medium flex-1">Pengumuman</span>
                <div class="w-2 h-2 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>

            <a href="{{ route('admin.laporan.index') }}"
                class="sidebar-menu-item group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 transform hover:translate-x-2 {{ request()->routeIs('admin.laporan*') ? 'bg-gradient-to-r from-blue-800 to-blue-600 shadow-lg scale-[1.02]' : 'hover:bg-blue-800/50' }}"
                data-index="4">
                <div class="w-9 h-9 rounded-lg bg-blue-800/80 flex items-center justify-center 
                          transform transition-all duration-300 group-hover:scale-110 group-hover:bg-blue-700
                          {{ request()->routeIs('admin.laporan*') ? 'bg-blue-700 scale-110' : '' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 transition-transform duration-300 group-hover:scale-125"></i>
                </div>
                <span class="font-medium flex-1">Laporan</span>
                <div class="w-2 h-2 bg-blue-300 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
        </nav>
    </div>

    {{-- User Info & Logout dengan Animasi --}}
    <div class="relative z-10 px-4 pb-6 space-y-3">
        <!-- User Info dengan Hover Animation -->
        <div class="flex items-center gap-3 px-3 py-3 bg-blue-800/60 rounded-xl 
                   transform transition-all duration-300 hover:scale-[1.02] hover:bg-blue-800/80 
                   hover:shadow-lg group/user">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full 
                      flex items-center justify-center transform transition-transform duration-500 
                      group-hover/user:rotate-[360deg] shadow-md">
                <i data-lucide="user" class="w-5 h-5 text-white"></i>
            </div>
            <div class="flex-1 min-w-0 overflow-hidden">
                <div class="font-semibold text-sm truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-blue-200 text-xs truncate">
                    {{ Auth::user()->email ?? 'admin@sipandakabulan.com' }}
                </div>
            </div>
        </div>

        <!-- Logout Button dengan Hover Animation -->
        <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit"
                class="sidebar-button w-full flex items-center justify-center gap-2 
                       bg-gradient-to-r from-red-500 to-red-600 py-3 rounded-xl 
                       transform transition-all duration-300 hover:scale-[1.02] 
                       hover:from-red-600 hover:to-red-700 hover:shadow-lg 
                       active:scale-95 group relative overflow-hidden">
                <i data-lucide="log-out"
                    class="w-5 h-5 transform transition-transform duration-300 
                          group-hover:translate-x-1"></i>
                <span class="font-semibold">Logout</span>
            </button>
        </form>
    </div>

    {{-- Close Button Mobile --}}
    <button id="sidebarClose" class="absolute top-4 right-4 lg:hidden p-2 rounded-lg bg-blue-800/50 hover:bg-blue-700 transition-colors duration-200">
        <i data-lucide="x" class="w-5 h-5"></i>
    </button>
</aside>

<!-- Mobile Overlay dengan Animasi Fade -->
<div class="fixed inset-0 bg-black/50 z-40 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"
    id="sidebarOverlay"></div>

<style>
    /* Animasi Stagger untuk Menu Items */
    @keyframes slideInStagger {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .sidebar-menu-item {
        animation: slideInStagger 0.4s ease-out forwards;
        opacity: 0;
    }

    .sidebar-menu-item[data-index="0"] {
        animation-delay: 0.05s;
    }

    .sidebar-menu-item[data-index="1"] {
        animation-delay: 0.1s;
    }

    .sidebar-menu-item[data-index="2"] {
        animation-delay: 0.15s;
    }

    .sidebar-menu-item[data-index="3"] {
        animation-delay: 0.2s;
    }

    .sidebar-menu-item[data-index="4"] {
        animation-delay: 0.25s;
    }

    /* Hover Effects Enhancement */
    .sidebar-menu-item:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    /* Active Menu Indicator */
    .sidebar-menu-item.bg-gradient-to-r {
        position: relative;
    }

    .sidebar-menu-item.bg-gradient-to-r::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background: linear-gradient(to bottom, #60a5fa, #3b82f6);
        border-radius: 0 4px 4px 0;
    }

    /* Ripple Effect untuk Button */
    .sidebar-button::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .sidebar-button:active::after {
        width: 300px;
        height: 300px;
    }

    /* Smooth Scrollbar */
    #sidebarMenu {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        max-height: calc(100vh - 240px);
        overflow-y: auto;
    }

    #sidebarMenu::-webkit-scrollbar {
        width: 4px;
    }

    #sidebarMenu::-webkit-scrollbar-track {
        background: transparent;
    }

    #sidebarMenu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    #sidebarMenu::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Sidebar Open State */
    #sidebar.sidebar-open {
        transform: translateX(0);
    }

    /* Mobile Optimization */
    @media (max-width: 1024px) {
        #sidebar {
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const menuItems = document.querySelectorAll('.sidebar-menu-item');

        // Toggle sidebar function
        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('sidebar-open');

            if (isOpen) {
                // Close sidebar
                sidebar.classList.remove('sidebar-open');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = '';
            } else {
                // Open sidebar
                sidebar.classList.add('sidebar-open');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100');
                document.body.style.overflow = 'hidden';
            }
        }

        // Event Listeners
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', toggleSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar when clicking on links in mobile
        menuItems.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024 && sidebar.classList.contains('sidebar-open')) {
                    setTimeout(toggleSidebar, 200);
                }
            });
        });

        // Close sidebar with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('sidebar-open')) {
                toggleSidebar();
            }
        });

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth >= 1024 && sidebar.classList.contains('sidebar-open')) {
                    toggleSidebar();
                }
            }, 250);
        });

        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>