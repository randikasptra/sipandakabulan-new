@extends('layouts.desaLayout')

@section('content')
    <div class="dashboard-wrapper">
        
        {{-- WELCOME HEADER --}}
        <div class="welcome-hero">
            <div class="welcome-pattern"></div>
            <div class="welcome-content">
                
                {{-- User Profile Section --}}
                <div class="user-profile-section">
                    <div class="user-avatar-wrapper">
                        <div class="user-avatar">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="currentColor"/>
                                <path d="M12 14.5C6.99 14.5 2.91 17.86 2.91 22C2.91 22.28 3.13 22.5 3.41 22.5H20.59C20.87 22.5 21.09 22.28 21.09 22C21.09 17.86 17.01 14.5 12 14.5Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="status-indicator">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>

                    <div class="user-details">
                        <div class="user-header">
                            <h1 class="user-name">Selamat Datang, {{ Auth::user()->name }}</h1>
                            <span class="user-role-badge">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                </svg>
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>

                        @if (Auth::user()->desa)
                            <div class="info-cards-grid">
                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 3L2 12h3v8h14v-8h3L12 3z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Desa</span>
                                        <span class="info-card-value">{{ Auth::user()->desa->nama_desa }}</span>
                                    </div>
                                </div>

                                @if (Auth::user()->desa->kode_desa)
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 3h8v8H3V3zm10 0h8v8h-8V3zM3 13h8v8H3v-8zm15 0h3v3h-3v-3zm0 5h3v3h-3v-3zm-5-5h3v3h-3v-3zm0 5h3v3h-3v-3z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <span class="info-card-label">Kode Desa</span>
                                            <span class="info-card-value">{{ Auth::user()->desa->kode_desa }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if (Auth::user()->desa->nama_kades)
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <div class="info-card-content">
                                            <span class="info-card-label">Kepala Desa</span>
                                            <span class="info-card-value">{{ Auth::user()->desa->nama_kades }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Date Card --}}
                <div class="date-card">
                    <div class="date-card-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" fill="currentColor"/>
                            <path d="M7 10h5v5H7z" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="date-card-content">
                        <span class="date-card-label">Hari ini</span>
                        <span class="date-card-value">{{ now()->format('d F Y') }}</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- PROGRESS OVERVIEW --}}
        <div class="overview-grid">
            
            {{-- Main Progress Card --}}
            <div class="progress-main-card">
                <div class="progress-card-header">
                    <div class="progress-card-info">
                        <h3 class="progress-card-title">Progress Evaluasi Desa Layak Anak</h3>
                        <p class="progress-card-subtitle">Status terkini penilaian klaster</p>
                    </div>
                    <div class="progress-percentage">
                        <div class="percentage-value">{{ number_format($totalProgress, 0) }}%</div>
                        <div class="percentage-label">Total Progress</div>
                    </div>
                </div>

                <div class="progress-bar-section">
                    <div class="progress-bar-header">
                        <span class="progress-bar-label">Progress Keseluruhan</span>
                        <span class="progress-bar-value">{{ number_format($totalProgress, 1) }}%</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $totalProgress }}%">
                            <div class="progress-bar-shine"></div>
                        </div>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card stat-em">
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Nilai EM</span>
                            <span class="stat-value">{{ number_format($totalEm, 2) }}</span>
                        </div>
                    </div>

                    <div class="stat-card stat-max">
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="2" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Nilai Maksimal</span>
                            <span class="stat-value">{{ number_format($totalMax, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Summary Card --}}
            <div class="status-summary-card">
                <h3 class="summary-title">Ringkasan Status</h3>
                <div class="status-list">
                    @php
                        $statusCounts = [
                            'approved' => ['count' => 0, 'color' => 'success', 'label' => 'Disetujui'],
                            'pending' => ['count' => 0, 'color' => 'warning', 'label' => 'Menunggu'],
                            'rejected' => ['count' => 0, 'color' => 'danger', 'label' => 'Ditolak']
                        ];
                        
                        foreach ($klasters as $klaster) {
                            if (isset($statusCounts[$klaster->status])) {
                                $statusCounts[$klaster->status]['count']++;
                            }
                        }
                    @endphp

                    @foreach ($statusCounts as $status => $data)
                        <div class="status-item status-{{ $data['color'] }}">
                            <div class="status-icon-wrapper">
                                <div class="status-icon">
                                    @if($status === 'approved')
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" fill="currentColor"/>
                                        </svg>
                                    @elseif($status === 'pending')
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" fill="currentColor"/>
                                            <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z" fill="currentColor"/>
                                        </svg>
                                    @else
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" fill="currentColor"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="status-content">
                                <span class="status-label">{{ $data['label'] }}</span>
                                <span class="status-count">{{ $data['count'] }} Klaster</span>
                            </div>
                            <div class="status-arrow">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" fill="currentColor"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SECTION HEADER --}}
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-icon-wrapper">
                    <div class="section-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="section-badge">{{ count($klasters) }}</div>
                </div>
                <div class="section-info">
                    <h2 class="section-title">Dashboard Desa Layak Anak</h2>
                    <p class="section-subtitle">Kelola dan pantau progress setiap klaster</p>
                </div>
            </div>
        </div>

    {{-- KLASTER GRID (PERPADUAN VERSI MODERN) --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">

    @foreach ($klasters as $klaster)
        @php
            $progress = $klaster->progres ?? 0;

            $progressColor = match(true) {
                $progress >= 80 => 'from-green-500 to-emerald-400',
                $progress >= 50 => 'from-yellow-500 to-amber-400',
                default => 'from-orange-500 to-red-400'
            };

            $statusConfig = match($klaster->status) {
                'approved' => ['color' => 'bg-green-50 text-green-700 border-green-200', 'icon' => 'bi-check-circle-fill'],
                'pending'  => ['color' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'icon' => 'bi-clock-fill'],
                'rejected' => ['color' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'bi-x-circle-fill'],
                default    => ['color' => 'bg-gray-50 text-gray-700 border-gray-200', 'icon' => 'bi-dash-circle-fill'],
            };
        @endphp

        <div class="group bg-white rounded-3xl shadow-lg border border-gray-200 hover:shadow-xl hover:border-blue-300 transition-all duration-300 overflow-hidden flex flex-col">

            {{-- HEADER --}}
            <div class="relative bg-gradient-to-br from-blue-800 to-blue-600 p-6 text-white pb-5">
                <div class="absolute inset-0 opacity-10"
                     style="background-image:url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-bold text-xl">{{ $klaster->title }}</h3>

                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                            <i class="bi {{ $statusConfig['icon'] }} text-xs"></i>
                            {{ strtoupper($klaster->status) }}
                        </span>
                    </div>

                    <div class="flex items-center flex-wrap gap-3">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full">
                            <div class="w-2 h-2 bg-gradient-to-r {{ $progressColor }} rounded-full animate-pulse"></div>
                            <span class="text-sm font-semibold">{{ $progress }}%</span>
                        </div>

                        <div class="flex items-center gap-2 text-blue-100">
                            <i class="bi bi-star-fill text-yellow-300"></i>
                            <span class="text-sm">EM: {{ number_format($klaster->nilai_em, 2) }}</span>
                        </div>

                        <div class="flex items-center gap-2 text-blue-100">
                            <i class="bi bi-bullseye text-cyan-300"></i>
                            <span class="text-sm">Max: {{ number_format($klaster->nilai_maksimal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            <div class="p-6 flex flex-col flex-1">
                
                {{-- Progress --}}
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-gray-700 mb-2">
                        <span class="font-medium">Progress Nilai</span>
                        <span class="font-semibold">{{ $klaster->nilai_em }} / {{ $klaster->nilai_maksimal }}</span>
                    </div>

                    <div class="relative">
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-3 bg-gradient-to-r {{ $progressColor }} rounded-full transition-all duration-700 relative"
                                 style="width: {{ $progress }}%">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white/30 animate-shimmer"></div>
                            </div>
                        </div>

                        @if($progress > 10)
                            <div class="absolute top-1/2 -translate-y-1/2"
                                 style="left: calc({{ $progress }}% - 8px)">
                                <div class="w-4 h-4 bg-white rounded-full border-2 border-blue-700 shadow"></div>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between text-xs text-gray-400 mt-2">
                        <span>0%</span>
                        <span>50%</span>
                        <span>100%</span>
                    </div>
                </div>

                {{-- Button --}}
                <a href="{{ route('desa.klaster.detail', $klaster->slug) }}"
                   class="mt-auto flex items-center justify-center w-full bg-gradient-to-r from-blue-700 to-blue-600 text-white font-semibold py-3 rounded-2xl hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all gap-2">
                    <i class="bi bi-pencil-square text-lg"></i>
                    Proses Penilaian
                    <i class="bi bi-arrow-right-short text-xl"></i>
                </a>

            </div>

        </div>
    @endforeach

</div>


    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .dashboard-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Welcome Hero */
        .welcome-hero {
            position: relative;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 24px;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(30, 58, 138, 0.3);
        }

        .welcome-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px);
        }

        .welcome-content {
            position: relative;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: start;
        }

        .user-profile-section {
            display: flex;
            gap: 1.5rem;
        }

        .user-avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        .status-indicator {
            position: absolute;
            bottom: -4px;
            right: -4px;
            width: 32px;
            height: 32px;
            background: #10b981;
            border-radius: 50%;
            border: 4px solid #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .user-details {
            flex: 1;
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .user-name {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .info-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .info-card-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .info-card-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-card-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .info-card-value {
            font-size: 0.875rem;
            color: white;
            font-weight: 700;
        }

        .date-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            min-width: 200px;
        }

        .date-card-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1rem;
        }

        .date-card-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .date-card-label {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .date-card-value {
            font-size: 1.125rem;
            color: white;
            font-weight: 700;
        }

        /* Overview Grid */
        .overview-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .progress-main-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 24px;
            padding: 2rem;
            color: white;
            box-shadow: 0 10px 40px rgba(30, 64, 175, 0.3);
        }

        .progress-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .progress-card-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .progress-card-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }

        .progress-percentage {
            text-align: right;
        }
                .percentage-value {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
        }

        .percentage-label {
            font-size: 0.875rem;
            margin-top: 0.25rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .progress-bar-section {
            margin-bottom: 2rem;
        }

        .progress-bar-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .progress-bar-container {
            width: 100%;
            height: 14px;
            border-radius: 10px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.25);
        }

        .progress-bar-fill {
            height: 100%;
            position: relative;
            background: linear-gradient(90deg, #34d399, #10b981);
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .progress-bar-shine {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                transparent,
                rgba(255,255,255,0.4),
                transparent);
            animation: shine 2s infinite linear;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-card {
            padding: 1.25rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.25);
        }

        .stat-card.stat-em {
            background: rgba(16,185,129,0.2);
        }

        .stat-card.stat-max {
            background: rgba(59,130,246,0.2);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items:center;
            justify-content:center;
            flex-shrink: 0;
        }

        .stat-label {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.8);
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
        }

        /* Status Summary */
        .status-summary-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .summary-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .status-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            transition: all .2s ease;
        }

        .status-item:hover {
            transform: translateX(4px);
        }

        .status-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items:center;
            justify-content:center;
            flex-shrink: 0;
        }

        .status-success .status-icon-wrapper { background: #d1fae5; color:#059669; }
        .status-warning .status-icon-wrapper { background: #fef9c3; color:#d97706; }
        .status-danger .status-icon-wrapper { background: #fee2e2; color:#dc2626; }

        .status-content {
            flex: 1;
            padding: 0 1rem;
        }

        .status-label {
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-count {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .status-arrow {
            opacity: 0.6;
        }

        /* Section Header */
        .section-header {
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }

        .section-header-left {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .section-icon-wrapper {
            position: relative;
        }

        .section-icon {
            width: 48px;
            height: 48px;
            background: #1e3a8a;
            color: white;
            border-radius: 14px;
            display: flex;
            align-items:center;
            justify-content:center;
        }

        .section-badge {
            position: absolute;
            right: -6px;
            bottom: -6px;
            background: #3b82f6;
            color:white;
            padding: 0.25rem 0.5rem;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 600;
            border: 2px solid white;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .section-subtitle {
            color:#6b7280;
        }

        /* Klaster Grid */
        .klaster-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(320px,1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .klaster-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .klaster-header {
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .klaster-header .header-pattern {
            position: absolute;
            inset: 0;
            opacity: .05;
            background-image: radial-gradient(circle at top left, white, transparent 60%);
        }

        .klaster-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: .3rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items:center;
            gap: 4px;
        }

        .status-approved { background:#d1fae5; color:#059669; }
        .status-pending  { background:#fef9c3; color:#b45309; }
        .status-rejected { background:#fee2e2; color:#dc2626; }

        .header-stats {
            display: flex;
            align-items:center;
            gap: .75rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .stat-chip {
            display: flex;
            align-items:center;
            gap: 6px;
            padding: 0.3rem 0.6rem;
            border-radius: 50px;
            background:#f3f4f6;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .progress-high   { background:#dcfce7 !important; color:#166534 !important; }
        .progress-medium { background:#fef3c7 !important; color:#d97706 !important; }
        .progress-low    { background:#fee2e2 !important; color:#dc2626 !important; }

        .klaster-body {
            padding: 1.25rem;
        }

        .progress-bar-wrapper {
            margin: 0.75rem 0;
            position: relative;
        }

        .progress-bar-track {
            height: 10px;
            background:#e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-indicator {
            height: 100%;
            border-radius: 10px;
            position: relative;
            transition: width 0.3s ease;
        }

        .progress-bar-indicator.progress-high{
            background:#34d399;
        }

        .progress-bar-indicator.progress-medium{
            background:#fbbf24;
        }

        .progress-bar-indicator.progress-low{
            background:#ef4444;
        }

        .progress-marker {
            width: 12px;
            height: 12px;
            background:white;
            border: 3px solid #3b82f6;
            border-radius: 50%;
            position: absolute;
            top: -2px;
            transform: translateX(-50%);
        }

        .action-button {
            margin-top: 1rem;
            display: flex;
            align-items:center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            background:#1e3a8a;
            color:white;
            border-radius: 12px;
            font-weight: 600;
            transition: all .2s ease;
            text-decoration:none;
        }

        .action-button:hover {
            background:#1e40af;
            transform: translateY(-2px);
        }

        .arrow-icon {
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .overview-grid {
                grid-template-columns: 1fr;
            }

            .welcome-content {
                grid-template-columns: 1fr;
            }
        }
    </style>

@endsection
