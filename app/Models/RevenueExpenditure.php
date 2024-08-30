<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueExpenditure extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function treasury(){
        return $this->belongsTo(Treasury::class, 'parent_id', 'id');
    }
}
