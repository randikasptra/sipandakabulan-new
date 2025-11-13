<nav class="fixed top-0 left-64 right-0 h-16 bg-white border-b shadow-sm z-40 flex items-center px-6 justify-between">

    {{-- LEFT SIDE: Page Title --}}
    <div class="flex items-center gap-3">
        {{-- Mobile toggle (sidebar collapse) --}}
        <i class="bi bi-list text-2xl text-gray-600 cursor-pointer lg:hidden"></i>

        {{-- Halaman --}}
        <h1 class="text-xl font-semibold text-gray-800">
            @yield('title', 'Dashboard Admin')
        </h1>
    </div>

    {{-- RIGHT SIDE: User Profile --}}
    <div class="relative group">

        <div class="flex items-center gap-2 cursor-pointer select-none">
            <div class="w-9 h-9 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <i class="bi bi-chevron-down text-gray-600"></i>
        </div>

        {{-- Dropdown --}}
        <div
            class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-xl py-2
                    opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">

            {{-- Profil --}}
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                <i class="bi bi-person-circle"></i> Profil
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

    </div>

</nav>
