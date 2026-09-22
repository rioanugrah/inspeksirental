<div class="modal fade" id="modalBuat" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPriceLabel">Buat Jurnal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Uraian</label>
                                <input type="text" name="uraian" class="form-control" placeholder="Uraian" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kode Debit</label>
                                <select name="code_debit" class="form-control" id="">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($coas as $item)
                                        <option value="{{ $item->code.'|'.$item->item }}">{{ $item->code.' - '.$item->item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kode Credit</label>
                                <select name="code_credit" class="form-control" id="">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($coas as $item)
                                        <option value="{{ $item->code.'|'.$item->item }}">{{ $item->code.' - '.$item->item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Nominal</label>
                                <input type="number" name="nominal" class="form-control" placeholder="Nominal" id="">
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
