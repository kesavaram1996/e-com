<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\OrderStatus;
use App\Models\SalesPerson;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $sales = SalesPerson::where('admin_id',$user_id)->get();
        if ($request->ajax()) {
            $data = Order::with('getuser','getaddress','getorderbyuser')->where('admin_id',$user_id);
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
                    ->editColumn('order_by', function ($data) {
                        if($data->user_id == $data->order_by){
                            return "Buyer";
                        }else{
                            return "Sales: ".$data->getorderbyuser->name;
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
                    ->rawColumns(['action','active_status'])
                    ->make(true);
        }
        return view('admin.orders.index',compact('sales'));
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
        return view('admin.orders.show',compact('data','status_count'));
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

    public function get_invoice(Request $request)
    {
        $invoice_type = $request->invoice_type;
        $order_id = $request->order_id;
        Order::where('id',$order_id)->update([
            'invoice_type' => $invoice_type,
            'total' =>  $request->total,
            'final_total' =>  $request->final_total,
        ]);
        $data = Order::where('id',$order_id)->get();
        return view('admin.orders.invoice',compact('data'));
    }

    public function change_status(Request $request)
    {
        $status = $request->status;
        $order_id = $request->id;
        $admin_id = auth()->user()->id;
        $msg = "";
        $action = "";

        $current_status = order::where('id',$order_id)->value('active_status');
        // received
        if($status == 'received'){
            $msg = "Wrong Status";
        }
        // processed
        if($status == 'processed'){
            if($current_status == 'received'){
                $action = 1;
            }else{
                $msg = "Wrong Status";
            }
        }
        // shipped
        if($status == 'shipped'){
            if($current_status == 'processed'){
                $action = 1;
            }else{
                $msg = "Wrong Status";
            }
        }
        // delivered
        if($status == 'delivered'){
            if($current_status == 'shipped'){
                $action = 1;
                $product_variants = OrderItem::where('order_id',$order_id)->get();
                foreach($product_variants as $product_variant){
                    OrderItem::where('product_variant_id',$product_variant->product_variant_id)->update([
                        'active_status' => 'delivered',
                    ]);
                }
            }else{
                $msg = "Wrong Status";
            }
        }
        // cancelled
        if($status == 'cancelled'){
            if($current_status == 'shipped'){
                // Add Stock to Product Variant
                $product_variants = OrderItem::where('order_id',$order_id)->get();
                foreach($product_variants as $product_variant){
                    $current_stock = ProductVariant::where('id',$product_variant->product_variant_id)->value('stock');
                    $quantity = $product_variant->quantity;
                    $stock = $current_stock + $quantity;
                    ProductVariant::where('id',$product_variant->product_variant_id)->update([
                        'stock' => $stock,
                    ]);
                    OrderItem::where('product_variant_id',$product_variant->product_variant_id)->update([
                        'active_status' => 'cancelled',
                    ]);
                }

                $action = 1;
            }else{
                $msg = "Wrong Status";
            }
        }
        // returned
        if($status == 'returned'){
            if($current_status == 'delivered'){
                // Return Stock to Product Variant
                $product_variants = OrderItem::where('order_id',$order_id)->get();
                foreach($product_variants as $product_variant){
                    $current_stock = ProductVariant::where('id',$product_variant->product_variant_id)->value('stock');
                    $quantity = $product_variant->quantity;
                    $stock = $current_stock + $quantity;
                    ProductVariant::where('id',$product_variant->product_variant_id)->update([
                        'stock' => $stock,
                    ]);
                    OrderItem::where('product_variant_id',$product_variant->product_variant_id)->update([
                        'active_status' => 'returned',
                    ]);
                }
                $action = 1;
            }else{
                $msg = "Wrong Status";
            }
        }

        if($action == 1){
            Order::where('id',$order_id)->update([
                'active_status' => $status,
            ]);
            
            OrderStatus::create([
                'admin_id'  => $admin_id,
                'order_id'  => $order_id,
                'status'    => $status,
            ]);
            $msg = "Status Changed Successfully.";
        }
        
        return response()->json($msg);  
    }
}
