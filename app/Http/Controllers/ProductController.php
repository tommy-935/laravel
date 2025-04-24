<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
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
        $product_list = Product::getList($where);
        $product_list->transform(function ($product) {
            $product->image = $product->image ? Storage::url($product->image) : null;
            return $product;
        });

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product_list
        ]);
    }

    /**
     * detail (GET /api/product/{slug})
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
     * Add / Update (POST /api/categories)
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
     * List (GET /api/categories)
     */
    public function index()
    {
        $where = [
        
        ];
        $product_list = Product::getList($where, 2);
        $product_list->transform(function ($product) {
            $product->img_uri = $product->image ? Storage::url($product->image) : null;
            return $product;
        });
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product_list
        ]);
    }

    /**
     * detail (GET /api/product/{id})
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'got success',
            'data' => $product
        ]);
    }

    /**
     * update (PUT/PATCH /api/categories/{id})
     */
    public function update(Request $request, $id)
    {
        $category = Product::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'update success',
            'data' => $category
        ]);
    }

    /**
     * delete (DELETE /api/categories/{id})
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'product not found'
            ], 404);
        }

        DB::transaction(function () use ($product) {
            $product->productDetail()->delete();
            $product->productImg()->delete();       
            $product->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'product deleted'
        ]);
    }
}