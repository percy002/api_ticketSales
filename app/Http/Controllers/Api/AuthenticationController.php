<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    //
    public function store(){
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // successfull authentication
            // return response()->json([
            //     'message' => Auth::user(),
            // ], 401);
            $user = User::find(Auth::user()->usuario_id);

            $user_token = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }
    public function destroy()
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        }
    }
}
