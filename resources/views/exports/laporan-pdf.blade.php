<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penilaian {{ $bulan }} {{ $tahun }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 9px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 3px solid #1e3a8a;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            padding: 15px;
        }

        .header h1 {
            font-size: 18px;
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            color: #1e40af;
            font-weight: 600;
        }

        .info-box {
            background-color: #f0f9ff;
            padding: 10px;
            border-left: 4px solid #3b82f6;
            margin-bottom: 15px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .info-item {
            font-size: 9px;
        }

        .info-item strong {
            color: #1e3a8a;
            display: block;
            margin-bottom: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 8px;
        }

        thead {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
        }

        thead th {
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: 600;
            border: 1px solid #1e3a8a;
        }

        tbody td {
            padding: 6px 5px;
            border: 1px solid #e5e7eb;
            font-size: 8px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: 600;
        }

        .badge-green {
            background-color: #dcfce7;
            color: #166534;
        }

        .nilai-box {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 3px 8px;
            border-radius: 10px;
            font-weight: bold;
            display: inline-block;
        }

        .desa-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 8px 10px;
            font-weight: bold;
            font-size: 10px;
            margin-top: 10px;
        }

        .klaster-header {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 6px 10px;
            font-weight: 600;
            font-size: 9px;
            border-left: 4px solid #3b82f6;
        }

        .subtotal-row {
            background: linear-gradient(135deg, #fef3c7 0%, #fde047 100%);
            font-weight: bold;
            border-top: 2px solid #eab308;
            border-bottom: 2px solid #eab308;
        }

        .grandtotal-row {
            background: linear-gradient(135deg, #dcfce7 0%, #86efac 100%);
            font-weight: bold;
            border-top: 3px solid #22c55e;
            font-size: 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN PENILAIAN DESA</h1>
        <p>Periode: {{ $bulan }} {{ $tahun }}</p>
    </div>

    <div class="info-box">
        <div class="info-item">
            <strong>Tanggal Export:</strong>
            {{ now()->format('d F Y, H:i') }} WIB
        </div>
        <div class="info-item">
            <strong>Total Penilaian:</strong>
            {{ $penilaians->count() }} penilaian
        </div>
        <div class="info-item">
            <strong>Status:</strong>
            <span class="badge badge-green">APPROVED</span>
        </div>
    </div>

    @php
        $currentDesa = null;
        $currentKlaster = null;
        $no = 0;
        $klasterSubtotal = 0;
        $desaSubtotal = 0;
        $grandTotal = 0;
        $klasterCount = 0;
        $desaCount = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Desa</th>
                <th width="20%">Klaster</th>
                <th width="38%">Indikator</th>
                <th width="10%" class="text-center">Nilai</th>
                <th width="10%" class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penilaians as $p)
                @php
                    // Cek perubahan Klaster - tampilkan subtotal
                    if ($currentKlaster !== null && $currentKlaster !== $p->klaster_id) {
                        echo '<tr class="subtotal-row">';
                        echo '<td colspan="4" class="text-right" style="padding: 6px 10px;"><strong>SUBTOTAL KLASTER:</strong></td>';
                        echo '<td class="text-center" style="padding: 6px; font-size: 10px;"><strong>' .
                            number_format($klasterSubtotal, 0) .
                            '</strong></td>';
                        echo '<td></td>';
                        echo '</tr>';
                        $klasterSubtotal = 0;
                        $klasterCount++;
                    }

                    // Cek perubahan Desa - tampilkan subtotal desa
                    if ($currentDesa !== null && $currentDesa !== $p->desa_id) {
                        echo '<tr class="grandtotal-row">';
                        echo '<td colspan="4" class="text-right" style="padding: 8px 10px;"><strong>TOTAL DESA ' .
                            strtoupper($penilaians->where('desa_id', $currentDesa)->first()->desa->nama_desa) .
                            ':</strong></td>';
                        echo '<td class="text-center" style="padding: 8px; font-size: 11px;"><strong>' .
                            number_format($desaSubtotal, 0) .
                            '</strong></td>';
                        echo '<td></td>';
                        echo '</tr>';
                        echo '<tr><td colspan="6" style="height: 10px; background: none; border: none;"></td></tr>';
                        $desaSubtotal = 0;
                        $desaCount++;
                    }

                    // Header Desa baru
                    $showDesa = $currentDesa !== $p->desa_id;
                    if ($showDesa) {
                        echo '<tr><td colspan="6" class="desa-header">📍 DESA: ' .
                            strtoupper($p->desa->nama_desa ?? '-') .
                            '</td></tr>';
                    }

                    // Header Klaster baru
                    $showKlaster = $currentKlaster !== $p->klaster_id;
                    if ($showKlaster) {
                        echo '<tr><td colspan="6" class="klaster-header">▶ ' .
                            ($p->klaster->title ?? '-') .
                            '</td></tr>';
                    }

                    $currentDesa = $p->desa_id;
                    $currentKlaster = $p->klaster_id;
                    $no++;

                    // Akumulasi
                    $klasterSubtotal += $p->nilai;
                    $desaSubtotal += $p->nilai;
                    $grandTotal += $p->nilai;
                @endphp
                <tr>
                    <td class="text-center">{{ $no }}</td>
                    <td>{{ $showDesa ? $p->desa->nama_desa ?? '-' : '' }}</td>
                    <td>{{ $showKlaster ? $p->klaster->title ?? '-' : '' }}</td>
                    <td>{{ $p->indikator->nama_indikator ?? '-' }}</td>
                    <td class="text-center">
                        <span class="nilai-box">{{ $p->nilai }}</span>
                    </td>
                    <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach

            {{-- Subtotal Klaster Terakhir --}}
            @if ($klasterSubtotal > 0)
                <tr class="subtotal-row">
                    <td colspan="4" class="text-right" style="padding: 6px 10px;"><strong>SUBTOTAL KLASTER:</strong>
                    </td>
                    <td class="text-center" style="padding: 6px; font-size: 10px;">
                        <strong>{{ number_format($klasterSubtotal, 0) }}</strong></td>
                    <td></td>
                </tr>
            @endif

            {{-- Subtotal Desa Terakhir --}}
            @if ($desaSubtotal > 0)
                <tr class="grandtotal-row">
                    <td colspan="4" class="text-right" style="padding: 8px 10px;"><strong>TOTAL DESA
                            {{ strtoupper($penilaians->last()->desa->nama_desa ?? '-') }}:</strong></td>
                    <td class="text-center" style="padding: 8px; font-size: 11px;">
                        <strong>{{ number_format($desaSubtotal, 0) }}</strong></td>
                    <td></td>
                </tr>
            @endif

            {{-- Grand Total --}}
            <tr
                style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; font-weight: bold; font-size: 11px; border: 3px solid #1e3a8a;">
                <td colspan="4" class="text-right" style="padding: 10px;"><strong>🏆 GRAND TOTAL SEMUA DESA:</strong>
                </td>
                <td class="text-center" style="padding: 10px; font-size: 14px;">
                    <strong>{{ number_format($grandTotal, 0) }}</strong></td>
                <td class="text-center"><strong>{{ $no }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Ringkasan:</strong> Total {{ $no }} penilaian approved dari semua desa | Grand Total Poin:
            {{ number_format($grandTotal, 0) }}</p>
        <p>Dokumen ini dibuat secara otomatis oleh sistem</p>
        <p>© {{ now()->year }} Sistem Penilaian Desa</p>
    </div>
</body>

</html>
