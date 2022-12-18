<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
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
            $data = SubCategory::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
       
                        $btns .= '<a href="' . route('sub_categories.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('sub_categories.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        
                        return $btns;
                    })
                    ->editColumn('image', function ($data) {
                        $label = '<a href="' . asset('images/'.$data->image)  .'" target="_blank"><img src="' . asset('images/'.$data->image)  .'" width="100px"></a>';
                        return $label;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('admin.sub_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $category = Category::where('admin_id',$user_id)->get();
        return view('admin.sub_categories.create',compact('category'));
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
            'category_id' => 'required',
            'name' => 'required',
            'sub_title' => 'required',
            'image' => 'required',
        ],
        [
            'category_id.required' => 'Category field is required',
            'name.required' => 'Sub Category Name field is required',
            'name.unique' => 'Sub Category Name already Exist',
            'sub_title.required' => 'Sub Category Sub Title field is required',
            'image.required' => 'Image field is required',
        ]);

        $imageName = uniqid().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        $admin_id = auth()->user()->id;

        $data = SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'subtitle' => $request->sub_title,
            'image' => $imageName,
            'status' => 1,
            'admin_id' => $admin_id,
        ]);
        flash()->addSuccess('Sub Category Created Successfully!');
        return redirect()->route('sub_categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = SubCategory::with('getcategory')->where('id',$id)->get();
        return view('admin.sub_categories.show',compact('data'));
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
        $category = Category::where('admin_id',$user_id)->get();
        $data = SubCategory::where('id',$id)->get();
        return view('admin.sub_categories.edit',compact('data','category'));
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
            'category_id' => 'required',
            'name' => 'required',
            'sub_title' => 'required',
        ],
        [
            'category_id.required' => 'Category field is required',
            'name.required' => 'Sub Category Name field is required',
            'name.unique' => 'Sub Category Name already Exist',
            'sub_title.required' => 'Sub Category Sub Title field is required',
        ]);
        if ($request->file('image')) {
            $imageName = uniqid().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $data = SubCategory::where('id',$id)->update([
                'image' => $imageName,
            ]);
        }

        $admin_id = auth()->user()->id;

        $data = SubCategory::where('id',$id)->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'subtitle' => $request->sub_title,
        ]);
        flash()->addSuccess('Sub Category Updated Successfully!');
        return redirect()->route('sub_categories.index');
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
