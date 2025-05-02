<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
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
     * Add / Update (POST /api/users)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request, &$user) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                return response()->json([
                    'success' => false,
                    'message' => 'user already exists'
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->userRoles()->create([
                'user_id' => $user->id,
                'role_id' => $request->role_id,
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
        
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $user_list
        ]);
    }

    /**
     * detail (GET /api/users/{id})
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
     * update (PUT/PATCH /api/users/{id})
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request, &$user) {
            $user = User::where('id', $request->id)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'user not found'
                ], 422);
            }

            $update_user = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if($request->password){
                $update_user['password'] = $request->password;
            }

            $user->update($update_user);

            $user->userRoles()->delete();
            $user->userRoles()->create([
                'user_id' => $user->id,
                'role_id' => $request->role_id,
            ]);

        });
        

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $user
        ], 201);
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
            $user->userRoles()->delete();
            $user->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'user deleted'
        ]);
    }
}