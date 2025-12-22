{{-- components/admin/header.blade.php --}}

<nav class="fixed top-0 left-0 lg:left-64 right-0 h-16 bg-white border-b shadow-sm z-40 flex items-center px-4 lg:px-6 justify-between transition-all duration-300">

    {{-- LEFT SIDE: Mobile Toggle & Page Title --}}
    <div class="flex items-center gap-3">
        {{-- Mobile toggle button --}}
        <button
            id="sidebarToggle"
            class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200 active:scale-95">
            <i data-lucide="menu" class="w-6 h-6 text-gray-600"></i>
        </button>

        {{-- Page Title --}}
        <h1 class="text-lg lg:text-xl font-semibold text-gray-800 truncate">
            @yield('title', 'Dashboard Admin')
        </h1>
    </div>

    {{-- RIGHT SIDE: User Profile Dropdown --}}
    <div class="relative group">
        <div class="flex items-center gap-2 cursor-pointer select-none p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <div class="w-9 h-9 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-full flex items-center justify-center font-semibold shadow-md">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="hidden sm:inline-block text-sm font-medium text-gray-700 max-w-[120px] truncate">
                {{ auth()->user()->name }}
            </span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-600 transition-transform duration-200 group-hover:rotate-180"></i>
        </div>

        {{-- Dropdown Menu --}}
        <div class="absolute right-0 mt-2 w-48 bg-white shadow-xl rounded-xl py-2 border border-gray-100
                    opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                    transform scale-95 group-hover:scale-100 transition-all duration-200 origin-top-right">

            {{-- User Info --}}
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
            </div>

            {{-- Profil Link --}}
            <a href="{{ route('admin.profile.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                <i data-lucide="user-circle" class="w-4 h-4"></i>
                <span>Profil Saya</span>
            </a>

            {{-- Settings (Optional) --}}
            <!-- <a href="#" 
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                <i data-lucide="settings" class="w-4 h-4"></i>
                <span>Pengaturan</span>
            </a> -->

            {{-- Divider --}}
            <div class="border-t border-gray-100 my-2"></div>

            {{-- Logout Button --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- Add padding to main content to account for fixed header --}}
<style>
    /* Ensure main content doesn't overlap with fixed header and sidebar */
    main {
        margin-top: 4rem;
        /* 64px header height */
    }

    @media (min-width: 1024px) {
        main {
            margin-left: 16rem;
            /* 256px sidebar width */
        }
    }

    /* Smooth transitions for responsive behavior */
    nav {
        transition: left 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons in header
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Prevent dropdown from closing when clicking inside
        const dropdown = document.querySelector('.group > div:last-child');
        if (dropdown) {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>