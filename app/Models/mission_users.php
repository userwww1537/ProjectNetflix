<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mission_users extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'parent_id',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
