<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_products extends Model
{
    use HasFactory;

    protected $fillable = [
        'info',
        'info_more',
        'quantity',
        'parent_id',
        'status',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function product() {
        $this->hasOne(products::class, 'id', 'parent_id');
    }
}
