@extends('layouts.desaLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- 🔰 INFO LOGIN USER --}}
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="bi bi-person-check text-2xl text-white"></i>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold mb-3">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h2>

                        {{-- Dibuat vertikal --}}
                        <div class="flex flex-col gap-2 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-person-badge text-blue-200"></i>
                                <span class="text-blue-100">Role:</span>
                                <span class="font-semibold text-white">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>

                            @if (Auth::user()->desa)
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-building text-blue-200"></i>
                                    <span class="text-blue-100">Desa:</span>
                                    <span class="font-semibold text-white">{{ Auth::user()->desa->nama_desa }}</span>
                                </div>

                                @if (Auth::user()->desa->kode_desa)
                                    <div class="flex items-center gap-2">
                                        <i class="bi bi-qr-code text-blue-200"></i>
                                        <span class="text-blue-100">Kode:</span>
                                        <span class="font-semibold text-white">{{ Auth::user()->desa->kode_desa }}</span>
                                    </div>
                                @endif

                                @if (Auth::user()->desa->nama_kades)
                                    <div class="flex items-center gap-2">
                                        <i class="bi bi-person-gear text-blue-200"></i>
                                        <span class="text-blue-100">Kepala Desa:</span>
                                        <span class="font-semibold text-white">{{ Auth::user()->desa->nama_kades }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 bg-white/10 rounded-xl p-3">
                    <i class="bi bi-calendar-check text-blue-200 text-xl"></i>
                    <div class="text-right">
                        <div class="text-blue-100 text-sm">Tanggal</div>
                        <div class="font-semibold text-white">{{ now()->format('d F Y') }}</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- 🏡 JUDUL KLASTER --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-900 to-blue-700 rounded-lg flex items-center justify-center">
                <i class="bi bi-speedometer2 text-white text-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Desa Layak Anak</h2>
        </div>

        {{-- 🧩 GRID KLASTER (FIX HEIGHT) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach ($klasters as $klaster)
                @php
                    $progress = $klaster->progres ?? 0;
                    $progressColor =
                        $progress >= 80 ? 'bg-green-500' : ($progress >= 50 ? 'bg-yellow-400' : 'bg-orange-400');

                    $badgeColor = match ($klaster->status) {
                        'approved' => 'bg-green-100 text-green-800 border border-green-200',
                        'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                        'rejected' => 'bg-red-100 text-red-800 border border-red-200',
                        default => 'bg-gray-100 text-gray-800 border border-gray-200',
                    };

                    $badgeIcon = match ($klaster->status) {
                        'approved' => 'bi-check-circle-fill',
                        'pending' => 'bi-clock-fill',
                        'rejected' => 'bi-x-circle-fill',
                        default => 'bi-dash-circle-fill',
                    };

                    $badgeText = strtoupper($klaster->status);
                @endphp

                {{-- CARD FIX HEIGHT --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 flex flex-col h-full">

                    {{-- HEADER --}}
                    <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white p-6 relative flex flex-col gap-3">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold pr-6">{{ $klaster->title }}</h3>

                            <span
                                class="inline-flex items-center gap-1 text-xs font-bold px-3 py-2 rounded-full shadow {{ $badgeColor }}">
                                <i class="bi {{ $badgeIcon }}"></i> {{ $badgeText }}
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-blue-100">
                            <span class="flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full">
                                <i class="bi bi-graph-up"></i>
                                {{ $progress }}% Complete
                            </span>

                            <span class="flex items-center gap-2">
                                <i class="bi bi-star"></i>
                                EM: <b class="text-white">{{ number_format($klaster->nilai_em, 2) }}</b>
                            </span>

                            <span class="flex items-center gap-2">
                                <i class="bi bi-bullseye"></i>
                                Max: <b class="text-white">{{ number_format($klaster->nilai_maksimal, 2) }}</b>
                            </span>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="p-6 flex flex-col justify-between flex-1">

                        <div>
                            <div class="flex justify-between text-sm text-gray-600 mb-3">
                                <span class="font-medium">Progress Nilai</span>
                                <span class="font-semibold">{{ $klaster->nilai_em }} /
                                    {{ $klaster->nilai_maksimal }}</span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
                                <div class="{{ $progressColor }} h-3 rounded-full transition-all duration-500 flex items-center justify-end"
                                    style="width: {{ $progress }}%;">
                                    @if ($progress > 20)
                                        <div class="w-4 h-4 bg-white rounded-full mr-1 shadow"></div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-between text-xs text-gray-500 mb-4">
                                <span>0%</span>
                                <span>50%</span>
                                <span>100%</span>
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <a href="{{ route('desa.klaster.detail', $klaster->slug) }}"
                            class="mt-auto flex items-center justify-center gap-2 w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold py-3 rounded-xl hover:shadow-lg transition-all duration-200">
                            <i class="bi bi-pencil-square"></i>
                            Proses Penilaian
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
@endsection

<style>
    .grid>div {
        height: 100%;
    }
</style>
