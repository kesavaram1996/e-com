<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Buyer;
use App\Models\SalesPerson;
use App\Models\Order;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Get User Role
        $user_role = auth()->user()->getRoleNames();
        $user_id = auth()->user()->id;
        // Check User role
        auth()->user()->hasRole('Super Admin');

        // Super Admin Data
        $user_count = User::where('id','!=','1')->count();
        $roles = Role::where('name','!=','Super Admin')->count();
        $users = User::with('getrole')->where('id','!=','1')->latest()->paginate(5);
        if(auth()->user()->getrole->name=='Super Admin'){
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
        }

        // Admin Data
        $products = Product::where('admin_id',$user_id)->count();
        $buyers = Buyer::where('admin_id',$user_id)->count();
        $sales_persons = SalesPerson::where('admin_id',$user_id)->count();
        $admin_users_count = $buyers + $sales_persons;
        $orders = Order::where('admin_id',$user_id)->count();

        if(auth()->user()->getrole->name=='Admin'){
            if ($request->ajax()) {
                $data = Order::with('getuser','getaddress','getorderbyuser')->where('admin_id',$user_id);

                if($request->get('search') != null || $request->get('status_filter') != null){
                    $query =Order::with('getuser','getaddress','getorderbyuser')->where('admin_id',$user_id);
                    // search Filter
                    if ($request->get('search') != null){
                        $query->where('id', 'like', '%'.$request->get('search').'%');
                    }
                    
                    // status_filter
                    if ($request->get('status_filter') != null){
                        $query->where('active_status',$request->get('status_filter'));
                    }
          
                    $data = $query->get();
                }

                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btns = '';
        
                            $btns .= '<a href="' . route('orders.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                            // $btns .= '<a href="' . route('orders.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                            
                            return $btns;
                        })
                        ->editColumn('active_status', function ($data) {
                            if($data->active_status == 'received'){
                                $label = '<label class="label label-primary">received</label>';
                                return $label;
                            }elseif($data->active_status == 'processed'){
                                $label = '<label class="label label-secondary">Processed</label>';
                                return $label;
                            }elseif($data->active_status == 'shipped'){
                                $label = '<label class="label label-info">Shipped</label>';
                                return $label;
                            }elseif($data->active_status == 'delivered'){
                                $label = '<label class="label label-success">Delivered</label>';
                                return $label;
                            }elseif($data->active_status == 'cancelled'){
                                $label = '<label class="label label-danger">Cancelled</label>';
                                return $label;
                            }elseif($data->active_status == 'returned'){
                                $label = '<label class="label label-warning">Returned</label>';
                                return $label;
                            }
                        })
                        ->editColumn('order_by', function ($data) {
                            if($data->user_id == $data->order_by){
                                return "Buyer";
                            }else{
                                return "Sales: ".$data->getorderbyuser->name;
                            }
                        })
                        
                        ->rawColumns(['action','active_status'])
                        ->make(true);
            }
        }

        // dd(auth()->user()->getrole->name);
        if(auth()->user()->getrole->name=='Admin'){
            return view('admin.dashboard.index',compact('admin_users_count','user_count','roles','users','products','users','orders'));
        }else{
            return view('superAdmin.dashboard.index',compact('admin_users_count','user_count','roles','users','products','users','orders'));
        }
    }
}
