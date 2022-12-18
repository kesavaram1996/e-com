<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(auth('sanctum')->user()->tokens());
        // $request->bearerToken()->delete();
        $token = DB::table('personal_access_tokens')
        ->where('tokenable_id', 11)
        ->delete();
        // dd($request->bearerToken());
        $admin_id = auth()->user()->admin_id;

        $data = Category::select('name','image')->where('admin_id',$admin_id)->where('status',1)->get();

        if(!blank($data)){
            return response()->json([
                'status'  => 200,
                'message' => "Category List",
                'data'    => $data
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Category List Not Found",
                'data'    => "Nil"
            ], 400); 
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
        //
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
}
