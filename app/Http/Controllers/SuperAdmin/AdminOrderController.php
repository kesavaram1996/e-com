<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\OrderStatus;
use App\Models\SalesPerson;
use DB;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user_role = auth()->user()->getrole->name;

        $data = Order::with('getuser','getaddress','getorderbyuser')->paginate(5);
        $admins = User::where('id','!=',1)->where('admin_id',null)->get();
        return view('superAdmin.orders.index',compact('data','admins'));
    }


    function fetch_data(Request $request)
    {
        if($request->ajax())
        {

            $query = Order::with('getuser','getaddress','getorderbyuser');
            if ($request->get('status_filter') != null){
                $query->where('active_status', $request->get('status_filter'));
            }
               
            if ($request->get('admin_filter') != null){
                $query->where('admin_id', $request->get('admin_filter'));
            }

            if ($request->get('query') != null){
                $query->where('id', 'like', '%'.$request->get('query').'%');
            }

            if ($request->get('start_date') != null && $request->get('end_date') != null){
                $query->whereBetween('created_at', [$request->get('start_date'), $request->get('end_date')]);
            }
               
            $data = $query->paginate(5);
            
         return view('superAdmin.orders.pagination_data', compact('data'))->render();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::where('id',$id)->get();
        $status_count = OrderStatus::where('order_id',$id)->count();
        return view('superAdmin.orders.show',compact('data','status_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
