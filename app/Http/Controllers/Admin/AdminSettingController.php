<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminSetting;
use App\Models\CutOff;

class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $delivery_data = AdminSetting::where('admin_id',$user_id)->where('display_name','delivery_charge')->get();
        $cut_off_data = AdminSetting::where('admin_id',$user_id)->where('display_name','cut_off')->get();
        $cut_off_time = CutOff::where('admin_id',$user_id)->get();
        return view('admin.admin_settings.index',compact('delivery_data','cut_off_data','cut_off_time'));
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
        // dd($request);
        // Delivery Charge
            $user_id = auth()->user()->id;
            if($request->delivery_charge==0){
                $res = AdminSetting::where('admin_id',$user_id)->where('display_name','delivery_charge')->update([
                    'status' => $request->delivery_charge,
                ]);
            }elseif($request->delivery_charge==1){
                AdminSetting::where('admin_id',$user_id)->where('display_name','delivery_charge')->update([
                    'status'    => $request->delivery_charge,
                    'key'       => $request->delivery_charge_type,
                    'value'     => $request->amount,
                ]);
            }

        // Cut Off
            if($request->cut_off==0){
                $res = AdminSetting::where('admin_id',$user_id)->where('display_name','cut_off')->update([
                    'status' => $request->cut_off,
                ]);
            }elseif($request->cut_off==1){
                AdminSetting::where('admin_id',$user_id)->where('display_name','cut_off')->update([
                    'status'    => $request->cut_off,
                ]);

                // Check Exist or not
                $cut_off_res = CutOff::where('admin_id',$user_id)->get();

                // Already Exists
                if(!blank($cut_off_res)){
                    CutOff::where('admin_id',$user_id)->where('day','monday')->update([
                        'time' => $request->day[0],
                    ]);
                    CutOff::where('admin_id',$user_id)->where('day','tuesday')->update([
                        'time' => $request->day[1],
                    ]);
                    CutOff::where('admin_id',$user_id)->where('day','wednesday')->update([
                        'time' => $request->day[2],
                    ]);
                    CutOff::where('admin_id',$user_id)->where('day','thursday')->update([
                        'time' => $request->day[3],
                    ]);
                    CutOff::where('admin_id',$user_id)->where('day','friday')->update([
                        'time' => $request->day[4],
                    ]);
                    CutOff::where('admin_id',$user_id)->where('day','saturday')->update([
                        'time' => $request->day[5],
                    ]);
                    CutOff::where('admin_id',$user_id)->where('day','sunday')->update([
                        'time' => $request->day[6],
                    ]);
                }else{  // Not Exist (Create New)
                    $weekdays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                    foreach($request->day as $key => $days){
                        CutOff::create([
                            'admin_id' => $user_id,
                            'day' => $weekdays[$key],
                            'time' => $days,
                            'status' =>1,
                        ]);
                    }
                }
            }

            flash()->addSuccess('Settings Updated Successfully!');
            return redirect()->route('admin_settings.index');
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
