<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Buyer;
use App\Models\User;
use App\Models\SalesPerson;
use Yajra\DataTables\DataTables;
use DB;
use Carbon\Carbon;

class ReportController extends Controller
{

// sales_report Start
    public function sales_report(Request $request)
    {
        $admin_id = auth()->user()->id;
        // $data = Order::where('admin_id',$admin_id)->where('active_status','delivered')->get();
        if ($request->ajax()) {
            $data =  $data = Order::with('getaddress')->where('admin_id',$admin_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){
                        return date('d-m-Y', strtotime($data->created_at));
                    })
                    ->editColumn('address', function($data){
                        $address = $data->getaddress->address.'<br>'.$data->getaddress->getarea->name.','.$data->getaddress->getstate->name.'<br>'.$data->getaddress->getcity->name.'-'.$data->getaddress->pincode.'<br>'.$data->getaddress->phone.'<br>'.$data->getaddress->email;
                        return $address;
                    })
                    ->rawColumns(['address'])
                    ->make(true);
        }

        return view('admin.reports.sales_report');
    }
// sales_report End

// buyers_report Start
    public function buyers_report(Request $request)
    {
        $admin_id = auth()->user()->id;
        $buyers = Buyer::where('admin_id',$admin_id)->get();
        // $data = Order::where('admin_id',$admin_id)->where('active_status','delivered')->get();
        if ($request->ajax()) {
            $data =  $data = Order::with('getaddress')->where('admin_id',$admin_id)->whereColumn('user_id','order_by');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('name', function($data){
                        return $data->getaddress->getbuyer->name;
                    })
                    ->editColumn('active_status', function ($data) {
                        if($data->active_status == 'received'){
                            $label = '<label class="label label-primary">Received</label>';
                            return $label;
                        }elseif($data->active_status == 'processed'){
                            $label = '<label class="label label-primary">Processed</label>';
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
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('status_filter'))) {
                            $instance->where('active_status', $request->get('status_filter'));
                        }
                        if (!empty($request->get('buyer_filter'))) {
                            $instance->where('user_id', $request->get('buyer_filter'));
                        }
                        if (!empty($request->get('end_date'))) {
                            $start_date = $request->get('start_date');
                            $end_date = $request->get('end_date');
                            $instance->whereBetween('created_at', [$start_date, $end_date]);
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('id', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['active_status'])
                    ->make(true);
        }

        return view('admin.reports.buyers_report',compact('buyers'));
    }
// buyers_report End

// sales_persons_report Start
    public function sales_persons_report(Request $request)
    {
        $admin_id = auth()->user()->id;
        $sales = SalesPerson::where('admin_id',$admin_id)->get();
        // $data = Order::where('admin_id',$admin_id)->where('active_status','delivered')->get();
        if ($request->ajax()) {
            $data =  $data = Order::with('getaddress')->where('admin_id',$admin_id)->whereColumn('user_id','!=','order_by');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('name', function($data){
                        return $data->getaddress->getbuyer->name;
                    })
                    ->editColumn('active_status', function ($data) {
                        if($data->active_status == 'received'){
                            $label = '<label class="label label-primary">Received</label>';
                            return $label;
                        }elseif($data->active_status == 'processed'){
                            $label = '<label class="label label-primary">Processed</label>';
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
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('status_filter'))) {
                            $instance->where('active_status', $request->get('status_filter'));
                        }
                        if (!empty($request->get('sales_filter'))) {
                            $instance->where('order_by', $request->get('sales_filter'));
                        }
                        if (!empty($request->get('end_date'))) {
                            $start_date = $request->get('start_date');
                            $end_date = $request->get('end_date');
                            $instance->whereBetween('created_at', [$start_date, $end_date]);
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('id', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['active_status'])
                    ->make(true);
        }

        return view('admin.reports.sales_persons_report',compact('sales'));
    }
// sales_persons_report End

// top_buyers start
    public function top_buyers(Request $request)
    {
        $admin_id = auth()->user()->id;
        $buyers = Buyer::where('admin_id',$admin_id )->get();
        if ($request->ajax()) {
            $data = Order::with('getaddress')->select('user_id', DB::raw('count(*) as total'), DB::raw('sum(final_total) as ftotal'))->where('admin_id',$admin_id)->groupBy('user_id')->orderBy('user_id', 'DESC')->get();
            if($request->get('end_date') != null || $request->get('search') != null || $request->get('buyer_filter') != null){
                $query = Order::with('getaddress')->select('user_id', DB::raw('count(*) as total'), DB::raw('sum(final_total) as ftotal'))->where('admin_id',$admin_id)->groupBy('user_id')->orderBy('user_id', 'DESC');
                // Date Filter
                if ($request->get('end_date') != null){
                    $start_date = $request->get('start_date');
                    $end_date = $request->get('end_date');
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }
                // search Filter
                if ($request->get('search') != null){
                    $query->where('id', 'like', '%'.$request->get('search').'%');
                }
                
                // buyer Filter
                if ($request->get('buyer_filter') != null){
                    $query->where('user_id',$request->get('buyer_filter'));
                }
      
                $data = $query->get();
            }
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('name', function($data){
                        return $data->getaddress->getbuyer->name;
                    })
                    ->editColumn('orders_count', function($data){
                        return $data->total;
                    })
                    ->editColumn('total_amount', function($data){
                        return $data->ftotal;
                    })
                    ->rawColumns(['active_status'])
                    ->make(true);
        }

        return view('admin.reports.top_buyers',compact('buyers'));
    }
// top_buyers End

// product_wise_report Start
    public function product_wise_report(Request $request)
    {
        $admin_id = auth()->user()->id;
        if ($request->ajax()) {
           $data = OrderItem::with('getorderproductvariant')->select('product_variant_id', DB::raw('sum(quantity) as total'))->where('admin_id',$admin_id)->where('active_status','!=','cancelled')->where('active_status','!=','returned')->groupBy('product_variant_id')->get();
           return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('product_name', function($data){
                        return $data->getorderproductvariant->getproduct->name;
                    })
                    ->editColumn('unit', function($data){
                        return $data->getorderproductvariant->measurement.$data->getorderproductvariant->getmeasurementunit->measurement_unit;
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('end_date'))) {
                            $admin_id = auth()->user()->id;
                            $start_date = $request->get('start_date');
                            $end_date = $request->get('end_date');
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('id', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns([''])
                    ->make(true);
        }

        return view('admin.reports.product_wise_report');
    }
// product_wise_report End

// top_selling_products Start
public function top_selling_products(Request $request)
{
    $admin_id = auth()->user()->id;
    $data = OrderItem::with('getorderproductvariant')->select('product_variant_id', DB::raw('sum(quantity) as total'), DB::raw('count(*) as order_count'))->where('admin_id',$admin_id)->where('active_status','!=','cancelled')->where('active_status','!=','returned')->groupBy('product_variant_id')->orderBy('total', 'DESC')->get();
    if ($request->ajax()) {
       $data = OrderItem::with('getorderproductvariant')->select('product_variant_id', DB::raw('sum(quantity) as total'), DB::raw('count(*) as order_count'))->where('admin_id',$admin_id)->where('active_status','!=','cancelled')->where('active_status','!=','returned')->groupBy('product_variant_id')->orderBy('total', 'DESC')->get();
       return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('product_name', function($data){
                    return $data->getorderproductvariant->getproduct->name;
                })
                ->editColumn('unit', function($data){
                    return $data->getorderproductvariant->measurement.$data->getorderproductvariant->getmeasurementunit->measurement_unit;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('end_date'))) {
                        $admin_id = auth()->user()->id;
                        $start_date = $request->get('start_date');
                        $end_date = $request->get('end_date');
                    }
                    if (!empty($request->get('search'))) {
                         $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('id', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns([''])
                ->make(true);
    }

    return view('admin.reports.top_selling_products');
}
// top_selling_products End

// product_sales_chart Start
public function product_sales_chart(Request $request)
{
    $admin_id = auth()->user()->id;
    $data = ProductVariant::where('admin_id',$admin_id)->get();
    $id="";
    $mon1="";
    $mon2="";
    $mon3="";
    $mon4="";
    $mon5="";
    $mon6="";
    $mon7="";
    $mon8="";
    $mon9="";
    $mon10="";
    $mon11="";
    $mon12="";
    return view('admin.reports.product_sales_chart',compact('id','data','mon1','mon2','mon3','mon4','mon5','mon6','mon7','mon8','mon9','mon10','mon11','mon12'));
}
// product_sales_chart End

// get_chart Start
public function get_chart(Request $request)
{
    $admin_id = auth()->user()->id;
    $data = ProductVariant::where('admin_id',$admin_id)->get();
    $id = $request->product_id;
    $chart_data = OrderItem::select('id', 'created_at')
    ->where('product_variant_id',$id)
    ->get()
    ->groupBy(function($date) {
    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
    return Carbon::parse($date->created_at)->format('m'); // grouping by months
    });
    $usermcount = [];
    $userArr = [];

    foreach ($chart_data as $key => $value) {
        $usermcount[(int)$key] = count($value);
    }

    for($i = 1; $i <= 12; $i++){
        if(!empty($usermcount[$i])){
            $userArr[$i] = $usermcount[$i];    
        }else{
            $userArr[$i] = 0;    
        }
    }
    
    $mon1 = $userArr[1];
    $mon2 = $userArr[2];
    $mon3 = $userArr[3];
    $mon4 = $userArr[4];
    $mon5 = $userArr[5];
    $mon6 = $userArr[6];
    $mon7 = $userArr[7];
    $mon8 = $userArr[8];
    $mon9 = $userArr[9];
    $mon10 = $userArr[10];
    $mon11 = $userArr[11];
    $mon12 = $userArr[12];

    return view('admin.reports.product_sales_chart',compact('id','data','mon1','mon2','mon3','mon4','mon5','mon6','mon7','mon8','mon9','mon10','mon11','mon12'));
}
// get_chart End
}
