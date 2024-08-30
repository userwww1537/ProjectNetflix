<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wallet_users extends Model
{
    use HasFactory;

    protected $fillable = [
        'money',
        'total',
        'coin',
        'parent_id'
    ];
}
