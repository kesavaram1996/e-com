<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table = 'states';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','name','admin_id'
    ];
}
