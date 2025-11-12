@extends('layouts.desaLayout')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary mb-3">
                <i class="bi bi-megaphone-fill me-2"></i> Pengumuman Desa
            </h2>
            <p class="text-muted">Halaman ini menampilkan informasi terbaru dan pengumuman penting untuk desa Anda.</p>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-2">📢 Sosialisasi Penilaian Klaster Desa 2025</h5>
                <p class="text-muted mb-3">Diumumkan pada: <strong>10 November 2025</strong></p>
                <p>
                    Diharapkan seluruh operator desa segera melengkapi data dan dokumen pendukung klaster sebelum tanggal 20
                    November 2025.
                    Pastikan semua dokumen telah diverifikasi sebelum dikirim untuk penilaian akhir.
                </p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-2">🗓️ Jadwal Evaluasi Akhir Tahun</h5>
                <p class="text-muted mb-3">Diumumkan pada: <strong>1 Desember 2025</strong></p>
                <p>
                    Evaluasi akhir tahun akan dilakukan oleh tim kabupaten mulai tanggal <strong>10 Desember 2025</strong>.
                    Mohon memastikan semua penilaian sudah selesai dan tidak ada yang berstatus pending.
                </p>
            </div>
        </div>
    </div>
@endsection
