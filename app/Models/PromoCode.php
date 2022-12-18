<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;
    protected $table = 'promo_codes';
    protected $hidden = ['created_at','updated_at'];
    protected $dates = ['start_date','end_date'];
    protected $fillable = [
        'id','admin_id','message','promo_code','start_date','end_date','no_of_users','minimum_order_amount','discount','discount_type','max_discount_amount','status','repeat_usage','no_of_repeat_usage'
    ];
}
