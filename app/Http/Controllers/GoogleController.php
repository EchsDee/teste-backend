<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redirect;

class GoogleController extends Controller
{
    /**
     * Redireciona o usuário para a página de autenticação do Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtém as informações do usuário do Google e registra o usuário.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        
        // checa se o usuario ja existe na base
        $existingUser = User::where('email', $googleUser->email)->first();
    
        if ($existingUser) {
            // se o usuario ja existe gera o jwt 
            $token = JWTAuth::fromUser($existingUser);
        } else {
            // se nao existe cria-se um novo usuario
            $newUser = new User();
            $newUser->name = $googleUser->name;
            $newUser->email = $googleUser->email;
            $newUser->password = bcrypt(Str::random(16)); // gera uma senha hashada para o usuario novo.
            $newUser->save();
    
            // gera o jwt para o usuario novo
            $token = JWTAuth::fromUser($newUser);
        }
    
        // coloca o jwt em um cookie.
        $cookie = cookie('token', $token, config('jwt.ttl'));
    
        // volta a view com o cookie
        return Redirect::to('/')->withCookie($cookie);
    }
}