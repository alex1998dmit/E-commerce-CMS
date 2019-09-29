<?php

namespace App\Http\Controllers\API\V1;

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
            return response()->json('Пользователь не найден', 404);
        }
        if ($user->email_verified_at) {
            return response()->json('Пользователь уже был подтвержден', 400);
        }
        $user->email_verified_at = date('Y-m-d g:i:s');
        $user->verification_token = null;
        $user->save();

        return view('client');
//        return response()->json('Подтвреждение прошло успешно');
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
