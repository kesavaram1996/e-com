<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesPerson;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use DB;

class SalesPersonController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        if ($request->ajax()) {
            $data =  $data = SalesPerson::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
                        // $btns .= '<a href="' . route('products.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('sales_persons.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        return $btns;
                    })
                    // ->editColumn('area', function ($data) {
                    //     return $data->getarea->name;
                    // })
                    ->editColumn('city', function ($data) {
                        return $data->getcity->name;
                    })
                    ->editColumn('state', function ($data) {
                        return $data->getstate->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.sales_persons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $states = State::where('admin_id',$user_id)->get();
        return view('admin.sales_persons.create',compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ 
            'name' => 'required',
            'phone' => 'required|digits:10',
            'password' => 'required|min:6',
            'city_id' => 'required',
            'state_id' => 'required',
            // 'area_id' => 'required',
            'address' => 'required',
            'pincode' => 'required',
        ],
        [
            'name.required' => 'Name field is required',
            'phone.required' => 'Phone field is required',
            'phone.digits' => 'Phone Number must be a 10 digits',
            'pincode.required' => 'Pincode field is required',
            'state_id.required' => 'State Name field is required',
            'city_id.required' => 'City Name field is required',
            'area_id.required' => 'Area Name field is required',
        ]);

        $admin_id = auth()->user()->id;

        $user=User::create([
            'admin_id'     => $admin_id,
            'name'     => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'status'          => 1,
            'password'       => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);
        $role         = Role::find(4);
        $user->assignRole($role->name);

 

        

        $data = SalesPerson::create([
            'admin_id' => $admin_id,
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            // 'area_id' => $request->area_id,
            'address' => $request->address,
            'pincode' => $request->pincode,
        ]);
        flash()->addSuccess('Sales Person Created Successfully!');
        return redirect()->route('sales_persons.index');
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
        $data = SalesPerson::where('id',$id)->get();
        $states = State::where('admin_id',$user_id)->get();
        $cities = City::where('admin_id',$user_id)->where('state_id',$data[0]->state_id)->get();
        $areas = Area::where('admin_id',$user_id)->where('city_id',$data[0]->city_id)->get();
        return view('admin.sales_persons.edit',compact('data','states','cities','areas'));
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
        // dd($request);
        $request->validate([ 
            'name' => 'required',
            'phone' => 'required|digits:10',
            'city_id' => 'required',
            'state_id' => 'required',
            // 'area_id' => 'required',
            'address' => 'required',
            'pincode' => 'required',
            'status' => 'required',
        ],
        [
            'name.required' => 'Name field is required',
            'phone.required' => 'Phone field is required',
            'phone.digits' => 'Phone Number must be a 10 digits',
            'pincode.required' => 'Pincode field is required',
            'state_id.required' => 'State Name field is required',
            'city_id.required' => 'City Name field is required',
            'area_id.required' => 'Area Name field is required',
            'status.required' => 'Status field is required',
        ]);


        $data = SalesPerson::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            // 'area_id' => $request->area_id,
            'address' => $request->address,
            'pincode' => $request->pincode,
        ]);

        if(!blank($request->status)){
            User::where('id',$request->user_id)->update([
                'status' => $request->status,
            ]);
            if($request->status==0){
                $token = DB::table('personal_access_tokens')
                ->where('tokenable_id', $request->user_id)
                ->delete();
            }
        }

        flash()->addSuccess('Sales Person Updated Successfully!');
        return redirect()->route('sales_persons.index');
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
