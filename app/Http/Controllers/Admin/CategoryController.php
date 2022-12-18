<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
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
            $data = Category::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
       
                        $btns .= '<a href="' . route('categories.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('categories.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        
                        return $btns;
                    })
                    ->editColumn('image', function ($data) {
                        $label = '<a href="' . asset('images/'.$data->image)  .'" target="_blank"><img src="' . asset('images/'.$data->image)  .'" width="100px"></a>';
                        return $label;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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
            'sub_title' => 'required',
            'image' => 'required',
        ],
        [
            'name.required' => 'Category Name field is required',
            'name.unique' => 'Category Name already Exist',
            'sub_title.required' => 'Category Sub Title field is required',
            'image.required' => 'Image field is required',
        ]);

        $imageName = uniqid().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        $admin_id = auth()->user()->id;

        $data = Category::create([
            'name' => $request->name,
            'subtitle' => $request->sub_title,
            'image' => $imageName,
            'status' => 1,
            'admin_id' => $admin_id,
        ]);
        flash()->addSuccess('Category Created Successfully!');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sub_category_list = SubCategory::where('category_id',$id)->get();
        $data = Category::where('id',$id)->get();
        return view('admin.categories.show',compact('data','sub_category_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Category::where('id',$id)->get();
        return view('admin.categories.edit',compact('data'));
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
            'sub_title' => 'required',
        ],
        [
            'name.required' => 'Category Name field is required',
            'name.unique' => 'Category Name already Exist',
            'sub_title.required' => 'Category Sub Title field is required',
        ]);
        if ($request->file('image')) {
            $imageName = uniqid().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $data = Category::where('id',$id)->update([
                'image' => $imageName,
            ]);
        }

        $admin_id = auth()->user()->id;

        $data = Category::where('id',$id)->update([
            'name' => $request->name,
            'subtitle' => $request->sub_title,
        ]);
        flash()->addSuccess('Category Updated Successfully!');
        return redirect()->route('categories.index');
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
