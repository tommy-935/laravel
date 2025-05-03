<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * 
     * List (GET /api/products)
     */
    public function getList(String $slug = '')
    {
        $where = [
            [
                'c.slug', '=', $slug
            ]
        ];
        $product_list = Order::getList($where);
    

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product_list
        ]);
    }

    /**
     * frontend
     * detail (GET /api/order/{slug})
     */
    public function get($handle)
    {
        $where = [
            [
                'a.uri', '=', $handle
            ]
        ];
        $product = Product::get($where);
        $product->images = [$product->img_uri ? Storage::url($product->img_uri) : null];
        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'got success',
            'data' => $product
        ]);
    }

    /**
     * Add / Update (POST /api/order)
     */
    public function store(Request $request)
    {
        
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'order not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try{
            DB::transaction(function () use ($request, &$order) {
                $order->update([
                    'status' => $request->status, 
                ]);
                $billing_address = $request->billing_address;
                $shipping_address = $request->shipping_address;
                $order->orderUser()->update([
                    
                    'billing_country' => $billing_address['country'],
                    'billing_state' => $billing_address['state'],
                    'billing_city' => $billing_address['city'],
                    'billing_first_name' => $billing_address['first_name'],
                    'billing_last_name' => $billing_address['last_name'],
                    'billing_email' => $billing_address['email'],
                    'billing_address1' => $billing_address['address1'],
                    'billing_address2' => $billing_address['address2'],
                    'billing_phone' => $billing_address['phone'],
                    'billing_zip_code' => $billing_address['phone'],
    
                    'shipping_first_name' => $shipping_address['first_name'],
                    'shipping_last_name' => $shipping_address['last_name'],
                    'shipping_email' => $shipping_address['email'],
                    'shipping_address1' => $shipping_address['address1'],
                    'shipping_address2' => $shipping_address['address2'],
                    'shipping_city' => $shipping_address['city'],
                    'shipping_state' => $shipping_address['state'],
                    'shipping_country' => $shipping_address['country'],
                    'shipping_phone' => $shipping_address['phone'],
                    'shipping_zip_code' => $shipping_address['zip_code'],
                ]);
            });
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'update failed',
                'errors' => $e->getMessage()
            ], 422);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $order
        ], 201);
    }

    /**
     * backend
     * List (GET /api/order)
     */
    public function index()
    {
        $where = [
        
        ];
        $order_list = Order::getList($where, 10);
        
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $order_list
        ]);
    }

    /**
     * backend
     * detail (GET /api/order/{id})
     */
    public function show($id)
    {
        $order = Order::getOrderInfo($id);

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'got success',
            'data' => $order
        ]);
    }


    /**
     * delete (DELETE /api/order/{id})
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'order not found'
            ], 404);
        }

        DB::transaction(function () use ($order) {
            $order->price()->delete();
            $order->payment()->delete();    
            $order->products()->delete();   
            $order->orderUser()->delete();
            $order->orderSoftToken()->delete();      
            $order->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'order deleted'
        ]);
    }
}
