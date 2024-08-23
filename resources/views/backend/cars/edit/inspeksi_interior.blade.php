@extends('layouts.backend.master')
@section('title')
    Edit Inspeksi Interior
@endsection
@section('content')
    <div class="col-md-12 mt-3">
        <div class="card">
            <form id="edit-bagian-interior" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <h6 class="card-title border-bottom p-3 mb-0 header-title">Edit Inspeksi Interior</h6>
                    <div class="row mt-3">
                        <div class="col-md-3 mb-3">
                            <label>Speedometer</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_speedometer) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_speedometer" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_speedometer" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_speedometer }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Setir</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_setir) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_setir" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_setir" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_setir }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Dasboard</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_dasboard) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_dasboard" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_dasboard" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_dasboard }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Plafon</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_plafon) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_plafon" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_plafon" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_plafon }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>AC</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_ac) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_ac" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_ac" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_ac }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Audio</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_audio) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_audio" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_audio" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_audio }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Jok</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_jok) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_jok" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_jok" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_jok }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Electric Spion</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_electric_spion) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_electric_spion" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_electric_spion" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_electric_spion }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Power Window</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_power_window) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_power_window" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_power_window" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_power_window }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Lain - Lain</label>
                            <img src="{{ asset('backend/mobil/' . $inspeksi_interior->cars->plat_nomor . '/berkas/pengecekkan_bagian_interior/' . $inspeksi_interior->foto_lain_lain) }}"
                                style="width: 250px; height: 250px; object-fit: contain;">
                            <input type="file" name="foto_lain_lain" class="form-control" id="">
                            <div style="font-weight: bold">Keterangan</div>
                            <div>
                                <textarea name="keterangan_lain_lain" class="form-control" id="" cols="30" rows="2">{{ $inspeksi_interior->keterangan_lain_lain }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary"
                        onclick="window.location.href='{{ url()->previous() }}'">Back</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
    <script>
        $('#edit-bagian-interior').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.update_inspeksi_interior', ['id' => $inspeksi_interior->id, 'inspeksi_interior' => $inspeksi_interior->cars_id]) }}",
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
                            window.location.href =
                                "{{ route('cars.buat_inspeksi', ['id' => $inspeksi_interior->cars_id]) }}";
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
