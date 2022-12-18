<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
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
            $data = Brand::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
       
                        $btns .= '<a href="' . route('brands.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('brands.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        
                        return $btns;
                    })
                    ->editColumn('image', function ($data) {
                        $label = '<a href="' . asset('images/'.$data->image)  .'" target="_blank"><img src="' . asset('images/'.$data->image)  .'" width="100px"></a>';
                        return $label;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('admin.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
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
            'image' => 'required',
        ],
        [
            'name.required' => 'Brand Name field is required',
            'name.unique' => 'Brand Name already Exist',
            'image.required' => 'Image field is required',
        ]);

        $imageName = uniqid().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        $admin_id = auth()->user()->id;

        $data = Brand::create([
            'name' => $request->name,
            'image' => $imageName,
            'status' => 1,
            'admin_id' => $admin_id,
        ]);
        flash()->addSuccess('Brand Created Successfully!');
        return redirect()->route('brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Brand::where('id',$id)->get();
        return view('admin.brands.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Brand::where('id',$id)->get();
        return view('admin.brands.edit',compact('data'));
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
        ],
        [
            'name.required' => 'Brand Name field is required',
            'name.unique' => 'Brand Name already Exist',
        ]);

        if ($request->file('image')) {
            $imageName = uniqid().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $data = Brand::where('id',$id)->update([
                'image' => $imageName,
            ]);
        }


        $data = Brand::where('id',$id)->update([
            'name' => $request->name,
        ]);
        flash()->addSuccess('Brand Updated Successfully!');
        return redirect()->route('brands.index');
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
