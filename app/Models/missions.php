<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class missions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'reward',
        'type',
        'link',
        'status',
        'view',
        'parent_id',
        'created_at',
        'updated_at'
    ];
}
