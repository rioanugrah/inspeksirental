<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceCoa;
use App\Models\FinanceJournal;

use \Carbon\Carbon;

use DataTables;
use Validator;
use PDF;

class FinanceJournalController extends Controller
{
    function __construct(
        FinanceCoa $financeCoa,
        FinanceJournal $financeJournal
    ){
        $this->middleware('permission:Finance Journal', ['only' => ['index','Simpan']]);
        $this->financeCoa = $financeCoa;
        $this->financeJournal = $financeJournal;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->financeJournal->whereYear('created_at',Carbon::now()->format('Y'))->get();
            return DataTables::of($data)
                                ->addIndexColumn()
                                ->addColumn('debit', function($row){
                                    return 'Rp. '.number_format($row->debit,2,',','.');
                                })
                                ->addColumn('credit', function($row){
                                    return 'Rp. '.number_format($row->credit,2,',','.');
                                })
                                ->addColumn('created_at', function($row){
                                    return $row->created_at->format('Y-m-d H:i:s');
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<div class="btn-group">';
                                    $btn = $btn.'<a onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-xs"><i class="bi-pencil"></i></a>';
                                    $btn = $btn.'<a class="btn btn-danger btn-xs btn-delete" data-id='.$row->id.'><i class="bi-trash"></i></a>';
                                    // $btn = $btn.'<a onclick="inputStatusPembayaran(`'.$row->id.'`)" class="btn btn-info btn-xs"><i class="bi-plus"></i> Status Pembayaran</a>';
                                    $btn = $btn.'</div>';
                                    return $btn;
                                })
                                ->rawColumns([
                                    'action',
                                    ])
                                ->make(true);
        }

        $data['coas'] = $this->financeCoa->whereYear('created_at',Carbon::now()->format('Y'))->orderBy('code','asc')->get();

        return view('backend.finance.journal.index',$data);
    }

    public function simpan(Request $request)
    {
        $rules = [
            'uraian' => 'required',
            'code_debit' => 'required',
            'code_credit' => 'required',
            'nominal' => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'uraian.required'  => 'Jurnal Uraian wajib diisi.',
            'code_debit.required'  => 'Pemilihan Kategori Debit wajib diisi.',
            'code_credit.required'  => 'Pemilihan Kategori Credit wajib diisi.',
            'nominal.required'  => 'Jurnal Nominal wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            // $input = $request->all();

            $input['tanggal'] = Carbon::now();
            $input['uraian'] = $request->uraian;
            $input['code_debit'] = explode('|',$request->code_debit)[0];
            $input['item_debit'] = explode('|',$request->code_debit)[1];
            $input['code_credit'] = explode('|',$request->code_credit)[0];
            $input['item_credit'] = explode('|',$request->code_credit)[1];

            $input['debit'] = $request->nominal;
            $input['credit'] = $request->nominal;

            $saveJournal = $this->financeJournal->create($input);

            if ($saveJournal) {
                $message_title="Berhasil !";
                $message_content= "Jurnal Umum Berhasil Disimpan";
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

    public function detail($id)
    {
        $journal = $this->financeJournal->find($id);

        if (empty($journal)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Journal Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $journal
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'uraian' => 'required',
            'code_debit' => 'required',
            'code_credit' => 'required',
            'nominal' => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'uraian.required'  => 'Jurnal Uraian wajib diisi.',
            'code_debit.required'  => 'Pemilihan Kategori Debit wajib diisi.',
            'code_credit.required'  => 'Pemilihan Kategori Credit wajib diisi.',
            'nominal.required'  => 'Jurnal Nominal wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            // $input = $request->all();

            $input['tanggal'] = Carbon::now();
            $input['uraian'] = $request->uraian;
            $input['code_debit'] = explode('|',$request->code_debit)[0];
            $input['item_debit'] = explode('|',$request->code_debit)[1];
            $input['code_credit'] = explode('|',$request->code_credit)[0];
            $input['item_credit'] = explode('|',$request->code_credit)[1];

            $input['debit'] = $request->nominal;
            $input['credit'] = $request->nominal;

            $updateJournal = $this->financeJournal->find($request->id)->update($input);

            if ($updateJournal) {
                $message_title="Berhasil !";
                $message_content= "Jurnal Umum Berhasil Diupdate";
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
        $journal = $this->financeJournal->find($id);

        if (empty($journal)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Journal Tidak Ditemukan'
            ]);
        }

        $journal->delete();

        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'Journal Berhasil Dihapus'
        ]);
    }

    public function downloadLaporanBulanan(Request $request)
    {
        $data['journals'] = $this->financeJournal->whereBetween('created_at',[$request->date_from,$request->date_end])
                                                ->orderBy('created_at','desc')
                                                ->get();

        $pdf = PDF::loadView('backend.finance.journal.laporanBulananPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Journal Bulanan Afkar Mobil Periode '.$request->date_from.' sd '.$request->date_end.'.pdf');

    }

    public function downloadLaporanTahunan(Request $request)
    {
        $data['journals'] = $this->financeJournal->whereYear('created_at',$request->year)
                                                ->orderBy('created_at','desc')
                                                ->get();

        $pdf = PDF::loadView('backend.finance.journal.laporanTahunanPdf',$data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Journal Tahunan Afkar Mobil Periode '.$request->year.'.pdf');

    }
}
