<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $table = 'order_payment';
    protected $fillable = [
        'order_id',
        'order_num',
        'paid_date',
        'payment_method',
        'currency',
        'amount',
        'status',
        'transaction_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
