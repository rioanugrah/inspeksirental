@extends('layouts.backend.master')
@section('title')
   Edit Inspeksi Depan
@endsection
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card">
            <form id="edit-bagian-depan" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h6 class="card-title border-bottom p-3 mb-0 header-title">Edit Inspeksi Depan</h6>
                <div class="row mt-3">
                    @if ($inspeksi_depan->kaca_depan == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Kaca Depan</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_depan->cars->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$inspeksi_depan->foto_kaca_depan) }}" style="width: 250px; height: 250px; object-fit: cover;">
                        <input type="file" name="foto_kaca_depan" class="form-control" id="">
                        <textarea name="keterangan_kaca_depan" class="form-control mt-2" id="" placeholder="Keterangan Kaca Depan" cols="30" rows="2">{{ $inspeksi_depan->keterangan_kaca_depan }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_depan->kap_mesin == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Kap Mesin</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_depan->cars->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$inspeksi_depan->foto_kap_mesin) }}" style="width: 250px; height: 250px; object-fit: cover;">
                        <input type="file" name="foto_kap_mesin" class="form-control" id="">
                        <textarea name="keterangan_kap_mesin" class="form-control mt-2" id="" placeholder="Keterangan Kap Mesin" cols="30" rows="2">{{ $inspeksi_depan->keterangan_kap_mesin }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_depan->rangka_mobil == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Rangka Mobil</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_depan->cars->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$inspeksi_depan->foto_rangka_mobil) }}" style="width: 250px; height: 250px; object-fit: cover;">
                        <input type="file" name="foto_rangka_mobil" class="form-control" id="">
                        <textarea name="keterangan_rangka_mobil" class="form-control mt-2" id="" placeholder="Keterangan Rangka Mobil" cols="30" rows="2">{{ $inspeksi_depan->keterangan_rangka_mobil }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_depan->aki == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>AKI / Baterai</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_depan->cars->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$inspeksi_depan->foto_aki) }}" style="width: 250px; height: 250px; object-fit: cover;">
                        <input type="file" name="foto_aki" class="form-control" id="">
                        <textarea name="keterangan_aki" class="form-control mt-2" id="" placeholder="Keterangan Aki / Baterai" cols="30" rows="2">{{ $inspeksi_depan->keterangan_aki }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_depan->radiator == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Radiator</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_depan->cars->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$inspeksi_depan->foto_radiator) }}" style="width: 250px; height: 250px; object-fit: cover;">
                        <input type="file" name="foto_radiator" class="form-control" id="">
                        <textarea name="keterangan_radiator" class="form-control mt-2" id="" placeholder="Keterangan Radiator" cols="30" rows="2">{{ $inspeksi_depan->keterangan_radiator }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_depan->kondisi_mesin == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Kondisi Mesin</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_depan->cars->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$inspeksi_depan->foto_kondisi_mesin) }}" style="width: 250px; height: 250px; object-fit: cover;">
                        <input type="file" name="foto_kondisi_mesin" class="form-control" id="">
                        <textarea name="keterangan_kondisi_mesin" class="form-control mt-2" id="" placeholder="Keterangan Kondisi Mesin" cols="30" rows="2">{{ $inspeksi_depan->keterangan_kondisi_mesin }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_depan->bumper_lampu == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Bumper dan Lampu</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_depan->cars->plat_nomor.'/berkas/pengecekkan_bagian_depan/'.$inspeksi_depan->foto_bumper_lampu) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_bumper_lampu" class="form-control" id="">
                        <textarea name="keterangan_bumper_lampu" class="form-control mt-2" id="" placeholder="Keterangan Bumper dan Lampu" cols="30" rows="2">{{ $inspeksi_depan->keterangan_bumper_lampu }}</textarea>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url()->previous() }}'">Back</button>
            </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
    <script>
        $('#edit-bagian-depan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.update_inspeksi_depan', ['id' => $inspeksi_depan->id, 'inspeksi_depan' => $inspeksi_depan->cars_id]) }}",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    Swal.fire({
                        icon: "info",
                        title: "Data Sedang Diproses, Silahkan Tunggu",
                        showConfirmButton: false,
                    });
                },
                success: (result) => {
                    if (result.success != false) {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
                        });
                        setTimeout(function() {
                            // location.reload();
                            window.location.href="{{ route('cars.buat_inspeksi',['id' => $inspeksi_depan->cars_id]) }}";
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: result.error,
                            // showConfirmButton: false,
                        });
                    }
                },
                error: function(request, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: error,
                        // showConfirmButton: false,
                    });
                }
            });
        });
    </script>
@endsection
