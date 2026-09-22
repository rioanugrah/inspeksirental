<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceCoa;
use App\Models\FinanceLajur;

use \Carbon\Carbon;

use DataTables;
use PDF;

class FinanceLajurController extends Controller
{
    function __construct(
        FinanceCoa $financeCoa,
        FinanceLajur $financeLajur
    ){
        $this->middleware('permission:Finance LajurBuku', ['only' => ['index']]);
        $this->financeCoa = $financeCoa;
        $this->financeLajur = $financeLajur;
    }

    public function index(Request $request)
    {
        $lajurs = $this->financeCoa->whereYear('created_at',Carbon::now()->format('Y'))
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        $data['hasilNeracaLajurs'] = [];

        $totalNeracaSaldoBeforeAdjustmentDebit = [];
        $totalNeracaSaldoBeforeAdjustmentCredit = [];
        $totalNeracaAdjustmentDebit = [];
        $totalNeracaAdjustmentCredit = [];
        $totalNeracaSaldoAfterAdjustmentDebit = [];
        $totalNeracaSaldoAfterAdjustmentCredit = [];
        $totalRugiLabaDebit = [];
        $totalRugiLabaCredit = [];
        $totalNeracaAfterDebit = [];
        $totalNeracaAfterCredit = [];

        foreach ($lajurs as $key => $lajur) {
            $neraca_debit = $lajur->journal_debit+$lajur->debit > $lajur->journal_credit+$lajur->credit ? 
                            $lajur->journal_debit+$lajur->debit-($lajur->journal_credit+$lajur->credit) : 0;
            
            $neraca_credit = $lajur->journal_credit+$lajur->credit > $lajur->journal_debit+$lajur->debit ? 
                            $lajur->journal_credit+$lajur->credit-($lajur->journal_debit+$lajur->debit) : 0;
            
            $saldo_after_adjustment_debit = $neraca_debit+$lajur->adjustment_debit > $neraca_credit+$lajur->adjustment_credit ? 
                                            $neraca_debit+$lajur->adjustment_debit-($neraca_credit+$lajur->adjustment_credit) : 0;

            $saldo_after_adjustment_credit = $neraca_credit+$lajur->adjustment_credit > $neraca_debit+$lajur->adjustment_debit ? 
                                            $neraca_credit+$lajur->adjustment_credit-($neraca_debit+$lajur->adjustment_debit) : 0;

            if ($lajur->code < 511) {
                $rugi_laba_debit = 0;
                $rugi_laba_credit = 0;
            }else{
                $rugi_laba_debit = $saldo_after_adjustment_debit;
                $rugi_laba_credit = $saldo_after_adjustment_credit;
            }

            if ($lajur->code > 414) {
                $neraca_after_debit = 0;
                $neraca_after_credit = 0;
            }else{
                $neraca_after_debit = $saldo_after_adjustment_debit;
                $neraca_after_credit = $saldo_after_adjustment_credit;
            }

            array_push($totalNeracaSaldoBeforeAdjustmentDebit, $neraca_debit);
            array_push($totalNeracaSaldoBeforeAdjustmentCredit, $neraca_credit);

            array_push($totalNeracaAdjustmentDebit, $lajur->adjustment_debit);
            array_push($totalNeracaAdjustmentCredit, $lajur->adjustment_credit);

            array_push($totalNeracaSaldoAfterAdjustmentDebit, $saldo_after_adjustment_debit);
            array_push($totalNeracaSaldoAfterAdjustmentCredit, $saldo_after_adjustment_credit);

            array_push($totalRugiLabaDebit, $rugi_laba_debit);
            array_push($totalRugiLabaCredit, $rugi_laba_credit);

            array_push($totalNeracaAfterDebit, $neraca_after_debit);
            array_push($totalNeracaAfterCredit, $neraca_after_credit);

            $data['hasilNeracaLajurs'][] = [
                'code' => $lajur->code,
                'item' => $lajur->item,
                'adjustment_debit' => $lajur->adjustment_debit,
                'adjustment_credit' => $lajur->adjustment_credit,
                'n_saldo_before_adjustment_debit' => $neraca_debit,
                'n_saldo_before_adjustment_credit' => $neraca_credit,
                'n_saldo_after_adjustment_debit' => $saldo_after_adjustment_debit,
                'n_saldo_after_adjustment_credit' => $saldo_after_adjustment_credit,
                'rugi_laba_debit' => $rugi_laba_debit,
                'rugi_laba_credit' => $rugi_laba_credit,
                'neraca_after_debit' => $neraca_after_debit,
                'neraca_after_credit' => $neraca_after_credit,
            ];
        }

        $data['totalNeracaSaldoBeforeAdjustmentDebit'] = array_sum($totalNeracaSaldoBeforeAdjustmentDebit);
        $data['totalNeracaSaldoBeforeAdjustmentCredit'] = array_sum($totalNeracaSaldoBeforeAdjustmentCredit);
        $data['totalNeracaAdjustmentDebit'] = array_sum($totalNeracaAdjustmentDebit);
        $data['totalNeracaAdjustmentCredit'] = array_sum($totalNeracaAdjustmentCredit);
        $data['totalNeracaSaldoAfterAdjustmentDebit'] = array_sum($totalNeracaSaldoAfterAdjustmentDebit);
        $data['totalNeracaSaldoAfterAdjustmentCredit'] = array_sum($totalNeracaSaldoAfterAdjustmentCredit);
        $data['totalRugiLabaDebit'] = array_sum($totalRugiLabaDebit);
        $data['totalRugiLabaCredit'] = array_sum($totalRugiLabaCredit);
        $data['totalNeracaAfterDebit'] = array_sum($totalNeracaAfterDebit);
        $data['totalNeracaAfterCredit'] = array_sum($totalNeracaAfterCredit);
        
        if ($data['totalRugiLabaCredit'] > $data['totalRugiLabaDebit']) {
            $data['totalMinusRugiLabaDebit'] = $data['totalRugiLabaCredit'] - $data['totalRugiLabaDebit'];
        }else{
            $data['totalMinusRugiLabaDebit'] = 0;
        }

        if ($data['totalRugiLabaDebit'] > $data['totalRugiLabaCredit']) {
            $data['totalMinusRugiLabaCredit'] = $data['totalRugiLabaDebit'] - $data['totalRugiLabaCredit'];
        }else{
            $data['totalMinusRugiLabaCredit'] = 0;
        }

        if ($data['totalRugiLabaCredit'] > $data['totalNeracaAfterDebit']) {
            $data['totalMinusNeracaAfterDebit'] = $data['totalRugiLabaCredit'] - $data['totalNeracaAfterDebit'];
        }else{
            $data['totalMinusNeracaAfterDebit'] = 0;
        }

        if ($data['totalNeracaAfterDebit'] > $data['totalNeracaAfterCredit']) {
            $data['totalMinusNeracaAfterCredit'] = $data['totalNeracaAfterDebit'] - $data['totalNeracaAfterCredit'];
        }else{
            $data['totalMinusNeracaAfterCredit'] = 0;
        }

        // dd($data);

        return view('backend.finance.lajur.index',$data);
    }

