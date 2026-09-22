<title>Laporan Journal Keuangan Afkar Mobil Periode {{ $_GET['year'] }}</title>
<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }

    table, td, th {
        border: 1px solid;
        padding: 10px;
        font-size: 11pt;
    }

    th{
        background-color: #FED24F;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .fw-bold{
        font-weight: bold;
    }

    .text-center{
        text-align: center;
    }
</style>
<div class="fw-bold text-center">Laporan Journal Keuangan Afkar Mobil</div>
<div class="fw-bold text-center">Periode : {{ $_GET['year'] }}</div>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Uraian</th>
            <th>Kode Debit</th>
            <th>Item Debit</th>
            <th>Nominal Debit</th>
            <th>Kode Kredit</th>
            <th>Item Kredit</th>
            <th>Nominal Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($journals as $journal)
            <tr>
                <td style="font-size: 10pt">{{ $journal->tanggal }}</td>
                <td style="font-size: 10pt">{{ $journal->uraian }}</td>
                <td class="text-center" style="font-size: 10pt">{{ $journal->code_debit }}</td>
                <td style="font-size: 10pt">{{ $journal->item_debit }}</td>
                <td style="font-size: 10pt">{{ 'Rp. '.number_format($journal->debit,2,',','.') }}</td>
                <td class="text-center" style="font-size: 10pt">{{ $journal->code_credit }}</td>
                <td style="font-size: 10pt">{{ $journal->item_credit }}</td>
                <td style="font-size: 10pt">{{ 'Rp. '.number_format($journal->credit,2,',','.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>