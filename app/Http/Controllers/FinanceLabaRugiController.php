<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceCoa;
use App\Models\FinanceLajur;

use \Carbon\Carbon;

use DataTables;
use PDF;

class FinanceLabaRugiController extends Controller
{
    function __construct(
        FinanceCoa $financeCoa,
        FinanceLajur $financeLajur
    ){
        $this->middleware('permission:Finance LabaRugi', ['only' => ['index','report_period']]);
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

        $data['pendapatan_jasa_inspeksi'] = $totalRugiLabaCredit[20];
        $data['pendapatan_jasa_giro'] = $totalRugiLabaCredit[21];
        $data['pendapatan_jasa_lain'] = $totalRugiLabaCredit[22];
        $data['total_pendapatan'] = $totalRugiLabaCredit[20]+$totalRugiLabaCredit[21]+$totalRugiLabaCredit[22];

        $data['beban_akomodasi'] = $totalRugiLabaDebit[23];
        $data['beban_internet'] = $totalRugiLabaDebit[24];
        $data['beban_website'] = $totalRugiLabaDebit[25];
        $data['beban_telepon'] = $totalRugiLabaDebit[26];
        $data['beban_percetakan'] = $totalRugiLabaDebit[27];
        $data['beban_marketing'] = $totalRugiLabaDebit[28];
        $data['beban_transportasi'] = $totalRugiLabaDebit[29];
        $data['beban_operational_lain'] = $totalRugiLabaDebit[30];
        $data['biaya_gaji'] = $totalRugiLabaDebit[31];
        $data['biaya_admin'] = $totalRugiLabaDebit[32];
        $data['biaya_sewa'] = $totalRugiLabaDebit[33];
        $data['biaya_lain_lain'] = $totalRugiLabaDebit[34];

        $data['total_beban_langsung'] = $data['beban_akomodasi'] + $data['beban_internet'] + $data['beban_website'] +
                                        $data['beban_telepon'] + $data['beban_percetakan'] + $data['beban_marketing'] + 
                                        $data['beban_transportasi'] + $data['beban_operational_lain'] + $data['biaya_gaji'] +
                                        $data['biaya_admin'] + $data['biaya_sewa'] + $data['biaya_lain_lain'];

        $data['hasil_laba_rugi'] = $data['total_pendapatan'] - $data['total_beban_langsung'];
        // dd($data['pendapatan_jasa_inspeksi']);
                                            
        return view('backend.finance.laba_rugi.index',$data);
    }

