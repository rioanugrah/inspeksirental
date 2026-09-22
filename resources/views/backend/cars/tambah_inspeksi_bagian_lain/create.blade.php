@extends('layouts.backend.master')
@section('title')
   Tambah Inspeksi Lain - Lain
@endsection
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card">
            <form id="tambah-bagian-lain" method="post" class="repeater" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h6 class="card-title border-bottom p-3 mb-0 header-title">Tambah Inspeksi Lain - Lain ({{ $inspeksi_lain->cars->plat_nomor }})</h6>
                <div class="row mt-3" data-repeater-list="group-a">
                    <div class="col-md-3 mb-3" data-repeater-item>
                        <div style="font-weight: bold">Keterangan Lain - Lain</div>
                            <input type="file" name="foto_lain_lain" class="form-control" id="">
                            <textarea name="keterangan_lain_lain" class="form-control" cols="30" rows="2"></textarea>
                            <input data-repeater-delete type="button" class="btn btn-danger" value="Delete" />
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-success" value="Add" />
            </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend/assets/js/jquery.repeater.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.repeater.min.js') }}"></script>

    <script>
        $('.repeater').repeater({
            defaultValues: {
                'textarea-input': 'foo',
                'text-input': 'bar',
                'select-input': 'B',
                'checkbox-input': ['A', 'B'],
                'radio-input': 'B'
            },
            show: function() {
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {

            }
        });
    </script>
@endsection
