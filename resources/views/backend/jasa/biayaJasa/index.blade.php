@extends('layouts.backend.master')
@section('title')
    Biaya Jasa
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
    @include('backend.jasa.biayaJasa.modalInputHarga')
    @include('backend.jasa.biayaJasa.modalInputHargaFinance')
    @include('backend.jasa.biayaJasa.modalStatusPembayaran')

    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Biaya Jasa</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="button-list mt-1 mb-1">
                        <a href="javascript:void(0)" onclick="reload()" class="btn btn-primary btn-rounded"><i class="uil-refresh"></i> Reload</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable">
                            <thead>
                                <tr>
                                    {{-- <th>No.Ref</th> --}}
                                    <th>Tanggal Dibuat</th>
                                    <th>Data Customer</th>
                                    {{-- <th>Lokasi Inspeksi</th> --}}
                                    <th>Plat Nomor</th>
                                    <th>Merk Mobil</th>
                                    <th>Model Mobil</th>
                                    <th>Biaya Jasa</th>
                                    <th>Biaya Transport</th>
                                    <th>Total Dibayar Customer</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"
        integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('jasa.biayaJasa') }}",
            columns: [
                // {
                //     data: 'no_reference',
                //     name: 'no_reference'
                // },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'dataCustomer',
                    name: 'dataCustomer'
                },
                // {
                //     data: 'lokasi_inspeksi',
                //     name: 'lokasi_inspeksi'
                // },
                {
                    data: 'plat_nomor',
                    name: 'plat_nomor'
                },
                {
                    data: 'merk',
                    name: 'merk'
                },
                {
                    data: 'model',
                    name: 'model'
                },
                {
                    data: 'biaya_jasa',
                    name: 'biaya_jasa'
                },
                {
                    data: 'biaya_transport',
                    name: 'biaya_transport'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'pembayaran',
                    name: 'pembayaran'
                },
                {
                    data: 'status_pembayaran',
                    name: 'status_pembayaran'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [0, 'desc'],
            // "columnDefs": [ {
            // "targets": 0,
            // "orderable": false
            // } ]
        });

        function reload(){
            table.ajax.reload(null, false);
        }

        /* Fungsi formatRupiah */
		// function formatRupiah(angka, prefix){
		// 	var number_string = angka.replace(/[^,\d]/g, '').toString(),
		// 	split   		= number_string.split(','),
		// 	sisa     		= split[0].length % 3,
		// 	rupiah     		= split[0].substr(0, sisa),
		// 	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
		// 	// tambahkan titik jika yang di input sudah menjadi angka ribuan
		// 	if(ribuan){
		// 		separator = sisa ? '.' : '';
		// 		rupiah += separator + ribuan.join('.');
		// 	}
 
		// 	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		// 	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		// }

        function inputHarga(id)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('jasa/biaya_jasa/') }}"+'/'+id,
                beforeSend: () => {

                },
                success: (result) => {
                    if (result.success != false) {
                        $('#modalIdNew').val(result.data.id);
                        document.getElementById('modalNoReference').innerHTML = result.data.no_reference;
                        document.getElementById('modalPlatNomor').innerHTML = result.data.plat_nomor;
                        document.getElementById('modalWarnaMobil').innerHTML = result.data.warna;
                        document.getElementById('modalMerk').innerHTML = result.data.merk;
                        document.getElementById('modalModel').innerHTML = result.data.model;
                        document.getElementById('modalNoRangka').innerHTML = result.data.no_rangka;
                        document.getElementById('modalTransmisi').innerHTML = result.data.transmisi;
                        document.getElementById('modalStatus').innerHTML = result.data.status;
                        $('#modalPrice').val(result.data.price);
                        $('#modalInputHarga').modal('show');
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

        function inputPembayaranFinance(id)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('jasa/biaya_jasa/') }}"+'/'+id,
                beforeSend: () => {

                },
                success: (result) => {
                    if (result.success != false) {
                        $('#modalIdNewFinance').val(result.data.id);
                        document.getElementById('modalNoReferenceFinance').innerHTML = result.data.no_reference;
                        document.getElementById('modalPlatNomorFinance').innerHTML = result.data.plat_nomor;
                        document.getElementById('modalWarnaMobilFinance').innerHTML = result.data.warna;
                        document.getElementById('modalMerkFinance').innerHTML = result.data.merk;
                        document.getElementById('modalModelFinance').innerHTML = result.data.model;
                        document.getElementById('modalNoRangkaFinance').innerHTML = result.data.no_rangka;
                        document.getElementById('modalTransmisiFinance').innerHTML = result.data.transmisi;
                        document.getElementById('modalStatusFinance').innerHTML = result.data.status;
                        document.getElementById('modalCustomerFinance').innerHTML = result.data.customer;
                        document.getElementById('modalLokasiFinance').innerHTML = result.data.lokasi;
                        // $('#modalPrice').val(result.data.price);
                        $('#modalInputHargaFinance').modal('show');
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

        function inputStatusPembayaran(id)
        {
            $.ajax({
                type: 'GET',
                url: "{{ url('jasa/biaya_jasa/') }}"+'/'+id,
                beforeSend: () => {

                },
                success: (result) => {
                    if (result.success != false) {
                        $('#modalIdPembayaran').val(result.data.id);
                        document.getElementById('modalNoReferencePembayaran').innerHTML = result.data.no_reference;
                        document.getElementById('modalPlatNomorPembayaran').innerHTML = result.data.plat_nomor;
                        document.getElementById('modalWarnaMobilPembayaran').innerHTML = result.data.warna;
                        document.getElementById('modalMerkPembayaran').innerHTML = result.data.merk;
                        document.getElementById('modalModelPembayaran').innerHTML = result.data.model;
                        document.getElementById('modalNoRangkaPembayaran').innerHTML = result.data.no_rangka;
                        document.getElementById('modalTransmisiPembayaran').innerHTML = result.data.transmisi;
                        document.getElementById('modalMetodeStatusPembayaran').innerHTML = result.data.status;
                        document.getElementById('modalCustomerPembayaran').innerHTML = result.data.customer;
                        document.getElementById('modalLokasiInspeksiPembayaran').innerHTML = result.data.lokasi;
                        
                        const officialRupiahBiayaJasa = new Intl.NumberFormat('id-ID', {
                                                                    style: 'currency',
                                                                    currency: 'IDR',
                                                                    minimumFractionDigits: 0, // Removes the ,00 decimal if not needed
                                                                    }).format(result.data.biaya_jasa);
                        document.getElementById('modalBiayaJasaPembayaran').innerHTML = officialRupiahBiayaJasa;

                        const officialRupiahBiayaTransport = new Intl.NumberFormat('id-ID', {
                                                                    style: 'currency',
                                                                    currency: 'IDR',
                                                                    minimumFractionDigits: 0, // Removes the ,00 decimal if not needed
                                                                    }).format(result.data.biaya_transport);
                        document.getElementById('modalBiayaTransportPembayaran').innerHTML = officialRupiahBiayaTransport;

                        const officialRupiahBiayaTotal = new Intl.NumberFormat('id-ID', {
                                                                    style: 'currency',
                                                                    currency: 'IDR',
                                                                    minimumFractionDigits: 0, // Removes the ,00 decimal if not needed
                                                                    }).format(parseFloat(result.data.biaya_jasa)+parseFloat(result.data.biaya_transport));
                        document.getElementById('modalBiayaCustomerPembayaran').innerHTML = officialRupiahBiayaTotal;
                        // $('#modalPrice').val(result.data.price);
                        $('#modalStatusPembayaran').modal('show');
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

        // $('#provinsi').on('change', function() {
        //     axios.post('{{ route('get_regencies') }}', {
        //             id: $(this).val()
        //         })
        //         .then(function(response) {
        //             $('#kabkota').empty();

        //             $.each(response.data, function(id, name) {
        //                 // alert(nama);
        //                 $('#kabkota').append(new Option(name, name));
        //             })
        //         });
        // });

        $(document).ready(function(){
            axios.post('{{ route('get_regencies') }}', {
                id: 35
            })
            .then(function(response) {
                $('#kabkota').empty();

                $.each(response.data, function(id, name) {
                    // alert(nama);
                    $('#kabkota').append(new Option(name, name));
                })
            });
        });

        $('#submit-modal-price').submit(function(e) {
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
                        url: "{{ route('jasa.biayaJasa.simpan') }}",
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
                                $('#modalInputHarga').modal('hide');
                                this.reset;
                                table.ajax.reload(null, false);
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
                }
            })
        });

        $('#submit-modal-price-finance').submit(function(e) {
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
                        url: "{{ route('jasa.biayaJasa.pembayaranFinance.simpan') }}",
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
                                $('#modalInputHargaFinance').modal('hide');
                                this.reset;
                                table.ajax.reload(null, false);
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
                }
            })
        });

        $('#submit-modal-pembayaran').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('jasa.biayaJasa.pembayaran.simpan') }}",
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
                        $('#modalStatusPembayaran').modal('hide');
                        this.reset();
                        table.ajax.reload(null, false);
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