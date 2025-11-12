<table border="1" cellspacing="0" cellpadding="5">
    <thead style="background:#3498db;color:white;">
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
