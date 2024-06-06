<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            'dni' => 'required|size:8|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'celular' => 'required|max:15|unique:usuarios',
            'password' => 'required|min:6|confirmed',

        ], $messages);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 'cliente';
        $user = User::create($input);

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json(['token' => $token, 'token_type' => 'Bearer'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
