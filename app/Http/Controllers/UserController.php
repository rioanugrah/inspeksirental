<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(

    ){
        $this->middleware('permission:User List', ['only' => ['index']]);
        $this->middleware('permission:User Create', ['only' => ['create','store']]);
        $this->middleware('permission:User Detail', ['only' => ['show']]);
        $this->middleware('permission:User Edit', ['only' => ['edit','update']]);
        $this->middleware('permission:User Delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // dd(auth()->user()->can('User List'));
        if ($request->ajax()) {
            if (auth()->user()->getRoleNames()[0] == 'Superadmin') {
                $data = User::all();
            }else{
                $data = User::whereHas('roles', function($query){
                            // $query->whereHas('name',['Administrator']);
                            $query->where('name','!=','Superadmin');
                })->get();
            }
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('akses', function($row){
                        if (!empty($row->getRoleNames())) {
                            foreach ($row->getRoleNames() as $v) {
                                switch ($v) {
                                    case 'Superadmin':
                                        return '<span class="badge bg-danger">'.$v.'</span>';
                                        break;
                                    case 'Administrator':
                                        return '<span class="badge bg-primary">'.$v.'</span>';
                                        break;
                                    case 'Admin':
                                        return '<span class="badge bg-info">'.$v.'</span>';
                                        break;
                                    case 'User':
                                        return '<span class="badge bg-info">'.$v.'</span>';
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
                        }
                        // if (!empty($row->roles)) {
                        //     foreach ($row->roles as $v) {
                        //         switch ($v->name) {
                        //             case 'Administrator':
                        //                 return '<span class="badge bg-info">'.$v->name.'</span>';
                        //                 break;
                        //             case 'Admin':
                        //                 return '<span class="badge bg-info">'.$v->name.'</span>';
                        //                 break;
                        //             case 'User':
                        //                 return '<span class="badge bg-info">'.$v->name.'</span>';
                        //                 break;
                        //             default:
                        //                 # code...
                        //                 break;
                        //         }
                        //     }
                        // }
                        
                    })
                    ->addColumn('last_seen', function($row){
                        if (Cache::has('is_online' . $row->id)) {
                            return '<span class="text-success">Online</span>';
                        }else{
                            return '<span class="text-secondary">Offline</span>';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="btn-group">';
                        if (auth()->user()->can('User Detail') == true) {
                            $btn = $btn.'<a href='.route('users.show', $row->id).' class="btn btn-success">Detail</a>';
                        }
                        if (auth()->user()->can('User Edit') == true) {
                            $btn = $btn.'<a href='.route('users.edit', $row->id).' class="btn btn-warning">Edit</a>';
                        }
                        if (auth()->user()->can('User Delete') == true) {
                            $btn = $btn.'<a href="javascript:void(0)" onclick="deleteUser('.$row->id.')" class="btn btn-danger">Delete</a>';
                        }
                        $btn = $btn.'</div>';
                        return $btn;
                    })
                    ->rawColumns(['action','akses','last_seen'])
                    ->make(true);
        }
        return view('backend.users.index');
        // $data = User::orderBy('id','DESC')->paginate(5);
        // return view('backend.users.index',compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('backend.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['generate'] = Str::uuid()->toString();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('backend.users.detail',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        // dd($user->roles);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('backend.users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        // $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($request->password);
        }

        // dd($request->all());
        // else{
        //     $input = array_except($input,array('password'));
        // }

        $input['roles'] = $request->roles;

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd('OK');
        $user = User::find($id);
        if (empty($user)) {
            return response()->json([
                'success' => false,
                'message_title' => 'Gagal',
                'message_content' => 'User Tidak Ditemukan'
            ]);
        }
        $user->delete();
        return response()->json([
            'success' => true,
            'message_title' => 'Berhasil',
            'message_content' => 'User Berhasil Dihapus'
        ]);
        // User::find($id)->delete();
        // return redirect()->route('users.index')
        //                 ->with('success','User deleted successfully');
    }

    public function profile()
    {
        $data['profile'] = User::where('generate',auth()->user()->generate)->first();
        $data['devices'] = visitor();
        // dd($data);
        return view('backend.users.profile.index',$data);
    }
}
