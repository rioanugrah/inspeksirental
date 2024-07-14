@extends('layouts.backend.master')

@section('title')
    Mulai Inspeksi
@endsection

@section('css')
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
                                width="100%" height="85%">
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
        <form method="post" id="upload-simpan" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
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
                                        <label>Kaki</label>
                                        <div class="input-group-btn" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="kaki" value="Baik" id="kaki1"
                                                    autocomplete="off"><i data-feather="thumbs-up"></i> Baik
                                            </label>
                                            <label class="btn btn-white">
                                                <input type="radio" name="kaki" value="Rusak" id="kaki2"
                                                    autocomplete="off"><i data-feather="thumbs-down"></i> Tidak/Rusak
                                            </label>
                                        </div>
                                        <div id="view_kaki"></div>
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
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="window.location.href='{{ route('cars') }}'" class="btn btn-secondary">Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <!--End Form-->
@endsection

@section('script')
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
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

        $('input[type=radio][name=kaki]').on('change',function(){
            if (this.value == 'Rusak') {
                document.getElementById('view_kaki').innerHTML = '<div class="mt-2 mb-2">'+
                                                                            '<label>Bukti Foto Kaki" Mobil</label>'+
                                                                            '<input type="file" name="foto_kaki" class="form-control">'+
                                                                        '</div>';
            }else{
                document.getElementById('view_kaki').innerHTML = null;
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

        $('#upload-simpan').submit(function(e) {
            // alert('coba');
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.simpan_inspeksi',['id' => $car->id]) }}",
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
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
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
