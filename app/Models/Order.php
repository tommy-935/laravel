<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_num',
        'paid_date',
        'paid_type',
        'status',
        'order_num',
        'created_by',
        'updated_by'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    public function price()
    {
        return $this->hasOne(OrderPrice::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orderUser()
    {
        return $this->hasOne(OrderUser::class);
    }
}
