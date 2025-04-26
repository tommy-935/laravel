<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'product_name',
        'price',
        'item_price'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
