<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    use HasFactory;
    protected $table = 'sales_persons';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','admin_id','user_id','name','phone','email','state_id','city_id','area_id','address','pincode','latitute','longitude'
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
    public function getslab()
    {
        return $this->hasOne(PriceSlab::class, 'id', 'slab_id');
    }
    public function getuser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
