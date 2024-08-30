<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class users extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'fullName',
        'username',
        'password',
        'email',
        'email_verified',
        'email_code',
        'mission_code',
        'phone',
        'affilate',
        'status',
        'role_id',
        'last_login',
        'is_mission',
    ];

    public function wall_user(){
        return $this->hasOne(wallet_users::class,'parent_id','id');
    }
}
