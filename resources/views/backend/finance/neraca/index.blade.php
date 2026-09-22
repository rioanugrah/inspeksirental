@extends('layouts.backend.master')
@section('title')
    Finance - Neraca
@endsection
@section('content')
    @include('backend.finance.neraca.modalLaporanBulanan')
    @include('backend.finance.neraca.modalLaporanTahunan')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Neraca</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title">Neraca</h4> --}}
                    {{-- <form method="GET" action="{{ route('finance.neraca.report_period') }}" class="col-md-4" target="_blank">
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
                    <div class="table-responsive">
                        <table class="table">
                            <thead style="background-color: #5996FF; color: white">
                                <tr>
                                    <th colspan="5" class="text-uppercase text-center">Afkar Mobil</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-uppercase text-center fs-3">Laporan Posisi Keuangan
                                        (Neraca)</th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-uppercase text-center">Periode : {{ date('Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-uppercase fw-bold">Aktiva Lancar</td>
                                    <td></td>
                                    <td class="text-uppercase fw-bold">Kewajiban Lancar</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[0]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[0]['aktiva_lancar']) }}
                                    </td>
                                    <td>{{ $hasilNeracaLajurs[11]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[11]['kewajiban_lancar']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[1]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[1]['aktiva_lancar']) }}
                                    </td>
                                    <td>{{ $hasilNeracaLajurs[12]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[12]['kewajiban_lancar']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[2]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[2]['aktiva_lancar']) }}
                                    </td>
                                    <td>{{ $hasilNeracaLajurs[13]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[13]['kewajiban_lancar']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[3]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[3]['aktiva_lancar']) }}
                                    </td>
                                    <td>{{ $hasilNeracaLajurs[14]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[14]['kewajiban_lancar']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[4]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[4]['aktiva_lancar']) }}
                                    </td>
                                    <td>{{ $hasilNeracaLajurs[15]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[15]['kewajiban_lancar']) }}
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[5]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. '.number_format($hasilNeracaLajurs[5]['aktiva_lancar']) }}
                                    </td>
                                    <td>{{ $hasilNeracaLajurs[31]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. '.number_format($hasilNeracaLajurs[32]['kewajiban_lancar']) }}
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[6]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[6]['aktiva_lancar']) }}
                                    </td>
                                    <td class="fw-bold">{{ $hasilNeracaLajurs[16]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[16]['modal_dasar_kewajiban_lancar']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[7]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[7]['aktiva_lancar']) }}
                                    </td>
                                    <td class="fw-bold">{{ $hasilNeracaLajurs[17]['item'] }}</td>
                                    <td class="text-end">
                                        {{-- {{ 'Rp. ' . number_format($modal_dasar_kewajiban_lancar) }} --}}
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[17]['modal_tambahan_kewajiban_lancar']) }}
                                        {{-- {{ 'Rp. ' . number_format($modal_tambahan_kewajiban_lancar) }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[8]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[8]['aktiva_lancar']) }}
                                    </td>
                                    <td class="fw-bold">{{ $hasilNeracaLajurs[18]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($laba_bulan_setelah_pjk_kewajiban_lancar) }}
                                        {{-- {{ 'Rp. ' . number_format($hasilNeracaLajurs[18]['laba_bulan_berjalan_setelah_pjk_kewajiban_lancar']) }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[9]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[9]['aktiva_lancar']) }}
                                    </td>
                                    <td class="fw-bold">{{ $hasilNeracaLajurs[19]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[19]['laba_ditahan']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-uppercase fw-bold" colspan="2">Aktiva Tetap</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $hasilNeracaLajurs[10]['item'] }}</td>
                                    <td class="text-end">
                                        {{ 'Rp. ' . number_format($hasilNeracaLajurs[10]['aktiva_lancar']) }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                @php
                                    $totalAktivaLancar =
                                        $hasilNeracaLajurs[0]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[1]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[2]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[3]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[4]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[5]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[6]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[7]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[8]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[9]['aktiva_lancar'] +
                                        $hasilNeracaLajurs[10]['aktiva_lancar'];

                                    $totalKewajibanLancar =
                                        $hasilNeracaLajurs[11]['kewajiban_lancar'] +
                                        $hasilNeracaLajurs[12]['kewajiban_lancar'] +
                                        $hasilNeracaLajurs[13]['kewajiban_lancar'] +
                                        $hasilNeracaLajurs[14]['kewajiban_lancar'] +
                                        $hasilNeracaLajurs[15]['kewajiban_lancar'] +
                                        $hasilNeracaLajurs[16]['kewajiban_lancar'] +
                                        $hasilNeracaLajurs[17]['kewajiban_lancar'] +
                                        // $modal_dasar_kewajiban_lancar +
                                        $hasilNeracaLajurs[18]['modal_tambahan_kewajiban_lancar'] +
                                        // $modal_tambahan_kewajiban_lancar +
                                        $laba_bulan_setelah_pjk_kewajiban_lancar +
                                        $hasilNeracaLajurs[19]['kewajiban_lancar'] +
                                        $hasilNeracaLajurs[31]['kewajiban_lancar'];
                                @endphp
                                <tr>
                                    <td colspan="2" class="text-uppercase fw-bold">Total Aktiva</td>
                                    <td class="text-end">{{ 'Rp. ' . number_format($totalAktivaLancar, 2, ',', '.') }}</td>
                                    <td class="text-uppercase fw-bold">Total Kewajiban dan Ekuitas</td>
                                    <td class="text-end">{{ 'Rp. ' . number_format($totalKewajibanLancar, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    {{-- <td colspan="5" class="text-center fw-bold text-uppercase {{ $totalAktivaLancar == $totalKewajibanLancar ? 'text-success' : 'text-danger' }}">
                                        {{ $totalAktivaLancar == $totalKewajibanLancar ? 'Balance' : 'Tidak Balance' }}
                                    </td> --}}
                                    <td colspan="5" class="text-center">
                                        <span
                                            class="badge {{ $totalAktivaLancar == $totalKewajibanLancar ? 'bg-success' : 'bg-danger' }} fs-6">
                                            @if ($totalAktivaLancar == $totalKewajibanLancar)
                                                Status Perhitungan : SEIMBANG
                                            @else
                                                Status Perhitungan : TIDAK SEIMBANG (Selisih :
                                                {{ 'Rp. ' . number_format($totalAktivaLancar - $totalKewajibanLancar, 2, ',', '.') }})
                                            @endif
                                        </span>
                                    </td>
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