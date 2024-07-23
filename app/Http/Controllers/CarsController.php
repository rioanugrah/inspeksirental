<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cars; // ini import Modelsnya Cars
use App\Models\InspeksiDepan;
use App\Models\InspeksiKiri;
use App\Models\InspeksiKanan;
use App\Models\InspeksiBelakang;
use App\Models\InspeksiInterior;

use App\Mail\InvoiceInspeksi;

use \Carbon\Carbon;
use Validator;
use File;
use DB;
use DataTables;
use PDF;
use Mail;

class CarsController extends Controller
{

    function __construct(
        Cars $cars, //Ini Parametersnya
        InspeksiDepan $inspeksi_depan,
        InspeksiKiri $inspeksi_kiri,
        InspeksiKanan $inspeksi_kanan,
        InspeksiBelakang $inspeksi_belakang,
        InspeksiInterior $inspeksi_interior,
        InvoiceInspeksi $invoiceInspeksi
    ){
        $this->cars = $cars; //Ini cara manggil parameters
        $this->inspeksi_depan = $inspeksi_depan;
        $this->inspeksi_kiri = $inspeksi_kiri;
        $this->inspeksi_kanan = $inspeksi_kanan;
        $this->inspeksi_belakang = $inspeksi_belakang;
        $this->inspeksi_interior = $inspeksi_interior;

        $this->invoiceInspeksi = $invoiceInspeksi;
    }

