<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEmailLabel">Kirim Email Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submit-modal-email" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="modalId" id="modalId">
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Customer</label>
                    <input type="text" name="modalNamaCustormer" class="form-control" placeholder="Nama Customer" id="">
                </div>
                <div class="mb-3">
                    <label>Email Customer</label>
                    <input type="email" name="modalEmail" class="form-control" placeholder="Email Customer" id="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
            </form>
        </div>
    </div>
</div>