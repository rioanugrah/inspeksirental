<title>Laporan Laba Rugi Keuangan Afkar Mobil Periode {{ $_GET['year'] }}</title>
<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    table,
    td,
    th {
        border: 1px solid;
        padding: 10px;
        font-size: 11pt;
    }

    th {
        background-color: #FED24F;
        color: black;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .fw-bold {
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .text-end {
        text-align: right;
    }
</style>
<div class="fw-bold text-center">Laporan Laba Rugi Keuangan Afkar Mobil</div>
<div class="fw-bold text-center">Periode : {{ $_GET['year'] }}</div>

<table>
    <thead>
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
            <td class="text-end">{{ 'Rp. ' . number_format($pendapatan_jasa_inspeksi, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">{{ $hasilNeracaLajurs[21]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($pendapatan_jasa_giro, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">{{ $hasilNeracaLajurs[22]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($pendapatan_jasa_lain, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">Total</td>
            <td class="text-end fw-bold">{{ 'Rp. ' . number_format($total_pendapatan, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="fw-bold text-uppercase" colspan="5">Beban Langsung Operasional :</td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[23]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_akomodasi, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[24]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_internet, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[25]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_website, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[26]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_telepon, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[27]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_percetakan, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[28]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_marketing, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[29]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_transportasi, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[30]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($beban_operational_lain, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[31]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($biaya_gaji, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[32]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($biaya_admin, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[33]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($biaya_sewa, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $hasilNeracaLajurs[34]['item'] }}</td>
            <td class="text-end">{{ 'Rp. ' . number_format($biaya_lain_lain, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" class="fw-bold text-uppercase text-center">Total Biaya Operational Langsung</td>
            <td class="text-end fw-bold">{{ 'Rp. ' . number_format($total_beban_langsung, 2, ',', '.') }}</td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-end text-uppercase fw-bold" colspan="4">Laba / Rugi</td>
            <td class="text-end fw-bold {{ $hasil_laba_rugi >= 0 ? null : 'text-danger' }}">
                {{ 'Rp. ' . number_format($hasil_laba_rugi, 2, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
