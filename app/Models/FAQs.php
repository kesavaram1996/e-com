<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQs extends Model
{
    use HasFactory;
    protected $table = 'faqs';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','admin_id','question','answer','status'
    ];
}
