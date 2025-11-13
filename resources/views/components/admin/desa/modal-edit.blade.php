<div class="modal fade" id="modalEditDesa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-xl">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Desa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditDesa" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body" id="editContent">
                    {{-- AJAX form content here --}}
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
