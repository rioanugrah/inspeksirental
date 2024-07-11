<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cars; // ini import Modelsnya Cars
use \Carbon\Carbon;
use Validator;
use File;
use DB;

class CarsController extends Controller
{

    function __construct(
        Cars $cars //Ini Parametersnya
    ){
        $this->cars = $cars; //Ini cara manggil parameters
    }

    public function index()
    {
        $data['cars'] = $this->cars->orderBy('created_at','asc')->get(); // Ini manggil data cars diurutkan berdasarkan tanggal buat
        return view('backend.cars.index',$data);
    }

    public function create() // Ini buat view create
    {
        return view('backend.cars.create');
    }

    public function store(Request $request) // Ini buat simpan data
    {
        $rules = [
            'plat_nomor_tengah'  => 'required',
            'warna'  => 'required',
            'merk'  => 'required',
            'model'  => 'required',
            'tahun'  => 'required',
            'no_rangka'  => 'required',
            'transmisi'  => 'required',
            'foto_kendaraan'  => 'required',
            'foto_stnk'  => 'required',
            'foto_sisi_depan'  => 'required',
            'foto_sisi_belakang'  => 'required',
            'foto_sisi_kanan'  => 'required',
            'foto_sisi_kiri'  => 'required',
            'foto_sisi_interior'  => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'plat_nomor_tengah.required'  => 'Plat Nomor wajib diisi lengkap.',
            'warna.required'  => 'Warna Mobil wajib diisi.',
            'merk.required'  => 'Merek Mobil wajib diisi.',
            'model.required'  => 'Model Mobil wajib diisi.',
            'tahun.required'  => 'Tahun Mobil wajib diisi.',
            'no_rangka.required'  => 'No. Rangka Mobil wajib diisi.',
            'transmisi.required'  => 'Transmisi Mobil wajib diisi.',
            'foto_kendaraan.required'  => 'Foto Kendaraan Mobil wajib diisi.',
            'foto_stnk.required'  => 'Foto STNK Mobil wajib diisi.',
            'foto_sisi_depan.required'  => 'Foto Sisi Depan Mobil wajib diisi.',
            'foto_sisi_belakang.required'  => 'Foto Sisi Belakang Mobil wajib diisi.',
            'foto_sisi_kanan.required'  => 'Foto Sisi Kanan Mobil wajib diisi.',
            'foto_sisi_kiri.required'  => 'Foto Sisi Kiri Mobil wajib diisi.',
            'foto_sisi_interior.required'  => 'Foto Sisi Interior Mobil wajib diisi.',
        ]; // Ini buat nampilkan pesan ketika error

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            $plat_mobil = $request->plat_nomor_depan.'-'.$request->plat_nomor_tengah.'-'.$request->plat_nomor_belakang;
            $path = public_path('backend/mobil/'.$plat_mobil);

            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
                File::makeDirectory(public_path('backend/mobil/'.$plat_mobil.'/berkas'), 0777, true, true);
            }

            $input['id'] = Str::uuid()->toString();
            $input['plat_nomor'] = $request->plat_nomor_depan.'-'.$request->plat_nomor_tengah.'-'.$request->plat_nomor_belakang;
            $input['warna'] = $request->warna;
            $input['merk'] = $request->merk;
            $input['model'] = $request->model;
            $input['tahun'] = $request->tahun;
            $input['no_rangka'] = $request->no_rangka;
            $input['transmisi'] = $request->transmisi;

            $image_foto_kendaraan = $request->file('foto_kendaraan');
            $img_foto_kendaraan = \Image::make($image_foto_kendaraan->path());
            $img_foto_kendaraan = $img_foto_kendaraan->encode('webp', 75);
            $input['foto_kendaraan'] = 'Full_Body_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_kendaraan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_kendaraan']);

            $image_foto_stnk = $request->file('foto_stnk');
            $img_foto_stnk = \Image::make($image_foto_stnk->path());
            $img_foto_stnk = $img_foto_stnk->encode('webp', 75);
            $input['foto_stnk'] = 'STNK_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_stnk->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_stnk']);

            $image_foto_sisi_depan = $request->file('foto_sisi_depan');
            $img_foto_sisi_depan = \Image::make($image_foto_sisi_depan->path());
            $img_foto_sisi_depan = $img_foto_sisi_depan->encode('webp', 75);
            $input['foto_sisi_depan'] = 'SisiDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_depan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_depan']);

            $image_foto_sisi_belakang = $request->file('foto_sisi_belakang');
            $img_foto_sisi_belakang = \Image::make($image_foto_sisi_belakang->path());
            $img_foto_sisi_belakang = $img_foto_sisi_belakang->encode('webp', 75);
            $input['foto_sisi_belakang'] = 'SisiBelakang_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_belakang']);

            $image_foto_sisi_kanan = $request->file('foto_sisi_kanan');
            $img_foto_sisi_kanan = \Image::make($image_foto_sisi_kanan->path());
            $img_foto_sisi_kanan = $img_foto_sisi_kanan->encode('webp', 75);
            $input['foto_sisi_kanan'] = 'SisiKanan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_kanan']);

            $image_foto_sisi_kiri = $request->file('foto_sisi_kiri');
            $img_foto_sisi_kiri = \Image::make($image_foto_sisi_kiri->path());
            $img_foto_sisi_kiri = $img_foto_sisi_kiri->encode('webp', 75);
            $input['foto_sisi_kiri'] = 'SisiKiri_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_kiri']);

            $image_foto_sisi_interior = $request->file('foto_sisi_interior');
            $img_foto_sisi_interior = \Image::make($image_foto_sisi_interior->path());
            $img_foto_sisi_interior = $img_foto_sisi_interior->encode('webp', 75);
            $input['foto_sisi_interior'] = 'SisiInterior_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_interior->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_interior']);

            // $input['foto_kendaraan'] = $request->foto_kendaraan;
            // $input['foto_stnk'] = $request->foto_stnk;
            // $input['foto_sisi_depan'] = $request->foto_sisi_depan;
            // $input['foto_sisi_belakang'] = $request->foto_sisi_belakang;
            // $input['foto_sisi_kanan'] = $request->foto_sisi_kanan;
            // $input['foto_sisi_kiri'] = $request->foto_sisi_kiri;
            // $input['foto_sisi_interior'] = $request->foto_sisi_interior;

            $save_cars = $this->cars->create($input);
            if ($save_cars) {
                $message_title="Berhasil !";
                $message_content= $request->plat_nomor_depan.' '.$request->plat_nomor_tengah.' '.$request->plat_nomor_belakang." Berhasil Disimpan";
                $message_type="success";
                $message_succes = true;
                // return redirect()->route()->with('success',' Mobil '.$input['plat_nomor'].' Berhasil Dibuat');
            }
            $array_message = array(
                'success' => $message_succes,
                'message_title' => $message_title,
                'message_content' => $message_content,
                'message_type' => $message_type,
            );
            return response()->json($array_message);
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );
        // return redirect()->back()->with(['error' => $validator->errors()->all()]);
    }

    public function show($id)
    {

        $data['car'] = $this->cars->find($id);
        return view('backend.cars.detail',$data);
    }

}
