<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        // return response()->json(['message' => 'register']);
        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'size' => 'El campo :attribute debe tener exactamente :size caracteres.',
            'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
            'unique' => 'El campo :attribute ya está en uso.',
        ];

        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'dni' => 'required|size:8',
            'email' => 'required|email|unique:usuarios',
            'celular' => 'required|size:9',
            'password' => 'required'
        ], $messages);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'token_type' => 'Bearer'], 200);
    }
}
