<title>Laporan Kondisi Kendaraan Inspeksi No {{ $car->no_reference }}</title>

<style>
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
</style>

<body>
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
        $circle_green = '<span class="dot green"></span>';
        $circle_yellow = '<span class="dot yellow"></span>';
        $circle_grey = '<span class="dot grey"></span>';
    @endphp
    <table style="margin-top: 1.5%">
        <tr>
            <td>
                <div>Keterangan :
                    <span>{!! $circle_green !!} OK</span>
                    <span>{!! $circle_yellow !!} Bermasalah</span>
                    <span>{!! $circle_grey !!} Tidak Berlaku</span>
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
    
    <table style="background-color: #FFD35A; margin-top: 2.5%">
        <tr>
            <td>
                <div style="padding: 1.5%; font-weight: bold">Foto Inspeksi Kendaraan </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%; margin: 2.5%">
        <tr>
            <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Depan</div></td>
        </tr>
        @if (!empty($car->detail_inspeksi_depan))
            <tr>
                @if (!empty($car->detail_inspeksi_depan->foto_kaca_depan))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Kaca Depan</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kaca_depan) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_depan->foto_kap_mesin))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Kap Mesin</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_kap_mesin) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_depan->foto_rangka_mobil))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Rangka Mobil</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_rangka_mobil) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_depan->foto_aki))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Aki</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_aki) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            
            <tr>
                @if (!empty($car->detail_inspeksi_depan->foto_bumper_lampu))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Bumper Lampu</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$car->detail_inspeksi_depan->foto_bumper_lampu) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kiri->foto_fender_depan_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Fender Depan Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_depan_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_kiri->foto_kaki_depan_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Kaki Depan Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_depan_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kiri->foto_kaki_belakang_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Kaki Belakang Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_belakang_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_kiri->foto_pintu_depan_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Pintu Depan Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_depan_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kiri->foto_pintu_belakang_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Pintu Belakang Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_belakang_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_kiri->foto_fender_belakang_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Fender Belakang Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_belakang_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_belakang->foto_lampu_belakang))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%; margin-top: 1.5%">Lampu Belakang</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_lampu_belakang) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
        @endif
    </table>
    <table>
        <tr>
            <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Kiri</div></td>
        </tr>
        @if (!empty($car->detail_inspeksi_kiri))
            <tr>
                @if (!empty($car->detail_inspeksi_kiri->foto_fender_depan_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Fender Depan Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_depan_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kiri->foto_kaki_depan_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Kaki Depan Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_depan_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_kiri->foto_kaki_belakang_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Kaki Belakang Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_kaki_belakang_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kiri->foto_pintu_depan_kiri))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Pintu Depan Kiri</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_pintu_depan_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_kiri->foto_fender_belakang_kiri))
                    <td style="vertical-align: top">
                        <div style="margin-bottom: 1.5%">Fender Belakang Kiri</div>
                        <div>
                            <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$car->detail_inspeksi_kiri->foto_fender_belakang_kiri) }}" style="width: 320px; height: 320px; object-fit: contain;">
                        </div>
                    </td>
                    @else
                    <td style="vertical-align: top">-</td>
                @endif
            </tr>
        @endif
    </table>
    <table>
        <tr>
            <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Kanan</div></td>
        </tr>
        @if (!empty($car->detail_inspeksi_kanan))
            <tr>
                @if (!empty($car->detail_inspeksi_kiri->foto_fender_depan_kanan))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Fender Depan Kanan</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_depan_kanan) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kanan->foto_kaki_depan_kanan))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">kaki_depan_kanan</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_depan_kanan) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_kanan->foto_kaki_belakang_kanan))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Kaki Belakang Kanan</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_kaki_belakang_kanan) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kanan->foto_pintu_depan_kanan))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Pintu Depan Kanan</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_depan_kanan) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_kanan->foto_pintu_belakang_kanan))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Pintu Belakang Kanan</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_pintu_belakang_kanan) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_kanan->foto_fender_belakang_kanan))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Fender Belakang Kanan</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$car->detail_inspeksi_kanan->foto_fender_belakang_kanan) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
        @endif
    </table>
    <table>
        <tr>
            <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Belakang</div></td>
        </tr>
        @if (!empty($car->detail_inspeksi_belakang))
            <tr>
                @if (!empty($car->detail_inspeksi_belakang->foto_lampu_belakang))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Lampu Belakang</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_lampu_belakang) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_belakang->foto_pintu_bagasi_belakang))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Pintu Bagasi Belakang</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_pintu_bagasi_belakang) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_belakang->foto_bumper_belakang))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Bumper Belakang</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$car->detail_inspeksi_belakang->foto_bumper_belakang) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
        @endif
    </table>
    <table>
         <tr>
            <td colspan="4"><div style="margin-top: 2.5%; margin-bottom: 2.5%; font-weight: bold"><span class="dot"></span> Bagian Interior</div></td>
        </tr>
        @if (!empty($car->detail_inspeksi_interior))
            <tr>
                @if (!empty($car->detail_inspeksi_interior->foto_speedometer))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Spidometer</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_speedometer) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_speedometer }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_interior->foto_setir))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Setir</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_setir) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_setir }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_interior->foto_dasboard))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Dashboard</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_dasboard) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_dasboard }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_interior->foto_plafon))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Plafon</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_plafon) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_plafon }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_interior->foto_ac))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">AC</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_ac) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_ac }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_interior->foto_audio))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Audio</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_audio) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_audio }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_interior->foto_jok))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">JOK</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_jok) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_jok }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_interior->foto_electric_spion))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Electric Spion</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_electric_spion) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_electric_spion }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
            <tr>
                @if (!empty($car->detail_inspeksi_interior->foto_power_window))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Power Window</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_power_window) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_power_window }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
                @if (!empty($car->detail_inspeksi_interior->foto_lain_lain))
                <td style="vertical-align: top">
                    <div style="margin-bottom: 1.5%">Foto Lain Lain</div>
                    <div>
                        <img src="{{ asset('backend/mobil/'.$car->plat_nomor.'/berkas/pengecekkan_bagian_interior/'.$car->detail_inspeksi_interior->foto_lain_lain) }}" style="width: 320px; height: 320px; object-fit: contain;">
                    </div>
                    <p>Keterangan : {{ $car->detail_inspeksi_interior->keterangan_lain_lain }}</p>
                </td>
                @else
                <td style="vertical-align: top">-</td>
                @endif
            </tr>
        @endif
    </table>
    <table style="width: 100%">
        <tr>
            <td colspan="2" style="text-align: center">Tanda Tangan</td>
        </tr>
        <tr>
            <td style="text-align: center;">Customer</td>
            <td style="text-align: center;">Inspektor</td>
        </tr>
        <tr>
            <td style="text-align: center">
                <div>
                    {!! '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG('4445645656', 'QRCODE',3.5,3.5) . '" alt="barcode"   />' !!}
                </div>
                {{-- <div>{!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE',3,3) !!}</div> --}}
                <div>______________________</div>
            </td>
            <td style="text-align: center">
                <div>
                    {!! '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG('4445645656', 'QRCODE',3.5,3.5) . '" alt="barcode"   />' !!}
                </div>
                {{-- <div>{!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE',3,3) !!}</div> --}}
                <div>{{ auth()->user()->name }}</div>
            </td>
        </tr>
    </table>
</body>
