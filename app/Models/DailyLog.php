<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    use HasFactory;
    protected $table = 'daily_logs';
    protected $hidden = ['admin_id','created_at','updated_at'];
    protected $fillable = [
        'id','user_id','admin_id','checkin_time','checkin_location','checkout_time','checkout_location'
    ];
    public function getsales()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
