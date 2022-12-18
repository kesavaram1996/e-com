<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutOff extends Model
{
    use HasFactory;
    protected $table = 'cut_off';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'day','time','status','admin_id'
    ];
}
