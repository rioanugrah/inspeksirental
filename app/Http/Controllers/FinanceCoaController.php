<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceCoa;

use \Carbon\Carbon;

use Validator;
use DataTables;

class FinanceCoaController extends Controller
{
    function __construct(
        FinanceCoa $financeCoa
    ){
        $this->middleware('permission:Finance COA', ['only' => ['index']]);
        $this->financeCoa = $financeCoa;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->financeCoa->all();
            return DataTables::of($data)
                                ->addIndexColumn()
                                ->addColumn('code', function($row){
                                    return '<a onclick="inputCode('.$row->id.')" class="text-primary">'.$row->code.'</a>';
                                    // return 'Rp. '.number_format($row->debit,2,',','.');
                                })
                                ->addColumn('tahun', function($row){
                                    return $row->created_at->format('Y');
                                    // return 'Rp. '.number_format($row->debit,2,',','.');
                                })
                                ->addColumn('debit', function($row){
                                    return 'Rp. '.number_format($row->debit,2,',','.');
                                })
                                ->addColumn('credit', function($row){
                                    return 'Rp. '.number_format($row->credit,2,',','.');
                                })
                                ->addColumn('action', function($row){
                                    $btn = '<div class="button-list">';
                                    // $btn = $btn.'<a onclick="inputHarga(`'.$row->id.'`)" class="btn btn-warning btn-xs text-dark"><i class="bi-plus"></i> Input Harga Inspeksi</a>';
                                    // $btn = $btn.'<a onclick="inputStatusPembayaran(`'.$row->id.'`)" class="btn btn-info btn-xs"><i class="bi-plus"></i> Status Pembayaran</a>';
                                    $btn = $btn.'</div>';
                                    return $btn;
                                })
                                ->rawColumns([
                                    'code',
                                    'action',
                                    ])
                                ->make(true);
        }

        return view('backend.finance.coa.index');
    }

    public function detail($id)
    {
        $data = $this->financeCoa->find($id);

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'COA Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function simpan(Request $request)
    {
        $rules = [
            'debit' => 'required',
            'credit' => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'debit.required'  => 'S.A Debit wajib diisi.',
            'credit.required'  => 'S.A Credit wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages); // Ini buat cek validasi

        if ($validator->passes()) {
            $updateCoa = $this->financeCoa->where('id',$request->modalId)->update([
                'debit' => $request->debit,
                'credit' => $request->credit,
            ]);

            if ($updateCoa) {
                $message_title="Berhasil !";
                $message_content= "Chart of Account Berhasil Disimpan";
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
}
