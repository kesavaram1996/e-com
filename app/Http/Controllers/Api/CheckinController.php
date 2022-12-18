<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\DailyLog;
use Carbon\Carbon;

class CheckinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'lattitude'     => 'required',
            'longitude'     => 'required',
            // 'checkin_at'    => 'required',
        ],
        [
            'lattitude.required'    => 'lattitude Field is Required',
            'longitude.required'    => 'longitude Field is Required',
            // 'checkin_at.required'   => 'checkin_at Field is Required',
        ]
        );
   
        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->errors(),
                'data'    => "Nil"
            ], 422);       
        }

        $admin_id = auth()->user()->admin_id;
        $user_id = auth()->user()->id;
        $checkin_time = Carbon::now();

        // Already checkin Validation
        $db_checkin_time = DailyLog::whereDate('checkin_time', Carbon::today())->where('user_id',$user_id)->value('checkin_time');
        if($db_checkin_time != null){
            return response()->json([
                'status'  => 422,
                'message' => "Already Checked In",
                'data'    => [
                    'checkin_at' => $db_checkin_time,
                ]
            ], 422); 
        }

        // Insert Data
        $res = DailyLog::create([
            'user_id'           => $user_id,
            'admin_id'          => $admin_id,
            'checkin_time'      => $checkin_time,
            'checkin_location'  => $request->lattitude.','.$request->longitude,
        ]);

        // Return Response
        return response()->json([
            'status'  => 200,
            'message' => "Checked In Successfully",
            'data'    => [
                'checkin_at' => $checkin_time,
            ]
        ], 200); 
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
