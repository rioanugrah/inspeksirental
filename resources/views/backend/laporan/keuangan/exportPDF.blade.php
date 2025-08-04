<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    table,
    td,
    th {
        border: 1px solid #ddd;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 5px;
    }

    tr:nth-child(even) {
        background-color: rgba(0, 99, 248, 0.1);
    }

    footer {
        position: absolute;
        bottom: 0;
        font-size: 10pt;
    }
</style>
<title>Laporan Keuangan Afkar Mobil Periode {{ $periode }}</title>

<body>
    <div style="text-align: center; font-weight: bold">Laporan Keuangan Afkar Mobil Periode {{ $periode }}</div>
    <table style="margin-top: 2.5%">
        <thead>
            <tr>
                <th style="text-align: center; background-color:orange">No</th>
                <th style="text-align: center; background-color:orange">No. References</th>
                <th style="text-align: center; background-color:orange">Plat Nomor</th>
                <th style="text-align: center; background-color:orange">Warna Mobil</th>
                <th style="text-align: center; background-color:orange">Merek</th>
                <th style="text-align: center; background-color:orange">Model</th>
                <th style="text-align: center; background-color:orange">Tahun</th>
                <th style="text-align: center; background-color:orange">Transmisi</th>
                <th style="text-align: center; background-color:orange">Harga</th>
            </tr>
        </thead>
        @php
            $total = [];
        @endphp
        <tbody>
            @forelse ($cars as $key => $car)
                @php
                    array_push($total, $car->price);
                @endphp
                <tr>
                    <td style="text-align: center; font-size: 10pt">{{ $key + 1 }}</td>
                    <td style="text-align: center; font-size: 10pt">{{ $car->no_reference }}</td>
                    <td style="text-align: center; font-size: 10pt; width: 12%">
                        {{ explode('-', $car->plat_nomor)[0] . ' ' . explode('-', $car->plat_nomor)[1] . ' ' . explode('-', $car->plat_nomor)[2] }}
                    </td>
                    <td style="text-align: center; font-size: 10pt">{{ $car->warna }}</td>
                    <td style="text-align: center; font-size: 10pt">{{ $car->merek }}</td>
                    <td style="text-align: center; font-size: 10pt">{{ $car->model }}</td>
                    <td style="text-align: center; font-size: 10pt">{{ $car->tahun }}</td>
                    <td style="text-align: center; font-size: 10pt">{{ $car->transmisi }}</td>
                    <td style="text-align: right">
                        @if (empty($car->price))
                            <span style="text-align: center; color: red; font-size: 10pt">Harga Belum Diinput</span>
                        @else
                            <span style="font-size: 10pt">{{ 'Rp. ' . number_format($car->price, 0, ',', '.') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; font-size: 10pt">Data Belum Tersedia</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align: right; font-weight: bold; font-size: 10pt">Total</td>
                <td style="text-align: right; font-weight: bold; font-size: 10pt">
                    {{ 'Rp. ' . number_format(array_sum($total), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    <footer>
        <span style="font-weight: bold">Ket:</span> Laporan Keuangan ini dibuat oleh sistem dan tidak dapat perubahan
        data dengan tidak semestinya.
    </footer>
</body>
