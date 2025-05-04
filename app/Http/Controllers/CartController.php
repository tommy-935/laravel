<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CartController extends Controller
{
    use AuthorizesRequests;
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartUuid = $request->cookie('hash_uuid');

        // 如果不存在，则创建新购物车并设置 Cookie
        if (! $cartUuid) {
            $cartUuid = Str::uuid();
            // $cart = CartItem::create(['' => $cartUuid]);
            // cookie('hash_uuid', $cartUuid, 60 * 24 * 30); // 30天有效期
            Cookie::queue('hash_uuid', $cartUuid, 60 * 24 * 30);

        }

        $item_key = Str::uuid();

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
           
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $uid = Auth::id() ? Auth::id() : 0;
            CartItem::create([
                'session_id' => $cartUuid,
                'item_key' => $item_key,
                'user_id' => $uid,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => []
        ]);
    }

   
    public function viewCart(Request $request)
    {
        // 尝试从 Cookie 获取购物车 UUID
        $cartUuid = $request->cookie('hash_uuid');

        // 如果不存在，则创建新购物车并设置 Cookie
        if (! $cartUuid) {
            /*
            $cartUuid = Str::uuid();
            $cart = CartItem::create(['session_id' => $cartUuid]);
            return $cart->load('items')->withCookie(cookie('hash_uuid', $cartUuid, 60 * 24 * 30)); // 30天有效期
            */
            return response()->json([
                'success' => false,
                'message' => 'Empty Cart',
                'data' => ''
            ]);
        }

        $uid = Auth::id() ? Auth::id() : 0;
        $query = CartItem::with('product.productImg.attachment:id,uri')
            ->leftjoin('product_detail', 'cart_items.product_id', '=', 'product_detail.product_id');
        
        if($uid){
            $cartItems = $query->where('user_id', $uid)
            ->get();
        }else{
            $cartItems = $query->where('session_id', $cartUuid)
            ->get();
        }
           
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $data = compact('cartItems', 'total');

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $data
        ]);
    }

   
    public function updateCart(Request $request)
    {
        $request->validate([
            'item_key' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);

        $item_key = $request->item_key;
        if(!$item_key){
            return response()->json([
                'success' => false,
                'message' => 'Item key is required',
                'data' => []
            ]);
        }
        // update cart item quantity
        $cartItem = CartItem::where('item_key', $item_key)->first();    
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
                'data' => []
            ]);
        }
        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => []
        ]);
    }

    
    public function removeFromCart(Request $request)
    {
        
        $item_key = $request->item_key;
        if(!$item_key){
            return response()->json([
                'success' => false,
                'message' => 'Item key is required',
                'data' => []
            ]);
        }
        // delete cart item
        $cartItem = CartItem::where('item_key', $item_key)->first();    
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
                'data' => []
            ]);
        }
        $cartItem->delete();


        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => []
        ]);
    }
}