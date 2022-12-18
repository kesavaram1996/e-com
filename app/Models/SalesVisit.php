<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesVisit extends Model
{
    use HasFactory;
    protected $table = 'sales_visits';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','user_id','admin_id','order_by','order_status','order_id','lattitude','longitude'
    ];
    public function getuser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function getbuyer()
    {
        return $this->hasOne(Buyer::class, 'user_id', 'user_id');
    }
}
