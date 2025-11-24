<div class="border rounded p-3">

    <div class="mb-2">
        <label>
            <input type="checkbox" id="checkAllDesa"> <strong>Pilih Semua</strong>
        </label>
    </div>

    <div class="grid grid-cols-2 gap-2">
        @foreach ($desas as $desa)
            <label class="flex items-center gap-2">
                <input type="checkbox" name="desa_ids[]" value="{{ $desa->id }}" class="desa-check"
                    {{ in_array($desa->id, $selected ?? []) ? 'checked' : '' }}>

                {{ $desa->nama_desa }}
            </label>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('checkAllDesa').addEventListener('change', function() {
        let status = this.checked;
        document.querySelectorAll('.desa-check').forEach(cb => cb.checked = status);
    });
</script>
