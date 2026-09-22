<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Cars;
use App\Models\PriceInspeksi;

use App\Models\FinanceCoa;
use App\Models\FinanceJournal;
use App\Models\FinanceBiayaJasa;

use \Carbon\Carbon;

use Validator;
use DataTables;

class JasaController extends Controller
{
    function __construct(
        Cars $cars,
        PriceInspeksi $priceInspeksi,
        FinanceBiayaJasa $financeBiayaJasa,
        FinanceCoa $financeCoa,
        FinanceJournal $financeJournal,

    ){
        $this->middleware('permission:BiayaJasa Create', ['only' => ['biaya_jasa_simpan','biaya_jasa_detail','biaya_jasa_metodePembayaran_simpan']]);
        $this->cars = $cars;
        $this->priceInspeksi = $priceInspeksi;
        $this->financeBiayaJasa = $financeBiayaJasa;
        $this->financeCoa = $financeCoa;
        $this->financeJournal = $financeJournal;

    }

    public function biaya_jasa(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->cars->select(
                                    'cars.id as id',
                                    'cars.no_reference as no_reference',
                                    'cars.plat_nomor as plat_nomor',
                                    'cars.warna as warna',
                                    'cars.merk as merk',
                                    'cars.model as model',
                                    // 'cars.foto_kendaraan as foto_kendaraan',
                                    'cars.status as status',
                                    'finance_biaya_jasa.customer as customer',
                                    'finance_biaya_jasa.lokasi as lokasi',
                                    'finance_biaya_jasa.biaya_jasa as biaya_jasa',
                                    'finance_biaya_jasa.biaya_transport as biaya_transport',
                                    'finance_biaya_jasa.biaya_gaji_karyawan as biaya_gaji_karyawan',
                                    // 'finance_biaya_jasa.total as total',
                                    'finance_biaya_jasa.pembayaran as pembayaran',
                                    'finance_biaya_jasa.status as status_pembayaran',
                                    'cars.created_at as created_at',
                                )
                                ->leftJoin('finance_biaya_jasa','cars.id','=','finance_biaya_jasa.cars_id')
                                ->get();

            return DataTables::of($data)
                                ->addIndexColumn()
                                // ->addColumn('customer', function($row){
                                //     if (empty($row->customer)) {
                                //         return '-';
                                //     }else{
                                //         return $row->customer;
                                //     }
                                // })
                                ->addColumn('dataCustomer', function($row){
                                    if (empty($row->customer)) {
                                        $data = '<div>'.
                                                    '<div><span class="fw-bold">No. Reference : </span>'.$row->no_reference.'</div>'.
                                                    '<div><span class="fw-bold">Nama Customer : </span> - </div>'.
                                                    '<div><span class="fw-bold">Lokasi Inspeksi : </span> - </div>'
                                                .'</div>';
                                        return $data;
                                    }else{
                                        $data = '<div>'.
                                                    '<div><span class="fw-bold">No. Reference : </span>'.$row->no_reference.'</div>'.
                                                    '<div><span class="fw-bold">Nama Customer : </span>'.$row->customer.'</div>'.
                                                    '<div><span class="fw-bold">Lokasi Inspeksi : </span>'.$row->lokasi.'</div>'
                                                .'</div>';
                                        return $data;
                                    }
                                })
                                // ->addColumn('lokasi_inspeksi', function($row){
                                //     if (empty($row->lokasi)) {
                                //         return '-';
                                //     }else{
                                //         return $row->lokasi;
                                //     }
                                // })
                                ->addColumn('biaya_jasa', function($row){
                                    if (empty($row->biaya_jasa)) {
                                        return '<span class="text-danger">Belum Diinput</span>';
                                    }
                                    return 'Rp. '.number_format($row->biaya_jasa,2,',','.');
                                })
                                ->addColumn('biaya_transport', function($row){
                                    // if (empty($row->biaya_transport)) {
                                    //     return '<span class="text-danger">Belum Diinput</span>';
                                    // }elseif($row->biaya_transport == 0){
                                    //     return 'Rp. '.number_format($row->biaya_transport,2,',','.');
                                    // }else{
                                    //     }
                                    if (empty($row->biaya_transport)) {
                                        return '<span class="text-danger">Belum Diinput</span>';
                                    }
                                    return 'Rp. '.number_format($row->biaya_transport,2,',','.');
                                })
                                ->addColumn('total', function($row){
                                    $total = $row->biaya_jasa+$row->biaya_transport;
                                    return 'Rp. '.number_format($total,2,',','.');
                                    // if (empty($row->total)) {
                                    //     return '<span class="text-danger">Belum Diinput</span>';
                                    // }
                                    // return 'Rp. '.number_format($row->total,2,',','.');
                                })
                                ->addColumn('plat_nomor', function($row){
                                    // return $row->plat_nomor;
                                    $explode_plat_nomor = explode('-',$row->plat_nomor);
                                    return $explode_plat_nomor[0].' '.$explode_plat_nomor[1].' '.$explode_plat_nomor[2];
                                })
                                ->addColumn('status_pembayaran', function($row){
                                    if ($row->status !== 'Selesai') {
                                        return '<span class="badge bg-primary">Proses Inspeksi</span>';
                                    }else{
                                        switch ($row->status_pembayaran) {
                                            case 'Waiting':
                                                return '<span class="badge bg-warning">Menunggu Pembayaran</span>';
                                                break;
                                            case 'Paid':
                                                return '<span class="badge bg-success">Lunas</span>';
                                                break;
                                            case 'Waiting Finance':
                                                return '<span class="badge bg-info">Menunggu Input Finance</span>';
                                                break;
                                            default:
                                                return '-';
                                                break;
                                        }
                                    }
                                })
                                ->addColumn('created_at', function($row){
                                    return $row->created_at->format('Y-m-d H:i:s');
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<div class="button-list">';
                                    if (empty($row->status_pembayaran)) {
                                        $btn = $btn.'<a onclick="inputHarga(`'.$row->id.'`)" class="btn btn-warning btn-xs text-dark"><i class="bi-plus"></i> Input Harga Inspeksi</a>';
                                    }elseif($row->status_pembayaran == 'Waiting'){
                                        $btn = $btn.'<a onclick="inputStatusPembayaran(`'.$row->id.'`)" class="btn btn-info btn-xs"><i class="bi-plus"></i> Status Pembayaran</a>';
                                    }elseif($row->status_pembayaran == 'Waiting Finance'){
                                        $btn = $btn.'<a onclick="inputPembayaranFinance(`'.$row->id.'`)" class="btn btn-primary btn-xs"><i class="bi-plus"></i> Input Harga</a>';
                                    }
                                    $btn = $btn.'</div>';
                                    return $btn;
                                })
                                ->rawColumns([
                                    'action',
                                    'dataCustomer',
                                    'biaya_jasa',
                                    'biaya_transport',
                                    'total',
                                    'status_pembayaran'
                                    ])
                                ->make(true);
        }

