@extends('layouts.desaLayout')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- 🔰 Info Login User --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl shadow p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-2xl font-bold mb-1">👋 Selamat Datang, {{ Auth::user()->name }}</h2>
                    <p class="text-sm text-blue-100">
                        Role: <span class="font-semibold text-white">{{ ucfirst(Auth::user()->role) }}</span>
                    </p>
                    @if (Auth::user()->desa)
                        <p class="text-sm text-blue-100 mt-1">
                            Desa: <span class="font-semibold text-white">{{ Auth::user()->desa->nama_desa }}</span>
                            @if (Auth::user()->desa->kode_desa)
                                (Kode: {{ Auth::user()->desa->kode_desa }})
                            @endif
                        </p>
                        @if (Auth::user()->desa->nama_kades)
                            <p class="text-sm text-blue-100">
                                Kepala Desa: {{ Auth::user()->desa->nama_kades }}
                            </p>
                        @endif
                    @endif
                </div>

            </div>
        </div>

        {{-- 🏡 Daftar Klaster --}}
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Desa Layak Anak</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($klasters as $klaster)
                @php
                    $progress = $klaster->progres ?? 0;
                    $progressColor =
                        $progress >= 80 ? 'bg-green-500' : ($progress >= 50 ? 'bg-yellow-400' : 'bg-orange-400');
                    $badgeColor = match ($klaster->status) {
                        'approved' => 'bg-green-500 text-white',
                        'pending' => 'bg-yellow-400 text-gray-900',
                        'rejected' => 'bg-red-500 text-white',
                        default => 'bg-gray-300 text-gray-600',
                    };
                    $badgeText = strtoupper($klaster->status);
                @endphp

                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white p-5 relative">
                        <h3 class="text-lg font-semibold">{{ $klaster->title }}</h3>

                        {{-- Badge Status --}}
                        <span
                            class="absolute top-4 right-4 text-xs font-bold px-3 py-1 rounded-full shadow {{ $badgeColor }}">
                            {{ $badgeText }}
                        </span>

                        {{-- Progress Info --}}
                        <div class="mt-3 flex flex-wrap items-center gap-3 text-sm">
                            <span class="bg-blue-500/30 px-3 py-1 rounded-full">📈 {{ $progress }}% Complete</span>
                            <span>💡 EM: <b>{{ number_format($klaster->nilai_em, 2) }}</b></span>
                            <span>🎯 Max: <b>{{ number_format($klaster->nilai_maksimal, 2) }}</b></span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-5">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Nilai</span>
                            <span>{{ $klaster->nilai_em }} / {{ $klaster->nilai_maksimal }}</span>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                            <div class="{{ $progressColor }} h-3 rounded-full transition-all duration-500"
                                style="width: {{ $progress }}%;"></div>
                        </div>

                        <div class="flex justify-between text-xs text-gray-500 mb-4">
                            <span>0%</span>
                            <span>50%</span>
                            <span>100%</span>
                        </div>

                        {{-- Button --}}
                        <a href="{{ route('desa.klaster.detail', $klaster->slug) }}"
                            class="block w-full text-center border border-blue-500 text-blue-600 font-semibold py-2 rounded-full hover:bg-blue-500 hover:text-white transition">
                            Proses Penilaian
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
