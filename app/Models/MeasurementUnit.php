<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    use HasFactory;
    protected $table = 'measurement_units';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = [
        'id','measurement_unit'
    ];
}
