<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SoftToken;
use App\Models\SoftTokenActive;

class LicenseController extends Controller
{
    //
    public function verify(Request $request){
        $now = Carbon::now()->toDateTimeString();
        $license = $request->license;
        $soft_name = $request->soft_name;
        $website = $request->website;
        if($license == ''){
            return response()->json([
                'success' => false,
                'message' => 'license is required',
                'data' => []
            ]);
        }
        if($token_data = SoftToken::where('token', $license)
            ->where('expired_at', '>', $now)
            ->where('soft_name', '=', $soft_name)
            ->get()){
            return response()->json([
                'success' => false,
                'message' => 'license is invalid',
                'data' => []
            ]);
        }
        try{
            SoftTokenActive::create([
                'soft_token_id' => $token_data->id,
                'website' => $website,
                'active_at' => $now,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed to create soft token active',
                'data' => []
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => [
                'soft_name' => $soft_name,
                'active_at' => $now,
                'ip' => $request->ip(),
                'user_agent'=> $request->userAgent(),
            ]
            ]);    
    }

    public function check(Request $request){
        $now = Carbon::now()->toDateTimeString();
        $license = $request->license;
        $soft_name = $request->soft_name;
        $website = $request->website;
        if($license == ''){
            return response()->json([
                'success' => false,
                'message' => 'license is required',
                'data' => []
            ]);
        }
        if($token_data = SoftToken::where('token', $license)
            ->where('expired_at', '>', $now)
            ->where('soft_name', '=', $soft_name)
            ->get()){
            return response()->json([
                'success' => false,
                'message' => 'license is invalid',
                'data' => []
            ]);
        }
        try{
            if(! SoftTokenActive::where('soft_token_id', $token_data->id)
                ->where('website', '=', $website)
                ->get()){
                return response()->json([
                    'success' => false,
                    'message' => 'license is invalid',
                    'data' => []
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed to get soft token active',
                'data' => []
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => [
                'soft_name' => $soft_name,
                'active_at' => $now,
                'ip' => $request->ip(),
                'user_agent'=> $request->userAgent(),
            ]
            ]);
        
    }
}
