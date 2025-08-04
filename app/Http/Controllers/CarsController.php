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
use App\Models\InspeksiLain;
use App\Models\PriceInspeksi;

use App\Mail\InvoiceInspeksi;

use \Carbon\Carbon;

use Dompdf\Options;
use Dompdf\Dompdf;

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
        InspeksiLain $inspeksi_lain,
        InvoiceInspeksi $invoiceInspeksi,
        PriceInspeksi $priceInspeksi
    ){
        $this->cars = $cars; //Ini cara manggil parameters
        $this->inspeksi_depan = $inspeksi_depan;
        $this->inspeksi_kiri = $inspeksi_kiri;
        $this->inspeksi_kanan = $inspeksi_kanan;
        $this->inspeksi_belakang = $inspeksi_belakang;
        $this->inspeksi_interior = $inspeksi_interior;
        $this->inspeksi_lain = $inspeksi_lain;
        $this->priceInspeksi = $priceInspeksi;

        $this->invoiceInspeksi = $invoiceInspeksi;

        $this->middleware('permission:Mobil List', ['only' => ['index']]);
        $this->middleware('permission:Mobil Create', ['only' => [
                                                        'create',
                                                        'store',
                                                        'buat_inspeksi',
                                                        'simpan_inspeksi_depan',
                                                        'simpan_inspeksi_kiri',
                                                        'simpan_inspeksi_belakang',
                                                        'simpan_inspeksi_kanan',
                                                        'simpan_inspeksi_interior',
                                                        'simpan_inspeksi_interior_lain',
                                                    ]]);
        $this->middleware('permission:Mobil Detail', ['only' => ['show']]);
        $this->middleware('permission:Mobil Edit', ['only' => ['edit']]);
        $this->middleware('permission:Mobil Update', ['only' => ['update']]);
        $this->middleware('permission:Mobil Delete', ['only' => ['delete']]);
        $this->middleware('permission:Mobil Cetak', ['only' => ['download']]);

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
                                ->addColumn('plat_nomor', function($row){
                                    // return $row->plat_nomor;
                                    $explode_plat_nomor = explode('-',$row->plat_nomor);
                                    return $explode_plat_nomor[0].' '.$explode_plat_nomor[1].' '.$explode_plat_nomor[2];
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
                                ->addColumn('created_at', function($row){
                                    return $row->created_at->format('Y-m-d H:i:s');
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<div class="button-list">';
                                    if ($row->status == 'Waiting') {
                                        if (auth()->user()->can('Mobil Create') == true) {
                                            $btn = $btn.'<a href='.route('cars.buat_inspeksi',['id' => $row->id]).' class="btn btn-warning btn-xs"><i class="bi-pencil-square"></i> Mulai Inspeksi</a>';
                                        }
                                        if (auth()->user()->can('Mobil Delete') == true) {
                                            $btn = $btn.'<a href="javascript:void(0)" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-xs"><i class="bi-trash2"></i> Delete</a>';
                                        }
                                    }elseif($row->status == 'Proses'){
                                        if (auth()->user()->can('Mobil Create') == true) {
                                            $btn = $btn.'<a href='.route('cars.buat_inspeksi',['id' => $row->id]).' class="btn btn-warning btn-xs"><i class="bi-pencil-square"></i> Lanjut Inspeksi</a>';
                                        }
                                    }else{
                                        if (auth()->user()->can('Mobil Detail') == true) {
                                            $btn = $btn.'<a href='.route('cars.detail',['id' => $row->id]).' class="btn btn-success btn-xs text-dark"><i class="bi-eye"></i> Detail Inspeksi</a>';
                                        }
                                        if (auth()->user()->can('Mobil Cetak') == true) {
                                            $btn = $btn.'<a href='.route('cars.download',['id' => $row->id]).' class="btn btn-primary btn-xs" target="_blank"><i class="bi-printer"></i> Cetak Hasil</a>';
                                        }
                                        // if (!$row->detail_price_inspeksi) {
                                        //     $btn = $btn.'<a onclick="inputHarga(`'.$row->id.'`)" class="btn btn-warning btn-xs text-dark" target="_blank"><i class="bi-plus"></i> Input Harga Inspeksi</a>';
                                        // }
                                        // $btn = $btn.'<a href="javascript:void(0)" onclick="sendEmailInspeksi(`'.$row->id.'`)" class="btn btn-info"><i class="bi-envelope"></i> Kirim Email</a>';
                                        // $btn = $btn.'<a href="javascript:void(0)" onclick="sendEmailInspeksi(`'.$row->id.'`)" class="btn btn-info"><i class="bi-envelope"></i> Kirim Email</a>';
                                    }
                                    $btn = $btn.'</div>';
                                    return $btn;
                                })
                                ->rawColumns(['action','foto_kendaraan','status'])
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
            $img_foto_kendaraan = $img_foto_kendaraan->encode('webp', 90);
            $input['foto_kendaraan'] = 'Full_Body_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_kendaraan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_kendaraan']);

            $image_foto_stnk = $request->file('foto_stnk');
            $img_foto_stnk = \Image::make($image_foto_stnk->path());
            $img_foto_stnk = $img_foto_stnk->encode('webp', 90);
            $input['foto_stnk'] = 'STNK_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_stnk->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_stnk']);

            $image_foto_sisi_depan = $request->file('foto_sisi_depan');
            $img_foto_sisi_depan = \Image::make($image_foto_sisi_depan->path());
            $img_foto_sisi_depan = $img_foto_sisi_depan->encode('webp', 90);
            $input['foto_sisi_depan'] = 'SisiDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_depan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_depan']);

            $image_foto_sisi_belakang = $request->file('foto_sisi_belakang');
            $img_foto_sisi_belakang = \Image::make($image_foto_sisi_belakang->path());
            $img_foto_sisi_belakang = $img_foto_sisi_belakang->encode('webp', 90);
            $input['foto_sisi_belakang'] = 'SisiBelakang_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_belakang']);

            $image_foto_sisi_kanan = $request->file('foto_sisi_kanan');
            $img_foto_sisi_kanan = \Image::make($image_foto_sisi_kanan->path());
            $img_foto_sisi_kanan = $img_foto_sisi_kanan->encode('webp', 90);
            $input['foto_sisi_kanan'] = 'SisiKanan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_kanan']);

            $image_foto_sisi_kiri = $request->file('foto_sisi_kiri');
            $img_foto_sisi_kiri = \Image::make($image_foto_sisi_kiri->path());
            $img_foto_sisi_kiri = $img_foto_sisi_kiri->encode('webp', 90);
            $input['foto_sisi_kiri'] = 'SisiKiri_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_sisi_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/').$input['foto_sisi_kiri']);

            $image_foto_sisi_interior = $request->file('foto_sisi_interior');
            $img_foto_sisi_interior = \Image::make($image_foto_sisi_interior->path());
            $img_foto_sisi_interior = $img_foto_sisi_interior->encode('webp', 90);
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
                                    // ->where('status', 'Waiting')
                                    // ->orWhere('status', 'Proses')
                                    ->first();
        if (empty($data['car'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }

        // if (empty($data['car']->detail_inspeksi_depan)) {
        //     $data['total_inspeksi_depan'] = [
        //         'total_rusak' => 0,
        //         'total_baik' => 0,
        //     ];
        // }else{
        //     $data['total_inspeksi_depan'] = $data['car']->detail_inspeksi_depan->select(
        //         array(
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE kaca_depan WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kap_mesin WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE rangka_mobil WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE aki WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE radiator WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kondisi_mesin WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE bumper_lampu WHEN "Rusak" THEN 1 ELSE NULL END)
        //                         )/7
        //                     )*100
        //                     as total_rusak'),
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE kaca_depan WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kap_mesin WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE rangka_mobil WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE aki WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE radiator WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kondisi_mesin WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE bumper_lampu WHEN "Baik" THEN 1 ELSE NULL END)
        //                         )/7
        //                     )*100
        //                     as total_baik'),
        //         )
        //     )->where('cars_id',$data['car']->id)->first();
        // }

        // if (empty($data['car']->detail_inspeksi_kiri)) {
        //     $data['total_inspeksi_kiri'] = [
        //         'total_rusak' => 0,
        //         'total_baik' => 0,
        //     ];
        // }else{
        //     $data['total_inspeksi_kiri'] = $data['car']->detail_inspeksi_kiri->select(
        //         array(
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE fender_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_depan_kiri WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE fender_belakang_kiri WHEN "Rusak" THEN 1 ELSE NULL END)
        //                         )/6
        //                     )*100
        //                     as total_rusak'),
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE fender_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_depan_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE fender_belakang_kiri WHEN "Baik" THEN 1 ELSE NULL END)
        //                         )/6
        //                     )*100
        //                     as total_baik'),
        //         )
        //     )->where('cars_id',$data['car']->id)->first();
        // }

        // if (empty($data['car']->detail_inspeksi_kanan)) {
        //     $data['total_inspeksi_kanan'] = [
        //         'total_rusak' => 0,
        //         'total_baik' => 0,
        //     ];
        // }else{
        //     $data['total_inspeksi_kanan'] = $data['car']->detail_inspeksi_kanan->select(
        //         array(
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE fender_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_depan_kanan WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE fender_belakang_kanan WHEN "Rusak" THEN 1 ELSE NULL END)
        //                         )/6
        //                     )*100
        //                     as total_rusak'),
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE fender_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE kaki_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_depan_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE fender_belakang_kanan WHEN "Baik" THEN 1 ELSE NULL END)
        //                         )/6
        //                     )*100
        //                     as total_baik'),
        //         )
        //     )->where('cars_id',$data['car']->id)->first();
        // }

        // if (empty($data['car']->detail_inspeksi_belakang)) {
        //     $data['total_inspeksi_belakang'] = [
        //         'total_rusak' => 0,
        //         'total_baik' => 0,
        //     ];
        // }else{
        //     $data['total_inspeksi_belakang'] = $data['car']->detail_inspeksi_belakang->select(
        //         array(
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE lampu_belakang WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_bagasi_belakang WHEN "Rusak" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE bumper_belakang WHEN "Rusak" THEN 1 ELSE NULL END)
        //                         )/3
        //                     )*100
        //                     as total_rusak'),
        //             DB::raw('(
        //                         (
        //                             COUNT(CASE lampu_belakang WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE pintu_bagasi_belakang WHEN "Baik" THEN 1 ELSE NULL END) +
        //                             COUNT(CASE bumper_belakang WHEN "Baik" THEN 1 ELSE NULL END)
        //                         )/3
        //                     )*100
        //                     as total_baik'),
        //         )
        //     )->where('cars_id',$data['car']->id)->first();
        // }

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

            $inputBagianDepan['keterangan_kaca_depan'] = $request->keterangan_kaca_depan;
            $inputBagianDepan['keterangan_kap_mesin'] = $request->keterangan_kap_mesin;
            $inputBagianDepan['keterangan_rangka_mobil'] = $request->keterangan_rangka_mobil;
            $inputBagianDepan['keterangan_aki'] = $request->keterangan_aki;
            $inputBagianDepan['keterangan_radiator'] = $request->keterangan_radiator;
            $inputBagianDepan['keterangan_kondisi_mesin'] = $request->keterangan_kondisi_mesin;
            $inputBagianDepan['keterangan_bumper_lampu'] = $request->keterangan_bumper_lampu;

            $save_inspeksi_depan = $this->inspeksi_depan->create($inputBagianDepan);

            if ($save_inspeksi_depan) {
                $check_cars->update([
                    'status' => 'Proses'
                ]);
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

            $inputBagianKiri['keterangan_fender_depan_kiri'] = $request->keterangan_fender_depan_kiri;
            $inputBagianKiri['keterangan_kaki_depan_kiri'] = $request->keterangan_kaki_depan_kiri;
            $inputBagianKiri['keterangan_kaki_belakang_kiri'] = $request->keterangan_kaki_belakang_kiri;
            $inputBagianKiri['keterangan_pintu_depan_kiri'] = $request->keterangan_pintu_depan_kiri;
            $inputBagianKiri['keterangan_pintu_belakang_kiri'] = $request->keterangan_pintu_belakang_kiri;
            $inputBagianKiri['keterangan_fender_belakang_kiri'] = $request->keterangan_fender_belakang_kiri;

            $save_inspeksi_kiri = $this->inspeksi_kiri->create($inputBagianKiri);

            if ($save_inspeksi_kiri) {
                if (
                    !empty($check_cars->detail_inspeksi_depan) &&
                    !empty($check_cars->detail_inspeksi_kiri) &&
                    !empty($check_cars->detail_inspeksi_belakang) &&
                    !empty($check_cars->detail_inspeksi_kanan) &&
                    !empty($check_cars->detail_inspeksi_interior) &&
                    !empty($check_cars->detail_inspeksi_lain)
                ) {
                    $check_cars->update([
                        'status' => 'Selesai'
                    ]);
                }
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

            $inputBagianKanan['keterangan_fender_depan_kanan'] = $request->keterangan_fender_depan_kanan;
            $inputBagianKanan['keterangan_kaki_depan_kanan'] = $request->keterangan_kaki_depan_kanan;
            $inputBagianKanan['keterangan_kaki_belakang_kanan'] = $request->keterangan_kaki_belakang_kanan;
            $inputBagianKanan['keterangan_pintu_depan_kanan'] = $request->keterangan_pintu_depan_kanan;
            $inputBagianKanan['keterangan_pintu_belakang_kanan'] = $request->keterangan_pintu_belakang_kanan;
            $inputBagianKanan['keterangan_fender_belakang_kanan'] = $request->keterangan_fender_belakang_kanan;

            $save_inspeksi_kanan = $this->inspeksi_kanan->create($inputBagianKanan);

            if ($save_inspeksi_kanan) {
                if (
                    !empty($check_cars->detail_inspeksi_depan) &&
                    !empty($check_cars->detail_inspeksi_kiri) &&
                    !empty($check_cars->detail_inspeksi_belakang) &&
                    !empty($check_cars->detail_inspeksi_kanan) &&
                    !empty($check_cars->detail_inspeksi_interior) &&
                    !empty($check_cars->detail_inspeksi_lain)
                ) {
                    $check_cars->update([
                        'status' => 'Selesai'
                    ]);
                }
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

            $inputBagianBelakang['keterangan_lampu_belakang'] = $request->keterangan_lampu_belakang;
            $inputBagianBelakang['keterangan_pintu_bagasi_belakang'] = $request->keterangan_pintu_bagasi_belakang;
            $inputBagianBelakang['keterangan_bumper_belakang'] = $request->keterangan_bumper_belakang;

            $save_inspeksi_belakang = $this->inspeksi_belakang->create($inputBagianBelakang);

            if ($save_inspeksi_belakang) {
                if (
                    !empty($check_cars->detail_inspeksi_depan) &&
                    !empty($check_cars->detail_inspeksi_kiri) &&
                    !empty($check_cars->detail_inspeksi_belakang) &&
                    !empty($check_cars->detail_inspeksi_kanan) &&
                    !empty($check_cars->detail_inspeksi_interior) &&
                    !empty($check_cars->detail_inspeksi_lain)
                ) {
                    $check_cars->update([
                        'status' => 'Selesai'
                    ]);
                }
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
        // ini_set('post_max_size', '1024M');
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

            $imageSpeedometer = 'SpeedometerInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_speedometer'] = $imageSpeedometer;
            // if ($request->foto_speedometer) {
            // }
            $imageSetir = 'SetirInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_setir'] = $imageSetir;
            // if ($request->foto_setir) {
            // }
            $imageDasboard = 'DasboardInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_dasboard'] = $imageDasboard;
            // if ($request->foto_dasboard) {
            // }
            $imagePlafon = 'PlafonInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_plafon'] = $imagePlafon;
            // if ($request->foto_plafon) {
            // }
            $imageAc = 'ACInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_ac'] = $imageAc;
            // if ($request->foto_ac) {
            // }
            $imageAudio = 'AudioInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_audio'] = $imageAudio;
            // if ($request->foto_audio) {
            // }
            $imageJok = 'JokInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_jok'] = $imageJok;
            // if ($request->foto_jok) {
            // }
            $imageElectricSpion = 'ElectricSpionInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_electric_spion'] = $imageElectricSpion;
            // if ($request->foto_electric_spion) {
            // }
            $imagePowerWindow = 'PowerWindowInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_power_window'] = $imagePowerWindow;
            // if ($request->foto_power_window) {
            // }
            $imageLainLain = 'LainLainInterior'.$plat_mobil.'.webp';
            $inputBagianInterior['foto_lain_lain'] = $imageLainLain;
            // if ($request->foto_lain_lain) {
            // }
            // if ($request->file('foto_speedometer')) {
            //     $image_interior_foto_speedometer = $request->file('foto_speedometer');
            //     $img_interior_foto_speedometer = \Image::make($image_interior_foto_speedometer->path());
            //     $img_interior_foto_speedometer = $img_interior_foto_speedometer->encode('webp',65);
            //     $inputBagianInterior['foto_speedometer'] = 'SpeedometerInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_speedometer->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_speedometer']);
            // }
            // if ($request->file('foto_setir')) {
            //     $image_interior_foto_setir = $request->file('foto_setir');
            //     $img_interior_foto_setir = \Image::make($image_interior_foto_setir->path());
            //     $img_interior_foto_setir = $img_interior_foto_setir->encode('webp',65);
            //     $inputBagianInterior['foto_setir'] = 'SetirInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_setir->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_setir']);
            // }
            // if ($request->file('foto_dasboard')) {
            //     $image_interior_foto_dasboard = $request->file('foto_dasboard');
            //     $img_interior_foto_dasboard = \Image::make($image_interior_foto_dasboard->path());
            //     $img_interior_foto_dasboard = $img_interior_foto_dasboard->encode('webp',65);
            //     $inputBagianInterior['foto_dasboard'] = 'DasboardInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_dasboard->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_dasboard']);
            // }
            // if ($request->file('foto_plafon')) {
            //     $image_interior_foto_plafon = $request->file('foto_plafon');
            //     $img_interior_foto_plafon = \Image::make($image_interior_foto_plafon->path());
            //     $img_interior_foto_plafon = $img_interior_foto_plafon->encode('webp',65);
            //     $inputBagianInterior['foto_plafon'] = 'PlafonInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_plafon->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_plafon']);
            // }
            // if ($request->file('foto_ac')) {
            //     $image_interior_foto_ac = $request->file('foto_ac');
            //     $img_interior_foto_ac = \Image::make($image_interior_foto_ac->path());
            //     $img_interior_foto_ac = $img_interior_foto_ac->encode('webp',65);
            //     $inputBagianInterior['foto_ac'] = 'ACInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_ac->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_ac']);
            // }
            // if ($request->file('foto_audio')) {
            //     $image_interior_foto_audio = $request->file('foto_audio');
            //     $img_interior_foto_audio = \Image::make($image_interior_foto_audio->path());
            //     $img_interior_foto_audio = $img_interior_foto_audio->encode('webp',65);
            //     $inputBagianInterior['foto_audio'] = 'AudioInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_audio->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_audio']);
            // }
            // if ($request->file('foto_jok')) {
            //     $image_interior_foto_jok = $request->file('foto_jok');
            //     $img_interior_foto_jok = \Image::make($image_interior_foto_jok->path());
            //     $img_interior_foto_jok = $img_interior_foto_jok->encode('webp',65);
            //     $inputBagianInterior['foto_jok'] = 'JokInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_jok->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_jok']);
            // }
            // if ($request->file('foto_electric_spion')) {
            //     $image_interior_foto_electric_spion = $request->file('foto_electric_spion');
            //     $img_interior_foto_electric_spion = \Image::make($image_interior_foto_electric_spion->path());
            //     $img_interior_foto_electric_spion = $img_interior_foto_electric_spion->encode('webp',65);
            //     $inputBagianInterior['foto_electric_spion'] = 'ElectricSpionInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_electric_spion->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_electric_spion']);
            // }
            // if ($request->file('foto_power_window')) {
            //     $image_interior_foto_power_window = $request->file('foto_power_window');
            //     $img_interior_foto_power_window = \Image::make($image_interior_foto_power_window->path());
            //     $img_interior_foto_power_window = $img_interior_foto_power_window->encode('webp',65);
            //     $inputBagianInterior['foto_power_window'] = 'PowerWindowInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_power_window->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_power_window']);
            // }
            // if ($request->file('foto_lain_lain')) {
            //     $image_interior_foto_lain_lain = $request->file('foto_lain_lain');
            //     $img_interior_foto_lain_lain = \Image::make($image_interior_foto_lain_lain->path());
            //     $img_interior_foto_lain_lain = $img_interior_foto_lain_lain->encode('webp',65);
            //     $inputBagianInterior['foto_lain_lain'] = 'LainLainInterior'.$plat_mobil.'_'.time().'.webp';
            //     $img_interior_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_lain_lain']);
            // }

            $save_inspeksi_interior = $this->inspeksi_interior->create($inputBagianInterior);

            if ($save_inspeksi_interior) {
                // $check_cars->update([
                //     'status' => 'Selesai'
                // ]);
                if (
                    !empty($check_cars->detail_inspeksi_depan) &&
                    !empty($check_cars->detail_inspeksi_kiri) &&
                    !empty($check_cars->detail_inspeksi_belakang) &&
                    !empty($check_cars->detail_inspeksi_kanan) &&
                    !empty($check_cars->detail_inspeksi_interior) &&
                    !empty($check_cars->detail_inspeksi_lain)
                ) {
                    $check_cars->update([
                        'status' => 'Selesai'
                    ]);
                }
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

    public function upload_file_inspeksi_interior_speedometer(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_speedometer')) {
            $image_interior_foto_speedometer = $request->file('foto_speedometer');
            $img_interior_foto_speedometer = \Image::make($image_interior_foto_speedometer->path());
            $img_interior_foto_speedometer = $img_interior_foto_speedometer->encode('webp',65);
            $inputBagianInterior['foto_speedometer'] = 'SpeedometerInterior'.$plat_mobil.'.webp';
            $img_interior_foto_speedometer->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_speedometer']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_setir(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_setir')) {
            $image_interior_foto_setir = $request->file('foto_setir');
            $img_interior_foto_setir = \Image::make($image_interior_foto_setir->path());
            $img_interior_foto_setir = $img_interior_foto_setir->encode('webp',65);
            $inputBagianInterior['foto_setir'] = 'SetirInterior'.$plat_mobil.'.webp';
            $img_interior_foto_setir->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_setir']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_dasboard(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_dasboard')) {
            $image_interior_foto_dasboard = $request->file('foto_dasboard');
            $img_interior_foto_dasboard = \Image::make($image_interior_foto_dasboard->path());
            $img_interior_foto_dasboard = $img_interior_foto_dasboard->encode('webp',65);
            $inputBagianInterior['foto_dasboard'] = 'DasboardInterior'.$plat_mobil.'.webp';
            $img_interior_foto_dasboard->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_dasboard']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_plafon(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_plafon')) {
            $image_interior_foto_plafon = $request->file('foto_plafon');
            $img_interior_foto_plafon = \Image::make($image_interior_foto_plafon->path());
            $img_interior_foto_plafon = $img_interior_foto_plafon->encode('webp',65);
            $inputBagianInterior['foto_plafon'] = 'PlafonInterior'.$plat_mobil.'.webp';
            $img_interior_foto_plafon->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_plafon']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_ac(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_ac')) {
            $image_interior_foto_ac = $request->file('foto_ac');
            $img_interior_foto_ac = \Image::make($image_interior_foto_ac->path());
            $img_interior_foto_ac = $img_interior_foto_ac->encode('webp',65);
            $inputBagianInterior['foto_ac'] = 'ACInterior'.$plat_mobil.'.webp';
            $img_interior_foto_ac->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_ac']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_audio(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_audio')) {
            $image_interior_foto_audio = $request->file('foto_audio');
            $img_interior_foto_audio = \Image::make($image_interior_foto_audio->path());
            $img_interior_foto_audio = $img_interior_foto_audio->encode('webp',65);
            $inputBagianInterior['foto_audio'] = 'AudioInterior'.$plat_mobil.'.webp';
            $img_interior_foto_audio->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_audio']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_jok(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_jok')) {
            $image_interior_foto_jok = $request->file('foto_jok');
            $img_interior_foto_jok = \Image::make($image_interior_foto_jok->path());
            $img_interior_foto_jok = $img_interior_foto_jok->encode('webp',65);
            $inputBagianInterior['foto_jok'] = 'JokInterior'.$plat_mobil.'.webp';
            $img_interior_foto_jok->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_jok']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_electric_spion(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_electric_spion')) {
            $image_interior_foto_electric_spion = $request->file('foto_electric_spion');
            $img_interior_foto_electric_spion = \Image::make($image_interior_foto_electric_spion->path());
            $img_interior_foto_electric_spion = $img_interior_foto_electric_spion->encode('webp',65);
            $inputBagianInterior['foto_electric_spion'] = 'ElectricSpionInterior'.$plat_mobil.'.webp';
            $img_interior_foto_electric_spion->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_electric_spion']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_power_window(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_power_window')) {
            $image_interior_foto_power_window = $request->file('foto_power_window');
            $img_interior_foto_power_window = \Image::make($image_interior_foto_power_window->path());
            $img_interior_foto_power_window = $img_interior_foto_power_window->encode('webp',65);
            $inputBagianInterior['foto_power_window'] = 'PowerWindowInterior'.$plat_mobil.'.webp';
            $img_interior_foto_power_window->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_power_window']);
        }

        return 'OK';

    }

    public function upload_file_inspeksi_interior_lain_lain(Request $request,$id)
    {
        $check_cars = $this->cars->find($id);
        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->file('foto_lain_lain')) {
            $image_interior_foto_lain_lain = $request->file('foto_lain_lain');
            $img_interior_foto_lain_lain = \Image::make($image_interior_foto_lain_lain->path());
            $img_interior_foto_lain_lain = $img_interior_foto_lain_lain->encode('webp',65);
            $inputBagianInterior['foto_lain_lain'] = 'LainLainInterior'.$plat_mobil.'.webp';
            $img_interior_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$inputBagianInterior['foto_lain_lain']);
        }

        return 'OK';

    }

    public function simpan_inspeksi_lain(Request $request,$id)
    {
        // ini_set('post_max_size', '1024M');

        $check_cars = $this->cars->find($id);
        if (empty($check_cars)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Inspeksi Tidak Ditemukan'
            ]);
        }

        $plat_mobil = $check_cars->plat_nomor;

        $path = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_lain');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        $inputBagianLain['id'] = Str::uuid()->toString();
        $inputBagianLain['cars_id'] = $id;
        $inputBody = array();
        // dd($request->all());
        // foreach ($request['foto_lain_lain'] as $key => $value) {
        //     // dd($value);
        //     // $image_foto_lain_lain = $value;
        //     // $img_foto_lain_lain = \Image::make($image_foto_lain_lain->path());
        //     // $img_foto_lain_lain = $img_foto_lain_lain->encode('webp', 75);
        //     $input_lain['foto_lain_lain'] = ['LainLain_'.$plat_mobil.'_'.time().'.webp'];
        //     // $img_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_lain/').$input_lain['foto_lain_lain']);
        //     $input_lain['keterangan_lain_lain'] = $request->keterangan_lain_lain[$key];
        //     $inputBody[$key] = $input_lain;
        //     // $inputBody[$key] = $key;
        // }

        foreach ($request['group-a'] as $key => $value) {
            // $inputBody[$key] = $value;
            $image_foto_lain_lain = $value['foto_lain_lain'];
            $img_foto_lain_lain = \Image::make($image_foto_lain_lain->path());
            $img_foto_lain_lain = $img_foto_lain_lain->encode('webp', 75);
            $input_lain['foto_lain_lain'] = 'LainLain_'.$plat_mobil.'_'.rand(100,999).'.webp';
            $img_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_lain/').$input_lain['foto_lain_lain']);
            $input_lain['keterangan_lain_lain'] = $value['keterangan_lain_lain'];
            $inputBody[$key] = $input_lain;
        }

        // $inputBagianLain['body'] = json_encode($input_lain);
        // dd($inputBody);
        $inputBagianLain['body'] = json_encode($inputBody);

        $save_inspeksi_lain = $this->inspeksi_lain->create($inputBagianLain);

        if ($save_inspeksi_lain) {
            if (
                !empty($check_cars->detail_inspeksi_depan) &&
                !empty($check_cars->detail_inspeksi_kiri) &&
                !empty($check_cars->detail_inspeksi_belakang) &&
                !empty($check_cars->detail_inspeksi_kanan) &&
                !empty($check_cars->detail_inspeksi_interior) &&
                !empty($check_cars->detail_inspeksi_lain)
            ) {
                $check_cars->update([
                    'status' => 'Selesai'
                ]);
            }
            $message_title="Berhasil !";
            $message_content= "Inspeksi Bagian Lain - Lain Plat Nomor ".$plat_mobil." Berhasil Dibuat. Silahkan Tunggu Memuat Ulang";
            $message_type="success";
            $message_succes = true;

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
                'error' => 'Input Inspeksi Lain - Lain Gagal, Silahkan Cek Kembali'
            ]
        );
    }

    public function edit_inspeksi_depan($id,$inspeksi_depan)
    {
        $data['inspeksi_depan'] = $this->inspeksi_depan->where('id',$inspeksi_depan)->where('cars_id',$id)->first();
        if (empty($data['inspeksi_depan'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.edit.inspeksi_depan',$data);
    }

    public function update_inspeksi_depan(Request $request,$id,$inspeksi_depan)
    {
        // $rules = [
        //     'keterangan_kaca_depan'  => 'required',
        //     'keterangan_kap_mesin'  => 'required',
        //     'keterangan_rangka_mobil'  => 'required',
        //     'keterangan_aki'  => 'required',
        //     'keterangan_radiator'  => 'required',
        //     'keterangan_kondisi_mesin'  => 'required',
        //     'keterangan_bumper_lampu'  => 'required',
        // ];

        // $messages = [
        //     'keterangan_kaca_depan.required'  => 'Keterangan Kaca Depan wajib diisi lengkap.',
        //     'keterangan_kap_mesin.required'  => 'Keterangan Kap Mesin wajib diisi.',
        //     'keterangan_rangka_mobil.required'  => 'Keterangan Rangka Mobil wajib diisi.',
        //     'keterangan_aki.required'  => 'Keterangan Aki wajib diisi.',
        //     'keterangan_radiator.required'  => 'Keterangan Radiator wajib diisi.',
        //     'keterangan_kondisi_mesin.required'  => 'Keterangan Kondisi Mesin Mobil wajib diisi.',
        //     'keterangan_bumper_lampu.required'  => 'Keterangan Bumper Lampu wajib diisi.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->passes()) {

        // }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );

        $inspeksi_depan = $this->inspeksi_depan->where('id',$id)->where('cars_id',$inspeksi_depan)->first();
        if (empty($inspeksi_depan)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $plat_mobil = $inspeksi_depan->cars->plat_nomor;

        if ($request->file('foto_kaca_depan')) {
            $image_foto_kaca_depan = $request->file('foto_kaca_depan');
            $img_foto_kaca_depan = \Image::make($image_foto_kaca_depan->path());
            $img_foto_kaca_depan = $img_foto_kaca_depan->encode('webp',75);
            $input['foto_kaca_depan'] = 'KacaDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_kaca_depan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_kaca_depan']);
        }
        if ($request->file('foto_kap_mesin')) {
            $image_foto_kap_mesin = $request->file('foto_kap_mesin');
            $img_foto_kap_mesin = \Image::make($image_foto_kap_mesin->path());
            $img_foto_kap_mesin = $img_foto_kap_mesin->encode('webp',75);
            $input['foto_kap_mesin'] = 'KapMesinDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_kap_mesin->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_kap_mesin']);
        }
        if ($request->file('foto_rangka_mobil')) {
            $image_foto_rangka_mobil = $request->file('foto_rangka_mobil');
            $img_foto_rangka_mobil = \Image::make($image_foto_rangka_mobil->path());
            $img_foto_rangka_mobil = $img_foto_rangka_mobil->encode('webp',75);
            $input['foto_rangka_mobil'] = 'RangkaMobilDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_rangka_mobil->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_rangka_mobil']);
        }
        if ($request->file('foto_aki')) {
            $image_foto_aki = $request->file('foto_aki');
            $img_foto_aki = \Image::make($image_foto_aki->path());
            $img_foto_aki = $img_foto_aki->encode('webp',75);
            $input['foto_aki'] = 'AkiMobilDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_aki->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_aki']);
        }
        if ($request->file('foto_radiator')) {
            $image_foto_radiator = $request->file('foto_radiator');
            $img_foto_radiator = \Image::make($image_foto_radiator->path());
            $img_foto_radiatori = $img_foto_radiator->encode('webp',75);
            $input['foto_radiator'] = 'RadiatorMobilDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_radiator->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_radiator']);
        }
        if ($request->file('foto_kondisi_mesin')) {
            $image_foto_kondisi_mesin = $request->file('foto_kondisi_mesin');
            $img_foto_kondisi_mesin = \Image::make($image_foto_kondisi_mesin->path());
            $img_foto_kondisi_mesin = $img_foto_kondisi_mesin->encode('webp',75);
            $input['foto_kondisi_mesin'] = 'KondisiMesinMobilDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_kondisi_mesin->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_kondisi_mesin']);
        }
        if ($request->file('foto_bumper_lampu')) {
            $image_foto_bumper_mobil = $request->file('foto_bumper_lampu');
            $img_foto_bumper_mobil = \Image::make($image_foto_bumper_mobil->path());
            $img_foto_bumper_mobil = $img_foto_bumper_mobil->encode('webp',75);
            $input['foto_bumper_lampu'] = 'BumperLampuMobilDepan_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_bumper_mobil->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_depan/').$input['foto_bumper_lampu']);
        }

        $input['keterangan_kaca_depan'] = $request->keterangan_kaca_depan;
        $input['keterangan_kap_mesin'] = $request->keterangan_kap_mesin;
        $input['keterangan_rangka_mobil'] = $request->keterangan_rangka_mobil;
        $input['keterangan_aki'] = $request->keterangan_aki;
        $input['keterangan_radiator'] = $request->keterangan_radiator;
        $input['keterangan_kondisi_mesin'] = $request->keterangan_kondisi_mesin;
        $input['keterangan_bumper_lampu'] = $request->keterangan_bumper_lampu;

        $inspeksi_depan->update($input);

        if ($inspeksi_depan) {
            $message_title="Berhasil !";
            $message_content= "Inspeksi Bagian Depan Plat Nomor ".$plat_mobil." Berhasil Diupdate. Silahkan Tunggu Memuat Ulang";
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

    public function edit_inspeksi_kiri($id,$inspeksi_kiri)
    {
        $data['inspeksi_kiri'] = $this->inspeksi_kiri->where('id',$inspeksi_kiri)->where('cars_id',$id)->first();
        if (empty($data['inspeksi_kiri'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.edit.inspeksi_kiri',$data);
    }

    public function update_inspeksi_kiri(Request $request,$id,$inspeksi_kiri)
    {
        // $rules = [
        //     'keterangan_fender_depan_kiri'  => 'required',
        //     'keterangan_kaki_depan_kiri'  => 'required',
        //     'keterangan_kaki_belakang_kiri'  => 'required',
        //     'keterangan_pintu_depan_kiri'  => 'required',
        //     'keterangan_pintu_belakang_kiri'  => 'required',
        //     'keterangan_fender_belakang_kiri'  => 'required',
        // ];

        // $messages = [
        //     'keterangan_fender_depan_kiri.required'  => 'Keterangan Fender Depan Kiri wajib diisi lengkap.',
        //     'keterangan_kaki_depan_kiri.required'  => 'Keterangan Kaki Depan Kiri wajib diisi.',
        //     'keterangan_kaki_belakang_kiri.required'  => 'Keterangan Kaki Belakang Kiri wajib diisi.',
        //     'keterangan_pintu_depan_kiri.required'  => 'Keterangan Pintu Depan Kiri wajib diisi.',
        //     'keterangan_pintu_belakang_kiri.required'  => 'Keterangan Pintu Belakang Kiri wajib diisi.',
        //     'keterangan_fender_belakang_kiri.required'  => 'Keterangan Fender Belakang Kiri wajib diisi.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->passes()) {

        // }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );
        $inspeksi_kiri = $this->inspeksi_kiri->where('id',$id)->where('cars_id',$inspeksi_kiri)->first();
        if (empty($inspeksi_kiri)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $plat_mobil = $inspeksi_kiri->cars->plat_nomor;

        if ($request->file('foto_fender_depan_kiri')) {
            $image_depan_foto_fender_depan_kiri = $request->file('foto_fender_depan_kiri');
            $img_depan_foto_fender_depan_kiri = \Image::make($image_depan_foto_fender_depan_kiri->path());
            $img_depan_foto_fender_depan_kiri = $img_depan_foto_fender_depan_kiri->encode('webp',75);
            $input['foto_fender_depan_kiri'] = 'FenderDepanKiri'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_fender_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$input['foto_fender_depan_kiri']);
        }
        if ($request->file('foto_kaki_depan_kiri')) {
            $image_depan_foto_kaki_depan_kiri = $request->file('foto_kaki_depan_kiri');
            $img_depan_foto_kaki_depan_kiri = \Image::make($image_depan_foto_kaki_depan_kiri->path());
            $img_depan_foto_kaki_depan_kiri = $img_depan_foto_kaki_depan_kiri->encode('webp',75);
            $input['foto_kaki_depan_kiri'] = 'KakiDepanKiri'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_kaki_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$input['foto_kaki_depan_kiri']);
        }
        if ($request->file('foto_kaki_belakang_kiri')) {
            $image_depan_foto_kaki_belakang_kiri = $request->file('foto_kaki_belakang_kiri');
            $img_depan_foto_kaki_belakang_kiri = \Image::make($image_depan_foto_kaki_belakang_kiri->path());
            $img_depan_foto_kaki_belakang_kiri = $img_depan_foto_kaki_belakang_kiri->encode('webp',75);
            $input['foto_kaki_belakang_kiri'] = 'KakiBelakangKiri'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_kaki_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$input['foto_kaki_belakang_kiri']);
        }
        if ($request->file('foto_pintu_depan_kiri')) {
            $image_depan_foto_pintu_depan_kiri = $request->file('foto_pintu_depan_kiri');
            $img_depan_foto_pintu_depan_kiri = \Image::make($image_depan_foto_pintu_depan_kiri->path());
            $img_depan_foto_pintu_depan_kiri = $img_depan_foto_pintu_depan_kiri->encode('webp',75);
            $input['foto_pintu_depan_kiri'] = 'PintuDepanKiri'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_pintu_depan_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$input['foto_pintu_depan_kiri']);
        }
        if ($request->file('foto_pintu_belakang_kiri')) {
            $image_depan_foto_pintu_belakang_kiri = $request->file('foto_pintu_belakang_kiri');
            $img_depan_foto_pintu_belakang_kiri = \Image::make($image_depan_foto_pintu_belakang_kiri->path());
            $img_depan_foto_pintu_belakang_kiri = $img_depan_foto_pintu_belakang_kiri->encode('webp',75);
            $input['foto_pintu_belakang_kiri'] = 'PintuBelakangKiri'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_pintu_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$input['foto_pintu_belakang_kiri']);
        }
        if ($request->file('foto_fender_belakang_kiri')) {
            $image_depan_foto_fender_belakang_kiri = $request->file('foto_fender_belakang_kiri');
            $img_depan_foto_fender_belakang_kiri = \Image::make($image_depan_foto_fender_belakang_kiri->path());
            $img_depan_foto_fender_belakang_kiri = $img_depan_foto_fender_belakang_kiri->encode('webp',75);
            $input['foto_fender_belakang_kiri'] = 'FenderBelakangKiri'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_fender_belakang_kiri->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kiri/').$input['foto_fender_belakang_kiri']);
        }

        $input['keterangan_fender_depan_kiri'] = $request->keterangan_fender_depan_kiri;
        $input['keterangan_kaki_depan_kiri'] = $request->keterangan_kaki_depan_kiri;
        $input['keterangan_kaki_belakang_kiri'] = $request->keterangan_kaki_belakang_kiri;
        $input['keterangan_pintu_depan_kiri'] = $request->keterangan_pintu_depan_kiri;
        $input['keterangan_pintu_belakang_kiri'] = $request->keterangan_pintu_belakang_kiri;
        $input['keterangan_fender_belakang_kiri'] = $request->keterangan_fender_belakang_kiri;

        $inspeksi_kiri->update($input);

        if ($inspeksi_kiri) {
            $message_title="Berhasil !";
            $message_content= "Inspeksi Bagian Kiri Plat Nomor ".$plat_mobil." Berhasil Diupdate. Silahkan Tunggu Memuat Ulang";
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

    public function edit_inspeksi_belakang($id,$inspeksi_belakang)
    {
        $data['inspeksi_belakang'] = $this->inspeksi_belakang->where('id',$inspeksi_belakang)->where('cars_id',$id)->first();
        if (empty($data['inspeksi_belakang'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.edit.inspeksi_belakang',$data);
    }

    public function update_inspeksi_belakang(Request $request,$id,$inspeksi_belakang)
    {
        // $rules = [
        //     'keterangan_lampu_belakang'  => 'required',
        //     'keterangan_pintu_bagasi_belakang'  => 'required',
        //     'keterangan_bumper_belakang'  => 'required',
        // ];

        // $messages = [
        //     'keterangan_lampu_belakang.required'  => 'Keterangan Lampu Belakang wajib diisi lengkap.',
        //     'keterangan_pintu_bagasi_belakang.required'  => 'Keterangan Pintu Bagasi Belakang wajib diisi.',
        //     'keterangan_bumper_belakang.required'  => 'Keterangan Bumper Belakang wajib diisi.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->passes()) {

        // }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );
        $inspeksi_belakang = $this->inspeksi_belakang->where('id',$id)->where('cars_id',$inspeksi_belakang)->first();
        if (empty($inspeksi_belakang)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $plat_mobil = $inspeksi_belakang->cars->plat_nomor;

        if ($request->file('foto_lampu_belakang')) {
            $image_foto_lampu_belakang = $request->file('foto_lampu_belakang');
            $img_foto_lampu_belakang = \Image::make($image_foto_lampu_belakang->path());
            $img_foto_lampu_belakang = $img_foto_lampu_belakang->encode('webp',75);
            $input['foto_lampu_belakang'] = 'LampuBelakang_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_lampu_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$input['foto_lampu_belakang']);
        }
        if ($request->file('foto_pintu_bagasi_belakang')) {
            $image_foto_pintu_bagasi_belakang = $request->file('foto_pintu_bagasi_belakang');
            $img_foto_pintu_bagasi_belakang = \Image::make($image_foto_pintu_bagasi_belakang->path());
            $img_foto_pintu_bagasi_belakang = $img_foto_pintu_bagasi_belakang->encode('webp',75);
            $input['foto_pintu_bagasi_belakang'] = 'PintuBagasiBelakang_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_pintu_bagasi_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$input['foto_pintu_bagasi_belakang']);
        }
        if ($request->file('foto_bumper_belakang')) {
            $image_foto_bumper_belakang = $request->file('foto_bumper_belakang');
            $img_foto_bumper_belakang = \Image::make($image_foto_bumper_belakang->path());
            $img_foto_bumper_belakang = $img_foto_bumper_belakang->encode('webp',75);
            $input['foto_bumper_belakang'] = 'BumperBelakang_'.$plat_mobil.'_'.time().'.webp';
            $img_foto_bumper_belakang->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_belakang/').$input['foto_bumper_belakang']);
        }

        $input['keterangan_lampu_belakang'] = $request->keterangan_lampu_belakang;
        $input['keterangan_pintu_bagasi_belakang'] = $request->keterangan_pintu_bagasi_belakang;
        $input['keterangan_bumper_belakang'] = $request->keterangan_bumper_belakang;

        $inspeksi_belakang->update($input);

        if ($inspeksi_belakang) {
            $message_title="Berhasil !";
            $message_content= "Inspeksi Bagian Belakang Plat Nomor ".$plat_mobil." Berhasil Diupdate. Silahkan Tunggu Memuat Ulang";
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

    public function edit_inspeksi_kanan($id,$inspeksi_kanan)
    {
        $data['inspeksi_kanan'] = $this->inspeksi_kanan->where('id',$inspeksi_kanan)->where('cars_id',$id)->first();
        if (empty($data['inspeksi_kanan'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.edit.inspeksi_kanan',$data);
    }

    public function update_inspeksi_kanan(Request $request,$id,$inspeksi_kanan)
    {
        // $rules = [
        //     'keterangan_fender_depan_kanan'  => 'required',
        //     'keterangan_kaki_depan_kanan'  => 'required',
        //     'keterangan_kaki_belakang_kanan'  => 'required',
        //     'keterangan_pintu_depan_kanan'  => 'required',
        //     'keterangan_pintu_belakang_kanan'  => 'required',
        //     'keterangan_fender_belakang_kanan'  => 'required',
        // ];

        // $messages = [
        //     'keterangan_fender_depan_kanan.required'  => 'Keterangan Fender Depan Kanan wajib diisi lengkap.',
        //     'keterangan_kaki_depan_kanan.required'  => 'Keterangan Kaki Depan Kanan wajib diisi.',
        //     'keterangan_kaki_belakang_kanan.required'  => 'Keterangan Kaki Belakang Kanan wajib diisi.',
        //     'keterangan_pintu_depan_kanan.required'  => 'Keterangan Pintu Depan Kanan wajib diisi.',
        //     'keterangan_pintu_belakang_kanan.required'  => 'Keterangan Pintu Belakang Kanan wajib diisi.',
        //     'keterangan_fender_belakang_kanan.required'  => 'Keterangan Fender Belakang Kanan wajib diisi.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->passes()) {

        // }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );
        $inspeksi_kanan = $this->inspeksi_kanan->where('id',$id)->where('cars_id',$inspeksi_kanan)->first();
        if (empty($inspeksi_kanan)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $plat_mobil = $inspeksi_kanan->cars->plat_nomor;

        if ($request->file('foto_fender_depan_kanan')) {
            $image_depan_foto_fender_depan_kanan = $request->file('foto_fender_depan_kanan');
            $img_depan_foto_fender_depan_kanan = \Image::make($image_depan_foto_fender_depan_kanan->path());
            $img_depan_foto_fender_depan_kanan = $img_depan_foto_fender_depan_kanan->encode('webp',75);
            $input['foto_fender_depan_kanan'] = 'FenderDepanKanan'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_fender_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$input['foto_fender_depan_kanan']);
        }
        if ($request->file('foto_kaki_depan_kanan')) {
            $image_depan_foto_kaki_depan_kanan = $request->file('foto_kaki_depan_kanan');
            $img_depan_foto_kaki_depan_kanan = \Image::make($image_depan_foto_kaki_depan_kanan->path());
            $img_depan_foto_kaki_depan_kanan = $img_depan_foto_kaki_depan_kanan->encode('webp',75);
            $input['foto_kaki_depan_kanan'] = 'KakiDepanKanan'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_kaki_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$input['foto_kaki_depan_kanan']);
        }
        if ($request->file('foto_kaki_belakang_kanan')) {
            $image_depan_foto_kaki_belakang_kanan = $request->file('foto_kaki_belakang_kanan');
            $img_depan_foto_kaki_belakang_kanan = \Image::make($image_depan_foto_kaki_belakang_kanan->path());
            $img_depan_foto_kaki_belakang_kanan = $img_depan_foto_kaki_belakang_kanan->encode('webp',75);
            $input['foto_kaki_belakang_kanan'] = 'KakiBelakangKanan'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_kaki_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$input['foto_kaki_belakang_kanan']);
        }
        if ($request->file('foto_pintu_depan_kanan')) {
            $image_depan_foto_pintu_depan_kanan = $request->file('foto_pintu_depan_kanan');
            $img_depan_foto_pintu_depan_kanan = \Image::make($image_depan_foto_pintu_depan_kanan->path());
            $img_depan_foto_pintu_depan_kanan = $img_depan_foto_pintu_depan_kanan->encode('webp',75);
            $input['foto_pintu_depan_kanan'] = 'PintuDepanKanan'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_pintu_depan_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$input['foto_pintu_depan_kanan']);
        }
        if ($request->file('foto_pintu_belakang_kanan')) {
            $image_depan_foto_pintu_belakang_kanan = $request->file('foto_pintu_belakang_kanan');
            $img_depan_foto_pintu_belakang_kanan = \Image::make($image_depan_foto_pintu_belakang_kanan->path());
            $img_depan_foto_pintu_belakang_kanan = $img_depan_foto_pintu_belakang_kanan->encode('webp',75);
            $input['foto_pintu_belakang_kanan'] = 'PintuBelakangKanan'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_pintu_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$input['foto_pintu_belakang_kanan']);
        }
        if ($request->file('foto_fender_belakang_kanan')) {
            $image_depan_foto_fender_belakang_kanan = $request->file('foto_fender_belakang_kanan');
            $img_depan_foto_fender_belakang_kanan = \Image::make($image_depan_foto_fender_belakang_kanan->path());
            $img_depan_foto_fender_belakang_kanan = $img_depan_foto_fender_belakang_kanan->encode('webp',75);
            $input['foto_fender_belakang_kanan'] = 'FenderBelakangKanan'.$plat_mobil.'_'.time().'.webp';
            $img_depan_foto_fender_belakang_kanan->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_kanan/').$input['foto_fender_belakang_kanan']);
        }

        $input['keterangan_fender_depan_kanan'] = $request->keterangan_fender_depan_kanan;
        $input['keterangan_kaki_depan_kanan'] = $request->keterangan_kaki_depan_kanan;
        $input['keterangan_kaki_belakang_kanan'] = $request->keterangan_kaki_belakang_kanan;
        $input['keterangan_pintu_depan_kanan'] = $request->keterangan_pintu_depan_kanan;
        $input['keterangan_pintu_belakang_kanan'] = $request->keterangan_pintu_belakang_kanan;
        $input['keterangan_fender_belakang_kanan'] = $request->keterangan_fender_belakang_kanan;

        $inspeksi_kanan->update($input);

        if ($inspeksi_kanan) {
            $message_title="Berhasil !";
            $message_content= "Inspeksi Bagian Kanan Plat Nomor ".$plat_mobil." Berhasil Diupdate. Silahkan Tunggu Memuat Ulang";
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

    public function edit_inspeksi_interior($id,$inspeksi_interior)
    {
        $data['inspeksi_interior'] = $this->inspeksi_interior->where('id',$inspeksi_interior)->where('cars_id',$id)->first();
        if (empty($data['inspeksi_interior'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.edit.inspeksi_interior',$data);
    }

    public function update_inspeksi_interior(Request $request,$id,$inspeksi_interior)
    {
        // $rules = [
        //     'keterangan_speedometer'  => 'required',
        //     'keterangan_setir'  => 'required',
        //     'keterangan_dasboard'  => 'required',
        //     'keterangan_plafon'  => 'required',
        //     'keterangan_ac'  => 'required',
        //     'keterangan_audio'  => 'required',
        //     'keterangan_jok'  => 'required',
        //     'keterangan_electric_spion'  => 'required',
        //     'keterangan_power_window'  => 'required',
        // ];

        // $messages = [
        //     'keterangan_speedometer.required'  => 'Keterangan Speedometer wajib diisi lengkap.',
        //     'keterangan_setir.required'  => 'Keterangan Setir wajib diisi.',
        //     'keterangan_dasboard.required'  => 'Keterangan Dasboard wajib diisi.',
        //     'keterangan_plafon.required'  => 'Keterangan Plafon wajib diisi.',
        //     'keterangan_ac.required'  => 'Keterangan AC wajib diisi.',
        //     'keterangan_audio.required'  => 'Keterangan Audio wajib diisi.',
        //     'keterangan_jok.required'  => 'Keterangan Jok wajib diisi.',
        //     'keterangan_electric_spion.required'  => 'Keterangan Electric Spion wajib diisi.',
        //     'keterangan_power_window.required'  => 'Keterangan Power Window wajib diisi.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->passes()) {

        // }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );

        $inspeksi_interior = $this->inspeksi_interior->where('id',$id)->where('cars_id',$inspeksi_interior)->first();
        if (empty($inspeksi_interior)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $plat_mobil = $inspeksi_interior->cars->plat_nomor;

        if ($request->file('foto_speedometer')) {
            $image_interior_foto_speedometer = $request->file('foto_speedometer');
            $img_interior_foto_speedometer = \Image::make($image_interior_foto_speedometer->path());
            $img_interior_foto_speedometer = $img_interior_foto_speedometer->encode('webp',65);
            $input['foto_speedometer'] = 'SpeedometerInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_speedometer->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_speedometer']);
        }
        if ($request->file('foto_setir')) {
            $image_interior_foto_setir = $request->file('foto_setir');
            $img_interior_foto_setir = \Image::make($image_interior_foto_setir->path());
            $img_interior_foto_setir = $img_interior_foto_setir->encode('webp',65);
            $input['foto_setir'] = 'SetirInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_setir->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_setir']);
        }
        if ($request->file('foto_dasboard')) {
            $image_interior_foto_dasboard = $request->file('foto_dasboard');
            $img_interior_foto_dasboard = \Image::make($image_interior_foto_dasboard->path());
            $img_interior_foto_dasboard = $img_interior_foto_dasboard->encode('webp',65);
            $input['foto_dasboard'] = 'DasboardInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_dasboard->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_dasboard']);
        }
        if ($request->file('foto_plafon')) {
            $image_interior_foto_plafon = $request->file('foto_plafon');
            $img_interior_foto_plafon = \Image::make($image_interior_foto_plafon->path());
            $img_interior_foto_plafon = $img_interior_foto_plafon->encode('webp',65);
            $input['foto_plafon'] = 'PlafonInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_plafon->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_plafon']);
        }
        if ($request->file('foto_ac')) {
            $image_interior_foto_ac = $request->file('foto_ac');
            $img_interior_foto_ac = \Image::make($image_interior_foto_ac->path());
            $img_interior_foto_ac = $img_interior_foto_ac->encode('webp',65);
            $input['foto_ac'] = 'ACInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_ac->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_ac']);
        }
        if ($request->file('foto_audio')) {
            $image_interior_foto_audio = $request->file('foto_audio');
            $img_interior_foto_audio = \Image::make($image_interior_foto_audio->path());
            $img_interior_foto_audio = $img_interior_foto_audio->encode('webp',65);
            $input['foto_audio'] = 'AudioInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_audio->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_audio']);
        }
        if ($request->file('foto_jok')) {
            $image_interior_foto_jok = $request->file('foto_jok');
            $img_interior_foto_jok = \Image::make($image_interior_foto_jok->path());
            $img_interior_foto_jok = $img_interior_foto_jok->encode('webp',65);
            $input['foto_jok'] = 'JokInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_jok->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_jok']);
        }
        if ($request->file('foto_electric_spion')) {
            $image_interior_foto_electric_spion = $request->file('foto_electric_spion');
            $img_interior_foto_electric_spion = \Image::make($image_interior_foto_electric_spion->path());
            $img_interior_foto_electric_spion = $img_interior_foto_electric_spion->encode('webp',65);
            $input['foto_electric_spion'] = 'ElectricSpionInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_electric_spion->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_electric_spion']);
        }
        if ($request->file('foto_power_window')) {
            $image_interior_foto_power_window = $request->file('foto_power_window');
            $img_interior_foto_power_window = \Image::make($image_interior_foto_power_window->path());
            $img_interior_foto_power_window = $img_interior_foto_power_window->encode('webp',65);
            $input['foto_power_window'] = 'PowerWindowInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_power_window->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_power_window']);
        }
        if ($request->file('foto_lain_lain')) {
            $image_interior_foto_lain_lain = $request->file('foto_lain_lain');
            $img_interior_foto_lain_lain = \Image::make($image_interior_foto_lain_lain->path());
            $img_interior_foto_lain_lain = $img_interior_foto_lain_lain->encode('webp',65);
            $input['foto_lain_lain'] = 'LainLainInterior'.$plat_mobil.'_'.time().'.webp';
            $img_interior_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_interior/').$input['foto_lain_lain']);
        }

        $input['keterangan_speedometer'] = $request->keterangan_speedometer;
        $input['keterangan_setir'] = $request->keterangan_setir;
        $input['keterangan_dasboard'] = $request->keterangan_dasboard;
        $input['keterangan_plafon'] = $request->keterangan_plafon;
        $input['keterangan_ac'] = $request->keterangan_ac;
        $input['keterangan_audio'] = $request->keterangan_audio;
        $input['keterangan_jok'] = $request->keterangan_jok;
        $input['keterangan_electric_spion'] = $request->keterangan_electric_spion;
        $input['keterangan_power_window'] = $request->keterangan_power_window;
        $input['keterangan_lain_lain'] = $request->keterangan_lain_lain;

        $inspeksi_interior->update($input);

        if ($inspeksi_interior) {
            $message_title="Berhasil !";
            $message_content= "Inspeksi Bagian Interior Plat Nomor ".$plat_mobil." Berhasil Diupdate. Silahkan Tunggu Memuat Ulang";
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

    public function edit_inspeksi_lain($id,$inspeksi_lain)
    {
        $data['inspeksi_lain'] = $this->inspeksi_lain->where('id',$inspeksi_lain)->where('cars_id',$id)->first();
        if (empty($data['inspeksi_lain'])) {
            return redirect()->back()->with('error','Data Tidak Ditemukan');
        }
        return view('backend.cars.edit.inspeksi_lain',$data);
    }

    public function update_inspeksi_lain(Request $request,$id,$inspeksi_lain)
    {
        // $rules = [
        //     'keterangan_lain_lain'  => 'required',
        // ];

        // $messages = [
        //     'keterangan_lain_lain.required'  => 'Keterangan wajib diisi lengkap.',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->passes()) {

        // }

        // return response()->json(
        //     [
        //         'success' => false,
        //         'error' => $validator->errors()->all()
        //     ]
        // );
        $inspeksi_lain = $this->inspeksi_lain->where('id',$id)->where('cars_id',$inspeksi_lain)->first();
        if (empty($inspeksi_lain)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data Tidak Ditemukan'
            ]);
        }

        $plat_mobil = $inspeksi_lain->cars->plat_nomor;

        $inputBody = array();
        foreach (json_decode($inspeksi_lain->body) as $key => $value) {
            // $input_lain['foto_lain_lain'] = $value->foto_lain_lain;
            // $input_lain['keterangan_lain_lain'] = $request->keterangan_lain_lain[$key];
            // $inputBody[$key] = $input_lain;
            // $cari_asset = public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_lain/'.)
            // dd($key);

            if ($request['foto_lain_lain_'.$key]) {
                // if (File::exists(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_lain/').$value)) {
                //     File::delete(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_lain/').$value);
                // }
                $image_foto_lain_lain = $request->file('foto_lain_lain_'.$key);
                $img_foto_lain_lain = \Image::make($image_foto_lain_lain->path());
                $img_foto_lain_lain = $img_foto_lain_lain->encode('webp', 75);
                $input_lain['foto_lain_lain'] = 'LainLain_'.$plat_mobil.'_'.rand(1000,9999).'.webp';
                $img_foto_lain_lain->save(public_path('backend/mobil/'.$plat_mobil.'/berkas/pengecekkan_bagian_lain/').$input_lain['foto_lain_lain']);
                $input_lain['keterangan_lain_lain'] = $request['keterangan_lain_lain_'.$key];
                $inputBody[$key] = $input_lain;
            }else{
                $input_lain['foto_lain_lain'] = $value->foto_lain_lain;
                $input_lain['keterangan_lain_lain'] = $request['keterangan_lain_lain_'.$key];
                $inputBody[$key] = $input_lain;
            }
        }
        $input['body'] = json_encode($inputBody);
        $inspeksi_lain->update($input);

        if ($inspeksi_lain) {
            $message_title="Berhasil !";
            $message_content= "Inspeksi Bagian Lain - Lain Plat Nomor ".$plat_mobil." Berhasil Diupdate. Silahkan Tunggu Memuat Ulang";
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
        $cars = $this->cars->find($id);
        if (empty($cars)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Data tidak ditemukan'
            ]);
        }
        if (File::exists(public_path('backend/mobil/'.$cars->plat_nomor))) {
            // unlink(public_path('backend/mobil/'.$cars->plat_nomor));
            File::deleteDirectory(public_path('backend/mobil/'.$cars->plat_nomor));
        }
        $cars->delete();
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Inspeksi Plat Nomor '.$cars->plat_nomor.' Berhasil Dihapus'
        ]);
    }

    public function download($id)
    {
        ini_set('max_execution_time', -1);
        $data['car'] = $this->cars->find($id);

        return view('backend.cars.downloadNew',$data);
        // $options = new Options();
        // $options->set('isRemoteEnabled', true);

        // $dompdf = new Dompdf($options);
        // $dompdf->loadHtml('backend.cars.downloadNew',$data);
        // $dompdf->render();

        // return $dompdf;

        $pdf = PDF::loadView('backend.cars.downloadNew',$data);
        $pdf->setOption([
            'dpi' => 10,
            'enable_remote' => true
        ]);
        // $pdf->set_option('isRemoteEnabled', true);
        // $pdf->setEncryption(1234, 5678, ['print', 'modify', 'copy', 'add']);
        return $pdf->stream('Laporan Kondisi Kendaraan Inspeksi No '.$data['car']->no_reference.'.pdf');
    }

    public function modalSendMail($id)
    {
        $data['car'] = $this->cars->find($id);
        return response()->json([
            'success' => true,
            'data' => $data['car']
        ]);
    }

    public function sendMailInspeksi(Request $request)
    {
        // dd($request->all());
        ini_set('max_execution_time', -1);
        $data['car'] = $this->cars->find($request->modalId);
        $data['request'] = $request;
        $total_inspeksi_depan = $data['car']->detail_inspeksi_depan->select(
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
        )->where('cars_id',$data['car']->id)->first();

        $total_inspeksi_kiri = $data['car']->detail_inspeksi_kiri->select(
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
        )->where('cars_id',$data['car']->id)->first();

        $total_inspeksi_kanan = $data['car']->detail_inspeksi_kanan->select(
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
        )->where('cars_id',$data['car']->id)->first();

        $total_inspeksi_belakang = $data['car']->detail_inspeksi_belakang->select(
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
        )->where('cars_id',$data['car']->id)->first();

        $data['total_all_inspeksi'] = ($total_inspeksi_depan['total_baik']+$total_inspeksi_kiri['total_baik']+$total_inspeksi_kanan['total_baik']+$total_inspeksi_belakang['total_baik'])/4;
        // dd($data);
        $pdf = PDF::loadView('backend.cars.download',$data);
        $sendMail = Mail::send('emails.InvoiceInspeksi',$data, function($message) use($data,$request,$pdf){
                    $message->to($request->modalEmail)
                            ->subject('Laporan Hasil Kondisi Kendaraan Inspeksi NOPOL '.$data['car']['plat_nomor'])
                            ->attachData($pdf->output(), 'Laporan Kondisi Kendaraan Inspeksi No '.$data['car']->no_reference.'.pdf');
        });
        return response()->json([
            'success' => true,
            'message_type' => 'success',
            'message_title' => 'Berhasil',
            'message_content' => 'Invoice Inspeksi Berhasil Dikirim. Silahkan cek email secara berkala.'
        ]);
    }

    public function inputHargaInspeksi($id)
    {
        $data = $this->cars->select(
                            'cars.id as id',
                            'cars.no_reference as no_reference',
                            'cars.plat_nomor as plat_nomor',
                            'cars.warna as warna',
                            'cars.merk as merk',
                            'cars.model as model',
                            'cars.tahun as tahun',
                            'cars.no_rangka as no_rangka',
                            'cars.transmisi as transmisi',
                            'cars.status as status',
                            'price_inspeksi.price as price',
                        )
                        ->leftJoin('price_inspeksi','price_inspeksi.cars_id','cars.id')
                        ->where('cars.id',$id)
                        ->first();

        if (empty($data)) {
            return redirect()->back()->with('error','Inspeksi Tidak Ditemukan');
        }

        $plat_nomor = explode('-',$data->plat_nomor);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $data->id,
                'no_reference' => $data->no_reference,
                'plat_nomor' => $plat_nomor[0] . ' ' . $plat_nomor[1] . ' ' . $plat_nomor[2],
                'warna' => $data->warna,
                'merk' => $data->merk,
                'model' => $data->model,
                'tahun' => $data->tahun,
                'no_rangka' => $data->no_rangka,
                'transmisi' => $data->transmisi,
                'status' => $data->status,
                'price' => $data->price
                // 'price' => 'Rp. '.number_format($data->price_inspeksi,0,',','.'),
            ]
        ],200);
                                // dd($data);
        // return view('backend.cars.inputHargaInspeksi',$data);
    }

    public function inputHargaInspeksiSimpan(Request $request)
    {
        $rules = [
            'modalPrice' => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'modalPrice.required'  => 'Harga Inspeksi wajib diisi lengkap.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            $price = $this->priceInspeksi->where('cars_id',$request->modalId)->first();
            if (empty($price)) {
                // dd('ok');
                $input['id'] = Str::uuid()->toString();
                $input['cars_id'] = $request->modalId;
                $input['price'] = $request->modalPrice;
                // dd($input);
                $savePrice = $this->priceInspeksi->create($input);

                if ($savePrice){
                    $message_title="Berhasil !";
                    $message_content= "Harga Inspeksi Berhasil Disimpan";
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
            }else{
                $message_title="Gagal !";
                $message_content= "Harga Inspeksi sudah ditambahkan!";
                $message_type="error";
                $message_succes = false;

                $array_message = array(
                    'success' => $message_succes,
                    'message_title' => $message_title,
                    'message_content' => $message_content,
                    'message_type' => $message_type,
                );
                return response()->json($array_message);
            }
        }

        return response()->json(
            [
                'success' => false,
                'error' => $validator->errors()->all()
            ]
        );

    }

}
