<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceSlab;
use Yajra\DataTables\DataTables;

class PriceSlabController extends Controller
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
            $data = PriceSlab::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
       
                        // $btns .= '<a href="' . route('brands.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('price_slabs.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        
                        return $btns;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('admin.price_slabs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.price_slabs.create');
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
            'title' => 'required',
        ],
        [
            'title.required' => 'Title field is required',
            'title.unique' => 'Title already Exist',
        ]);

        $admin_id = auth()->user()->id;
       
        $data = PriceSlab::create([
            'title' => $request->title,
            'status' => 1,
            'admin_id' => $admin_id,
        ]);
        flash()->addSuccess('Price Slab Created Successfully!');
        return redirect()->route('price_slabs.index');
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
        $data = PriceSlab::where('id',$id)->get();
        return view('admin.price_slabs.edit',compact('data'));
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
            'title' => 'required',
            'status' => 'required',
        ],
        [
            'title.required' => 'Title field is required',
            'title.unique' => 'Title already Exist',
            'status.required' => 'Status field is required',
        ]);

        $data = PriceSlab::where('id',$id)->update([
            'title' => $request->title,
            'status' => $request->status,
        ]);
        flash()->addSuccess('Price Slab Updated Successfully!');
        return redirect()->route('price_slabs.index');
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
