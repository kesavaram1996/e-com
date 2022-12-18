<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = 'product_variants';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = [
        'id','admin_id','product_id','type','measurement','measurement_unit_id','price','min_qty','serve_for','stock','stock_unit_id'
    ];

    // protected function price(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => explode(",",$value)[0],
    //     );
    // }

    public function getproduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getmeasurementunit()
    {
        return $this->hasOne(MeasurementUnit::class, 'id', 'measurement_unit_id');
    }
    

}
