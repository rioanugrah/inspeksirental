<div class="modal fade" id="modalInputCoa" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPriceLabel">Input/Update Chart of Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modalId" id="modalId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kode COA</label>
                                <div id="modalCode"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Item</label>
                                <div id="modalItem"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">S.A Debit</label>
                                <input type="number" name="debit" class="form-control" min="0" placeholder="Rp." id="modalDebit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">S.A Credit</label>
                                <input type="number" name="credit" class="form-control" min="0" placeholder="Rp." id="modalCredit">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="">Ket :</label>
                        <span>Chart of Account ini diinput setelah tutup buku setiap akhir tahun</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
