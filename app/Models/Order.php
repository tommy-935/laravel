<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';
    static $_table = 'order';
    protected $fillable = [
        'order_num',
        'order_key',
        'status',
        'created_by',
        'updated_by'
    ];


    public static function getList(Array $where = [], Int $limit = 10){
        $query = DB::table(self::$_table . ' as a');
        $data = $query->select('a.*', 'b.total', 'd.payment_method', 'd.currency', 'e.shipping_country', 'e.shipping_email')
            ->leftjoin('order_price as b', 'a.id', '=', 'b.order_id')
            ->leftjoin('order_payment as d', 'a.id', '=', 'd.order_id')
            ->leftjoin('order_user as e', 'a.id', '=', 'e.order_id')
            ->where($where)
           // ->limit($limit)
            ->orderBy('a.id', 'desc')
            ->paginate($limit);
        // $sql = vsprintf(str_replace('?', "'%s'", $query->toSql()), $query->getBindings());
        // error_log(print_r($sql, true) . "\r\n", 3, 'e:/www/debug.log');
        return $data;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
        */

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

    public static function getOrderInfo($order_id){
        
        $order = Order::with([
            'products.product:id,uri', 
            'payment', 
            'price', 
            'orderUser', 
            'orderSoftToken' => function ($query) {
                $query->select('token', 'expired_at', 'order_id');
            }]
            )->where('id', $order_id)->first();
        return $order;
    }
}
