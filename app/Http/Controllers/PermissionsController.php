<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DataTables;
use Validator;

class PermissionsController extends Controller
{
    function __construct(
        Permission $permissions
    )
    {
        $this->middleware('permission:Permission List', ['only' => ['index']]);
        $this->middleware('permission:Permission Create', ['only' => ['simpan']]);
        $this->middleware('permission:Permission Edit', ['only' => ['edit']]);
        $this->middleware('permission:Permission Update', ['only' => ['update']]);
        $this->middleware('permission:Permission Delete', ['only' => ['destroy']]);

        $this->permissions = $permissions;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->permissions->all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="btn-group">';
                        $btn = $btn.'<button type="button" onclick="edit('.$row->id.')" class="btn btn-primary btn-icon">
                                    <i class="uil-edit"></i> Edit
                                </button>';
                        $btn = $btn.'<button type="button" class="btn btn-danger btn-icon">
                                    <i class="uil-trash"></i> Delete
                                </button>';
                        $btn = $btn.'</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

        }
        return view('backend.permissions.index');
    }

    public function simpan(Request $request)
    {
        $rules = [
            'name'  => 'required',
            'guard_name'  => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama wajib diisi.',
            'guard_name.required'  => 'Guard Name wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $input = $request->all();
            $permissions = $this->permissions->create($input);

            if($permissions){
                $message_title="Berhasil !";
                $message_content="Permission Berhasil Ditambah";
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

    public function edit($id)
    {
        $permission = $this->permissions->find($id);
        if (empty($permission)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'Permission Tidak Ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $permission
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'edit_name'  => 'required',
            'edit_guard_name'  => 'required',
        ];

        $messages = [
            'edit_name.required'  => 'Nama wajib diisi.',
            'edit_guard_name.required'  => 'Guard Name wajib diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $permissions = $this->permissions->find($request->edit_id);
            $input['name'] = $request->edit_name;
            $input['guard_name'] = $request->edit_guard_name;
            $permissions->update($input);

            if($permissions){
                $message_title="Berhasil !";
                $message_content="Permission Berhasil Diupdate";
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
