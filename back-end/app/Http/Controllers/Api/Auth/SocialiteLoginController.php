<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\SocialiteLogin;
use App\User;
use Socialite;
use JWTAuth;

class SocialiteLoginController extends Controller
{
    /**
     * Redirect the user to the Facebook Authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        //return Socialite::driver($provider)->stateless()->redirect();

        // Nuxt.Js Url Setting
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            "url" => $url
        ],200);
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        try {

            $user = Socialite::driver($provider)->stateless()->user();

            if (!$user->token) {
                // Return Json
                return response()->json([
                    "success" => false,
                    "message" => "Failed to login"
                ],404);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "This User Already Login, Please Try Again Later"
            ],500);
        }

        $appUser = User::whereEmail($user->email)->first();

        //dd($user, $appUser);

        if (!$appUser) {
            // create user and add the provider
            $appUser = User::create([
                'name'      => $user->name,
                'email'     => $user->email,
                'password'  => Hash::make(Str::random(10)),
            ]);

            $socialAccount = SocialiteLogin::create([
                'provider'          => $provider, // App Name Like [Facebook, Twitter]
                'user_id'           => $appUser->id, // User ID IN MY App
                'provider_user_id'  => $user->id, // User ID IN Facebook OR Other App
            ]);

        } else {
            // means that we have already this user
            $socialAccount = $appUser->socialLogin()->where('provider', $provider)->first();

            if (!$socialAccount) {
                // create social account
                $socialAccount = SocialiteLogin::create([
                    'provider'          => $provider, // App Name Like [Facebook, Twitter]
                    'user_id'           => $appUser->id, // User ID IN MY App
                    'provider_user_id'  => $user->id, // User ID IN Facebook OR Other App
                ]);
            }

        }

        // Create User Token
        $token = JWTAuth::fromUser($appUser);

        return response()->json([
            "message"       => "Login Has Been Successfully",
            "access_token"  => $token,
        ],200);

    }
}
