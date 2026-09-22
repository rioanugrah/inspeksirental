<title>Laporan Buku Besar Keuangan Afkar Mobil Periode {{ $_GET['date_from'] . ' sd ' . $_GET['date_end'] }}</title>
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
<div class="fw-bold text-center">Laporan Buku Besar Keuangan Afkar Mobil</div>
<div class="fw-bold text-center">Periode : {{ $_GET['date_from'] . ' sd ' . $_GET['date_end'] }}</div>

<table>
    <thead>
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
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center fw-bold">{{ $bukuBesar['code'] }}</td>
                <td class="fw-bold">{{ $bukuBesar['item'] }}</td>
                <td class="text-end">{{ 'Rp. ' . number_format($bukuBesar['sa_debit'], 2, ',', '.') }}</td>
                <td class="text-end">{{ 'Rp. ' . number_format($bukuBesar['sa_credit'], 2, ',', '.') }}</td>
                <td class="text-end">{{ 'Rp. ' . number_format($bukuBesar['debit'], 2, ',', '.') }}</td>
                <td class="text-end">{{ 'Rp. ' . number_format($bukuBesar['credit'], 2, ',', '.') }}</td>
                <td class="text-end">{{ 'Rp. ' . number_format($bukuBesar['neraca_debit'], 2, ',', '.') }}</td>
                <td class="text-end">{{ 'Rp. ' . number_format($bukuBesar['neraca_credit'], 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-center">Total</th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalSaDebit, 2, ',', '.') }}</th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalSaCredit, 2, ',', '.') }}</th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalDebit, 2, ',', '.') }}</th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalCredit, 2, ',', '.') }}</th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalNeracaDebit, 2, ',', '.') }}</th>
            <th class="text-end">{{ 'Rp. ' . number_format($totalNeracaCredit, 2, ',', '.') }}</th>
        </tr>
        <tr>
            <th colspan="3" class="text-center">Total Laba Bersih Utama</th>
            <th colspan="2" class="text-center"><i>Penyeimbang Laba Bersih</i></th>
            <th colspan="4" class="text-end">{{ 'Rp. ' . number_format($totalCredit - $totalDebit, 2, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>
