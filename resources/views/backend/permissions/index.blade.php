@extends('layouts.backend.master')
@section('title')
    Permissions
@endsection
@section('css')
    <link href="{{ asset('backend/') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/') }}/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('backend.permissions.modalBuat')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Permissions</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Permissions</h4>
                    <div class="btn-group mt-2 mb-2 pull-right">
                        <button onclick="buat()" class="btn btn-primary">Buat Permission</button>
                        <button onclick="reload()" class="btn btn-primary">Reload</button>
                    </div>
                    <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Guard</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
    </script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="{{ asset('backend/') }}/assets/js/pages/sweetalert2@11.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('permissions') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'guard_name',
                    name: 'guard_name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            // order: [1, 'desc']
        });

        function reload() {
            table.ajax.reload();
        }

        function buat() {
            $('#modal_buat').modal('show');
        }

        $('#upload-form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('permissions.simpan') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: result.message_content,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        // toastr["success"](result.message_content);
                        // toastr.options = {
                        //     "closeButton": false,
                        //     "debug": false,
                        //     "newestOnTop": false,
                        //     "progressBar": true,
                        //     "positionClass": "toast-top-right",
                        //     "preventDuplicates": false,
                        //     "onclick": null,
                        //     "showDuration": 300,
                        //     "hideDuration": 1000,
                        //     "timeOut": 5000,
                        //     "extendedTimeOut": 1000,
                        //     "showEasing": "swing",
                        //     "hideEasing": "linear",
                        //     "showMethod": "fadeIn",
                        //     "hideMethod": "fadeOut"
                        // }
                        this.reset();
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: result.error,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        // toastr["error"](result.error);
                        // toastr.options = {
                        //     "closeButton": false,
                        //     "debug": false,
                        //     "newestOnTop": false,
                        //     "progressBar": true,
                        //     "positionClass": "toast-top-right",
                        //     "preventDuplicates": false,
                        //     "onclick": null,
                        //     "showDuration": 300,
                        //     "hideDuration": 1000,
                        //     "timeOut": 5000,
                        //     "extendedTimeOut": 1000,
                        //     "showEasing": "swing",
                        //     "hideEasing": "linear",
                        //     "showMethod": "fadeIn",
                        //     "hideMethod": "fadeOut"
                        // }
                    }
                },
                error: function(request, status, error) {
                    // toastr["error"](error);
                    // toastr.options = {
                    //     "closeButton": false,
                    //     "debug": false,
                    //     "newestOnTop": false,
                    //     "progressBar": true,
                    //     "positionClass": "toast-top-right",
                    //     "preventDuplicates": false,
                    //     "onclick": null,
                    //     "showDuration": 300,
                    //     "hideDuration": 1000,
                    //     "timeOut": 5000,
                    //     "extendedTimeOut": 1000,
                    //     "showEasing": "swing",
                    //     "hideEasing": "linear",
                    //     "showMethod": "fadeIn",
                    //     "hideMethod": "fadeOut"
                    // }
                }
            });
        });
    </script>
@endsection
