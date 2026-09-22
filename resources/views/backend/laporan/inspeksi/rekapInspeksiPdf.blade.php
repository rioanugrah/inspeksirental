<title>Laporan Hasil Inspeksi Afkar Mobil Periode {{ \Carbon\Carbon::create($date)->isoFormat('MMMM YYYY') }}</title>
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

<div class="fw-bold">Laporan Hasil Inspeksi Afkar Mobil</div>
<div class="fw-bold">Periode : {{ \Carbon\Carbon::create($date)->isoFormat('MMMM YYYY') }}</div>

<table style="margin-top: 2%">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">No. Reference</th>
            <th class="text-center">Plat Nomor</th>
            <th class="text-center">Warna</th>
            <th class="text-center">Merek</th>
            <th class="text-center">Model</th>
            <th class="text-center">Transmisi</th>
            <th class="text-center">Tahun Pembuatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cars as $key => $car)
            <tr>
                <td class="text-center">{{ $key+1 }}</td>
                <td class="text-center">{{ $car->no_reference }}</td>
                <td class="text-center">{{ $car->plat_nomor }}</td>
                <td class="text-center">{{ $car->warna }}</td>
                <td class="text-center">{{ $car->merk }}</td>
                <td class="text-center">{{ $car->model }}</td>
                <td class="text-center">{{ $car->transmisi }}</td>
                <td class="text-center">{{ $car->tahun }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<footer style="
position: absolute;
bottom: 0;
font-weight: bold;
font-size: 10pt
">
    <label for="">Ket: </label>
    <div>Hasil laporan rekap inspeksi sah yang telah dibuat oleh sistem.</div>
</footer>