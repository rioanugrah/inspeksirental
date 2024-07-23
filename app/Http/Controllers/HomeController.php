<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use \Carbon\Carbon;
use Carbon\CarbonPeriod;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Cars $car
    )
    {
        $this->car = $car;
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = Carbon::now();
        $data['total_car'] = $this->car->count();
        $data['total_car_inspeksi'] = $this->car->where('status','selesai')->count();

        $week_start = $date->startOfYear()->format('Y-m');
        $week_end = $date->endOfYear()->format('Y-m');

        $years = CarbonPeriod::create($week_start, $week_end)->month();

        foreach ($years as $key => $value) {
            $data['count_inspeksi'][] = $this->car->where('created_at','like','%'.$value->format('Y-m').'%')->count();
            $data['years'][] = $value->format('m-Y');
        }

        // dd($data);

        // $data['total_inspeksi_done_year'] = $this->car->whereMonth('created_at','<=',$date)
        //                                             ->whereMonth('created_at','>=',$data)
        //                                             ->where('status','selesai')
        //                                             ->get();
        //                                         dd($data);
        return view('backend.home.index',$data);
    }
}
