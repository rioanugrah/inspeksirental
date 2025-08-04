@extends('layouts.backend.master')
@section('title')
    Laporan Keuangan
@endsection

@section('css')
    <style>
        tr:nth-child(even) {
            background-color: rgba(0, 99, 248, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="modal" id="modalExportPDF" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Download Export PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('lap_keuangan.export_pdf') }}" method="get" target="_blank">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Tahun</label>
                                    <select name="years" class="form-control">
                                        <option value="">-- Pilih Tahun --</option>
                                        @for ($i = 2023; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Bulan</label>
                                <select name="month" class="form-control">
                                    <option value="">-- Pilih Bulan --</option>
                                    @for ($i = 01; $i <= 12; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="modalExportExcel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Download Export Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('lap_keuangan.export_pdf') }}" method="get" target="_blank">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Tahun</label>
                                    <select name="years" class="form-control">
                                        <option value="">-- Pilih Tahun --</option>
                                        @for ($i = 2023; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Bulan</label>
                                <select name="month" class="form-control">
                                    <option value="">-- Pilih Bulan --</option>
                                    @for ($i = 01; $i <= 12; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Laporan Keuangan</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="button-list mt-1 mb-1">
                        {{-- @can('Mobil Create')
                            <a href="{{ route('cars.create') }}" class="btn btn-primary btn-rounded"><i class="uil-plus"></i>
                                Buat Baru</a>
                        @endcan
                        <a href="javascript:void(0)" onclick="reload()" class="btn btn-primary btn-rounded"><i
                                class="uil-refresh"></i> Reload</a> --}}
                    </div>
                    <div>Filter:</div>
                    <div class="row">
                        <div class="col-md-4">
                            <form action="{{ route('lap_keuangan.cari_data') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="years" class="form-control">
                                            <option value="">-- Pilih Tahun --</option>
                                            @for ($i = 2023; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="month" class="form-control">
                                            <option value="">-- Pilih Bulan --</option>
                                            @for ($i = 01; $i <= 12; $i++)
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
                        <div class="col-md-4">
                            <button onclick="modalExportExcel()" class="btn btn-success">Export Excel</button>
                            <button onclick="modalExportPDF()" class="btn btn-danger">Export PDF</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">No.Ref</th>
                                    <th class="text-center">Plat Nomor</th>
                                    <th class="text-center">Merek</th>
                                    <th class="text-center">Harga Inspeksi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Dibuat Tanggal</th>
                                </tr>
                            </thead>
                            @php
                                $total = [];
                            @endphp
                            <tbody>
                                @forelse ($cars as $key => $car)
                                    @php
                                        array_push($total, $car->price);
                                        $plat_nomor = explode('-',$car->plat_nomor);
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">{{ $car->no_reference }}</td>
                                        <td class="text-center">{{ $plat_nomor[0].' '.$plat_nomor[1].' '.$plat_nomor[2] }}</td>
                                        <td class="text-center">{{ $car->merek }}</td>
                                        <td>
                                            @if (empty($car->price))
                                                <div class="text-center">
                                                    <span class="text-danger">Harga Belum Diinput</span>
                                                </div>
                                            @else
                                                <div style="text-align: right">
                                                    {{ 'Rp. ' . number_format($car->price, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @switch($car->status)
                                                @case('Waiting')
                                                    <span class="badge bg-warning">Menunggu Inspeksi</span>
                                                @break

                                                @case('Proses')
                                                    <span class="badge bg-info">Proses Inspeksi</span>
                                                @break

                                                @case('Selesai')
                                                    <span class="badge bg-success">Selesai</span>
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td class="text-center">{{ $car->created_at }}</td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right; font-weight: bold">Total</td>
                                        <td style="text-align: right; font-weight: bold">
                                            {{ 'Rp. ' . number_format(array_sum($total), 0, ',', '.') }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- {{ $cars->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            function modalExportPDF() {
                $('#modalExportPDF').modal('show');
            }

            function modalExportExcel() {
                $('#modalExportExcel').modal('show');
            }
        </script>
    @endsection
