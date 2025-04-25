<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_num',
        'order_key',
        'status',
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

    public function orderSoftToken()
    {
        return $this->hasOne(SoftToken::class);
    }

    public function getCheckoutOrderInfo($order_key){
        $data = DB::table('order as a')
        ->select(['a.id', 'a.order_key', 'a.status', 'a.created_at', 'a.order_num', 'b.payment_type', 'c.total_price', 
            'd.*', 'e.*', 'f.token', 'f.website_num', 'f.expired_at'])
        ->leftjoin('order_payment as b', 'a.id', '=', 'b.order_id')
        ->leftjoin('order_price as c', 'a.id', '=', 'c.order_id')
        ->leftjoin('order_user as d', 'a.id', '=', 'd.order_id')
        ->leftjoin('order_product as e','a.id', '=','e.order_id')
        ->leftjoin('soft_token as f','a.id', '=','f.order_id')
        ->where('a.order_key', $order_key)
        ->get();
        return $data;
    }

    public function getOrderInfo($order_id){
        $data = DB::table('order as a')
        ->select(['a.id', 'a.order_key', 'a.status', 'a.created_at', 'a.order_num', 'b.payment_type', 'c.total_price', 
            'd.*', 'e.*', 'f.token', 'f.website_num', 'f.expired_at'])
        ->leftjoin('order_payment as b', 'a.id', '=', 'b.order_id')
        ->leftjoin('order_price as c', 'a.id', '=', 'c.order_id')
        ->leftjoin('order_user as d', 'a.id', '=', 'd.order_id')
        ->leftjoin('order_product as e','a.id', '=','e.order_id')
        ->leftjoin('soft_token as f','a.id', '=','f.order_id')
        ->where('a.id', $order_id)
        ->get();
        return $data;
    }
}
