<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Posisi Keuangan Neraca Afkar Mobil Periode {{ $_GET['periode'] }}</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif
        }

        table {
            width: 100%
        }

        td {
            padding-top: 1%;
            padding-bottom: 1%;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 47%;
            padding: 10px;
            /* height: 300px; */
            /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <table style="margin-bottom: 5%">
        <thead>
            <tr>
                <th style="text-align: center">Laporan Posisi Keuangan (Neraca)</th>
            </tr>
            <tr>
                <th style="text-align: center">Periode : 2026</th>
            </tr>
            <tr>
                <th style="text-align: center">Afkar Mobil</th>
            </tr>
        </thead>
    </table>
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
            // $hasilNeracaLajurs[16]['kewajiban_lancar'] +
            $hasilNeracaLajurs[16]['modal_dasar_kewajiban_lancar'] +
            // $hasilNeracaLajurs[17]['kewajiban_lancar'] +
            $hasilNeracaLajurs[17]['modal_tambahan_kewajiban_lancar'] +
            // $modal_dasar_kewajiban_lancar +
            // $hasilNeracaLajurs[18]['kewajiban_lancar'] +
            // $hasilNeracaLajurs[18]['modal_tambahan_kewajiban_lancar'] +
            // $modal_tambahan_kewajiban_lancar +
            $laba_bulan_setelah_pjk_kewajiban_lancar +
            // $hasilNeracaLajurs[19]['kewajiban_lancar'] +
            $hasilNeracaLajurs[19]['laba_ditahan'] +
            $hasilNeracaLajurs[31]['kewajiban_lancar'];
    @endphp
    <div class="row">
        <div class="column" style="background-color:#fff;">
            <table style="font-size: 10pt">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-uppercase fw-bold">Aktiva Lancar</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[0]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[0]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[1]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[1]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[2]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[2]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[3]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[3]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[4]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[4]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[6]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[6]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[7]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[7]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[8]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[8]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[9]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[9]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-uppercase fw-bold" colspan="2">Aktiva Tetap</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $hasilNeracaLajurs[10]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[10]['aktiva_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-uppercase fw-bold">Total Aktiva</td>
                        <td class="text-end">{{ 'Rp. ' . number_format($totalAktivaLancar, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="column" style="background-color:#fff;">
            <table style="font-size: 10pt">
                <tbody>
                    <tr>
                        <td class="text-uppercase fw-bold">Kewajiban Lancar</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{ $hasilNeracaLajurs[11]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[11]['kewajiban_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $hasilNeracaLajurs[12]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[12]['kewajiban_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $hasilNeracaLajurs[13]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[13]['kewajiban_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $hasilNeracaLajurs[14]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[14]['kewajiban_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $hasilNeracaLajurs[15]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[15]['kewajiban_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">{{ $hasilNeracaLajurs[16]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[16]['modal_dasar_kewajiban_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">{{ $hasilNeracaLajurs[17]['item'] }}</td>
                        <td class="text-end">
                            {{-- {{ 'Rp. ' . number_format($modal_tambahan_kewajiban_lancar,2,',','.') }} --}}
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[17]['modal_tambahan_kewajiban_lancar'], 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">{{ $hasilNeracaLajurs[18]['item'] }}</td>
                        <td class="text-end">
                            {{ 'Rp. ' . number_format($laba_bulan_setelah_pjk_kewajiban_lancar,2,',','.') }}
                            {{-- {{ 'Rp. ' . number_format($hasilNeracaLajurs[18]['laba_bulan_berjalan_setelah_pjk_kewajiban_lancar'], 2, ',', '.') }} --}}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">{{ $hasilNeracaLajurs[19]['item'] }}</td>
                        <td class="text-end">
                            {{-- {{ 'Rp. ' . number_format($hasilNeracaLajurs[19]['kewajiban_lancar'], 2, ',', '.') }} --}}
                            {{ 'Rp. ' . number_format($hasilNeracaLajurs[19]['laba_ditahan'],2,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-uppercase fw-bold">Total Kewajiban dan Ekuitas</td>
                        <td class="text-end">{{ 'Rp. ' . number_format($totalKewajibanLancar, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <table>
        <tr>
            <td class="text-center">
                <span>
                    @if ($totalAktivaLancar == $totalKewajibanLancar)
                        Status Perhitungan : SEIMBANG
                    @else
                        Status Perhitungan : TIDAK SEIMBANG (Selisih :
                        {{ 'Rp. ' . number_format($totalAktivaLancar - $totalKewajibanLancar, 2, ',', '.') }})
                    @endif
                </span>
            </td>
        </tr>
    </table>

    {{-- <table>
        <tbody>
            <tr>
                <td colspan="2" class="text-uppercase fw-bold">Aktiva Lancar</td>
                <td></td>
                <td class="text-uppercase fw-bold">Kewajiban Lancar</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[0]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[0]['aktiva_lancar']) }}
                </td>
                <td>{{ $hasilNeracaLajurs[11]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[11]['kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[1]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[1]['aktiva_lancar']) }}
                </td>
                <td>{{ $hasilNeracaLajurs[12]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[12]['kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[2]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[2]['aktiva_lancar']) }}
                </td>
                <td>{{ $hasilNeracaLajurs[13]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[13]['kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[3]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[3]['aktiva_lancar']) }}
                </td>
                <td>{{ $hasilNeracaLajurs[14]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[14]['kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[4]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[4]['aktiva_lancar']) }}
                </td>
                <td>{{ $hasilNeracaLajurs[15]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[15]['kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[6]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[6]['aktiva_lancar']) }}
                </td>
                <td class="fw-bold">{{ $hasilNeracaLajurs[16]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[16]['modal_dasar_kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[7]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[7]['aktiva_lancar']) }}
                </td>
                <td class="fw-bold">{{ $hasilNeracaLajurs[17]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[17]['modal_tambahan_kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[8]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[8]['aktiva_lancar']) }}
                </td>
                <td class="fw-bold">{{ $hasilNeracaLajurs[18]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[18]['laba_bulan_berjalan_setelah_pjk_kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[9]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[9]['aktiva_lancar']) }}
                </td>
                <td class="fw-bold">{{ $hasilNeracaLajurs[19]['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajurs[19]['kewajiban_lancar']) }}
                </td>
            </tr>
            <tr>
                <td class="text-uppercase fw-bold" colspan="2">Aktiva Tetap</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">{{ $hasilNeracaLajurs[10]['item'] }}</td>
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
                    $hasilNeracaLajurs[18]['kewajiban_lancar'] +
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
    </table> --}}
</body>

</html>
