<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use App\Models\Area;
use Yajra\DataTables\DataTables;

class CityController extends Controller
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
            $data =  $data = City::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
                        $btns .= '<a href="' . route('cities.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('cities.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        return $btns;
                    })
                    ->editColumn('state_name', function($data){
                        return $data->getstate->name;
                    }) 
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.cities.index');
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
        return view('admin.cities.create',compact('states'));
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
            'state_id' => 'required',
            'name' => 'required',
        ],
        [
            'name.required' => 'City Name field is required',
            'name.unique' => 'City Name already Exist',
            'state_id.required' => 'State Name field is required',
        ]);

        $admin_id = auth()->user()->id;
        $err = City::where('name',$request->name)->where('admin_id',$admin_id)->get();

        if(!blank($err)){
            return redirect()->back()->with('error', 'City Name already Exist');
        }

        $data = City::create([
            'name' => $request->name,
            'state_id' => $request->state_id,
            'admin_id' => $admin_id,
        ]);
        flash()->addSuccess('City Created Successfully!');
        return redirect()->route('cities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area_lists = Area::where('city_id',$id)->get();
        $data = City::where('id',$id)->get();
        return view('admin.cities.show',compact('data','area_lists'));
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
        $data = City::where('id',$id)->get();
        $states = State::where('admin_id',$user_id)->get();
        return view('admin.cities.edit',compact('data','states'));
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
            'state_id' => 'required',
        ],
        [
            'name.required' => 'City Name field is required',
            'name.unique' => 'City Name already Exist',
            'state_id.required' => 'State Name field is required',
        ]);

        $admin_id = auth()->user()->id;
        $err = City::where('name',$request->name)->where('admin_id',$admin_id)->where('id','!=',$id)->get();

        if(!blank($err)){
            return redirect()->back()->with('error', 'City Name already Exist');
        }

        $data = City::where('id',$id)->update([
            'name' => $request->name,
            'state_id' => $request->state_id,
        ]);
        flash()->addSuccess('City Updated Successfully!');
        return redirect()->route('cities.index');
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
