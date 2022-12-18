<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buyer;
use Validator;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_id = auth()->user()->admin_id;

        $data = Buyer::with('getcity','getstate')->select('id','company_name','name','address','pincode','city_id','state_id')->where('admin_id',$admin_id)->get();

        $response = [
            'status'  => 200,
            'message' => "Buyer Lists",
            'data'    => $data,
        ];
        return response()->json($response, 200);
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

    public function search_buyer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],
        [
            'name.required' => 'Name Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $name = $request->name;
        $admin_id = auth()->user()->admin_id;

        $data = Buyer::with('getcity','getstate')->select('id','company_name','name','address','pincode','city_id','state_id')->Where('admin_id',$admin_id)->Where('name', 'like', '%' . $name . '%')->get();

        if(!blank($data)){
            return response()->json([
                'status'  => 200,
                'message' => "Buyer Lists",
                'data'    => $data
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Buyer List Not Found",
                'data'    => "Nil"
            ], 422); 
        }
    }
}
