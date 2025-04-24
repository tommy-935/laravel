<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_detail';
    protected $fillable = [
        'product_id',
        'price',
        'short_desc',
        'long_desc'
    ];
    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
