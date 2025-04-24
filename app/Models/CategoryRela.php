<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRela extends Model
{
    protected $table = 'cate_rela';
    
    protected $fillable = [
        'cate_id',
        'parent_id',
    ];

    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id', 'id');
    }
}
