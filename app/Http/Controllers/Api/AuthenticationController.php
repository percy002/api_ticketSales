<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class AuthenticationController extends Controller
{
    //
    public function store(Request $request){
        $messages = [
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'password.required' => 'El campo password es obligatorio.'
        ];

        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], $messages);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
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
                'errors' => ['Las credenciales proporcionadas son incorrectas'],
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
