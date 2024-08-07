@extends('layouts.backend.master')
@section('title')
    Cars
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
    @include('backend.cars.modalEmail')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Mobil</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="button-list mt-1 mb-1">
                        @can('Mobil Create')
                        <a href="{{ route('cars.create') }}" class="btn btn-primary btn-rounded"><i class="uil-plus"></i> Buat Baru</a>
                        @endcan
                        <a href="javascript:void(0)" onclick="reload()" class="btn btn-primary btn-rounded"><i class="uil-refresh"></i> Reload</a>
                        {{-- <a href="javascript:void(0)" class="btn btn-primary btn-rounded"><i class="uil-plus"></i> Download Laporan Inspeksi</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>No.Ref</th>
                                    <th>Plat Nomor</th>
                                    <th>Merk</th>
                                    <th>Foto Kendaraan</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
            ajax: "{{ route('cars') }}",
            columns: [
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'no_reference',
                    name: 'no_reference'
                },
                {
                    data: 'plat_nomor',
                    name: 'plat_nomor'
                },
                {
                    data: 'merk',
                    name: 'merk'
                },
                {
                    data: 'foto_kendaraan',
                    name: 'foto_kendaraan'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ],
            order: [6, 'desc'],
            "columnDefs": [ {
            "targets": 0,
            "orderable": false
            } ]
        });

        function reload(){
            table.ajax.reload();
        }

        function sendEmailInspeksi(id)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('cars/') }}"+'/'+id+'/'+'modalSendMail',
                success: (result) => {
                    if (result.success != false) {
                        $('#modalId').val(result.data.id);
                        $('#modalEmail').modal('show');
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

        function hapus(id)
        {
            Swal.fire({
                title: "Apakah Anda yakin hapus ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('cars/') }}"+'/'+id+'/'+'delete',
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
                                icon: 'success',
                                title: result.message_title,
                                text: result.message_content,
                                showConfirmButton: true,
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
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
            });

        }

        $('#submit-modal-email').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.sendMailInspeksi') }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    Swal.fire({
                        icon: "info",
                        title: "Email Sedang Diproses, Silahkan Tunggu",
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
                        // setTimeout(function(){
                        //     location.reload();
                        // }, 2000);
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: true,
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
        });
    </script>
@endsection
