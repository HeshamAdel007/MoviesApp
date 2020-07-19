<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Validator;
use App\User;

class VerifyEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request) {

        // Find User
        $user = User::findOrFail($request->id);

        // Check If Hash Send With Verification == Hash Come From Route Link OR No
        if (! hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized"
            ],401);
        }

    // Check If User Verified OR No

        // If This User Has Verified E-Mail Return This Message
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                "success" => false,
                "message" => "User Already Verified E-Mail!, You Can LoggedIn Now."
            ],400);
        }

        // If User Not Verified Make This User Verify E-Mail
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // After Successeded Verified Return This Message
        return response()->json([
            "success" => true,
            "message" => "E-Mail Verified Successfully!, You Can LoggedIn Now."
        ],200);

    }

    public function resendVerifyEmail (Request $request) {

        $this->validate($request, ['email' => 'required|email']);

        // Find User E-Mail To Resend Verification
        $user = User::where('email', $request->email)->first();

        // If Not Found User E-Mail Return This Message
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Failed Send Verify Notification, We Can't Find A User With That E-Mail!."
            ],400);
        }

        // If Find User E-Mail Send Verification To This User IN E-Mail
        $user->sendEmailVerificationNotification();

        // After Successeded Resend Verification Return This Message
        return response()->json([
            "success" => true,
            "message" => "Successfully Send Verify Notification To Your E-Mail!, Please Check Your E-Mail!."
        ],200);
    }
}
