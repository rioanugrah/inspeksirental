<div class="modal" id="modalExportPDF" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download Export PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('lap_keuangan.export_pdf') }}" method="get" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Tahun</label>
                                <select name="years" class="form-control">
                                    <option value="">-- Pilih Tahun --</option>
                                    @for ($i = 2023; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $_GET['years'] == $i ? 'selected' : null }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Bulan</label>
                            <select name="month" class="form-control">
                                <option value="">-- Pilih Bulan --</option>
                                @for ($i = 01; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $_GET['month'] == $i ? 'selected' : null }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
