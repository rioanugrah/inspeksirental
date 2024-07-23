@extends('layouts.backend.master')

@section('title')
    Mulai Inspeksi
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard_theme_arrows.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard_theme_circles.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard_theme_dots.min.css') }}" type="text/css" />
@endsection

@section('content')
    <div class="row" style="margin-top: 3%">
        <div class="col">
            <div class="card">
                <div class="card-body p-0">
                    <h6 class="card-title border-bottom p-3 mb-0 header-title">DETAIL IDENTITAS KENDARAAN</h6>
                    <div class="row py-1">
                        <div class="col-xl-6 col-sm-6">
                            <input type="image" src="{{ asset('backend/assets/images/mobil_images/mb.webp') }}"
                                width="100%" height="85%" style="margin-left: 5%">
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="row" style="margin-left: 2.5%; margin-right: 2.5%;">
                                <div class="d-flex p-1">
                                    <i data-feather="check-square" class="align-self-center icon-dual icon-md me-1"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mt-0 mb-0">Plat Nomor</h4>
                                        <span class="text-muted">{{ $car->plat_nomor }}</span>
                                    </div>
                                </div>
                                <div class="d-flex p-1">
                                    <i data-feather="check-square" class="align-self-center icon-dual icon-md me-1"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mt-0 mb-0">Model</h4>
                                        <span class="text-muted">{{ $car->model }}</span>
                                    </div>
                                </div>
                                <div class="d-flex p-1">
                                    <i data-feather="check-square" class="align-self-center icon-dual icon-md me-1"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mt-0 mb-0">Merk</h4>
                                        <span class="text-muted">{{ $car->merk }}</span>
                                    </div>
                                </div>
                                <div class="d-flex p-1">
                                    <i data-feather="check-square" class="align-self-center icon-dual icon-md me-1"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mt-0 mb-0">Warna</h4>
                                        <span class="text-muted">{{ $car->warna }}</span>
                                    </div>
                                </div>
                                <div class="d-flex p-1">
                                    <i data-feather="check-square" class="align-self-center icon-dual icon-md me-1"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mt-0 mb-0">Tahun</h4>
                                        <span class="text-muted">{{ $car->tahun }}</span>
                                    </div>
                                </div>
                                <div class="d-flex p-1">
                                    <i data-feather="check-square" class="align-self-center icon-dual icon-md me-1"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mt-0 mb-0">Nomor Rangka</h4>
                                        <span class="text-muted">{{ $car->no_rangka }}</span>
                                    </div>
                                </div>
                                <div class="d-flex p-1">
                                    <i data-feather="check-square" class="align-self-center icon-dual icon-md me-1"></i>
                                    <div class="flex-grow-1">
                                        <h4 class="mt-0 mb-0">Transmisi</h4>
                                        <span class="text-muted">{{ $car->transmisi }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--untuk form inspeksi-->
    <div class="card">
        <div class="card-body p-0">
            <h6 class="card-title border-bottom p-3 mb-0 header-title text-center">FORM INSPEKSI</h6>
        </div>
        
            <div class="card">
                <div class="card-body">
                <div id="smartwizard-default">
                    <ul>
                        <li>
                            <a href="#sw-default-step-1">
                                Bagian Depan {!! $car->detail_inspeksi_depan ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>' : null !!} 
                                <small class="d-block fw-normal">Inspeksi</small>
                                <small>Baik : {!! number_format($total_inspeksi_depan['total_baik'],0,'.',',').'%' !!}</small>
                                <small>Tidak Baik : {!! number_format($total_inspeksi_depan['total_rusak'],0,'.',',').'%' !!}</small>
                            </a>
                        </li>
                        <li>
                            <a href="#sw-default-step-2">Bagian Kiri {!! $car->detail_inspeksi_kiri ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>' : null !!} 
                                <small class="d-block fw-normal">Inspeksi</small>
                                <small>Baik : {!! number_format($total_inspeksi_kiri['total_baik'],0,'.',',').'%' !!}</small>
                                <small>Tidak Baik : {!! number_format($total_inspeksi_kiri['total_rusak'],0,'.',',').'%' !!}</small>
                            </a>
                        </li>
                        <li>
                            <a href="#sw-default-step-3">Bagian Belakang {!! $car->detail_inspeksi_belakang ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>' : null !!} 
                                <small class="d-block fw-normal">Inspeksi</small>
                                <small>Baik : {!! number_format($total_inspeksi_belakang['total_baik'],0,'.',',').'%' !!}</small>
                                <small>Tidak Baik : {!! number_format($total_inspeksi_belakang['total_rusak'],0,'.',',').'%' !!}</small>
                            </a>
                        </li>
                        <li>
                            <a href="#sw-default-step-4">Bagian Kanan {!! $car->detail_inspeksi_kanan ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>' : null !!} 
                                <small class="d-block fw-normal">Inspeksi</small>
                                <small>Baik : {!! number_format($total_inspeksi_kanan['total_baik'],0,'.',',').'%' !!}</small>
                                <small>Tidak Baik : {!! number_format($total_inspeksi_kanan['total_rusak'],0,'.',',').'%' !!}</small>
                            </a>
                        </li>
                        <li>
                            <a href="#sw-default-step-5">
                                Bagian Interior {!! $car->detail_inspeksi_interior ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>' : null !!} 
                                <small class="d-block fw-normal">Inspeksi</small>
                            </a>
                        </li>
                    </ul>
                    <div class="p-2">
                        <div id="sw-default-step-1">
                            @if ($car->detail_inspeksi_depan)
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kaca Depan</label>
                                            @switch($car->detail_inspeksi_depan->kaca_depan)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kaca_depan) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kap Mesin</label>
                                            @switch($car->detail_inspeksi_depan->kap_mesin)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kap_mesin) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Rangka Mobil</label>
                                            @switch($car->detail_inspeksi_depan->rangka_mobil)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_rangka_mobil) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>AKI / Baterai</label>
                                            @switch($car->detail_inspeksi_depan->aki)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_aki) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Radiator</label>
                                            @switch($car->detail_inspeksi_depan->radiator)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_radiator) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kondisi Mesin</label>
                                            @switch($car->detail_inspeksi_depan->kondisi_mesin)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kondisi_mesin) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Bumper dan Lampu</label>
                                            @switch($car->detail_inspeksi_depan->bumper_lampu)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_bumper_lampu) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <form method="post" id="upload-simpan-bagian-depan" enctype="multipart/form-data">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kaca Depan</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="kaca_depan" class="kaca_depan" value="Baik" id="kacadepan1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="kaca_depan" class="kaca_depan" value="Rusak" id="kacadepan2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_kaca_depan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kap Mesin</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="kap_mesin" value="Baik" id="kapmesin1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="kap_mesin" value="Rusak" id="kapmesin2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_kap_mesin"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Rangka Mobil</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="rangka_mobil" value="Baik" id="rangkamobil1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="rangka_mobil" value="Rusak" id="rangkamobil2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_rangka_mobil"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>AKI / Baterai</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="aki" value="Baik" id="aki1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="aki" value="Rusak" id="aki2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_aki"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Radiator</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="radiator" value="Baik" id="radiator1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="radiator" value="Rusak" id="radiator2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_radiator"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kondisi Mesin</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="kondisi_mesin" value="Baik" id="kondisimesin1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="kondisi_mesin" value="Rusak" id="kondisimesin2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_kondisi_mesin"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Bumper dan Lampu</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="bumper_lampu" value="Baik" id="bumperlampu1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="bumper_lampu" value="Rusak" id="bumperlampu2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_bumper_lampu"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                            </form>
                            @endif
                        </div>
                        <div id="sw-default-step-2">
                            @if ($car->detail_inspeksi_kiri)
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Fender Depan Kiri</label>
                                                @switch($car->detail_inspeksi_kiri->fender_depan_kiri)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_depan_kiri) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Kaki Depan Kiri</label>
                                                @switch($car->detail_inspeksi_kiri->kaki_depan_kiri)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_depan_kiri) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Kaki Belakang Kiri</label>
                                                @switch($car->detail_inspeksi_kiri->kaki_belakang_kiri)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_belakang_kiri) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Pintu Depan Kiri</label>
                                                @switch($car->detail_inspeksi_kiri->pintu_depan_kiri)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_depan_kiri) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Pintu Belakang Kiri</label>
                                                @switch($car->detail_inspeksi_kiri->pintu_belakang_kiri)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_belakang_kiri) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Fender Belakang Kiri</label>
                                                @switch($car->detail_inspeksi_kiri->fender_belakang_kiri)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_belakang_kiri) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <form method="post" id="upload-simpan-bagian-kiri" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Fender Depan Kiri</label>
                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="fender_depan_kiri" value="Baik"
                                                            id="fenderdepankiri1" autocomplete="off"><i
                                                            data-feather="thumbs-up"></i> Baik
                                                    </label>
                                                    <label class="btn btn-white">
                                                        <input type="radio" name="fender_depan_kiri" value="Rusak"
                                                            id="fenderdepankiri2" autocomplete="off"><i
                                                            data-feather="thumbs-down"></i> Tidak/Rusak
                                                    </label>
                                                </div>
                                                <div id="view_fender_depan_kiri"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Kaki Depan Kiri</label>
                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="kaki_depan_kiri" value="Baik"
                                                            id="kakidepankiri1" autocomplete="off"><i
                                                            data-feather="thumbs-up"></i> Baik
                                                    </label>
                                                    <label class="btn btn-white">
                                                        <input type="radio" name="kaki_depan_kiri" value="Rusak"
                                                            id="kakidepankiri2" autocomplete="off"><i
                                                            data-feather="thumbs-down"></i> Tidak/Rusak
                                                    </label>
                                                </div>
                                                <div id="view_kaki_depan_kiri"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Kaki Belakang Kiri</label>
                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="kaki_belakang_kiri" value="Baik"
                                                            id="kakibelakangkiri1" autocomplete="off"><i
                                                            data-feather="thumbs-up"></i> Baik
                                                    </label>
                                                    <label class="btn btn-white">
                                                        <input type="radio" name="kaki_belakang_kiri" value="Rusak"
                                                            id="kakibelakangkiri2" autocomplete="off"><i
                                                            data-feather="thumbs-down"></i> Tidak/Rusak
                                                    </label>
                                                </div>
                                                <div id="view_kaki_belakang_kiri"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Pintu Depan Kiri</label>
                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="pintu_depan_kiri" value="Baik"
                                                            id="pintudepankiri1" autocomplete="off"><i
                                                            data-feather="thumbs-up"></i> Baik
                                                    </label>
                                                    <label class="btn btn-white">
                                                        <input type="radio" name="pintu_depan_kiri" value="Rusak"
                                                            id="pintudepankiri2" autocomplete="off"><i
                                                            data-feather="thumbs-down"></i> Tidak/Rusak
                                                    </label>
                                                </div>
                                                <div id="view_pintu_depan_kiri"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Pintu Belakang Kiri</label>
                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="pintu_belakang_kiri" value="Baik"
                                                            id="pintubelakangkiri1" autocomplete="off"><i
                                                            data-feather="thumbs-up"></i> Baik
                                                    </label>
                                                    <label class="btn btn-white">
                                                        <input type="radio" name="pintu_belakang_kiri" value="Rusak"
                                                            id="pintubelakangkiri2" autocomplete="off"><i
                                                            data-feather="thumbs-down"></i> Tidak/Rusak
                                                    </label>
                                                </div>
                                                <div id="view_pintu_belakang_kiri"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Fender Belakang Kiri</label>
                                                <div class="input-group-btn" data-toggle="buttons">
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="fender_belakang_kiri" value="Baik"
                                                            id="fenderbelakangkiri1" autocomplete="off"><i
                                                            data-feather="thumbs-up"></i> Baik
                                                    </label>
                                                    <label class="btn btn-white">
                                                        <input type="radio" name="fender_belakang_kiri" value="Rusak"
                                                            id="fenderbelakangkiri2" autocomplete="off"><i
                                                            data-feather="thumbs-down"></i> Tidak/Rusak
                                                    </label>
                                                </div>
                                                <div id="view_fender_belakang_kiri"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                            @endif
                        </div>
                        <div id="sw-default-step-3">
                            @if ($car->detail_inspeksi_belakang)
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Lampu Belakang Kanan Kiri</label>
                                                @switch($car->detail_inspeksi_belakang->lampu_belakang)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_lampu_belakang) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Pintu Bagasi Belakang</label>
                                                @switch($car->detail_inspeksi_belakang->pintu_bagasi_belakang)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_pintu_bagasi_belakang) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Bumper Belakang</label>
                                                @switch($car->detail_inspeksi_belakang->bumper_belakang)
                                                    @case('Baik')
                                                        <p class="text-success">Baik</p>
                                                        @break
                                                    @case('Rusak')
                                                        <p class="text-danger">Tidak Baik / Rusak</p>
                                                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_bumper_belakang) }}" width="100%">
                                                        @break
                                                    @default
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <form method="post" id="upload-simpan-bagian-belakang" enctype="multipart/form-data">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Lampu Belakang Kanan Kiri</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="lampu_belakang" value="Baik" id="lampubelakang1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="lampu_belakang" value="Rusak" id="lampubelakang2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_lampu_belakang_kanan_kiri"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Pintu Bagasi</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="pintu_bagasi_belakang" value="Baik" id="pintubagasibelakang1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="pintu_bagasi_belakang" value="Rusak" id="pintubagasibelakang2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_pintu_bagasi_belakang"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Bumper Belakang</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="bumper_belakang" value="Baik" id="bumperbelakang1"
                                                        autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="bumper_belakang" value="Rusak" id="bumperbelakang2"
                                                        autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_bumper_belakang"></div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                            </form>
                            @endif
                        </div>
                        <div id="sw-default-step-4">
                            @if ($car->detail_inspeksi_kanan)
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Fender Depan Kanan</label>
                                            @switch($car->detail_inspeksi_kanan->fender_depan_kanan)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_depan_kanan) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kaki Depan Kanan</label>
                                            @switch($car->detail_inspeksi_kanan->kaki_depan_kanan)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_depan_kanan) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kaki Belakang Kanan</label>
                                            @switch($car->detail_inspeksi_kanan->kaki_belakang_kanan)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_belakang_kanan) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Pintu Depan Kanan</label>
                                            @switch($car->detail_inspeksi_kanan->pintu_depan_kanan)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_depan_kanan) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Pintu Belakang Kanan</label>
                                            @switch($car->detail_inspeksi_kanan->pintu_belakang_kanan)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_belakang_kanan) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Fender Belakang Kanan</label>
                                            @switch($car->detail_inspeksi_kanan->fender_belakang_kanan)
                                                @case('Baik')
                                                    <p class="text-success">Baik</p>
                                                    @break
                                                @case('Rusak')
                                                    <p class="text-danger">Tidak Baik / Rusak</p>
                                                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_belakang_kanan) }}" width="100%">
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <form method="post" id="upload-simpan-bagian-kanan" enctype="multipart/form-data">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Fender Depan Kanan</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="fender_depan_kanan" value="Baik"
                                                        id="fenderdepankanan1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="fender_depan_kanan" value="Rusak"
                                                        id="fenderdepankanan2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_fender_depan_kanan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kaki Depan Kanan</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="kaki_depan_kanan" value="Baik"
                                                        id="kakidepankanan1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="kaki_depan_kanan" value="Rusak"
                                                        id="kakidepankanan2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_kaki_depan_kanan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Kaki Belakang Kanan</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="kaki_belakang_kanan" value="Baik"
                                                        id="kakibelakangkanan1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="kaki_belakang_kanan" value="Rusak"
                                                        id="kakibelakangkanan2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_kaki_belakang_kanan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Pintu Depan Kanan</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="pintu_depan_kanan" value="Baik"
                                                        id="pintudepankanan1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="pintu_depan_kanan" value="Rusak"
                                                        id="pintudepankanan2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_pintu_depan_kanan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Pintu Belakang Kanan</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="pintu_belakang_kanan" value="Baik"
                                                        id="pintubelakangkanan1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="pintu_belakang_kanan" value="Rusak"
                                                        id="pintubelakangkanan2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_pintu_belakang_kanan"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Fender Belakang Kanan</label>
                                            <div class="input-group-btn" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="fender_belakang_kanan" value="Baik"
                                                        id="fenderbelakangkanan1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="fender_belakang_kanan" value="Rusak"
                                                        id="fenderbelakangkanan2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
                                                </label>
                                            </div>
                                            <div id="view_fender_belakang_kanan"></div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                            </form>
                            @endif
                        </div>
                        <div id="sw-default-step-5">
                            @if ($car->detail_inspeksi_interior)
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Speedometer</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_speedometer !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_speedometer) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Setir</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_setir !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_setir) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Dasboard</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_dasboard !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_dasboard) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Plafon</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_plafon !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_plafon) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan AC</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_ac !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_ac) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Audio</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_audio !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_audio) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Jok</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_jok !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_jok) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Electric Spion</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_electric_spion !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_electric_spion) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Power Window</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_power_window !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_power_window) }}" width="100%">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan Lain - Lain</label>
                                                <p>{!! $car->detail_inspeksi_interior->keterangan_lain_lain !!}</p>
                                                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_lain_lain) }}" width="100%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <form method="post" id="upload-simpan-bagian-interior" enctype="multipart/form-data">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Speedometer</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_speedometer" class="form-control">
                                                <textarea id="" name="keterangan_speedometer" rows="2" cols="30" class="form-control" placeholder="Keterangan Spidometer"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Setir</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_setir" class="form-control">
                                                <textarea id="" name="keterangan_setir" rows="2" cols="30" class="form-control" placeholder="Keterangan Setir"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Dashboard</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_dasboard" class="form-control">
                                                <textarea id="" name="keterangan_dasboard" rows="2" cols="30" class="form-control" placeholder="Keterangan Dashboard"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Plafon</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_plafon" class="form-control">
                                                <textarea id="" name="keterangan_plafon" rows="2" cols="30" class="form-control" placeholder="Keterangan Plafon"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>AC</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_ac" class="form-control">
                                                <textarea id="" name="keterangan_ac" rows="2" cols="30" class="form-control" placeholder="Keterangan AC"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Audio</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_audio" class="form-control">
                                                <textarea id="" name="keterangan_audio" rows="2" cols="30" class="form-control" placeholder="Keterangan Audio"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Jok</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_jok" class="form-control">
                                                <textarea id="" name="keterangan_jok" rows="2" cols="30" class="form-control" placeholder="Keterangan Jok"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Electric Spion</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_electric_spion" class="form-control">
                                                <textarea id="" name="keterangan_electric_spion" rows="2" cols="30" class="form-control" placeholder="Keterangan Electric Spion"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Power Window</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_power_window" class="form-control">
                                                <textarea id="" name="keterangan_power_window" rows="2" cols="30" class="form-control" placeholder="Keterangan Power Window"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Lain - Lain</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_lain_lain" class="form-control">
                                                <textarea id="" name="keterangan_lain_lain" rows="2" cols="30" class="form-control" placeholder="Keterangan Lain - Lain"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <span style="font-size: 12pt" class="badge bg-warning text-dark mb-2">Pengecekan Bagian Depan</span>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Kaca Depan</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kaca_depan" class="kaca_depan" value="Baik" id="kacadepan1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kaca_depan" class="kaca_depan" value="Rusak" id="kacadepan2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kaca_depan"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Kap Mesin</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kap_mesin" value="Baik" id="kapmesin1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kap_mesin" value="Rusak" id="kapmesin2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kap_mesin"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Rangka Mobil</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="rangka_mobil" value="Baik" id="rangkamobil1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="rangka_mobil" value="Rusak" id="rangkamobil2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_rangka_mobil"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>AKI / Baterai</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="aki" value="Baik" id="aki1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="aki" value="Rusak" id="aki2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_aki"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Radiator</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="radiator" value="Baik" id="radiator1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="radiator" value="Rusak" id="radiator2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_radiator"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Kondisi Mesin</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kondisi_mesin" value="Baik" id="kondisimesin1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kondisi_mesin" value="Rusak" id="kondisimesin2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kondisi_mesin"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Bumper dan Lampu</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="bumper_lampu" value="Baik" id="bumperlampu1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="bumper_lampu" value="Rusak" id="bumperlampu2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_bumper_lampu"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <span style="font-size: 12pt" class="badge bg-warning text-dark mb-2">Pengecekan Bagian Kiri</span>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Fender Depan Kiri</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="fender_depan_kiri" value="Baik"
                                                    id="fenderdepankiri1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="fender_depan_kiri" value="Rusak"
                                                    id="fenderdepankiri2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_fender_depan_kiri"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Kaki Depan Kiri</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kaki_depan_kiri" value="Baik"
                                                    id="kakidepankiri1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kaki_depan_kiri" value="Rusak"
                                                    id="kakidepankiri2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kaki_depan_kiri"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Kaki Belakang Kiri</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kaki_belakang_kiri" value="Baik"
                                                    id="kakibelakangkiri1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kaki_belakang_kiri" value="Rusak"
                                                    id="kakibelakangkiri2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kaki_belakang_kiri"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Pintu Depan Kiri</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="pintu_depan_kiri" value="Baik"
                                                    id="pintudepankiri1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="pintu_depan_kiri" value="Rusak"
                                                    id="pintudepankiri2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_pintu_depan_kiri"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Pintu Belakang Kiri</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="pintu_belakang_kiri" value="Baik"
                                                    id="pintubelakangkiri1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="pintu_belakang_kiri" value="Rusak"
                                                    id="pintubelakangkiri2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_pintu_belakang_kiri"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Fender Belakang Kiri</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="fender_belakang_kiri" value="Baik"
                                                    id="fenderbelakangkiri1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="fender_belakang_kiri" value="Rusak"
                                                    id="fenderbelakangkiri2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_fender_belakang_kiri"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <span style="font-size: 12pt" class="badge bg-warning text-dark mb-2">Pengecekan Bagian Belakang</span>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Lampu Belakang Kanan Kiri</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="lampu_belakang" value="Baik" id="lampubelakang1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="lampu_belakang" value="Rusak" id="lampubelakang2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_lampu_belakang_kanan_kiri"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Pintu Bagasi</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="pintu_bagasi_belakang" value="Baik" id="pintubagasibelakang1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="pintu_bagasi_belakang" value="Rusak" id="pintubagasibelakang2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_pintu_bagasi_belakang"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Bumper Belakang</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="bumper_belakang" value="Baik" id="bumperbelakang1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="bumper_belakang" value="Rusak" id="bumperbelakang2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_bumper_belakang"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <span style="font-size: 12pt" class="badge bg-warning text-dark mb-2">Pengecekan Bagian Kanan</span>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Fender Depan Kanan</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="fender_depan_kanan" value="Baik"
                                                    id="fenderdepankanan1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="fender_depan_kanan" value="Rusak"
                                                    id="fenderdepankanan2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_fender_depan_kanan"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Kaki Depan Kanan</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kaki_depan_kanan" value="Baik"
                                                    id="kakidepankanan1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kaki_depan_kanan" value="Rusak"
                                                    id="kakidepankanan2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kaki_depan_kanan"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Kaki Belakang Kanan</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kaki_belakang_kanan" value="Baik"
                                                    id="kakibelakangkanan1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kaki_belakang_kanan" value="Rusak"
                                                    id="kakibelakangkanan2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kaki_belakang_kanan"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Pintu Depan Kanan</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="pintu_depan_kanan" value="Baik"
                                                    id="pintudepankanan1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="pintu_depan_kanan" value="Rusak"
                                                    id="pintudepankanan2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_pintu_depan_kanan"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Pintu Belakang Kanan</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="pintu_belakang_kanan" value="Baik"
                                                    id="pintubelakangkanan1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="pintu_belakang_kanan" value="Rusak"
                                                    id="pintubelakangkanan2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_pintu_belakang_kanan"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Fender Belakang Kanan</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="fender_belakang_kanan" value="Baik"
                                                    id="fenderbelakangkanan1" autocomplete="off"><i
                                                    data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="fender_belakang_kanan" value="Rusak"
                                                    id="fenderbelakangkanan2" autocomplete="off"><i
                                                    data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_fender_belakang_kanan"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span style="font-size: 12pt" class="badge bg-warning text-dark mb-2">Interior</span>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Spidometer</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_speedometer" class="form-control">
                                            <textarea id="" name="keterangan_speedometer" rows="2" cols="30" class="form-control" placeholder="Keterangan Spidometer"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Setir</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_setir" class="form-control">
                                            <textarea id="" name="keterangan_setir" rows="2" cols="30" class="form-control" placeholder="Keterangan Setir"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Dashboard</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_dasboard" class="form-control">
                                            <textarea id="" name="keterangan_dasboard" rows="2" cols="30" class="form-control" placeholder="Keterangan Dashboard"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Plafon</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_plafon" class="form-control">
                                            <textarea id="" name="keterangan_plafon" rows="2" cols="30" class="form-control" placeholder="Keterangan Plafon"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>AC</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_ac" class="form-control">
                                            <textarea id="" name="keterangan_ac" rows="2" cols="30" class="form-control" placeholder="Keterangan AC"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Audio</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_audio" class="form-control">
                                            <textarea id="" name="keterangan_audio" rows="2" cols="30" class="form-control" placeholder="Keterangan Audio"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Jok</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_jok" class="form-control">
                                            <textarea id="" name="keterangan_jok" rows="2" cols="30" class="form-control" placeholder="Keterangan Jok"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Electric Spion</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_electric_spion" class="form-control">
                                            <textarea id="" name="keterangan_electric_spion" rows="2" cols="30" class="form-control" placeholder="Keterangan Electric Spion"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Power Window</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_power_window" class="form-control">
                                            <textarea id="" name="keterangan_power_window" rows="2" cols="30" class="form-control" placeholder="Keterangan Power Window"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label>Lain - Lain</label>
                                        <div class="input-group-btn">
                                            <input type="file" name="foto_lain_lain" class="form-control">
                                            <textarea id="" name="keterangan_lain_lain" rows="2" cols="30" class="form-control" placeholder="Keterangan Lain - Lain"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div> -->
                </div>
                {{-- <div class="card-footer">
                    <button type="button" onclick="window.location.href='{{ route('cars') }}'" class="btn btn-secondary">Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div> --}}
            </div>
        </form>
    </div>
    <!--End Form-->
