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
                            <img src="{{ asset('backend/assets/images/mobil_images/mb.webp') }}"
                                width="100%" height="85%" class="img-fluid" alt="Foto kendaraan" style="margin-left: 5%">
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
            <a href="#!" class="text-dark" onclick="event.preventDefault();" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
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
            <a href="#!" class="text-dark collapsed" onclick="event.preventDefault();" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
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
            <a href="#!" class="text-dark" onclick="event.preventDefault();" data-bs-toggle="collapse" data-bs-target="#collapseThree"
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
            <a href="#!" class="text-dark" onclick="event.preventDefault();" data-bs-toggle="collapse" data-bs-target="#collapseFour"
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
            <a href="#!" class="text-dark" onclick="event.preventDefault();" data-bs-toggle="collapse" data-bs-target="#collapseFive"
                aria-expanded="true" aria-controls="collapseFive">
                <div class="card-header" id="headingFive">
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
                                <div id="interior-realtime-status" class="alert alert-light border mt-3" role="status" aria-live="polite">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong id="interior-realtime-title">Menunggu kelengkapan data...</strong>
                                        <span id="interior-realtime-percent">0%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div id="interior-realtime-progress" class="progress-bar progress-bar-striped" role="progressbar"
                                            style="width: 0%;" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>
                                    </div>
                                    <small id="interior-realtime-detail" class="text-muted d-block mt-2">Lengkapi semua foto dan keterangan terlebih dahulu.</small>
                                </div>

                                <button type="submit" id="btn-submit-interior" class="btn btn-success">
                                    <i class="uil uil-check-circle me-1"></i> Submit
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mb-1 shadow-none border">
            <a href="#!" class="text-dark" onclick="event.preventDefault();" data-bs-toggle="collapse" data-bs-target="#collapseSix"
                aria-expanded="true" aria-controls="collapseSix">
                <div class="card-header" id="headingSix">
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
                                <button type="button"
                                    onclick="window.location.href='{{ route('cars.tambah_inspeksi_lain', ['id' => $car->id, 'inspeksi_lain' => $car->detail_inspeksi_lain->id]) }}'"
                                    class="btn btn-primary">Tambah Baru</button>
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
    <script src="{{ asset('backend/assets/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
    <script>
        $(function () {
            'use strict';

            /* -------------------------------------------------------------
             * Common helpers
             * ----------------------------------------------------------- */
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                || document.querySelector('input[name="_token"]')?.value
                || '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const inspectionForms = {
                '#upload-simpan-bagian-depan': {
                    url: "{{ route('cars.simpan_inspeksi_depan', ['id' => $car->id]) }}",
                    redirect: 'reload'
                },
                '#upload-simpan-bagian-kiri': {
                    url: "{{ route('cars.simpan_inspeksi_kiri', ['id' => $car->id]) }}",
                    redirect: 'reload'
                },
                '#upload-simpan-bagian-belakang': {
                    url: "{{ route('cars.simpan_inspeksi_belakang', ['id' => $car->id]) }}",
                    redirect: 'reload'
                },
                '#upload-simpan-bagian-kanan': {
                    url: "{{ route('cars.simpan_inspeksi_kanan', ['id' => $car->id]) }}",
                    redirect: 'reload'
                },
                '#upload-simpan-bagian-interior': {
                    url: "{{ route('cars.simpan_inspeksi_interior', ['id' => $car->id]) }}",
                    redirect: "{{ route('cars') }}",
                    waitForUploads: true
                },
                '#upload-simpan-bagian-lain': {
                    url: "{{ route('cars.simpan_inspeksi_lain', ['id' => $car->id]) }}",
                    redirect: "{{ route('cars') }}"
                }
            };

            function safeJson(text) {
                if (!text) return null;
                try {
                    return typeof text === 'object' ? text : JSON.parse(text);
                } catch (error) {
                    return null;
                }
            }

            function getResponseData(request, fallback) {
                return request?.responseJSON || safeJson(request?.responseText) || fallback || {};
            }

            function getFirstValidationError(errors) {
                if (!errors || typeof errors !== 'object') return '';
                for (const key of Object.keys(errors)) {
                    const messages = Array.isArray(errors[key]) ? errors[key] : [errors[key]];
                    if (messages[0]) return messages[0];
                }
                return '';
            }

            function showAlert({
                icon = 'info',
                title = 'Informasi',
                text = '',
                timer = null,
                allowOutsideClick = true
            }) {
                const options = {
                    icon,
                    title,
                    text,
                    allowOutsideClick,
                    buttonsStyling: true
                };
                if (timer) {
                    options.timer = timer;
                    options.showConfirmButton = false;
                }
                return Swal.fire(options);
            }

            function showLoading(title = 'Data sedang diproses, silakan tunggu...') {
                Swal.fire({
                    title,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });
            }

            function setFormBusy(form, busy) {
                form.dataset.submitting = busy ? '1' : '0';
                form.querySelectorAll('button[type="submit"]').forEach(button => {
                    button.disabled = busy;
                });
            }

            /* -------------------------------------------------------------
             * Repeater: bagian lain-lain
             * ----------------------------------------------------------- */
            const $repeater = $('.repeater');
            if ($repeater.length && typeof $repeater.repeater === 'function') {
                $repeater.repeater({
                    isFirstItemUndeletable: true,
                    show: function () {
                        $(this).slideDown();
                    },
                    hide: function (deleteElement) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Hapus item ini?',
                            text: 'Data yang dihapus dari daftar ini tidak dapat dipulihkan sebelum disimpan.',
                            showCancelButton: true,
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal'
                        }).then(result => {
                            if (result.isConfirmed) {
                                $(this).slideUp(deleteElement);
                            }
                        });
                    }
                });
            }

            /* -------------------------------------------------------------
             * Radio inspection -> show evidence fields when damaged
             * ----------------------------------------------------------- */
            const damageFields = [
                ['kaca_depan', 'view_kaca_depan', 'foto_kaca_depan', 'Kaca Depan'],
                ['kap_mesin', 'view_kap_mesin', 'foto_kap_mesin', 'Kap Mesin'],
                ['rangka_mobil', 'view_rangka_mobil', 'foto_rangka_mobil', 'Rangka Mobil'],
                ['aki', 'view_aki', 'foto_aki', 'Aki Mobil'],
                ['radiator', 'view_radiator', 'foto_radiator', 'Radiator'],
                ['kondisi_mesin', 'view_kondisi_mesin', 'foto_kondisi_mesin', 'Kondisi Mesin'],
                ['bumper_lampu', 'view_bumper_lampu', 'foto_bumper_lampu', 'Bumper & Lampu'],
                ['fender_depan_kiri', 'view_fender_depan_kiri', 'foto_fender_depan_kiri', 'Fender Depan Kiri'],
                ['kaki_depan_kiri', 'view_kaki_depan_kiri', 'foto_kaki_depan_kiri', 'Kaki Depan Kiri'],
                ['kaki_belakang_kiri', 'view_kaki_belakang_kiri', 'foto_kaki_belakang_kiri', 'Kaki Belakang Kiri'],
                ['pintu_depan_kiri', 'view_pintu_depan_kiri', 'foto_pintu_depan_kiri', 'Pintu Depan Kiri'],
                ['pintu_belakang_kiri', 'view_pintu_belakang_kiri', 'foto_pintu_belakang_kiri', 'Pintu Belakang Kiri'],
                ['fender_belakang_kiri', 'view_fender_belakang_kiri', 'foto_fender_belakang_kiri', 'Fender Belakang Kiri'],
                ['lampu_belakang', 'view_lampu_belakang_kanan_kiri', 'foto_lampu_belakang', 'Lampu Belakang Kanan Kiri'],
                ['pintu_bagasi_belakang', 'view_pintu_bagasi_belakang', 'foto_pintu_bagasi_belakang', 'Pintu Bagasi Belakang'],
                ['bumper_belakang', 'view_bumper_belakang', 'foto_bumper_belakang', 'Bumper Belakang'],
                ['fender_depan_kanan', 'view_fender_depan_kanan', 'foto_fender_depan_kanan', 'Fender Depan Kanan'],
                ['kaki_depan_kanan', 'view_kaki_depan_kanan', 'foto_kaki_depan_kanan', 'Kaki Depan Kanan'],
                ['kaki_belakang_kanan', 'view_kaki_belakang_kanan', 'foto_kaki_belakang_kanan', 'Kaki Belakang Kanan'],
                ['pintu_depan_kanan', 'view_pintu_depan_kanan', 'foto_pintu_depan_kanan', 'Pintu Depan Kanan'],
                ['pintu_belakang_kanan', 'view_pintu_belakang_kanan', 'foto_pintu_belakang_kanan', 'Pintu Belakang Kanan'],
                ['fender_belakang_kanan', 'view_fender_belakang_kanan', 'foto_fender_belakang_kanan', 'Fender Belakang Kanan']
            ];

            const damageMap = Object.fromEntries(
                damageFields.map(([radio, view, file, label]) => [radio, { view, file, label }])
            );

            function renderDamageEvidence(radioName, value) {
                const config = damageMap[radioName];
                const container = document.getElementById(config?.view);
                if (!container) return;

                if (value === 'Rusak') {
                    const textareaName = `keterangan_${config.file.replace(/^foto_/, '')}`;
                    container.innerHTML = `
                        <div class="mt-2 mb-2">
                            <label for="${config.file}">Bukti Foto ${config.label}</label>
                            <input type="file"
                                   id="${config.file}"
                                   name="${config.file}"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/webp">
                            <textarea name="${textareaName}"
                                      rows="2"
                                      class="form-control mt-2"
                                      placeholder="Keterangan ${config.label}"></textarea>
                        </div>`;
                } else {
                    container.innerHTML = '';
                }
            }

            damageFields.forEach(([radioName]) => {
                $(`input[type="radio"][name="${radioName}"]`).on('change', function () {
                    const group = this.closest('.input-group-btn');
                    if (group) {
                        group.querySelectorAll('label.btn').forEach(label => {
                            const radio = label.querySelector('input[type="radio"]');
                            const active = !!radio?.checked;
                            label.classList.toggle('active', active);
                            label.classList.toggle('btn-primary', active);
                            label.classList.toggle('btn-white', !active);
                        });
                    }
                    renderDamageEvidence(radioName, this.value);
                });

                const checked = document.querySelector(`input[type="radio"][name="${radioName}"]:checked`);
                if (checked) {
                    renderDamageEvidence(radioName, checked.value);
                }
            });

            /* -------------------------------------------------------------
             * Form submission + realtime completeness
             * ----------------------------------------------------------- */
            const pendingInteriorUploads = new Map();
            let interiorAutoProcessing = false;

            const interiorUploadConfigs = [
                ['foto_speedometer', 'keterangan_speedometer', 'progressBarSpeedometer', 'statusSpeedometer', 'loaded_n_totalSpeedometer', 'Speedometer', "{{ route('cars.upload_file_inspeksi_interior_speedometer', ['id' => $car->id]) }}"],
                ['foto_setir', 'keterangan_setir', 'progressBarSetir', 'statusSetir', 'loaded_n_totalSetir', 'Setir', "{{ route('cars.upload_file_inspeksi_interior_setir', ['id' => $car->id]) }}"],
                ['foto_dasboard', 'keterangan_dasboard', 'progressBarDasboard', 'statusDasboard', 'loaded_n_totalDasboard', 'Dashboard', "{{ route('cars.upload_file_inspeksi_interior_dasboard', ['id' => $car->id]) }}"],
                ['foto_plafon', 'keterangan_plafon', 'progressBarPlafon', 'statusPlafon', 'loaded_n_totalPlafon', 'Plafon', "{{ route('cars.upload_file_inspeksi_interior_plafon', ['id' => $car->id]) }}"],
                ['foto_ac', 'keterangan_ac', 'progressBarAc', 'statusAc', 'loaded_n_totalAc', 'AC', "{{ route('cars.upload_file_inspeksi_interior_ac', ['id' => $car->id]) }}"],
                ['foto_audio', 'keterangan_audio', 'progressBarAudio', 'statusAudio', 'loaded_n_totalAudio', 'Audio', "{{ route('cars.upload_file_inspeksi_interior_audio', ['id' => $car->id]) }}"],
                ['foto_jok', 'keterangan_jok', 'progressBarJok', 'statusJok', 'loaded_n_totalJok', 'Jok', "{{ route('cars.upload_file_inspeksi_interior_jok', ['id' => $car->id]) }}"],
                ['foto_electric_spion', 'keterangan_electric_spion', 'progressBarElectricSpion', 'statusElectricSpion', 'loaded_n_totalElectricSpion', 'Electric Spion', "{{ route('cars.upload_file_inspeksi_interior_electric_spion', ['id' => $car->id]) }}"],
                ['foto_power_window', 'keterangan_power_window', 'progressBarPowerWindow', 'statusPowerWindow', 'loaded_n_totalPowerWindow', 'Power Window', "{{ route('cars.upload_file_inspeksi_interior_power_window', ['id' => $car->id]) }}"],
                ['foto_lain_lain', 'keterangan_lain_lain', 'progressBarLainLain', 'statusLainLain', 'loaded_n_totalLainLain', 'Lain-lain', "{{ route('cars.upload_file_inspeksi_interior_lain_lain', ['id' => $car->id]) }}"]
            ];

            function updateInteriorRealtimeStatus(title, detail, percent) {
                const titleEl = document.getElementById('interior-realtime-title');
                const detailEl = document.getElementById('interior-realtime-detail');
                const percentEl = document.getElementById('interior-realtime-percent');
                const progressEl = document.getElementById('interior-realtime-progress');

                const safePercent = Math.max(0, Math.min(100, Math.round(Number(percent) || 0)));
                if (titleEl) titleEl.textContent = title || '';
                if (detailEl) detailEl.textContent = detail || '';
                if (percentEl) percentEl.textContent = `${safePercent}%`;
                if (progressEl) {
                    progressEl.style.width = `${safePercent}%`;
                    progressEl.setAttribute('aria-valuenow', String(safePercent));
                    progressEl.classList.toggle('progress-bar-animated', interiorAutoProcessing);
                }
            }

            function getInteriorForm() {
                return document.getElementById('upload-simpan-bagian-interior');
            }

            function getInteriorCompletion(form) {
                const missing = [];
                let completed = 0;

                interiorUploadConfigs.forEach(([fileName, noteName, , , , label]) => {
                    const fileInput = form.querySelector(`[name="${fileName}"]`);
                    const noteInput = form.querySelector(`[name="${noteName}"]`);
                    const hasFile = !!fileInput?.files?.length;
                    const hasNote = !!noteInput?.value?.trim();

                    if (hasFile && hasNote) {
                        completed += 1;
                        return;
                    }

                    const parts = [];
                    if (!hasFile) parts.push('foto');
                    if (!hasNote) parts.push('keterangan');
                    missing.push(`${label} (${parts.join(' + ')})`);
                });

                return {
                    complete: missing.length === 0,
                    completed,
                    total: interiorUploadConfigs.length,
                    missing
                };
            }

            function updateInteriorCompletion() {
                const form = getInteriorForm();
                const submitButton = document.getElementById('btn-submit-interior');
                if (!form) return { complete: false };

                const state = getInteriorCompletion(form);
                if (submitButton) submitButton.disabled = interiorAutoProcessing;

                if (!state.complete) {
                    updateInteriorRealtimeStatus(
                        'Menunggu kelengkapan data...',
                        `${state.completed}/${state.total} bagian lengkap. Belum lengkap: ${state.missing.slice(0, 3).join(', ')}${state.missing.length > 3 ? ', ...' : ''}`,
                        (state.completed / state.total) * 100
                    );
                } else if (!interiorAutoProcessing) {
                    updateInteriorRealtimeStatus(
                        'Semua input sudah lengkap',
                        'Data lengkap. Klik Submit untuk memulai proses upload dan penyimpanan.',
                        0
                    );
                }

                return state;
            }

            function setUploadStatus(progressId, statusId, totalId, percent, message) {
                const progress = document.getElementById(progressId);
                const status = document.getElementById(statusId);
                const total = document.getElementById(totalId);
                const safePercent = Math.max(0, Math.min(100, Math.round(Number(percent) || 0)));

                if (progress) progress.value = safePercent;
                if (status) status.textContent = message || '';
                if (total) total.textContent = `${safePercent}%`;
            }

            function getUploadMessage(xhr) {
                const data = getResponseData(xhr, {});
                return data?.message_content || data?.message || data?.message_title || '';
            }

            function uploadInteriorFile(config, batch) {
                const [fileName, , progressId, statusId, totalId, label, url] = config;
                const form = getInteriorForm();
                const input = form?.querySelector(`[name="${fileName}"]`);
                const file = input?.files?.[0];

                if (!file) return Promise.reject(new Error(`${label}: foto belum dipilih.`));
                if (!file.type.startsWith('image/')) return Promise.reject(new Error(`${label}: file harus berupa gambar.`));

                const xhr = new XMLHttpRequest();
                let lastLoaded = 0;

                const promise = new Promise((resolve, reject) => {
                    xhr.upload.addEventListener('progress', event => {
                        if (!event.lengthComputable) return;
                        const percent = (event.loaded / event.total) * 100;
                        setUploadStatus(progressId, statusId, totalId, percent, `${label}: ${Math.round(percent)}% terupload...`);

                        const delta = Math.max(0, event.loaded - lastLoaded);
                        lastLoaded = event.loaded;
                        batch.loadedBytes += delta;
                        const overall = batch.totalBytes ? (batch.loadedBytes / batch.totalBytes) * 100 : 0;
                        updateInteriorRealtimeStatus(
                            `Mengupload ${label}...`,
                            `${batch.completed}/${batch.total} foto selesai`,
                            overall
                        );
                    });

                    xhr.addEventListener('load', () => {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            setUploadStatus(progressId, statusId, totalId, 100, `${label}: upload berhasil.`);
                            batch.loadedBytes += Math.max(0, file.size - lastLoaded);
                            batch.completed += 1;
                            updateInteriorRealtimeStatus(
                                `Upload ${label} selesai`,
                                `${batch.completed}/${batch.total} foto selesai`,
                                batch.totalBytes ? (batch.loadedBytes / batch.totalBytes) * 100 : 0
                            );
                            resolve(getUploadMessage(xhr) || 'Upload berhasil.');
                        } else {
                            setUploadStatus(progressId, statusId, totalId, 0, `${label}: upload gagal (HTTP ${xhr.status}).`);
                            reject(new Error(`${label}: upload gagal dengan HTTP ${xhr.status}.`));
                        }
                    });

                    xhr.addEventListener('error', () => reject(new Error(`${label}: koneksi upload gagal.`)));
                    xhr.addEventListener('timeout', () => reject(new Error(`${label}: upload timeout.`)));
                    xhr.addEventListener('abort', () => reject(new Error(`${label}: upload dibatalkan.`)));
                });

                xhr.open('POST', url, true);
                if (csrfToken) xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.timeout = 120000;

                const data = new FormData();
                data.append(input.name, file);
                pendingInteriorUploads.set(fileName, { xhr, promise });
                xhr.send(data);

                promise.then(
                    () => pendingInteriorUploads.delete(fileName),
                    () => pendingInteriorUploads.delete(fileName)
                );

                return promise;
            }

            async function processInteriorAutomatically(form) {
                if (interiorAutoProcessing) return;

                const completion = getInteriorCompletion(form);
                if (!completion.complete) {
                    updateInteriorCompletion();
                    return;
                }

                interiorAutoProcessing = true;
                setFormBusy(form, true);
                const submitButton = document.getElementById('btn-submit-interior');
                if (submitButton) submitButton.disabled = true;

                const files = interiorUploadConfigs.map(([fileName]) => form.querySelector(`[name="${fileName}"]`)?.files?.[0]);
                const batch = {
                    total: interiorUploadConfigs.length,
                    completed: 0,
                    loadedBytes: 0,
                    totalBytes: files.reduce((sum, file) => sum + (file?.size || 0), 0)
                };

                try {
                    showLoading('Memproses inspeksi interior...');
                    updateInteriorRealtimeStatus(
                        'Memulai upload foto...',
                        `0/${batch.total} foto selesai`,
                        0
                    );

                    for (const config of interiorUploadConfigs) {
                        await uploadInteriorFile(config, batch);
                    }

                    updateInteriorRealtimeStatus(
                        'Semua foto berhasil diupload',
                        'Menyimpan foto dan seluruh keterangan inspeksi...',
                        100
                    );
                    if (Swal.isVisible()) {
                        Swal.update({
                            title: 'Menyimpan inspeksi interior...',
                            html: '<div class="small text-muted">Semua input lengkap dan sedang disimpan ke server.</div>'
                        });
                    }

                    const result = await $.ajax({
                        type: 'POST',
                        url: inspectionForms['#upload-simpan-bagian-interior'].url,
                        data: new FormData(form),
                        contentType: false,
                        processData: false,
                        cache: false,
                        timeout: 120000
                    });

                    const data = typeof result === 'object' ? result : (safeJson(result) || {});
                    if (data.success === false) {
                        throw new Error(data.message_content || data.error || 'Data inspeksi interior tidak dapat disimpan.');
                    }

                    updateInteriorRealtimeStatus(
                        'Inspeksi interior berhasil disimpan',
                        'Semua foto dan keterangan telah tersimpan.',
                        100
                    );

                    Swal.fire({
                        icon: data.message_type || 'success',
                        title: data.message_title || 'Berhasil',
                        text: data.message_content || 'Data inspeksi interior berhasil disimpan.',
                        timer: 1400,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = inspectionForms['#upload-simpan-bagian-interior'].redirect;
                    });
                } catch (error) {
                    if (Swal.isVisible()) Swal.close();
                    showAlert({
                        icon: 'error',
                        title: 'Proses dihentikan',
                        text: error?.message || 'Upload atau penyimpanan inspeksi interior gagal.'
                    });
                    updateInteriorRealtimeStatus(
                        'Proses belum selesai',
                        error?.message || 'Periksa data dan coba lagi.',
                        0
                    );
                } finally {
                    interiorAutoProcessing = false;
                    setFormBusy(form, false);
                    updateInteriorCompletion();
                }
            }

            /* Submit bagian lain tetap menggunakan flow umum. Interior akan diproses otomatis. */
            Object.entries(inspectionForms).forEach(([selector, config]) => {
                $(selector).on('submit', function (event) {
                    event.preventDefault();
                    const form = this;

                    if (config.waitForUploads) {
                        const completion = getInteriorCompletion(form);
                        if (!completion.complete) {
                            showAlert({
                                icon: 'warning',
                                title: 'Data belum lengkap',
                                text: `Lengkapi semua foto dan keterangan terlebih dahulu. Bagian yang belum lengkap: ${completion.missing.join(', ')}.`
                            });
                            updateInteriorCompletion();
                            return;
                        }
                        processInteriorAutomatically(form);
                        return;
                    }

                    if (form.dataset.submitting === '1') return;
                    setFormBusy(form, true);
                    showLoading();

                    const formData = new FormData(form);
                    $.ajax({
                        type: 'POST',
                        url: config.url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        cache: false,
                        timeout: 120000,
                        success: function (result) {
                            const data = typeof result === 'object' ? result : (safeJson(result) || {});
                            if (data.success === false) {
                                showAlert({
                                    icon: data.message_type || 'error',
                                    title: data.message_title || 'Gagal',
                                    text: data.message_content || data.error || 'Data tidak dapat disimpan.'
                                });
                                return;
                            }

                            showAlert({
                                icon: data.message_type || 'success',
                                title: data.message_title || 'Berhasil',
                                text: data.message_content || 'Data inspeksi berhasil disimpan.',
                                timer: 1400
                            }).then(() => {
                                if (config.redirect === 'reload') window.location.reload();
                                else window.location.href = config.redirect;
                            });
                        },
                        error: function (request) {
                            const data = getResponseData(request, {});
                            showAlert({
                                icon: 'error',
                                title: request.status === 422 ? 'Validasi gagal' : 'Terjadi kesalahan',
                                text: getFirstValidationError(data.errors) || data.message || data.error || `Gagal menyimpan data (HTTP ${request.status || 'unknown'}).`
                            });
                        },
                        complete: function () {
                            setFormBusy(form, false);
                        }
                    });
                });
            });

            const interiorForm = getInteriorForm();
            if (interiorForm) {
                // Hanya memantau perubahan. TIDAK ada upload saat satu field berubah.
                interiorUploadConfigs.forEach(([fileName, noteName]) => {
                    const fileInput = interiorForm.querySelector(`[name="${fileName}"]`);
                    const noteInput = interiorForm.querySelector(`[name="${noteName}"]`);
                    [fileInput, noteInput].forEach(input => {
                        if (!input) return;
                        input.addEventListener('input', updateInteriorCompletion);
                        input.addEventListener('change', updateInteriorCompletion);
                    });
                });

                updateInteriorCompletion();

                // Tidak ada proses otomatis saat input berubah. Proses hanya dimulai setelah tombol Submit diklik.
            }
        });
    </script>
@endsection
