<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCode;
use Yajra\DataTables\DataTables;

class PromoCodeController extends Controller
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
            $data =  $data = PromoCode::where('admin_id',$user_id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
                        // $btns .= '<a href="' . route('areas.show', $row->id) . '" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="' . route('promo_codes.edit', $row->id) . '" class="" title="View"><i class="fa-solid fa-pen-to-square"></i></a>';
                        return $btns;
                    })
                    ->editColumn('start_date', function($data){
                        return date('d-m-Y', strtotime($data->start_date));
                    }) 
                    ->editColumn('end_date', function($data){
                        return date('d-m-Y', strtotime($data->end_date));
                    }) 
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.promo_codes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promo_codes.create');
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
            'promo_code'            => 'required',
            'message'               => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
            'no_of_users'           => 'required',
            'minimum_order_amount'  => 'required',
            'discount'              => 'required',
            'discount_type'         => 'required',
            'max_discount_amount'      => 'required',
            'repeat_usage'          => 'required',
            'status'                => 'required',
        ],
        [
            'promo_code.required' => 'Promo Code field is required',
            'message.required' => 'Message field is required',
            'start_date.required' => 'Start Date field is required',
            'end_date.required' => 'End Date field is required',
            'no_of_users.required' => 'No of Users field is required',
            'minimum_order_amount.required' => 'Minimum Order Amount field is required',
            'discount.required' => 'Discount field is required',
            'discount_type.required' => 'Discount Type field is required',
            'max_discount_amount.required' => 'Max Discount Amount field is required',
            'repeat_usage.required' => 'Repeat Usage field is required',
            'status.required' => 'Status field is required',            
        ]);

        $admin_id = auth()->user()->id;

        $res = PromoCode::create([
            'admin_id'              => $admin_id,
            'promo_code'            => $request->promo_code,
            'message'               => $request->message,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'no_of_users'           => $request->no_of_users,
            'minimum_order_amount'  => $request->minimum_order_amount,
            'discount'              => $request->discount,
            'discount_type'         => $request->discount_type,
            'max_discount_amount'   => $request->max_discount_amount,
            'repeat_usage'          => $request->repeat_usage,
            'no_of_repeat_usage'    => $request->no_of_repeat_usage,
            'status'                => $request->status,
        ]);
        flash()->addSuccess('Promo Code Created Successfully!');
        return redirect()->route('promo_codes.index');
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
        $data = PromoCode::where('id',$id)->get();
        return view('admin.promo_codes.edit',compact('data'));
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
            'promo_code'            => 'required',
            'message'               => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
            'no_of_users'           => 'required',
            'minimum_order_amount'  => 'required',
            'discount'              => 'required',
            'discount_type'         => 'required',
            'max_discount_amount'      => 'required',
            'repeat_usage'          => 'required',
            'status'                => 'required',
        ],
        [
            'promo_code.required' => 'Promo Code field is required',
            'message.required' => 'Message field is required',
            'start_date.required' => 'Start Date field is required',
            'end_date.required' => 'End Date field is required',
            'no_of_users.required' => 'No of Users field is required',
            'minimum_order_amount.required' => 'Minimum Order Amount field is required',
            'discount.required' => 'Discount field is required',
            'discount_type.required' => 'Discount Type field is required',
            'max_discount_amount.required' => 'Max Discount Amount field is required',
            'repeat_usage.required' => 'Repeat Usage field is required',
            'status.required' => 'Status field is required',            
        ]);

        $admin_id = auth()->user()->id;

        $res = PromoCode::where('id',$id)->update([
            'promo_code'            => $request->promo_code,
            'message'               => $request->message,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'no_of_users'           => $request->no_of_users,
            'minimum_order_amount'  => $request->minimum_order_amount,
            'discount'              => $request->discount,
            'discount_type'         => $request->discount_type,
            'max_discount_amount'   => $request->max_discount_amount,
            'repeat_usage'          => $request->repeat_usage,
            'no_of_repeat_usage'    => $request->no_of_repeat_usage,
            'status'                => $request->status,
        ]);
        flash()->addSuccess('Promo Code Updated Successfully!');
        return redirect()->route('promo_codes.index');
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
