<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notify extends Model
{
    use HasFactory;

    protected $table = 'notify';

    protected $fillable = [
        'title',
        'body',
        'status',
        'parent_id',
        'created_at',
        'updated_at'
    ];
}
