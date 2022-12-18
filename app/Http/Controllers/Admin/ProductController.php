<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\PriceSlab;
use App\Models\Product;
use App\Models\ProductVariant;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $prices = PriceSlab::where('admin_id',$user_id)->where('status',1)->get();
        if ($request->ajax()) {
            $data = Product::with('getvariant')->where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
       
                        // $btns .= '<a href="' . route('products.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('products.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        
                        return $btns;
                    })
                    ->editColumn('price0', function ($data) {
                        $label_list = $data->getvariant[0]->price;
                        $price = explode(",",$label_list);
                        return $price[0];
                    })
                    ->editColumn('price1', function ($data) {
                        $label_list = $data->getvariant[0]->price;
                        $price = explode(",",$label_list);
                        return $price[1];
                    })
                    ->editColumn('price2', function ($data) {
                        $label_list = $data->getvariant[0]->price;
                        $price = explode(",",$label_list);
                        return $price[2];
                    })
                    ->editColumn('price3', function ($data) {
                        $label_list = $data->getvariant[0]->price;
                        $price = explode(",",$label_list);
                        return $price[3];
                    })
                    ->editColumn('measurement', function ($data) {
                        $measurement = $data->getvariant[0]->measurement;
                        $measurement_unit = $data->getvariant[0]->getmeasurementunit->measurement_unit;
                        return $measurement.$measurement_unit;
                    })
                    ->editColumn('image', function ($data) {
                        $label = '<a href="' . asset('images/'.$data->pimage)  .'" target="_blank"><img src="' . asset('images/'.$data->pimage)  .'" width="100px"></a>';
                        return $label;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('admin.products.index',compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $categories = Category::where('admin_id',$user_id)->get();
        $sub_categories = SubCategory::where('admin_id',$user_id)->get();
        $brands = Brand::where('admin_id',$user_id)->get();
        $prices = PriceSlab::where('admin_id',$user_id)->where('status',1)->get();
        return view('admin.products.create',compact('categories','sub_categories','brands','prices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // $user_id = auth()->user()->id;
        // $limit = PriceSlab::where('admin_id',$user_id)->count();
        // $i = 0;
        // foreach($request->packate_measurement as $key => $variant){
        // $newArray = array_slice($request->packate_price, $i, $limit);
        // $i = $i + $limit;
        // $price = implode(',', $newArray);
        // echo  $price;
        // echo "<br>";
        // echo "limit".$i;
        // echo "<br>";
        // }
        // exit;
        $request->validate([ 
            'name' => 'required|unique:products,name',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'brand_id' => 'required',
            'pimage' => 'required',
            'minimum_stock' => 'required',
            'hsn_code' => 'required',
        ],
        [
            'name.required' => 'Product Name field is required',
            'name.unique' => 'Product Name already Exist',
            'category_id.required' => 'Category Name field is required',
            'sub_category_id.required' => 'Sub Category Name field is required',
            'brand_id.required' => 'Brand Name field is required',
            'pimage.required' => 'Product Image field is required',
            'minimum_stock.required' => 'Minimum Stock field is required',
            'hsn_code.required' => 'HSN Code field is required',
        ]);

        $admin_id = auth()->user()->id;
        $user_id = auth()->user()->id;
        $limit = PriceSlab::where('admin_id',$user_id)->count();
        $i = 0;
        
        $pimage = uniqid().'.'.$request->pimage->extension();  
        $request->pimage->move(public_path('images'), $pimage);
        $gimage = null;   

        if ($request->file('gimage')) {
            $gimage = uniqid().'.'.$request->gimage->extension();  
            $request->gimage->move(public_path('images'), $gimage);
        }

        // Insert Data to products Table
        $data = Product::create([
            'admin_id' => $admin_id,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
            'pimage' => $pimage,
            'gimage' => $gimage,
            'description' => $request->description,
            'sgst' => $request->sgst,
            'cgst' => $request->cgst,
            'igst' => $request->igst,
            'min_stock' => $request->minimum_stock,
            'hsn_code' => $request->hsn_code,
            'status' => 1,
        ]);

        
        // Insert Data to product_variants Table
        foreach($request->packate_measurement as $key => $variant){
            $newArray = array_slice($request->packate_price, $i, $limit);
            $i = $i + $limit;
            $price = implode(',', $newArray);
            
            $variant_data = ProductVariant::create([
                'admin_id' => $admin_id,
                'product_id' => $data->id,
                'type' => "packet",
                'measurement' => $request->packate_measurement[$key],
                'measurement_unit_id' => $request->packate_measurement_unit_id[$key],
                'price' => $price,
                'min_qty' => $request->minimum_stock,
                'serve_for' => $request->packate_serve_for[$key],
                'stock' => $request->packate_stock[$key],
            ]);
        }
        flash()->addSuccess('Product Added Successfully!');
        return redirect()->route('products.index');
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
        $user_id = auth()->user()->id;
        $categories = Category::where('admin_id',$user_id)->get();
        $sub_categories = SubCategory::where('admin_id',$user_id)->get();
        $brands = Brand::where('admin_id',$user_id)->get();
        $prices = PriceSlab::where('admin_id',$user_id)->where('status',1)->get();
        $data = Product::with('getvariant')->where('id',$id)->get();
        return view('admin.products.edit',compact('categories','sub_categories','brands','prices','data'));
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
        $request->validate([ 
            'name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'brand_id' => 'required',
            'minimum_stock' => 'required',
            'hsn_code' => 'required',
        ],
        [
            'name.required' => 'Product Name field is required',
            'name.unique' => 'Product Name already Exist',
            'category_id.required' => 'Category Name field is required',
            'sub_category_id.required' => 'Sub Category Name field is required',
            'brand_id.required' => 'Brand Name field is required',
            'pimage.required' => 'Product Image field is required',
            'minimum_stock.required' => 'Minimum Stock field is required',
            'hsn_code.required' => 'HSN Code field is required',
        ]);

        $admin_id = auth()->user()->id;
        $user_id = auth()->user()->id;
        $limit = PriceSlab::where('admin_id',$user_id)->count();
        $i = 0;

        if ($request->file('pimage')) {
            $pimage = uniqid().'.'.$request->pimage->extension();  
            $request->pimage->move(public_path('images'), $pimage);
            Product::where('id',$id)->update([
                'pimage' => $pimage,
            ]);
        } 

        if ($request->file('gimage')) {
            $gimage = uniqid().'.'.$request->gimage->extension();  
            $request->gimage->move(public_path('images'), $gimage);
            Product::where('id',$id)->update([
                'gimage' => $gimage,
            ]);
        }

        // Insert Data to products Table
        $data = Product::where('id',$id)->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'sgst' => $request->sgst,
            'cgst' => $request->cgst,
            'igst' => $request->igst,
            'min_stock' => $request->minimum_stock,
            'hsn_code' => $request->hsn_code,
        ]);

        
        // Insert Data to product_variants Table
        foreach($request->variant_id as $key => $variant){
            $newArray = array_slice($request->packate_price, $i, $limit);
            $i = $i + $limit;
            $price = implode(',', $newArray);
            
            $variant_data = ProductVariant::where('id',$request->variant_id[$key])->update([
                'measurement' => $request->packate_measurement[$key],
                'measurement_unit_id' => $request->packate_measurement_unit_id[$key],
                'price' => $price,
                'min_qty' => $request->minimum_stock,
                'serve_for' => $request->packate_serve_for[$key],
                'stock' => $request->packate_stock[$key],
            ]);
        }
        flash()->addSuccess('Product Updated Successfully!');
        return redirect()->back();
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

    public function edit_products()
    {
        $user_id = auth()->user()->id;
        $categories = Category::where('admin_id',$user_id)->get();
        $sub_categories = SubCategory::where('admin_id',$user_id)->get();
        $brands = Brand::where('admin_id',$user_id)->get();
        $prices = PriceSlab::where('admin_id',$user_id)->where('status',1)->get();
        $data = ProductVariant::where('admin_id',$user_id)->latest()->paginate(5);
        return view('admin.products.edit_products',compact('data','categories','sub_categories','prices'));
    }

    public function update_products(Request $request)
    {
        $name =  $request->name;
        $id = $request->id;
        
        // Product Name
        if($request->name){
            $res = Product::where('name',$name)->get();

            if(!blank($res)){
                $msg = 'Product Name Already Exist';
                return response()->json(array('msg'=> $msg), 200);
            }else{
                Product::where('id',$id)->update([
                    'name' => $name,
                ]);
                $msg = 'Product Name Updated Successfully';
                return response()->json(array('msg'=> $msg), 200);
            }
        } 
        
        // Category
        if($request->category_id){
            $category_id =  $request->category_id;
            $id = $request->id;
            Product::where('id',$id)->update([
                'category_id' => $category_id,
            ]);
            $msg = 'Product Category Updated Successfully';
            return response()->json(array('msg'=> $msg), 200);
        }
        
        // Sub Category
        if($request->sub_category_id){
            $sub_category_id =  $request->sub_category_id;
            $id = $request->id;
            Product::where('id',$id)->update([
                'sub_category_id' => $sub_category_id,
            ]);
            $msg = 'Product Sub Category Updated Successfully';
            return response()->json(array('msg'=> $msg), 200);
        } 
        
        // Measurement
        if($request->measurement){
            $measurement =  $request->measurement;
            $id = $request->id;
            ProductVariant::where('id',$id)->update([
                'measurement' => $measurement,
            ]);
            $msg = 'Product Measurement Updated Successfully';
            return response()->json(array('msg'=> $msg), 200);
        }

        // Packate Measurement Unit id
        if($request->packate_measurement_unit_id){
            $packate_measurement_unit_id =  $request->packate_measurement_unit_id;
            $id = $request->id;
            ProductVariant::where('id',$id)->update([
                'measurement_unit_id' => $packate_measurement_unit_id,
            ]);
            $msg = 'Product Measurement Unit Updated Successfully';
            return response()->json(array('msg'=> $msg), 200);
        }

        // Price
        if($request->price){
            $priceList =  $request->price;
            $price = implode(', ',$priceList);
            $id = $request->id;
            ProductVariant::where('id',$id)->update([
                'price' => $price,
            ]);
            $msg = 'Product Price Updated Successfully';
            return response()->json(array('msg'=> $msg), 200);
        }

        // Discounted Price
        if($request->discounted_price){
            $discounted_price =  $request->discounted_price;
            $id = $request->id;
            ProductVariant::where('id',$id)->update([
                'discounted_price' => $discounted_price,
            ]);
            $msg = 'Product Discounted Price Updated Successfully';
            return response()->json(array('msg'=> $msg), 200);
        }

        // Stock
        if($request->stock){
            $stock =  $request->stock;
            $id = $request->id;
            ProductVariant::where('id',$id)->update([
                'stock' => $stock,
            ]);
            $msg = 'Product Stock Updated Successfully';
            return response()->json(array('msg'=> $msg), 200);
        }

        // Packate Serve for
        if($request->packate_serve_for){
            $packate_serve_for =  $request->packate_serve_for;
            $id = $request->id;
            ProductVariant::where('id',$id)->update([
                'serve_for' => $packate_serve_for,
            ]);
            $msg = 'Product Serve Updated Successfully';
            return response()->json(array('msg'=> $id), 200);
        }
    }

    public function min_stock_products(Request $request)
    {
        $user_id = auth()->user()->id;
        if ($request->ajax()) {
            $data = ProductVariant::with('getproduct')->where('admin_id',$user_id)->whereColumn('stock','<=','min_qty')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('name', function ($data) {
                        
                        return $data->getproduct->name;
                    })
                    ->editColumn('measurement', function ($data) {
                        $measurement = $data->measurement;
                        $measurement_unit = $data->getmeasurementunit->measurement_unit;
                        return $measurement.$measurement_unit;
                    })
                    ->editColumn('min_stock', function ($data) {
                        return $data->getproduct->min_stock;
                    })
                    ->rawColumns([])
                    ->make(true);
        }
        return view('admin.products.min_stock_products');
    }
}
