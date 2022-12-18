<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuyerAddress;
use Validator;

class BuyerAddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $data = BuyerAddress::select('id','name','address','pincode','phone','email','state_id','city_id')->with('getstate','getcity')->where('user_id',$user_id)->get();
        if(!blank($data)){
            return response()->json([
                'status'  => 200,
                'message' => "Address Lists",
                'data'    => $data
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Address List Not Found",
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'phone' => 'required|digits:10|numeric',
            'street' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            // 'area_id' => 'required',
            'pincode' => 'required',
            'lattitude' => 'required',
            'longitude' => 'required',
        ],
        [
            'name.required' => 'Name Field is Required',
            'name.min' => 'The Name must be at least 3 characters.',
            'phone.required' => 'phone Field is Required',
            'phone.digits' => 'The Phone must be 10 digits.',
            'phone.numeric' => 'The Phone must be numeric values only',
            'street.required' => 'street Field is Required',
            'state_id.required' => 'state_id Field is Required',
            'city_id.required' => 'city_id Field is Required',
            'area_id.required' => 'area_id Field is Required',
            'pincode.required' => 'pincode Field is Required',
            'lattitude.required' => 'lattitude Field is Required',
            'longitude.required' => 'longitude Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $user_id = auth()->user()->id;
        $admin_id = auth()->user()->admin_id;

        $res = BuyerAddress::create([
            'admin_id' => $admin_id,
            'user_id' => $user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->street,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            // 'area_id' => $request->area_id,
            'pincode' => $request->pincode,
            'lattitude' => $request->lattitude,
            'longitude' => $request->longitude,
            'is_default' => 0,
            'status' => 1,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => "Address Added Successfully",
            'data'    => "Nil"
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


    public function edit_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
            'name' => 'required|min:3',
            'phone' => 'required|digits:10|numeric',
            'street' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            // 'area_id' => 'required',
            'pincode' => 'required',
            'lattitude' => 'required',
            'longitude' => 'required',
        ],
        [
            'address_id.required' => 'address_id Field is Required',
            'name.required' => 'Name Field is Required',
            'name.min' => 'The Name must be at least 3 characters.',
            'phone.required' => 'phone Field is Required',
            'phone.digits' => 'The Phone must be 10 digits.',
            'phone.numeric' => 'The Phone must be numeric values only',
            'street.required' => 'street Field is Required',
            'state_id.required' => 'state_id Field is Required',
            'city_id.required' => 'city_id Field is Required',
            'area_id.required' => 'area_id Field is Required',
            'pincode.required' => 'pincode Field is Required',
            'lattitude.required' => 'lattitude Field is Required',
            'longitude.required' => 'longitude Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $res = BuyerAddress::where('id',$request->address_id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->street,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            // 'area_id' => $request->area_id,
            'pincode' => $request->pincode,
            'lattitude' => $request->lattitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'status'  => 200,
            'message' => "Address updated Successfully",
            'data'    => "Nil"
        ], 200);
    }

    public function delete_address(Request $request)
    {
        $id = $request->address_id;
        $address = BuyerAddress::find($id);
        if(!blank($address)){
            $address->delete();
            return response()->json([
                'status'  => 200,
                'message' => "Address deleted Successfully",
                'data'    => "Nil"
            ], 200);
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Address Not Found",
                'data'    => "Nil"
            ], 400);
        }
    }
}
