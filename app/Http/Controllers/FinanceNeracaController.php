<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceCoa;
use App\Models\FinanceLajur;

use \Carbon\Carbon;

use DataTables;
use PDF;

class FinanceNeracaController extends Controller
{
    function __construct(
        FinanceCoa $financeCoa,
        FinanceLajur $financeLajur
    ){
        $this->middleware('permission:Finance Neraca', ['only' => ['index','report_period']]);
        $this->financeCoa = $financeCoa;
        $this->financeLajur = $financeLajur;
    }

    public function index()
    {
        // $lajurs = $this->financeCoa->whereYear('created_at',Carbon::now()->format('Y'))
        //                             ->withSum('debitJournals as journal_debit','debit')
        //                             ->withSum('creditJournals as journal_credit','credit')
        //                             ->orderBy('code','asc')
        //                             ->get();
        $lajurs = $this->financeCoa
                                    // ->whereIn('code',['412','413'])
                                    ->whereYear('created_at',Carbon::now()->format('Y'))
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        $data['hasilNeracaLajurs'] = [];
        $totalAktivaLancar = [];
        $totalKewajibanLancar = [];

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

        $totalModalDasarKewajibanLancar = [];
        $totalModalTambahanKewajibanLancar = [];
        $totalLabaBulanBerjalanSetelahPjkKewajibanLancar = [];
        $totalLabaDitahanKewajibanLancar = [];

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

            $aktivaLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_debit - $neraca_after_credit;
            // $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_credit - $neraca_after_debit : $neraca_after_credit;
            $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_credit;
            $modalDasarKewajibanLancar = $neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit;

            if ($rugi_laba_credit > $neraca_after_debit) {
                $totalMinusNeracaAfterDebit = $rugi_laba_credit - $neraca_after_debit;
            }else{
                $totalMinusNeracaAfterDebit = 0;
            }

            if ($neraca_after_debit > $neraca_after_credit) {
                $totalMinusNeracaAfterCredit = $neraca_after_debit - $neraca_after_credit;
            }else{
                $totalMinusNeracaAfterCredit = 0;
            }

            // dd($neraca_after_credit,$neraca_after_debit);

            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            $modalDasarKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaDitahan = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            
            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            
            // $labaBulanBerjalanSetelahPjk = $totalMinusNeracaAfterCredit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit);
            
            array_push($totalAktivaLancar, $aktivaLancar);
            array_push($totalKewajibanLancar, $kewajibanLancar);

            array_push($totalModalDasarKewajibanLancar, $modalDasarKewajibanLancar);
            array_push($totalModalTambahanKewajibanLancar, $modalTambahanKewajibanLancar);
            array_push($totalLabaBulanBerjalanSetelahPjkKewajibanLancar, $labaBulanBerjalanSetelahPjk);

            // $data['hasilNeracaLajurs'][] = [
            //     'code' => $lajur->code,
            //     'item' => $lajur->item,
            //     'aktiva_lancar' => $aktivaLancar,
            //     'kewajiban_lancar' => $kewajibanLancar,
            //     'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
            //     'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
            //     'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
            // ];
            $data['hasilNeracaLajurs'][] = [
                'code' => $lajur->code,
                'item' => $lajur->item,
                'aktiva_lancar' => $aktivaLancar,
                'kewajiban_lancar' => $kewajibanLancar,
                'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
                'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
                'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
                'laba_ditahan' => $labaDitahan,
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

        // $data['modal_dasar_kewajiban_lancar'] = array_sum($totalModalDasarKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['modal_tambahan_kewajiban_lancar'] = array_sum($totalModalTambahanKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['laba_bulan_setelah_pjk_kewajiban_lancar'] = array_sum($totalLabaBulanBerjalanSetelahPjkKewajibanLancar)+$data['totalMinusNeracaAfterCredit'];

        // dd($data['hasilNeracaLajurs']);
        // dd($data);

        // $data['totalAktivaLancar'] = array_sum($totalAktivaLancar);
        // $data['totalKewajibanLancar'] = array_sum($totalKewajibanLancar);

        return view('backend.finance.neraca.index',$data);
    }

    public function report_period(Request $request)
    {
        $lajurs = $this->financeCoa
                                    // ->whereIn('code',['412','413'])
                                    ->whereYear('created_at',$request->periode)
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        if ($lajurs->isEmpty()) {
            return redirect()->back();
        }

        $data['hasilNeracaLajurs'] = [];
        $totalAktivaLancar = [];
        $totalKewajibanLancar = [];

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

        $totalModalDasarKewajibanLancar = [];
        $totalModalTambahanKewajibanLancar = [];
        $totalLabaBulanBerjalanSetelahPjkKewajibanLancar = [];
        $totalLabaDitahanKewajibanLancar = [];

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

            $aktivaLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_debit - $neraca_after_credit;
            // $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_credit - $neraca_after_debit : $neraca_after_credit;
            $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_credit;
            $modalDasarKewajibanLancar = $neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit;

            if ($rugi_laba_credit > $neraca_after_debit) {
                $totalMinusNeracaAfterDebit = $rugi_laba_credit - $neraca_after_debit;
            }else{
                $totalMinusNeracaAfterDebit = 0;
            }

            if ($neraca_after_debit > $neraca_after_credit) {
                $totalMinusNeracaAfterCredit = $neraca_after_debit - $neraca_after_credit;
            }else{
                $totalMinusNeracaAfterCredit = 0;
            }

            // dd($neraca_after_credit,$neraca_after_debit);

            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            $modalDasarKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaDitahan = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            
            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            
            // $labaBulanBerjalanSetelahPjk = $totalMinusNeracaAfterCredit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit);
            
            array_push($totalAktivaLancar, $aktivaLancar);
            array_push($totalKewajibanLancar, $kewajibanLancar);

            array_push($totalModalDasarKewajibanLancar, $modalDasarKewajibanLancar);
            array_push($totalModalTambahanKewajibanLancar, $modalTambahanKewajibanLancar);
            array_push($totalLabaBulanBerjalanSetelahPjkKewajibanLancar, $labaBulanBerjalanSetelahPjk);

            // $data['hasilNeracaLajurs'][] = [
            //     'code' => $lajur->code,
            //     'item' => $lajur->item,
            //     'aktiva_lancar' => $aktivaLancar,
            //     'kewajiban_lancar' => $kewajibanLancar,
            //     'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
            //     'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
            //     'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
            // ];
            $data['hasilNeracaLajurs'][] = [
                'code' => $lajur->code,
                'item' => $lajur->item,
                'aktiva_lancar' => $aktivaLancar,
                'kewajiban_lancar' => $kewajibanLancar,
                'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
                'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
                'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
                'laba_ditahan' => $labaDitahan,
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

        // $data['modal_dasar_kewajiban_lancar'] = array_sum($totalModalDasarKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['modal_tambahan_kewajiban_lancar'] = array_sum($totalModalTambahanKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['laba_bulan_setelah_pjk_kewajiban_lancar'] = array_sum($totalLabaBulanBerjalanSetelahPjkKewajibanLancar)+$data['totalMinusNeracaAfterCredit'];

        $pdf = PDF::loadView('backend.finance.neraca.reportPeriod',$data);
        $pdf->setOption([
            'enable_remote' => true
        ]);

        return $pdf->stream('Laporan Posisi Keuangan Neraca Afkar Mobil Periode '.date('Y').'.pdf');
    }

    public function downloadLaporanBulanan(Request $request)
    {
        $lajurs = $this->financeCoa->whereBetween('created_at',[$request->date_from,$request->date_end])
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        $data['hasilNeracaLajurs'] = [];
        $totalAktivaLancar = [];
        $totalKewajibanLancar = [];

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

        $totalModalDasarKewajibanLancar = [];
        $totalModalTambahanKewajibanLancar = [];
        $totalLabaBulanBerjalanSetelahPjkKewajibanLancar = [];
        $totalLabaDitahanKewajibanLancar = [];

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

            $aktivaLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_debit - $neraca_after_credit;
            // $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_credit - $neraca_after_debit : $neraca_after_credit;
            $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_credit;
            $modalDasarKewajibanLancar = $neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit;

            if ($rugi_laba_credit > $neraca_after_debit) {
                $totalMinusNeracaAfterDebit = $rugi_laba_credit - $neraca_after_debit;
            }else{
                $totalMinusNeracaAfterDebit = 0;
            }

            if ($neraca_after_debit > $neraca_after_credit) {
                $totalMinusNeracaAfterCredit = $neraca_after_debit - $neraca_after_credit;
            }else{
                $totalMinusNeracaAfterCredit = 0;
            }

            // dd($neraca_after_credit,$neraca_after_debit);

            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            $modalDasarKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaDitahan = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            
            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            
            // $labaBulanBerjalanSetelahPjk = $totalMinusNeracaAfterCredit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit);
            
            array_push($totalAktivaLancar, $aktivaLancar);
            array_push($totalKewajibanLancar, $kewajibanLancar);

            array_push($totalModalDasarKewajibanLancar, $modalDasarKewajibanLancar);
            array_push($totalModalTambahanKewajibanLancar, $modalTambahanKewajibanLancar);
            array_push($totalLabaBulanBerjalanSetelahPjkKewajibanLancar, $labaBulanBerjalanSetelahPjk);

            // $data['hasilNeracaLajurs'][] = [
            //     'code' => $lajur->code,
            //     'item' => $lajur->item,
            //     'aktiva_lancar' => $aktivaLancar,
            //     'kewajiban_lancar' => $kewajibanLancar,
            //     'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
            //     'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
            //     'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
            // ];
            $data['hasilNeracaLajurs'][] = [
                'code' => $lajur->code,
                'item' => $lajur->item,
                'aktiva_lancar' => $aktivaLancar,
                'kewajiban_lancar' => $kewajibanLancar,
                'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
                'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
                'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
                'laba_ditahan' => $labaDitahan,
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

        // $data['modal_dasar_kewajiban_lancar'] = array_sum($totalModalDasarKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['modal_tambahan_kewajiban_lancar'] = array_sum($totalModalTambahanKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['laba_bulan_setelah_pjk_kewajiban_lancar'] = array_sum($totalLabaBulanBerjalanSetelahPjkKewajibanLancar)+$data['totalMinusNeracaAfterCredit'];

        $pdf = PDF::loadView('backend.finance.neraca.laporanBulananPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Neraca Bulanan Afkar Mobil Periode '.$request->date_from.' sd '.$request->date_end.'.pdf');

    }

    public function downloadLaporanTahunan(Request $request)
    {
        $lajurs = $this->financeCoa->whereYear('created_at',$request->year)
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        $data['hasilNeracaLajurs'] = [];
        $totalAktivaLancar = [];
        $totalKewajibanLancar = [];

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

        $totalModalDasarKewajibanLancar = [];
        $totalModalTambahanKewajibanLancar = [];
        $totalLabaBulanBerjalanSetelahPjkKewajibanLancar = [];
        $totalLabaDitahanKewajibanLancar = [];

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

            $aktivaLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_debit - $neraca_after_credit;
            // $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_credit - $neraca_after_debit : $neraca_after_credit;
            $kewajibanLancar = $neraca_after_debit > 0 ? $neraca_after_debit : $neraca_after_credit;
            $modalDasarKewajibanLancar = $neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit;

            if ($rugi_laba_credit > $neraca_after_debit) {
                $totalMinusNeracaAfterDebit = $rugi_laba_credit - $neraca_after_debit;
            }else{
                $totalMinusNeracaAfterDebit = 0;
            }

            if ($neraca_after_debit > $neraca_after_credit) {
                $totalMinusNeracaAfterCredit = $neraca_after_debit - $neraca_after_credit;
            }else{
                $totalMinusNeracaAfterCredit = 0;
            }

            // dd($neraca_after_credit,$neraca_after_debit);

            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            $modalDasarKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            $labaDitahan = ($neraca_after_credit > 0 ? $neraca_after_credit : ($neraca_after_debit - $neraca_after_credit)-($neraca_after_debit - $neraca_after_credit));
            
            // $modalTambahanKewajibanLancar = ($neraca_after_credit > 0 ? $neraca_after_credit : - $neraca_after_debit) - $totalMinusNeracaAfterDebit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit) + $totalMinusNeracaAfterCredit;
            
            // $labaBulanBerjalanSetelahPjk = $totalMinusNeracaAfterCredit;
            // $labaBulanBerjalanSetelahPjk = ($neraca_after_credit > 0 ? $neraca_after_credit : $neraca_after_credit - $neraca_after_debit);
            
            array_push($totalAktivaLancar, $aktivaLancar);
            array_push($totalKewajibanLancar, $kewajibanLancar);

            array_push($totalModalDasarKewajibanLancar, $modalDasarKewajibanLancar);
            array_push($totalModalTambahanKewajibanLancar, $modalTambahanKewajibanLancar);
            array_push($totalLabaBulanBerjalanSetelahPjkKewajibanLancar, $labaBulanBerjalanSetelahPjk);

            // $data['hasilNeracaLajurs'][] = [
            //     'code' => $lajur->code,
            //     'item' => $lajur->item,
            //     'aktiva_lancar' => $aktivaLancar,
            //     'kewajiban_lancar' => $kewajibanLancar,
            //     'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
            //     'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
            //     'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
            // ];
            $data['hasilNeracaLajurs'][] = [
                'code' => $lajur->code,
                'item' => $lajur->item,
                'aktiva_lancar' => $aktivaLancar,
                'kewajiban_lancar' => $kewajibanLancar,
                'modal_dasar_kewajiban_lancar' => $modalDasarKewajibanLancar,
                'modal_tambahan_kewajiban_lancar' => $modalTambahanKewajibanLancar,
                'laba_bulan_berjalan_setelah_pjk_kewajiban_lancar' => $labaBulanBerjalanSetelahPjk,
                'laba_ditahan' => $labaDitahan,
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

        // $data['modal_dasar_kewajiban_lancar'] = array_sum($totalModalDasarKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['modal_tambahan_kewajiban_lancar'] = array_sum($totalModalTambahanKewajibanLancar)-$data['totalMinusNeracaAfterDebit'];
        $data['laba_bulan_setelah_pjk_kewajiban_lancar'] = array_sum($totalLabaBulanBerjalanSetelahPjkKewajibanLancar)+$data['totalMinusNeracaAfterCredit'];

        $pdf = PDF::loadView('backend.finance.neraca.laporanTahunanPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Neraca Tahunan Afkar Mobil Periode '.$request->date_from.' sd '.$request->date_end.'.pdf');

    }
}
