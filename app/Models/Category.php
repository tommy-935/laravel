<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $table = 'cate';

    protected $fillable = [
        'cate_name',
        'slug',
        'desc',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];


    public function products(): HasMany
    {
        return $this->hasMany(ProductCate::class, 'cate_id', 'id');
    }

    public function categoryRela(): HasOne
    {
        return $this->hasOne(CategoryRela::class, 'cate_id', 'id');
    }
}