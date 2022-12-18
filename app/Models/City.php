<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $hidden = ['admin_id','created_at','updated_at','state_id'];
    protected $fillable = [
        'id','name','admin_id','state_id'
    ];
    public function getstate()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
}
