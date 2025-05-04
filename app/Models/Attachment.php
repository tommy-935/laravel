<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachment';

    
    protected $fillable = [
        'name',
        'uri',
        'type'
    ];

    public function productImg()
    {
        return $this->hasMany(ProductImg::class, 'attachment_id', 'id');
    }
}