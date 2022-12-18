<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\State;
use App\Models\City;
use Yajra\DataTables\DataTables;

class AreaController extends Controller
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
            $data =  $data = Area::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
                        $btns .= '<a href="' . route('areas.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('areas.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        return $btns;
                    })
                    ->editColumn('state_name', function($data){
                        return $data->getstate->name;
                    }) 
                    ->editColumn('city_name', function($data){
                        return $data->getcity->name;
                    }) 
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.areas.index');
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
        return view('admin.areas.create',compact('states'));
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
            'city_id' => 'required',
            'state_id' => 'required',
            'pincode' => 'required',
            'name' => 'required',
        ],
        [
            'name.required' => 'Area Name field is required',
            'pincode.required' => 'Pincode field is required',
            'name.unique' => 'Area Name already Exist',
            'state_id.required' => 'State Name field is required',
            'city_id.required' => 'City Name field is required',
        ]);

        $admin_id = auth()->user()->id;
        $err = Area::where('name',$request->name)->where('admin_id',$admin_id)->get();

        if(!blank($err)){
            return redirect()->back()->with('error', 'Area Name already Exist');
        }

        $data = Area::create([
            'name' => $request->name,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
            'admin_id' => $admin_id,
        ]);
        flash()->addSuccess('Area Created Successfully!');
        return redirect()->route('areas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Area::where('id',$id)->get();
        return view('admin.areas.show',compact('data'));
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
        $data = Area::where('id',$id)->get();
        $states = State::where('admin_id',$user_id)->get();
        $cities = City::where('admin_id',$user_id)->get();
        return view('admin.areas.edit',compact('data','states','cities'));
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
            'city_id' => 'required',
            'state_id' => 'required',
            'pincode' => 'required',
            'name' => 'required',
        ],
        [
            'name.required' => 'Area Name field is required',
            'pincode.required' => 'Pincode field is required',
            'name.unique' => 'Area Name already Exist',
            'state_id.required' => 'State Name field is required',
            'city_id.required' => 'City Name field is required',
        ]);

        $admin_id = auth()->user()->id;
        $err = Area::where('name',$request->name)->where('admin_id',$admin_id)->where('id','!=',$id)->get();

        if(!blank($err)){
            return redirect()->back()->with('error', 'Area Name already Exist');
        }

        $data = Area::where('id',$id)->update([
            'name' => $request->name,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
        ]);
        flash()->addSuccess('Area Updated Successfully!');
        return redirect()->route('areas.index');
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
    
    public function get_city_list($id)
    {
        $city = City::where('state_id',$id)->get();
        return response()->json($city);  
    }

    public function get_area_list($id)
    {
        $area = Area::where('city_id',$id)->get();
        return response()->json($area);  
    }
}
