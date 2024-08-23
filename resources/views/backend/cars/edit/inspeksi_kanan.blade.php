@extends('layouts.backend.master')
@section('title')
   Edit Inspeksi Kanan
@endsection
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card">
            <form id="edit-bagian-kanan" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h6 class="card-title border-bottom p-3 mb-0 header-title">Edit Inspeksi Kanan</h6>
                <div class="row mt-3">
                    @if ($inspeksi_kanan->fender_depan_kanan == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Fender Depan Kanan</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kanan->cars->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$inspeksi_kanan->foto_fender_depan_kanan) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_fender_depan_kanan" class="form-control" id="">
                        <textarea name="keterangan_fender_depan_kanan" class="form-control" id="" placeholder="Keterangan Fender Depan Kanan" cols="30" rows="2">{{ $inspeksi_kanan->keterangan_fender_depan_kanan }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kanan->kaki_depan_kanan == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Kaki Depan Kanan</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kanan->cars->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$inspeksi_kanan->foto_kaki_depan_kanan) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_kaki_depan_kanan" class="form-control" id="">
                        <textarea name="keterangan_kaki_depan_kanan" class="form-control" id="" placeholder="Keterangan Kaki Depan Kanan" cols="30" rows="2">{{ $inspeksi_kanan->keterangan_kaki_depan_kanan }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kanan->kaki_belakang_kanan == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Kaki Belakang Kanan</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kanan->cars->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$inspeksi_kanan->foto_kaki_belakang_kanan) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_kaki_belakang_kanan" class="form-control" id="">
                        <textarea name="keterangan_kaki_belakang_kanan" class="form-control" id="" placeholder="Keterangan Kaki Belakang Kanan" cols="30" rows="2">{{ $inspeksi_kanan->keterangan_kaki_belakang_kanan }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kanan->pintu_depan_kanan == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Pintu Depan Kanan</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kanan->cars->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$inspeksi_kanan->foto_pintu_depan_kanan) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_pintu_depan_kanan" class="form-control" id="">
                        <textarea name="keterangan_pintu_depan_kanan" class="form-control" id="" placeholder="Keterangan Pintu Depan Kanan" cols="30" rows="2">{{ $inspeksi_kanan->keterangan_pintu_depan_kanan }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kanan->pintu_belakang_kanan == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Pintu Belakang Kanan</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kanan->cars->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$inspeksi_kanan->foto_pintu_belakang_kanan) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_pintu_belakang_kanan" class="form-control" id="">
                        <textarea name="keterangan_pintu_belakang_kanan" class="form-control" id="" placeholder="Keterangan Pintu Belakang Kanan" cols="30" rows="2">{{ $inspeksi_kanan->keterangan_pintu_belakang_kanan }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kanan->fender_belakang_kanan == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Fender Belakang Kanan</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kanan->cars->plat_nomor.'/berkas/pengecekkan_bagian_kanan/'.$inspeksi_kanan->foto_fender_belakang_kanan) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_fender_belakang_kanan" class="form-control" id="">
                        <textarea name="keterangan_fender_belakang_kanan" class="form-control" id="" placeholder="Keterangan Fender Belakang Kanan" cols="30" rows="2">{{ $inspeksi_kanan->keterangan_fender_belakang_kanan }}</textarea>
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
        $('#edit-bagian-kanan').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.update_inspeksi_kanan', ['id' => $inspeksi_kanan->id, 'inspeksi_kanan' => $inspeksi_kanan->cars_id]) }}",
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
                            window.location.href="{{ route('cars.buat_inspeksi',['id' => $inspeksi_kanan->cars_id]) }}";
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
