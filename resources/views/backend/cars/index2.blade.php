@extends('layouts.backend.master')
@section('title')
    Cars
@endsection

@section('css')
    {{-- <link href="{{ asset('backend/') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/') }}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/') }}/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css"
        rel="stylesheet" type="text/css" /> --}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Mobil</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="button-list mt-1 mb-1">
                        <a href="{{ route('cars.create') }}" class="btn btn-primary btn-rounded"><i class="uil-plus"></i> Buat Baru</a>
                        <a href="javascript:void(0)" onclick="reload()" class="btn btn-primary btn-rounded"><i class="uil-refresh"></i> Reload</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="datatable">
                            <thead>
                                <tr>
                                    <th>PlatNo</th>
                                    <th>Merk</th>
                                    <th>Model</th>
                                    <th>Foto Kendaraan</th>
                                    <th>Hasil Inspeksi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cars as $key => $car)
                                <tr>
                                    <td>{{ $car->plat_nomor }}</td>
                                    <td>{{ $car->merk }}</td>
                                    <td>{{ $car->model }}</td>
                                    <td>
                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_kendaraan) }}" width="150">
                                    </td>
                                    <td class="text-center">
                                        @if (
                                            empty($car->detail_inspeksi_depan) && 
                                            empty($car->detail_inspeksi_kiri) &&
                                            empty($car->detail_inspeksi_belakang) &&
                                            empty($car->detail_inspeksi_kanan) &&
                                            empty($car->detail_inspeksi_interior)
                                        )
                                            -
                                        @else
                                            @php
                                                $total_inspeksi_depan = $car->detail_inspeksi_depan->select(
                                                    array(
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE kaca_depan WHEN "Rusak" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE kap_mesin WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE rangka_mobil WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE aki WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE radiator WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE kondisi_mesin WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE bumper_lampu WHEN "Rusak" THEN 1 ELSE NULL END)
                                                                    )/7
                                                                )*100
                                                                as total_rusak'),
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE kaca_depan WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE kap_mesin WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE rangka_mobil WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE aki WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE radiator WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE kondisi_mesin WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE bumper_lampu WHEN "Baik" THEN 1 ELSE NULL END)
                                                                    )/7
                                                                )*100
                                                                as total_baik'),
                                                    )
                                                )->first();

                                                $total_inspeksi_kiri = $car->detail_inspeksi_kiri->select(
                                                    array(
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE fender_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE kaki_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE kaki_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE fender_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END)
                                                                    )/6
                                                                )*100
                                                                as total_rusak'),
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE fender_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE kaki_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE kaki_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE fender_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END)
                                                                    )/6
                                                                )*100
                                                                as total_baik'),
                                                    )
                                                )->first();

                                                $total_inspeksi_kanan = $car->detail_inspeksi_kanan->select(
                                                    array(
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE fender_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE kaki_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE kaki_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE fender_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END)
                                                                    )/6
                                                                )*100
                                                                as total_rusak'),
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE fender_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE kaki_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE kaki_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE pintu_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE fender_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END)
                                                                    )/6
                                                                )*100
                                                                as total_baik'),
                                                    )
                                                )->first();

                                                $total_inspeksi_belakang = $car->detail_inspeksi_belakang->select(
                                                    array(
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE lampu_belakang WHEN "Rusak" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE pintu_bagasi_belakang WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE bumper_belakang WHEN "Rusak" THEN 1 ELSE NULL END)
                                                                    )/3
                                                                )*100
                                                                as total_rusak'),
                                                        DB::raw('(
                                                                    (
                                                                        COUNT(CASE lampu_belakang WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                        COUNT(CASE pintu_bagasi_belakang WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                        COUNT(CASE bumper_belakang WHEN "Baik" THEN 1 ELSE NULL END)
                                                                    )/3
                                                                )*100
                                                                as total_baik'),
                                                    )
                                                )->first();

                                                $total_all_inspeksi = ($total_inspeksi_depan['total_baik']+$total_inspeksi_kiri['total_baik']+$total_inspeksi_kanan['total_baik']+$total_inspeksi_belakang['total_baik'])/4;
                                                // $total_all_inspeksi = (
                                                //                         (($total_inspeksi_depan['total_rusak']+$total_inspeksi_depan['total_baik'])/7)+
                                                //                         (($total_inspeksi_kiri['total_rusak']+$total_inspeksi_kiri['total_baik'])/6)+
                                                //                         (($total_inspeksi_kanan['total_rusak']+$total_inspeksi_kanan['total_baik'])/6)+
                                                //                         (($total_inspeksi_belakang['total_rusak']+$total_inspeksi_belakang['total_baik'])/3)
                                                //                     )/1;
                                            @endphp
                                            {!! $total_all_inspeksi < 50 ? '<span class="badge bg-danger">'.round($total_all_inspeksi).' %</span>' : '<span class="badge bg-success">'.round($total_all_inspeksi).' %</span>' !!}
                                        @endif
                                    </td>
                                    <td>
                                        @switch($car->status)
                                            @case('Waiting')
                                                <span class="badge bg-warning">Menunggu Inspeksi</span>
                                                @break
                                            @case('Proses')
                                                <span class="badge bg-info">Proses Inspeksi</span>
                                                @break
                                            @case('Selesai')
                                                <span class="badge bg-success">Selesai</span>
                                                @break
                                            @default
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <!--<a href="#" class="btn btn-primary"><i class="bi-eye"></i> Detail Inspeksi</a>-->
                                            <a href="{{ route('cars.buat_inspeksi',['id' => $car->id]) }}" class="btn btn-warning"><i class="bi-pencil-square"></i> Mulai Inspeksi</a>
                                            <a href="#" class="btn btn-danger"><i class="bi-trash2"></i> Delete</a>
                                        </div>
                                    </td>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="{{ asset('backend/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
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
    <script src="{{ asset('backend/') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script> --}}
@endsection
