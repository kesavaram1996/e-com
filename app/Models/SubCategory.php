<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','category_id','name','subtitle','image','status','admin_id'
    ];

    public function getcategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
