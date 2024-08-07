@extends('layouts.backend.master')
@section('title')
   Edit Inspeksi Lain - Lain
@endsection
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card">
            <form id="edit-bagian-lain" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h6 class="card-title border-bottom p-3 mb-0 header-title">Edit Inspeksi Lain - Lain</h6>
                <div class="row mt-3">
                    @foreach (json_decode($inspeksi_lain->body) as $key => $inspeksi_lain_data)
                    <div class="col-md-3">
                        <div style="font-weight: bold">Keterangan Lain - Lain {{ $key+1 }}</div>
                        <img src="{{ asset('backend/mobil/'.$inspeksi_lain->cars->plat_nomor.'/berkas/pengecekkan_bagian_lain/'.$inspeksi_lain_data->foto_lain_lain) }}" class="mt-2 mb-2" style="width: 250px; height: 250px; object-fit: contain;">
                        <textarea name="keterangan_lain_lain[]" class="form-control" cols="30" rows="2">{{ $inspeksi_lain_data->keterangan_lain_lain }}</textarea>
                    </div>
                    @endforeach
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
        $('#edit-bagian-lain').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.update_inspeksi_lain', ['id' => $inspeksi_lain->id, 'inspeksi_lain' => $inspeksi_lain->cars_id]) }}",
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
                            window.location.href="{{ route('cars.buat_inspeksi',['id' => $inspeksi_lain->cars_id]) }}";
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