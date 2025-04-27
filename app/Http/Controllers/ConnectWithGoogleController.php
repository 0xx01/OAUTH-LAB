<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ConnectWithGoogleController extends Controller
{
    # Redirect user to Google 
    public function redirectToGoogle()
    {
        config(['services.google.redirect' => "https://Your_domain/account/connect/google"]);
        return Socialite::driver('google')->with(['prompt' => 'consent', 'access_type' => 'offline'])->redirect();
    }

    # handle Google Callback 
    public function handleGoogleCallback(Request $request){
        # Don't check the `state` parmeter in the request --> CSRF Attack
        try{
            config(['services.google.redirect' => config('services.google.GOOGLE_Connect_REDIRECT_URI')]);
            $googleUser = Socialite::driver('google')->stateless()->user();
            $googleID = User::where('google_id',$googleUser->getId())->first();
            $user = Auth::user();
            if($googleID == null){
                $user->token = $googleUser->token;
                $user->google_id = $googleUser->getId();
                $user->google_refresh_token = $googleUser->refreshToken;
                $user->save();  
                return redirect()->route('dashboard')->with('success', 'Your Google account has been linked!');
            }else{
                return response()->json([
                    "status" => "#2100", 
                    "error"  => "Error, please try again",
                ]);
            }
        }catch (\Exception $e) {
            return dd($e);
        }
   
    }
}
