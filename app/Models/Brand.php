<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','name','image','status','admin_id'
    ];
}
