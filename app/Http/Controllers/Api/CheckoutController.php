<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\PromoCode;
use App\Models\BuyerAddress;
use Carbon\Carbon;
use Validator;
use App\Models\DailyLog;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $promo_code = $request->promo_code;
        $address = $request->address_id;
        $user = $request->user_id;
        $delivery_address = '';

        $user_id = auth()->user()->id;
        $result = Cart::query()
                ->with(['getproduct' => function ($query) {$query->select('id','name','cgst','sgst','igst');}])->where('user_id',$user_id)->get();
        $data = [];
        $total = 0;

        foreach($result as $key => $results){
            $data[$key]['name'] = $results->getproduct->name;
            $data[$key]['quantity'] = $results->quantity;
            $data[$key]['price'] = $results->price;
            // CGST
            $cgst_amount = $results->price * ($results->getproduct->cgst/100);
            $data[$key]['cgst'] = $results->getproduct->cgst;
            $data[$key]['cgst_amount'] = $cgst_amount;
            // SGST
            $sgst_amount = $results->price * ($results->getproduct->sgst/100);
            $data[$key]['sgst'] = $results->getproduct->sgst;
            $data[$key]['sgst_amount'] = $sgst_amount;
            // IGST
            $igst_amount = $results->price * ($results->getproduct->igst/100);
            $data[$key]['igst'] = $results->getproduct->igst;
            $data[$key]['igst_amount'] = $igst_amount;
            // Sub Total
            $sub_total = $results->price + $cgst_amount + $sgst_amount + $igst_amount;
            $data[$key]['sub_total'] = $sub_total;
            $total = $total + $data[$key]['sub_total'];
        }

        if(!blank($address)){
            $delivery_address = BuyerAddress::with('getstate','getcity','getarea')->select('name','phone','address','pincode','state_id','city_id','area_id')->where('id',$address)->get();
        }else{
            $delivery_address = BuyerAddress::with('getstate','getcity','getarea')->select('name','phone','address','pincode','state_id','city_id','area_id')->where('user_id',$user)->where('is_default',1)->get();
        }
        
        if(!blank($promo_code)){
            $res_promo_code = PromoCode::where('promo_code',$promo_code)->where('status','active')->value('promo_code');
            if(!blank($res_promo_code)){
                $min_order_amount = PromoCode::where('promo_code',$promo_code)->value('minimum_order_amount');
                if($total >= $min_order_amount){
                    $no_of_users = PromoCode::where('promo_code',$promo_code)->value('no_of_users');
                    $no_of_users_used = PromoCode::where('promo_code',$promo_code)->value('no_of_users_used');
                    if($no_of_users_used < $no_of_users){
                        $end_date = PromoCode::where('promo_code',$promo_code)->value('end_date');
                        $current_date = Carbon::now();
                        if ($end_date >= $current_date) {
                            $discount_type = PromoCode::where('promo_code',$promo_code)->value('discount_type');
                            $discount = PromoCode::where('promo_code',$promo_code)->value('discount');
                            $max_discount_amount = PromoCode::where('promo_code',$promo_code)->value('max_discount_amount');
                            if($discount_type=='percentage'){
                                $discount_amount = $total * ($discount/100);
                                $total = $total - $discount_amount;
                                if($discount_amount < $max_discount_amount){
                                    return response()->json([
                                        'status'  => 200,
                                        'message' => "Checkout List",
                                        'data'    => [
                                            'delivery_address'      => $delivery_address,
                                            'order summary'         => $data,
                                            'promo code discount'   => $discount_amount,
                                            'total'                 => $total,
                                        ],
                                    ], 200); 
                                }else{
                                    $discount_amount = $max_discount_amount;
                                    $total = $total - $discount_amount;
                                    return response()->json([
                                        'status'  => 200,
                                        'message' => "Checkout List",
                                        'data'    => [
                                            'delivery_address'      => $delivery_address,
                                            'order summary'         => $data,
                                            'promo code discount'   => $discount_amount,
                                            'total'                 => $total,
                                        ],
                                    ], 200);
                                }
                            }elseif($discount_type=='amount'){
                                $total = $total - $discount;
                                return response()->json([
                                    'status'  => 200,
                                    'message' => "Checkout List",
                                    'data'    => [
                                        'delivery_address'      => $delivery_address,
                                        'order summary'         => $data,
                                        'promo code discount'   => $discount,
                                        'total'                 => $total,
                                    ],
                                ], 200); 
                            }
                          } else {
                            return response()->json([
                                'status'  => 419,
                                'message' => "Promo Code Expired",
                                'data'    => "Nil"
                            ], 419);
                          }
                    }else{
                        return response()->json([
                            'status'  => 419,
                            'message' => "Promo Code Expired",
                            'data'    => "Nil"
                        ], 419);
                    }
                }else{
                    return response()->json([
                        'status'  => 400,
                        'message' => "Not Eligible for this amount. min order amount is: " . $min_order_amount,
                        'data'    => "Nil"
                    ], 400);
                }
            }else{
                return response()->json([
                    'status'  => 400,
                    'message' => "Invalid Promo Code",
                    'data'    => "Nil"
                ], 400);
            }
        }
        

        if(!blank($data)){
            return response()->json([
                'status'  => 200,
                'message' => "Checkout List",
                'data'    => [
                    'delivery_address'      => $delivery_address,
                    'order summary'         => $data,
                    'total'                 => $total,
                ],
            ], 200); 
        }else{
            return response()->json([
                'status'  => 400,
                'message' => "Checkout List Not Found",
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
        $validator = Validator::make($request->all(), [
            'lattitude'     => 'required',
            'longitude'     => 'required',
            // 'checkout_at'    => 'required',
        ],
        [
            'lattitude.required'    => 'lattitude Field is Required',
            'longitude.required'    => 'longitude Field is Required',
            // 'checkout_at.required'   => 'checkin_at Field is Required',
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
        $checkout_time = Carbon::now();

        // checkin Validation
        $db_checkin_time = DailyLog::whereDate('checkin_time', Carbon::today())->where('user_id',$user_id)->value('checkin_time');
        if($db_checkin_time == null){
            return response()->json([
                'status'  => 422,
                'message' => "Please Checkin",
                'data'    => "Nil"
            ], 422); 
        }

        // checkin Validation
        $db_checkout_time = DailyLog::whereDate('checkout_time', Carbon::today())->where('user_id',$user_id)->value('checkout_time');
        if($db_checkout_time != null){
            return response()->json([
                'status'  => 422,
                'message' => "Already Checked out",
                'data'    => [
                    'checkout_at' => $db_checkout_time
                ]
            ], 422); 
        }

        // dd($checkin_time);
        // Insert Data
        $res = DailyLog::whereDate('checkin_time', Carbon::today())->where('user_id',$user_id)->update([
            'checkout_time'      => $checkout_time,
            'checkout_location'  => $request->lattitude.','.$request->longitude,
        ]);

        // Return Response
        return response()->json([
            'status'  => 200,
            'message' => "Checked Out Successfully",
            'data'    => "Nil"
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
