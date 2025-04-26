<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPrice extends Model
{
    protected $table = 'order_price';
    protected $fillable = [
        'order_id',
        'discount_price',
        'total',
        'sub_total',
        'tax',
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
