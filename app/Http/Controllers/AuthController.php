<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    
        // salva o jwt em um cookie
        $cookie = cookie('token', $token, config('jwt.ttl'));
    
        // volta para a tela inicial com o cookie.
        return Redirect::to('/')->withCookie($cookie);
    }
    public function showLoginForm()
    {
        return view('login-form');
    }
    
    /**
     * desconecta o usuario e mata o token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Invalida o token JWT do usuário atual
        JWTAuth::invalidate(JWTAuth::getToken());
    
        // Redireciona o usuário de volta para a página de login
        return redirect()->route('login-form');
    }
    /**
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::refresh();

        return response()->json(compact('token'));
    }
}