    public function downloadLaporanBulanan(Request $request)
    {
        $lajurs = $this->financeCoa->whereBetween('created_at',[$request->date_from,$request->date_end])
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        $data['hasilNeracaLajurs'] = [];

        $totalNeracaSaldoBeforeAdjustmentDebit = [];
        $totalNeracaSaldoBeforeAdjustmentCredit = [];
        $totalNeracaAdjustmentDebit = [];
        $totalNeracaAdjustmentCredit = [];
        $totalNeracaSaldoAfterAdjustmentDebit = [];
        $totalNeracaSaldoAfterAdjustmentCredit = [];
        $totalRugiLabaDebit = [];
        $totalRugiLabaCredit = [];
        $totalNeracaAfterDebit = [];
        $totalNeracaAfterCredit = [];

        foreach ($lajurs as $key => $lajur) {
            $neraca_debit = $lajur->journal_debit+$lajur->debit > $lajur->journal_credit+$lajur->credit ? 
                            $lajur->journal_debit+$lajur->debit-($lajur->journal_credit+$lajur->credit) : 0;
            
            $neraca_credit = $lajur->journal_credit+$lajur->credit > $lajur->journal_debit+$lajur->debit ? 
                            $lajur->journal_credit+$lajur->credit-($lajur->journal_debit+$lajur->debit) : 0;
            
            $saldo_after_adjustment_debit = $neraca_debit+$lajur->adjustment_debit > $neraca_credit+$lajur->adjustment_credit ? 
                                            $neraca_debit+$lajur->adjustment_debit-($neraca_credit+$lajur->adjustment_credit) : 0;

            $saldo_after_adjustment_credit = $neraca_credit+$lajur->adjustment_credit > $neraca_debit+$lajur->adjustment_debit ? 
                                            $neraca_credit+$lajur->adjustment_credit-($neraca_debit+$lajur->adjustment_debit) : 0;

            if ($lajur->code < 511) {
                $rugi_laba_debit = 0;
                $rugi_laba_credit = 0;
            }else{
                $rugi_laba_debit = $saldo_after_adjustment_debit;
                $rugi_laba_credit = $saldo_after_adjustment_credit;
            }

            if ($lajur->code > 414) {
                $neraca_after_debit = 0;
                $neraca_after_credit = 0;
            }else{
                $neraca_after_debit = $saldo_after_adjustment_debit;
                $neraca_after_credit = $saldo_after_adjustment_credit;
            }

            array_push($totalNeracaSaldoBeforeAdjustmentDebit, $neraca_debit);
            array_push($totalNeracaSaldoBeforeAdjustmentCredit, $neraca_credit);

            array_push($totalNeracaAdjustmentDebit, $lajur->adjustment_debit);
            array_push($totalNeracaAdjustmentCredit, $lajur->adjustment_credit);

            array_push($totalNeracaSaldoAfterAdjustmentDebit, $saldo_after_adjustment_debit);
            array_push($totalNeracaSaldoAfterAdjustmentCredit, $saldo_after_adjustment_credit);

            array_push($totalRugiLabaDebit, $rugi_laba_debit);
            array_push($totalRugiLabaCredit, $rugi_laba_credit);

            array_push($totalNeracaAfterDebit, $neraca_after_debit);
            array_push($totalNeracaAfterCredit, $neraca_after_credit);

            $data['hasilNeracaLajurs'][] = [
                'code' => $lajur->code,
                'item' => $lajur->item,
                'adjustment_debit' => $lajur->adjustment_debit,
                'adjustment_credit' => $lajur->adjustment_credit,
                'n_saldo_before_adjustment_debit' => $neraca_debit,
                'n_saldo_before_adjustment_credit' => $neraca_credit,
                'n_saldo_after_adjustment_debit' => $saldo_after_adjustment_debit,
                'n_saldo_after_adjustment_credit' => $saldo_after_adjustment_credit,
                'rugi_laba_debit' => $rugi_laba_debit,
                'rugi_laba_credit' => $rugi_laba_credit,
                'neraca_after_debit' => $neraca_after_debit,
                'neraca_after_credit' => $neraca_after_credit,
            ];
        }

        $data['totalNeracaSaldoBeforeAdjustmentDebit'] = array_sum($totalNeracaSaldoBeforeAdjustmentDebit);
        $data['totalNeracaSaldoBeforeAdjustmentCredit'] = array_sum($totalNeracaSaldoBeforeAdjustmentCredit);
        $data['totalNeracaAdjustmentDebit'] = array_sum($totalNeracaAdjustmentDebit);
        $data['totalNeracaAdjustmentCredit'] = array_sum($totalNeracaAdjustmentCredit);
        $data['totalNeracaSaldoAfterAdjustmentDebit'] = array_sum($totalNeracaSaldoAfterAdjustmentDebit);
        $data['totalNeracaSaldoAfterAdjustmentCredit'] = array_sum($totalNeracaSaldoAfterAdjustmentCredit);
        $data['totalRugiLabaDebit'] = array_sum($totalRugiLabaDebit);
        $data['totalRugiLabaCredit'] = array_sum($totalRugiLabaCredit);
        $data['totalNeracaAfterDebit'] = array_sum($totalNeracaAfterDebit);
        $data['totalNeracaAfterCredit'] = array_sum($totalNeracaAfterCredit);
        
        if ($data['totalRugiLabaCredit'] > $data['totalRugiLabaDebit']) {
            $data['totalMinusRugiLabaDebit'] = $data['totalRugiLabaCredit'] - $data['totalRugiLabaDebit'];
        }else{
            $data['totalMinusRugiLabaDebit'] = 0;
        }

        if ($data['totalRugiLabaDebit'] > $data['totalRugiLabaCredit']) {
            $data['totalMinusRugiLabaCredit'] = $data['totalRugiLabaDebit'] - $data['totalRugiLabaCredit'];
        }else{
            $data['totalMinusRugiLabaCredit'] = 0;
        }

        if ($data['totalRugiLabaCredit'] > $data['totalNeracaAfterDebit']) {
            $data['totalMinusNeracaAfterDebit'] = $data['totalRugiLabaCredit'] - $data['totalNeracaAfterDebit'];
        }else{
            $data['totalMinusNeracaAfterDebit'] = 0;
        }

        if ($data['totalNeracaAfterDebit'] > $data['totalNeracaAfterCredit']) {
            $data['totalMinusNeracaAfterCredit'] = $data['totalNeracaAfterDebit'] - $data['totalNeracaAfterCredit'];
        }else{
            $data['totalMinusNeracaAfterCredit'] = 0;
        }

        $pdf = PDF::loadView('backend.finance.lajur.laporanBulananPdf',$data);
        $pdf->setPaper('A3', 'landscape');

        return $pdf->stream('Laporan Lajur Buku Bulanan Afkar Mobil Periode '.$request->date_from.' sd '.$request->date_end.'.pdf');

    }

