<h5 class="fw-bold mb-3">{{ $desa->nama_desa }}</h5>

<p><b>Kode Desa:</b> {{ $desa->kode_desa }}</p>
<p><b>Kades:</b> {{ $desa->nama_kades }}</p>
<p><b>Alamat:</b> {{ $desa->alamat_kantor }}</p>
<p><b>Telepon:</b> {{ $desa->no_telp }}</p>

<h6 class="fw-bold mt-4">User Desa:</h6>
<ul>
    @foreach ($desa->users as $u)
        <li>{{ $u->name }} — {{ $u->email }}</li>
    @endforeach
</ul>
