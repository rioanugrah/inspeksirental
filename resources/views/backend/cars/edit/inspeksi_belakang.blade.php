@extends('layouts.backend.master')
@section('title')
   Edit Inspeksi Belakang
@endsection
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card">
            <form id="edit-bagian-belakang" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h6 class="card-title border-bottom p-3 mb-0 header-title">Edit Inspeksi Belakang</h6>
                <div class="row mt-3">
                    @if ($inspeksi_belakang->lampu_belakang == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Lampu Belakang</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_belakang->cars->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$inspeksi_belakang->foto_lampu_belakang) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_lampu_belakang" class="form-control" id="">
                        <textarea name="keterangan_lampu_belakang" class="form-control" id="" placeholder="Keterangan Lampu Belakang" cols="30" rows="2">{{ $inspeksi_belakang->keterangan_lampu_belakang }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_belakang->pintu_bagasi_belakang == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Pintu Bagasi Belakang</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_belakang->cars->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$inspeksi_belakang->foto_pintu_bagasi_belakang) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_pintu_bagasi_belakang" class="form-control" id="">
                        <textarea name="keterangan_pintu_bagasi_belakang" class="form-control" id="" placeholder="Keterangan Pintu Bagasi Belakang" cols="30" rows="2">{{ $inspeksi_belakang->keterangan_pintu_bagasi_belakang }}</textarea>
                    </div>
                    @endif
                    @if ($inspeksi_belakang->bumper_belakang == 'Rusak')
                    <div class="col-md-3 mb-3">
                        <label>Bumper Belakang</label>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_belakang->cars->plat_nomor.'/berkas/pengecekkan_bagian_belakang/'.$inspeksi_belakang->foto_bumper_belakang) }}" style="width: 250px; height: 250px; object-fit: contain;">
                        <input type="file" name="foto_bumper_belakang" class="form-control" id="">
                        <textarea name="keterangan_bumper_belakang" class="form-control" id="" placeholder="Keterangan Bumper Belakang" cols="30" rows="2">{{ $inspeksi_belakang->keterangan_bumper_belakang }}</textarea>
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
        $('#edit-bagian-belakang').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.update_inspeksi_belakang', ['id' => $inspeksi_belakang->id, 'inspeksi_belakang' => $inspeksi_belakang->cars_id]) }}",
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
                            window.location.href="{{ route('cars.buat_inspeksi',['id' => $inspeksi_belakang->cars_id]) }}";
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
