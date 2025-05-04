<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    protected $table = 'product_img';
    protected $fillable = [
        'product_id',
        'attachment_id',
        'is_main'
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }
}
