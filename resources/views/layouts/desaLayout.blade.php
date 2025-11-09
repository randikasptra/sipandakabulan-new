<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Desa | SIPANDAKABULAN')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR -->
    <header class="bg-green-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-bold text-lg">🏡 Desa SIPANDAKABULAN</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('desa.dashboard') }}" class="hover:underline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <!-- CONTENT WRAPPER -->
    <main class="max-w-7xl mx-auto px-6 py-6">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="text-center py-4 text-sm text-gray-600">
        &copy; {{ date('Y') }} Pemerintah Kabupaten Tasikmalaya
    </footer>

</body>
</html>
