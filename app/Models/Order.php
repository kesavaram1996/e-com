<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id',
        'user_id',
        'admin_id',
        'order_by',
        'address_id',
        'delivery_boy_id',
        'total',
        'delivery_charge',
        'tax_amount',
        'tax_percentage',
        'wallet_balance',
        'credit_balance',
        'credit_paid',
        'credit_available',
        'credit_paid_date',
        'discount',
        'promo_code',
        'promo_discount',
        'final_total',
        'payment_method',
        'lattitude',
        'longitude',
        'delivery_time',
        'status',
        'active_status',
        'invoice_type'
    ];

    public function getorderitem()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function getuser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getorderbyuser()
    {
        return $this->hasOne(User::class, 'id', 'order_by');
    }

    public function getaddress()
    {
        return $this->hasOne(BuyerAddress::class, 'user_id', 'user_id');
    }

    public function getslab()
    {
        return $this->hasOne(Buyer::class, 'user_id', 'user_id');
    }
    public function getstatuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id', 'id');
    }
}
