<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
    
    /**
     * 
     * List (GET /api/roles)
     */
    public function getList()
    {
        $where = [
           
        ];
        $role_list = Roles::where($where)->all();

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $role_list
        ]);
    }

    /**
     * backend
     * List (GET /api/roles)
     */
    public function index()
    {
        $where = [
        
        ];
        $roles_list = Roles::orderBy('id', 'desc')->paginate(10);
       
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $roles_list
        ]);
    }

    /**
     * detail (GET /api/role/{slug})
     */
    public function get($handle)
    {
        $where = [
            [
                'a.uri', '=', $handle
            ]
        ];
        $role = Roles::get($where);
        if (! $role) {
            return response()->json([
                'success' => false,
                'message' => 'role not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'got success',
            'data' => $role
        ]);
    }
}
