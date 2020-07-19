<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use JWTAuth;
use JWTFactory;
use Response;
use Auth;

class UserApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth',['except' => ['login','register']]);
    }

    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Foundation\Auth\AuthenticatesUsers
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(UserLoginRequest $request)
    {

        // This Request come Frome User
        $credentials = $request->only('email', 'password');

        // Cheack User Token
        try {
            // Cheack the $credentials Wrong
            if (! $token = JWTAuth::attempt($credentials)) {
                // Return Arry Error With HTTP Protocol (401)
                return response()->json(['error' => 'Invalid Username and Password'], 401);
            }
          // Get Error Details
        } catch (JWTException $e) {
            // Return Arry Error With HTTP Protocol (500)
            return response()->json(['error' => 'Could not Create Token'], 500);
        }
        // When User Login Check If Has Verify E-Mail OR No
        $user = User::where('email', $request['email'])
                ->where('email_verified_at', '<>', NULL)
                ->first();
        // If Not Has Verify E-Mail
        // Verify E-Mail Before Login
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Email Is Not Verified!, You Need To Confirm Your Account First Before LoggedIn."
            ],400);
        }

        // when Login Validator Success Return Token
        // And E-Mail Verify
        // Make User Lgoni
        return $this->respondWithToken($token);

    }

    /**
    * Get a JWT Registeration New User.
    *
    * @return \Illuminate\Foundation\Auth\RegistersUsers
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function register(UserRegisterRequest $request)
    {
        // Add New User
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $user->attachRole('user');
        // Get The User Toke When Register
        $token = JWTAuth::fromUser($user);

         // When User Successeded Register Send E-Mail Verification
        $user->sendEmailVerificationNotification();

        // If Register Successeded Return User Ifon & Token & Return This Message
        return response()->json([
            compact('user','token'),
            "success" => true,
            "message" => "Registration Has Been Successfully, We Have Send You An Activation Link, Please Check Your E-Mail."
        ],201);
    }

    /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "success" => true,
            'message' => 'Successfully LoggedOut!'
        ],200);
    }

    /**
    * Refresh a token.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
    * Get the token array structure.
    *
    * @param  string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token)
    {
        return response()->json([
            // Token Info
            "message"       => "LoggedIn Is Successfully",
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * 60,
            'userId'        => auth()->user()->id
        ],200);
    }
}
