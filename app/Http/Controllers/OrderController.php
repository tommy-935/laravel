<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request, &$product) {
            $product = Product::where('uri', Str::slug($request->uri))->first();

            if ($product) {
                return response()->json([
                    'success' => false,
                    'message' => 'product already exists'
                ], 422);
            }

            $product = Product::create([
                'name' => $request->name,
                // 'short_desc' => $request->short_desc,
                'uri' => Str::slug($request->uri),
            ]);

            $product->productCate()->create([
                'product_id' => $product->id,
                'cate_id' => $request->cate_id,
            ]);

            $product->productDetail()->create([
                'product_id' => $product->id,
                'price' => $request->price,
                'short_desc' => $request->short_desc,
                'long_desc' => '',
            ]);
            $product->productImg()->create([
                'product_id' => $product->id,
                'attachment_id' => $request->image_id,
                'is_main' => 1,
            ]);
        });
        

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product
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
