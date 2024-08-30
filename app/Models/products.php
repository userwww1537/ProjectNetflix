<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'price',
        'coin',
        'sold',
        'country',
        'description',
        'status',
        'parent_id',
        'user_id',
    ];

    public function sub_category(){
        return $this->hasOne(sub_categories::class,'id','parent_id');
    }
}
