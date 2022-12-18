<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;
    protected $table = 'admin_settings';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'display_name','key','value','status','admin_id'
    ];
}
