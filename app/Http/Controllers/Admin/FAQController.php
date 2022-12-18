<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQs;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $data = FAQs::where('admin_id',$user_id)->latest()->paginate(5);
        return view('admin.faqs.index',compact('data'));
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
        $admin_id = auth()->user()->id;

        // Update
        if($request->id){
            FAQs::where('id',$request->id)->update([
                'question'  => $request->question,
                'answer'    => $request->answer,
                'status'    => $request->status,
            ]);
            flash()->addSuccess('FAQ Updated Successfully!');
            return redirect()->back();
        }else{
            // Create
            FAQs::create([
                'admin_id'  => $admin_id,
                'question'  => $request->question,
                'answer'    => $request->answer,
                'status'    => $request->status,
            ]);
            flash()->addSuccess('FAQ Added Successfully!');
            return redirect()->back();
        }  
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

    public function faqdelete(Request $request)
    {
        if(isset($request->id)){
            $todo = FAQs::findOrFail($request->id);
            $todo->delete();
            flash()->addSuccess('FAQ Deleted Successfully!');
            return Response::json('success');
        }
    }

}
