<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    <title>Report Kondisi Kendaraan No {{ $car->no_reference }}</title>
    <style>
        @media print{
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            html {
                font-family: Arial, Helvetica, sans-serif;
            }
        
            table,
            td,
            th {
                /* border: 1px solid; */
                /* padding: 0.5%; */
            }
        
            table {
                width: 100%;
                border-collapse: collapse;
            }
        
            #watermark {
                position: fixed;
                opacity: 0.3;
        
                /** 
                    Set a position in the page for your image
                    This should center it vertically
                **/
                bottom:   10cm;
                left:     5.5cm;
        
                /** Change image dimensions**/
                width:    8cm;
                height:   8cm;
        
                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
        
            .dot {
                height: 10px !important;
                width: 10px !important;
                background-color: #45474b !important;
                border-radius: 50% !important;
                display: inline-block;
            }
        
            .green {
                background-color: green;
            }
        
            .yellow {
                background-color: orange;
            }
        
            .grey {
                background-color: #45474b;
            }
        
        }

        html {
            font-family: Arial, Helvetica, sans-serif;
        }
    
        table,
        td,
        th {
            /* border: 1px solid; */
            /* padding: 0.5%; */
        }
    
        table {
            width: 100%;
            border-collapse: collapse;
        }
    
        #watermark {
            position: fixed;
            opacity: 0.3;
    
            /** 
                Set a position in the page for your image
                This should center it vertically
            **/
            bottom:   10cm;
            left:     5.5cm;
    
            /** Change image dimensions**/
            width:    8cm;
            height:   8cm;
    
            /** Your watermark should be behind every content**/
            z-index:  -1000;
        }
    
        .dot {
            height: 10px;
            width: 10px;
            background-color: #45474b;
            border-radius: 50%;
            display: inline-block;
        }
    
        .green {
            background-color: green;
        }
    
        .yellow {
            background-color: orange;
        }
    
        .grey {
            background-color: #45474b;
        }
    
        .grid-coverer {
            display: grid;
            grid-template-columns: auto auto auto;
            /* background-color: #2196F3; */
            /* padding: 10px; */
        }
        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            /* border: 1px solid rgba(0, 0, 0, 0.8); */
            margin: 10px;
            font-size: 18px;
            text-align: center;
            word-break: break-all;
        }
    </style>
