<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Valida informação.
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'name' => 'required|string|max:255',
        ]);

        // Cria um novo usuario
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Hash the password
        $user->name = $request->name;
        $user->save();

        // gera o jwt
        $token = JWTAuth::fromUser($user);

        // salva em um cookie
        $cookie = Cookie::make('token', $token, config('jwt.ttl'));

        // volta a view com o cookie
        return Redirect::to('/')->withCookie($cookie);
    }
}
