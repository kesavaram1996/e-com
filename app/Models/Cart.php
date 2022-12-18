<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','user_id','admin_id','product_id','product_variant_id','quantity','price'
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => explode(",",$value)[0],
        );
    }

    public function getproduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getvariant()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }
}
