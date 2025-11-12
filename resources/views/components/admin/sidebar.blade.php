<aside
    class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white shadow-lg flex flex-col justify-between">
    {{-- Logo / Header --}}
    <div>
        <div class="px-6 py-5 border-b border-blue-600 flex items-center gap-3">
            <i class="bi bi-shield-lock-fill text-2xl"></i>
            <span class="font-bold text-lg">Admin SIPANDAKABULAN</span>
        </div>

        {{-- Navigasi Menu --}}
        <nav class="mt-5 flex flex-col space-y-2 px-4">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.desa') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.desa') ? 'bg-blue-800' : '' }}">
                <i class="bi bi-building"></i> <span>Kelola Desa</span>
            </a>

            <a href="{{ route('admin.penilaian') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.penilaian') ? 'bg-blue-800' : '' }}">
                <i class="bi bi-clipboard-data"></i> <span>Penilaian</span>
            </a>

            <a href="{{ route('admin.pengumuman') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.pengumuman') ? 'bg-blue-800' : '' }}">
                <i class="bi bi-megaphone-fill"></i> <span>Pengumuman</span>
            </a>

            <a href="{{ route('admin.tutorial') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.tutorial') ? 'bg-blue-800' : '' }}">
                <i class="bi bi-journal-code"></i> <span>Tutorial</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.laporan') ? 'bg-blue-800' : '' }}">
                <i class="bi bi-bar-chart-line"></i> <span>Laporan</span>
            </a>
        </nav>
    </div>

    {{-- Tombol Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="px-4 pb-6">
        @csrf
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 bg-red-500 py-2 rounded-md hover:bg-red-600 transition-all">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</aside>
