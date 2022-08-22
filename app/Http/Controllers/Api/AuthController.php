<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        // Check Validation Errors
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'Error', 'Message' => 'The provided credentials are incorrect.', 'code' => 401], 401);
        }
    
        return response()->json(['status' => 'Success', 'token' => $user->createToken($request->device_name)->plainTextToken, 'code' => 200], 200);
    }
}
