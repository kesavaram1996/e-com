<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','name','subtitle','image','status','admin_id'
    ];
}
