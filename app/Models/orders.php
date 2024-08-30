<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'product_id',
        'payment_method',
        'information',
        'info_more',
        'status',
        'price',
        'coin',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'parent_id');
    }

    public function product(){
        return $this->hasOne(products::class, 'id', 'product_id');
    }
}
