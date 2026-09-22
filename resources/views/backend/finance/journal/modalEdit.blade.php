<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPriceLabel">Edit Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Uraian</label>
                                <input type="text" name="uraian" class="form-control" placeholder="Uraian" id="edit_uraian">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Kode Debit</label>
                                <select name="code_debit" class="form-control" id="edit_kode_debit">
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
                                <select name="code_credit" class="form-control" id="edit_kode_credit">
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
                                <input type="number" name="nominal" class="form-control" placeholder="Nominal" id="edit_nominal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
