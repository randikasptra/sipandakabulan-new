@extends('layouts.adminLayout')
@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="text-2xl font-bold mb-6">📊 Dashboard Admin</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-xl p-5 text-center">
            <i class="bi bi-building text-blue-600 text-3xl mb-2"></i>
            <h3 class="font-semibold text-lg">Total Desa</h3>
            <p class="text-gray-500">12 Desa Terdaftar</p>
        </div>
        <div class="bg-white shadow rounded-xl p-5 text-center">
            <i class="bi bi-hourglass-split text-yellow-500 text-3xl mb-2"></i>
            <h3 class="font-semibold text-lg">Pending Penilaian</h3>
            <p class="text-gray-500">24 Data</p>
        </div>
        <div class="bg-white shadow rounded-xl p-5 text-center">
            <i class="bi bi-check-circle-fill text-green-600 text-3xl mb-2"></i>
            <h3 class="font-semibold text-lg">Approved Penilaian</h3>
            <p class="text-gray-500">56 Data</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <h4 class="font-bold text-lg mb-3">Grafik Penilaian Desa</h4>
        <canvas id="chartPenilaian"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartPenilaian');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Klaster 1', 'Klaster 2', 'Klaster 3', 'Klaster 4'],
                datasets: [{
                    label: 'Jumlah Desa Selesai',
                    data: [10, 8, 6, 12],
                    borderWidth: 1,
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
