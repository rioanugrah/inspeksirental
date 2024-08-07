@extends('layouts.backend.master')
@section('title')
    Detail Inspeksi - {{ $car->plat_nomor }}
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
                </div>
            </a>
            <div id="collapseOne" class="collapse"
                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="card-body">
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
                                                width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_depan->keterangan_kaca_depan }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_depan->keterangan_kap_mesin }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_depan->keterangan_rangka_mobil }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_depan->keterangan_aki }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_depan->keterangan_radiator }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_depan->keterangan_kondisi_mesin }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_depan->keterangan_bumper_lampu }}</div>
                                        @break

                                        @default
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="window.location.href='{{ route('cars.edit_inspeksi_depan',['id' => $car->id, 'inspeksi_depan' => $car->detail_inspeksi_depan->id]) }}'" class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
                    </div>
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
                    {!! $car->detail_inspeksi_kiri ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>' : null !!}
                </div>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="card-body">
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_kiri->keterangan_fender_depan_kiri }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_kiri->keterangan_kaki_depan_kiri }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_kiri->kaki_belakang_kiri }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_kiri->keterangan_pintu_depan_kiri }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_kiri->keterangan_pintu_belakang_kiri }}</div>
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
                                            <div style="font-weight: bold">Keterangan</div>
                                            <div>{{ $car->detail_inspeksi_kiri->keterangan_fender_belakang_kiri }}</div>
                                        @break

                                        @default
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="window.location.href='{{ route('cars.edit_inspeksi_kiri',['id' => $car->id, 'inspeksi_kiri' => $car->detail_inspeksi_kiri->id]) }}'" class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
                    </div>
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
                </div>
            </a>

            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_belakang->keterangan_lampu_belakang }}</div>
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_belakang->keterangan_pintu_bagasi_belakang }}</div>
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_belakang->keterangan_bumper_belakang }}</div>
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="window.location.href='{{ route('cars.edit_inspeksi_belakang',['id' => $car->id, 'inspeksi_belakang' => $car->detail_inspeksi_belakang->id]) }}'" class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
                        </div>
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
                    {!! $car->detail_inspeksi_kanan ? '<i class="uil-check text-success"></i> <span class="badge bg-success">Verified</span>' : null !!}
                </div>
            </a>

            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_kanan->keterangan_fender_depan_kanan }}</div>
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_kanan->keterangan_kaki_depan_kanan }}</div>
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_kanan->keterangan_kaki_belakang_kanan }}</div>
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_kanan->keterangan_pintu_depan_kanan }}</div>
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_kanan->keterangan_pintu_belakang_kanan }}</div>
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
                                                <div style="font-weight: bold">Keterangan</div>
                                                <div>{{ $car->detail_inspeksi_kanan->keterangan_fender_belakang_kanan }}</div>
                                            @break

                                            @default
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="window.location.href='{{ route('cars.edit_inspeksi_kanan',['id' => $car->id, 'inspeksi_kanan' => $car->detail_inspeksi_kanan->id]) }}'" class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
                        </div>
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

            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
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
                            <button type="button" onclick="window.location.href='{{ route('cars.edit_inspeksi_interior',['id' => $car->id, 'inspeksi_interior' => $car->detail_inspeksi_interior->id]) }}'" class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
                        </div>
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
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                <div class="card-body">
                    @if ($car->detail_inspeksi_lain)
                    <div class="row">
                        @foreach (json_decode($car->detail_inspeksi_lain->body) as $key_lain => $detail_inspeksi_lain)
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Foto {{ $key_lain+1 }}</label>
                                    <img src="{{ asset('backend/mobil/' . $car->plat_nomor . '/berkas/pengecekkan_bagian_lain/' . $detail_inspeksi_lain->foto_lain_lain) }}"
                                        width="100%" style="width: 250px; height: 250px; object-fit: cover;">
                                    <div>Keterangan {{ $key_lain+1 }}</div>
                                    <div>{!! $detail_inspeksi_lain->keterangan_lain_lain !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="window.location.href='{{ route('cars.edit_inspeksi_lain',['id' => $car->id, 'inspeksi_lain' => $car->detail_inspeksi_lain->id]) }}'" class="btn btn-warning"><i class="bi-pencil-square"></i> Edit</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection