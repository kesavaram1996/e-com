<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','name','admin_id','state_id','city_id','pincode'
    ];
    public function getstate()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    public function getcity()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
