<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id',
        'user_id',
        'admin_id',
        'order_id',
        'product_variant_id',
        'quantity',
        'price',
        'sgst',
        'cgst',
        'igst',
        'hsn_code',
        'discounted_price',
        'discount',
        'sub_total',
        'deliver_by',
        'status',
        'active_status',
    ];

    public function getorderproductvariant()
    {
        return $this->hasOne(ProductVariant::class, 'id', 'product_variant_id');
    }
}
