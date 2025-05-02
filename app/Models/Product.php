<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'product';
    static $_table = 'product';

    protected $fillable = [
        'name',
        'uri'
    ];
    // app/Models/Product.php
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public static function getList(Array $where = [], Int $limit = 10){
        $query = DB::table(self::$_table . ' as a');
        $data = $query->select('a.*', 'b.cate_id', 'c.cate_name as category', 'd.price', 'd.short_desc', 'd.long_desc', 'f.uri as image', 'f.name as img_name')
            ->leftjoin('product_cate_rela as b', 'a.id', '=', 'b.product_id')
            ->leftjoin('product_detail as d', 'a.id', '=', 'd.product_id')
            ->leftjoin('product_img as e', 'a.id', '=', 'e.product_id')
            ->leftjoin('attachment as f', 'f.id', '=', 'e.attachment_id')
            ->leftjoin('cate as c', 'b.cate_id', '=', 'c.id')
            ->where($where)
           // ->limit($limit)
            ->orderBy('a.id', 'desc')
            ->paginate($limit);
        // $sql = vsprintf(str_replace('?', "'%s'", $query->toSql()), $query->getBindings());
        // error_log(print_r($sql, true) . "\r\n", 3, 'e:/www/debug.log');
        return $data;
    }

    public static function get(Array $where = []){
        $query = DB::table(self::$_table . ' as a');
        return $query->select('a.*', 'b.cate_id', 'c.cate_name', 'd.price', 'd.short_desc', 'd.long_desc', 'f.uri as img_uri', 'f.name as img_name')
            ->leftjoin('product_cate_rela as b', 'a.id', '=', 'b.product_id')
            ->leftjoin('product_detail as d', 'a.id', '=', 'd.product_id')
            ->leftjoin('product_img as e', 'a.id', '=', 'e.product_id')
            ->leftjoin('attachment as f', 'f.id', '=', 'e.attachment_id')
            ->leftjoin('cate as c', 'b.cate_id', '=', 'c.id')
            ->where($where)
            ->first();
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id');
    }

    public function productImg()
    {
        return $this->hasMany(ProductImg::class, 'product_id', 'id');
    }

    public function productCate()
    {
        return $this->hasMany(ProductCate::class, 'product_id', 'id');
    }
}
