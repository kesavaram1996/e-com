<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Buyer;
use App\Models\MeasurementUnit;

class ProductController extends Controller
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

    public function category_product_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'   => 'required',
            'buyer_id'      => 'required',
        ],
        [
            'buyer_id.required'     => 'buyer_id Field is Required',
            'category_id.required'  => 'category_id Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $category_id = $request->category_id;
        $admin_id = auth()->user()->admin_id;

        // $data = Product::query()->with(['getvariant' => function ($query) {
        //     $query->select('id', 'product_id','measurement','measurement_unit_id','price')->with('getmeasurementunit');
        // }])->select('id','name','pimage')->where('admin_id',$admin_id)->where('category_id',$category_id)->where('status',1)->get();

        $products = Product::select('id','name','pimage')->where('admin_id',$admin_id)->where('category_id',$category_id)->where('status',1)->get();
        if(!blank($products)){ // Product Exist validation
            foreach($products as $product){
                $slab = Buyer::where('user_id',$request->buyer_id)->value('slab_id');
                $variants = ProductVariant::where('product_id',$product->id)->get();
               
                foreach($variants as $variant){
                    $measurement_unit = MeasurementUnit::where('id',$variant->measurement_unit_id)->value('measurement_unit');
                    $price = explode(",",$variant->price);
                    $product_variant[] = [
                        'id'                => $variant->id,
                        'quantity'          => $variant->measurement,
                        'measurement_unit'  => $measurement_unit,
                        'price'             => $price[$slab],
                    ];
                }
                $id[] = $product->id;
                $name[] = $product->name;
                $image[] = $product->pimage;
            }
            foreach($id as $key => $ids){
                $data[] = [
                    'id'        => $id[$key],
                    'name'      => $name[$key],
                    'image'     => $image[$key],
                    'variants'   => $product_variant,
                ];
            }
        // Return Response
            return response()->json([
                'status'  => 200,
                'message' => "Product List",
                'data'    => $data
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Product List Not Found",
                'data'    => "Nil"
            ], 400); 
        }
    }


    public function product_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'    => 'required',
            'buyer_id'      => 'required',
        ],
        [
            'buyer_id.required'     => 'buyer_id Field is Required',
            'product_id.required'   => 'product_id Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $product_id = $request->product_id;
        $admin_id = auth()->user()->admin_id;

        // $data = Product::query()->with(['getvariant' => function ($query) {
        //     $query->select('id', 'product_id','measurement','measurement_unit_id','price')->with('getmeasurementunit');
        // }])->select('id','name','pimage')->where('admin_id',$admin_id)->where('id',$product_id)->where('status',1)->get();

        $products = Product::select('id','name','pimage')->where('admin_id',$admin_id)->where('id',$product_id)->where('status',1)->get();

        if(!blank($products)){ // Product Exist validation
                $slab = Buyer::where('user_id',$request->buyer_id)->value('slab_id');
                $variants = ProductVariant::where('product_id',$products[0]->id)->get();
                foreach($variants as $variant){
                    $measurement_unit = MeasurementUnit::where('id',$variant->measurement_unit_id)->value('measurement_unit');
                    $price = explode(",",$variant->price);
                    $product_variant[] = [
                        'id'                => $variant->id,
                        'quantity'          => $variant->measurement,
                        'measurement_unit'  => $measurement_unit,
                        'price'             => $price[$slab],
                    ];
                }
                $data[] = [
                    'id'        => $products[0]->id,
                    'name'      => $products[0]->name,
                    'image'     => $products[0]->pimage,
                    'variants'   => $product_variant,
                ];
        // Return Response
            return response()->json([
                'status'  => 200,
                'message' => "Product Details",
                'data'    => $data
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Product Details Not Found",
                'data'    => "Nil"
            ], 400); 
        }
    }


}
