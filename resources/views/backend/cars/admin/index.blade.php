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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-bo">
                            <div class="button-list mt-1 mb-1">
                                <a href="{{ route('cars.create') }}" class="btn btn-primary btn-rounded"><i class="uil-plus"></i> Buat Baru</a>
                                <a href="javascript:void(0)" onclick="reload()" class="btn btn-primary btn-rounded"><i class="uil-refresh"></i> Reload</a>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($cars as $car)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
