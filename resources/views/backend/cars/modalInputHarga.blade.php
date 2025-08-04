<div class="modal fade" id="modalInputHarga" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPriceLabel">Harga Inspeksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submit-modal-price" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modalId" id="modalIdNew">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">No. Reference</label>
                                <div id="modalNoReference"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Plat Nomor</label>
                                <div id="modalPlatNomor"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Warna Mobil</label>
                                <div id="modalWarnaMobil"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Merk Mobil</label>
                                <div id="modalMerk"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Model Mobil</label>
                                <div id="modalModel"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">No. Rangka</label>
                                <div id="modalNoRangka"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Transmisi</label>
                                <div id="modalTransmisi"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Status Kendaraan</label>
                                <div id="modalStatus"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Harga Inspeksi</label>
                                <div>
                                    <input type="number" name="modalPrice" min="0" class="form-control" placeholder="Harga Inspeksi" id="modalPrice">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
