<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log_users extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'content',
        'ip_address',
        'browser',
        'parent_id',
    ];
}
