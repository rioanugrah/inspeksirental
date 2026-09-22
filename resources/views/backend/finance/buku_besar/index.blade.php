@extends('layouts.backend.master')
@section('title')
    Finance - Buku Besar
@endsection

@section('css')

@endsection

@section('content')
    @include('backend.finance.buku_besar.modalLaporanBulanan')
    @include('backend.finance.buku_besar.modalLaporanTahunan')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Buku Besar</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Buku Besar</h4>
                    <div class="mb-2">Note : Kode COA ini tidak bisa diubah / dihapus.</div>
                    <div class="mb-2">
                        <a href="javascript:void(0)" onclick="downloadLaporanBulananPdf()" class="btn btn-success"><i class="uil-download-alt"></i> Download Rekap Bulanan</a>
                        <a href="javascript:void(0)" onclick="downloadLaporanTahunanPdf()" class="btn btn-success"><i class="uil-download-alt"></i> Download Rekap Tahunan</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped table-hover" id="datatable">
                            <thead style="background-color: #5996FF; color: white">
                                <tr>
                                    <th colspan="7" class="text-center">Buku Besar</th>
                                    <th colspan="2" class="text-center">Neraca Saldo</th>
                                </tr>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode Coa</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">S. A. Debit</th>
                                    <th class="text-center">S. A. Credit</th>
                                    <th class="text-center">Debit</th>
                                    <th class="text-center">Credit</th>
                                    <th class="text-center">Saldo Debit</th>
                                    <th class="text-center">Saldo Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasilBukuBesar as $key => $bukuBesar)
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td class="text-center fw-bold">{{ $bukuBesar['code'] }}</td>
                                        <td class="fw-bold">{{ $bukuBesar['item'] }}</td>
                                        <td class="text-end">{{ 'Rp. '.number_format($bukuBesar['sa_debit'],2,',','.') }}</td>
                                        <td class="text-end">{{ 'Rp. '.number_format($bukuBesar['sa_credit'],2,',','.') }}</td>
                                        <td class="text-end">{{ 'Rp. '.number_format($bukuBesar['debit'],2,',','.') }}</td>
                                        <td class="text-end">{{ 'Rp. '.number_format($bukuBesar['credit'],2,',','.') }}</td>
                                        <td class="text-end">{{ 'Rp. '.number_format($bukuBesar['neraca_debit'],2,',','.') }}</td>
                                        <td class="text-end">{{ 'Rp. '.number_format($bukuBesar['neraca_credit'],2,',','.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">Total</th>
                                    <th class="text-end">{{ 'Rp. '.number_format($totalSaDebit,2,',','.') }}</th>
                                    <th class="text-end">{{ 'Rp. '.number_format($totalSaCredit,2,',','.') }}</th>
                                    <th class="text-end">{{ 'Rp. '.number_format($totalDebit,2,',','.') }}</th>
                                    <th class="text-end">{{ 'Rp. '.number_format($totalCredit,2,',','.') }}</th>
                                    <th class="text-end">{{ 'Rp. '.number_format($totalNeracaDebit,2,',','.') }}</th>
                                    <th class="text-end">{{ 'Rp. '.number_format($totalNeracaCredit,2,',','.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-center">Total Laba Bersih Utama</th>
                                    <th colspan="2" class="text-center"><i>Penyeimbang Laba Bersih</i></th>
                                    <th class="text-end">{{ 'Rp. '.number_format($totalCredit-$totalDebit,2,',','.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function downloadLaporanBulananPdf() {
            $('#modalLaporanBulanan').modal('show');
        }
        function downloadLaporanTahunanPdf() {
            $('#modalLaporanTahunan').modal('show');
        }
    </script>
@endsection