@extends('layouts.backend.master')

@section('title')
    Mulai Inspeksi
@endsection

@section('content')
<div class="row" style="margin-top: 3%">
    <div class="col">
        <div class="card">
            <div class="card-body p-0">
                <h6 class="card-title border-bottom p-3 mb-0 header-title">DETAIL IDENTITAS KENDARAAN</h6>
                <div class="row py-1">
                    <div class="col-xl-6 col-sm-6">
                        <div class="d-flex p-3">
                            <input type="image" src="{{ asset('backend/assets/images/mobil_images/mb.webp') }}" width="500" height="250" alt="">
                        </div>
                    </div>

                    <div class="col-xl-6 col-sm-6">
                        <div class="row">
                            <div class="d-flex p-1">
                                <i data-feather="check-square" class="align-self-center icon-dual icon-lg me-1"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mt-0 mb-0">Model</h4>
                                    <span class="text-muted">-</span>
                                </div>
                            </div>
                            <div class="d-flex p-2">
                                <i data-feather="check-square" class="align-self-center icon-dual icon-lg me-1"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mt-0 mb-0">Merk</h4>
                                    <span class="text-muted">-</span>
                                </div>
                            </div>
                            <div class="d-flex p-2">
                                <i data-feather="check-square" class="align-self-center icon-dual icon-lg me-1"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mt-0 mb-0">Warna</h4>
                                    <span class="text-muted">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex p-1">
                                <i data-feather="check-square" class="align-self-center icon-dual icon-lg me-1"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mt-0 mb-0">Tahun</h4>
                                    <span class="text-muted">-</span>
                                </div>
                            </div>
                            <div class="d-flex p-2">
                                <i data-feather="check-square" class="align-self-center icon-dual icon-lg me-1"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mt-0 mb-0">Nomor Rangka</h4>
                                    <span class="text-muted">-</span>
                                </div>
                            </div>
                            <div class="d-flex p-2">
                                <i data-feather="check-square" class="align-self-center icon-dual icon-lg me-1"></i>
                                <div class="flex-grow-1">
                                    <h4 class="mt-0 mb-0">Transmisi</h4>
                                    <span class="text-muted">-</span>
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
<div class="row">
    <div class="card">
        <div class="card-body p-0">
            <h6 class="card-title border-bottom p-3 mb-0 header-title">FORM INSPEKSI</h6>
        </div>     
        <form method="post" id="upload-simpan" enctype="multipart/form-data">
                @csrf
                
                <div class="card">
                    <span style="font-size: 12pt" class="badge bg-warning">Pengecekan Bagian Depan</span>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Kaca Depan</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Kap Mesin</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Rangka Mobil</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Kaki</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Radiator</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Kondisi Mesin</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Bumper dan Lampu</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <span style="font-size: 12pt" class="badge bg-warning">Pengecekan Bagian Kiri</span>
                             <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Radiator</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Kondisi Mesin</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Bumper dan Lampu</label><br>
                                        <button type="button" class="btn btn-primary btn-sm me-1">Baik <i data-feather="thumbs-up"></i> </button>
                                        <button type="button" class="btn btn-white btn-sm me-1 dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                        Tidak/Rusak  <i data-feather="thumbs-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                                            <div class="p-1">
                                                <input type="file" name="foto_stnk" class="form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </div>
</div>
<!--End Form-->
@endsection
