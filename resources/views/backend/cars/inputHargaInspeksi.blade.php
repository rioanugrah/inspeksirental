@extends('layouts.backend.master')
@php
    $plat_nomor = explode('-', $car->plat_nomor);
@endphp
@section('title')
    Harga Inspeksi - {{ $plat_nomor[0] . ' ' . $plat_nomor[1] . ' ' . $plat_nomor[2] }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Harga Inspeksi</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Kendaraan</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">No. Reference</label>
                                <div>{{ $car->no_reference }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Plat Nomor</label>
                                <div>{{ $plat_nomor[0] . ' ' . $plat_nomor[1] . ' ' . $plat_nomor[2] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Warna Mobil</label>
                                <div>{{ $car->warna }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Merk Mobil</label>
                                <div>{{ $car->merk }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Model Mobil</label>
                                <div>{{ $car->model }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">No. Rangka</label>
                                <div>{{ $car->no_rangka }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Transmisi</label>
                                <div>{{ $car->transmisi }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Status Kendaraan</label>
                                <div>{{ $car->status }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
