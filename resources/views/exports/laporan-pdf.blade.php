<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penilaian ({{ $bulan }} {{ $tahun }})</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>Laporan Penilaian Desa<br>{{ $bulan }} {{ $tahun }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Desa</th>
                <th>Klaster</th>
                <th>Indikator</th>
                <th>Nilai</th>
                <th>Bulan</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penilaians as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->desa->nama_desa ?? '-' }}</td>
                    <td>{{ $p->klaster->title ?? '-' }}</td>
                    <td>{{ $p->indikator->nama_indikator ?? '-' }}</td>
                    <td>{{ $p->nilai ?? '-' }}</td>
                    <td>{{ $p->bulan }}</td>
                    <td>{{ $p->tahun }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
