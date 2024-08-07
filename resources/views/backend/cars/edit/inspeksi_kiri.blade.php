@extends('layouts.backend.master')
@section('title')
   Edit Inspeksi Kiri
@endsection
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card">
            <form id="edit-bagian-kiri" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h6 class="card-title border-bottom p-3 mb-0 header-title">Edit Inspeksi Kiri</h6>
                <div class="row mt-3">
                    @if ($inspeksi_kiri->fender_depan_kiri == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Fender Depan Kiri</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kiri->cars->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$inspeksi_kiri->foto_fender_depan_kiri) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <textarea name="keterangan_fender_depan_kiri" class="form-control" id="" placeholder="Keterangan Fender Depan Kiri" cols="30" rows="2">{{ $inspeksi_kiri->keterangan_fender_depan_kiri }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kiri->kaki_depan_kiri == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Kaki Depan Kiri</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kiri->cars->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$inspeksi_kiri->foto_kaki_depan_kiri) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <textarea name="keterangan_kaki_depan_kiri" class="form-control" id="" placeholder="Keterangan Kaki Depan Kiri" cols="30" rows="2">{{ $inspeksi_kiri->keterangan_kaki_depan_kiri }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kiri->kaki_belakang_kiri == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Kaki Belakang Kiri</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kiri->cars->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$inspeksi_kiri->foto_kaki_belakang_kiri) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <textarea name="keterangan_kaki_belakang_kiri" class="form-control" id="" placeholder="Keterangan Kaki Belakang Kiri" cols="30" rows="2">{{ $inspeksi_kiri->keterangan_kaki_belakang_kiri }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kiri->pintu_depan_kiri == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Pintu Depan Kiri</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kiri->cars->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$inspeksi_kiri->foto_pintu_depan_kiri) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <textarea name="keterangan_pintu_depan_kiri" class="form-control" id="" placeholder="Keterangan Pintu Depan Kiri" cols="30" rows="2">{{ $inspeksi_kiri->keterangan_pintu_depan_kiri }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kiri->pintu_belakang_kiri == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Pintu Belakang Kiri</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kiri->cars->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$inspeksi_kiri->foto_pintu_belakang_kiri) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <textarea name="keterangan_pintu_belakang_kiri" class="form-control" id="" placeholder="Keterangan Pintu Belakang Kiri" cols="30" rows="2">{{ $inspeksi_kiri->keterangan_pintu_belakang_kiri }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_kiri->fender_belakang_kiri == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Fender Belakang Kiri</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_kiri->cars->plat_nomor.'/berkas/pengecekkan_bagian_kiri/'.$inspeksi_kiri->foto_fender_belakang_kiri) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <textarea name="keterangan_fender_belakang_kiri" class="form-control" id="" placeholder="Keterangan Fender Belakang Kiri" cols="30" rows="2">{{ $inspeksi_kiri->keterangan_fender_belakang_kiri }}</textarea>
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
        $('#edit-bagian-kiri').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.update_inspeksi_kiri', ['id' => $inspeksi_kiri->id, 'inspeksi_kiri' => $inspeksi_kiri->cars_id]) }}",
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
                            window.location.href="{{ route('cars.buat_inspeksi',['id' => $inspeksi_kiri->cars_id]) }}";
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