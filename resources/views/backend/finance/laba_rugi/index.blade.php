@extends('layouts.backend.master')
@section('title')
    Finance - Laba Rugi
@endsection

@section('content')
    @include('backend.finance.laba_rugi.modalLaporanBulanan')
    @include('backend.finance.laba_rugi.modalLaporanTahunan')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Laba Rugi</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title">Laba Rugi</h4> --}}
                    {{-- <form method="GET" action="{{ route('finance.laba_rugi.report_period') }}" class="col-md-4" target="_blank">
                        <div class="input-group mb-3">
                            <input type="number" name="periode" class="form-control" placeholder="Periode"
                                aria-label="Periode" aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Download Rekap PDF</button>
                        </div>
                    </form> --}}
                    <div class="mb-2">
                        <a href="javascript:void(0)" onclick="downloadLaporanBulananPdf()" class="btn btn-success"><i class="uil-download-alt"></i> Download Rekap Bulanan</a>
                        <a href="javascript:void(0)" onclick="downloadLaporanTahunanPdf()" class="btn btn-success"><i class="uil-download-alt"></i> Download Rekap Tahunan</a>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead style="background-color: #5996FF; color: white">
                            <tr>
                                <th class="text-center" colspan="5">Afkar Mobil</th>
                            </tr>
                            <tr>
                                <th class="text-center fs-3" colspan="5">LAPORAN LABA RUGI</th>
                            </tr>
                            <tr>
                                <th class="text-center" colspan="5">Periode : {{ date('Y') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-uppercase" colspan="5">Pendapatan :</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">{{ $hasilNeracaLajurs[20]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($pendapatan_jasa_inspeksi,2,',','.') }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">{{ $hasilNeracaLajurs[21]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($pendapatan_jasa_giro,2,',','.') }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">{{ $hasilNeracaLajurs[22]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($pendapatan_jasa_lain,2,',','.') }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3">Total</td>
                                <td class="text-end fw-bold">{{ 'Rp. '.number_format($total_pendapatan,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-uppercase" colspan="5">Beban Langsung Operasional :</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[23]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_akomodasi,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[24]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_internet,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[25]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_website,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[26]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_telepon,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[27]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_percetakan,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[28]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_marketing,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[29]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_transportasi,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[30]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($beban_operational_lain,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[31]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($biaya_gaji,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[32]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($biaya_admin,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[33]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($biaya_sewa,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ $hasilNeracaLajurs[34]['item'] }}</td>
                                <td class="text-end">{{ 'Rp. '.number_format($biaya_lain_lain,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="fw-bold text-uppercase text-center">Total Biaya Operational Langsung</td>
                                <td class="text-end fw-bold">{{ 'Rp. '.number_format($total_beban_langsung,2,',','.') }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-end text-uppercase fw-bold" colspan="4">Laba / Rugi</td>
                                <td class="text-end fw-bold {{ $hasil_laba_rugi >= 0 ? null : 'text-danger' }}">{{ 'Rp. '.number_format($hasil_laba_rugi,2,',','.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
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