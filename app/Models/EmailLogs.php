<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLogs extends Model
{
    //
    protected $fillable = [
        'email',
        'subject',
        'body',
        'status',
        'created_by',
        'updated_by'
    ];
}
