<header class="fixed top-0 left-0 w-full bg-gradient-header text-white shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        {{-- Logo dan Nama Desa --}}
        <h1 class="font-bold text-xl flex items-center gap-3">
            <i class="bi bi-house-check-fill text-2xl"></i>
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-white">
                Desa SIPANDAKABULAN
            </span>
        </h1>

        {{-- Navigasi --}}
        <div class="flex items-center gap-6">
            <a href="{{ route('desa.dashboard') }}"
                class="flex items-center gap-2 hover:text-blue-200 smooth-transition font-medium">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="{{ route('desa.tutorial') }}"
                class="flex items-center gap-2 hover:text-blue-200 smooth-transition font-medium">
                <i class="bi bi-journal-code"></i>
                Tutorial
            </a>

            <a href="{{ route('desa.pengumuman') }}"
                class="flex items-center gap-2 hover:text-blue-200 smooth-transition font-medium">
                <i class="bi bi-megaphone-fill"></i>
                Pengumuman
            </a>

            <a href="{{ route('desa.settings') }}"
                class="flex items-center gap-2 hover:text-blue-200 smooth-transition font-medium">
                <i class="bi bi-gear-fill"></i>
                Settings
            </a>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 smooth-transition btn-animate font-medium">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </div>

    </div>
</header>
