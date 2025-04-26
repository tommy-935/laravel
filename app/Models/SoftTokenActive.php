<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftTokenActive extends Model
{
    protected $table = 'soft_token_active';
    protected $fillable = [
        'token_id',
        'active_at',
        'created_by',
        'updated_by',
        'user_agent',
        'ip',
        'website'
    ];
    //
    public function softToken()
    {
        return $this->belongsTo(SoftToken::class);
    }
}
