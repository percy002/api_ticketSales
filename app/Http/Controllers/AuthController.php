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
            'max' => 'El campo :attribute no debe tener más de :max caracteres.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'confirmed' => 'El campo :attribute no coincide con la confirmación.'
        ];

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|max:100',
            'apellido_paterno' => 'required|max:100',
            'apellido_materno' => 'required|max:100',
            'dni' => 'required|size:8',
            'email' => 'required|email|unique:usuarios',
            'celular' => 'required|max:15',
            'password' => 'required|min:6|confirmed',

        ], $messages);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'token_type' => 'Bearer'], 200);
    }

    public function login(Request $request){
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json(['errors' => ['Las credenciales proporcionadas son incorrectas']], 401);
        }        

        $user = Auth::user();
        return response()->json(['errors' => [Auth::user()]], 401);
        if (!$user) {
            return response()->json(['errors' => ['No se pudo autenticar al usuario']], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'token_type' => 'Bearer'], 200);
    }
}
