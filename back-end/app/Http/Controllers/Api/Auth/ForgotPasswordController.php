<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        //dd($response);
        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            "success" => true,
            "message" => "Successfully Send Password Reset To Your E-Mail, Please Check Your E-Mail!.",
            'response'=> $response
        ], 200);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json([
            "success" => false,
            "message" => "Faild To Send Password Reset Link!, Please Try Again Later",
            'response'=> $response
        ], 400);
    }

    public function broker()
    {
        return Password::broker();
    }

}
