<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceSlab extends Model
{
    use HasFactory;
    protected $table = 'price_slabs';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','title','status','admin_id'
    ];
}
