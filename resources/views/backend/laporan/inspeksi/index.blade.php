@extends('layouts.backend.master')
@section('title')
    Laporan Inspeksi
@endsection
@section('css')
    <style>
        tr:nth-child(even) {
            background-color: rgba(0, 99, 248, 0.1);
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Laporan Inspeksi</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>Filter:</div>
                    <div class="row">
                        <div class="col-md-4">
                            <form action="{{ route('lap_inspeksi.cari_data') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="years" class="form-control">
                                            <option value="">-- Pilih Tahun --</option>
                                            <option value="all">All</option>
                                            @for ($i = 2023; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-info">Cari Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Total Inspeksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = [];
                                @endphp
                                @foreach ($periods as $key => $period)
                                    @php
                                        array_push($total,$period['total_cars']);
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::create($period['date'])->isoFormat('MMMM YYYY') }}</td>
                                        <td class="text-center">{{ $period['total_cars'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="font-weight: bold; text-align: right">Total Inspeksi</td>
                                    <td class="text-center" style="font-weight: bold">{{ array_sum($total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
