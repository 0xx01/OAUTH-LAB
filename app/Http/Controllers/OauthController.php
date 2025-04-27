<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

class OauthController extends Controller
{
    # Redirect user to Google
    public function redirect(){

        return Socialite::driver('google')->redirect();
    }
    
    # Handler Callback to login with Google Account
    public function HenadlercCallback(Request $request){
        try {
            $googleUser = Socialite::driver('google')->with(['prompt' => 'consent', 'access_type' => 'offline'])->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user == null) {
                // Create a new user
                $user = User::create([
                    'name'                  => $googleUser->getName(),
                    'email'                 => $googleUser->getEmail(),
                    'password'              => bcrypt('google'),
                    'token'                 => $googleUser->token,
                    'google_id'             => $googleUser->getId(),
                    'google_refresh_token'  => $googleUser->refreshToken
                ]);
            }else{
                Auth::login($user);
                return redirect('/dashboard');
            }
        } catch (\Exception $e) {
            #return dd($e);
            return redirect('/login')->withErrors(['oauth' => 'Google login failed.']);
        }
    }
}
