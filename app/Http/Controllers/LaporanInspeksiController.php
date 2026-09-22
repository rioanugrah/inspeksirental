<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use DB;
use PDF;

class LaporanInspeksiController extends Controller
{
    function __construct(
        Cars $cars
    ){
        $this->cars = $cars;
    }

    public function index()
    {
        $from = Carbon::now()->startOfYear()->format('Y-m');
        $to = Carbon::now()->endOfYear()->format('Y-m');

        for ($i=$from; $i <= $to ; $i++) {
            $data['periods'][] = [
                'date' => $i,
                'total_cars' => $this->cars->where('created_at','LIKE','%'.$i.'%')
                                    ->count()
            ];
        }

        return view('backend.laporan.inspeksi.index',$data);
    }

    public function cari_data(Request $request)
    {
        if ($request->years == 'all') {
            $data['periods'] = $this->cars->selectRaw("COUNT(*) total_cars, DATE_FORMAT(created_at, '%Y-%m') date")
                                            ->groupBy('date')
                                            ->orderBy('date','desc')
                                            ->get();

        }else{
            $data['periods'] = $this->cars->selectRaw("COUNT(*) total_cars, DATE_FORMAT(created_at, '%Y-%m') date")
                                            ->whereYear('created_at',$request->years)
                                            ->groupBy('date')
                                            ->orderBy('date','desc')
                                            ->get();
        }

        return view('backend.laporan.inspeksi.cari',$data);
    }

    public function download_rekap_inspeksi($date)
    {
        $data['cars'] = $this->cars->where('created_at','like','%'.$date.'%')
                                    ->orderBy('created_at','asc')
                                    ->get();
        $data['date'] = $date;

        $pdf = PDF::loadView('backend.laporan.inspeksi.rekapInspeksiPdf',$data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption([
            // 'dpi' => 10,
            'enable_remote' => true
        ]);

        return $pdf->stream('Laporan Hasil Inspeksi Afkar Mobil Periode '.Carbon::create($date)->isoFormat('MMMM YYYY').'.pdf');
    }
}
