<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftToken extends Model
{
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
}
