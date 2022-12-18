<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Order;
use App\Models\Buyer;
use App\Models\ProductVariant;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\Models\SalesVisit;
use Mail;
use App\Mail\OrderMail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // Validation
        $validator = Validator::make($request->all(), [
            'user_id'               => 'required',
            'order_by'              => 'required',
            'address_id'            => 'required',
            'product_variant_id'    => 'required',
            'quantity'              => 'required',
            'total'                 => 'required',
            // 'delivery_charge'       => 'required',
            // 'tax_amount'            => 'required',
            // 'tax_percentage'        => 'required',
            // 'discount'              => 'required',
            'final_total'           => 'required',
            'lattitude'             => 'required',
            'longitude'             => 'required',
            'payment_method'        => 'required',
            // 'delivery_time'         => 'required',
            'status'                => 'required',
        ],
        [
            'user_id.required'              => 'user_id Field is Required',
            'order_by.required'             => 'order_by Field is Required',
            'address_id.required'           => 'address_id Field is Required',
            'product_variant_id.required'   => 'product_variant_id Field is Required',
            'quantity.required'             => 'quantity Field is Required',
            'total.required'                => 'total Field is Required',
            'delivery_charge.required'      => 'delivery_charge Field is Required',
            'tax_amount.required'           => 'tax_amount Field is Required',
            'tax_percentage.required'       => 'tax_percentage Field is Required',
            'discount.required'             => 'discount Field is Required',
            'final_total.required'          => 'final_total Field is Required',
            'lattitude.required'            => 'lattitude Field is Required',
            'longitude.required'            => 'longitude Field is Required',
            'payment_method.required'       => 'payment_method Field is Required',
            'delivery_time.required'        => 'delivery_time Field is Required',
            'status.required'               => 'status Field is Required',
        ]
        );
        
        // Return Error
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        //Stock Validation
        foreach($request->product_variant_id as $key => $product_variant_ids){
            $db_stock = ProductVariant::where('id',$product_variant_ids)->value('stock');
            $req_stock = $request->quantity[$key];
            if($db_stock < $req_stock){
                return response()->json([
                    'status'  => 422,
                    'message' => "Product variant ".$product_variant_ids." quantity is reach Limit. Available Stock is: ".$db_stock,
                    'data'    => "Nil"
                ], 422);  
            }
        }

        $admin_id = auth()->user()->admin_id;
        $invoice_type = Buyer::where('user_id',$request->user_id)->value('invoice_type');

        // Insert data to orders Table
        $order = Order::create([
            'user_id'           => $request->user_id,
            'admin_id'          => $admin_id,
            'order_by'          => $request->order_by,
            'address_id'        => $request->address_id,
            'delivery_boy_id'   => $request->delivery_boy_id,
            'total'             => $request->total,
            'delivery_charge'   => $request->delivery_charge,
            'tax_amount'        => $request->tax_amount,
            'tax_percentage'    => $request->tax_percentage,
            'discount'          => $request->discount,
            'promo_code'        => $request->promo_code,
            'promo_discount'    => $request->promo_discount,
            'final_total'       => $request->final_total,
            'payment_method'    => $request->payment_method,
            'lattitude'         => $request->lattitude,
            'longitude'         => $request->longitude,
            'delivery_time'     => $request->delivery_time,
            'status'            => $request->status,
            'active_status'     => 'received',
            'invoice_type'      => $invoice_type,
        ]);

        $order_status = OrderStatus::create([
            'admin_id' => $admin_id,
            'order_id' => $order->id,
            'status'   => 'received',
        ]);

        $price_slab = Buyer::where('user_id',$request->user_id)->value('slab_id');
        $price_slab = $price_slab - 1;

        foreach($request->product_variant_id as $key => $product_variant_ids){
            
            $price_string = ProductVariant::where('id',$product_variant_ids)->value('price');
            $price_array = explode(",",$price_string);
            $price = $price_array[$price_slab];
            // $price = $request->quantity[$key] * $per_price;
            $product_id = ProductVariant::where('id',$product_variant_ids)->value('product_id');
            $sgst = Product::where('id',$product_id)->value('sgst');
            $cgst = Product::where('id',$product_id)->value('cgst');
            $igst = Product::where('id',$product_id)->value('igst');
            $hsn_code = Product::where('id',$product_id)->value('hsn_code');
            $discounted_price = 0;
            $sub_total = $price + $discounted_price;
            // Insert data to order_items Table
            $order_item = OrderItem::create([
                'user_id'               => $request->user_id,
                'admin_id'              => $admin_id,
                'order_id'              => $order->id,
                'product_variant_id'    => $product_variant_ids,
                'quantity'              => $request->quantity[$key],
                'price'                 => $price,
                'sgst'                  => $sgst,
                'cgst'                  => $cgst,
                'igst'                  => $igst,
                'hsn_code'              => $hsn_code,
                'discounted_price'      => $discounted_price,
                'discount'              => $request->discount,
                'sub_total'             => $sub_total,
                'status'                => $request->status,
                'active_status'         => 'received'
            ]);

            // Decrease Product Count
            $current_stock = ProductVariant::where('id',$product_variant_ids)->value('stock');
            $stock = $current_stock - $request->quantity[$key];
            ProductVariant::where('id',$product_variant_ids)->update([
                'stock' => $stock,
            ]);
        }

        // Get data to send mail
        $data = OrderItem::where('order_id',$order->id)->get();
        $user_name = User::where('id',$request->user_id)->value('name');
        $mailData = [
            'title' => 'Mail from Adesha',
            'body' => 'Your Order Placed Successfully.',
            'data' => $data,
            'name' => $user_name
        ];
        
        $user_mail = User::where('id',$request->user_id)->value('email');

        Mail::to($user_mail)->send(new OrderMail($mailData));

        // Check Is Sales Order
        if($request->order_by != $request->user_id){
            SalesVisit::create([
                'admin_id'      => $admin_id,
                'user_id'       => $request->user_id,
                'order_status'  => 1,
                'order_id'      => $order->id,
                'order_by'      =>$request->order_by,
                'lattitude'     => $request->lattitude,
                'longitude'     => $request->longitude,
            ]);
        }

        return response()->json([
            'status'  => 200,
            'message' => "Order Placed Successfully",
            'data'    => 'nil'
        ], 200); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function my_orders()
    {
        $user_id = auth()->user()->id;
        $data = Order::with('getorderitem')->where('user_id',$user_id)->get();
        if(!blank($data)){
            return response()->json([
                'status'  => 200,
                'message' => "Your Orders",
                'data'    => $data
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Orders not Found",
                'data'    => $data
            ], 400); 
        }
    }

    public function no_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lattitude'     => 'required',
            'longitude'     => 'required',
            'buyer_id'      => 'required',
        ],
        [
            'lattitude.required'    => 'lattitude Field is Required',
            'longitude.required'    => 'longitude Field is Required',
            'buyer_id.required'     => 'buyer_id Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $order_by = auth()->user()->id;
        $admin_id = auth()->user()->admin_id;

        SalesVisit::create([
            'admin_id'      => $admin_id,
            'user_id'       => $request->buyer_id,
            'order_status'  => 0,
            'order_by'      => $order_by,
            'lattitude'     => $request->lattitude,
            'longitude'     => $request->longitude,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => "No Order added Successfully",
            'data'    => "Nil"
        ], 200); 
    }
}