</head>
<body>
    {{-- <input type="button" style="margin: 1%" onclick="printDiv('printableArea')" value="Cetak Hasil" /> --}}
    <div id="printableArea">
        <div id="watermark">
            <img src="{{ asset('backend/assets/images/icons/logo_inspector.jpg') }}" height="100%" width="100%" />
        </div>
        <table style="background-color: #FFD35A">
            <tr>
                <td>
                    <div style="padding: 2.5%; font-weight: bold">Laporan Kondisi Kendaraan No. {{ $car->no_reference }}</div>
                </td>
                <td style="text-align: right">
                    <div style="padding: 2.5%; font-weight: bold">Tanggal Buat : {{ $car->created_at->isoFormat('DD MMMM YYYY') }}</div>
                </td>
            </tr>
        </table>
        <table style="background-color: #F3FEB8; margin-top: 1.5%">
            <tr>
                <td>
                    <div style="padding: 5%">No. Polisi</div>
                </td>
                <td>
                    <div style="padding: 5%">:</div>
                </td>
                <td>
                    <div style="padding: 5%">{{ $car->plat_nomor }}</div>
                </td>
                <td>
                    <div style="padding: 5%">Warna</div>
                </td>
                <td>
                    <div style="padding: 5%">:</div>
                </td>
                <td>
                    <div style="padding: 5%">{{ $car->warna }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="padding: 5%">Merk</div>
                </td>
                <td>
                    <div style="padding: 5%">:</div>
                </td>
                <td>
                    <div style="padding: 5%">{{ $car->merk }}</div>
                </td>
                <td>
                    <div style="padding: 5%">Model / Type</div>
                </td>
                <td>
                    <div style="padding: 5%">:</div>
                </td>
                <td>
                    <div style="padding: 5%">{{ $car->model }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="padding: 5%">Tahun</div>
                </td>
                <td>
                    <div style="padding: 5%">:</div>
                </td>
                <td>
                    <div style="padding: 5%">{{ $car->tahun }}</div>
                </td>
                <td>
                    <div style="padding: 5%">No. Rangka</div>
                </td>
                <td>
                    <div style="padding: 5%">:</div>
                </td>
                <td>
                    <div style="padding: 5%">{{ $car->no_rangka }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="padding: 5%">Transmisi</div>
                </td>
                <td>
                    <div style="padding: 5%">:</div>
                </td>
                <td>
                    <div style="padding: 5%">{{ $car->transmisi }}</div>
                </td>
            </tr>
        </table>
        <table style="background-color: #FFD35A; margin-top: 1.5%">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Poin Inspeksi</div>
                </td>
            </tr>
        </table>
        @php
            $circle_green = '<i class="fa fa-check-square-o" aria-hidden="true" style="color: green"></i>';
            $circle_yellow = '<i class="fa fa-times-circle" aria-hidden="true" style="color: red"></i>';
        @endphp
        <table style="margin-top: 1.5%">
            <tr>
                <td>
                    <div>Keterangan Kondisi Inspeksi :
                        <span>OK {!! $circle_green !!}</span>
                        <span>Bermasalah {!! $circle_yellow !!}</span>
                    </div>
                </td>
            </tr>
        </table>
        <table style="width: 100%; margin: 1.5%">
            @if (!empty($car->detail_inspeksi_depan))
                <tr>
                    <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Depan</div></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Kaca Depan</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_depan->kaca_depan)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Kap Mesin</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_depan->kap_mesin)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Rangka Mobil</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_depan->rangka_mobil)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Aki Mobil</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_depan->aki)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Radiator</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_depan->radiator)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Kondisi Mesin</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_depan->kondisi_mesin)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Bumper Lampu</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_depan->bumper_lampu)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
            @endif
    
            @if (!empty($car->detail_inspeksi_kiri))
                <tr>
                    <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Kiri</div></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Fender Depan Kiri</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kiri->fender_depan_kiri)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Kaki Depan Kiri</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kiri->kaki_depan_kiri)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Kaki Belakang Kiri</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kiri->kaki_belakang_kiri)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Pintu Depan Kiri</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kiri->pintu_depan_kiri)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Pintu Belakang Kiri</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kiri->pintu_belakang_kiri)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Fender Belakang Kiri</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kiri->fender_belakang_kiri)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
            @endif
    
            @if (!empty($car->detail_inspeksi_kanan))
                <tr>
                    <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Kanan</div></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Fender Depan Kanan</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kanan->fender_depan_kanan)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Kaki Depan Kanan</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kanan->kaki_depan_kanan)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Kaki Belakang Kanan</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kanan->kaki_belakang_kanan)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Pintu Depan Kanan</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kanan->pintu_depan_kanan)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Pintu Belakang Kanan</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kanan->pintu_belakang_kanan)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Fender Belakang Kanan</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_kanan->fender_belakang_kanan)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
            @endif
    
            @if (!empty($car->detail_inspeksi_belakang))
                <tr>
                    <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Belakang</div></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Lampu Belakang</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_belakang->lampu_belakang)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Pintu Bagasi Belakang</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_belakang->pintu_bagasi_belakang)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle">
                        <div style="margin-top: 2.5%; margin-bottom: 2.5%">Bumper Belakang</div>
                    </td>
                    <td style="vertical-align: middle">
                        @switch($car->detail_inspeksi_belakang->bumper_belakang)
                            @case('Baik')
                                {!! $circle_green !!}
                                @break
                            @case('Rusak')
                                {!! $circle_yellow !!}
                                @break
                            @default
                        @endswitch
                    </td>
                </tr>
            @endif
            
        </table>
    
        <table width="100%" style="background-color: #FFD35A; margin-top: 2.5%; page-break-before: always;">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Foto Identitas Kendaraan</div>
                </td>
            </tr>
        </table>
    
        <table style="width: 100%">
            <tr>
                <td>
                    <div>Foto Kendaraan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_kendaraan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                </td>
                <td>
                    <div>Foto STNK</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_stnk) }}" style="width: 220px; height: 250px; object-fit: cover;">
                </td>
                <td>
                    <div>Foto Sisi Depan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_sisi_depan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                </td>
            </tr>
            <tr>
                <td>
                    <div>Foto Sisi Belakang</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_sisi_belakang) }}" style="width: 220px; height: 250px; object-fit: cover;">
                </td>
                <td>
                    <div>Foto Sisi Kiri</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_sisi_kiri) }}" style="width: 220px; height: 250px; object-fit: cover;">
                </td>
                <td>
                    <div>Foto Sisi Kanan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_sisi_kanan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                </td>
            </tr>
            <tr>
                <td>
                    <div>Foto Sisi Interior</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/'.$car->foto_sisi_interior) }}" style="width: 220px; height: 250px; object-fit: cover;">
                </td>
            </tr>
        </table>
    
        <table width="100%" style="background-color: #FFD35A; margin-top: 2.5%; page-break-before: always;">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Foto Inspeksi Kendaraan Depan</div>
                </td>
            </tr>
        </table>

        <div class="grid-coverer">
            @if ($car->detail_inspeksi_depan->kaca_depan == 'Rusak')
            <div class="grid-item">
                <div>Kaca Depan</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kaca_depan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_depan->keterangan_kaca_depan }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_depan->kap_mesin == 'Rusak')
            <div class="grid-item">
                <div>Kap Mesin</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kap_mesin) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_depan->keterangan_kap_mesin }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_depan->rangka_mobil == 'Rusak')
            <div class="grid-item">
                <div>Rangka Mobil</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_rangka_mobil) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_depan->keterangan_rangka_mobil }}</div>
            </div>  
            @endif
            @if ($car->detail_inspeksi_depan->aki == 'Rusak')
            <div class="grid-item">
                <div>Aki</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_aki) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_depan->keterangan_aki }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_depan->radiator == 'Rusak')
            <div class="grid-item">
                <div>Radiator</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_radiator) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_depan->keterangan_radiator }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_depan->kondisi_mesin == 'Rusak')
            <div class="grid-item">
                <div>Kondisi Mesin</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kondisi_mesin) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_depan->keterangan_kondisi_mesin }}</div>
            </div>  
            @endif
            @if ($car->detail_inspeksi_depan->bumper_lampu == 'Rusak')
            <div class="grid-item">
                <div>Bumper Lampu</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_bumper_lampu) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_depan->keterangan_bumper_lampu }}</div>
            </div>
            @endif
          </div>
    
        {{-- <table style="width: 100%">
            <tr>
                <td style="font-size: 10pt">Kaca Depan</td>
                <td style="font-size: 10pt">Kap Mesin</td>
                <td style="font-size: 10pt">Rangka Mobil</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_depan->foto_kaca_depan)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kaca_depan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <!-- Baik <img src="{{ asset('backend/assets/icon/check.png') }}" width="50"> -->
                    <i class="fa fa-check-square-o" aria-hidden="true">Kondisi Ok</i>
                     
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_depan->foto_kap_mesin)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kap_mesin) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <!-- <img src="{{ asset('backend/assets/icon/check.png') }}" width="150"> -->
                    <i class="fa fa-check-square-o" aria-hidden="true">Kondisi Ok</i>
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_depan->foto_rangka_mobil)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_rangka_mobil) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 10pt">Aki</td>
                <td style="font-size: 10pt">Radiator</td>
                <td style="font-size: 10pt">Kondisi Mesin</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_depan->foto_aki)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_aki) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_depan->foto_radiator)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_radiator) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_depan->foto_kondisi_mesin)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kondisi_mesin) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 10pt">Bumper Lampu</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_depan->foto_bumper_lampu)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_bumper_lampu) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="200">
                    @endif
                </td>
            </tr>
        </table> --}}
    
        <table width="100%" style="background-color: #FFD35A; margin-top: 2.5%; page-break-before: always;">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Foto Inspeksi Kendaraan Kanan</div>
                </td>
            </tr>
        </table>

        <div class="grid-coverer">
            @if ($car->detail_inspeksi_kanan->fender_depan_kanan == 'Rusak')
            <div class="grid-item">
                <div>Fender Depan Kanan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_depan_kanan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kanan->keterangan_fender_depan_kanan }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kanan->kaki_depan_kanan == 'Rusak')
            <div class="grid-item">
                <div>Kaki Depan Kanan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_depan_kanan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kanan->keterangan_kaki_depan_kanan }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kanan->kaki_belakang_kanan == 'Rusak')
            <div class="grid-item">
                <div>Kaki Belakang Kanan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_belakang_kanan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kanan->keterangan_kaki_belakang_kanan }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kanan->pintu_depan_kanan == 'Rusak')
            <div class="grid-item">
                <div>Pintu Depan Kanan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_depan_kanan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kanan->keterangan_pintu_depan_kanan }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kanan->pintu_belakang_kanan == 'Rusak')
            <div class="grid-item">
                <div>Pintu Belakang Kanan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_belakang_kanan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kanan->keterangan_pintu_belakang_kanan }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kanan->fender_belakang_kanan == 'Rusak')
            <div class="grid-item">
                <div>Fender Belakang Kanan</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_belakang_kanan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kanan->keterangan_fender_belakang_kanan }}</div>
            </div>
            @endif
        </div>
        {{-- <table width="100%">
            <tr>
                <td style="font-size: 10pt">Fender Depan Kanan</td>
                <td style="font-size: 10pt">Kaki Depan Kanan</td>
                <td style="font-size: 10pt">Kaki Belakang Kanan</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_kanan->foto_fender_depan_kanan)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_depan_kanan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kanan->foto_kaki_depan_kanan)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_depan_kanan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kanan->foto_kaki_belakang_kanan)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_belakang_kanan) }}" style="width: 220px; height: 250px; object-fit: cover;">  
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 10pt">Pintu Depan Kanan</td>
                <td style="font-size: 10pt">Pintu Belakang Kanan</td>
                <td style="font-size: 10pt">Fender Belakang Kanan</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_kanan->foto_pintu_depan_kanan)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_depan_kanan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kanan->foto_pintu_belakang_kanan)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_belakang_kanan) }}" style="width: 220px; height: 250px; object-fit: cover;"> 
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150"> 
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kanan->foto_fender_belakang_kanan)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_belakang_kanan) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150"> 
                    @endif
                </td>
            </tr>
        </table> --}}
    
        <table width="100%" style="background-color: #FFD35A; margin-top: 2.5%; page-break-before: always;">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Foto Inspeksi Kendaraan Kiri</div>
                </td>
            </tr>
        </table>

        <div class="grid-coverer">
            @if ($car->detail_inspeksi_kiri->fender_depan_kiri == 'Rusak')
            <div class="grid-item">
                <div>Fender Depan Kiri</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_depan_kiri) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kiri->keterangan_fender_depan_kiri }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kiri->kaki_depan_kiri == 'Rusak')
            <div class="grid-item">
                <div>Kaki Depan Kiri</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_depan_kiri) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kiri->keterangan_kaki_depan_kiri }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kiri->kaki_belakang_kiri == 'Rusak')
            <div class="grid-item">
                <div>Kaki Belakang Kiri</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_belakang_kiri) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kiri->keterangan_kaki_belakang_kiri }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kiri->pintu_depan_kiri == 'Rusak')
            <div class="grid-item">
                <div>Pintu Depan Kiri</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_depan_kiri) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kiri->keterangan_pintu_depan_kiri }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kiri->pintu_belakang_kiri == 'Rusak')
            <div class="grid-item">
                <div>Pintu Belakang Kiri</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_belakang_kiri) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kiri->keterangan_pintu_belakang_kiri }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_kiri->fender_belakang_kiri == 'Rusak')
            <div class="grid-item">
                <div>Fender Belakang Kiri</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_belakang_kiri) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_kiri->keterangan_fender_belakang_kiri }}</div>
            </div>
            @endif
        </div>

        {{-- <table width="100%">
             <tr>
                <td style="font-size: 10pt">Fender Depan Kiri</td>
                <td style="font-size: 10pt">Kaki Depan Kiri</td>
                <td style="font-size: 10pt">Kaki Belakang Kiri</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_kiri->foto_fender_depan_kiri)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_depan_kiri) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kiri->foto_kaki_depan_kiri)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_depan_kiri) }}" style="width: 220px; height: 250px; object-fit: cover;">  
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kiri->foto_kaki_belakang_kiri)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_belakang_kiri) }}" style="width: 220px; height: 250px; object-fit: cover;"> 
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 10pt">Pintu Depan Kiri</td>
                <td style="font-size: 10pt">Pintu Belakang Kiri</td>
                <td style="font-size: 10pt">Fender Belakang Kiri</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_kiri->foto_pintu_depan_kiri)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_depan_kiri) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kiri->foto_pintu_belakang_kiri)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_belakang_kiri) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_kiri->foto_fender_belakang_kiri)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_belakang_kiri) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
        </table> --}}
    
        <table width="100%" style="background-color: #FFD35A; margin-top: 2.5%; page-break-before: always;">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Foto Inspeksi Kendaraan Belakang</div>
                </td>
            </tr>
        </table>

        <div class="grid-coverer">
            @if ($car->detail_inspeksi_belakang->lampu_belakang == 'Rusak')
            <div class="grid-item">
                <div>Lampu Belakang</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_lampu_belakang) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_belakang->keterangan_lampu_belakang }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_belakang->pintu_bagasi_belakang == 'Rusak')
            <div class="grid-item">
                <div>Pintu Bagasi Belakang</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_pintu_bagasi_belakang) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_belakang->keterangan_pintu_bagasi_belakang }}</div>
            </div>
            @endif
            @if ($car->detail_inspeksi_belakang->pintu_bumper_belakang == 'Rusak')
            <div class="grid-item">
                <div>Bumper Belakang</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_bumper_belakang) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_belakang->keterangan_bumper_belakang }}</div>
            </div>
            @endif
        </div>

        {{-- <table width="100%">
             <tr>
                <td style="font-size: 10pt">Lampu Belakang</td>
                <td style="font-size: 10pt">Pintu Bagasi Belakang</td>
                <td style="font-size: 10pt">Bumper Belakang</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_belakang->foto_lampu_belakang)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_lampu_belakang) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_belakang->foto_pintu_bagasi_belakang)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_pintu_bagasi_belakang) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_belakang->foto_bumper_belakang)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_bumper_belakang) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
        </table> --}}
    
        <table width="100%" style="background-color: #FFD35A; margin-top: 2.5%; page-break-before: always;">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Foto Inspeksi Kendaraan Interior</div>
                </td>
            </tr>
        </table>

        <div class="grid-coverer">
            <div class="grid-item">
                <div>Speedometer</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_speedometer) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_speedometer }}</div>
            </div>
            <div class="grid-item">
                <div>Setir</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_setir) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_setir }}</div>
            </div>
            <div class="grid-item">
                <div>Dasboard</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_dasboard) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_dasboard }}</div>
            </div>
            <div class="grid-item">
                <div>Plafon</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_plafon) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_plafon }}</div>
            </div>
            <div class="grid-item">
                <div>AC</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_ac) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_ac }}</div>
            </div>
            <div class="grid-item">
                <div>Audio</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_audio) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_audio }}</div>
            </div>
            <div class="grid-item">
                <div>Jok</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_jok) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_jok }}</div>
            </div>
            <div class="grid-item">
                <div>Electric Spion</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_electric_spion) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_electric_spion }}</div>
            </div>
            <div class="grid-item">
                <div>Power Window</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_power_window) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_power_window }}</div>
            </div>
            <div class="grid-item">
                <div>Lain - Lain</div>
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_lain_lain) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div style="font-weight: bold">Keterangan</div>
                <div>{{ $car->detail_inspeksi_interior->keterangan_lain_lain }}</div>
            </div>
        </div>

        <table width="100%" style="background-color: #FFD35A; margin-top: 2.5%; page-break-before: always;">
            <tr>
                <td>
                    <div style="padding: 1.5%; font-weight: bold">Foto Inspeksi Lain - Lain</div>
                </td>
            </tr>
        </table>

        <div class="grid-coverer">
            @foreach (json_decode($car->detail_inspeksi_lain->body) as $key => $body)
            <div class="grid-item">
                <div style="font-weight: bold">Keterangan {{ $key+1 }}</div>
                <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_lain/'.$body->foto_lain_lain) }}" style="width: 250px; height: 250px; object-fit: cover;">
                <div>{{ $body->keterangan_lain_lain }}</div>
            </div>
            @endforeach
        </div>

        {{-- <table width="100%">
            <tr>
                <td style="font-size: 10pt">Spedometer</td>
                <td style="font-size: 10pt">Setir</td>
                <td style="font-size: 10pt">Dashboard</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_speedometer)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_speedometer) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_setir)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_setir) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_dasboard)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_dasboard) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 10pt">Plafon</td>
                <td style="font-size: 10pt">Ac</td>
                <td style="font-size: 10pt">Audio</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_plafon)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_plafon) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <!-- <img src="{{ asset('backend/assets/icon/check.png') }}" width="150"> -->
                     <label for="">Kondisi OK</label>
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_ac)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_ac) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_audio)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_audio) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 10pt">Jok</td>
                <td style="font-size: 10pt">Electric Spion</td>
                <td style="font-size: 10pt">Power Window</td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_jok)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_jok) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_electric_spion)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_electric_spion) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_power_window)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_power_window) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-size: 10pt">Lain - Lain</td>
                <td style="font-size: 10pt"></td>
                <td style="font-size: 10pt"></td>
            </tr>
            <tr>
                <td>
                    @if ($car->detail_inspeksi_interior->foto_lain_lain)
                    <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_lain_lain) }}" style="width: 220px; height: 250px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/assets/icon/check.png') }}" width="150">
                    @endif
                </td>
                <td></td>
                <td></td>
            </tr>
        </table> --}}
        <div style="text-align: center">Inspektor By</div>
        <div style="font-weight: bold; text-align: center">AFKAR MAHESA MOBIL</div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        function printDivOne() {
            var printContents = document.getElementById('printableArea').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        printDivOne();
    </script>
</body>
</html>
