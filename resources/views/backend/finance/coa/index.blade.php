@extends('layouts.backend.master')
@section('title')
    Finance - Chart of Account
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
    @include('backend.finance.coa.modalUpdate')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Chart of Account</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Chart of Account</h4>
                    <div class="button-list mb-1">
                        <a href="javascript:void(0)" onclick="reload()" class="btn btn-info"><i class="uil-refresh"></i> Reload</a>
                    </div>
                    <div class="mb-2">Note : Kode COA ini tidak bisa diubah / dihapus.</div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>Kode Coa</th>
                                    <th>Item</th>
                                    <th>S.A Debit</th>
                                    <th>S.A Credit</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('finance.coa') }}",
            columns: [
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'item',
                    name: 'item',
                },
                {
                    data: 'debit',
                    name: 'debit'
                },
                {
                    data: 'credit',
                    name: 'credit'
                },
                {
                    data: 'tahun',
                    name: 'tahun',
                    // orderable: false,
                    // searchable: false
                },
                // {
                //     data: 'action',
                //     name: 'action',
                // },
            ],
            order: [0, 'asc'],
            // "columnDefs": [ {
            // "targets": 0,
            // "orderable": false
            // } ]
        });

        function reload(){
            table.ajax.reload(null, false);
        }

        function buat(){
            $('#modalBuat').modal('show');
        }

        function inputCode(id)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('finance/coa/') }}"+'/'+id,
                beforeSend: () => {

                },
                success: (result) => {
                    if (result.success != false) {
                        $('#modalId').val(result.data.id);
                        document.getElementById('modalCode').innerHTML = result.data.code;
                        document.getElementById('modalItem').innerHTML = result.data.item;
                        $('#modalDebit').val(result.data.debit);
                        $('#modalCredit').val(result.data.credit);
                        $('#modalInputCoa').modal('show');
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: true,
                            // showConfirmButton: false,
                        });
                    }
                },
                error: function(request, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: error,
                        // showConfirmButton: false,
                    });
                }
            });
        }

        $('#form-update').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            Swal.fire({
                title: "Apakah Sudah Yakin?",
                text: "Anda tidak dapat mengubah setelah submit",
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-primary me-2 mt-2',
                    cancelButton: 'btn btn-danger mt-2',
                },
                confirmButtonText: "Ya, Submit",
                buttonsStyling: false,
                showCloseButton: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('finance.coa.simpan') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            Swal.fire({
                                icon: "info",
                                title: "Sedang Diproses, Silahkan Tunggu",
                                showConfirmButton: false,
                            });
                        },
                        success: (result) => {
                            if (result.success != false) {
                                Swal.fire({
                                    icon: result.message_type,
                                    title: result.message_title,
                                    text: result.message_content,
                                    showConfirmButton: true,
                                });
                                $('#modalInputCoa').modal('hide');
                                this.reset;
                                table.ajax.reload(null, false);
                                // setTimeout(function(){
                                //     location.reload();
                                // }, 2000);
                            } else {
                                // alert(result);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: result.error,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(request, status, error) {
                            alert(error);
                            Swal.fire({
                                icon: 'error',
                                title: error,
                                // showConfirmButton: false,
                            });
                        }
                    });
                }
            })
        });
    </script>
@endsection