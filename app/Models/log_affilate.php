<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log_affilate extends Model
{
    use HasFactory;

    protected $table = 'log_affilate';
    protected $fillable = [
        'content',
        'des',
        'amount',
        'money_before',
        'money_change',
        'referrer_id',
        'parent_id',
    ];
}
