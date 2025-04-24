<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPrice extends Model
{
    protected $fillable = [
        'order_id',
        'discount_price',
        'total',
        'sub_total',
        'tax',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
