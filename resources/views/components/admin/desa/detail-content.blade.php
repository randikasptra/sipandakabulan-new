<div class="p-3">
    <h5 class="fw-bold mb-3">{{ $desa->nama_desa }}</h5>

    <table class="table table-borderless table-sm">
        <tr>
            <td width="150" class="fw-bold">Kode Desa</td>
            <td>: <code>{{ $desa->kode_desa }}</code></td>
        </tr>
        <tr>
            <td class="fw-bold">Kepala Desa</td>
            <td>: {{ $desa->nama_kades ?? '-' }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Alamat</td>
            <td>: {{ $desa->alamat_kantor ?? '-' }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Telepon</td>
            <td>: {{ $desa->no_telp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="fw-bold">Terdaftar</td>
            <td>: {{ $desa->created_at->format('d F Y') }}</td>
        </tr>
    </table>

    <hr>

    <h6 class="fw-bold mt-3 mb-2">Operator Desa ({{ $desa->users->count() }} user):</h6>
    @if ($desa->users->count() > 0)
        <ul class="list-unstyled mb-0">
            @foreach ($desa->users as $user)
                <li class="mb-2">
                    <i class="bi bi-person-circle me-2"></i>
                    <strong>{{ $user->name }}</strong><br>
                    <small class="text-muted ms-4">{{ $user->email }}</small>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted mb-0"><em>Belum ada user</em></p>
    @endif
</div>
