@extends('layouts.backend.master')
@section('title')
    Mobil
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Mobil</h4>
            </div>
            <div class="button-list mt-1 mb-1">
                <a href="{{ route('cars.create') }}" class="btn btn-primary btn-rounded"><i class="uil-plus"></i> Buat Baru</a>
                <a href="javascript:void(0)" onclick="reload()" class="btn btn-primary btn-rounded"><i
                        class="uil-refresh"></i> Reload</a>
            </div>
            <div class="row">
                @foreach ($cars as $car)
                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                @switch($car->status)
                                    @case('Waiting')
                                        <div class="badge bg-warning float-end">Menunggu Inspeksi</div>
                                    @break

                                    @case('Proses')
                                        <div class="badge bg-warning float-end">Proses Inspeksi</div>
                                    @break

                                    @case('Selesai')
                                        <div class="badge bg-success float-end">Selesai</div>
                                    @break

                                    @default
                                @endswitch
                                <p class="text-uppercase fs-12 mb-2">Plat Nomor: {{ $car->plat_nomor }}</p>
                                <h5><a href="#" class="text-dark">{{ $car->merk.' '.$car->model.' - '.$car->warna }}</a></h5>
                                <p class="text-muted mb-4"><img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_kendaraan) }}" width="100%"></p>
                            </div>
                            <div class="card-body border-top">
                                <div class="row align-items-center">
                                    <div class="col-sm-auto">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#" class="btn btn-sm btn-primary d-inline-block">
                                                    <i class="bi-eye"></i> Detail
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="{{ route('cars.edit',['id' => $car->id]) }}" class="btn btn-sm btn-warning d-inline-block">
                                                    <i class="bi-pencil-square"></i> Mulai Inspeksi
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" class="btn btn-sm btn-danger d-inline-block">
                                                    <i class="bi-trash2"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
