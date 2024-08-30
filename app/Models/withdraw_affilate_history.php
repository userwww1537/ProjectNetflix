<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class withdraw_affilate_history extends Model
{
    use HasFactory;
    
    protected $table = 'withdraw_affilate_history';
    protected $fillable = [
        'amount',
        'bank_info',
        'stk',
        'name_info',
        'status',
        'parent_id',
        'created_at',
        'updated_at',
    ];
}
