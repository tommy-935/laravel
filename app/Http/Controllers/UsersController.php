<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;





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
     * detail (GET /api/users/{id})
     */
    public function getProfile()
    {
        $id = Auth::id();
        if(!$id){
            return response()->json([
                'success' => false,
                'message' => 'id is not empty'
            ], 422);
        }
        $user = User::select('id', 'name', 'email')->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function getUserOrder(Request $request)
    {
        $uid = Auth::id();
        $key = $request->input('key');
        if(!$uid || !$key){
            return response()->json([
                'success' => false,
                'message' => 'id is not empty'
            ], 422);
        }
        $order = Order::with([
            'orderUser:id,user_id,order_id,shipping_first_name,shipping_last_name,shipping_address1,shipping_address2,shipping_city,shipping_state,shipping_zip_code,shipping_country,shipping_phone,shipping_email,billing_address1,billing_address2,billing_city,billing_state,billing_zip_code,billing_country,billing_phone,billing_email,billing_first_name,billing_last_name',
            'orderSoftToken:id,token,order_id',
            'price:id,total,order_id',
            'products.product.productImg.attachment:id,uri',
            'products' => function ($query) {
                $query->select('id', 'product_name', 'product_id', 'price', 'qty', 'item_price', 'order_id');
            },
        ])
        ->whereHas('orderUser', function ($query) use ($uid, $key) {
            $query->where('user_id', $uid)->where('order_key', $key);
        })
        ->select('id', 'order_key', 'order_num', 'created_at', 'status')
        ->first();


        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function getUserOrders(Request $request)
    {
        $uid = Auth::id();
        if(!$uid){
            return response()->json([
                'success' => false,
                'message' => 'id is not empty'
            ], 422);
        }
        $orders = Order::with([
            'orderUser:id,user_id,order_id',
            'orderSoftToken:id,token,order_id',
            'price:id,total,order_id'
        ])
        ->whereHas('orderUser', function ($query) use ($uid) {
            $query->where('user_id', $uid);
        })
        ->select('id', 'order_key', 'order_num', 'created_at')
        ->get();


        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $orders
        ]);
    }

    public function changePassword(Request $request)
    {
        $uid = Auth::id();
        if (!$uid) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', //  new_password_confirmation
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
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
     * update (PUT/PATCH /api/users/{id})
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        $uid = Auth::id();
        if(!$uid){
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'verify failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::transaction(function () use ($request, &$user, $uid) {
            $user = User::where('id', $uid)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'user not found'
                ], 422);
            }

            $update_user = [
                'name' => $request->name,
            ];
            

            $user->update($update_user);


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