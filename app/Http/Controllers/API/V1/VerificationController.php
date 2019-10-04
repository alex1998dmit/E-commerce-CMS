<?php

namespace App\Http\Controllers\API\V1;

use Redirect;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    //
    use VerifiesEmails;

    public function confirm(Request $request) {
        $username = $request['username'];
        $token = $request['token'];
        $user = User::where('email', 'like', '%' . $username . '%')->first();
        if (!$user) {
            return response()->json(['message' => 'User is not found'], 404);
        }
        if ($user->email_verified_at) {
            return response()->json(['message' => 'You are already verified'], 400);
        }
        $user->email_verified_at = date('Y-m-d g:i:s');
        $user->save();
        return Redirect::to(env('MIX_APP_URL'));
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json('The notification has been resubmitted');
    }

}