    public function report_period(Request $request)
    {
        $lajurs = $this->financeCoa->whereYear('created_at',$request->periode)
                                    ->withSum('debitJournals as journal_debit','debit')
                                    ->withSum('creditJournals as journal_credit','credit')
                                    ->orderBy('code','asc')
                                    ->get();

        if ($lajurs->isEmpty()) {
            return redirect()->back();
        }

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

        $data['pendapatan_jasa_inspeksi'] = $totalRugiLabaCredit[20];
        $data['pendapatan_jasa_giro'] = $totalRugiLabaCredit[21];
        $data['pendapatan_jasa_lain'] = $totalRugiLabaCredit[22];
        $data['total_pendapatan'] = $totalRugiLabaCredit[20]+$totalRugiLabaCredit[21]+$totalRugiLabaCredit[22];

        $data['beban_akomodasi'] = $totalRugiLabaDebit[23];
        $data['beban_internet'] = $totalRugiLabaDebit[24];
        $data['beban_website'] = $totalRugiLabaDebit[25];
        $data['beban_telepon'] = $totalRugiLabaDebit[26];
        $data['beban_percetakan'] = $totalRugiLabaDebit[27];
        $data['beban_marketing'] = $totalRugiLabaDebit[28];
        $data['beban_transportasi'] = $totalRugiLabaDebit[29];
        $data['beban_operational_lain'] = $totalRugiLabaDebit[30];
        $data['biaya_gaji'] = $totalRugiLabaDebit[31];
        $data['biaya_admin'] = $totalRugiLabaDebit[32];
        $data['biaya_sewa'] = $totalRugiLabaDebit[33];
        $data['biaya_lain_lain'] = $totalRugiLabaDebit[34];

        $data['total_beban_langsung'] = $data['beban_akomodasi'] + $data['beban_internet'] + $data['beban_website'] +
                                        $data['beban_telepon'] + $data['beban_percetakan'] + $data['beban_marketing'] + 
                                        $data['beban_transportasi'] + $data['beban_operational_lain'] + $data['biaya_gaji'] +
                                        $data['biaya_admin'] + $data['biaya_sewa'] + $data['biaya_lain_lain'];

        $data['hasil_laba_rugi'] = $data['total_pendapatan'] - $data['total_beban_langsung'];

        $pdf = PDF::loadView('backend.finance.laba_rugi.reportPeriod',$data);
        $pdf->setOption([
            'enable_remote' => true
        ]);

        return $pdf->stream('Laporan Posisi Keuangan Laba Rugi Afkar Mobil Periode '.date('Y').'.pdf');
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

        $data['pendapatan_jasa_inspeksi'] = $totalRugiLabaCredit[20];
        $data['pendapatan_jasa_giro'] = $totalRugiLabaCredit[21];
        $data['pendapatan_jasa_lain'] = $totalRugiLabaCredit[22];
        $data['total_pendapatan'] = $totalRugiLabaCredit[20]+$totalRugiLabaCredit[21]+$totalRugiLabaCredit[22];

        $data['beban_akomodasi'] = $totalRugiLabaDebit[23];
        $data['beban_internet'] = $totalRugiLabaDebit[24];
        $data['beban_website'] = $totalRugiLabaDebit[25];
        $data['beban_telepon'] = $totalRugiLabaDebit[26];
        $data['beban_percetakan'] = $totalRugiLabaDebit[27];
        $data['beban_marketing'] = $totalRugiLabaDebit[28];
        $data['beban_transportasi'] = $totalRugiLabaDebit[29];
        $data['beban_operational_lain'] = $totalRugiLabaDebit[30];
        $data['biaya_gaji'] = $totalRugiLabaDebit[31];
        $data['biaya_admin'] = $totalRugiLabaDebit[32];
        $data['biaya_sewa'] = $totalRugiLabaDebit[33];
        $data['biaya_lain_lain'] = $totalRugiLabaDebit[34];

        $data['total_beban_langsung'] = $data['beban_akomodasi'] + $data['beban_internet'] + $data['beban_website'] +
                                        $data['beban_telepon'] + $data['beban_percetakan'] + $data['beban_marketing'] + 
                                        $data['beban_transportasi'] + $data['beban_operational_lain'] + $data['biaya_gaji'] +
                                        $data['biaya_admin'] + $data['biaya_sewa'] + $data['biaya_lain_lain'];

        $data['hasil_laba_rugi'] = $data['total_pendapatan'] - $data['total_beban_langsung'];

        $pdf = PDF::loadView('backend.finance.laba_rugi.laporanBulananPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Laba Rugi Bulanan Afkar Mobil Periode '.$request->date_from.' sd '.$request->date_end.'.pdf');

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

        $data['pendapatan_jasa_inspeksi'] = $totalRugiLabaCredit[20];
        $data['pendapatan_jasa_giro'] = $totalRugiLabaCredit[21];
        $data['pendapatan_jasa_lain'] = $totalRugiLabaCredit[22];
        $data['total_pendapatan'] = $totalRugiLabaCredit[20]+$totalRugiLabaCredit[21]+$totalRugiLabaCredit[22];

        $data['beban_akomodasi'] = $totalRugiLabaDebit[23];
        $data['beban_internet'] = $totalRugiLabaDebit[24];
        $data['beban_website'] = $totalRugiLabaDebit[25];
        $data['beban_telepon'] = $totalRugiLabaDebit[26];
        $data['beban_percetakan'] = $totalRugiLabaDebit[27];
        $data['beban_marketing'] = $totalRugiLabaDebit[28];
        $data['beban_transportasi'] = $totalRugiLabaDebit[29];
        $data['beban_operational_lain'] = $totalRugiLabaDebit[30];
        $data['biaya_gaji'] = $totalRugiLabaDebit[31];
        $data['biaya_admin'] = $totalRugiLabaDebit[32];
        $data['biaya_sewa'] = $totalRugiLabaDebit[33];
        $data['biaya_lain_lain'] = $totalRugiLabaDebit[34];

        $data['total_beban_langsung'] = $data['beban_akomodasi'] + $data['beban_internet'] + $data['beban_website'] +
                                        $data['beban_telepon'] + $data['beban_percetakan'] + $data['beban_marketing'] + 
                                        $data['beban_transportasi'] + $data['beban_operational_lain'] + $data['biaya_gaji'] +
                                        $data['biaya_admin'] + $data['biaya_sewa'] + $data['biaya_lain_lain'];

        $data['hasil_laba_rugi'] = $data['total_pendapatan'] - $data['total_beban_langsung'];

        $pdf = PDF::loadView('backend.finance.laba_rugi.laporanTahunanPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Laba Rugi Tahunan Afkar Mobil Periode '.$request->year.'.pdf');

    }
}
