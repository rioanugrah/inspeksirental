<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use \Carbon\Carbon;
use PDF;

class LaporanKeuanganController extends Controller
{
    function __construct(
        Cars $cars
    ){
        $this->cars = $cars;

        $this->middleware('permission:Keuangan List', ['only' => ['index','cari_data']]);
        // $this->middleware('permission:Keuangan Create', ['only' => ['index']]);
    }

    public function index()
    {
        $data['cars'] = $this->cars->select(
                                        'cars.no_reference as no_reference',
                                        'cars.plat_nomor as plat_nomor',
                                        'cars.merk as merek',
                                        'price_inspeksi.price as price',
                                        'cars.status as status',
                                        'cars.created_at as created_at',
                                        'cars.updated_at as updated_at',
                                    )
                                    ->leftJoin('price_inspeksi','price_inspeksi.cars_id','=','cars.id')
                                    ->where('cars.status','Selesai')
                                    ->whereYear('cars.created_at',date('Y'))
                                    ->orderBy('cars.created_at','desc')
                                    ->get();
        // dd($data);
        return view('backend.laporan.keuangan.index',$data);
    }

    public function cari_data(Request $request)
    {
        $data['cars'] = $this->cars->select(
                                        'cars.no_reference as no_reference',
                                        'cars.plat_nomor as plat_nomor',
                                        'cars.merk as merek',
                                        'price_inspeksi.price as price',
                                        'cars.status as status',
                                        'cars.created_at as created_at',
                                        'cars.updated_at as updated_at',
                                    )
                                    ->leftJoin('price_inspeksi','price_inspeksi.cars_id','=','cars.id')
                                    ->where('cars.status','Selesai')
                                    ->whereMonth('cars.created_at','LIKE','%'.$request->month.'%')
                                    ->whereYear('cars.created_at',$request->years)
                                    ->orderBy('cars.created_at','desc')
                                    ->get();

        return view('backend.laporan.keuangan.cari',$data);
    }

    public function export_pdf(Request $request)
    {
        $data['periode'] = Carbon::create($request->years.'-'.$request->month)->isoFormat('MMMM YYYY');
        $data['cars'] = $this->cars->select(
                                        'cars.no_reference as no_reference',
                                        'cars.plat_nomor as plat_nomor',
                                        'cars.warna as warna',
                                        'cars.merk as merek',
                                        'cars.model as model',
                                        'cars.tahun as tahun',
                                        'cars.transmisi as transmisi',
                                        'price_inspeksi.price as price',
                                        'cars.status as status',
                                        'cars.created_at as created_at',
                                        'cars.updated_at as updated_at',
                                    )
                                    ->leftJoin('price_inspeksi','price_inspeksi.cars_id','=','cars.id')
                                    ->where('cars.status','Selesai')
                                    ->whereMonth('cars.created_at',$request->month)
                                    ->whereYear('cars.created_at',$request->years)
                                    ->orderBy('cars.created_at','desc')
                                    ->get();

        $pdf = PDF::loadview('backend.laporan.keuangan.exportPDF',$data);
        $pdf->set_paper('A4', 'landscape');
        return $pdf->stream('Laporan Keuangan Afkar Mobil Periode '.$data['periode'].'.pdf');
    }

    public function export_excel(Request $request)
    {
        $data['periode'] = Carbon::create($request->years.'-'.$request->month)->isoFormat('MMMM YYYY');
        $data['cars'] = $this->cars->select(
                                        'cars.no_reference as no_reference',
                                        'cars.plat_nomor as plat_nomor',
                                        'cars.warna as warna',
                                        'cars.merk as merek',
                                        'cars.model as model',
                                        'cars.tahun as tahun',
                                        'cars.transmisi as transmisi',
                                        'price_inspeksi.price as price',
                                        'cars.status as status',
                                        'cars.created_at as created_at',
                                        'cars.updated_at as updated_at',
                                    )
                                    ->leftJoin('price_inspeksi','price_inspeksi.cars_id','=','cars.id')
                                    ->where('cars.status','Selesai')
                                    ->whereMonth('cars.created_at',$request->month)
                                    ->whereYear('cars.created_at',$request->years)
                                    ->orderBy('cars.created_at','desc')
                                    ->get();
    }
}
