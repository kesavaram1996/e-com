<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $table = 'order_statuses';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'order_id','admin_id','status'
    ];
}
