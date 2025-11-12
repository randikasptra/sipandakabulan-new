<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Desa | SIPANDAKABULAN')</title>

    {{-- ✅ TailwindCSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- ✅ Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ✅ Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- ✅ Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- ✅ AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- ✅ Custom CSS --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        /* ✅ Fixed Header (selalu di atas) */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50;
        }

        /* ✅ Gradient Header Style */
        .bg-gradient-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        /* ✅ Tambahkan ruang agar konten tidak tertimpa header */
        main {
            padding-top: 90px;
            /* sesuaikan tinggi header kamu */
        }

        /* Scrollbar style */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border-radius: 10px;
        }

        .smooth-transition {
            transition: all 0.3s ease-in-out;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-animate {
            transition: all 0.3s ease;
        }

        .btn-animate:hover {
            transform: translateY(-2px);
        }
    </style>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    {{-- ✅ Header (sudah fixed, tidak menimpa konten) --}}
    @include('components.header')

    {{-- ✅ Content --}}
    <main class="mt-24 max-w-7xl mx-auto px-6 py-8" data-aos="fade-up" data-aos-duration="800">
        @yield('content')
    </main>

    {{-- ✅ Footer --}}
    @include('components.footer')

    {{-- ✅ JavaScript Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Disable double submit form
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    if (button) {
                        button.innerHTML = `
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Memproses...
                        `;
                        button.disabled = true;
                    }
                });
            });
        });
    </script>

</body>

</html>
