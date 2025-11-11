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

    {{-- ✅ Bootstrap Icons (Modern & Lengkap) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- ✅ Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- ✅ AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- ✅ Custom CSS --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Gradient Background untuk Header */
        .bg-gradient-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        /* Custom Scrollbar */
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

        /* Smooth Transitions */
        .smooth-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Card Hover Effects */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Button Animations */
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

    <!-- NAVBAR -->
    <header class="bg-gradient-header text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-bold text-xl flex items-center gap-3">
                <i class="bi bi-house-check-fill text-2xl"></i>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-white">
                    Desa SIPANDAKABULAN
                </span>
            </h1>
            <div class="flex items-center gap-6">
                <a href="{{ route('desa.dashboard') }}"
                   class="flex items-center gap-2 hover:text-blue-200 smooth-transition font-medium">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
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

    <!-- CONTENT WRAPPER -->
    <main class="max-w-7xl mx-auto px-6 py-8" data-aos="fade-up" data-aos-duration="800">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="text-center py-6 text-sm text-gray-600 border-t border-gray-200 mt-12 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-center gap-2 mb-2">
                <i class="bi bi-geo-alt-fill text-blue-500"></i>
                <span class="font-medium">Pemerintah Kabupaten Tasikmalaya</span>
            </div>
            <p class="text-gray-500">
                &copy; {{ date('Y') }} SIPANDAKABULAN - Sistem Penilaian Desa Terintegrasi
            </p>
        </div>
    </footer>

    {{-- ✅ JavaScript Libraries --}}

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- AOS Animation --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    {{-- Chart.js (untuk dashboard nanti) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Custom JavaScript untuk interaksi
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading states to buttons
            const buttons = document.querySelectorAll('button[type="submit"]');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.disabled) {
                        const originalText = this.innerHTML;
                        this.innerHTML = `
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Memproses...
                        `;
                        this.disabled = true;

                        // Reset after 3 seconds if still processing
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 3000);
                    }
                });
            });

            // Smooth scroll to top
            function scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            // Add scroll to top button
            const scrollButton = document.createElement('button');
            scrollButton.innerHTML = '<i class="bi bi-chevron-up"></i>';
            scrollButton.className = 'fixed bottom-6 right-6 bg-blue-500 text-white p-3 rounded-full shadow-lg hover:bg-blue-600 smooth-transition btn-animate z-50';
            scrollButton.style.display = 'none';
            scrollButton.addEventListener('click', scrollToTop);
            document.body.appendChild(scrollButton);

            // Show/hide scroll button
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollButton.style.display = 'block';
                } else {
                    scrollButton.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
