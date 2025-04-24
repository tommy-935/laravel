<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachment';

    const CREATED_AT = 'added_date';
    const UPDATED_AT = 'updated_date';
    
    protected $fillable = [
        'name',
        'uri',
        'type'
    ];
}