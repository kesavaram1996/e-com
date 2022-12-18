<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Session;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->auth_user_role = auth()->user()->getrole->name;
            if($this->auth_user_role != 'Super Admin'){
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // $users = User::where('id','!=','1')->orderBy('id','DESC')->paginate(5);
        
        if ($request->ajax()) {
            $data = User::with('getrole')->where('id','!=','1');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
    
                        $btns .= '<a href="' . route('users.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('users.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        return $btns;
                    })
                    ->editColumn('role', function ($data) {
                        if($data->getrole->name=='Admin'){
                            $label = '<label class="badge badge-success">Admin</label>';
                            return $label;
                        }elseif($data->getrole->name=='Buyer'){
                            $label = '<label class="badge badge-info">Buyer</label>';
                            return $label;
                        }elseif($data->getrole->name=='Sales Person'){
                            $label = '<label class="badge badge-warning">Sales Person</label>';
                            return $label;
                        }
                    })
                    
                    ->rawColumns(['action','role'])
                    ->make(true);
        }
        return view('users.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name','=','Admin')->pluck('name','name')->all();
        return view('users.create',compact('roles'));
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
            'phone' => 'required|unique:users,phone',
            'password' => 'required|same:cpassword',
            'roles' => 'required'
        ],
        [
            'name.required' => 'name field is required',
            'email.required' => 'email field is required',
            'phone.required' => 'phone field is required',
            'password.required' => 'password field is required',
            'roles.required' => 'role field is required',
        ]

        );
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        if($request->input('roles') == 'Admin'){
            Session::put('admin_id', $user->id);
            \Artisan::call('db:seed', array('--class' => "AdminSettingSeeder",'--force' => true));
            \Artisan::call('db:seed', array('--class' => "PriceSlabSeeder",'--force' => true));
            \Artisan::call('db:seed', array('--class' => "StateSeeder",'--force' => true));
            \Artisan::call('db:seed', array('--class' => "CitySeeder",'--force' => true));
            // \Artisan::call('db:seed', array('--class' => "AreaSeeder",'--force' => true));
        }

        flash()->addSuccess('User created successfully!');
        return redirect()->route('users.index');
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
        return view('users.show',compact('user'));
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
        $roles = Role::where('name','!=','Super Admin')->pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
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
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$id,
            'phone'     => 'required|unique:users,phone,'.$id,
            // 'password'  => 'min:6',
            'roles'     => 'required'
        ],
        [
            'name.required'     => 'name field is required',
            'email.required'    => 'email field is required',
            'phone.required'    => 'phone field is required',
            // 'password.min'      => 'password field is required minimum 6 characters',
            'roles.required'    => 'role field is required',
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        flash()->addSuccess('User updated successfully!');
        return redirect()->route('users.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        flash()->addSuccess('User deleted successfully!');
        return redirect()->route('users.index');
    }
}