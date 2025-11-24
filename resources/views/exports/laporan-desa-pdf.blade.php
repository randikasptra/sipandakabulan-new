<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan {{ $desa->nama_desa }} - {{ $bulan }} {{ $tahun }}</title>
    <style>
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            padding: 25px;
            line-height: 1.5;
            background: #fafafa;
        }

        /* ================= HEADER ================= */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 12px;
            border-bottom: 3px solid #1e3a8a;
        }

        .header h1 {
            font-size: 22px;
            letter-spacing: 1px;
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 16px;
            color: #3b82f6;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 12px;
            color: #6b7280;
        }

        /* ================= INFO BOX ================= */
        .info-section {
            background: #f0f9ff;
            border-left: 5px solid #3b82f6;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
        }

        .info-section p {
            margin: 4px 0;
            font-size: 11.5px;
        }

        .info-section strong {
            width: 160px;
            display: inline-block;
            color: #1e3a8a;
        }

        /* ================= SUMMARY CARDS ================= */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            padding: 14px;
            border-radius: 10px;
            border: 1.5px solid #d1d5db;
            background: #f8fafc;
            text-align: center;
        }

        .summary-card .label {
            font-size: 10px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: .5px;
        }

        .summary-card .value {
            font-size: 22px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .summary-card.green {
            background: #dcfce7;
            border-color: #22c55e;
        }

        .summary-card.green .value {
            color: #166534;
        }

        .summary-card.purple {
            background: #f3e8ff;
            border-color: #a855f7;
        }

        .summary-card.purple .value {
            color: #6b21a8;
        }

        .summary-card.yellow {
            background: #fef9c3;
            border-color: #eab308;
        }

        .summary-card.yellow .value {
            color: #92400e;
        }

        /* ================= TABLE ================= */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        thead {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
        }

        thead th {
            padding: 10px 8px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        tbody td {
            padding: 9px 8px;
            font-size: 10.5px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:hover {
            background: #e0f2fe;
        }

        .text-center {
            text-align: center;
        }

        /* ================= BADGES ================= */
        .badge {
            padding: 4px 9px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-green {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #22c55e;
        }

        .badge-yellow {
            color: #92400e;
            background: #fef3c7;
            border: 1px solid #eab308;
        }

        .badge-red {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #ef4444;
        }

        .nilai-badge {
            padding: 6px 12px;
            border-radius: 20px;
            background: #dbeafe;
            border: 2px solid #3b82f6;
            font-weight: bold;
            color: #1e40af;
            font-size: 12px;
        }

        /* ================= SIGNATURE ================= */
        .signature {
            margin-top: 45px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-box p {
            font-size: 11px;
            margin-bottom: 50px;
        }

        .signature-box .name {
            border-top: 2px solid #444;
            padding-top: 5px;
            min-width: 180px;
            font-weight: bold;
            display: inline-block;
        }

        /* ================= FOOTER ================= */
        .footer {
            margin-top: 40px;
            padding-top: 12px;
            border-top: 1.5px solid #d1d5db;
            text-align: center;
        }

        .footer p {
            font-size: 9px;
            color: #737373;
            margin: 3px 0;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <h1>LAPORAN PENILAIAN DESA</h1>
        <h2>{{ $desa->nama_desa }}</h2>
        <p>Periode: {{ $bulan }} {{ $tahun }}</p>
    </div>

    <!-- INFO SECTION -->
    <div class="info-section">
        <p><strong>Nama Desa:</strong> {{ $desa->nama_desa }}</p>
        <p><strong>Periode Laporan:</strong> {{ $bulan }} {{ $tahun }}</p>
        <p><strong>Tanggal Export:</strong> {{ now()->format('d F Y, H:i') }} WIB</p>
        <p><strong>Total Klaster:</strong> {{ $klasters->count() }} klaster</p>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="label">Total Klaster</div>
            <div class="value">{{ $klasters->count() }}</div>
        </div>
        <div class="summary-card green">
            <div class="label">Disetujui</div>
            <div class="value">{{ $klasters->sum('approved') }}</div>
        </div>
        <div class="summary-card purple">
            <div class="label">Rata-rata</div>
            <div class="value">{{ number_format($klasters->avg('rata_rata'), 1) }}</div>
        </div>
        <div class="summary-card yellow">
            <div class="label">Total Poin</div>
            <div class="value">
                {{ number_format(
                    $klasters->sum(fn($k) => $k->indikators->flatMap->penilaians->where('status', 'approved')->sum('nilai')),
                    0,
                ) }}
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="40%">Nama Klaster</th>
                <th width="15%" class="text-center">Disetujui</th>
                <th width="15%" class="text-center">Menunggu</th>
                <th width="15%" class="text-center">Rata-rata</th>
                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($klasters as $i => $klaster)
                @php
                    $status = 'Pending';
                    $badgeClass = 'badge-yellow';
                    if ($klaster->rejected > 0) {
                        $status = 'Rejected';
                        $badgeClass = 'badge-red';
                    } elseif ($klaster->pending == 0 && $klaster->approved > 0) {
                        $status = 'Approved';
                        $badgeClass = 'badge-green';
                    }
                @endphp

                <tr>
                    <td class="text-center"><strong>{{ $i + 1 }}</strong></td>
                    <td><strong>{{ $klaster->title }}</strong></td>
                    <td class="text-center"><span class="badge badge-green">{{ $klaster->approved }}</span></td>
                    <td class="text-center"><span class="badge badge-yellow">{{ $klaster->pending }}</span></td>
                    <td class="text-center"><span
                            class="nilai-badge">{{ number_format($klaster->rata_rata, 2) }}</span></td>
                    <td class="text-center"><span class="badge {{ $badgeClass }}">{{ $status }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- SIGNATURE -->
    <div class="signature">
        <div class="signature-box">
            <p>Mengetahui,<br>Kepala Desa</p>
            <div class="name">( ........................... )</div>
        </div>
        <div class="signature-box">
            <p>{{ now()->format('d F Y') }}<br>Petugas Penilaian</p>
            <div class="name">( ........................... )</div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Penilaian Desa</p>
        <p>© {{ now()->year }} Seluruh data adalah hasil penilaian final</p>
    </div>

</body>

</html>