@endsection

@section('script')
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/smartwizard/js/jquery.smartWizard.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/form-wizard.init.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[type=radio][name=kaca_depan]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kaca_depan').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kaca Depan</label>'+
                                                                            '<input type="file" name="foto_kaca_depan" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kaca_depan').innerHTML = null;
            }
        });

        $('input[type=radio][name=kap_mesin]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kap_mesin').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kap Mesin</label>'+
                                                                            '<input type="file" name="foto_kap_mesin" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kap_mesin').innerHTML = null;
            }
        });

        $('input[type=radio][name=rangka_mobil]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_rangka_mobil').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Rangka Mobil</label>'+
                                                                            '<input type="file" name="foto_rangka_mobil" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_rangka_mobil').innerHTML = null;
            }
        });

        $('input[type=radio][name=aki]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_aki').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Aki Mobil</label>'+
                                                                            '<input type="file" name="foto_aki" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_aki').innerHTML = null;
            }
        });

        $('input[type=radio][name=radiator]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_radiator').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Radiator</label>'+
                                                                            '<input type="file" name="foto_radiator" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_radiator').innerHTML = null;
            }
        });

        $('input[type=radio][name=kondisi_mesin]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kondisi_mesin').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kondisi Mesin</label>'+
                                                                            '<input type="file" name="foto_kondisi_mesin" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kondisi_mesin').innerHTML = null;
            }
        });

        $('input[type=radio][name=bumper_lampu]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_bumper_lampu').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Bumper & Lampu</label>'+
                                                                            '<input type="file" name="foto_bumper_lampu" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_bumper_lampu').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_depan_kiri]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_depan_kiri').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Fender Depan Kiri</label>'+
                                                                            '<input type="file" name="foto_fender_depan_kiri" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_fender_depan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_depan_kiri]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_depan_kiri').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kaki Depan Kiri</label>'+
                                                                            '<input type="file" name="foto_kaki_depan_kiri" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kaki_depan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_belakang_kiri]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_belakang_kiri').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kaki Belakang Kiri</label>'+
                                                                            '<input type="file" name="foto_kaki_belakang_kiri" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kaki_belakang_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_depan_kiri]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_depan_kiri').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Pintu Depan Kiri</label>'+
                                                                            '<input type="file" name="foto_pintu_depan_kiri" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_pintu_depan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_belakang_kiri]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_belakang_kiri').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Pintu Belakang Kiri</label>'+
                                                                            '<input type="file" name="foto_pintu_belakang_kiri" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_pintu_belakang_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_belakang_kiri]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_belakang_kiri').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Fender Belakang Kiri</label>'+
                                                                            '<input type="file" name="foto_fender_belakang_kiri" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_fender_belakang_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=lampu_belakang]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_lampu_belakang_kanan_kiri').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Lampu Belakang Kanan Kiri</label>'+
                                                                            '<input type="file" name="foto_lampu_belakang" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_lampu_belakang_kanan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_bagasi_belakang]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_bagasi_belakang').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Pintu Bagasi Belakang</label>'+
                                                                            '<input type="file" name="foto_pintu_bagasi_belakang" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_pintu_bagasi_belakang').innerHTML = null;
            }
        });

        $('input[type=radio][name=bumper_belakang]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_bumper_belakang').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Bumper Belakang</label>'+
                                                                            '<input type="file" name="foto_bumper_belakang" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_bumper_belakang').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_depan_kanan]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_depan_kanan').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Fender Depan Kanan</label>'+
                                                                            '<input type="file" name="foto_fender_depan_kanan" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_fender_depan_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_depan_kanan]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_depan_kanan').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kaki Depan Kanan</label>'+
                                                                            '<input type="file" name="foto_kaki_depan_kanan" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kaki_depan_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_belakang_kanan]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_belakang_kanan').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kaki Belakang Kanan</label>'+
                                                                            '<input type="file" name="foto_kaki_belakang_kanan" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kaki_belakang_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_depan_kanan]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_depan_kanan').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Pintu Depan Kanan</label>'+
                                                                            '<input type="file" name="foto_pintu_depan_kanan" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_pintu_depan_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_belakang_kanan]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_belakang_kanan').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Pintu Belakang Kanan</label>'+
                                                                            '<input type="file" name="foto_pintu_belakang_kanan" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_pintu_belakang_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_belakang_kanan]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_belakang_kanan').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Fender Belakang Kanan</label>'+
                                                                            '<input type="file" name="foto_fender_belakang_kanan" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_fender_belakang_kanan').innerHTML = null;
            }
        });

        $('#upload-simpan-bagian-depan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi_depan',['id' => $car->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    Swal.fire({
                        icon: "info",
                        title: "Data Sedang Diproses, Silahkan Tunggu",
                        showConfirmButton: false,
                    });
                },
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
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
        });

        $('#upload-simpan-bagian-kiri').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi_kiri',['id' => $car->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    Swal.fire({
                        icon: "info",
                        title: "Data Sedang Diproses, Silahkan Tunggu",
                        showConfirmButton: false,
                    });
                },
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
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
        });

        $('#upload-simpan-bagian-belakang').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi_belakang',['id' => $car->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    Swal.fire({
                        icon: "info",
                        title: "Data Sedang Diproses, Silahkan Tunggu",
                        showConfirmButton: false,
                    });
                },
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
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
        });

        $('#upload-simpan-bagian-kanan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi_kanan',['id' => $car->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    Swal.fire({
                        icon: "info",
                        title: "Data Sedang Diproses, Silahkan Tunggu",
                        showConfirmButton: false,
                    });
                },
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
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
        });

        $('#upload-simpan-bagian-interior').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi_interior',['id' => $car->id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    Swal.fire({
                        icon: "info",
                        title: "Data Sedang Diproses, Silahkan Tunggu",
                        showConfirmButton: false,
                    });
                },
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
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
        });
    </script>
@endsection
