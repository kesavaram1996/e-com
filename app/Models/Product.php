<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

    use HasFactory;

    protected $table = 'products';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','admin_id','name','category_id','sub_category_id','brand_id','indicator','pimage','gimage','description','sgst','cgst','igst','min_stock','min_stock_notified','status','hsn_code'
    ];

    public function getvariant()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function getcategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getsubcategory()
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }
}
