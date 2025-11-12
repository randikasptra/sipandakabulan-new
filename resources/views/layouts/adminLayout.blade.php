<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | SIPANDAKABULAN')</title>

    {{-- Tailwind + Bootstrap + Icons --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        main {
            padding-top: 90px;
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #cbd5e1 !important;
        }
    </style>
</head>

<body>
    {{-- ✅ Header --}}
    <header class="shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i class="bi bi-shield-lock-fill text-2xl"></i>
                <span>Admin SIPANDAKABULAN</span>
            </h1>

            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-2">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.desa') }}" class="nav-link flex items-center gap-2">
                    <i class="bi bi-building"></i> Desa
                </a>
                <a href="{{ route('admin.penilaian') }}" class="nav-link flex items-center gap-2">
                    <i class="bi bi-clipboard-data"></i> Penilaian
                </a>
                <a href="{{ route('admin.pengumuman') }}" class="nav-link flex items-center gap-2">
                    <i class="bi bi-megaphone-fill"></i> Pengumuman
                </a>
                <a href="{{ route('admin.tutorial') }}" class="nav-link flex items-center gap-2">
                    <i class="bi bi-journal-code"></i> Tutorial
                </a>
                <a href="{{ route('admin.laporan') }}" class="nav-link flex items-center gap-2">
                    <i class="bi bi-bar-chart-line"></i> Laporan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 bg-red-500 px-3 py-2 rounded-md hover:bg-red-600 transition-all">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
    </header>

    {{-- ✅ Konten --}}
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>
</body>

</html>