        $data['provinces'] = \DB::table('province')->where('id',35)->get();

        return view('backend.jasa.biayaJasa.index',$data);
    }

    public function biaya_jasa_simpan(Request $request)
    {
        $rules = [
            // 'price' => 'required',
            'priceBiayaJasa' => 'required',
            'priceBiayaTransport' => 'required',
            'priceGajiKaryawan' => 'required',
            'keterangan' => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            // 'price.required'  => 'Harga Inspeksi wajib diisi.',
            'priceJasaInspeksi.required'  => 'Harga Jasa Inspeksi wajib diisi.',
            'priceBiayaTransport.required'  => 'Biaya Transport wajib diisi.',
            'priceGajiKaryawan.required'  => 'Gaji Karyawan wajib diisi.',
            'keterangan.required'  => 'Keterangan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            // $cek_coa = $this->financeCoa->select('code','item')
            //                             ->whereYear('created_at',Carbon::now()->format('Y'))
            //                             ->get();
            // dd($cek_coa[0]['item']);
            $price = $this->priceInspeksi->where('cars_id',$request->modalId)->first();
            
            if (empty($price)) {
                // dd('ok');
                $input['id'] = Str::uuid()->toString();
                $input['cars_id'] = $request->modalId;
                $input['price'] = $request->priceBiayaJasa+$request->priceBiayaTransport;
                // dd($input);
                $savePrice = $this->priceInspeksi->create($input);
                
                $this->financeBiayaJasa->create([
                    'cars_id' => $request->modalId,
                    'customer' => $request->customer,
                    'lokasi' => $request->lokasi,
                    'biaya_jasa' => $request->priceBiayaJasa,
                    'biaya_transport' => $request->priceBiayaTransport,
                    'biaya_gaji_karyawan' => $request->priceGajiKaryawan,
                    'pembayaran' => $request->metode_pembayaran,
                    'keterangan' => $request->keterangan,
                    'status' => $request->metode_pembayaran == 'Cash' ? 'Paid' : 'Waiting'
                ]);

                if ($savePrice){
                    $cars = $this->cars->find($request->modalId);

                    switch ($request->metode_pembayaran) {
                        case 'Cash':
                            $cek_coa = $this->financeCoa->select('code','item')
                                                        ->whereYear('created_at',Carbon::now()->format('Y'))
                                                        ->get();

                            $this->financeJournal->create([
                                'tanggal' => Carbon::now()->format('Y-m-d'),
                                'uraian' => 'Uang Masuk Customer '.$request->customer.' Metode Pembayaran Cash',
                                'code_debit' => $cek_coa[0]['code'],
                                'item_debit' => $cek_coa[0]['item'],
                                'debit' => $request->priceBiayaJasa+$request->priceBiayaTransport,
                                'code_credit' => $cek_coa[20]['code'],
                                'item_credit' => $cek_coa[20]['item'],
                                'credit' => $request->priceBiayaJasa+$request->priceBiayaTransport,
                            ]);

                            $this->financeJournal->create([
                                'tanggal' => Carbon::now()->format('Y-m-d'),
                                'uraian' => 'Biaya Gaji Karyawan Nopol '.$cars->plat_nomor.' Customer '.$request->customer,
                                'code_debit' => $cek_coa[31]['code'],
                                'item_debit' => $cek_coa[31]['item'],
                                'debit' => $request->priceGajiKaryawan,
                                'code_credit' => $cek_coa[0]['code'],
                                'item_credit' => $cek_coa[0]['item'],
                                'credit' => $request->priceGajiKaryawan,
                            ]);

                            if ($request->priceBiayaTransport > 0) {
                                $this->financeJournal->create([
                                    'tanggal' => Carbon::now()->format('Y-m-d'),
                                    'uraian' => 'Biaya Transport Nopol '.$cars->plat_nomor.' Customer '.$request->customer,
                                    'code_debit' => $cek_coa[29]['code'],
                                    'item_debit' => $cek_coa[29]['item'],
                                    'debit' => $request->priceBiayaTransport,
                                    'code_credit' => $cek_coa[0]['code'],
                                    'item_credit' => $cek_coa[0]['item'],
                                    'credit' => $request->priceBiayaTransport,
                                ]);
                            }

                            break;
                        
                        default:
                            # code...
                            break;
                    }
                    $message_title="Berhasil !";
                    $message_content= "Biaya Inspeksi Berhasil Disimpan";
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
                $message_content= "Biaya Inspeksi sudah ditambahkan!";
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

    public function biaya_jasa_detail($id)
    {
        $data = $this->cars->select(
                                    'cars.id as id',
                                    'cars.no_reference as no_reference',
                                    'cars.plat_nomor as plat_nomor',
                                    'cars.warna as warna',
                                    'cars.merk as merk',
                                    'cars.no_rangka as no_rangka',
                                    'cars.model as model',
                                    'cars.transmisi as transmisi',
                                    'cars.status as status',
                                    'finance_biaya_jasa.customer as customer',
                                    'finance_biaya_jasa.lokasi as lokasi',
                                    'finance_biaya_jasa.biaya_jasa as biaya_jasa',
                                    'finance_biaya_jasa.biaya_transport as biaya_transport',
                                    'finance_biaya_jasa.biaya_gaji_karyawan as biaya_gaji_karyawan',
                                    // 'finance_biaya_jasa.total as total',
                                    'finance_biaya_jasa.pembayaran as pembayaran',
                                    'finance_biaya_jasa.status as status_pembayaran',
                                    'cars.created_at as created_at',
                                )
                                ->leftJoin('finance_biaya_jasa','cars.id','=','finance_biaya_jasa.cars_id')
                                ->where('cars.id',$id)
                                ->first();

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Inspeksi Mobil Tidak Ditemukan',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function biaya_jasa_finance_simpan(Request $request)
    {
        $rules = [
            // 'price' => 'required',
            'priceBiayaJasa' => 'required',
            'priceBiayaTransport' => 'required',
            'priceGajiKaryawan' => 'required',
            'keterangan' => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            // 'price.required'  => 'Harga Inspeksi wajib diisi.',
            'priceJasaInspeksi.required'  => 'Harga Jasa Inspeksi wajib diisi.',
            'priceBiayaTransport.required'  => 'Biaya Transport wajib diisi.',
            'priceGajiKaryawan.required'  => 'Gaji Karyawan wajib diisi.',
            'keterangan.required'  => 'Keterangan wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            // $cek_coa = $this->financeCoa->select('code','item')
            //                             ->whereYear('created_at',Carbon::now()->format('Y'))
            //                             ->get();
            // dd($cek_coa[0]['item']);
            $price = $this->priceInspeksi->where('cars_id',$request->modalId)->first();
            
            if (empty($price)) {
                // dd('ok');
                $input['id'] = Str::uuid()->toString();
                $input['cars_id'] = $request->modalId;
                $input['price'] = $request->priceBiayaJasa+$request->priceBiayaTransport;
                // dd($input);
                $savePrice = $this->priceInspeksi->create($input);

                if ($savePrice){
                    $cars = $this->cars->find($request->modalId);

                    $cekBiayaJasa = $this->financeBiayaJasa->where('cars_id',$request->modalId)->first();
                    
                    $cekBiayaJasa->update([
                        'biaya_jasa' => $request->priceBiayaJasa,
                        'biaya_transport' => $request->priceBiayaTransport,
                        'biaya_gaji_karyawan' => $request->priceGajiKaryawan,
                        'pembayaran' => $request->metode_pembayaran,
                        'keterangan' => $request->keterangan,
                        'status' => $request->metode_pembayaran == 'Cash' ? 'Paid' : 'Waiting'
                    ]);

                    switch ($request->metode_pembayaran) {
                        case 'Cash':
                            $cek_coa = $this->financeCoa->select('code','item')
                                                        ->whereYear('created_at',Carbon::now()->format('Y'))
                                                        ->get();

                            $this->financeJournal->create([
                                'tanggal' => Carbon::now()->format('Y-m-d'),
                                'uraian' => 'Uang Masuk Customer '.$cekBiayaJasa->customer.' Metode Pembayaran Cash',
                                'code_debit' => $cek_coa[0]['code'],
                                'item_debit' => $cek_coa[0]['item'],
                                'debit' => $request->priceBiayaJasa+$request->priceBiayaTransport,
                                'code_credit' => $cek_coa[20]['code'],
                                'item_credit' => $cek_coa[20]['item'],
                                'credit' => $request->priceBiayaJasa+$request->priceBiayaTransport,
                            ]);

                            $this->financeJournal->create([
                                'tanggal' => Carbon::now()->format('Y-m-d'),
                                'uraian' => 'Biaya Gaji Karyawan '.$cekBiayaJasa->inspector.' Nopol '.$cars->plat_nomor.' Customer '.$cekBiayaJasa->customer,
                                'code_debit' => $cek_coa[31]['code'],
                                'item_debit' => $cek_coa[31]['item'],
                                'debit' => $request->priceGajiKaryawan,
                                'code_credit' => $cek_coa[0]['code'],
                                'item_credit' => $cek_coa[0]['item'],
                                'credit' => $request->priceGajiKaryawan,
                            ]);

                            if ($request->priceBiayaTransport > 0) {
                                $this->financeJournal->create([
                                    'tanggal' => Carbon::now()->format('Y-m-d'),
                                    'uraian' => 'Biaya Transport '.$cekBiayaJasa->inspector.' Nopol '.$cars->plat_nomor.' Customer '.$cekBiayaJasa->customer,
                                    'code_debit' => $cek_coa[29]['code'],
                                    'item_debit' => $cek_coa[29]['item'],
                                    'debit' => $request->priceBiayaTransport,
                                    'code_credit' => $cek_coa[0]['code'],
                                    'item_credit' => $cek_coa[0]['item'],
                                    'credit' => $request->priceBiayaTransport,
                                ]);
                            }

                            break;
                        
                        default:
                            # code...
                            break;
                    }
                    $message_title="Berhasil !";
                    $message_content= "Biaya Inspeksi Berhasil Disimpan";
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
                $message_content= "Biaya Inspeksi sudah ditambahkan!";
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

    public function biaya_jasa_metodePembayaran_simpan(Request $request)
    {
        $rules = [
            'payment_status' => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'payment_status.required'  => 'Metode Pembayaran wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $biayaJasa = $this->financeBiayaJasa->where('cars_id',$request->modalId)->first();

            $biayaJasa->update([
                'status' => $request->payment_status
            ]);

            if ($biayaJasa){
                $cars = $this->cars->find($request->modalId);

                $cek_coa = $this->financeCoa->select('code','item')
                                            ->whereYear('created_at',Carbon::now()->format('Y'))
                                            ->get();

                $this->financeJournal->create([
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                    'uraian' => 'Uang Masuk Customer '.$biayaJasa->customer.' Metode Pembayaran Transfer',
                    'code_debit' => $cek_coa[3]['code'],
                    'item_debit' => $cek_coa[3]['item'],
                    'debit' => $biayaJasa->biaya_jasa+$biayaJasa->biaya_transport,
                    'code_credit' => $cek_coa[20]['code'],
                    'item_credit' => $cek_coa[20]['item'],
                    'credit' => $biayaJasa->biaya_jasa+$biayaJasa->biaya_transport,
                ]);

                $this->financeJournal->create([
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                    'uraian' => 'Biaya Gaji Karyawan '.$biayaJasa->inspector.' Nopol '.$cars->plat_nomor.' Customer '.$biayaJasa->customer,
                    'code_debit' => $cek_coa[31]['code'],
                    'item_debit' => $cek_coa[31]['item'],
                    'debit' => $biayaJasa->biaya_gaji_karyawan,
                    'code_credit' => $cek_coa[3]['code'],
                    'item_credit' => $cek_coa[3]['item'],
                    'credit' => $biayaJasa->biaya_gaji_karyawan,
                ]);
                if ($biayaJasa->biaya_transport > 0) {
                    $this->financeJournal->create([
                        'tanggal' => Carbon::now()->format('Y-m-d'),
                        'uraian' => 'Biaya Transport '.$biayaJasa->inspector.' Nopol '.$cars->plat_nomor.' Customer '.$biayaJasa->customer,
                        'code_debit' => $cek_coa[29]['code'],
                        'item_debit' => $cek_coa[29]['item'],
                        'debit' => $biayaJasa->biaya_transport,
                        'code_credit' => $cek_coa[3]['code'],
                        'item_credit' => $cek_coa[3]['item'],
                        'credit' => $biayaJasa->biaya_transport,
                    ]);
                }
                
                $message_title="Berhasil !";
                $message_content= "Pembayaran Berhasil Dibuat";
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
    }
}
