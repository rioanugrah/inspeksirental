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
@endsection
