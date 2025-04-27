<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
{
    /**
     * 
     * List (GET /api/users)
     */
    public function getList(String $slug = '')
    {
        $where = [
            [
                'c.slug', '=', $slug
            ]
        ];
        $user_list = User::getList($where);
        $user_list->transform(function ($user) {
            $user->image = $user->image ? Storage::url($user->image) : null;
            return $user;
        });

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $user_list
        ]);
    }

    /**
     * detail (GET /api/user/{slug})
     */
    public function get($handle)
    {
        $where = [
            [
                'a.uri', '=', $handle
            ]
        ];
        $user = User::get($where);
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 404);
        }

        $user->images = [$user->img_uri ? Storage::url($user->img_uri) : null];
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'got success',
            'data' => $user
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

        DB::transaction(function () use ($request, &$user) {
            $user = User::where('uri', Str::slug($request->uri))->first();

            if ($user) {
                return response()->json([
                    'success' => false,
                    'message' => 'user already exists'
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                // 'short_desc' => $request->short_desc,
                'uri' => Str::slug($request->uri),
            ]);

            $user->userCate()->create([
                'user_id' => $user->id,
                'cate_id' => $request->cate_id,
            ]);

            $user->userDetail()->create([
                'user_id' => $user->id,
                'price' => $request->price,
                'short_desc' => $request->short_desc,
                'long_desc' => '',
            ]);
            $user->userImg()->create([
                'user_id' => $user->id,
                'attachment_id' => $request->image_id,
                'is_main' => 1,
            ]);
        });
        

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $user
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
        $user_list = User::getList($where, 2);
        $user_list->transform(function ($user) {
            $user->img_uri = $user->image ? Storage::url($user->image) : null;
            return $user;
        });
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $user_list
        ]);
    }

    /**
     * detail (GET /api/user/{id})
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'got success',
            'data' => $user
        ]);
    }

    /**
     * update (PUT/PATCH /api/categories/{id})
     */
    public function update(Request $request, $id)
    {
        $category = User::find($id);

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
     * delete (DELETE /api/user/{id})
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 404);
        }

        DB::transaction(function () use ($user) {
            $user->userDetail()->delete();
            $user->userImg()->delete();       
            $user->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'user deleted'
        ]);
    }
}