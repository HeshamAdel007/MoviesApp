<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\User;
use Auth;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request)
    {
        // This Request come Frome User
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $response = $this->broker()->reset(
            $credentials , function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json([
            "success" => true,
            'message' => 'Password Reset Successfully',
            'response'=> $response
        ], 201);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json([
            "success" => false,
            'message' => 'Failed Reset Password!, Please Try Again Later',
            'response'=> $response
        ], 400);

    }

    public function broker()
    {
        return Password::broker();
    }

}
