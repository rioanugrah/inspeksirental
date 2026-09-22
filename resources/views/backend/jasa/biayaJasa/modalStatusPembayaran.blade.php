<div class="modal fade" id="modalStatusPembayaran" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPriceLabel">Update Status Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submit-modal-pembayaran" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modalId" id="modalIdPembayaran">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Customer</label>
                                <div id="modalCustomerPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Lokasi Inspeksi</label>
                                <div id="modalLokasiInspeksiPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">No. Reference</label>
                                <div id="modalNoReferencePembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Plat Nomor</label>
                                <div id="modalPlatNomorPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Warna Mobil</label>
                                <div id="modalWarnaMobilPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Merk Mobil</label>
                                <div id="modalMerkPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Model Mobil</label>
                                <div id="modalModelPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">No. Rangka</label>
                                <div id="modalNoRangkaPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Transmisi</label>
                                <div id="modalTransmisiPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Status Kendaraan</label>
                                <div id="modalMetodeStatusPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Biaya Jasa</label>
                                <div id="modalBiayaJasaPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Biaya Transport</label>
                                <div id="modalBiayaTransportPembayaran"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3 text-center">
                                <label for="">Total Biaya Customer</label>
                                <div id="modalBiayaCustomerPembayaran" class="fs-1 fw-bold text-success"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Apakah customer sudah melakukan pembayaran via transfer?</label>
                                <select name="payment_status" class="form-control" id="">
                                    <option value="">-- Pilih --</option>
                                    <option value="Paid">Sudah</option>
                                    <option value="Waiting">Belum</option>
                                </select>
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
