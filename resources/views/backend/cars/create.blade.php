@extends('layouts.backend.master')

@section('title')
    Tambah Data Mobil
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-box">
                <h4 class="page-title">Buat Data Identitas Mobil</h4>
            </div>
            <form method="post" id="upload-simpan" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Plat Nomor</label>
                                    <div class="input-group">
                                        <input type="text" name="plat_nomor_depan" class="form-control" placeholder="XX"
                                            required id="">
                                        <input type="text" name="plat_nomor_tengah" class="form-control"
                                            placeholder="1234" required id="plat_nomor_tengah">
                                        <input type="text" name="plat_nomor_belakang" class="form-control"
                                            placeholder="XX" required id="">
                                    </div>
                                    {{-- <input type="text" name="plat_nomor" class="form-control" id="plat_nomor" placeholder="Plat Nomor"> --}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Warna Mobil</label>
                                    <input type="text" name="warna" class="form-control" placeholder="Isi Warna">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Merk Mobil</label>
                                    <input type="text" name="merk" class="form-control" placeholder="Isi Merk Mobil">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Model Mobil</label>
                                    <input type="text" name="model" class="form-control" placeholder="Isi Model Mobil">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control" id="">
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach (range(date('Y'), 1900) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" name="tahun" class="form-control" placeholder="Pilih Tahun Mobil"> --}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Nomor Rangka</label>
                                    <input type="text" name="no_rangka" class="form-control"
                                        placeholder="Isi Nomor Rangka Mobil">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Transmisi</label>
                                    <input type="text" name="transmisi" class="form-control"
                                        placeholder="Isi Transmisi Mobil">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Foto Kendaraan</label>
                                    <input type="file" name="foto_kendaraan" class="form-control" placeholder="Foto Kendaraan">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Foto STNK</label>
                                    <input type="file" name="foto_stnk" class="form-control" placeholder="Foto STNK">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Foto Sisi Depan</label>
                                            <input type="file" name="foto_sisi_depan" class="form-control"
                                                placeholder="Foto Sisi Depan">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Foto Sisi Kanan</label>
                                            <input type="file" name="foto_sisi_kanan" class="form-control"
                                                placeholder="Foto Sisi Kanan">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Foto Sisi Kiri</label>
                                            <input type="file" name="foto_sisi_kiri" class="form-control"
                                                placeholder="Foto Sisi Kiri">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Foto Sisi Belakang</label>
                                            <input type="file" name="foto_sisi_belakang" class="form-control"
                                                placeholder="Foto Sisi Belakang">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Foto Interior Mobil</label>
                                            <input type="file" name="foto_sisi_interior" class="form-control"
                                                placeholder="Foto Interior">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend/assets/js/pages/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/jquery.SimpleMask.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script>
        $('#plat_nomor_tengah').simpleMask({
            'mask': ['####']
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#upload-simpan').submit(function(e) {
            // alert('coba');
            e.preventDefault();
            let formData = new FormData(this);
            // $('#image-input-error').text('');
            $.ajax({
                type: 'POST',
                url: "{{ route('cars.store') }}",
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
                    } else {
                        Swal.fire({
                            icon: result.message_type,
                            title: result.message_title,
                            text: result.message_content,
                            showConfirmButton: false,
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