    public function index(Request $request)
    {
        // dd(auth()->user()->getRoleNames()->first());
        // $data['cars'] = $this->cars->orderBy('created_at','asc')->paginate(1); // Ini manggil data cars diurutkan berdasarkan tanggal buat
        // if (auth()->user()->getRoleNames()->first() == 'Administrator') {
        //     return view('backend.cars.index',$data);
        // }elseif(auth()->user()->getRoleNames()->first() == 'Admin'){
        //     return view('backend.cars.admin.index',$data);
        // }
        if ($request->ajax()) {
            $data = $this->cars->all();
            return DataTables::of($data)
                                ->addIndexColumn()
                                ->addColumn('foto_kendaraan', function($row){
                                    return '<img src='.asset('backend/mobil/'.$row->plat_nomor.'/berkas/'.$row->foto_kendaraan).' width=150>';
                                })
                                ->addColumn('status', function($row){
                                    switch ($row->status) {
                                        case 'Waiting':
                                            return '<span class="badge bg-warning">Menunggu Inspeksi</span>';
                                            break;
                                        case 'Proses':
                                            return '<span class="badge bg-info">Proses Inspeksi</span>';
                                            break;
                                        case 'Selesai':
                                            return '<span class="badge bg-success">Selesai</span>';
                                            break;
                                        default:
                                            # code...
                                            break;
                                    }
                                })
                                ->addColumn('hasil_inspeksi', function($row){
                                    if (
                                        empty($row->detail_inspeksi_depan) && 
                                        empty($row->detail_inspeksi_kiri) &&
                                        empty($row->detail_inspeksi_belakang) &&
                                        empty($row->detail_inspeksi_kanan) &&
                                        empty($row->detail_inspeksi_interior)
                                    ) {
                                        return '-';
                                    }else{
                                        $total_inspeksi_depan = $row->detail_inspeksi_depan->select(
                                            array(
                                                DB::raw('(
                                                            (
                                                                COUNT(CASE kaca_depan WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                COUNT(CASE kap_mesin WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE rangka_mobil WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE aki WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE radiator WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE kondisi_mesin WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE bumper_lampu WHEN "Baik" THEN 1 ELSE NULL END)
                                                            )/7
                                                        )*100
                                                        as total_baik'),
                                            )
                                        )->first();

                                        $total_inspeksi_kiri = $row->detail_inspeksi_kiri->select(
                                            array(
                                                DB::raw('(
                                                            (
                                                                COUNT(CASE fender_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                COUNT(CASE kaki_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE kaki_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE pintu_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE pintu_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE fender_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END)
                                                            )/6
                                                        )*100
                                                        as total_baik'),
                                            )
                                        )->first();

                                        $total_inspeksi_kanan = $row->detail_inspeksi_kanan->select(
                                            array(
                                                DB::raw('(
                                                            (
                                                                COUNT(CASE fender_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                COUNT(CASE kaki_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE kaki_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE pintu_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE pintu_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE fender_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END)
                                                            )/6
                                                        )*100
                                                        as total_baik'),
                                            )
                                        )->first();

                                        $total_inspeksi_belakang = $row->detail_inspeksi_belakang->select(
                                            array(
                                                DB::raw('(
                                                            (
                                                                COUNT(CASE lampu_belakang WHEN "Baik" THEN 1 ELSE NULL END) +
                                                                COUNT(CASE pintu_bagasi_belakang WHEN "Baik" THEN 1 ELSE NULL END) + 
                                                                COUNT(CASE bumper_belakang WHEN "Baik" THEN 1 ELSE NULL END)
                                                            )/3
                                                        )*100
                                                        as total_baik'),
                                            )
                                        )->first();

                                        $total_all_inspeksi = ($total_inspeksi_depan['total_baik']+$total_inspeksi_kiri['total_baik']+$total_inspeksi_kanan['total_baik']+$total_inspeksi_belakang['total_baik'])/4;

                                        return $total_all_inspeksi < 50 ? '<span class="badge bg-danger">'.round($total_all_inspeksi).' %</span>' : '<span class="badge bg-success">'.round($total_all_inspeksi).' %</span>';
                                    }
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<div class="button-list">';
                                    if ($row->status != 'Selesai') {
                                        $btn = $btn.'<a href='.route('cars.buat_inspeksi',['id' => $row->id]).' class="btn btn-warning"><i class="bi-pencil-square"></i> Mulai Inspeksi</a>';
                                    }else{
                                        $btn = $btn.'<a href='.route('cars.download',['id' => $row->id]).' class="btn btn-primary"><i class="bi-files"></i> Download Hasil</a>';
                                        $btn = $btn.'<a href="javascript:void(0)" class="btn btn-info"><i class="bi-envelope"></i> Kirim Email</a>';
                                    }
                                    $btn = $btn.'<a href="javascript:void(0)" class="btn btn-danger"><i class="bi-trash2"></i> Delete</a>';
                                    $btn = $btn.'</div>';
                                    return $btn;
                                })
                                ->rawColumns(['action','foto_kendaraan','hasil_inspeksi','status'])
                                ->make(true);
        }
        return view('backend.cars.index');
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
            $input['no_reference'] = date('Ymd').rand(100,999);
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
            $input['status'] = 'Waiting';
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
                'id' => $input['id']
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
        if (empty($data['car'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.detail',$data);
    }

    public function buat_inspeksi($id)
    {
        $data['car'] = $this->cars->where('id',$id)
                                    ->where('status', 'Waiting')
                                    ->orWhere('status', 'Proses')
                                    ->first();
        if (empty($data['car'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }

        if (empty($data['car']->detail_inspeksi_depan)) {
            $data['total_inspeksi_depan'] = [
                'total_rusak' => 0,
                'total_baik' => 0,
            ];
        }else{
            $data['total_inspeksi_depan'] = $data['car']->detail_inspeksi_depan->select(
                array(
                    DB::raw('(
                                (
                                    COUNT(CASE kaca_depan WHEN "Rusak" THEN 1 ELSE NULL END) +
                                    COUNT(CASE kap_mesin WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE rangka_mobil WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE aki WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE radiator WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE kondisi_mesin WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE bumper_lampu WHEN "Rusak" THEN 1 ELSE NULL END)
                                )/7
                            )*100
                            as total_rusak'),
                    DB::raw('(
                                (
                                    COUNT(CASE kaca_depan WHEN "Baik" THEN 1 ELSE NULL END) +
                                    COUNT(CASE kap_mesin WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE rangka_mobil WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE aki WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE radiator WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE kondisi_mesin WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE bumper_lampu WHEN "Baik" THEN 1 ELSE NULL END)
                                )/7
                            )*100
                            as total_baik'),
                )
            )->first();
        }

        if (empty($data['car']->detail_inspeksi_kiri)) {
            $data['total_inspeksi_kiri'] = [
                'total_rusak' => 0,
                'total_baik' => 0,
            ];
        }else{
            $data['total_inspeksi_kiri'] = $data['car']->detail_inspeksi_kiri->select(
                array(
                    DB::raw('(
                                (
                                    COUNT(CASE fender_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) +
                                    COUNT(CASE kaki_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE kaki_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE fender_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END)
                                )/6
                            )*100
                            as total_rusak'),
                    DB::raw('(
                                (
                                    COUNT(CASE fender_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
                                    COUNT(CASE kaki_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE kaki_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE fender_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END)
                                )/6
                            )*100
                            as total_baik'),
                )
            )->first();
        }

        if (empty($data['car']->detail_inspeksi_kanan)) {
            $data['total_inspeksi_kanan'] = [
                'total_rusak' => 0,
                'total_baik' => 0,
            ];
        }else{
            $data['total_inspeksi_kanan'] = $data['car']->detail_inspeksi_kanan->select(
                array(
                    DB::raw('(
                                (
                                    COUNT(CASE fender_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) +
                                    COUNT(CASE kaki_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE kaki_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE fender_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END)
                                )/6
                            )*100
                            as total_rusak'),
                    DB::raw('(
                                (
                                    COUNT(CASE fender_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
                                    COUNT(CASE kaki_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE kaki_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE pintu_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE fender_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END)
                                )/6
                            )*100
                            as total_baik'),
                )
            )->first();
        }

        if (empty($data['car']->detail_inspeksi_belakang)) {
            $data['total_inspeksi_belakang'] = [
                'total_rusak' => 0,
                'total_baik' => 0,
            ];
        }else{
            $data['total_inspeksi_belakang'] = $data['car']->detail_inspeksi_belakang->select(
                array(
                    DB::raw('(
                                (
                                    COUNT(CASE lampu_belakang WHEN "Rusak" THEN 1 ELSE NULL END) +
                                    COUNT(CASE pintu_bagasi_belakang WHEN "Rusak" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE bumper_belakang WHEN "Rusak" THEN 1 ELSE NULL END)
                                )/3
                            )*100
                            as total_rusak'),
                    DB::raw('(
                                (
                                    COUNT(CASE lampu_belakang WHEN "Baik" THEN 1 ELSE NULL END) +
                                    COUNT(CASE pintu_bagasi_belakang WHEN "Baik" THEN 1 ELSE NULL END) + 
                                    COUNT(CASE bumper_belakang WHEN "Baik" THEN 1 ELSE NULL END)
                                )/3
                            )*100
                            as total_baik'),
                )
            )->first();
        }

        // dd($data);

        return view('backend.cars.buat_inspeksi',$data);
    }

    public function simpan_inspeksi_depan(Request $request,$id)
    {
        $rules = [
            'kaca_depan'  => 'required',
            'kap_mesin'  => 'required',
            'rangka_mobil'  => 'required',
            'aki'  => 'required',
            'radiator'  => 'required',
            'kondisi_mesin'  => 'required',
            'bumper_lampu'  => 'required',
        ];

        $messages = [
            'kaca_depan.required'  => 'Kaca Depan wajib diisi lengkap.',
            'kap_mesin.required'  => 'Kap Mobil wajib diisi.',
            'rangka_mobil.required'  => 'Rangka Mobil wajib diisi.',
            'aki.required'  => 'Aki Mobil wajib diisi.',
            'radiator.required'  => 'Radiator Mobil wajib diisi.',
            'kondisi_mesin.required'  => 'Kondisi Mobil wajib diisi.',
            'bumper_lampu.required'  => 'Bumper Lampu Mobil wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $check_cars = $this->cars->find($id);
            $plat_mobil = $check_cars->plat_nomor;

            // dd($plat_mobil);
            $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            //Inspeksi Bagian Depan
            $inputBagianDepan['id'] = Str::uuid()->toString();
            $inputBagianDepan['cars_id'] = $id;
            $inputBagianDepan['kaca_depan'] = $request->kaca_depan;
            $inputBagianDepan['kap_mesin'] = $request->kap_mesin;
            $inputBagianDepan['rangka_mobil'] = $request->rangka_mobil;
            $inputBagianDepan['aki'] = $request->aki;
            $inputBagianDepan['radiator'] = $request->radiator;
            $inputBagianDepan['kondisi_mesin'] = $request->kondisi_mesin;
            $inputBagianDepan['bumper_lampu'] = $request->bumper_lampu;

            if ($request->file('foto_kaca_depan')) {
                $image_foto_kaca_depan = $request->file('foto_kaca_depan');
                $img_foto_kaca_depan = \Image::make($image_foto_kaca_depan->path());
                $img_foto_kaca_depan = $img_foto_kaca_depan->encode('webp',75);
                $inputBagianDepan['foto_kaca_depan'] = 'KacaDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_kaca_depan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_kaca_depan']);
            }
            if ($request->file('foto_kap_mesin')) {
                $image_foto_kap_mesin = $request->file('foto_kap_mesin');
                $img_foto_kap_mesin = \Image::make($image_foto_kap_mesin->path());
                $img_foto_kap_mesin = $img_foto_kap_mesin->encode('webp',75);
                $inputBagianDepan['foto_kap_mesin'] = 'KapMesinDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_kap_mesin->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_kap_mesin']);
            }
            if ($request->file('foto_rangka_mobil')) {
                $image_foto_rangka_mobil = $request->file('foto_rangka_mobil');
                $img_foto_rangka_mobil = \Image::make($image_foto_rangka_mobil->path());
                $img_foto_rangka_mobil = $img_foto_rangka_mobil->encode('webp',75);
                $inputBagianDepan['foto_rangka_mobil'] = 'RangkaMobilDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_rangka_mobil->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_rangka_mobil']);
            }
            if ($request->file('foto_aki')) {
                $image_foto_aki = $request->file('foto_aki');
                $img_foto_aki = \Image::make($image_foto_aki->path());
                $img_foto_aki = $img_foto_aki->encode('webp',75);
                $inputBagianDepan['foto_aki'] = 'AkiMobilDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_aki->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_aki']);
            }
            if ($request->file('foto_radiator')) {
                $image_foto_radiator = $request->file('foto_radiator');
                $img_foto_radiator = \Image::make($image_foto_radiator->path());
                $img_foto_radiatori = $img_foto_radiator->encode('webp',75);
                $inputBagianDepan['foto_radiator'] = 'RadiatorMobilDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_radiator->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_radiator']);
            }
            if ($request->file('foto_kondisi_mesin')) {
                $image_foto_kondisi_mesin = $request->file('foto_kondisi_mesin');
                $img_foto_kondisi_mesin = \Image::make($image_foto_kondisi_mesin->path());
                $img_foto_kondisi_mesin = $img_foto_kondisi_mesin->encode('webp',75);
                $inputBagianDepan['foto_kondisi_mesin'] = 'KondisiMesinMobilDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_kondisi_mesin->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_kondisi_mesin']);
            }
            if ($request->file('foto_bumper_lampu')) {
                $image_foto_bumper_mobil = $request->file('foto_bumper_lampu');
                $img_foto_bumper_mobil = \Image::make($image_foto_bumper_mobil->path());
                $img_foto_bumper_mobil = $img_foto_bumper_mobil->encode('webp',75);
                $inputBagianDepan['foto_bumper_lampu'] = 'BumperLampuMobilDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_bumper_mobil->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_bumper_lampu']);
            }
            //End Inspeksi Bagian Depan

            $save_inspeksi_depan = $this->inspeksi_depan->create($inputBagianDepan);

            if ($save_inspeksi_depan) {
                $message_title="Berhasil !";
                $message_content= "Inspeksi Bagian Depan Plat Nomor ".$plat_mobil." Berhasil Dibuat. Silahkan Tunggu Memuat Ulang";
                $message_type="success";
                $message_succes = true;
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
    }

    public function simpan_inspeksi_kiri(Request $request,$id)
    {
        $rules = [
            'fender_depan_kiri'  => 'required',
            'kaki_depan_kiri'  => 'required',
            'kaki_belakang_kiri'  => 'required',
            'pintu_depan_kiri'  => 'required',
            'pintu_belakang_kiri'  => 'required',
            'fender_belakang_kiri'  => 'required',
        ];

        $messages = [
            'fender_depan_kiri.required'  => 'Fender Depan Kiri Mobil wajib diisi.',
            'kaki_depan_kiri.required'  => 'Kaki Depan Kiri Mobil wajib diisi.',
            'kaki_belakang_kiri.required'  => 'Kaki Belakang Kiri Mobil wajib diisi.',
            'pintu_depan_kiri.required'  => 'Pintu Depan Kiri Mobil wajib diisi.',
            'pintu_belakang_kiri.required'  => 'Pintu Belakang Kiri Mobil wajib diisi.',
            'fender_belakang_kiri.required'  => 'Fender Belakang Kiri Mobil wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $check_cars = $this->cars->find($id);
            $plat_mobil = $check_cars->plat_nomor;

            // dd($plat_mobil);
            $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $inputBagianKiri['id'] = Str::uuid()->toString();
            $inputBagianKiri['cars_id'] = $id;
            $inputBagianKiri['fender_depan_kiri'] = $request->fender_depan_kiri;
            $inputBagianKiri['kaki_depan_kiri'] = $request->kaki_depan_kiri;
            $inputBagianKiri['kaki_belakang_kiri'] = $request->kaki_belakang_kiri;
            $inputBagianKiri['pintu_depan_kiri'] = $request->pintu_depan_kiri;
            $inputBagianKiri['pintu_belakang_kiri'] = $request->pintu_belakang_kiri;
            $inputBagianKiri['fender_belakang_kiri'] = $request->fender_belakang_kiri;

            if ($request->file('foto_fender_depan_kiri')) {
                $image_depan_foto_fender_depan_kiri = $request->file('foto_fender_depan_kiri');
                $img_depan_foto_fender_depan_kiri = \Image::make($image_depan_foto_fender_depan_kiri->path());
                $img_depan_foto_fender_depan_kiri = $img_depan_foto_fender_depan_kiri->encode('webp',75);
                $inputBagianKiri['foto_fender_depan_kiri'] = 'FenderDepanKiri'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_fender_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_fender_depan_kiri']);
            }
            if ($request->file('foto_kaki_depan_kiri')) {
                $image_depan_foto_kaki_depan_kiri = $request->file('foto_kaki_depan_kiri');
                $img_depan_foto_kaki_depan_kiri = \Image::make($image_depan_foto_kaki_depan_kiri->path());
                $img_depan_foto_kaki_depan_kiri = $img_depan_foto_kaki_depan_kiri->encode('webp',75);
                $inputBagianKiri['foto_kaki_depan_kiri'] = 'KakiDepanKiri'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_kaki_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_kaki_depan_kiri']);
            }
            if ($request->file('foto_kaki_belakang_kiri')) {
                $image_depan_foto_kaki_belakang_kiri = $request->file('foto_kaki_belakang_kiri');
                $img_depan_foto_kaki_belakang_kiri = \Image::make($image_depan_foto_kaki_belakang_kiri->path());
                $img_depan_foto_kaki_belakang_kiri = $img_depan_foto_kaki_belakang_kiri->encode('webp',75);
                $inputBagianKiri['foto_kaki_belakang_kiri'] = 'KakiBelakangKiri'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_kaki_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_kaki_belakang_kiri']);
            }
            if ($request->file('foto_pintu_depan_kiri')) {
                $image_depan_foto_pintu_depan_kiri = $request->file('foto_pintu_depan_kiri');
                $img_depan_foto_pintu_depan_kiri = \Image::make($image_depan_foto_pintu_depan_kiri->path());
                $img_depan_foto_pintu_depan_kiri = $img_depan_foto_pintu_depan_kiri->encode('webp',75);
                $inputBagianKiri['foto_pintu_depan_kiri'] = 'PintuDepanKiri'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_pintu_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_pintu_depan_kiri']);
            }
            if ($request->file('foto_pintu_belakang_kiri')) {
                $image_depan_foto_pintu_belakang_kiri = $request->file('foto_pintu_belakang_kiri');
                $img_depan_foto_pintu_belakang_kiri = \Image::make($image_depan_foto_pintu_belakang_kiri->path());
                $img_depan_foto_pintu_belakang_kiri = $img_depan_foto_pintu_belakang_kiri->encode('webp',75);
                $inputBagianKiri['foto_pintu_belakang_kiri'] = 'PintuBelakangKiri'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_pintu_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_pintu_belakang_kiri']);
            }
            if ($request->file('foto_fender_belakang_kiri')) {
                $image_depan_foto_fender_belakang_kiri = $request->file('foto_fender_belakang_kiri');
                $img_depan_foto_fender_belakang_kiri = \Image::make($image_depan_foto_fender_belakang_kiri->path());
                $img_depan_foto_fender_belakang_kiri = $img_depan_foto_fender_belakang_kiri->encode('webp',75);
                $inputBagianKiri['foto_fender_belakang_kiri'] = 'FenderBelakangKiri'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_fender_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_fender_belakang_kiri']);
            }

            $save_inspeksi_kiri = $this->inspeksi_kiri->create($inputBagianKiri);

            if ($save_inspeksi_kiri) {
                $message_title="Berhasil !";
                $message_content= "Inspeksi Bagian Kiri Plat Nomor ".$plat_mobil." Berhasil Dibuat. Silahkan Tunggu Memuat Ulang";
                $message_type="success";
                $message_succes = true;
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
    }

    public function simpan_inspeksi_kanan(Request $request,$id)
    {
        $rules = [
            'fender_depan_kanan'  => 'required',
            'kaki_depan_kanan'  => 'required',
            'kaki_belakang_kanan'  => 'required',
            'pintu_depan_kanan'  => 'required',
            'pintu_belakang_kanan'  => 'required',
            'fender_belakang_kanan'  => 'required',
        ];

        $messages = [
            'fender_depan_kanan.required'  => 'Fender Depan Kanan Mobil wajib diisi.',
            'kaki_depan_kanan.required'  => 'Kaki Depan Kanan Mobil wajib diisi.',
            'kaki_belakang_kanan.required'  => 'Kaki Belakang Kanan Mobil wajib diisi.',
            'pintu_depan_kanan.required'  => 'Pintu Depan Kanan Mobil wajib diisi.',
            'pintu_belakang_kanan.required'  => 'Pintu Belakang Kanan Mobil wajib diisi.',
            'fender_belakang_kanan.required'  => 'Fender Belakang Kanan Mobil wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $check_cars = $this->cars->find($id);
            $plat_mobil = $check_cars->plat_nomor;

            // dd($plat_mobil);
            $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $inputBagianKanan['id'] = Str::uuid()->toString();
            $inputBagianKanan['cars_id'] = $id;
            $inputBagianKanan['fender_depan_kanan'] = $request->fender_depan_kanan;
            $inputBagianKanan['kaki_depan_kanan'] = $request->kaki_depan_kanan;
            $inputBagianKanan['kaki_belakang_kanan'] = $request->kaki_belakang_kanan;
            $inputBagianKanan['pintu_depan_kanan'] = $request->pintu_depan_kanan;
            $inputBagianKanan['pintu_belakang_kanan'] = $request->pintu_belakang_kanan;
            $inputBagianKanan['fender_belakang_kanan'] = $request->fender_belakang_kanan;

            if ($request->file('foto_fender_depan_kanan')) {
                $image_depan_foto_fender_depan_kanan = $request->file('foto_fender_depan_kanan');
                $img_depan_foto_fender_depan_kanan = \Image::make($image_depan_foto_fender_depan_kanan->path());
                $img_depan_foto_fender_depan_kanan = $img_depan_foto_fender_depan_kanan->encode('webp',75);
                $inputBagianKanan['foto_fender_depan_kanan'] = 'FenderDepanKanan'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_fender_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_fender_depan_kanan']);
            }
            if ($request->file('foto_kaki_depan_kanan')) {
                $image_depan_foto_kaki_depan_kanan = $request->file('foto_kaki_depan_kanan');
                $img_depan_foto_kaki_depan_kanan = \Image::make($image_depan_foto_kaki_depan_kanan->path());
                $img_depan_foto_kaki_depan_kanan = $img_depan_foto_kaki_depan_kanan->encode('webp',75);
                $inputBagianKanan['foto_kaki_depan_kanan'] = 'KakiDepanKanan'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_kaki_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_kaki_depan_kanan']);
            }
            if ($request->file('foto_kaki_belakang_kanan')) {
                $image_depan_foto_kaki_belakang_kanan = $request->file('foto_kaki_belakang_kanan');
                $img_depan_foto_kaki_belakang_kanan = \Image::make($image_depan_foto_kaki_belakang_kanan->path());
                $img_depan_foto_kaki_belakang_kanan = $img_depan_foto_kaki_belakang_kanan->encode('webp',75);
                $inputBagianKanan['foto_kaki_belakang_kanan'] = 'KakiBelakangKanan'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_kaki_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_kaki_belakang_kanan']);
            }
            if ($request->file('foto_pintu_depan_kanan')) {
                $image_depan_foto_pintu_depan_kanan = $request->file('foto_pintu_depan_kanan');
                $img_depan_foto_pintu_depan_kanan = \Image::make($image_depan_foto_pintu_depan_kanan->path());
                $img_depan_foto_pintu_depan_kanan = $img_depan_foto_pintu_depan_kanan->encode('webp',75);
                $inputBagianKanan['foto_pintu_depan_kanan'] = 'PintuDepanKanan'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_pintu_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_pintu_depan_kanan']);
            }
            if ($request->file('foto_pintu_belakang_kanan')) {
                $image_depan_foto_pintu_belakang_kanan = $request->file('foto_pintu_belakang_kanan');
                $img_depan_foto_pintu_belakang_kanan = \Image::make($image_depan_foto_pintu_belakang_kanan->path());
                $img_depan_foto_pintu_belakang_kanan = $img_depan_foto_pintu_belakang_kanan->encode('webp',75);
                $inputBagianKanan['foto_pintu_belakang_kanan'] = 'PintuBelakangKanan'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_pintu_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_pintu_belakang_kanan']);
            }
            if ($request->file('foto_fender_belakang_kanan')) {
                $image_depan_foto_fender_belakang_kanan = $request->file('foto_fender_belakang_kanan');
                $img_depan_foto_fender_belakang_kanan = \Image::make($image_depan_foto_fender_belakang_kanan->path());
                $img_depan_foto_fender_belakang_kanan = $img_depan_foto_fender_belakang_kanan->encode('webp',75);
                $inputBagianKanan['foto_fender_belakang_kanan'] = 'FenderBelakangKanan'.$plat_mobil.'_'.time().'.webp';
                $img_depan_foto_fender_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_fender_belakang_kanan']);
            }

            $save_inspeksi_kanan = $this->inspeksi_kanan->create($inputBagianKanan);

            if ($save_inspeksi_kanan) {
                $message_title="Berhasil !";
                $message_content= "Inspeksi Bagian Kanan Plat Nomor ".$plat_mobil." Berhasil Dibuat. Silahkan Tunggu Memuat Ulang";
                $message_type="success";
                $message_succes = true;
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
    }

    public function simpan_inspeksi_belakang(Request $request,$id)
    {
        $rules = [
            'lampu_belakang'  => 'required',
            'pintu_bagasi_belakang'  => 'required',
            'bumper_belakang'  => 'required',
        ];

        $messages = [
            'lampu_belakang.required'  => 'Lampu Belakang Mobil wajib diisi.',
            'pintu_bagasi_belakang.required'  => 'Pintu Bagasi Belakang Mobil wajib diisi.',
            'bumper_belakang.required'  => 'Bumper Belakang Mobil wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $check_cars = $this->cars->find($id);
            $plat_mobil = $check_cars->plat_nomor;

            // dd($plat_mobil);
            $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $inputBagianBelakang['id'] = Str::uuid()->toString();
            $inputBagianBelakang['cars_id'] = $id;
            $inputBagianBelakang['lampu_belakang'] = $request->lampu_belakang;
            $inputBagianBelakang['pintu_bagasi_belakang'] = $request->pintu_bagasi_belakang;
            $inputBagianBelakang['bumper_belakang'] = $request->bumper_belakang;

            if ($request->file('foto_lampu_belakang')) {
                $image_foto_lampu_belakang = $request->file('foto_lampu_belakang');
                $img_foto_lampu_belakang = \Image::make($image_foto_lampu_belakang->path());
                $img_foto_lampu_belakang = $img_foto_lampu_belakang->encode('webp',75);
                $inputBagianBelakang['foto_lampu_belakang'] = 'LampuBelakang_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_lampu_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$inputBagianBelakang['foto_lampu_belakang']);
            }
            if ($request->file('foto_pintu_bagasi_belakang')) {
                $image_foto_pintu_bagasi_belakang = $request->file('foto_pintu_bagasi_belakang');
                $img_foto_pintu_bagasi_belakang = \Image::make($image_foto_pintu_bagasi_belakang->path());
                $img_foto_pintu_bagasi_belakang = $img_foto_pintu_bagasi_belakang->encode('webp',75);
                $inputBagianBelakang['foto_pintu_bagasi_belakang'] = 'PintuBagasiBelakang_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_pintu_bagasi_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$inputBagianBelakang['foto_pintu_bagasi_belakang']);
            }
            if ($request->file('foto_bumper_belakang')) {
                $image_foto_bumper_belakang = $request->file('foto_bumper_belakang');
                $img_foto_bumper_belakang = \Image::make($image_foto_bumper_belakang->path());
                $img_foto_bumper_belakang = $img_foto_bumper_belakang->encode('webp',75);
                $inputBagianBelakang['foto_bumper_belakang'] = 'BumperBelakang_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_bumper_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$inputBagianBelakang['foto_bumper_belakang']);
            }

            $save_inspeksi_belakang = $this->inspeksi_belakang->create($inputBagianBelakang);

            if ($save_inspeksi_belakang) {
                $message_title="Berhasil !";
                $message_content= "Inspeksi Bagian Belakang Plat Nomor ".$plat_mobil." Berhasil Dibuat. Silahkan Tunggu Memuat Ulang";
                $message_type="success";
                $message_succes = true;
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
    }

    public function simpan_inspeksi_interior(Request $request,$id)
    {
        $rules = [
            'foto_speedometer'  => 'required',
            'keterangan_speedometer'  => 'required',
            'foto_setir'  => 'required',
            'keterangan_setir'  => 'required',
            'foto_dasboard'  => 'required',
            'keterangan_dasboard'  => 'required',
            'foto_ac'  => 'required',
            'keterangan_ac'  => 'required',
            'foto_jok'  => 'required',
            'keterangan_jok'  => 'required',
            'foto_electric_spion'  => 'required',
            'keterangan_electric_spion'  => 'required',
            'foto_power_window'  => 'required',
            'keterangan_power_window'  => 'required',
        ];

        $messages = [
            'foto_speedometer.required'  => 'Foto Speedometer Mobil wajib diisi.',
            'keterangan_speedometer.required'  => 'Keterangan Speedometer Mobil wajib diisi.',
            'foto_setir.required'  => 'Foto Setir Mobil wajib diisi.',
            'keterangan_setir.required'  => 'Keterangan Setir Mobil wajib diisi.',
            'foto_dasboard.required'  => 'Foto Dasboard Mobil wajib diisi.',
            'keterangan_dasboard.required'  => 'Keterangan Dasboard Mobil wajib diisi.',
            'foto_ac.required'  => 'Foto AC Mobil wajib diisi.',
            'keterangan_ac.required'  => 'Keterangan AC Mobil wajib diisi.',
            'foto_jok.required'  => 'Foto Jok Mobil wajib diisi.',
            'keterangan_jok.required'  => 'Keterangan Jok Mobil wajib diisi.',
            'foto_electric_spion.required'  => 'Foto Electric Spion Mobil wajib diisi.',
            'keterangan_electric_spion.required'  => 'Keterangan Electric Spion Mobil wajib diisi.',
            'foto_power_window.required'  => 'Foto Power Window Mobil wajib diisi.',
            'keterangan_power_window.required'  => 'Keterangan Power Window Mobil wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $check_cars = $this->cars->find($id);
            $plat_mobil = $check_cars->plat_nomor;

            // dd($plat_mobil);
            $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $inputBagianInterior['id'] = Str::uuid()->toString();
            $inputBagianInterior['cars_id'] = $id;
            $inputBagianInterior['keterangan_speedometer'] = $request->keterangan_speedometer;
            $inputBagianInterior['keterangan_setir'] = $request->keterangan_setir;
            $inputBagianInterior['keterangan_dasboard'] = $request->keterangan_dasboard;
            $inputBagianInterior['keterangan_ac'] = $request->keterangan_ac;
            $inputBagianInterior['keterangan_audio'] = $request->keterangan_audio;
            $inputBagianInterior['keterangan_jok'] = $request->keterangan_jok;
            $inputBagianInterior['keterangan_electric_spion'] = $request->keterangan_electric_spion;
            $inputBagianInterior['keterangan_power_window'] = $request->keterangan_power_window;
            $inputBagianInterior['keterangan_lain_lain'] = $request->keterangan_lain_lain;

            if ($request->file('foto_speedometer')) {
                $image_interior_foto_speedometer = $request->file('foto_speedometer');
                $img_interior_foto_speedometer = \Image::make($image_interior_foto_speedometer->path());
                $img_interior_foto_speedometer = $img_interior_foto_speedometer->encode('webp',75);
                $inputBagianInterior['foto_speedometer'] = 'SpeedometerInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_speedometer->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_speedometer']);
            }
            if ($request->file('foto_setir')) {
                $image_interior_foto_setir = $request->file('foto_setir');
                $img_interior_foto_setir = \Image::make($image_interior_foto_setir->path());
                $img_interior_foto_setir = $img_interior_foto_setir->encode('webp',75);
                $inputBagianInterior['foto_setir'] = 'SetirInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_setir->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_setir']);
            }
            if ($request->file('foto_dasboard')) {
                $image_interior_foto_dasboard = $request->file('foto_dasboard');
                $img_interior_foto_dasboard = \Image::make($image_interior_foto_dasboard->path());
                $img_interior_foto_dasboard = $img_interior_foto_dasboard->encode('webp',75);
                $inputBagianInterior['foto_dasboard'] = 'DasboardInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_dasboard->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_dasboard']);
            }
            if ($request->file('foto_plafon')) {
                $image_interior_foto_plafon = $request->file('foto_plafon');
                $img_interior_foto_plafon = \Image::make($image_interior_foto_plafon->path());
                $img_interior_foto_plafon = $img_interior_foto_plafon->encode('webp',75);
                $inputBagianInterior['foto_plafon'] = 'PlafonInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_plafon->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_plafon']);
            }
            if ($request->file('foto_ac')) {
                $image_interior_foto_ac = $request->file('foto_ac');
                $img_interior_foto_ac = \Image::make($image_interior_foto_ac->path());
                $img_interior_foto_ac = $img_interior_foto_ac->encode('webp',75);
                $inputBagianInterior['foto_ac'] = 'ACInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_ac->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_ac']);
            }
            if ($request->file('foto_audio')) {
                $image_interior_foto_audio = $request->file('foto_audio');
                $img_interior_foto_audio = \Image::make($image_interior_foto_audio->path());
                $img_interior_foto_audio = $img_interior_foto_audio->encode('webp',75);
                $inputBagianInterior['foto_audio'] = 'AudioInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_audio->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_audio']);
            }
            if ($request->file('foto_jok')) {
                $image_interior_foto_jok = $request->file('foto_jok');
                $img_interior_foto_jok = \Image::make($image_interior_foto_jok->path());
                $img_interior_foto_jok = $img_interior_foto_jok->encode('webp',75);
                $inputBagianInterior['foto_jok'] = 'JokInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_jok->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_jok']);
            }
            if ($request->file('foto_electric_spion')) {
                $image_interior_foto_electric_spion = $request->file('foto_electric_spion');
                $img_interior_foto_electric_spion = \Image::make($image_interior_foto_electric_spion->path());
                $img_interior_foto_electric_spion = $img_interior_foto_electric_spion->encode('webp',75);
                $inputBagianInterior['foto_electric_spion'] = 'ElectricSpionInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_electric_spion->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_electric_spion']);
            }
            if ($request->file('foto_power_window')) {
                $image_interior_foto_power_window = $request->file('foto_power_window');
                $img_interior_foto_power_window = \Image::make($image_interior_foto_power_window->path());
                $img_interior_foto_power_window = $img_interior_foto_power_window->encode('webp',75);
                $inputBagianInterior['foto_power_window'] = 'PowerWindowInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_power_window->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_power_window']);
            }
            if ($request->file('foto_lain_lain')) {
                $image_interior_foto_lain_lain = $request->file('foto_lain_lain');
                $img_interior_foto_lain_lain = \Image::make($image_interior_foto_lain_lain->path());
                $img_interior_foto_lain_lain = $img_interior_foto_lain_lain->encode('webp',75);
                $inputBagianInterior['foto_lain_lain'] = 'LainLainInterior'.$plat_mobil.'_'.time().'.webp';
                $img_interior_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_lain_lain']);
            }

            $save_inspeksi_interior = $this->inspeksi_interior->create($inputBagianInterior);

            if ($save_inspeksi_interior) {
                $check_cars->update([
                    'status' => 'Selesai'
                ]);
                $message_title="Berhasil !";
                $message_content= "Inspeksi Bagian Interior Plat Nomor ".$plat_mobil." Berhasil Dibuat. Silahkan Tunggu Memuat Ulang";
                $message_type="success";
                $message_succes = true;
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
    }

    public function simpan_inspeksi(Request $request,$id)
    {
        dd($request->all());
        // dd($request->foto_speedometer);
        // $rules = [
        //     'kaca_depan'  => 'required',
        //     'kap_mesin'  => 'required',
        //     'rangka_mobil'  => 'required',
        //     'aki'  => 'required',
        //     'radiator'  => 'required',
        //     'kondisi_mesin'  => 'required',
        //     'bumper_lampu'  => 'required',
        //     'fender_depan_kiri'  => 'required',
        //     'kaki_depan_kiri'  => 'required',
        //     'kaki_belakang_kiri'  => 'required',
        //     'pintu_depan_kiri'  => 'required',
        //     'pintu_belakang_kiri'  => 'required',
        //     'fender_belakang_kiri'  => 'required',
        //     'lampu_belakang'  => 'required',
        //     'pintu_bagasi_belakang'  => 'required',
        //     'bumper_belakang'  => 'required',
        //     'fender_depan_kanan'  => 'required',
        //     'kaki_depan_kanan'  => 'required',
        //     'kaki_belakang_kanan'  => 'required',
        //     'pintu_depan_kanan'  => 'required',
        //     'pintu_belakang_kanan'  => 'required',
        //     'fender_belakang_kanan'  => 'required',
        //     'foto_speedometer'  => 'required',
        //     'keterangan_speedometer'  => 'required',
        //     'foto_setir'  => 'required',
        //     'keterangan_setir'  => 'required',
        //     'foto_dasboard'  => 'required',
        //     'keterangan_dasboard'  => 'required',
        //     'foto_ac'  => 'required',
        //     'keterangan_ac'  => 'required',
        //     'foto_jok'  => 'required',
        //     'keterangan_jok'  => 'required',
        //     'foto_electric_spion'  => 'required',
        //     'keterangan_electric_spion'  => 'required',
        //     'foto_power_window'  => 'required',
        //     'keterangan_power_window'  => 'required',
        // ];

        // $messages = [
        //     'kaca_depan.required'  => 'Kaca Depan wajib diisi lengkap.',
        //     'kap_mesin.required'  => 'Kap Mobil wajib diisi.',
        //     'rangka_mobil.required'  => 'Rangka Mobil wajib diisi.',
        //     'aki.required'  => 'Aki Mobil wajib diisi.',
        //     'radiator.required'  => 'Radiator Mobil wajib diisi.',
        //     'kondisi_mesin.required'  => 'Kondisi Mobil wajib diisi.',
        //     'bumper_lampu.required'  => 'Bumper Lampu Mobil wajib diisi.',
            
        //     'fender_depan_kiri.required'  => 'Fender Depan Kiri Mobil wajib diisi.',
        //     'kaki_depan_kiri.required'  => 'Kaki Depan Kiri Mobil wajib diisi.',
        //     'kaki_belakang_kiri.required'  => 'Kaki Belakang Kiri Mobil wajib diisi.',
        //     'pintu_depan_kiri.required'  => 'Pintu Depan Kiri Mobil wajib diisi.',
        //     'fender_belakang_kiri.required'  => 'Fender Belakang Kiri Mobil wajib diisi.',
            
        //     'lampu_belakang.required'  => 'Lampu Belakang Mobil wajib diisi.',
        //     'pintu_bagasi_belakang.required'  => 'Pintu Bagasi Belakang Mobil wajib diisi.',
        //     'bumper_belakang.required'  => 'Bumper Belakang Mobil wajib diisi.',
            
        //     'fender_depan_kanan.required'  => 'Fender Depan Kanan Mobil wajib diisi.',
        //     'kaki_depan_kanan.required'  => 'Kaki Depan Kanan Mobil wajib diisi.',
        //     'kaki_belakang_kanan.required'  => 'Kaki Belakang Kanan Mobil wajib diisi.',
        //     'pintu_depan_kanan.required'  => 'Pintu Depan Kanan Mobil wajib diisi.',
        //     'pintu_belakang_kanan.required'  => 'Pintu Belakang Kanan Mobil wajib diisi.',
        //     'fender_belakang_kanan.required'  => 'Fender Belakang Kanan Mobil wajib diisi.',
            
        //     'foto_speedometer.required'  => 'Foto Speedometer Mobil wajib diisi.',
        //     'keterangan_speedometer.required'  => 'Keterangan Speedometer Mobil wajib diisi.',
        //     'foto_setir.required'  => 'Foto Setir Mobil wajib diisi.',
        //     'keterangan_setir.required'  => 'Keterangan Setir Mobil wajib diisi.',
        //     'foto_dasboard.required'  => 'Foto Dasboard Mobil wajib diisi.',
        //     'keterangan_dasboard.required'  => 'Keterangan Dasboard Mobil wajib diisi.',
        //     'foto_ac.required'  => 'Foto AC Mobil wajib diisi.',
        //     'keterangan_ac.required'  => 'Keterangan AC Mobil wajib diisi.',
        //     'foto_jok.required'  => 'Foto Jok Mobil wajib diisi.',
        //     'keterangan_jok.required'  => 'Keterangan Jok Mobil wajib diisi.',
        //     'foto_electric_spion.required'  => 'Foto Electric Spion Mobil wajib diisi.',
        //     'keterangan_electric_spion.required'  => 'Keterangan Electric Spion Mobil wajib diisi.',
        //     'foto_power_window.required'  => 'Foto Power Window Mobil wajib diisi.',
        //     'keterangan_power_window.required'  => 'Keterangan Power Window Mobil wajib diisi.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        // if ($validator->passes()) {
        //     $check_cars = $this->cars->find($id);
        //     $plat_mobil = $check_cars->plat_nomor;

        //     $path = public_path('backend/mobil/'.$plat_mobil);
        //     if(!File::isDirectory($path)){
        //         File::makeDirectory($path, 0777, true, true);
        //         File::makeDirectory(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/'), 0777, true, true);
        //         File::makeDirectory(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/'), 0777, true, true);
        //         File::makeDirectory(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/'), 0777, true, true);
        //         File::makeDirectory(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/'), 0777, true, true);
        //         File::makeDirectory(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/'), 0777, true, true);
        //     }

        //     //Inspeksi Bagian Depan
        //     $inputBagianDepan['id'] = Str::uuid()->toString();
        //     $inputBagianDepan['cars_id'] = $id;
        //     $inputBagianDepan['kaca_depan'] = $request->kaca_depan;
        //     $inputBagianDepan['kap_mesin'] = $request->kap_mesin;
        //     $inputBagianDepan['rangka_mobil'] = $request->rangka_mobil;
        //     $inputBagianDepan['aki'] = $request->aki;
        //     $inputBagianDepan['radiator'] = $request->radiator;
        //     $inputBagianDepan['kondisi_mesin'] = $request->kondisi_mesin;
        //     $inputBagianDepan['bumper_lampu'] = $request->bumper_lampu;

        //     if ($request->file('foto_kaca_depan')) {
        //         $image_foto_kaca_depan = $request->file('foto_kaca_depan');
        //         $img_foto_kaca_depan = \Image::make($image_foto_kaca_depan->path());
        //         $img_foto_kaca_depan = $img_foto_kaca_depan->encode('webp',75);
        //         $inputBagianDepan['foto_kaca_depan'] = 'KacaDepan_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_kaca_depan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_kaca_depan']);
        //     }
        //     if ($request->file('foto_kap_mesin')) {
        //         $image_foto_kap_mesin = $request->file('foto_kap_mesin');
        //         $img_foto_kap_mesin = \Image::make($image_foto_kap_mesin->path());
        //         $img_foto_kap_mesin = $img_foto_kap_mesin->encode('webp',75);
        //         $input['foto_kap_mesin'] = 'KapMesinDepan_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_kap_mesin->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_kap_mesin']);
        //     }
        //     if ($request->file('foto_rangka_mobil')) {
        //         $image_foto_rangka_mobil = $request->file('foto_rangka_mobil');
        //         $img_foto_rangka_mobil = \Image::make($image_foto_rangka_mobil->path());
        //         $img_foto_rangka_mobil = $img_foto_rangka_mobil->encode('webp',75);
        //         $inputBagianDepan['foto_rangka_mobil'] = 'RangkaMobilDepan_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_rangka_mobil->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_rangka_mobil']);
        //     }
        //     if ($request->file('foto_aki')) {
        //         $image_foto_aki = $request->file('foto_aki');
        //         $img_foto_aki = \Image::make($image_foto_aki->path());
        //         $img_foto_aki = $img_foto_aki->encode('webp',75);
        //         $inputBagianDepan['foto_aki'] = 'AkiMobilDepan_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_aki->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_aki']);
        //     }
        //     if ($request->file('foto_radiator')) {
        //         $image_foto_radiator = $request->file('foto_radiator');
        //         $img_foto_radiator = \Image::make($image_foto_radiator->path());
        //         $img_foto_radiatori = $img_foto_radiator->encode('webp',75);
        //         $inputBagianDepan['foto_radiator'] = 'RadiatorMobilDepan_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_radiator->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_radiator']);
        //     }
        //     if ($request->file('foto_kondisi_mesin')) {
        //         $image_foto_kondisi_mesin = $request->file('foto_kondisi_mesin');
        //         $img_foto_kondisi_mesin = \Image::make($image_foto_kondisi_mesin->path());
        //         $img_foto_kondisi_mesin = $img_foto_kondisi_mesin->encode('webp',75);
        //         $inputBagianDepan['foto_kondisi_mesin'] = 'KondisiMesinMobilDepan_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_kondisi_mesin->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_kondisi_mesin']);
        //     }
        //     if ($request->file('foto_bumper_mobil')) {
        //         $image_foto_bumper_mobil = $request->file('foto_bumper_mobil');
        //         $img_foto_bumper_mobil = \Image::make($image_foto_bumper_mobil->path());
        //         $img_foto_bumper_mobil = $img_foto_bumper_mobil->encode('webp',75);
        //         $inputBagianDepan['foto_bumper_mobil'] = 'BumperMobilDepan_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_bumper_mobil->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$inputBagianDepan['foto_bumper_mobil']);
        //     }
        //     //End Inspeksi Bagian Depan

        //     //Inspeksi Bagian Kiri
        //     $inputBagianKiri['id'] = Str::uuid()->toString();
        //     $inputBagianKiri['cars_id'] = $id;
        //     $inputBagianKiri['fender_depan_kiri'] = $request->fender_depan_kiri;
        //     $inputBagianKiri['kaki_depan_kiri'] = $request->kaki_depan_kiri;
        //     $inputBagianKiri['kaki_belakang_kiri'] = $request->kaki_belakang_kiri;
        //     $inputBagianKiri['pintu_depan_kiri'] = $request->pintu_depan_kiri;
        //     $inputBagianKiri['pintu_belakang_kiri'] = $request->pintu_belakang_kiri;
        //     $inputBagianKiri['fender_belakang_kiri'] = $request->fender_belakang_kiri;

        //     if ($request->file('foto_fender_depan_kiri')) {
        //         $image_depan_foto_fender_depan_kiri = $request->file('foto_fender_depan_kiri');
        //         $img_depan_foto_fender_depan_kiri = \Image::make($image_depan_foto_fender_depan_kiri->path());
        //         $img_depan_foto_fender_depan_kiri = $img_depan_foto_fender_depan_kiri->encode('webp',75);
        //         $inputBagianKiri['foto_fender_depan_kiri'] = 'FenderDepanKiri'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_fender_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_fender_depan_kiri']);
        //     }
        //     if ($request->file('foto_kaki_depan_kiri')) {
        //         $image_depan_foto_kaki_depan_kiri = $request->file('foto_kaki_depan_kiri');
        //         $img_depan_foto_kaki_depan_kiri = \Image::make($image_depan_foto_kaki_depan_kiri->path());
        //         $img_depan_foto_kaki_depan_kiri = $img_depan_foto_kaki_depan_kiri->encode('webp',75);
        //         $inputBagianKiri['foto_kaki_depan_kiri'] = 'KakiDepanKiri'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_kaki_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_kaki_depan_kiri']);
        //     }
        //     if ($request->file('foto_kaki_belakang_kiri')) {
        //         $image_depan_foto_kaki_belakang_kiri = $request->file('foto_kaki_belakang_kiri');
        //         $img_depan_foto_kaki_belakang_kiri = \Image::make($image_depan_foto_kaki_belakang_kiri->path());
        //         $img_depan_foto_kaki_belakang_kiri = $img_depan_foto_kaki_belakang_kiri->encode('webp',75);
        //         $inputBagianKiri['foto_kaki_belakang_kiri'] = 'KakiBelakangKiri'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_kaki_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_kaki_belakang_kiri']);
        //     }
        //     if ($request->file('foto_pintu_depan_kiri')) {
        //         $image_depan_foto_pintu_depan_kiri = $request->file('foto_pintu_depan_kiri');
        //         $img_depan_foto_pintu_depan_kiri = \Image::make($image_depan_foto_pintu_depan_kiri->path());
        //         $img_depan_foto_pintu_depan_kiri = $img_depan_foto_pintu_depan_kiri->encode('webp',75);
        //         $inputBagianKiri['foto_pintu_depan_kiri'] = 'PintuDepanKiri'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_pintu_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_pintu_depan_kiri']);
        //     }
        //     if ($request->file('foto_pintu_belakang_kiri')) {
        //         $image_depan_foto_pintu_belakang_kiri = $request->file('foto_pintu_belakang_kiri');
        //         $img_depan_foto_pintu_belakang_kiri = \Image::make($image_depan_foto_pintu_belakang_kiri->path());
        //         $img_depan_foto_pintu_belakang_kiri = $img_depan_foto_pintu_belakang_kiri->encode('webp',75);
        //         $inputBagianKiri['foto_pintu_belakang_kiri'] = 'PintuBelakangKiri'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_pintu_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_pintu_belakang_kiri']);
        //     }
        //     if ($request->file('foto_fender_belakang_kiri')) {
        //         $image_depan_foto_fender_belakang_kiri = $request->file('foto_fender_belakang_kiri');
        //         $img_depan_foto_fender_belakang_kiri = \Image::make($image_depan_foto_fender_belakang_kiri->path());
        //         $img_depan_foto_fender_belakang_kiri = $img_depan_foto_fender_belakang_kiri->encode('webp',75);
        //         $inputBagianKiri['foto_fender_belakang_kiri'] = 'FenderBelakangKiri'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_fender_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$inputBagianKiri['foto_fender_belakang_kiri']);
        //     }
        //     //End Inspeksi Bagian Depan

        //     //Inspeksi Bagian Kanan
        //     $inputBagianKanan['id'] = Str::uuid()->toString();
        //     $inputBagianKanan['cars_id'] = $id;
        //     $inputBagianKanan['fender_depan_kanan'] = $request->fender_depan_kanan;
        //     $inputBagianKanan['kaki_depan_kanan'] = $request->kaki_depan_kanan;
        //     $inputBagianKanan['kaki_belakang_kanan'] = $request->kaki_belakang_kanan;
        //     $inputBagianKanan['pintu_depan_kanan'] = $request->pintu_depan_kanan;
        //     $inputBagianKanan['pintu_belakang_kanan'] = $request->pintu_belakang_kanan;
        //     $inputBagianKanan['fender_belakang_kanan'] = $request->fender_belakang_kanan;

        //     if ($request->file('foto_fender_depan_kanan')) {
        //         $image_depan_foto_fender_depan_kanan = $request->file('foto_fender_depan_kanan');
        //         $img_depan_foto_fender_depan_kanan = \Image::make($image_depan_foto_fender_depan_kanan->path());
        //         $img_depan_foto_fender_depan_kanan = $img_depan_foto_fender_depan_kanan->encode('webp',75);
        //         $inputBagianKanan['foto_fender_depan_kanan'] = 'FenderDepanKanan'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_fender_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_fender_depan_kanan']);
        //     }
        //     if ($request->file('foto_kaki_depan_kanan')) {
        //         $image_depan_foto_kaki_depan_kanan = $request->file('foto_kaki_depan_kanan');
        //         $img_depan_foto_kaki_depan_kanan = \Image::make($image_depan_foto_kaki_depan_kanan->path());
        //         $img_depan_foto_kaki_depan_kanan = $img_depan_foto_kaki_depan_kanan->encode('webp',75);
        //         $inputBagianKanan['foto_kaki_depan_kanan'] = 'KakiDepanKanan'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_kaki_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_kaki_depan_kanan']);
        //     }
        //     if ($request->file('foto_kaki_belakang_kanan')) {
        //         $image_depan_foto_kaki_belakang_kanan = $request->file('foto_kaki_belakang_kanan');
        //         $img_depan_foto_kaki_belakang_kanan = \Image::make($image_depan_foto_kaki_belakang_kanan->path());
        //         $img_depan_foto_kaki_belakang_kanan = $img_depan_foto_kaki_belakang_kanan->encode('webp',75);
        //         $inputBagianKanan['foto_kaki_belakang_kanan'] = 'KakiBelakangKanan'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_kaki_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_kaki_belakang_kanan']);
        //     }
        //     if ($request->file('foto_pintu_depan_kanan')) {
        //         $image_depan_foto_pintu_depan_kanan = $request->file('foto_pintu_depan_kanan');
        //         $img_depan_foto_pintu_depan_kanan = \Image::make($image_depan_foto_pintu_depan_kanan->path());
        //         $img_depan_foto_pintu_depan_kanan = $img_depan_foto_pintu_depan_kanan->encode('webp',75);
        //         $inputBagianKanan['foto_pintu_depan_kanan'] = 'PintuDepanKanan'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_pintu_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_pintu_depan_kanan']);
        //     }
        //     if ($request->file('foto_pintu_belakang_kanan')) {
        //         $image_depan_foto_pintu_belakang_kanan = $request->file('foto_pintu_belakang_kanan');
        //         $img_depan_foto_pintu_belakang_kanan = \Image::make($image_depan_foto_pintu_belakang_kanan->path());
        //         $img_depan_foto_pintu_belakang_kanan = $img_depan_foto_pintu_belakang_kanan->encode('webp',75);
        //         $inputBagianKanan['foto_pintu_belakang_kanan'] = 'PintuBelakangKanan'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_pintu_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_pintu_belakang_kanan']);
        //     }
        //     if ($request->file('foto_fender_belakang_kanan')) {
        //         $image_depan_foto_fender_belakang_kanan = $request->file('foto_fender_belakang_kanan');
        //         $img_depan_foto_fender_belakang_kanan = \Image::make($image_depan_foto_fender_belakang_kanan->path());
        //         $img_depan_foto_fender_belakang_kanan = $img_depan_foto_fender_belakang_kanan->encode('webp',75);
        //         $inputBagianKanan['foto_fender_belakang_kanan'] = 'FenderBelakangKanan'.$plat_mobil.'_'.time().'.webp';
        //         $img_depan_foto_fender_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$inputBagianKanan['foto_fender_belakang_kanan']);
        //     }
        //     //End Inspeksi Bagian Kanan

        //     //Inspeksi Bagian Belakang
        //     $inputBagianBelakang['id'] = Str::uuid()->toString();
        //     $inputBagianBelakang['cars_id'] = $id;
        //     $inputBagianBelakang['lampu_belakang'] = $request->lampu_belakang;
        //     $inputBagianBelakang['pintu_bagasi_belakang'] = $request->pintu_bagasi_belakang;
        //     $inputBagianBelakang['bumper_belakang'] = $request->bumper_belakang;

        //     if ($request->file('foto_lampu_belakang')) {
        //         $image_foto_lampu_belakang = $request->file('foto_lampu_belakang');
        //         $img_foto_lampu_belakang = \Image::make($image_foto_lampu_belakang->path());
        //         $img_foto_lampu_belakang = $img_foto_lampu_belakang->encode('webp',75);
        //         $inputBagianBelakang['foto_lampu_belakang'] = 'LampuBelakang_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_lampu_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$inputBagianBelakang['foto_lampu_belakang']);
        //     }
        //     if ($request->file('foto_pintu_bagasi_belakang')) {
        //         $image_foto_pintu_bagasi_belakang = $request->file('foto_pintu_bagasi_belakang');
        //         $img_foto_pintu_bagasi_belakang = \Image::make($image_foto_pintu_bagasi_belakang->path());
        //         $img_foto_pintu_bagasi_belakang = $img_foto_pintu_bagasi_belakang->encode('webp',75);
        //         $inputBagianBelakang['foto_pintu_bagasi_belakang'] = 'PintuBagasiBelakang_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_pintu_bagasi_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$inputBagianBelakang['foto_pintu_bagasi_belakang']);
        //     }
        //     if ($request->file('foto_bumper_belakang')) {
        //         $image_foto_bumper_belakang = $request->file('foto_bumper_belakang');
        //         $img_foto_bumper_belakang = \Image::make($image_foto_bumper_belakang->path());
        //         $img_foto_bumper_belakang = $img_foto_bumper_belakang->encode('webp',75);
        //         $inputBagianBelakang['foto_bumper_belakang'] = 'BumperBelakang_'.$plat_mobil.'_'.time().'.webp';
        //         $img_foto_bumper_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$inputBagianBelakang['foto_bumper_belakang']);
        //     }
        //     //End Inspeksi Bagian Belakang

        //     $inputBagianInterior['id'] = Str::uuid()->toString();
        //     $inputBagianInterior['cars_id'] = $id;
        //     $inputBagianInterior['keterangan_speedometer'] = $request->keterangan_speedometer;
        //     $inputBagianInterior['keterangan_setir'] = $request->keterangan_setir;
        //     $inputBagianInterior['keterangan_dasboard'] = $request->keterangan_dasboard;
        //     $inputBagianInterior['keterangan_ac'] = $request->keterangan_ac;
        //     $inputBagianInterior['keterangan_audio'] = $request->keterangan_audio;
        //     $inputBagianInterior['keterangan_jok'] = $request->keterangan_jok;
        //     $inputBagianInterior['keterangan_electric_spion'] = $request->keterangan_electric_spion;
        //     $inputBagianInterior['keterangan_power_window'] = $request->keterangan_power_window;
        //     $inputBagianInterior['keterangan_lain_lain'] = $request->keterangan_lain_lain;

        //     if ($request->file('foto_speedometer')) {
        //         $image_interior_foto_speedometer = $request->file('foto_speedometer');
        //         $img_interior_foto_speedometer = \Image::make($image_interior_foto_speedometer->path());
        //         $img_interior_foto_speedometer = $img_interior_foto_speedometer->encode('webp',75);
        //         $inputBagianInterior['foto_speedometer'] = 'SpeedometerInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_speedometer->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_speedometer']);
        //     }
        //     if ($request->file('foto_setir')) {
        //         $image_interior_foto_setir = $request->file('foto_setir');
        //         $img_interior_foto_setir = \Image::make($image_interior_foto_setir->path());
        //         $img_interior_foto_setir = $img_interior_foto_setir->encode('webp',75);
        //         $inputBagianInterior['foto_setir'] = 'SetirInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_setir->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_setir']);
        //     }
        //     if ($request->file('foto_dasboard')) {
        //         $image_interior_foto_dasboard = $request->file('foto_dasboard');
        //         $img_interior_foto_dasboard = \Image::make($image_interior_foto_dasboard->path());
        //         $img_interior_foto_dasboard = $img_interior_foto_dasboard->encode('webp',75);
        //         $inputBagianInterior['foto_dasboard'] = 'DasboardInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_dasboard->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_dasboard']);
        //     }
        //     if ($request->file('foto_plafon')) {
        //         $image_interior_foto_plafon = $request->file('foto_plafon');
        //         $img_interior_foto_plafon = \Image::make($image_interior_foto_plafon->path());
        //         $img_interior_foto_plafon = $img_interior_foto_plafon->encode('webp',75);
        //         $inputBagianInterior['foto_plafon'] = 'PlafonInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_plafon->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_plafon']);
        //     }
        //     if ($request->file('foto_ac')) {
        //         $image_interior_foto_ac = $request->file('foto_ac');
        //         $img_interior_foto_ac = \Image::make($image_interior_foto_ac->path());
        //         $img_interior_foto_ac = $img_interior_foto_ac->encode('webp',75);
        //         $inputBagianInterior['foto_ac'] = 'ACInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_ac->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_ac']);
        //     }
        //     if ($request->file('foto_audio')) {
        //         $image_interior_foto_audio = $request->file('foto_audio');
        //         $img_interior_foto_audio = \Image::make($image_interior_foto_audio->path());
        //         $img_interior_foto_audio = $img_interior_foto_audio->encode('webp',75);
        //         $inputBagianInterior['foto_audio'] = 'AudioInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_audio->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_audio']);
        //     }
        //     if ($request->file('foto_jok')) {
        //         $image_interior_foto_jok = $request->file('foto_jok');
        //         $img_interior_foto_jok = \Image::make($image_interior_foto_jok->path());
        //         $img_interior_foto_jok = $img_interior_foto_jok->encode('webp',75);
        //         $inputBagianInterior['foto_jok'] = 'JokInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_jok->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_jok']);
        //     }
        //     if ($request->file('foto_electric_spion')) {
        //         $image_interior_foto_electric_spion = $request->file('foto_electric_spion');
        //         $img_interior_foto_electric_spion = \Image::make($image_interior_foto_electric_spion->path());
        //         $img_interior_foto_electric_spion = $img_interior_foto_electric_spion->encode('webp',75);
        //         $inputBagianInterior['foto_electric_spion'] = 'ElectricSpionInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_electric_spion->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_electric_spion']);
        //     }
        //     if ($request->file('foto_power_window')) {
        //         $image_interior_foto_power_window = $request->file('foto_power_window');
        //         $img_interior_foto_power_window = \Image::make($image_interior_foto_power_window->path());
        //         $img_interior_foto_power_window = $img_interior_foto_power_window->encode('webp',75);
        //         $inputBagianInterior['foto_power_window'] = 'PowerWindowInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_power_window->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_power_window']);
        //     }
        //     if ($request->file('foto_lain_lain')) {
        //         $image_interior_foto_lain_lain = $request->file('foto_lain_lain');
        //         $img_interior_foto_lain_lain = \Image::make($image_interior_foto_lain_lain->path());
        //         $img_interior_foto_lain_lain = $img_interior_foto_lain_lain->encode('webp',75);
        //         $inputBagianInterior['foto_lain_lain'] = 'LainLainInterior'.$plat_mobil.'_'.time().'.webp';
        //         $img_interior_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_lain_lain']);
        //     }

        //     $save_inspeksi_depan = $this->inspeksi_depan->firstOrCreate(
        //         [
        //             'cars_id' => $inputBagianDepan['cars_id']
        //         ],$inputBagianDepan
        //     );
        //     $save_inspeksi_kiri = $this->inspeksi_kiri->firstOrCreate(
        //         [
        //             'cars_id' => $inputBagianKiri['cars_id']
        //         ],$inputBagianKiri
        //     );
        //     $save_inspeksi_kanan = $this->inspeksi_kanan->firstOrCreate(
        //         [
        //             'cars_id' => $inputBagianKanan['cars_id']
        //         ],$inputBagianKanan
        //     );
        //     $save_inspeksi_belakang = $this->inspeksi_belakang->firstOrCreate(
        //         [
        //             'cars_id' => $inputBagianBelakang['cars_id']
        //         ],$inputBagianBelakang
        //     );
        //     $save_inspeksi_interior = $this->inspeksi_interior->firstOrCreate(
        //         [
        //             'cars_id' => $inputBagianInterior['cars_id']
        //         ],$inputBagianInterior
        //     );

        //     if ($save_inspeksi_depan && $save_inspeksi_kiri && $save_inspeksi_kanan && $save_inspeksi_belakang && $save_inspeksi_interior) {
        //         $message_title="Berhasil !";
        //         $message_content= "Inspeksi Plat Nomor ".$plat_mobil." Berhasil Dibuat";
        //         $message_type="success";
        //         $message_succes = true;
        //     }
        //     $array_message = array(
        //         'success' => $message_succes,
        //         'message_title' => $message_title,
        //         'message_content' => $message_content,
        //         'message_type' => $message_type,
        //     );
        //     return response()->json($array_message);
        // }
        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );
    }

    public function edit($id)
    {
        $data['car'] = $this->cars->find($id);
        if (empty($data['car'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.edit',$data);
    }

    public function update(Request $request, $id)
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
            $cars = $this->cars->find($id);
            $input['plat_nomor'] = $request->plat_nomor_depan.'-'.$request->plat_nomor_tengah.'-'.$request->plat_nomor_belakang;
            $input['warna'] = $request->warna;
            $input['merk'] = $request->merk;
            $input['model'] = $request->model;
            $input['tahun'] = $request->tahun;
            $input['no_rangka'] = $request->no_rangka;
            $input['transmisi'] = $request->transmisi;

            if ($request->file('foto_kendaraan')) {
                if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_kendaraan))) {
                    File::delete(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_kendaraan));
                }
                $image_foto_kendaraan = $request->file('foto_kendaraan');
                $img_foto_kendaraan = \Image::make($image_foto_kendaraan->path());
                $img_foto_kendaraan = $img_foto_kendaraan->encode('webp', 75);
                $input['foto_kendaraan'] = 'Full_Body_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_kendaraan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_kendaraan']);
            }

            if ($request->file('foto_stnk')) {
                if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_stnk))) {
                    File::delete(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_stnk));
                }
                $image_foto_stnk = $request->file('foto_stnk');
                $img_foto_stnk = \Image::make($image_foto_stnk->path());
                $img_foto_stnk = $img_foto_stnk->encode('webp', 75);
                $input['foto_stnk'] = 'STNK_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_stnk->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_stnk']);
            }

            if ($request->file('foto_sisi_depan')) {
                if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_depan))) {
                    File::delete(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_depan));
                }
                $image_foto_sisi_depan = $request->file('foto_sisi_depan');
                $img_foto_sisi_depan = \Image::make($image_foto_sisi_depan->path());
                $img_foto_sisi_depan = $img_foto_sisi_depan->encode('webp', 75);
                $input['foto_sisi_depan'] = 'SisiDepan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_sisi_depan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_depan']);
            }

            if ($request->file('foto_sisi_belakang')) {
                if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_belakang))) {
                    File::delete(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_belakang));
                }
                $image_foto_sisi_belakang = $request->file('foto_sisi_belakang');
                $img_foto_sisi_belakang = \Image::make($image_foto_sisi_belakang->path());
                $img_foto_sisi_belakang = $img_foto_sisi_belakang->encode('webp', 75);
                $input['foto_sisi_belakang'] = 'SisiBelakang_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_sisi_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_belakang']);
            }

            if ($request->file('foto_sisi_kanan')) {
                if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_kanan))) {
                    File::delete(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_kanan));
                }
                $image_foto_sisi_kanan = $request->file('foto_sisi_kanan');
                $img_foto_sisi_kanan = \Image::make($image_foto_sisi_kanan->path());
                $img_foto_sisi_kanan = $img_foto_sisi_kanan->encode('webp', 75);
                $input['foto_sisi_kanan'] = 'SisiKanan_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_sisi_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_kanan']);
            }

            if ($request->file('foto_sisi_kiri')) {
                if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_kiri))) {
                    File::delete(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_kiri));
                }
                $image_foto_sisi_kiri = $request->file('foto_sisi_kiri');
                $img_foto_sisi_kiri = \Image::make($image_foto_sisi_kiri->path());
                $img_foto_sisi_kiri = $img_foto_sisi_kiri->encode('webp', 75);
                $input['foto_sisi_kiri'] = 'SisiKiri_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_sisi_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_kiri']);
            }

            if ($request->file('foto_sisi_interior')) {
                if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_interior))) {
                    File::delete(public_path('backend/mobil/'.$cars->plat_nomor.'/berkas/'.$cars->foto_sisi_interior));
                }
                $image_foto_sisi_interior = $request->file('foto_sisi_interior');
                $img_foto_sisi_interior = \Image::make($image_foto_sisi_interior->path());
                $img_foto_sisi_interior = $img_foto_sisi_interior->encode('webp', 75);
                $input['foto_sisi_interior'] = 'SisiInterior_'.$plat_mobil.'_'.time().'.webp';
                $img_foto_sisi_interior->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_interior']);
            }

            $cars->update($input);

            $save_cars = $this->cars->create($input);
            if ($save_cars) {
                $message_title="Berhasil !";
                $message_content= $request->plat_nomor_depan.' '.$request->plat_nomor_tengah.' '.$request->plat_nomor_belakang." Berhasil Disimpan";
                $message_type="success";
                $message_succes = true;
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
    }

    public function delete($id)
    {
        $data = $this->cars->find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }


        $data->delete();
    }

    public function download($id)
    {
        $data['car'] = $this->cars->find($id);
        $pdf = PDF::loadView('backend.cars.download',$data);
        // $pdf->setEncryption(1234, 5678, ['print', 'modify', 'copy', 'add']);
        return $pdf->stream('Laporan Kondisi Kendaraan Inspeksi No '.$data['car']->no_reference.'.pdf');
    }

    public function sendMailInspeksi($id)
    {
        $data['car'] = $this->cars->find($id);
        $pdf = PDF::loadView('backend.cars.download',$data);
        $sendMail = Mail::send('emails.InvoiceInspeksi',$data, function($message) use($data,$pdf){
                    $message->to('rioanugrah999@gmail.com','rioanugrah999@gmail.com')
                            ->subject('Percobaan Email Inspeksi')
                            ->attachData($pdf->output(), 'Laporan Kondisi Kendaraan Inspeksi No '.$data['car']->no_reference.'.pdf');
        });
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Invoice Inspeksi Berhasil Dikirim. Silahkan cek email secara berkala.'
        ]);
    }

}
