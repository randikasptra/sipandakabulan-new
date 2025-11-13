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
            /* 64 Tailwind = 16rem */
            padding: 2rem;
        }

        .content-container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>

    <style>
        canvas {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 10px;
        }
    </style>

</head>

<body class="bg-gray-50">

    {{-- ✅ Sidebar kiri --}}
    @include('components.admin.sidebar')

    {{-- ✅ Konten utama --}}
    <main>
        <div class="content-container">
            @yield('content')
        </div>
    </main>

</body>

</html>
