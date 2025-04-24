<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * List (GET /api/categories)
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Add / Update (POST /api/categories)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cate_name' => 'required|string|max:255|unique:cate',
            'desc' => 'nullable|string',
            'slug' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request, &$category) {

            $category = Category::create([
                'cate_name' => $request->cate_name,
                'desc' => '',
                'slug' => Str::slug($request->slug),
            ]);

            if(! $request->id){
                $category->categoryRela()->create([
                    'cate_id' => $category->id,
                    'parent_id' => 0,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $category
        ], 201);
    }

    /**
     * detail (GET /api/categories/{id})
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'got success',
            'data' => $category
        ]);
    }

    /**
     * update (PUT/PATCH /api/categories/{id})
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'cate_name' => 'required|string|max:255'.$category->id,
            'desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $category->update([
            'cate_name' => $request->cate_name,
            'desc' => '',
            'slug' => Str::slug($request->slug),
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
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }

        if ($category->products()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'category has products, cannot delete'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'category deleted'
        ]);
    }
}