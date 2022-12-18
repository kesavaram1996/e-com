<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Cart;
use App\Models\ProductVariant;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $data = Cart::where('user_id',$user_id)->get();
        $data_count = Cart::where('user_id',$user_id)->count();
        $data_sum = Cart::where('user_id',$user_id)->sum('price');

        if(!blank($data)){
            return response()->json([
                'status'  => 200,
                'message' => "Cart List",
                'data'    => $data,
                'total_items'    => $data_count,
                'total'    => $data_sum
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Cart List Not Found",
                'data'    => "Nil"
            ], 422); 
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

    public function add_to_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'product_variant_id' => 'required',
            'quantity' => 'required',
        ],
        [
            'product_id.required' => 'product_id Field is Required',
            'product_variant_id.required' => 'product_variant_id Field is Required',
            'quantity.required' => 'quantity Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $admin_id = auth()->user()->admin_id;
        $user_id = auth()->user()->id;
        $per_product_price = ProductVariant::where('id',$request->product_variant_id)->value('price');

        $price = $request->quantity * $per_product_price;

        $res = Cart::create([
            'admin_id' => $admin_id,
            'user_id' => $user_id,
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id,
            'quantity' => $request->quantity,
            'price' => $price,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => "Product addded to Cart",
            'data'    => "Nil"
        ], 200);     
    }


    public function update_cart_product(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required',
            'quantity' => 'required',
        ],
        [
            'cart_id.required' => 'cart_id Field is Required',
            'quantity.required' => 'quantity Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $product_variant_id = Cart::where('id',$request->cart_id)->value('product_variant_id');

        if(blank($product_variant_id)){
            return response()->json([
                'status'  => 400,
                'message' => "Cart details Not Found",
                'data'    => "Nil"
            ], 400);
        }

        $per_product_price = ProductVariant::where('id',$product_variant_id)->value('price');
        $price = $request->quantity * $per_product_price;

        $res = Cart::where('id',$request->cart_id)->update([
            'quantity' => $request->quantity,
            'price' => $price,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => "Cart Updated",
            'data'    => "Nil"
        ], 200);
    }


    public function delete_cart_product(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required',
        ],
        [
            'cart_id.required' => 'cart_id Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }
        $data = Cart::where('id',$request->cart_id)->get();
        $res = Cart::where('id',$request->cart_id)->delete();
        if(!blank($data)){
            return response()->json([
                'status'  => 200,
                'message' => "Product deleted from Cart",
                'data'    => "Nil"
            ], 200);
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Product details Not found in cart",
                'data'    => "Nil"
            ], 400);
        }  
    }
}
