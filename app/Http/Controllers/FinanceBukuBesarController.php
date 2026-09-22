<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceCoa;
use App\Models\FinanceJournal;

use \Carbon\Carbon;

use DataTables;
use PDF;


class FinanceBukuBesarController extends Controller
{
    function __construct(
        FinanceCoa $financeCoa,
        FinanceJournal $financeJournal
    ){
        $this->middleware('permission:Finance BukuBesar', ['only' => ['index']]);
        $this->financeCoa = $financeCoa;
        $this->financeJournal = $financeJournal;
    }

    public function index(Request $request)
    {
        $coas = $this->financeCoa->whereYear('created_at',Carbon::now()->format('Y'))
                                ->withSum('debitJournals as journal_debit','debit')
                                ->withSum('creditJournals as journal_credit','credit')
                                ->orderBy('code','asc')
                                ->get();

        $data['hasilBukuBesar'] = [];

        $totalSaDebit = [];
        $totalSaCredit = [];
        $totalDebit = [];
        $totalCredit = [];
        $totalNeracaDebit = [];
        $totalNeracaCredit = [];

        foreach ($coas as $key => $coa) {

            $neraca_debit = $coa->journal_debit+$coa->debit > $coa->journal_credit+$coa->credit ? 
                            $coa->journal_debit+$coa->debit-($coa->journal_credit+$coa->credit) : 0;
            
            $neraca_credit = $coa->journal_credit+$coa->credit > $coa->journal_debit+$coa->debit ? 
                            $coa->journal_credit+$coa->credit-($coa->journal_debit+$coa->debit) : 0;
        
            $data['hasilBukuBesar'][] = [
                'code' => $coa->code,
                'item' => $coa->item,
                'sa_debit' => $coa->debit,
                'sa_credit' => $coa->credit,
                'debit' => $coa->journal_debit,
                'credit' => $coa->journal_credit,
                'neraca_debit' => $neraca_debit,
                'neraca_credit' => $neraca_credit,
            ];

            array_push($totalSaDebit,$coa->debit);
            array_push($totalSaCredit,$coa->credit);
            array_push($totalDebit,$coa->journal_debit);
            array_push($totalCredit,$coa->journal_credit);
            array_push($totalNeracaDebit,$neraca_debit);
            array_push($totalNeracaCredit,$neraca_credit);
        }

        $data['totalSaDebit'] = array_sum($totalSaDebit);
        $data['totalSaCredit'] = array_sum($totalSaCredit);
        $data['totalDebit'] = array_sum($totalDebit);
        $data['totalCredit'] = array_sum($totalCredit);
        $data['totalNeracaDebit'] = array_sum($totalNeracaDebit);
        $data['totalNeracaCredit'] = array_sum($totalNeracaCredit);
                                        // dd($hasilBukuBesar);

        return view('backend.finance.buku_besar.index',$data);
    }

    public function downloadLaporanBulanan(Request $request)
    {
        $coas = $this->financeCoa->whereBetween('created_at',[$request->date_from,$request->date_end])
                                ->withSum('debitJournals as journal_debit','debit')
                                ->withSum('creditJournals as journal_credit','credit')
                                ->orderBy('code','asc')
                                ->get();

        $data['hasilBukuBesar'] = [];

        $totalSaDebit = [];
        $totalSaCredit = [];
        $totalDebit = [];
        $totalCredit = [];
        $totalNeracaDebit = [];
        $totalNeracaCredit = [];

        foreach ($coas as $key => $coa) {

            $neraca_debit = $coa->journal_debit+$coa->debit > $coa->journal_credit+$coa->credit ? 
                            $coa->journal_debit+$coa->debit-($coa->journal_credit+$coa->credit) : 0;
            
            $neraca_credit = $coa->journal_credit+$coa->credit > $coa->journal_debit+$coa->debit ? 
                            $coa->journal_credit+$coa->credit-($coa->journal_debit+$coa->debit) : 0;
        
            $data['hasilBukuBesar'][] = [
                'code' => $coa->code,
                'item' => $coa->item,
                'sa_debit' => $coa->debit,
                'sa_credit' => $coa->credit,
                'debit' => $coa->journal_debit,
                'credit' => $coa->journal_credit,
                'neraca_debit' => $neraca_debit,
                'neraca_credit' => $neraca_credit,
            ];

            array_push($totalSaDebit,$coa->debit);
            array_push($totalSaCredit,$coa->credit);
            array_push($totalDebit,$coa->journal_debit);
            array_push($totalCredit,$coa->journal_credit);
            array_push($totalNeracaDebit,$neraca_debit);
            array_push($totalNeracaCredit,$neraca_credit);
        }

        $data['totalSaDebit'] = array_sum($totalSaDebit);
        $data['totalSaCredit'] = array_sum($totalSaCredit);
        $data['totalDebit'] = array_sum($totalDebit);
        $data['totalCredit'] = array_sum($totalCredit);
        $data['totalNeracaDebit'] = array_sum($totalNeracaDebit);
        $data['totalNeracaCredit'] = array_sum($totalNeracaCredit);

        $pdf = PDF::loadView('backend.finance.buku_besar.laporanBulananPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Buku Besar Bulanan Afkar Mobil Periode '.$request->date_from.' sd '.$request->date_end.'.pdf');

    }

    public function downloadLaporanTahunan(Request $request)
    {
        $coas = $this->financeCoa->whereYear('created_at',$request->year)
                                ->withSum('debitJournals as journal_debit','debit')
                                ->withSum('creditJournals as journal_credit','credit')
                                ->orderBy('code','asc')
                                ->get();

        $data['hasilBukuBesar'] = [];

        $totalSaDebit = [];
        $totalSaCredit = [];
        $totalDebit = [];
        $totalCredit = [];
        $totalNeracaDebit = [];
        $totalNeracaCredit = [];

        foreach ($coas as $key => $coa) {

            $neraca_debit = $coa->journal_debit+$coa->debit > $coa->journal_credit+$coa->credit ? 
                            $coa->journal_debit+$coa->debit-($coa->journal_credit+$coa->credit) : 0;
            
            $neraca_credit = $coa->journal_credit+$coa->credit > $coa->journal_debit+$coa->debit ? 
                            $coa->journal_credit+$coa->credit-($coa->journal_debit+$coa->debit) : 0;
        
            $data['hasilBukuBesar'][] = [
                'code' => $coa->code,
                'item' => $coa->item,
                'sa_debit' => $coa->debit,
                'sa_credit' => $coa->credit,
                'debit' => $coa->journal_debit,
                'credit' => $coa->journal_credit,
                'neraca_debit' => $neraca_debit,
                'neraca_credit' => $neraca_credit,
            ];

            array_push($totalSaDebit,$coa->debit);
            array_push($totalSaCredit,$coa->credit);
            array_push($totalDebit,$coa->journal_debit);
            array_push($totalCredit,$coa->journal_credit);
            array_push($totalNeracaDebit,$neraca_debit);
            array_push($totalNeracaCredit,$neraca_credit);
        }

        $data['totalSaDebit'] = array_sum($totalSaDebit);
        $data['totalSaCredit'] = array_sum($totalSaCredit);
        $data['totalDebit'] = array_sum($totalDebit);
        $data['totalCredit'] = array_sum($totalCredit);
        $data['totalNeracaDebit'] = array_sum($totalNeracaDebit);
        $data['totalNeracaCredit'] = array_sum($totalNeracaCredit);

        $pdf = PDF::loadView('backend.finance.buku_besar.laporanTahunanPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Buku Besar Tahunan Afkar Mobil Periode '.$request->date_from.' sd '.$request->date_end.'.pdf');

    }
}
