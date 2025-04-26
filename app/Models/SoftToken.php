<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftToken extends Model
{
    protected $table = 'soft_token';
    protected $fillable = [
        'token',
        'expired_at',
        'created_by',
        'updated_by',
        'website_num',
        'email'
    ];
    
    //
    public function softTokenActive(){
        return $this->hasOne(SoftTokenActive::class, 'soft_token_id', 'id');
    }

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
