@extends('layouts.desaLayout')

@section('content')
    <div class="dashboard-wrapper">
        
        {{-- WELCOME HEADER --}}
        <div class="welcome-hero mt-24">
            <div class="welcome-pattern"></div>
            <div class="welcome-content">
                
                {{-- User Profile Section --}}
                <div class="user-profile-section">
                    <div class="user-avatar-wrapper">
                        <div class="user-avatar">
                            <i class="bi bi-person-circle text-3xl"></i>
                        </div>
                        <div class="status-indicator">
                            <i class="bi bi-check-circle-fill text-xs"></i>
                        </div>
                    </div>

                    <div class="user-details">
                        <div class="user-header">
                            <h1 class="user-name">Selamat Datang, {{ Auth::user()->name }}</h1>
                            <span class="user-role-badge">
                                <i class="bi bi-star-fill"></i>
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>

                        @if (Auth::user()->desa)
                            <div class="info-cards-grid">
                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bi bi-house-door-fill"></i>
                                    </div>
                                    <div class="info-card-content">
                                        <span class="info-card-label">Desa</span>
                                        <span class="info-card-value">{{ Auth::user()->desa->nama_desa }}</span>
                                    </div>
                                </div>

                                @if (Auth::user()->desa->kode_desa)
                                    <div class="info-card">
                                        <div class="info-card-icon">
                                            <i class="bi bi-qr-code-scan"></i>
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
                                            <i class="bi bi-person-badge-fill"></i>
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
                        <i class="bi bi-calendar-check-fill text-xl"></i>
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
                            <i class="bi bi-star-fill text-xl"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">Nilai EM</span>
                            <span class="stat-value">{{ number_format($totalEm, 2) }}</span>
                        </div>
                    </div>

                    <div class="stat-card stat-max">
                        <div class="stat-icon">
                            <i class="bi bi-bullseye text-xl"></i>
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
                                        <i class="bi bi-check-circle-fill"></i>
                                    @elseif($status === 'pending')
                                        <i class="bi bi-clock-fill"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="status-content">
                                <span class="status-label">{{ $data['label'] }}</span>
                                <span class="status-count">{{ $data['count'] }} Klaster</span>
                            </div>
                            <div class="status-arrow">
                                <i class="bi bi-chevron-right"></i>
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
                        <i class="bi bi-speedometer2 text-lg"></i>
                    </div>
                    <div class="section-badge">{{ count($klasters) }}</div>
                </div>
                <div class="section-info">
                    <h2 class="section-title">Dashboard Desa Layak Anak</h2>
                    <p class="section-subtitle">Kelola dan pantau progress setiap klaster</p>
                </div>
            </div>
        </div>

        {{-- KLASTER GRID --}}
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

                <div class="group bg-white rounded-2xl shadow-lg border border-gray-200 hover:shadow-xl hover:border-blue-300 transition-all duration-300 overflow-hidden flex flex-col">
                    {{-- HEADER --}}
                    <div class="relative bg-gradient-to-br from-blue-800 to-blue-600 p-5 text-white">
                        <div class="absolute inset-0 opacity-10"
                             style="background-image:url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        </div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-lg">{{ $klaster->title }}</h3>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                                    <i class="bi {{ $statusConfig['icon'] }} text-xs"></i>
                                    {{ strtoupper($klaster->status) }}
                                </span>
                            </div>

                            <div class="flex items-center flex-wrap gap-2">
                                <div class="flex items-center gap-2 px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full">
                                    <div class="w-1.5 h-1.5 bg-gradient-to-r {{ $progressColor }} rounded-full animate-pulse"></div>
                                    <span class="text-xs font-semibold">{{ $progress }}%</span>
                                </div>

                                <div class="flex items-center gap-1 text-blue-100">
                                    <i class="bi bi-star-fill text-yellow-300 text-sm"></i>
                                    <span class="text-xs">EM: {{ number_format($klaster->nilai_em, 2) }}</span>
                                </div>

                                <div class="flex items-center gap-1 text-blue-100">
                                    <i class="bi bi-bullseye text-cyan-300 text-sm"></i>
                                    <span class="text-xs">Max: {{ number_format($klaster->nilai_maksimal, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="p-5 flex flex-col flex-1">
                        {{-- Progress --}}
                        <div class="mb-5">
                            <div class="flex justify-between text-sm text-gray-700 mb-2">
                                <span class="font-medium">Progress Nilai</span>
                                <span class="font-semibold">{{ $klaster->nilai_em }} / {{ $klaster->nilai_maksimal }}</span>
                            </div>

                            <div class="relative">
                                <div class="w-full h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-2.5 bg-gradient-to-r {{ $progressColor }} rounded-full transition-all duration-700 relative"
                                         style="width: {{ $progress }}%">
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white/30 animate-shimmer"></div>
                                    </div>
                                </div>

                                @if($progress > 10)
                                    <div class="absolute top-1/2 -translate-y-1/2"
                                         style="left: calc({{ $progress }}% - 6px)">
                                        <div class="w-3 h-3 bg-white rounded-full border-2 border-blue-700 shadow"></div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-between text-xs text-gray-400 mt-1.5">
                                <span>0%</span>
                                <span>50%</span>
                                <span>100%</span>
                            </div>
                        </div>

                        {{-- Button --}}
                        <a href="{{ route('desa.klaster.detail', $klaster->slug) }}"
                           class="mt-auto flex items-center justify-center w-full bg-gradient-to-r from-blue-700 to-blue-600 text-white font-semibold py-2.5 rounded-xl hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all gap-2 text-sm">
                            <i class="bi bi-pencil-square"></i>
                            Proses Penilaian
                            <i class="bi bi-arrow-right-short text-base"></i>
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
            padding: 1rem;
        }

        /* Welcome Hero */
        .welcome-hero {
            position: relative;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(30, 58, 138, 0.2);
        }

        .welcome-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 30px, rgba(255,255,255,.1) 30px, rgba(255,255,255,.1) 60px);
        }

        .welcome-content {
            position: relative;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1.5rem;
            align-items: start;
        }

        .user-profile-section {
            display: flex;
            gap: 1.25rem;
        }

        .user-avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .user-avatar {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.2);
            font-size: 2rem;
        }

        .status-indicator {
            position: absolute;
            bottom: -3px;
            right: -3px;
            width: 28px;
            height: 28px;
            background: #10b981;
            border-radius: 50%;
            border: 3px solid #1e3a8a;
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
            gap: 0.875rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .user-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .info-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.875rem;
        }

        .info-card {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.875rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .info-card-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .info-card-content {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .info-card-label {
            font-size: 0.6875rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .info-card-value {
            font-size: 0.8125rem;
            color: white;
            font-weight: 600;
        }

        .date-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 1.25rem;
            min-width: 180px;
        }

        .date-card-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 0.875rem;
            font-size: 1.25rem;
        }

        .date-card-content {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .date-card-label {
            font-size: 0.8125rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .date-card-value {
            font-size: 1rem;
            color: white;
            font-weight: 600;
        }

        /* Overview Grid */
        .overview-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .progress-main-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 20px;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.2);
        }

        .progress-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .progress-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.375rem;
        }

        .progress-card-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8125rem;
        }

        .progress-percentage {
            text-align: right;
        }

        .percentage-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }

        .percentage-label {
            font-size: 0.8125rem;
            margin-top: 0.125rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .progress-bar-section {
            margin-bottom: 1.5rem;
        }

        .progress-bar-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .progress-bar-container {
            width: 100%;
            height: 12px;
            border-radius: 8px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.25);
        }

        .progress-bar-fill {
            height: 100%;
            position: relative;
            background: linear-gradient(90deg, #34d399, #10b981);
            border-radius: 8px;
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
            gap: 0.875rem;
            margin-top: 1.5rem;
        }

        .stat-card {
            padding: 1rem;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 0.875rem;
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
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items:center;
            justify-content:center;
            flex-shrink: 0;
            font-size: 1.125rem;
        }

        .stat-label {
            font-size: 0.8125rem;
            color: rgba(255,255,255,0.8);
        }

        .stat-value {
            font-size: 1rem;
            font-weight: 600;
        }

        /* Status Summary */
        .status-summary-card {
            background: white;
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: 0 6px 25px rgba(0,0,0,0.06);
        }

        .summary-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
        }

        .status-list {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            transition: all .2s ease;
        }

        .status-item:hover {
            transform: translateX(3px);
        }

        .status-icon-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 10px;
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
            padding: 0 0.875rem;
        }

        .status-label {
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .status-count {
            font-size: 0.6875rem;
            color: #6b7280;
        }

        .status-arrow {
            opacity: 0.6;
            font-size: 0.875rem;
        }

        /* Section Header */
        .section-header {
            margin-top: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .section-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-icon-wrapper {
            position: relative;
        }

        .section-icon {
            width: 42px;
            height: 42px;
            background: #1e3a8a;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items:center;
            justify-content:center;
            font-size: 1.125rem;
        }

        .section-badge {
            position: absolute;
            right: -5px;
            bottom: -5px;
            background: #3b82f6;
            color:white;
            padding: 0.2rem 0.4rem;
            border-radius: 50%;
            font-size: 0.6875rem;
            font-weight: 600;
            border: 2px solid white;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .section-subtitle {
            color:#6b7280;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .overview-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .welcome-content {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
            
            .user-profile-section {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .user-header {
                justify-content: center;
            }
            
            .date-card {
                min-width: auto;
            }
            
            .info-cards-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            
            .dashboard-wrapper {
                padding: 0.75rem;
            }
            
            .welcome-hero {
                padding: 1.5rem 1rem;
            }
        }

        @media (max-width: 640px) {
            .user-name {
                font-size: 1.25rem;
            }
            
            .progress-card-title {
                font-size: 1.125rem;
            }
            
            .section-title {
                font-size: 1.125rem;
            }
        }
    </style>

@endsection