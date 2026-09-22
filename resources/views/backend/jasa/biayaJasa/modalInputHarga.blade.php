<div class="modal fade" id="modalInputHarga" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPriceLabel">Input Harga Inspeksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submit-modal-price" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modalId" id="modalIdNew">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">No. Reference</label>
                                <div id="modalNoReference"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">Plat Nomor</label>
                                <div id="modalPlatNomor"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">Warna Mobil</label>
                                <div id="modalWarnaMobil"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">Merk Mobil</label>
                                <div id="modalMerk"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">Model Mobil</label>
                                <div id="modalModel"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">No. Rangka</label>
                                <div id="modalNoRangka"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">Transmisi</label>
                                <div id="modalTransmisi"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="">Status Kendaraan</label>
                                <div id="modalStatus"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Nama Pelanggan</label>
                                <div>
                                    <input type="text" name="customer" class="form-control"
                                        placeholder="Nama Pelanggan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Provinsi</label>
                                <select class="form-control" id="provinsi">
                                    <option value="">-- Pilih Lokasi Inspeksi --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $province->id == 35 ? 'selected' : null }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kab. / Kota</label>
                                <select name="lokasi" class="form-control" id="kabkota">
                                    <option value="">-- Pilih Kab / Kota --</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Lokasi Pelanggan</label>
                                <div>
                                    <input type="text" name="lokasi" class="form-control"
                                        placeholder="Lokasi Pelanggan">
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Total Biaya Inspeksi</label>
                                <div>
                                    <input type="number" name="priceBiayaJasa" min="0" class="form-control"
                                        placeholder="Total Biaya Inspeksi" id="modalPrice">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Biaya Transport</label>
                                <div>
                                    <input type="number" name="priceBiayaTransport" min="0" class="form-control"
                                        placeholder="Biaya Transport">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Gaji Karyawan</label>
                                <div>
                                    <input type="number" name="priceGajiKaryawan" min="0"
                                        class="form-control" placeholder="Gaji Karyawan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Metode Pembayaran</label>
                                <select name="metode_pembayaran" class="form-control" id="">
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Cash">Cash</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan" id="" cols="30" rows="5"></textarea>
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
