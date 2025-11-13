<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">
        <i class="bi bi-info-circle me-2"></i>
        Detail Desa – {{ $desa->nama_desa }}
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <table class="table table-bordered">
        <tr>
            <th width="30%">Nama Desa</th>
            <td>{{ $desa->nama_desa }}</td>
        </tr>
        <tr>
            <th>Kode Desa</th>
            <td>{{ $desa->kode_desa }}</td>
        </tr>
        <tr>
            <th>No Telepon</th>
            <td>{{ $desa->no_telp ?? '-' }}</td>
        </tr>
        <tr>
            <th>Alamat Kantor</th>
            <td>{{ $desa->alamat_kantor ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah User</th>
            <td>
                <span class="badge bg-info">{{ $desa->users->count() }} user</span>
            </td>
        </tr>
        <tr>
            <th>Dibuat Pada</th>
            <td>{{ $desa->created_at->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <th>Terakhir Update</th>
            <td>{{ $desa->updated_at->format('d M Y H:i') }}</td>
        </tr>
    </table>

    <h6 class="fw-bold mt-4">User Operator:</h6>

    <ul class="list-group">
        @foreach ($desa->users as $user)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <strong>{{ $user->name }}</strong><br>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>

                <span class="badge bg-secondary">{{ $user->role }}</span>
            </li>
        @endforeach
    </ul>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        Tutup
    </button>
</div>
