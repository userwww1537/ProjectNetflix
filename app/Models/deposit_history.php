<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deposit_history extends Model
{
    use HasFactory;

    protected $table = 'deposit_history';

    protected $fillable = [
        'parent_id',
        'amount',
        'actually_received',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
}
