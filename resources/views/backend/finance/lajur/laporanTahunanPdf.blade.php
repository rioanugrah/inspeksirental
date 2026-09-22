<title>Laporan Lajur Buku Keuangan Afkar Mobil Periode {{ $_GET['year'] }}</title>
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
</style>
<div class="fw-bold text-center">Laporan Lajur Buku Keuangan Afkar Mobil</div>
<div class="fw-bold text-center">Periode : {{ $_GET['year'] }}</div>

<table>
    <thead style="background-color: #5996FF; color: white">
        <tr>
            <th class="text-center" style="vertical-align: middle" rowspan="2">Kode</th>
            <th class="text-center" style="vertical-align: middle" rowspan="2">Item</th>
            <th class="text-center" style="vertical-align: middle" colspan="2">N. Saldo Before
                Adjustment</th>
            <th class="text-center" style="vertical-align: middle" colspan="2">Adjustment</th>
            <th class="text-center" style="vertical-align: middle" colspan="2">N. Saldo After
                Adjustment</th>
            <th class="text-center" style="vertical-align: middle" colspan="2">Rugi Laba</th>
            <th class="text-center" style="vertical-align: middle" colspan="2">Neraca</th>
        </tr>
        <tr>
            <th class="text-center" style="vertical-align: middle">Debit</th>
            <th class="text-center" style="vertical-align: middle">Credit</th>
            <th class="text-center" style="vertical-align: middle">Debit</th>
            <th class="text-center" style="vertical-align: middle">Credit</th>
            <th class="text-center" style="vertical-align: middle">Debit</th>
            <th class="text-center" style="vertical-align: middle">Credit</th>
            <th class="text-center" style="vertical-align: middle">Debit</th>
            <th class="text-center" style="vertical-align: middle">Credit</th>
            <th class="text-center" style="vertical-align: middle">Debit</th>
            <th class="text-center" style="vertical-align: middle">Credit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($hasilNeracaLajurs as $key => $hasilNeracaLajur)
            <tr>
                <td class="text-center fw-bold">{{ $hasilNeracaLajur['code'] }}</td>
                <td class="text-start fw-bold">{{ $hasilNeracaLajur['item'] }}</td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['n_saldo_before_adjustment_debit'], 2, ',', '.') }}
                </td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['n_saldo_before_adjustment_credit'], 2, ',', '.') }}
                </td>
                <td class="text-end">
                    <a
                        onclick="alert('{{ $hasilNeracaLajur['item'] }}')">{{ 'Rp. ' . number_format($hasilNeracaLajur['adjustment_debit'], 2, ',', '.') }}</a>
                </td>
                <td class="text-end">
                    <a
                        onclick="alert('{{ $hasilNeracaLajur['item'] }}')">{{ 'Rp. ' . number_format($hasilNeracaLajur['adjustment_credit'], 2, ',', '.') }}</a>
                </td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['n_saldo_after_adjustment_debit'], 2, ',', '.') }}
                </td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['n_saldo_after_adjustment_credit'], 2, ',', '.') }}
                </td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['rugi_laba_debit'], 2, ',', '.') }}
                </td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['rugi_laba_credit'], 2, ',', '.') }}
                </td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['neraca_after_debit'], 2, ',', '.') }}
                </td>
                <td class="text-end">
                    {{ 'Rp. ' . number_format($hasilNeracaLajur['neraca_after_credit'], 2, ',', '.') }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-center" colspan="2" rowspan="2">Total</th>
            <th class="text-end">
                {{ 'Rp. ' . number_format($totalNeracaSaldoBeforeAdjustmentDebit, 2, ',', '.') }}
            </th>
            <th class="text-end">
                {{ 'Rp. ' . number_format($totalNeracaSaldoBeforeAdjustmentCredit, 2, ',', '.') }}
            </th>
            <th class="text-end">
                {{ 'Rp. ' . number_format($totalNeracaAdjustmentDebit, 2, ',', '.') }}
            </th>
            <th class="text-end">
                {{ 'Rp. ' . number_format($totalNeracaAdjustmentCredit, 2, ',', '.') }}
            </th>
            <th class="text-end">
                {{ 'Rp. ' . number_format($totalNeracaSaldoAfterAdjustmentDebit, 2, ',', '.') }}
            </th>
            <th class="text-end">
                {{ 'Rp. ' . number_format($totalNeracaSaldoAfterAdjustmentCredit, 2, ',', '.') }}
            </th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalRugiLabaDebit, 2, ',', '.') }}
            </th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalRugiLabaCredit, 2, ',', '.') }}
            </th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalNeracaAfterDebit, 2, ',', '.') }}
            </th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalNeracaAfterCredit, 2, ',', '.') }}
            </th>
        </tr>
        <tr>
            <th class="text-end"></th>
            <th class="text-end"></th>
            <th class="text-end"></th>
            <th class="text-end"></th>
            <th class="text-end"></th>
            <th class="text-end"></th>
            <th class="text-end {{ $totalMinusRugiLabaDebit > 0 ? 'text-primary' : null }}">
                {{ 'Rp. ' . number_format($totalMinusRugiLabaDebit, 2, ',', '.') }}</th>
            <th class="text-end {{ $totalMinusRugiLabaCredit > 0 ? 'text-primary' : null }}">
                {{ 'Rp. ' . number_format($totalMinusRugiLabaCredit, 2, ',', '.') }}</th>
            <th class="text-end {{ $totalMinusNeracaAfterDebit > 0 ? 'text-primary' : null }}">
                {{ 'Rp. ' . number_format($totalMinusNeracaAfterDebit, 2, ',', '.') }}</th>
            <th class="text-end {{ $totalMinusNeracaAfterCredit > 0 ? 'text-primary' : null }}">
                {{ 'Rp. ' . number_format($totalMinusNeracaAfterCredit, 2, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>
