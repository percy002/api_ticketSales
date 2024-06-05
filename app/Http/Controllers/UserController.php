<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getUser(){
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'user' => $user,
        ], 200);
    }
}
