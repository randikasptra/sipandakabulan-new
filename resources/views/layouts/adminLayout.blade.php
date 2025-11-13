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

        main {
            margin-left: 16rem;
            /* Sidebar width */
            padding: 2rem 2.5rem;
        }

        .content-container {
            max-width: 1300px;
            margin: 0 auto;
        }

        /* Canvas Chart */
        canvas {
            background: #ffffff;
            border-radius: 14px;
            padding: 10px;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50">

    {{-- Sidebar --}}
    @include('components.admin.sidebar')
    {{-- Navbar --}}
    @include('components.admin.navbar')

    {{-- Main Content --}}
    <main>
        <div class="content-container mt-24">
            @yield('content')
        </div>
    </main>

    {{-- JS Library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Chart.js ditempatkan di sini, bukan di <head> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Script tambahan dari setiap halaman --}}
    @yield('scripts')

</body>

</html>
