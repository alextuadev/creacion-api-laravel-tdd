<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['message' => 'User register successfully'], 201);
    }

    public function login(Request $request)
    {
        $credentials = request()->only(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json(['message'=>'Unauthorized'], 401);
        $user = $request->user();
        $token = $user->createToken('Personal Access Token');

        return response()->json([
           'access_token'=> $token->accessToken,
           'user_id' => $user->id
        ]);
    }

}
