<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class StateController extends Controller
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
            $data =  $data = State::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
                        $btns .= '<a href="' . route('states.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('states.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        return $btns;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.states.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.states.create');
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
        ],
        [
            'name.required' => 'State Name field is required',
            'name.unique' => 'State Name already Exist',
        ]);

        $admin_id = auth()->user()->id;
        $err = State::where('name',$request->name)->where('admin_id',$admin_id)->get();

        if(!blank($err)){
            return redirect()->back()->with('error', 'State Name already Exist');
        }

        $data = State::create([
            'name' => $request->name,
            'admin_id' => $admin_id,
        ]);
        flash()->addSuccess('State Created Successfully!');
        return redirect()->route('states.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = State::where('id',$id)->get();
        $city_lists = City::where('state_id',$id)->get();
        return view('admin.states.show',compact('data','city_lists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = State::where('id',$id)->get();
        return view('admin.states.edit',compact('data'));
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
        $admin_id = auth()->user()->id;
        $request->validate([ 
            'name' => 'required',
        ],
        [
            'name.required' => 'State Name field is required',
        ]);

        $err = State::where('name',$request->name)->where('admin_id',$admin_id)->where('id','!=',$id)->get();

        if(!blank($err)){
            return redirect()->back()->with('error', 'State Name already Exist');
        }

        $data = State::where('id',$id)->update([
            'name' => $request->name,
        ]);
        flash()->addSuccess('State Updated Successfully!');
        return redirect()->route('states.index');
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