    public function downloadLaporanTahunan(Request $request)
    {
        $lajurs = $this->financeCoa->whereYear('created_at',$request->year)
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        $data['hasilNeracaLajurs'] = [];

        $totalNeracaSaldoBeforeAdjustmentDebit = [];
        $totalNeracaSaldoBeforeAdjustmentCredit = [];
        $totalNeracaAdjustmentDebit = [];
        $totalNeracaAdjustmentCredit = [];
        $totalNeracaSaldoAfterAdjustmentDebit = [];
        $totalNeracaSaldoAfterAdjustmentCredit = [];
        $totalRugiLabaDebit = [];
        $totalRugiLabaCredit = [];
        $totalNeracaAfterDebit = [];
        $totalNeracaAfterCredit = [];

        foreach ($lajurs as $key => $lajur) {
            $neraca_debit = $lajur->journal_debit+$lajur->debit > $lajur->journal_credit+$lajur->credit ? 
                            $lajur->journal_debit+$lajur->debit-($lajur->journal_credit+$lajur->credit) : 0;
            
            $neraca_credit = $lajur->journal_credit+$lajur->credit > $lajur->journal_debit+$lajur->debit ? 
                            $lajur->journal_credit+$lajur->credit-($lajur->journal_debit+$lajur->debit) : 0;
            
            $saldo_after_adjustment_debit = $neraca_debit+$lajur->adjustment_debit > $neraca_credit+$lajur->adjustment_credit ? 
                                            $neraca_debit+$lajur->adjustment_debit-($neraca_credit+$lajur->adjustment_credit) : 0;

            $saldo_after_adjustment_credit = $neraca_credit+$lajur->adjustment_credit > $neraca_debit+$lajur->adjustment_debit ? 
                                            $neraca_credit+$lajur->adjustment_credit-($neraca_debit+$lajur->adjustment_debit) : 0;

            if ($lajur->code < 511) {
                $rugi_laba_debit = 0;
                $rugi_laba_credit = 0;
            }else{
                $rugi_laba_debit = $saldo_after_adjustment_debit;
                $rugi_laba_credit = $saldo_after_adjustment_credit;
            }

            if ($lajur->code > 414) {
                $neraca_after_debit = 0;
                $neraca_after_credit = 0;
            }else{
                $neraca_after_debit = $saldo_after_adjustment_debit;
                $neraca_after_credit = $saldo_after_adjustment_credit;
            }

            array_push($totalNeracaSaldoBeforeAdjustmentDebit, $neraca_debit);
            array_push($totalNeracaSaldoBeforeAdjustmentCredit, $neraca_credit);

            array_push($totalNeracaAdjustmentDebit, $lajur->adjustment_debit);
            array_push($totalNeracaAdjustmentCredit, $lajur->adjustment_credit);

            array_push($totalNeracaSaldoAfterAdjustmentDebit, $saldo_after_adjustment_debit);
            array_push($totalNeracaSaldoAfterAdjustmentCredit, $saldo_after_adjustment_credit);

            array_push($totalRugiLabaDebit, $rugi_laba_debit);
            array_push($totalRugiLabaCredit, $rugi_laba_credit);

            array_push($totalNeracaAfterDebit, $neraca_after_debit);
            array_push($totalNeracaAfterCredit, $neraca_after_credit);

            $data['hasilNeracaLajurs'][] = [
                'code' => $lajur->code,
                'item' => $lajur->item,
                'adjustment_debit' => $lajur->adjustment_debit,
                'adjustment_credit' => $lajur->adjustment_credit,
                'n_saldo_before_adjustment_debit' => $neraca_debit,
                'n_saldo_before_adjustment_credit' => $neraca_credit,
                'n_saldo_after_adjustment_debit' => $saldo_after_adjustment_debit,
                'n_saldo_after_adjustment_credit' => $saldo_after_adjustment_credit,
                'rugi_laba_debit' => $rugi_laba_debit,
                'rugi_laba_credit' => $rugi_laba_credit,
                'neraca_after_debit' => $neraca_after_debit,
                'neraca_after_credit' => $neraca_after_credit,
            ];
        }

        $data['totalNeracaSaldoBeforeAdjustmentDebit'] = array_sum($totalNeracaSaldoBeforeAdjustmentDebit);
        $data['totalNeracaSaldoBeforeAdjustmentCredit'] = array_sum($totalNeracaSaldoBeforeAdjustmentCredit);
        $data['totalNeracaAdjustmentDebit'] = array_sum($totalNeracaAdjustmentDebit);
        $data['totalNeracaAdjustmentCredit'] = array_sum($totalNeracaAdjustmentCredit);
        $data['totalNeracaSaldoAfterAdjustmentDebit'] = array_sum($totalNeracaSaldoAfterAdjustmentDebit);
        $data['totalNeracaSaldoAfterAdjustmentCredit'] = array_sum($totalNeracaSaldoAfterAdjustmentCredit);
        $data['totalRugiLabaDebit'] = array_sum($totalRugiLabaDebit);
        $data['totalRugiLabaCredit'] = array_sum($totalRugiLabaCredit);
        $data['totalNeracaAfterDebit'] = array_sum($totalNeracaAfterDebit);
        $data['totalNeracaAfterCredit'] = array_sum($totalNeracaAfterCredit);
        
        if ($data['totalRugiLabaCredit'] > $data['totalRugiLabaDebit']) {
            $data['totalMinusRugiLabaDebit'] = $data['totalRugiLabaCredit'] - $data['totalRugiLabaDebit'];
        }else{
            $data['totalMinusRugiLabaDebit'] = 0;
        }

        if ($data['totalRugiLabaDebit'] > $data['totalRugiLabaCredit']) {
            $data['totalMinusRugiLabaCredit'] = $data['totalRugiLabaDebit'] - $data['totalRugiLabaCredit'];
        }else{
            $data['totalMinusRugiLabaCredit'] = 0;
        }

        if ($data['totalRugiLabaCredit'] > $data['totalNeracaAfterDebit']) {
            $data['totalMinusNeracaAfterDebit'] = $data['totalRugiLabaCredit'] - $data['totalNeracaAfterDebit'];
        }else{
            $data['totalMinusNeracaAfterDebit'] = 0;
        }

        if ($data['totalNeracaAfterDebit'] > $data['totalNeracaAfterCredit']) {
            $data['totalMinusNeracaAfterCredit'] = $data['totalNeracaAfterDebit'] - $data['totalNeracaAfterCredit'];
        }else{
            $data['totalMinusNeracaAfterCredit'] = 0;
        }

        $pdf = PDF::loadView('backend.finance.lajur.laporanTahunanPdf',$data);
        $pdf->setPaper('A3', 'landscape');

        return $pdf->stream('Laporan Lajur Buku Tahunan Afkar Mobil Periode '.$request->year.'.pdf');

    }
}
