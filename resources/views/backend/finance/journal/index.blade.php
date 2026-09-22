@extends('layouts.backend.master')
@section('title')
    Finance - Jurnal Umum
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
    @include('backend.finance.journal.modalBuat')
    @include('backend.finance.journal.modalEdit')

    @include('backend.finance.journal.modalLaporanBulanan')
    @include('backend.finance.journal.modalLaporanTahunan')
    
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Jurnal Umum</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Jurnal Umum</h4>
                    <div class="button-list mb-1">
                        <a href="javascript:void(0)" onclick="buat()" class="btn btn-primary"><i class="uil-plus"></i> Buat
                            Jurnal Baru</a>
                        <a href="javascript:void(0)" onclick="downloadLaporanBulananPdf()" class="btn btn-success"><i class="uil-download-alt"></i> Download Rekap Bulanan</a>
                        <a href="javascript:void(0)" onclick="downloadLaporanTahunanPdf()" class="btn btn-success"><i class="uil-download-alt"></i> Download Rekap Tahunan</a>
                        <a href="javascript:void(0)" onclick="reload()" class="btn btn-info"><i class="uil-refresh"></i>
                            Reload</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Tanggal</th>
                                    <th>Uraian</th>
                                    <th>Kode Debit</th>
                                    <th>Item Debit</th>
                                    <th>Debit</th>
                                    <th>Kode Credit</th>
                                    <th>Item Credit</th>
                                    <th>Credit</th>
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
            ajax: "{{ route('finance.journal') }}",
            columns: [{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'uraian',
                    name: 'uraian',
                },
                {
                    data: 'code_debit',
                    name: 'code_debit',
                },
                {
                    data: 'item_debit',
                    name: 'item_debit',
                },
                {
                    data: 'debit',
                    name: 'debit',
                },
                {
                    data: 'code_credit',
                    name: 'code_credit',
                },
                {
                    data: 'item_credit',
                    name: 'item_credit',
                },
                {
                    data: 'credit',
                    name: 'credit',
                },
                // {
                //     data: 'action',
                //     name: 'action',
                // },
            ],
            order: [1, 'desc'],
            // "columnDefs": [ {
            // "targets": 0,
            // "orderable": false
            // } ]
        });

        function reload() {
            table.ajax.reload(null, false);
        }

        function buat() {
            $('#modalBuat').modal('show');
        }

        function edit(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('finance/journal/') }}" + '/' + id,
                beforeSend: () => {
                    Swal.fire({
                        title: 'Loading...',
                        html: 'Please wait while we process your request',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: (result) => {
                    Swal.close();
                    $('#edit_id').val(result.data.id);
                    $('#edit_uraian').val(result.data.uraian);
                    $('#edit_kode_debit').val(result.data.code_debit + '|' + result.data.item_debit);
                    $('#edit_kode_credit').val(result.data.code_credit + '|' + result.data.item_credit);
                    $('#edit_nominal').val(result.data.debit);
                    $('#modalEdit').modal('show');
                },
                error: function(request, status, error) {

                }
            });
        }

        $('#form-simpan').submit(function(e) {
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
                        url: "{{ route('finance.journal.simpan') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            Swal.fire({
                                title: 'Loading...',
                                html: 'Please wait while we process your request',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: (result) => {
                            if (result.success == true) {
                                Swal.close();

                                Swal.fire({
                                    title: result.message_title,
                                    text: result.message_content,
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary mt-2',
                                    },
                                    buttonsStyling: false
                                })

                                table.ajax.reload(null, false);

                                this.reset;

                                $('#modalBuat').modal('hide');
                            } else {
                                Swal.close();
                                Swal.fire({
                                    title: 'Gagal',
                                    text: result.error,
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-danger mt-2',
                                    },
                                    buttonsStyling: false
                                })
                            }
                        },
                        error: function(request, status, error) {
                            Swal.close();
                            Swal.fire({
                                title: 'Error',
                                text: error,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-danger mt-2',
                                },
                                buttonsStyling: false
                            })
                        }
                    });
                }
            });
        });

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
                        url: "{{ route('finance.journal.update') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            Swal.fire({
                                title: 'Loading...',
                                html: 'Please wait while we process your request',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: (result) => {
                            if (result.success == true) {
                                Swal.close();

                                Swal.fire({
                                    title: result.message_title,
                                    text: result.message_content,
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary mt-2',
                                    },
                                    buttonsStyling: false
                                })

                                table.ajax.reload(null, false);

                                this.reset;

                                $('#modalEdit').modal('hide');
                            } else {
                                Swal.close();
                                Swal.fire({
                                    title: 'Gagal',
                                    text: result.error,
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-danger mt-2',
                                    },
                                    buttonsStyling: false
                                })
                            }
                        },
                        error: function(request, status, error) {
                            Swal.close();
                            Swal.fire({
                                title: 'Error',
                                text: error,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-danger mt-2',
                                },
                                buttonsStyling: false
                            })
                        }
                    });
                }
            });
        });

        $('body').on('click', '.btn-delete', function() {
            let id = $(this).data('id'); // Mengambil nilai data-id
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
                        url: 'journal/' + id + '/delete', // Menyesuaikan URL endpoint
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(result) {
                            // Lakukan sesuatu dengan data respons
                            Swal.fire({
                                title: result.message_title,
                                text: result.message_content,
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary mt-2',
                                },
                                buttonsStyling: false
                            })

                            table.ajax.reload(null, false);
                        },
                        error: function(error) {
                            Swal.fire({
                                title: 'Error',
                                text: error,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-danger mt-2',
                                },
                                buttonsStyling: false
                            })
                        }
                    });
                }
            });

        });

        function downloadLaporanBulananPdf() {
            $('#modalLaporanBulanan').modal('show');
        }
        function downloadLaporanTahunanPdf() {
            $('#modalLaporanTahunan').modal('show');
        }
    </script>
@endsection
