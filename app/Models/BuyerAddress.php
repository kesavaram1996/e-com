<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerAddress extends Model
{
    use HasFactory;
    protected $table = 'buyer_addresses';
    protected $hidden = ['admin_id','created_at','updated_at','state_id','city_id','area_id'];
    protected $fillable = [
        'id','user_id','admin_id','name','phone','email','address','area_id','city_id','state_id','pincode','lattitude','longitude','is_default','status'
    ];

    public function getstate()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    public function getcity()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
    public function getarea()
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }
    public function getbuyer()
    {
        return $this->hasOne(Buyer::class, 'user_id', 'user_id');
    }
}
