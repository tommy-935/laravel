<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCate extends Model
{
    protected $table = 'product_cate_rela';

    protected $fillable = [
        'product_id',
        'cate_id',
    ];
    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
