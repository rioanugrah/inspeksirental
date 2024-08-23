@extends('layouts.backend.master')

@section('title')
    Mulai Inspeksi
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard_theme_arrows.min.css') }}"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard_theme_circles.min.css') }}"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/smartwizard/css/smart_wizard_theme_dots.min.css') }}"
        type="text/css" /> --}}
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

    <div class="accordion custom-accordionwitharrow" id="accordionExample">
        <div class="card mb-1 shadow-none border">
            <a href="" class="text-dark" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                aria-controls="collapseOne">
                <div class="card-header" id="headingOne">
                    <h5 class="m-0 fs-16">
                        Inspeksi Bagian Depan
                        <i class="uil uil-angle-down float-end accordion-arrow"></i>
                    </h5>
                    {!! $car->detail_inspeksi_depan
                        ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>'
                        : null !!}
                    {{-- <small>Baik : {!! number_format($total_inspeksi_depan['total_baik'], 0, '.', ',') . '%' !!}</small>
                    <small>Tidak Baik : {!! number_format($total_inspeksi_depan['total_rusak'], 0, '.', ',') . '%' !!}</small> --}}
                </div>
            </a>
            <div id="collapseOne" class="collapse {{ empty($car->detail_inspeksi_depan) ? 'show' : null }}"
                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="card-body">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_depan/' . $car->detail_inspeksi_depan->foto_kaca_depan) }}"
                                                    width="100%">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_depan/' . $car->detail_inspeksi_depan->foto_kap_mesin) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_depan/' . $car->detail_inspeksi_depan->foto_rangka_mobil) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_depan/' . $car->detail_inspeksi_depan->foto_aki) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_depan/' . $car->detail_inspeksi_depan->foto_radiator) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_depan/' . $car->detail_inspeksi_depan->foto_kondisi_mesin) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_depan/' . $car->detail_inspeksi_depan->foto_bumper_lampu) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <button type="button"
                                onclick="window.location.href='{{ route('cars.edit_inspeksi_depan', ['id' => $car->id, 'inspeksi_depan' => $car->detail_inspeksi_depan->id]) }}'"
                                class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
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
                                                    <input type="radio" name="kaca_depan" class="kaca_depan"
                                                        value="Baik" id="kacadepan1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="kaca_depan" class="kaca_depan"
                                                        value="Rusak" id="kacadepan2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
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
                                                    <input type="radio" name="rangka_mobil" value="Baik"
                                                        id="rangkamobil1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="rangka_mobil" value="Rusak"
                                                        id="rangkamobil2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
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
                                                    <input type="radio" name="kondisi_mesin" value="Baik"
                                                        id="kondisimesin1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="kondisi_mesin" value="Rusak"
                                                        id="kondisimesin2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
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
                                                    <input type="radio" name="bumper_lampu" value="Baik"
                                                        id="bumperlampu1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="bumper_lampu" value="Rusak"
                                                        id="bumperlampu2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
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
            </div>
        </div>

        <div class="card mb-1 shadow-none border">
            <a href="" class="text-dark collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                aria-expanded="false" aria-controls="collapseTwo">
                <div class="card-header" id="headingTwo">
                    <h5 class="m-0 fs-16">
                        Inspeksi Bagian Kiri
                        <i class="uil uil-angle-down float-end accordion-arrow"></i>
                    </h5>
                    {!! $car->detail_inspeksi_kiri
                        ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>'
                        : null !!}
                    {{-- <small>Baik : {!! number_format($total_inspeksi_kiri['total_baik'], 0, '.', ',') . '%' !!}</small>
                    <small>Tidak Baik : {!! number_format($total_inspeksi_kiri['total_rusak'], 0, '.', ',') . '%' !!}</small> --}}
                </div>
            </a>
            <div id="collapseTwo"
                class="collapse {{ !empty($car->detail_inspeksi_depan) && empty($car->detail_inspeksi_kiri) ? 'show' : null }}"
                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="card-body">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kiri/' . $car->detail_inspeksi_kiri->foto_fender_depan_kiri) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kiri/' . $car->detail_inspeksi_kiri->foto_kaki_depan_kiri) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kiri/' . $car->detail_inspeksi_kiri->foto_kaki_belakang_kiri) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kiri/' . $car->detail_inspeksi_kiri->foto_pintu_depan_kiri) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kiri/' . $car->detail_inspeksi_kiri->foto_pintu_belakang_kiri) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kiri/' . $car->detail_inspeksi_kiri->foto_fender_belakang_kiri) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <button type="button"
                                onclick="window.location.href='{{ route('cars.edit_inspeksi_kiri', ['id' => $car->id, 'inspeksi_kiri' => $car->detail_inspeksi_kiri->id]) }}'"
                                class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
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
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
            </div>
        </div>

        <div class="card mb-1 shadow-none border">
            <a href="" class="text-dark" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0 fs-16">
                        Inspeksi Bagian Belakang
                        <i class="uil uil-angle-down float-end accordion-arrow"></i>
                    </h5>
                    {!! $car->detail_inspeksi_belakang
                        ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>'
                        : null !!}
                    {{-- <small>Baik : {!! number_format($total_inspeksi_belakang['total_baik'], 0, '.', ',') . '%' !!}</small>
                    <small>Tidak Baik : {!! number_format($total_inspeksi_belakang['total_rusak'], 0, '.', ',') . '%' !!}</small> --}}
                </div>
            </a>

            <div id="collapseThree"
                class="collapse {{ !empty($car->detail_inspeksi_depan) && !empty($car->detail_inspeksi_kiri) && empty($car->detail_inspeksi_belakang) ? 'show' : null }}"
                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="card-body">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_belakang/' . $car->detail_inspeksi_belakang->foto_lampu_belakang) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_belakang/' . $car->detail_inspeksi_belakang->foto_pintu_bagasi_belakang) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_belakang/' . $car->detail_inspeksi_belakang->foto_bumper_belakang) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <button type="button"
                                onclick="window.location.href='{{ route('cars.edit_inspeksi_belakang', ['id' => $car->id, 'inspeksi_belakang' => $car->detail_inspeksi_belakang->id]) }}'"
                                class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
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
                                                    <input type="radio" name="lampu_belakang" value="Baik"
                                                        id="lampubelakang1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="lampu_belakang" value="Rusak"
                                                        id="lampubelakang2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
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
                                                    <input type="radio" name="pintu_bagasi_belakang" value="Baik"
                                                        id="pintubagasibelakang1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="pintu_bagasi_belakang" value="Rusak"
                                                        id="pintubagasibelakang2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
                                                    <input type="radio" name="bumper_belakang" value="Baik"
                                                        id="bumperbelakang1" autocomplete="off"><i
                                                        data-feather="thumbs-up"></i> Baik
                                                </label>
                                                <label class="btn btn-white">
                                                    <input type="radio" name="bumper_belakang" value="Rusak"
                                                        id="bumperbelakang2" autocomplete="off"><i
                                                        data-feather="thumbs-down"></i> Tidak/Rusak
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
            </div>
        </div>

        <div class="card mb-1 shadow-none border">
            <a href="" class="text-dark" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                aria-expanded="true" aria-controls="collapseFour">
                <div class="card-header" id="headingFour">
                    <h5 class="m-0 fs-16">
                        Inspeksi Bagian Kanan
                        <i class="uil uil-angle-down float-end accordion-arrow"></i>
                    </h5>
                    {!! $car->detail_inspeksi_kanan
                        ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>'
                        : null !!}
                    {{-- <small>Baik : {!! number_format($total_inspeksi_kanan['total_baik'], 0, '.', ',') . '%' !!}</small>
                    <small>Tidak Baik : {!! number_format($total_inspeksi_kanan['total_rusak'], 0, '.', ',') . '%' !!}</small> --}}
                </div>
            </a>

            <div id="collapseFour"
                class="collapse {{ !empty($car->detail_inspeksi_depan) && !empty($car->detail_inspeksi_kiri) && !empty($car->detail_inspeksi_belakang) && empty($car->detail_inspeksi_kanan) ? 'show' : null }}"
                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="card-body">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kanan/' . $car->detail_inspeksi_kanan->foto_fender_depan_kanan) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kanan/' . $car->detail_inspeksi_kanan->foto_kaki_depan_kanan) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kanan/' . $car->detail_inspeksi_kanan->foto_kaki_belakang_kanan) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kanan/' . $car->detail_inspeksi_kanan->foto_pintu_depan_kanan) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kanan/' . $car->detail_inspeksi_kanan->foto_pintu_belakang_kanan) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
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
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_kanan/' . $car->detail_inspeksi_kanan->foto_fender_belakang_kanan) }}"
                                                    width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <button type="button"
                                onclick="window.location.href='{{ route('cars.edit_inspeksi_kanan', ['id' => $car->id, 'inspeksi_kanan' => $car->detail_inspeksi_kanan->id]) }}'"
                                class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
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
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
                                                        data-feather="thumbs-down"></i>
                                                    Tidak/Rusak
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
            </div>
        </div>

        <div class="card mb-1 shadow-none border">
            <a href="" class="text-dark" data-bs-toggle="collapse" data-bs-target="#collapseFive"
                aria-expanded="true" aria-controls="collapseFive">
                <div class="card-header" id="headingiver">
                    <h5 class="m-0 fs-16">
                        Inspeksi Bagian Interior
                        <i class="uil uil-angle-down float-end accordion-arrow"></i>
                    </h5>
                    {!! $car->detail_inspeksi_interior
                        ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>'
                        : null !!}
                </div>
            </a>

            <div id="collapseFive"
                class="collapse {{ !empty($car->detail_inspeksi_depan) && !empty($car->detail_inspeksi_kiri) && !empty($car->detail_inspeksi_belakang) && !empty($car->detail_inspeksi_kanan) && empty($car->detail_inspeksi_interior) ? 'show' : null }}"
                aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                <div class="card-body">
                    @if ($car->detail_inspeksi_interior)
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Speedometer</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_speedometer) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Speedometer</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_speedometer !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Setir</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_setir) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Setir</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_setir !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Dasboard</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_dasboard) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Dasboard</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_dasboard !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Plafon</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_plafon) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Plafon</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_plafon !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>AC</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_ac) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan AC</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_ac !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Audio</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_audio) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Audio</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_audio !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Jok</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_jok) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Jok</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_jok !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Keterangan Electric Spion</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_electric_spion) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Electric Spion</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_electric_spion !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Power Window</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_power_window) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Power Window</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_power_window !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Keterangan Lain - Lain</label>
                                        <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $car->detail_inspeksi_interior->foto_lain_lain) }}"
                                            width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                        <div>Keterangan Lain - Lain</div>
                                        <div>{!! $car->detail_inspeksi_interior->keterangan_lain_lain !!}</div>
                                    </div>
                                </div>
                            </div>
                            <button type="button"
                                onclick="window.location.href='{{ route('cars.edit_inspeksi_interior', ['id' => $car->id, 'inspeksi_interior' => $car->detail_inspeksi_interior->id]) }}'"
                                class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
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
                                                <input type="file" name="foto_speedometer" accept="image/*"
                                                    class="form-control" id="foto_speedometer">
                                                <textarea id="" name="keterangan_speedometer" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Spidometer"></textarea>
                                            </div>
                                            <progress id="progressBarSpeedometer" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusSpeedometer"></h3>
                                            <p id="loaded_n_totalSpeedometer"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Setir</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_setir" accept="image/*"
                                                    class="form-control" id="foto_setir">
                                                <textarea id="" name="keterangan_setir" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Setir"></textarea>
                                            </div>
                                            <progress id="progressBarSetir" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusSetir"></h3>
                                            <p id="loaded_n_totalSetir"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Dashboard</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_dasboard" accept="image/*"
                                                    class="form-control" id="foto_dasboard">
                                                <textarea id="" name="keterangan_dasboard" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Dashboard"></textarea>
                                            </div>
                                            <progress id="progressBarDasboard" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusDasboard"></h3>
                                            <p id="loaded_n_totalDasboard"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Plafon</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_plafon" accept="image/*"
                                                    class="form-control" id="foto_plafon">
                                                <textarea id="" name="keterangan_plafon" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Plafon"></textarea>
                                            </div>
                                            <progress id="progressBarPlafon" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusPlafon"></h3>
                                            <p id="loaded_n_totalPlafon"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>AC</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_ac" accept="image/*"
                                                    class="form-control" id="foto_ac">
                                                <textarea id="" name="keterangan_ac" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan AC"></textarea>
                                            </div>
                                            <progress id="progressBarAc" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusAc"></h3>
                                            <p id="loaded_n_totalAc"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Audio</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_audio" accept="image/*"
                                                    class="form-control" id="foto_audio">
                                                <textarea id="" name="keterangan_audio" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Audio"></textarea>
                                            </div>
                                            <progress id="progressBarAudio" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusAudio"></h3>
                                            <p id="loaded_n_totalAudio"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Jok</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_jok" accept="image/*"
                                                    class="form-control" id="foto_jok">
                                                <textarea id="" name="keterangan_jok" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Jok"></textarea>
                                            </div>
                                            <progress id="progressBarJok" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusJok"></h3>
                                            <p id="loaded_n_totalJok"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Electric Spion</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_electric_spion" accept="image/*"
                                                    class="form-control" id="foto_electric_spion">
                                                <textarea id="" name="keterangan_electric_spion" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Electric Spion"></textarea>
                                            </div>
                                            <progress id="progressBarElectricSpion" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusElectricSpion"></h3>
                                            <p id="loaded_n_totalElectricSpion"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Power Window</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_power_window" accept="image/*"
                                                    class="form-control" id="foto_power_window">
                                                <textarea id="" name="keterangan_power_window" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Power Window"></textarea>
                                            </div>
                                            <progress id="progressBarPowerWindow" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusPowerWindow"></h3>
                                            <p id="loaded_n_totalPowerWindow"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label>Lain - Lain</label>
                                            <div class="input-group-btn">
                                                <input type="file" name="foto_lain_lain" accept="image/*"
                                                    class="form-control" id="foto_lain_lain">
                                                <textarea id="" name="keterangan_lain_lain" rows="2" cols="30" class="form-control"
                                                    placeholder="Keterangan Lain - Lain"></textarea>
                                            </div>
                                            <progress id="progressBarLainLain" value="0" max="100"
                                                style="width:300px;"></progress>
                                            <h3 id="statusLainLain"></h3>
                                            <p id="loaded_n_totalLainLain"></p>
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

        <div class="card mb-1 shadow-none border">
            <a href="" class="text-dark" data-bs-toggle="collapse" data-bs-target="#collapseSix"
                aria-expanded="true" aria-controls="collapseSix">
                <div class="card-header" id="headingiver">
                    <h5 class="m-0 fs-16">
                        Inspeksi Bagian Lain - Lain
                        <i class="uil uil-angle-down float-end accordion-arrow"></i>
                    </h5>
                    {!! $car->detail_inspeksi_lain
                        ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>'
                        : null !!}
                </div>
            </a>
            <div id="collapseSix"
                class="collapse {{ !empty($car->detail_inspeksi_depan) && !empty($car->detail_inspeksi_kiri) && !empty($car->detail_inspeksi_belakang) && !empty($car->detail_inspeksi_kanan) && !empty($car->detail_inspeksi_interior) && empty($car->detail_inspeksi_lain) ? 'show' : null }}"
                aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                <form id="upload-simpan-bagian-lain" class="repeater" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            @if ($car->detail_inspeksi_lain)
                                <div class="row">
                                    @foreach (json_decode($car->detail_inspeksi_lain->body) as $key_lain => $detail_inspeksi_lain)
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Keterangan {{ $key_lain + 1 }}</label>
                                                <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_lain/' . $detail_inspeksi_lain->foto_lain_lain) }}"
                                                    width="100%"
                                                    style="width: 250px; height: 250px; object-fit: cover;">
                                                <p>{!! $detail_inspeksi_lain->keterangan_lain_lain !!}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button"
                                    onclick="window.location.href='{{ route('cars.edit_inspeksi_lain', ['id' => $car->id, 'inspeksi_lain' => $car->detail_inspeksi_lain->id]) }}'"
                                    class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
                            @else
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                <div id="formAttachmentLainLain">
                                    <input type="file" name="foto_lain_lain[]" class="form-control">
                                    <textarea name="keterangan_lain_lain[]" class="form-control" placeholder="Keterangan 1"></textarea>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 mt-3">
                                    <button type="button" class="btn btn-success add" onclick="add()"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-rule="evenodd"
                                                d="M13 13v7a1 1 0 0 1-2 0v-7H4a1 1 0 0 1 0-2h7V4a1 1 0 0 1 2 0v7h7a1 1 0 0 1 0 2z" />
                                        </svg></button>
                                    <button type="button" class="btn btn-danger remove"
                                        onclick="remove()"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="1em" height="1em" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M4 5h3V4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1h3a1 1 0 0 1 0 2h-1v13a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7H4a1 1 0 1 1 0-2m3 2v13h10V7zm2-2h6V4H9zm0 4h2v9H9zm4 0h2v9h-2z" />
                                        </svg></button>
                                </div>
                            </div> --}}
                                    <div class="col-md-12">
                                        <div data-repeater-list="group-a">
                                            <div data-repeater-item>
                                                <input type="file" name="foto_lain_lain" class="form-control">
                                                <textarea name="keterangan_lain_lain" class="form-control" placeholder="Keterangan 1"></textarea>
                                                <input data-repeater-delete type="button" value="Delete" />
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" value="Add" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Form-->
@endsection

@section('script')
    <script src="{{ asset('backend/assets/js/jquery.repeater.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('plugins/src/tomSelect/tom-select.base.js') }}"></script>
    <script src="{{ asset('plugins/src/tomSelect/custom-tom-select.js') }}"></script>
    {{-- <script src="{{ asset('backend/assets/libs/smartwizard/js/jquery.smartWizard.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/form-wizard.init.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            'use strict';

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

            window.outerRepeater = $('.outer-repeater').repeater({
                isFirstItemUndeletable: true,
                defaultValues: {
                    'text-input': 'outer-default'
                },
                show: function() {
                    console.log('outer show');
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    console.log('outer delete');
                    $(this).slideUp(deleteElement);
                },
                repeaters: [{
                    isFirstItemUndeletable: true,
                    selector: '.inner-repeater',
                    defaultValues: {
                        'inner-text-input': 'inner-default'
                    },
                    show: function() {
                        console.log('inner show');
                        $(this).slideDown();
                    },
                    hide: function(deleteElement) {
                        console.log('inner delete');
                        $(this).slideUp(deleteElement);
                    }
                }]
            });
        });

        var formAttachmentLainLain = document.getElementById('formAttachmentLainLain');

        var no = 1;

        function add() {
            var newField = document.createElement('input');
            newField.setAttribute('type', 'file');
            newField.setAttribute('name', 'foto_lain_lain[]');
            newField.setAttribute('class', 'form-control');
            formAttachmentLainLain.appendChild(newField);

            var newFieldTextArea = document.createElement('textarea');
            newFieldTextArea.setAttribute('name', 'keterangan_lain_lain[]');
            newFieldTextArea.setAttribute('class', 'form-control');
            newFieldTextArea.setAttribute('placeholder', 'Keterangan ' + parseInt(no + 1));
            formAttachmentLainLain.appendChild(newFieldTextArea);

            var hr = document.createElement('hr');
            formAttachmentLainLain.appendChild(hr);
            no++;
        }

        function remove() {
            var input_tags = formAttachmentLainLain.getElementsByTagName('input');
            if (input_tags.length > 0) {
                formAttachmentLainLain.removeChild(input_tags[(input_tags.length) - 1]);
            }

            var input_tags_textarea = formAttachmentLainLain.getElementsByTagName('textarea');
            if (input_tags_textarea.length > 0) {
                formAttachmentLainLain.removeChild(input_tags_textarea[(input_tags_textarea.length) - 1]);
            }

            var hr = formAttachmentLainLain.getElementsByTagName('hr');
            if (hr.length > 0) {
                formAttachmentLainLain.removeChild(hr[(hr.length) - 1]);
            }
            no--;
        }
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[type=radio][name=kaca_depan]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_kaca_depan').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Kaca Depan</label>' +
                    '<input type="file" name="foto_kaca_depan" class="form-control">' +
                    '<textarea id="" name="keterangan_kaca_depan" rows="2" cols="10" class="form-control" placeholder="Keterangan Kaca Depan"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_kaca_depan').innerHTML = null;
            }
        });

        $('input[type=radio][name=kap_mesin]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_kap_mesin').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Kap Mesin</label>' +
                    '<input type="file" name="foto_kap_mesin" class="form-control">' +
                    '<textarea id="" name="keterangan_kap_mesin" rows="2" cols="10" class="form-control" placeholder="Keterangan Kap Mesin"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_kap_mesin').innerHTML = null;
            }
        });

        $('input[type=radio][name=rangka_mobil]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_rangka_mobil').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Rangka Mobil</label>' +
                    '<input type="file" name="foto_rangka_mobil" class="form-control">' +
                    '<textarea id="" name="keterangan_rangka_mobil" rows="2" cols="10" class="form-control" placeholder="Keterangan Rangka Mobil"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_rangka_mobil').innerHTML = null;
            }
        });

        $('input[type=radio][name=aki]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_aki').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Aki Mobil</label>' +
                    '<input type="file" name="foto_aki" class="form-control">' +
                    '<textarea id="" name="keterangan_aki" rows="2" cols="10" class="form-control" placeholder="Keterangan Aki Mobil"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_aki').innerHTML = null;
            }
        });

        $('input[type=radio][name=radiator]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_radiator').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Radiator</label>' +
                    '<input type="file" name="foto_radiator" class="form-control">' +
                    '<textarea id="" name="keterangan_radiator" rows="2" cols="10" class="form-control" placeholder="Keterangan Radiator"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_radiator').innerHTML = null;
            }
        });

        $('input[type=radio][name=kondisi_mesin]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_kondisi_mesin').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Kondisi Mesin</label>' +
                    '<input type="file" name="foto_kondisi_mesin" class="form-control">' +
                    '<textarea id="" name="keterangan_kondisi_mesin" rows="2" cols="10" class="form-control" placeholder="Keterangan Kondisi Mesin"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_kondisi_mesin').innerHTML = null;
            }
        });

        $('input[type=radio][name=bumper_lampu]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_bumper_lampu').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Bumper & Lampu</label>' +
                    '<input type="file" name="foto_bumper_lampu" class="form-control">' +
                    '<textarea id="" name="keterangan_bumper_lampu" rows="2" cols="10" class="form-control" placeholder="Keterangan Bumper & Lampu"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_bumper_lampu').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_depan_kiri]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_depan_kiri').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Fender Depan Kiri</label>' +
                    '<input type="file" name="foto_fender_depan_kiri" class="form-control">' +
                    '<textarea id="" name="keterangan_fender_depan_kiri" rows="2" cols="10" class="form-control" placeholder="Keterangan Fender Depan Kiri"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_fender_depan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_depan_kiri]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_depan_kiri').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Kaki Depan Kiri</label>' +
                    '<input type="file" name="foto_kaki_depan_kiri" class="form-control">' +
                    '<textarea id="" name="keterangan_kaki_depan_kiri" rows="2" cols="10" class="form-control" placeholder="Keterangan Kaki Depan Kiri"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_kaki_depan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_belakang_kiri]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_belakang_kiri').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Kaki Belakang Kiri</label>' +
                    '<input type="file" name="foto_kaki_belakang_kiri" class="form-control">' +
                    '<textarea id="" name="keterangan_kaki_belakang_kiri" rows="2" cols="10" class="form-control" placeholder="Keterangan Kaki Belakang Kiri"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_kaki_belakang_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_depan_kiri]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_depan_kiri').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Pintu Depan Kiri</label>' +
                    '<input type="file" name="foto_pintu_depan_kiri" class="form-control">' +
                    '<textarea id="" name="keterangan_pintu_depan_kiri" rows="2" cols="10" class="form-control" placeholder="Keterangan Pintu Depan Kiri"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_pintu_depan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_belakang_kiri]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_belakang_kiri').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Pintu Belakang Kiri</label>' +
                    '<input type="file" name="foto_pintu_belakang_kiri" class="form-control">' +
                    '<textarea id="" name="keterangan_pintu_belakang_kiri" rows="2" cols="10" class="form-control" placeholder="Keterangan Pintu Belakang Kiri"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_pintu_belakang_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_belakang_kiri]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_belakang_kiri').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Fender Belakang Kiri</label>' +
                    '<input type="file" name="foto_fender_belakang_kiri" class="form-control">' +
                    '<textarea id="" name="keterangan_fender_belakang_kiri" rows="2" cols="10" class="form-control" placeholder="Keterangan Fender Belakang Kiri"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_fender_belakang_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=lampu_belakang]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_lampu_belakang_kanan_kiri').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Lampu Belakang Kanan Kiri</label>' +
                    '<input type="file" name="foto_lampu_belakang" class="form-control">' +
                    '<textarea id="" name="keterangan_lampu_belakang" rows="2" cols="10" class="form-control" placeholder="Keterangan Lampu Belakang Kanan Kiri"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_lampu_belakang_kanan_kiri').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_bagasi_belakang]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_bagasi_belakang').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Pintu Bagasi Belakang</label>' +
                    '<input type="file" name="foto_pintu_bagasi_belakang" class="form-control">' +
                    '<textarea id="" name="keterangan_pintu_bagasi_belakang" rows="2" cols="10" class="form-control" placeholder="Keterangan Pintu Bagasi Belakang"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_pintu_bagasi_belakang').innerHTML = null;
            }
        });

        $('input[type=radio][name=bumper_belakang]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_bumper_belakang').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Bumper Belakang</label>' +
                    '<input type="file" name="foto_bumper_belakang" class="form-control">' +
                    '<textarea id="" name="keterangan_bumper_belakang" rows="2" cols="10" class="form-control" placeholder="Keterangan Bumper Belakang"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_bumper_belakang').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_depan_kanan]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_depan_kanan').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Fender Depan Kanan</label>' +
                    '<input type="file" name="foto_fender_depan_kanan" class="form-control">' +
                    '<textarea id="" name="keterangan_fender_depan_kanan" rows="2" cols="10" class="form-control" placeholder="Keterangan Fender Depan Kanan"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_fender_depan_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_depan_kanan]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_depan_kanan').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Kaki Depan Kanan</label>' +
                    '<input type="file" name="foto_kaki_depan_kanan" class="form-control">' +
                    '<textarea id="" name="keterangan_kaki_depan_kanan" rows="2" cols="10" class="form-control" placeholder="Keterangan Kaki Depan Kanan"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_kaki_depan_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=kaki_belakang_kanan]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki_belakang_kanan').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Kaki Belakang Kanan</label>' +
                    '<input type="file" name="foto_kaki_belakang_kanan" class="form-control">' +
                    '<textarea id="" name="keterangan_kaki_belakang_kanan" rows="2" cols="10" class="form-control" placeholder="Keterangan Kaki Belakang Kanan"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_kaki_belakang_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_depan_kanan]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_depan_kanan').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Pintu Depan Kanan</label>' +
                    '<input type="file" name="foto_pintu_depan_kanan" class="form-control">' +
                    '<textarea id="" name="keterangan_pintu_depan_kanan" rows="2" cols="10" class="form-control" placeholder="Keterangan Pintu Depan Kanan"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_pintu_depan_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=pintu_belakang_kanan]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_pintu_belakang_kanan').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Pintu Belakang Kanan</label>' +
                    '<input type="file" name="foto_pintu_belakang_kanan" class="form-control">' +
                    '<textarea id="" name="keterangan_pintu_belakang_kanan" rows="2" cols="10" class="form-control" placeholder="Keterangan Pintu Belakang Kanan"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_pintu_belakang_kanan').innerHTML = null;
            }
        });

        $('input[type=radio][name=fender_belakang_kanan]').on('change', function() {
            if (this.value == 'Rusak') {
                document.getElementById('view_fender_belakang_kanan').innerHTML = '<div class="mt-2 mb-2">' +
                    '<label>Bukti Foto Fender Belakang Kanan</label>' +
                    '<input type="file" name="foto_fender_belakang_kanan" class="form-control">' +
                    '<textarea id="" name="keterangan_fender_belakang_kanan" rows="2" cols="10" class="form-control" placeholder="Keterangan Fender Belakang Kanan"></textarea>' +
                    '</div>';
            } else {
                document.getElementById('view_fender_belakang_kanan').innerHTML = null;
            }
        });

        $('#upload-simpan-bagian-depan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi_depan', ['id' => $car->id]) }}",
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
                        setTimeout(function() {
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
                url: "{{ route('cars.simpan_inspeksi_kiri', ['id' => $car->id]) }}",
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
                        setTimeout(function() {
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
                url: "{{ route('cars.simpan_inspeksi_belakang', ['id' => $car->id]) }}",
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
                        setTimeout(function() {
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
                url: "{{ route('cars.simpan_inspeksi_kanan', ['id' => $car->id]) }}",
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
                        setTimeout(function() {
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
                url: "{{ route('cars.simpan_inspeksi_interior', ['id' => $car->id]) }}",
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
                        setTimeout(function() {
                            // location.reload();
                            window.location.href = "{{ route('cars') }}";
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: result.error,
                            // showConfirmButton: false,
                        });
                    }
                },
                error: function(request, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        // showConfirmButton: false,
                    });
                }
            });
        });

        $('#upload-simpan-bagian-lain').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi_lain', ['id' => $car->id]) }}",
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
                        setTimeout(function() {
                            // location.reload();
                            window.location.href = "{{ route('cars') }}";
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
    <script>
        function _(el) {
            return document.getElementById(el);
        }

        $('#foto_speedometer').on('change', function() {
            var file = _("foto_speedometer").files[0];
            var formdata = new FormData();
            formdata.append("foto_speedometer", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerSpeedometer, false);
            ajax.addEventListener("load", completeHandlerSpeedometer, false);
            ajax.addEventListener("error", errorHandlerSpeedometer, false);
            ajax.addEventListener("abort", abortHandlerSpeedometer, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_speedometer', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerSpeedometer(event) {
            _("loaded_n_totalSpeedometer").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarSpeedometer").value = Math.round(percent);
            _("statusSpeedometer").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerSpeedometer(event) {
            _("statusSpeedometer").innerHTML = event.target.responseText;
            _("progressBarSpeedometer").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerSpeedometer(event) {
            _("statusSpeedometer").innerHTML = "Upload Failed";
        }

        function abortHandlerSpeedometer(event) {
            _("statusSpeedometer").innerHTML = "Upload Aborted";
        }


        $('#foto_setir').on('change', function() {
            var file = _("foto_setir").files[0];
            var formdata = new FormData();
            formdata.append("foto_setir", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerSetir, false);
            ajax.addEventListener("load", completeHandlerSetir, false);
            ajax.addEventListener("error", errorHandlerSetir, false);
            ajax.addEventListener("abort", abortHandlerSetir, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_setir', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerSetir(event) {
            _("loaded_n_totalSetir").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarSetir").value = Math.round(percent);
            _("statusSetir").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerSetir(event) {
            _("statusSetir").innerHTML = event.target.responseText;
            _("progressBarSetir").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerSetir(event) {
            _("statusSetir").innerHTML = "Upload Failed";
        }

        function abortHandlerSetir(event) {
            _("statusSetir").innerHTML = "Upload Aborted";
        }


        $('#foto_dasboard').on('change', function() {
            var file = _("foto_dasboard").files[0];
            var formdata = new FormData();
            formdata.append("foto_dasboard", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerDasboard, false);
            ajax.addEventListener("load", completeHandlerDasboard, false);
            ajax.addEventListener("error", errorHandlerDasboard, false);
            ajax.addEventListener("abort", abortHandlerDasboard, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_dasboard', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerDasboard(event) {
            _("loaded_n_totalDasboard").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarDasboard").value = Math.round(percent);
            _("statusDasboard").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerDasboard(event) {
            _("statusDasboard").innerHTML = event.target.responseText;
            _("progressBarDasboard").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerDasboard(event) {
            _("statusDasboard").innerHTML = "Upload Failed";
        }

        function abortHandlerDasboard(event) {
            _("statusDasboard").innerHTML = "Upload Aborted";
        }


        $('#foto_plafon').on('change', function() {
            var file = _("foto_plafon").files[0];
            var formdata = new FormData();
            formdata.append("foto_plafon", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerPlafon, false);
            ajax.addEventListener("load", completeHandlerPlafon, false);
            ajax.addEventListener("error", errorHandlerPlafon, false);
            ajax.addEventListener("abort", abortHandlerPlafon, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_plafon', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerPlafon(event) {
            _("loaded_n_totalPlafon").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarPlafon").value = Math.round(percent);
            _("statusPlafon").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerPlafon(event) {
            _("statusPlafon").innerHTML = event.target.responseText;
            _("progressBarPlafon").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerPlafon(event) {
            _("statusPlafon").innerHTML = "Upload Failed";
        }

        function abortHandlerPlafon(event) {
            _("statusPlafon").innerHTML = "Upload Aborted";
        }


        $('#foto_ac').on('change', function() {
            var file = _("foto_ac").files[0];
            var formdata = new FormData();
            formdata.append("foto_ac", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerAc, false);
            ajax.addEventListener("load", completeHandlerAc, false);
            ajax.addEventListener("error", errorHandlerAc, false);
            ajax.addEventListener("abort", abortHandlerAc, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_ac', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerAc(event) {
            _("loaded_n_totalAc").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarAc").value = Math.round(percent);
            _("statusAc").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerAc(event) {
            _("statusAc").innerHTML = event.target.responseText;
            _("progressBarAc").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerAc(event) {
            _("statusAc").innerHTML = "Upload Failed";
        }

        function abortHandlerAc(event) {
            _("statusAc").innerHTML = "Upload Aborted";
        }


        $('#foto_audio').on('change', function() {
            var file = _("foto_audio").files[0];
            var formdata = new FormData();
            formdata.append("foto_audio", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerAudio, false);
            ajax.addEventListener("load", completeHandlerAudio, false);
            ajax.addEventListener("error", errorHandlerAudio, false);
            ajax.addEventListener("abort", abortHandlerAudio, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_audio', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerAudio(event) {
            _("loaded_n_totalAudio").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarAudio").value = Math.round(percent);
            _("statusAudio").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerAudio(event) {
            _("statusAudio").innerHTML = event.target.responseText;
            _("progressBarAudio").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerAudio(event) {
            _("statusAudio").innerHTML = "Upload Failed";
        }

        function abortHandlerAudio(event) {
            _("statusAudio").innerHTML = "Upload Aborted";
        }


        $('#foto_jok').on('change', function() {
            var file = _("foto_jok").files[0];
            var formdata = new FormData();
            formdata.append("foto_jok", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerJok, false);
            ajax.addEventListener("load", completeHandlerJok, false);
            ajax.addEventListener("error", errorHandlerJok, false);
            ajax.addEventListener("abort", abortHandlerJok, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_jok', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerJok(event) {
            _("loaded_n_totalJok").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarJok").value = Math.round(percent);
            _("statusJok").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerJok(event) {
            _("statusJok").innerHTML = event.target.responseText;
            _("progressBarJok").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerJok(event) {
            _("statusJok").innerHTML = "Upload Failed";
        }

        function abortHandlerJok(event) {
            _("statusJok").innerHTML = "Upload Aborted";
        }


        $('#foto_electric_spion').on('change', function() {
            var file = _("foto_electric_spion").files[0];
            var formdata = new FormData();
            formdata.append("foto_electric_spion", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerElectricSpion, false);
            ajax.addEventListener("load", completeHandlerElectricSpion, false);
            ajax.addEventListener("error", errorHandlerElectricSpion, false);
            ajax.addEventListener("abort", abortHandlerElectricSpion, false);
            ajax.open("POST",
                "{{ route('cars.upload_file_inspeksi_interior_electric_spion', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerElectricSpion(event) {
            _("loaded_n_totalElectricSpion").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarElectricSpion").value = Math.round(percent);
            _("statusElectricSpion").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerElectricSpion(event) {
            _("statusElectricSpion").innerHTML = event.target.responseText;
            _("progressBarElectricSpion").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerElectricSpion(event) {
            _("statusElectricSpion").innerHTML = "Upload Failed";
        }

        function abortHandlerElectricSpion(event) {
            _("statusElectricSpion").innerHTML = "Upload Aborted";
        }


        $('#foto_power_window').on('change', function() {
            var file = _("foto_power_window").files[0];
            var formdata = new FormData();
            formdata.append("foto_power_window", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerPowerWindow, false);
            ajax.addEventListener("load", completeHandlerPowerWindow, false);
            ajax.addEventListener("error", errorHandlerPowerWindow, false);
            ajax.addEventListener("abort", abortHandlerPowerWindow, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_power_window', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerPowerWindow(event) {
            _("loaded_n_totalPowerWindow").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarPowerWindow").value = Math.round(percent);
            _("statusPowerWindow").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerPowerWindow(event) {
            _("statusPowerWindow").innerHTML = event.target.responseText;
            _("progressBarPowerWindow").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerPowerWindow(event) {
            _("statusPowerWindow").innerHTML = "Upload Failed";
        }

        function abortHandlerPowerWindow(event) {
            _("statusPowerWindow").innerHTML = "Upload Aborted";
        }


        $('#foto_lain_lain').on('change', function() {
            var file = _("foto_lain_lain").files[0];
            var formdata = new FormData();
            formdata.append("foto_lain_lain", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerLainLain, false);
            ajax.addEventListener("load", completeHandlerLainLain, false);
            ajax.addEventListener("error", errorHandlerLainLain, false);
            ajax.addEventListener("abort", abortHandlerLainLain, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_lain_lain', ['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerLainLain(event) {
            _("loaded_n_totalLainLain").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarLainLain").value = Math.round(percent);
            _("statusLainLain").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerLainLain(event) {
            _("statusLainLain").innerHTML = event.target.responseText;
            _("progressBarLainLain").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerLainLain(event) {
            _("statusLainLain").innerHTML = "Upload Failed";
        }

        function abortHandlerLainLain(event) {
            _("statusLainLain").innerHTML = "Upload Aborted";
        }
    </script>
@endsection
