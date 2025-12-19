{{-- layouts/adminLayout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | SIPANDAKABULAN Admin</title>

    {{-- TailwindCSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sipandakabulan.png') }}">

    {{-- Chart.js (dipindahkan ke head agar bisa diakses dari semua halaman) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <link rel="icon" type="image/png" href="{{ asset('assets/images/LogoKKLA.png') }}">


    {{-- Custom CSS --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }

        /* Main content area adjustment */
        main {
            min-height: calc(100vh - 4rem);
            margin-top: 4rem; /* Header height */
            padding: 1.5rem;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 1024px) {
            main {
                margin-left: 16rem; /* Sidebar width */
            }
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        /* Card hover effects */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Prevent content shift when scrollbar appears */
        html {
            overflow-y: scroll;
        }

        /* Loading animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        /* Chart container responsive */
        canvas {
            max-width: 100%;
            height: auto !important;
        }

        /* Responsive padding adjustments */
        @media (max-width: 640px) {
            main {
                padding: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar Component --}}
    @include('components.admin.sidebar')

    {{-- Header Component --}}
    @include('components.admin.header')

    {{-- Main Content Area --}}
    <main class="fade-in">
        {{-- Breadcrumb (Optional) --}}
        @if(isset($breadcrumbs))
        <nav class="mb-4 text-sm" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 text-gray-600">
                @foreach($breadcrumbs as $label => $url)
                    @if($loop->last)
                        <li class="font-medium text-blue-600">{{ $label }}</li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="hover:text-blue-600 transition-colors">{{ $label }}</a>
                            <i data-lucide="chevron-right" class="w-4 h-4 inline-block mx-1"></i>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
        @endif

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3 fade-in">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
            <div class="flex-1">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3 fade-in">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        @endif

        {{-- Page Content --}}
        @yield('content')
    </main>

    {{-- Global Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s ease';
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 500);
                }, 5000);
            });

            // Prevent double form submission
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        `;
                        
                        // Re-enable after 3 seconds as fallback
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 3000);
                    }
                });
            });

            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>

    {{-- CRITICAL: Scripts section untuk Chart.js dan scripts lainnya --}}
    @yield('scripts')
    @stack('scripts')
</body>
</html>