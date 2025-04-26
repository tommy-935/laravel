<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderUser extends Model
{
    protected $table = 'order_user';
    protected $fillable = [
        'order_id',
        'user_id',
        'session_id',

        'billing_country',
        'billing_state',
        'billing_city',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_address1',
        'billing_address2',
        'billing_phone',
        'billing_zip_code',

        'shipping_country',
        'shipping_state',
        'shipping_city',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_email',
        'shipping_address1',
        'shipping_address2',
        'shipping_phone',
        'shipping_zip_code'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
